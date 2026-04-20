<?php
// admin.php - simple admin dashboard for approving pending events
require_once __DIR__ . '/auth.php';

// require admin role
if (!is_logged_in() || (current_user()['role'] ?? '') !== 'admin') {
    header('HTTP/1.1 403 Forbidden');
    echo 'Forbidden';
    exit;
}
