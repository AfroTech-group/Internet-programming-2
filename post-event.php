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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Connect to database
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Basic JSON response wrapper
        header('Content-Type: application/json');

        // Verify CSRF token
        $posted_token = $_POST['csrf_token'] ?? '';
        if (empty($posted_token) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $posted_token)) {
            echo json_encode(['success' => false, 'message' => 'Invalid session or invalid CSRF token']);
            exit;
        }

        // Validate required fields
        $errors = [];
        
        $title = trim($_POST['event_title'] ?? '');
        $category = trim($_POST['event_category'] ?? '');
        $description = trim($_POST['event_description'] ?? '');
        $event_date = $_POST['event_date'] ?? '';
        $event_time = $_POST['event_time'] ?? '';
        $location = trim($_POST['event_location'] ?? '');
        $organizer_name = trim($_POST['organizer_name'] ?? '');
        $organizer_email = trim($_POST['organizer_email'] ?? '');

        
