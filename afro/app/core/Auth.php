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

function current_user(): ?array
{
    if (empty($_SESSION['user_id'])) return null;
    static $user = null;
    if ($user !== null) return $user;
    $userModel = new User();
    $user = $userModel->findById((int) $_SESSION['user_id']);
    return $user ?: null;
}

function login_user(int $user_id): void
{
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user_id;
}

function logout_user(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(), '', time() - 42000,
            $params['path'], $params['domain'],
            $params['secure'], $params['httponly']
        );
    }
    session_destroy();
}

function require_login(): void
{
    if (!is_logged_in()) {
        header('Location: /afro/?page=login');
        exit;
    }
}

function require_admin(): void
{
    if (!is_logged_in() || (current_user()['role'] ?? '') !== 'admin') {
        http_response_code(403);
        echo 'Forbidden';
        exit;
    }
}
