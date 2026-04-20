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
<main class="container">
    <h1>Your Bookings</h1>
    <p style="color:var(--text-muted);margin-bottom:20px;font-size:0.9rem">Bookings you have made. Empty if none yet.</p>
<div style="background:#f8f9fa;border:1px solid #e9ecef;padding:16px;border-radius:6px">No bookings found.</div>
<table class="bookings">
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
 </main>
</body>
</html>             

