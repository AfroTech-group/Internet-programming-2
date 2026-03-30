<?php
// post-event.php - Simple event submission handler with CSRF and basic protections

session_start();

// Database configuration
$db_host = 'localhost';
$db_name = 'afroevents_db';
$db_user = 'root';
$db_pass = '';

// Create upload directory if it doesn't exist
$upload_dir = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'events' . DIRECTORY_SEPARATOR;
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Initialize response
$response = ['success' => false, 'message' => ''];

// Provide a CSRF token endpoint for the frontend to request
if (isset($_GET['action']) && $_GET['action'] === 'token') {
    // generate token
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    header('Content-Type: application/json');
    echo json_encode(['token' => $_SESSION['csrf_token']]);
    exit;
}
