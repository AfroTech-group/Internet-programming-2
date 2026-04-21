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
