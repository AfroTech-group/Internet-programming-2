<?php
// app/controllers/EventController.php

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../models/Event.php';
require_once __DIR__ . '/../models/Booking.php';

class EventController
{
    private Event   $eventModel;
    private Booking $bookingModel;

    public function __construct()
    {
        $this->eventModel   = new Event();
        $this->bookingModel = new Booking();
    }

    // ── Events listing ───────────────────────────────────────────
    public function index(): void
    {
        $search       = trim($_GET['search']       ?? '');
        $category     = trim($_GET['category']     ?? '');
        $event_type   = trim($_GET['event_type']   ?? '');
        $price_filter = trim($_GET['price_filter'] ?? '');
        $sort         = trim($_GET['sort']         ?? 'date_asc');

        $user    = current_user();
        $isAdmin = $user && ($user['role'] ?? '') === 'admin';

        $filters = compact('search', 'category', 'event_type', 'price_filter', 'sort');

        $events = $isAdmin
            ? $this->eventModel->getAllAdmin($filters)
            : $this->eventModel->getAll($filters);

        include __DIR__ . '/../views/events/index.php';
    }

    // ── Single event detail + booking ────────────────────────────
    public function show(): void
    {
        $eventId = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($eventId <= 0) {
            header('Location: /afro/?page=events');
            exit;
        }

        $event        = null;
        $userBookings = [];

        try {
            $event = $this->eventModel->findById($eventId);
            if (!$event) {
                header('Location: /afro/?page=events');
                exit;
            }
            if (is_logged_in()) {
                $userBookings = $this->bookingModel->getByUserAndEvent(
                    (int) $_SESSION['user_id'],
                    $eventId
                );
            }
        } catch (Exception $e) {
            error_log('EventController::show - ' . $e->getMessage());
        }

        $bookingErrors  = [];
        $bookingSuccess = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST'
            && isset($_POST['action'])
            && $_POST['action'] === 'book_tickets'
        ) {
            if (!is_logged_in()) {
                header('Location: /afro/?page=login&redirect=' . urlencode($_SERVER['REQUEST_URI']));
                exit;
            }
            require_once __DIR__ . '/BookingController.php';
            $result         = (new BookingController())->store($event);
            $bookingErrors  = $result['errors'];
            $bookingSuccess = $result['success'];
        }

        include __DIR__ . '/../views/events/show.php';
    }
}
