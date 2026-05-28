<?php
// app/controllers/PostEventController.php

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../models/Event.php';

class PostEventController
{
    private string $uploadDir;

    public function __construct()
    {
        $this->uploadDir = dirname(__DIR__, 2) . '/uploads/events/';
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    /** GET - render the post-event form */
    public function create(): void
    {
        include __DIR__ . '/../views/post-event/create.php';
    }

    /** GET ?action=token - return CSRF token as JSON */
    public function token(): void
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        header('Content-Type: application/json');
        echo json_encode(['token' => $_SESSION['csrf_token']]);
        exit;
    }

    /** POST - handle event submission */
    public function store(): void
    {
        header('Content-Type: application/json');

        if (!is_logged_in()) {
            echo json_encode(['success' => false, 'message' => 'Authentication required']);
            exit;
        }

        // CSRF check
        $posted_token = $_POST['csrf_token'] ?? '';
        if (
            empty($posted_token) ||
            empty($_SESSION['csrf_token']) ||
            !hash_equals($_SESSION['csrf_token'], $posted_token)
        ) {
            echo json_encode(['success' => false, 'message' => 'Invalid session or CSRF token']);
            exit;
        }

        $errors = [];

        $title           = trim($_POST['event_title'] ?? '');
        $category        = trim($_POST['event_category'] ?? '');
        $description     = trim($_POST['event_description'] ?? '');
        $event_date      = $_POST['event_date'] ?? '';
        $event_time      = $_POST['event_time'] ?? '';
        $location        = trim($_POST['event_location'] ?? '');
        $organizer_name  = trim($_POST['organizer_name'] ?? '');
        $organizer_email = trim($_POST['organizer_email'] ?? '');

        if (empty($title))                                                    $errors[] = 'Event title is required';
        if (empty($category))                                                 $errors[] = 'Category is required';
        if (empty($description) || strlen($description) < 150)               $errors[] = 'Description must be at least 150 characters';
        if (empty($event_date))                                               $errors[] = 'Event date is required';
        if (empty($event_time))                                               $errors[] = 'Event time is required';
        if (empty($location))                                                 $errors[] = 'Event location is required';
        if (empty($organizer_name))                                           $errors[] = 'Organizer name is required';
        if (empty($organizer_email) || !filter_var($organizer_email, FILTER_VALIDATE_EMAIL))
                                                                              $errors[] = 'Valid contact email is required';

        $ticket_type = $_POST['ticket_type'] ?? 'free';
        if ($ticket_type === 'paid') {
            $ticket_price    = floatval($_POST['ticket_price'] ?? 0);
            $ticket_quantity = intval($_POST['ticket_quantity_form'] ?? 0);
            if ($ticket_price <= 0)                          $errors[] = 'Valid ticket price is required';
            if ($ticket_quantity < 1 || $ticket_quantity > 10000) $errors[] = 'Ticket quantity must be between 1 and 10000';
        } else {
            $ticket_quantity = intval($_POST['free_ticket_quantity'] ?? 200);
            $ticket_price    = null;
        }

        // Handle image upload
        $image_path = null;
        if (isset($_FILES['event_image']) && $_FILES['event_image']['error'] === UPLOAD_ERR_OK) {
            $file    = $_FILES['event_image'];
            $finfo   = new finfo(FILEINFO_MIME_TYPE);
            $mime    = $finfo->file($file['tmp_name']);
            $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif'];
            if (!isset($allowed[$mime]))        $errors[] = 'Only JPG, PNG, and GIF images are allowed';
            if ($file['size'] > 5 * 1024 * 1024) $errors[] = 'Image must be less than 5MB';
            if (empty($errors)) {
                $ext      = $allowed[$mime];
                $filename = bin2hex(random_bytes(16)) . '_' . time() . '.' . $ext;
                $target   = $this->uploadDir . $filename;
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

        try {
            $eventModel = new Event();
            $eventModel->create([
                'user_id'              => (int) $_SESSION['user_id'],
                'title'                => $title,
                'category'             => $category,
                'description'          => $description,
                'tags'                 => trim($_POST['event_tags'] ?? ''),
                'start_at'             => sprintf('%s %s:00', $event_date, $event_time),
                'location'             => $location,
                'full_address'         => trim($_POST['event_address'] ?? ''),
                'event_type'           => $_POST['event_type'] ?? 'in-person',
                'duration'             => $_POST['event_duration'] ?? '',
                'ticket_type'          => $ticket_type,
                'ticket_price'         => $ticket_price,
                'ticket_quantity'      => $ticket_quantity,
                'early_bird_enabled'   => isset($_POST['early_bird_check']) ? 1 : 0,
                'early_bird_price'     => isset($_POST['early_bird_check']) ? floatval($_POST['early_price'] ?? 0) : null,
                'early_bird_deadline'  => isset($_POST['early_bird_check']) ? ($_POST['early_deadline'] ?? null) : null,
                'organizer_name'       => $organizer_name,
                'organizer_email'      => $organizer_email,
                'organizer_phone'      => trim($_POST['organizer_phone'] ?? ''),
                'website'              => trim($_POST['website'] ?? ''),
                'facebook_url'         => trim($_POST['facebook_url'] ?? ''),
                'instagram_url'        => trim($_POST['instagram_url'] ?? ''),
                'twitter_url'          => trim($_POST['twitter_url'] ?? ''),
                'event_image'          => $image_path,
                'status'               => 'pending',
            ]);

            echo json_encode(['success' => true, 'message' => 'Event submitted successfully and is pending review']);
        } catch (Exception $e) {
            error_log('PostEventController::store - ' . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Server error while saving event']);
        }
        exit;
    }

    public function handle(): void
    {
        if (isset($_GET['action']) && $_GET['action'] === 'token') {
            $this->token();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->store();
        } else {
            $this->create();
        }
    }
}
