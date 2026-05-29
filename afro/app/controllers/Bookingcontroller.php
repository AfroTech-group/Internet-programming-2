<?php
// app/controllers/api/BookingApiController.php
// REST API controller for bookings — returns JSON only.

require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../../models/Booking.php';
require_once __DIR__ . '/../../models/Event.php';

class BookingApiController
{
    private Booking $bookingModel;
    private Event   $eventModel;

    public function __construct()
    {
        $this->bookingModel = new Booking();
        $this->eventModel   = new Event();
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

    // ── GET /api/bookings ────────────────────────────────────────
    // Returns the authenticated user's booking history + summary stats.
    public function index(): void
    {
        if (!is_logged_in()) {
            $this->error('Authentication required.', 401);
        }

        $user = current_user();

        try {
            $bookings = $this->bookingModel->getByUser((int) $user['id']);

            // Cast numeric fields
            foreach ($bookings as &$b) {
                $b['quantity']     = (int)   $b['quantity'];
                $b['unit_price']   = (float) $b['unit_price'];
                $b['total_amount'] = (float) $b['total_amount'];
                $b['event_id']     = (int)   $b['event_id'];
            }
            unset($b);

            $totalSpent = array_sum(array_column($bookings, 'total_amount'));
            $paidCount  = count(array_filter($bookings, fn($b) => $b['payment_status'] === 'paid'));

            $this->json([
                'success'  => true,
                'stats'    => [
                    'total_bookings' => count($bookings),
                    'total_spent'    => round($totalSpent, 2),
                    'paid_count'     => $paidCount,
                ],
                'bookings' => $bookings,
            ]);
        } catch (Exception $ex) {
            error_log('BookingApiController::index - ' . $ex->getMessage());
            $this->error('Failed to fetch bookings.', 500);
        }
    }

    // ── POST /api/bookings ───────────────────────────────────────
    // Body (JSON or form-encoded): event_id, quantity
    public function store(): void
    {
        if (!is_logged_in()) {
            $this->error('Authentication required.', 401);
        }

        // CSRF check — accepts X-CSRF-Token header (for fetch()) or csrf_token body field
        require_once __DIR__ . '/../../core/Security.php';
        csrf_verify_api();

        // Accept both JSON body and form-encoded POST
        $body = [];
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        if (str_contains($contentType, 'application/json')) {
            $raw  = file_get_contents('php://input');
            $body = json_decode($raw, true) ?? [];
        } else {
            $body = $_POST;
        }

        $eventId  = isset($body['event_id'])  ? intval($body['event_id'])  : 0;
        $quantity = isset($body['quantity'])  ? intval($body['quantity'])  : 0;

        // ── Validate ─────────────────────────────────────────────
        $errors = [];

        if ($eventId <= 0) {
            $errors[] = 'Invalid event ID.';
        }
        if ($quantity < 1) {
            $errors[] = 'Please select at least 1 ticket.';
        } elseif ($quantity > 10) {
            $errors[] = 'Maximum 10 tickets per order.';
        }

        if (!empty($errors)) {
            $this->json(['success' => false, 'errors' => $errors], 422);
        }

        // ── Fetch event ───────────────────────────────────────────
        try {
            $event = $this->eventModel->findById($eventId);
        } catch (Exception $ex) {
            error_log('BookingApiController::store findById - ' . $ex->getMessage());
            $this->error('Failed to load event.', 500);
        }

        if (!$event) {
            $this->error('Event not found.', 404);
        }

        $available = max(0, ($event['ticket_quantity'] ?? 0) - ($event['tickets_sold'] ?? 0));
        if ($quantity > $available) {
            $this->json([
                'success' => false,
                'errors'  => ["Only {$available} ticket(s) available."],
            ], 422);
        }

        // ── Create booking ────────────────────────────────────────
        try {
            $unitPrice   = (float) ($event['ticket_price'] ?? 0);
            $totalAmount = $unitPrice * $quantity;
            $ref         = strtoupper(bin2hex(random_bytes(6)));

            $this->bookingModel->create([
                'booking_reference' => $ref,
                'user_id'           => (int) $_SESSION['user_id'],
                'event_id'          => $eventId,
                'quantity'          => $quantity,
                'unit_price'        => $unitPrice,
                'total_amount'      => $totalAmount,
                'payment_status'    => 'pending',
                'booking_status'    => 'confirmed',
            ]);

            $this->json([
                'success'           => true,
                'booking_reference' => $ref,
                'event_id'          => $eventId,
                'quantity'          => $quantity,
                'unit_price'        => $unitPrice,
                'total_amount'      => $totalAmount,
                'payment_status'    => 'pending',
                'booking_status'    => 'confirmed',
            ], 201);
        } catch (Exception $ex) {
            error_log('BookingApiController::store create - ' . $ex->getMessage());
            $this->error('Booking failed. Please try again.', 500);
        }
    }
}
