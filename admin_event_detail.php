<?php
// admin_event_detail.php - detailed view of a single event for admin approval/rejection
require_once __DIR__ . '/auth.php';

if (!is_logged_in() || (current_user()['role'] ?? '') !== 'admin') {
    header('HTTP/1.1 403 Forbidden');
    echo 'Forbidden';
    exit;
}

$eventId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($eventId <= 0) {
    header('Location: /afro/admin.php');
    exit;
}

try {
    $stmt = $pdo->prepare("
        SELECT e.*, u.username, u.email as creator_email, u.full_name as creator_name 
        FROM events e 
        LEFT JOIN users u ON e.user_id = u.id 
        WHERE e.id = :id
    ");
    $stmt->execute([':id' => $eventId]);
    $event = $stmt->fetch();
    
    if (!$event) {
        header('Location: /afro/admin.php');
        exit;
    }
} catch (Exception $e) {
    error_log('admin_event_detail.php: ' . $e->getMessage());
    $event = null;
}

?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin - Event Details: <?php echo htmlspecialchars($event['title'] ?? 'Unknown'); ?></title>
    <link rel="stylesheet" href="/afro/theme.css">
    <style>
        main{max-width:900px;margin:32px auto;padding:0 16px}
        .event-header{display:flex;gap:20px;margin-bottom:30px}
        .event-image{flex:0 0 300px}
        .event-image img{width:100%;height:200px;object-fit:cover;border-radius:8px}
        .event-info{flex:1}
        .detail-section{margin-bottom:25px}
        .detail-section h3{margin-bottom:10px;color:#333;border-bottom:2px solid #eee;padding-bottom:5px}
        .detail-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:15px}
        .detail-item{padding:10px;background:#f8f9fa;border-radius:6px}
        .detail-label{font-weight:600;color:#666;margin-bottom:3px}
        .detail-value{color:#333}
        .description{background:#f8f9fa;padding:15px;border-radius:8px;line-height:1.6}
        .actions{margin-top:30px;padding:20px;background:#fff;border:1px solid #ddd;border-radius:8px}
        .actions form{display:inline-block;margin-right:10px}
        .status-badge{display:inline-block;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;text-transform:uppercase}
        .status-pending{background:#fff3cd;color:#856404}
        .status-active{background:#d4edda;color:#155724}
        .status-rejected{background:#f8d7da;color:#721c24}
        .back-link{margin-bottom:20px;display:inline-block}
    </style>
</head>
<body>
<?php require_once __DIR__ . '/includes/header.php'; ?>
<main>
    <div class="back-link">
        <a href="/afro/admin.php" class="btn">« Back to Pending Events</a>
    </div>

    <?php if ($event): ?>
        <div class="event-header">
            <div class="event-image">
                <img src="<?php echo htmlspecialchars($event['event_image'] ?: 'images.jpg'); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>">
            </div>
            <div class="event-info">
                <h1><?php echo htmlspecialchars($event['title']); ?></h1>
                <div class="status-badge status-<?php echo htmlspecialchars($event['status']); ?>">
                    <?php echo htmlspecialchars($event['status']); ?>
                </div>
                <p style="margin-top:10px;color:#666;">
                    Submitted on <?php echo htmlspecialchars($event['created_at']); ?>
                </p>
            </div>
        </div>

        <div class="detail-section">
            <h3>Event Description</h3>
            <div class="description">
                <?php echo nl2br(htmlspecialchars($event['description'])); ?>
            </div>
        </div>

    <div class="detail-section">
            <h3>Event Details</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Category</div>
                    <div class="detail-value"><?php echo htmlspecialchars($event['category']); ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Date & Time</div>
                    <div class="detail-value"><?php echo htmlspecialchars($event['start_at']); ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Location</div>
                    <div class="detail-value"><?php echo htmlspecialchars($event['location']); ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Event Type</div>
                    <div class="detail-value"><?php echo htmlspecialchars($event['event_type'] ?: 'In-person'); ?></div>
                </div>
                <?php if ($event['duration']): ?>
                <div class="detail-item">
                    <div class="detail-label">Duration</div>
                    <div class="detail-value"><?php echo htmlspecialchars($event['duration']); ?></div>
                </div>
                <?php endif; ?>
                <?php if ($event['full_address']): ?>
                <div class="detail-item">
                    <div class="detail-label">Full Address</div>
                    <div class="detail-value"><?php echo nl2br(htmlspecialchars($event['full_address'])); ?></div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($event['tags']): ?>
        <div class="detail-section">
            <h3>Tags</h3>
            <div class="detail-value"><?php echo htmlspecialchars($event['tags']); ?></div>
        </div>
        <?php endif; ?>

        <div class="detail-section">
            <h3>Ticket Information</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Ticket Type</div>
                    <div class="detail-value"><?php echo htmlspecialchars($event['ticket_type'] ?: 'Free'); ?></div>
                </div>
                <?php if ($event['ticket_price']): ?>
                <div class="detail-item">
                    <div class="detail-label">Price</div>
                    <div class="detail-value">$<?php echo number_format($event['ticket_price'], 2); ?></div>
                </div>
                <?php endif; ?>
                <?php if ($event['ticket_quantity']): ?>
                <div class="detail-item">
                    <div class="detail-label">Available Tickets</div>
                    <div class="detail-value"><?php echo (int)$event['ticket_quantity']; ?></div>
                </div>
                <?php endif; ?>
                <?php if ($event['early_bird_enabled']): ?>
                <div class="detail-item">
                    <div class="detail-label">Early Bird Price</div>
                    <div class="detail-value">$<?php echo number_format($event['early_bird_price'], 2); ?></div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="detail-section">
            <h3>Organizer Information</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Organizer Name</div>
                    <div class="detail-value"><?php echo htmlspecialchars($event['organizer_name'] ?: $event['creator_name'] ?: 'Not specified'); ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Organizer Email</div>
                    <div class="detail-value"><?php echo htmlspecialchars($event['organizer_email'] ?: $event['creator_email'] ?: 'Not specified'); ?></div>
                </div>
                <?php if ($event['organizer_phone']): ?>
                <div class="detail-item">
                    <div class="detail-label">Organizer Phone</div>
                    <div class="detail-value"><?php echo htmlspecialchars($event['organizer_phone']); ?></div>
                </div>
                <?php endif; ?>
                <?php if ($event['website']): ?>
                <div class="detail-item">
                    <div class="detail-label">Website</div>
                    <div class="detail-value"><a href="<?php echo htmlspecialchars($event['website']); ?>" target="_blank"><?php echo htmlspecialchars($event['website']); ?></a></div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($event['facebook_url'] || $event['instagram_url'] || $event['twitter_url']): ?>
        <div class="detail-section">
            <h3>Social Media</h3>
            <div class="detail-grid">
                <?php if ($event['facebook_url']): ?>
                <div class="detail-item">
                    <div class="detail-label">Facebook</div>
                    <div class="detail-value"><a href="<?php echo htmlspecialchars($event['facebook_url']); ?>" target="_blank">View Page</a></div>
                </div>
                <?php endif; ?>
                <?php if ($event['instagram_url']): ?>
                <div class="detail-item">
                    <div class="detail-label">Instagram</div>
                    <div class="detail-value"><a href="<?php echo htmlspecialchars($event['instagram_url']); ?>" target="_blank">View Profile</a></div>
                </div>
                <?php endif; ?>
                <?php if ($event['twitter_url']): ?>
                <div class="detail-item">
                    <div class="detail-label">Twitter</div>
                    <div class="detail-value"><a href="<?php echo htmlspecialchars($event['twitter_url']); ?>" target="_blank">View Profile</a></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($event['status'] === 'pending'): ?>
        <div class="actions">
            <h3>Admin Actions</h3>
            <form method="post" action="/afro/admin_action.php">
                <input type="hidden" name="event_id" value="<?php echo (int)$event['id']; ?>">
                <input type="hidden" name="action" value="approve">
                <button class="btn" style="background:#28a745;color:white">Approve Event</button>
            </form>
            <form method="post" action="/afro/admin_action.php">
                <input type="hidden" name="event_id" value="<?php echo (int)$event['id']; ?>">
                <input type="hidden" name="action" value="reject">
                <button class="btn" style="background:#dc3545;color:white">Reject Event</button>
            </form>
        </div>
        <?php else: ?>
        <div class="actions">
            <p style="color:#666;">This event has already been <?php echo htmlspecialchars($event['status']); ?>.</p>
            <a href="/afro/admin.php" class="btn">Back to Admin Panel</a>
        </div>
        <?php endif; ?>

    <?php else: ?>
        <p>Event not found.</p>
        <a href="/afro/admin.php" class="btn">Back to Admin Panel</a>
    <?php endif; ?>
</main>
</body>
</html>
