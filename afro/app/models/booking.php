<?php
// app/models/Booking.php - Booking model

require_once __DIR__ . '/Database.php';

class Booking
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function getByUser(int $userId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT b.booking_reference, b.quantity, b.unit_price, b.total_amount,
                    b.payment_status, b.booking_status, b.created_at, b.event_id,
                    e.title AS event_title, e.start_at AS event_start, e.location AS event_location
             FROM bookings b
             LEFT JOIN events e ON b.event_id = e.id
             WHERE b.user_id = :uid
             ORDER BY b.created_at DESC'
        );
        $stmt->execute([':uid' => $userId]);
        return $stmt->fetchAll();
    }

    public function getByUserAndEvent(int $userId, int $eventId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM bookings
             WHERE user_id = :user_id AND event_id = :event_id
             ORDER BY created_at DESC'
        );
        $stmt->execute([':user_id' => $userId, ':event_id' => $eventId]);
        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO bookings (booking_reference, user_id, event_id, quantity,
                                   unit_price, total_amount, payment_status, booking_status, created_at)
             VALUES (:ref, :user_id, :event_id, :quantity,
                     :unit_price, :total_amount, :payment_status, :booking_status, NOW())'
        );
        $stmt->execute([
            ':ref'            => $data['booking_reference'],
            ':user_id'        => $data['user_id'],
            ':event_id'       => $data['event_id'],
            ':quantity'       => $data['quantity'],
            ':unit_price'     => $data['unit_price'],
            ':total_amount'   => $data['total_amount'],
            ':payment_status' => $data['payment_status'] ?? 'pending',
            ':booking_status' => $data['booking_status'] ?? 'confirmed',
        ]);
        return (int) $this->pdo->lastInsertId();
    }
}
