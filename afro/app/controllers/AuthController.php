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
