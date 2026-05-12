<?php
// event_detail.php - detailed view of a single event with booking functionality
require_once __DIR__ . '/auth.php';

$eventId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($eventId <= 0) {
    header('Location: /afro/events.php');
    exit;
}
// adding a try and catch for event handling exceptions
try {
    $stmt = $pdo->prepare("
        SELECT e.*, u.username, u.email as creator_email, u.full_name as creator_name 
        FROM events e 
        LEFT JOIN users u ON e.user_id = u.id 
        WHERE e.id = :id AND e.status = 'active'
    ");
    $stmt->execute([':id' => $eventId]);
    $event = $stmt->fetch();
    
    if (!$event) {
        header('Location: /afro/events.php');
        exit;
    }
    
    // Get user's booking history for this event
    $userBookings = [];
    if (is_logged_in()) {
        $stmt = $pdo->prepare("
            SELECT * FROM bookings 
            WHERE user_id = :user_id AND event_id = :event_id 
            ORDER BY created_at DESC
        ");
        $stmt->execute([':user_id' => $_SESSION['user_id'], ':event_id' => $eventId]);
        $userBookings = $stmt->fetchAll();
    }
    
} catch (Exception $e) {
    error_log('event_detail.php: ' . $e->getMessage());
    $event = null;
    $userBookings = [];
}

// Handle booking form submission
$bookingErrors = [];
$bookingSuccess = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'book_tickets') {
    if (!is_logged_in()) {
        header('Location: /afro/login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
        exit;
    }
    
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $token = $_POST['csrf_token'] ?? '';
    
    if (!verify_csrf($token)) {
        $bookingErrors[] = 'Invalid request token';
    } elseif ($quantity < 1) {
        $bookingErrors[] = 'Please select at least 1 ticket';
    } elseif ($event && $event['ticket_quantity'] && $quantity > ($event['ticket_quantity'] - $event['tickets_sold'])) {
        $bookingErrors[] = 'Not enough tickets available';
    } else {
        try {
            // Generate booking reference
            $bookingReference = 'BK' . strtoupper(uniqid()) . rand(1000, 9999);
            
            // Calculate total amount
            $unitPrice = $event['ticket_price'] ?? 0;
            $totalAmount = $unitPrice * $quantity;
            
            // Insert booking
            $stmt = $pdo->prepare("
                INSERT INTO bookings (booking_reference, user_id, event_id, quantity, unit_price, total_amount, payment_status, booking_status)
                VALUES (:ref, :user_id, :event_id, :quantity, :unit_price, :total_amount, 'pending', 'pending')
            ");
            $stmt->execute([
                ':ref' => $bookingReference,
                ':user_id' => $_SESSION['user_id'],
                ':event_id' => $eventId,
                ':quantity' => $quantity,
                ':unit_price' => $unitPrice,
                ':total_amount' => $totalAmount
            ]);
            
            // Update tickets sold count
            if ($event['ticket_quantity']) {
                $stmt = $pdo->prepare("UPDATE events SET tickets_sold = tickets_sold + :quantity WHERE id = :id");
                $stmt->execute([':quantity' => $quantity, ':id' => $eventId]);
            }
            
            $bookingSuccess = true;
            
            // Refresh event data
            $stmt = $pdo->prepare("SELECT * FROM events WHERE id = :id");
            $stmt->execute([':id' => $eventId]);
            $event = $stmt->fetch();
            
            // Refresh user bookings
            $stmt = $pdo->prepare("
                SELECT * FROM bookings 
                WHERE user_id = :user_id AND event_id = :event_id 
                ORDER BY created_at DESC
            ");
            $stmt->execute([':user_id' => $_SESSION['user_id'], ':event_id' => $eventId]);
            $userBookings = $stmt->fetchAll();
            
        } catch (Exception $e) {
            error_log('event_detail.php booking error: ' . $e->getMessage());
            $bookingErrors[] = 'Booking failed. Please try again.';
        }
    }
}

?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo htmlspecialchars($event['title'] ?? 'Event'); ?> - AfroEvents</title>
    <link rel="stylesheet" href="/afro/theme.css">
    <link rel="stylesheet" href="/afro/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        main{max-width:900px;margin:32px auto;padding:0 16px}
        .event-header{display:flex;gap:20px;margin-bottom:30px}
        .event-image{flex:0 0 350px}
        .event-image img{width:100%;height:250px;object-fit:cover;border-radius:8px}
        .event-info{flex:1}
        .detail-section{margin-bottom:25px}
        .detail-section h3{margin-bottom:10px;color:#333;border-bottom:2px solid #eee;padding-bottom:5px}
        .detail-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:15px}
        .detail-item{padding:10px;background:#f8f9fa;border-radius:6px}
        .detail-label{font-weight:600;color:#666;margin-bottom:3px}
        .detail-value{color:#333}
        .description{background:#f8f9fa;padding:15px;border-radius:8px;line-height:1.6}
        .booking-section{margin-top:30px;padding:20px;background:#fff;border:1px solid #ddd;border-radius:8px}
        .booking-form{display:flex;gap:15px;align-items:center}
        .quantity-input{width:80px;padding:8px;border:1px solid #ddd;border-radius:4px}
        .price-display{font-size:1.2rem;font-weight:600;color:#28a745}
        .booking-history{margin-top:20px}
        .booking-item{padding:10px;background:#f8f9fa;border-radius:6px;margin-bottom:10px}
        .booking-status{display:inline-block;padding:2px 8px;border-radius:12px;font-size:12px;font-weight:600}
        .status-pending{background:#fff3cd;color:#856404}
        .status-confirmed{background:#d4edda;color:#155724}
        .status-cancelled{background:#f8d7da;color:#721c24}
        .back-link{margin-bottom:20px;display:inline-block}
        .btn-primary{background:#2b6cb0;color:white}
        .btn-success{background:#28a745;color:white}
        .btn-danger{background:#dc3545;color:white}
        .alert{padding:12px;border-radius:6px;margin-bottom:15px}
        .alert-success{background:#d4edda;color:#155724;border:1px solid #c3e6cb}
        .alert-danger{background:#f8d7da;color:#721c24;border:1px solid #f5c6cb}
    </style>
</head>
<body>
<?php require_once __DIR__ . '/includes/header.php'; ?>
<main>
    <div class="back-link">
        <a href="/afro/events.php" class="btn">« Back to Events</a>
    </div>

    <?php if ($event): ?>
        <div class="event-header">
            <div class="event-image">
                <img src="<?php echo htmlspecialchars($event['event_image'] ?: 'images.jpg'); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>">
            </div>
            <div class="event-info">
                <h1><?php echo htmlspecialchars($event['title']); ?></h1>
                <div style="margin-top:10px;color:#666;">
                    <p><i class="far fa-calendar"></i> <?php echo htmlspecialchars(date('F j, Y | g:i A', strtotime($event['start_at']))); ?></p>
                    <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($event['location']); ?></p>
                    <p><i class="fas fa-tag"></i> <?php echo htmlspecialchars($event['category']); ?></p>
                </div>
                <div style="margin-top:15px;">
                    <span class="price-display">
                        <?php if ($event['ticket_price']): ?>
                            ETB <?php echo number_format($event['ticket_price'], 2); ?>
                        <?php else: ?>
                            Free
                        <?php endif; ?>
                    </span>
                    <?php if ($event['ticket_quantity']): ?>
                        <span style="margin-left:20px;color:#666;">
                            <i class="fas fa-ticket-alt"></i> 
                            <?php echo max(0, $event['ticket_quantity'] - $event['tickets_sold']); ?> tickets left
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="detail-section">
            <h3>About This Event</h3>
            <div class="description">
                <?php echo nl2br(htmlspecialchars($event['description'])); ?>
            </div>
        </div>

        <div class="detail-section">
            <h3>Event Details</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Event Type</div>
                    <div class="detail-value"><?php echo htmlspecialchars($event['event_type'] ?: 'In-person'); ?></div>
                </div>
                <?php if ($event['duration']): ?>
                <div class="detail-item">
                    <div class="detail-label">Duration</div>
                    <div class="detail-value"><?php echo htmlspecialchars($event['duration']); ?></div>
                </div>
                <?php endif; ?>
                <?php if ($event['full_address']): ?>
                <div class="detail-item">
                    <div class="detail-label">Full Address</div>
                    <div class="detail-value"><?php echo nl2br(htmlspecialchars($event['full_address'])); ?></div>
                </div>
                <?php endif; ?>
                <?php if ($event['tags']): ?>
                <div class="detail-item">
                    <div class="detail-label">Tags</div>
                    <div class="detail-value"><?php echo htmlspecialchars($event['tags']); ?></div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="detail-section">
            <h3>Organizer Information</h3>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">Organizer Name</div>
                    <div class="detail-value"><?php echo htmlspecialchars($event['organizer_name'] ?: $event['creator_name'] ?: 'Not specified'); ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Organizer Email</div>
                    <div class="detail-value"><?php echo htmlspecialchars($event['organizer_email'] ?: $event['creator_email'] ?: 'Not specified'); ?></div>
                </div>
                <?php if ($event['organizer_phone']): ?>
                <div class="detail-item">
                    <div class="detail-label">Organizer Phone</div>
                    <div class="detail-value"><?php echo htmlspecialchars($event['organizer_phone']); ?></div>
                </div>
                <?php endif; ?>
                <?php if ($event['website']): ?>
                <div class="detail-item">
                    <div class="detail-label">Website</div>
                    <div class="detail-value"><a href="<?php echo htmlspecialchars($event['website']); ?>" target="_blank"><?php echo htmlspecialchars($event['website']); ?></a></div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($event['facebook_url'] || $event['instagram_url'] || $event['twitter_url']): ?>
        <div class="detail-section">
            <h3>Connect With Us</h3>
            <div class="detail-grid">
                <?php if ($event['facebook_url']): ?>
                <div class="detail-item">
                    <div class="detail-label">Facebook</div>
                    <div class="detail-value"><a href="<?php echo htmlspecialchars($event['facebook_url']); ?>" target="_blank">View Page</a></div>
                </div>
                <?php endif; ?>
                <?php if ($event['instagram_url']): ?>
                <div class="detail-item">
                    <div class="detail-label">Instagram</div>
                    <div class="detail-value"><a href="<?php echo htmlspecialchars($event['instagram_url']); ?>" target="_blank">View Profile</a></div>
                </div>
                <?php endif; ?>
                <?php if ($event['twitter_url']): ?>
                <div class="detail-item">
                    <div class="detail-label">Twitter</div>
                    <div class="detail-value"><a href="<?php echo htmlspecialchars($event['twitter_url']); ?>" target="_blank">View Profile</a></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <div id="booking" class="booking-section">
            <h3>Book Your Tickets</h3>
            
            <?php if ($bookingSuccess): ?>
                <div class="alert alert-success">
                    <strong>Booking Successful!</strong> Your booking reference is: <strong><?php echo htmlspecialchars($bookingReference); ?></strong>
                </div>
            <?php endif; ?>

            <?php if (!empty($bookingErrors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($bookingErrors as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!is_logged_in()): ?>
                <p>Please <a href="/afro/login.php?redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">log in</a> to book tickets.</p>
            <?php elseif ($event['ticket_quantity'] && $event['tickets_sold'] >= $event['ticket_quantity']): ?>
                <p style="color:#dc3545;">This event is sold out!</p>
            <?php else: ?>
                <form method="post" class="booking-form">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token()); ?>">
                    <input type="hidden" name="action" value="book_tickets">
                    
                    <label for="quantity">Number of Tickets:</label>
                    <input type="number" id="quantity" name="quantity" class="quantity-input" min="1" max="<?php echo $event['ticket_quantity'] ? max(1, $event['ticket_quantity'] - $event['tickets_sold']) : 10; ?>" value="1">
                    
                    <div class="price-display">
                        Total: ETB <span id="total-price"><?php echo number_format($event['ticket_price'] ?? 0, 2); ?></span>
                    </div>
                    
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-ticket-alt"></i> Book Tickets
                    </button>
                </form>
            <?php endif; ?>
        </div>

        <?php if (is_logged_in() && !empty($userBookings)): ?>
        <div class="booking-history">
            <h3>Your Booking History</h3>
            <?php foreach ($userBookings as $booking): ?>
                <div class="booking-item">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <div>
                            <strong>Reference:</strong> <?php echo htmlspecialchars($booking['booking_reference']); ?><br>
                            <strong>Quantity:</strong> <?php echo (int)$booking['quantity']; ?> tickets<br>
                            <strong>Total:</strong> ETB <?php echo number_format($booking['total_amount'], 2); ?><br>
                            <strong>Date:</strong> <?php echo htmlspecialchars(date('M j, Y g:i A', strtotime($booking['created_at']))); ?>
                        </div>
                        <div>
                            <span class="booking-status status-<?php echo htmlspecialchars($booking['booking_status']); ?>">
                                <?php echo htmlspecialchars($booking['booking_status']); ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    <?php else: ?>
        <p>Event not found.</p>
        <a href="/afro/events.php" class="btn">Back to Events</a>
    <?php endif; ?>
</main>
<script>
// Update total price when quantity changes
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity');
    const totalPriceSpan = document.getElementById('total-price');
    const unitPrice = <?php echo $event['ticket_price'] ?? 0; ?>;
    
    if (quantityInput && totalPriceSpan) {
        quantityInput.addEventListener('input', function() {
            const quantity = parseInt(this.value) || 1;
            const total = unitPrice * quantity;
            totalPriceSpan.textContent = total.toFixed(2);
        });
    }
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
</body>
</html>

