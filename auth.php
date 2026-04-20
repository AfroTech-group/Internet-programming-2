<?php
// auth.php - session and auth helpers
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/db.php';

function is_logged_in()
{
    return !empty($_SESSION['user_id']);
}

function current_user()
{
    global $pdo;
    if (empty($_SESSION['user_id'])) return null;
    static $user = null;
    if ($user !== null) return $user;
    // include avatar so header can show it without extra query
    $stmt = $pdo->prepare('SELECT id, username, email, full_name, role, avatar FROM users WHERE id = :id LIMIT 1');
    $stmt->execute([':id' => $_SESSION['user_id']]);
    $user = $stmt->fetch();
    return $user ?: null;
}

function login_user($user_id)
{
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user_id;
}

function logout_user()
{
    // Clear session and cookie
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params['path'], $params['domain'], $params['secure'], $params['httponly']
        );
    }
    session_destroy();
}

function require_login()
{
    if (!is_logged_in()) {
        header('Location: /afro/login.php');
        exit;
    }
}

// CSRF helpers
function csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf($token)
{
    return !empty($token) && !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

?>
