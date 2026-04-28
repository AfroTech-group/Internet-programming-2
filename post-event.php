<?php
require_once __DIR__ . '/auth.php';

$upload_dir = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'events' . DIRECTORY_SEPARATOR;
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// CSRF token endpoint (keeps legacy support)
if (isset($_GET['action']) && $_GET['action'] === 'token') {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    header('Content-Type: application/json');
    echo json_encode(['token' => $_SESSION['csrf_token']]);
    exit;
}

// If GET, serve the static form (post-event.html) but update navigation links to PHP and include a small header showing login state
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $tpl = __DIR__ . '/post-event.html';
    if (!file_exists($tpl)) {
        echo 'Template not found';
        exit;
    }
    $html = file_get_contents($tpl);
    $map = [
        'index.html' => 'index.php',
        'events.html' => 'events.php',
        'post-event.html' => 'post-event.php',
        'features.html' => 'features.php',
        'support.html' => 'support.php',
        'contact.html' => 'contact.php'
    ];

// Update links from .html to .php
    $html = str_replace(array_keys($map), array_values($map), $html);

    // Ensure theme.css is present (other PHP wrappers add this when missing)
    if (strpos($html, 'theme.css') === false) {
        $html = str_replace('</head>', '<link rel="stylesheet" href="/afro/theme.css"></head>', $html);
    }

    // Capture header/footer rendered by includes so we can inject them like other pages
    ob_start();
    include __DIR__ . '/includes/header.php';
    $header_html = ob_get_clean();

    ob_start();
    include __DIR__ . '/includes/footer.php';
    $footer_html = ob_get_clean();

    $html = preg_replace('/(<body[^>]*>)/i', "$1\n" . $header_html, $html, 1);

    $html = preg_replace('/<nav class="navbar"[^>]*>.*?<\/nav>/s', '', $html);

    $html = preg_replace('/<footer class="footer"[^>]*>.*?<\/footer>/s', $footer_html, $html);
    if (strpos($html, $footer_html) === false) {
        $html = str_replace('</body>', $footer_html . '</body>', $html);
    }
    if (!is_logged_in()) {
        $notice = '<div style="background:#fff3cd;padding:12px;border:1px solid #ffeeba;margin:12px;border-radius:4px;max-width:1000px;margin-left:auto;margin-right:auto;">You are viewing the event submission form. You must <a href="/afro/login.php">log in</a> to submit an event.</div>';
       
        $html = preg_replace('/(<body[^>]*>)/i', "\\1\n" . $notice, $html, 1);
    }

    
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
            if (empty($errors)) {
                $ext = $allowed[$mime];
                $filename = bin2hex(random_bytes(16)) . '_' . time() . '.' . $ext;
                $target = $upload_dir . $filename;
                if (!move_uploaded_file($file['tmp_name'], $target)) {
                    $errors[] = 'Failed to save uploaded image';
                } else {
                    $image_path = 'uploads/events/' . $filename;
                }
            }
        }
        
        if (!empty($errors)) {
            echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
            exit;
        }
$sql = "INSERT INTO events (
            title, category, description, tags, event_date, event_time,
            location, full_address, event_type, duration, ticket_type,
            ticket_price, ticket_quantity, early_bird_enabled, early_bird_price,
            early_bird_deadline, organizer_name, organizer_email, organizer_phone,
            website, facebook_url, instagram_url, twitter_url, event_image, status
        ) VALUES (
            :title, :category, :description, :tags, :event_date, :event_time,
            :location, :full_address, :event_type, :duration, :ticket_type,
            :ticket_price, :ticket_quantity, :early_bird_enabled, :early_bird_price,
            :early_bird_deadline, :organizer_name, :organizer_email, :organizer_phone,
            :website, :facebook_url, :instagram_url, :twitter_url, :event_image, 'pending'
        )";
        
        $stmt = $pdo->prepare($sql);
    
        $tags = trim($_POST['event_tags'] ?? '');
        $full_address = trim($_POST['event_address'] ?? '');
        $event_type = $_POST['event_type'] ?? 'in-person';
        $duration = $_POST['event_duration'] ?? '';
        $organizer_phone = trim($_POST['organizer_phone'] ?? '');
        $website = trim($_POST['website'] ?? '');
        $facebook = trim($_POST['facebook_url'] ?? '');
        $instagram = trim($_POST['instagram_url'] ?? '');
        $twitter = trim($_POST['twitter_url'] ?? '');
        
        $early_bird_enabled = isset($_POST['early_bird_check']) ? 1 : 0;
        $early_bird_price = $early_bird_enabled ? floatval($_POST['early_price'] ?? 0) : null;
        $early_bird_deadline = $early_bird_enabled ? ($_POST['early_deadline'] ?? null) : null;
        
        // Execute
        $stmt->execute([
            ':title' => $title,
            ':category' => $category,
            ':description' => $description,
            ':tags' => $tags,
            ':event_date' => $event_date,
            ':event_time' => $event_time,
            ':location' => $location,
            ':full_address' => $full_address,
            ':event_type' => $event_type,
            ':duration' => $duration,
            ':ticket_type' => $ticket_type,
            ':ticket_price' => $ticket_price,
            ':ticket_quantity' => $ticket_quantity,
            ':early_bird_enabled' => $early_bird_enabled,
            ':early_bird_price' => $early_bird_price,
            ':early_bird_deadline' => $early_bird_deadline,
            ':organizer_name' => $organizer_name,
            ':organizer_email' => $organizer_email,
            ':organizer_phone' => $organizer_phone,
            ':website' => $website,
            ':facebook_url' => $facebook,
            ':instagram_url' => $instagram,
            ':twitter_url' => $twitter,
            ':event_image' => $image_path
        ]);
        
        // Success response
        echo json_encode(['success' => true, 'message' => 'Event submitted successfully!']);
        
    } catch (PDOException $e) {
        // Log detailed error server-side, but return a generic message to client
        error_log('post-event.php PDOException: ' . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Server error while saving event']);
    }
} else {
    // Not a POST request
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
