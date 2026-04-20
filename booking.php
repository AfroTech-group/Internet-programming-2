<?php
require_once __DIR__ . '/auth.php';
if (is_logged_in()) { header('Location: /afro/index.php'); exit; }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!verify_csrf($token)) $errors[] = 'Invalid CSRF token';

    $identifier = trim($_POST['identifier'] ?? '');
    $password   = $_POST['password'] ?? '';
    if ($identifier === '' || $password === '') $errors[] = 'Provide username/email and password.';

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare('SELECT id, username, email, password_hash FROM users WHERE username=:username OR email=:email LIMIT 1');
            $stmt->execute([':username' => $identifier, ':email' => $identifier]);
            $u = $stmt->fetch();
            if ($u && password_verify($password, $u['password_hash'])) {
                login_user($u['id']);
                header('Location: /afro/index.php'); exit;
            } else {
                $errors[] = 'Invalid credentials.';
            }
        } catch (PDOException $e) {
            error_log('login.php: ' . $e->getMessage());
            $errors[] = 'Server error, try again later.';
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Your Bookings - AfroEvents</title>
    <link rel="stylesheet" href="/afro/theme.css">
</head>
<body>
    <?php require_once __DIR__ . '/includes/header.php'; ?>
<main class="container">
    <h1>Your Bookings</h1>
    <p style="color:var(--text-muted);margin-bottom:20px;font-size:0.9rem">Bookings you have made. Empty if none yet.</p>
 <?php if (empty($bookings)): ?>
        <div style="background:#f8f9fa;border:1px solid #e9ecef;padding:16px;border-radius:6px">No bookings found.</div>
    <?php else: ?>
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Event</th>
                    <th>Date</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Booking</th>
                    <th>Booked At</th>
                </tr>
            </thead>
            <tbody>
     <?php foreach ($bookings as $b):
                $ref = htmlspecialchars($b['booking_reference']);
                $eventTitle = htmlspecialchars($b['event_title'] ?? 'Event removed');
                $eventDate = !empty($b['event_start']) ? date('F j, Y g:i A', strtotime($b['event_start'])) : '-';
                $qty = intval($b['quantity']);
                $unit = is_null($b['unit_price']) ? 'ETB 0.00' : 'ETB ' . number_format($b['unit_price'], 2);
                $total = 'ETB ' . number_format($b['total_amount'], 2);
                $payment = htmlspecialchars($b['payment_status']);
                $bookingStatus = htmlspecialchars($b['booking_status']);
                $created = htmlspecialchars($b['created_at']);
                $eventLink = isset($b['event_id']) ? ("events.php#event-" . intval($b['event_id'])) : '#';
            ?>
    <tr>
                    <td><?php echo $ref; ?></td>
                    <td><a href="<?php echo $eventLink; ?>"><?php echo $eventTitle; ?></a></td>
                    <td><?php echo $eventDate; ?></td>
                    <td><?php echo $qty; ?></td>
                    <td><?php echo $unit; ?></td>
                    <td><?php echo $total; ?></td>
                    <td class="<?php echo $payment === 'paid' ? 'status-paid' : ($payment === 'pending' ? 'status-pending' : 'status-failed'); ?>"><?php echo $payment; ?></td>
                    <td><?php echo $bookingStatus; ?></td>
                    <td><?php echo $created; ?></td>
                </tr>
                  </tbody>
        </table>
 </main>
</body>
</html>             

