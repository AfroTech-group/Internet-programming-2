<?php
// app/core/Auth.php - session and authentication helpers

if (session_status() === PHP_SESSION_NONE) {
    // Harden session cookie before starting the session
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params([
        'lifetime' => $cookieParams['lifetime'],
        'path'     => $cookieParams['path'] ?: '/',
        'domain'   => $cookieParams['domain'],
        'secure'   => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/User.php';

function is_logged_in(): bool
{
    return !empty($_SESSION['user_id']);
}
