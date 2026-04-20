<?php
// admin.php - simple admin dashboard for approving pending events
require_once __DIR__ . '/auth.php';

// require admin role
if (!is_logged_in() || (current_user()['role'] ?? '') !== 'admin') {
    header('HTTP/1.1 403 Forbidden');
    echo 'Forbidden';
    exit;
}

try{
    $stmt= $pdo->prepare("SELECT id, user_id, title, category, start_at, location, event_image, created_at FROM events WHERE status = 'pending' ORDER BY created_at ASC");
    $stmt->execute();
    $pending = $stmt->fetchAll();
}   catch (Exception $e) {
    error_log('admin.php: ' . $e->getMessage());
    $pending = [];
}   

?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin - Pending Events</title>
    <link rel="stylesheet" href="/afro/theme.css">
    <style>main{max-width:1100px;margin:32px auto;padding:0 16px}.card{border:1px solid #eee;padding:12px;border-radius:8px;margin-bottom:12px;display:flex;gap:12px}.card img{width:150px;height:100px;object-fit:cover;border-radius:6px}.actions form{display:inline-block;margin-right:6px}</style>
</head>
<body>


