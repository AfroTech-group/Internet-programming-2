<?php
// events.php - render events list from database and allow simple viewing
require_once __DIR__ . '/auth.php';
// Handle search and filtering
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category = $_GET['category'] ?? '';
$event_type = $_GET['event_type'] ?? '';

// Debug: Log received parameters
error_log('Search params - search: "' . $search . '", category: "' . $category . '", event_type: "' . $event_type . '"');

// Build WHERE clause
$whereConditions = ["status = 'active'"];
$params = [];

if ($search) {
    $whereConditions[] = "(title LIKE :search OR description LIKE :search OR location LIKE :search)";
    $params[':search'] = '%' . $search . '%';
}

if ($category) {
    $whereConditions[] = "category = :category";
    $params[':category'] = $category;
}

if ($event_type) {
    $whereConditions[] = "event_type = :event_type";
    $params[':event_type'] = $event_type;
}
$whereClause = implode(' AND ', $whereConditions);
// Query events with filters
try {
	$user = current_user();
	$isAdmin = $user && ($user['role'] ?? '') === 'admin';
	
	if ($isAdmin) {
		// Admins can see all events
		$whereClause = str_replace("status = 'active'", "1=1", $whereClause);
		$sql = "SELECT id, title, category, description, start_at, event_image, location, ticket_price, tickets_sold, ticket_quantity, status, event_type FROM events WHERE $whereClause ORDER BY start_at ASC";
	} else {
		$sql = "SELECT id, title, category, description, start_at, event_image, location, ticket_price, tickets_sold, ticket_quantity, status, event_type FROM events WHERE $whereClause ORDER BY start_at ASC";
	}
	
	$stmt = $pdo->prepare($sql);
	
	// Debug: Log the SQL and params for troubleshooting
	error_log('Events SQL: ' . $sql);
	error_log('Events Params: ' . json_encode($params));
	
	// Only execute with params if there are parameters
	if (!empty($params)) {
		$stmt->execute($params);
	} else {
		$stmt->execute();
	}
	$events = $stmt->fetchAll();
	
	// Debug: Log results count
	error_log('Search results count: ' . count($events));
	
	// Debug: Check if there are any active events at all
	$stmt = $pdo->query("SELECT COUNT(*) as count FROM events WHERE status = 'active'");
	$activeCount = $stmt->fetch()['count'];
	error_log('Total active events in database: ' . $activeCount);
	
	// Get available categories for filter dropdown
	$stmt = $pdo->query("SELECT DISTINCT category FROM events WHERE status = 'active' ORDER BY category");
	$categories = $stmt->fetchAll(PDO::FETCH_COLUMN);
	
	// Get available event types
	$stmt = $pdo->query("SELECT DISTINCT event_type FROM events WHERE status = 'active' AND event_type IS NOT NULL ORDER BY event_type");
	$eventTypes = $stmt->fetchAll(PDO::FETCH_COLUMN);
	
} catch (Exception $e) {
	error_log('events.php: ' . $e->getMessage());
	$events = [];
	$categories = [];
	$eventTypes = [];
}

?><!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Events - AfroEvents</title>
	<link rel="stylesheet" href="/afro/theme.css">
	<link rel="stylesheet" href="/afro/style.css">
	<link rel="stylesheet" href="/afro/events.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<?php require_once __DIR__ . '/includes/header.php'; ?>

<main class="container">
	<h1>Events</h1>
	
	<!-- Search and Filter Form -->
	<div class="search-filter-section" style="background:#f8f9fa;padding:20px;border-radius:8px;margin-bottom:30px;">
		<form method="get" action="/afro/events.php" style="display:flex;gap:15px;flex-wrap:wrap;align-items:end;">
			<div style="flex:1;min-width:200px;">
				<label for="search" style="display:block;margin-bottom:5px;font-weight:600;">Search Events</label>
				<input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search); ?>" 
					   placeholder="Search by title, description, or location..." 
					   style="width:100%;padding:10px;border:1px solid #ddd;border-radius:4px;">
			</div>
			
			<div style="min-width:150px;">
				<label for="category" style="display:block;margin-bottom:5px;font-weight:600;">Category</label>
				<select id="category" name="category" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:4px;">
					<option value="">All Categories</option>
					<?php foreach ($categories as $cat): ?>
						<option value="<?php echo htmlspecialchars($cat); ?>" <?php echo $category === $cat ? 'selected' : ''; ?>>
							<?php echo htmlspecialchars($cat); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			
			<div style="min-width:150px;">
				<label for="event_type" style="display:block;margin-bottom:5px;font-weight:600;">Event Type</label>
				<select id="event_type" name="event_type" style="width:100%;padding:10px;border:1px solid #ddd;border-radius:4px;">
					<option value="">All Types</option>
					<?php foreach ($eventTypes as $type): ?>
						<option value="<?php echo htmlspecialchars($type); ?>" <?php echo $event_type === $type ? 'selected' : ''; ?>>
							<?php echo htmlspecialchars($type); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			
			<div>
				<button type="submit" class="btn btn-primary" style="padding:10px 20px;">
					<i class="fas fa-search"></i> Search
				</button>
			</div>
			
			<div>
				<a href="/afro/events.php" class="btn" style="padding:10px 20px;background:#6c757d;color:white;">
					<i class="fas fa-times"></i> Clear
				</a>
			</div>
		</form>
	</div>
	
	<div class="events-grid">
		<?php if (empty($events)): ?>
			<p>No events found.</p>
		<?php else: ?>
			<?php foreach ($events as $ev):
				$img = htmlspecialchars($ev['event_image'] ?: 'images.jpg');
				$title = htmlspecialchars($ev['title']);
				$date = htmlspecialchars(date('F j, Y | g:i A', strtotime($ev['start_at'] ?? 'now')));
				$location = htmlspecialchars($ev['location'] ?? '');
				$price = $ev['ticket_price'] ? 'ETB ' . number_format($ev['ticket_price'], 2) : 'Free';
				$short = htmlspecialchars(mb_substr($ev['description'] ?? '', 0, 200));
				$tickets = is_null($ev['ticket_quantity']) ? 'Unlimited' : max(0, $ev['ticket_quantity'] - $ev['tickets_sold']);
			?>
				<article id="event-<?php echo $ev['id']; ?>" class="event-card">
					<div class="event-image"><img src="<?php echo $img; ?>" alt="<?php echo $title; ?>"></div>
					<div class="event-info">
						<h3><a href="/afro/event_detail.php?id=<?php echo $ev['id']; ?>" style="color:inherit;text-decoration:none;"><?php echo $title; ?></a></h3>
						<p class="meta"><?php echo $date; ?> · <?php echo $location; ?></p>
						<p class="desc"><?php echo $short; ?></p>
						<p class="price"><?php echo $price; ?></p>
						<p class="tickets"><i class="fas fa-ticket-alt"></i> <?php echo $tickets; ?> tickets left</p>
						<?php if ($isAdmin): ?>
							<p class="status">Status: <?php echo htmlspecialchars($ev['status']); ?></p>
						<?php endif; ?>
						<div class="event-actions" style="margin-top:15px;">
							<a href="/afro/event_detail.php?id=<?php echo $ev['id']; ?>" class="btn btn-primary">View Details</a>
							<a href="/afro/event_detail.php?id=<?php echo $ev['id']; ?>#booking" class="btn btn-success">Get Ticket</a>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</main>
<script src="common.js"></script>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
