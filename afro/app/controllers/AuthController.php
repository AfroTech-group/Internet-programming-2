<?php
// app/controllers/AuthController.php

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/Security.php';
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    // ── Login ────────────────────────────────────────────────────
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            if (is_logged_in()) { header('Location: /afro/'); exit; }
            include __DIR__ . '/../views/auth/login.php';
            return;
        }

        // CSRF check
        csrf_verify();

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
 $errors   = [];

        if (!$username || !$password) {
            $errors[] = 'Username and password are required.';
        }

        // Rate-limit by username + IP combined key
        $rateLimitKey = $username . '|' . ($_SERVER['REMOTE_ADDR'] ?? '');

        if (empty($errors) && is_login_locked($rateLimitKey)) {
            $errors[] = 'Too many failed attempts. Please wait 15 minutes before trying again.';
        }

        if (empty($errors)) {
            $user = $this->userModel->findByUsername($username);
            $hash = $user['password_hash'] ?? $user['password'] ?? '';
            if (!$user || !password_verify($password, $hash)) {
                record_failed_login($rateLimitKey);
                $errors[] = 'Invalid username or password.';
            } else {
                clear_login_attempts($rateLimitKey);
                login_user((int) $user['id']);
                // Validate redirect to prevent open redirect
                $redirect = safe_redirect($_GET['redirect'] ?? '', '/afro/');
                header('Location: ' . $redirect);
                exit;
            }
        }

        include __DIR__ . '/../views/auth/login.php';
// ── Register ─────────────────────────────────────────────────
    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            if (is_logged_in()) { header('Location: /afro/'); exit; }
            include __DIR__ . '/../views/auth/register.php';
            return;
        }

        // CSRF check
        csrf_verify();

        // Rate-limit registrations by IP to prevent spam account creation
        $rateLimitKey = 'register|' . ($_SERVER['REMOTE_ADDR'] ?? '');
        $errors = [];

        if (is_login_locked($rateLimitKey)) {
            $errors[] = 'Too many registration attempts. Please wait 15 minutes before trying again.';
        }

        $username = trim($_POST['username'] ?? '');
        $email    = trim($_POST['email']    ?? '');
        $password = $_POST['password']      ?? '';
if (empty($errors)) {
            if (!$username || !$email || !$password) {
                $errors[] = 'All fields are required.';
            }
            if ($username && !preg_match('/^[A-Za-z0-9_\-]{3,50}$/', $username)) {
                $errors[] = 'Username must be 3–50 characters (letters, numbers, _ or -)';
            }
            if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Invalid email address.';
            }
            if ($password && strlen($password) < 6) {
                $errors[] = 'Password must be at least 6 characters.';
            }
        }

        if (empty($errors)) {
            if ($this->userModel->findByUsername($username)) {
                $errors[] = 'Username already taken.';
            } elseif ($this->userModel->findByEmail($email)) {
                $errors[] = 'Email already registered.';
            }
        }

        if (empty($errors)) {
            // Record a successful registration to count toward the rate limit window
            record_failed_login($rateLimitKey);
            $id = $this->userModel->create([
                'username' => $username,
                'email'    => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role'     => 'user',
            ]);
            login_user($id); // regenerates session ID internally
            header('Location: /afro/');
            exit;
        }

        include __DIR__ . '/../views/auth/register.php';
    }

    // ── Logout ───────────────────────────────────────────────────
    public function logout(): void
    {
        logout_user();
        header('Location: /afro/');
        exit;
    }
}
