<?php
// app/controllers/api/EventApiController.php
// REST API controller for events — returns JSON only.

require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../../models/Event.php';
require_once __DIR__ . '/../../models/Booking.php';

class EventApiController
{
    private Event   $eventModel;
    private Booking $bookingModel;

    public function __construct()
    {
        $this->eventModel   = new Event();
        $this->bookingModel = new Booking();
    }

    // ── Helpers ──────────────────────────────────────────────────

    private function json(mixed $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    private function error(string $message, int $status = 400): void
    {
        $this->json(['success' => false, 'error' => $message], $status);
    }

    // ── GET /api/events ──────────────────────────────────────────
    // Query params: search, category, event_type, price_filter, sort
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

        try {
            $events = $isAdmin
                ? $this->eventModel->getAllAdmin($filters)
                : $this->eventModel->getAll($filters);

            // Normalise image paths so the client always gets a usable URL
            foreach ($events as &$e) {
                $e['event_image'] = $this->resolveImageUrl($e['event_image'] ?? null);
                // Cast numeric fields
                $e['id']              = (int)   $e['id'];
                $e['ticket_price']    = (float) ($e['ticket_price'] ?? 0);
                $e['ticket_quantity'] = (int)   ($e['ticket_quantity'] ?? 0);
                $e['tickets_sold']    = (int)   ($e['tickets_sold']   ?? 0);
                $e['tickets_available'] = max(0, $e['ticket_quantity'] - $e['tickets_sold']);
            }
            unset($e);

            $this->json([
                'success' => true,
                'count'   => count($events),
                'filters' => $filters,
                'events'  => $events,
            ]);
        } catch (Exception $ex) {
            error_log('EventApiController::index - ' . $ex->getMessage());
            $this->error('Failed to fetch events.', 500);
        }
    }

    // ── GET /api/events/{id} ─────────────────────────────────────
    public function show(): void
    {
        $eventId = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($eventId <= 0) {
            $this->error('Invalid event ID.', 400);
        }

        try {
            $event = $this->eventModel->findById($eventId);
            if (!$event) {
                $this->error('Event not found.', 404);
            }

            $event['event_image']       = $this->resolveImageUrl($event['event_image'] ?? null);
            $event['id']                = (int)   $event['id'];
            $event['ticket_price']      = (float) ($event['ticket_price']    ?? 0);
            $event['ticket_quantity']   = (int)   ($event['ticket_quantity'] ?? 0);
            $event['tickets_sold']      = (int)   ($event['tickets_sold']    ?? 0);
            $event['tickets_available'] = max(0, $event['ticket_quantity'] - $event['tickets_sold']);

            // Include the current user's bookings for this event if logged in
            $userBookings = [];
            if (is_logged_in()) {
                $userBookings = $this->bookingModel->getByUserAndEvent(
                    (int) $_SESSION['user_id'],
                    $eventId
                );
                foreach ($userBookings as &$b) {
                    $b['quantity']     = (int)   $b['quantity'];
                    $b['total_amount'] = (float) $b['total_amount'];
                    $b['unit_price']   = (float) $b['unit_price'];
                }
                unset($b);
            }

            $this->json([
                'success'      => true,
                'event'        => $event,
                'userBookings' => $userBookings,
                'isLoggedIn'   => is_logged_in(),
            ]);
        } catch (Exception $ex) {
            error_log('EventApiController::show - ' . $ex->getMessage());
            $this->error('Failed to fetch event.', 500);
        }
    }

    // ── Utility ──────────────────────────────────────────────────

    private function resolveImageUrl(?string $path): string
    {
        if (!$path) {
            return '/afro/public/images/placeholder.jpg';
        }
        if (str_starts_with($path, 'http') || str_starts_with($path, '/')) {
            return $path;
        }
        return '/afro/' . $path;
    }
}
