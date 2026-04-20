
<?php
require_once __DIR__ . '/auth.php';
if (is_logged_in()) { header('Location: /afro/index.php'); exit; }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!verify_csrf($token)) $errors[] = 'Invalid CSRF token';

    $username         = trim($_POST['username'] ?? '');
    $email            = trim($_POST['email'] ?? '');
    $password         = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $full_name        = trim($_POST['full_name'] ?? '');
    $phone            = trim($_POST['phone'] ?? '');

    if (!preg_match('/^[A-Za-z0-9_\-]{3,50}$/', $username)) $errors[] = 'Username: 3-50 chars, letters/numbers/-/_';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))           $errors[] = 'Provide a valid email address.';
    if (strlen($password) < 6)                                $errors[] = 'Password must be at least 6 characters.';
    if ($password !== $password_confirm)                      $errors[] = 'Passwords do not match.';
  if (empty($errors)) {
        try {
            $stmt = $pdo->prepare('SELECT id FROM users WHERE username=:u OR email=:e LIMIT 1');
            $stmt->execute([':u'=>$username, ':e'=>$email]);
            if ($stmt->fetch()) {
                $errors[] = 'Username or email already in use.';
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $ins  = $pdo->prepare('INSERT INTO users (username, email, password_hash, full_name, phone) VALUES (:u,:e,:p,:f,:ph)');
                $ins->execute([':u'=>$username,':e'=>$email,':p'=>$hash,':f'=>$full_name?:null,':ph'=>$phone?:null]);
                login_user($pdo->lastInsertId());
                header('Location: /afro/index.php'); exit;
            }
        } catch (PDOException $e) {
            error_log('signup.php: ' . $e->getMessage());
            $errors[] = 'Server error, try again later.';
        }
    }
}
?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Sign up — HabeshaEvents</title>
    <link rel="stylesheet" href="/afro/theme.css">
</head>
<body class="auth-page">
<div class="auth-card">
    <div class="auth-logo">
        <a href="/afro/index.php">HABESHA<span>EVENTS</span></a>
        <p>Create your free account today.</p>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="auth-errors"><?php echo htmlspecialchars(implode(' · ', $errors)); ?></div>
    <?php endif; ?>

    <form method="post" id="signup-form" novalidate>
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token()); ?>">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required autocomplete="username"
                   value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" placeholder="cooluser123">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required autocomplete="email"
                   value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" placeholder="you@example.com">
        </div>
        <div class="form-group">
            <label>Full Name <span style="color:var(--text-muted);font-weight:400">(optional)</span></label>
            <input type="text" name="full_name"
                   value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>" placeholder="Abebe Girma">
        </div>
        <div class="form-group">
            <label>Phone <span style="color:var(--text-muted);font-weight:400">(optional)</span></label>
            <input type="text" name="phone"
                   value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>" placeholder="+251 9...">
        </div>
