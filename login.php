
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
