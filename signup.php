
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
