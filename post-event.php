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

         if (empty($title)) $errors[] = 'Event title is required';
        if (empty($category)) $errors[] = 'Category is required';
        if (empty($description)) $errors[] = 'Description is required';
        if (strlen($description) < 150) $errors[] = 'Description must be at least 150 characters';
        if (empty($event_date)) $errors[] = 'Event date is required';
        if (empty($event_time)) $errors[] = 'Event time is required';
        if (empty($location)) $errors[] = 'Event location is required';
        if (empty($organizer_name)) $errors[] = 'Organizer name is required';
        if (empty($organizer_email)) $errors[] = 'Contact email is required';
        if (!filter_var($organizer_email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required';
        
        // Validate ticket quantity
        $ticket_type = $_POST['ticket_type'] ?? 'free';
        if ($ticket_type === 'paid') {
            $ticket_price = floatval($_POST['ticket_price'] ?? 0);
            $ticket_quantity = intval($_POST['ticket_quantity_form'] ?? 0);
            if ($ticket_price <= 0) $errors[] = 'Valid ticket price is required';
            if ($ticket_quantity < 1 || $ticket_quantity > 10000) $errors[] = 'Ticket quantity must be between 1 and 10000';
        } else {
            $ticket_quantity = intval($_POST['free_ticket_quantity'] ?? 200);
            $ticket_price = null;
        }
        
        // Handle image upload (if present)
        $image_path = null;
        if (isset($_FILES['event_image']) && $_FILES['event_image']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['event_image'];
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($file['tmp_name']);
 $allowed = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/gif' => 'gif'
            ];

            if (!isset($allowed[$mime])) {
                $errors[] = 'Only JPG, PNG, and GIF images are allowed';
            }

            if ($file['size'] > 5 * 1024 * 1024) {
                $errors[] = 'Image must be less than 5MB';
            }

            if (empty($errors)) {
                $ext = $allowed[$mime];
                $filename = bin2hex(random_bytes(16)) . '_' . time() . '.' . $ext;
                $target = $upload_dir . $filename;
                if (!move_uploaded_file($file['tmp_name'], $target)) {
                    $errors[] = 'Failed to save uploaded image';
                } else {
                    // store path relative to web root if possible
                    $image_path = 'uploads/events/' . $filename;
                }
            }
        }
        
        // If errors, show them
        if (!empty($errors)) {
            echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
            exit;
        }
