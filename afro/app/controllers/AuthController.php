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
