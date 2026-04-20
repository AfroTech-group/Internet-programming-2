<?php
// admin_action.php - handle approve/reject actions for events
require_once __DIR__ . '/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method not allowed';
    exit;
}

if (!is_logged_in() || (current_user()['role'] ?? '') !== 'admin') {
    http_response_code(403);
    echo 'Forbidden';
    exit;
}

$eventId = isset($_POST['event_id']) ? intval($_POST['event_id']) : 0;
$action = $_POST['action'] ?? '';

if ($eventId <= 0 || !in_array($action, ['approve','reject'])) {
    http_response_code(400);
    echo 'Bad request';
    exit;
}

try {
    if ($action === 'approve') {
        $stmt = $pdo->prepare('UPDATE events SET status = :s WHERE id = :id');
        $stmt->execute([':s' => 'active', ':id' => $eventId]);
    } else {
        $stmt = $pdo->prepare('UPDATE events SET status = :s WHERE id = :id');
        $stmt->execute([':s' => 'rejected', ':id' => $eventId]);
    }
    header('Location: /afro/admin.php');
    exit;
} catch (Exception $e) {
    error_log('admin_action.php: ' . $e->getMessage());
    http_response_code(500);
    echo 'Server error';
}
