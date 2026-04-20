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

