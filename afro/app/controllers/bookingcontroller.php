<?php
// app/controllers/BookingController.php

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../models/Booking.php';
require_once __DIR__ . '/../models/Event.php';

class BookingController
{
    private Booking $bookingModel;
    private Event $eventModel;

    public function __construct()
    {
        $this->bookingModel = new Booking();
        $this->eventModel   = new Event();
    }

    /**
     * Show the logged-in user's booking history.
     */
    public function index(): void
    {
        require_login();
        $user     = current_user();
        $bookings = [];

        try {
            $bookings = $this->bookingModel->getByUser((int) $user['id']);
        } catch (Exception $e) {
            error_log('BookingController::index - ' . $e->getMessage());
        }

        include __DIR__ . '/../views/bookings/index.php';
    }

    /**
     * Process a ticket booking (called from EventController::show).
     * Returns ['success' => bool, 'errors' => array].
     */
    public function store(array $event): array
    {
        $errors  = [];
        $success = false;

        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

        if ($quantity < 1) {
            $errors[] = 'Please select at least 1 ticket.';
        } elseif ($quantity > 10) {
            $errors[] = 'Maximum 10 tickets per order.';
        }

        $available = ($event['ticket_quantity'] ?? 0) - ($event['tickets_sold'] ?? 0);
        if (empty($errors) && $quantity > $available) {
            $errors[] = "Only {$available} tickets available.";
        }

        if (empty($errors)) {
            try {
                $unitPrice   = (float) ($event['ticket_price'] ?? 0);
                $totalAmount = $unitPrice * $quantity;
                $ref         = strtoupper(bin2hex(random_bytes(6)));

                $this->bookingModel->create([
                    'booking_reference' => $ref,
                    'user_id'           => (int) $_SESSION['user_id'],
                    'event_id'          => (int) $event['id'],
                    'quantity'          => $quantity,
                    'unit_price'        => $unitPrice,
                    'total_amount'      => $totalAmount,
                    'payment_status'    => 'pending',
                    'booking_status'    => 'confirmed',
                ]);
                $success = true;
            } catch (Exception $e) {
                error_log('BookingController::store - ' . $e->getMessage());
                $errors[] = 'Booking failed. Please try again.';
            }
        }

        return compact('success', 'errors');
    }
}
