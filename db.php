<?php
// db.php - create a PDO connection using values from config.php/.env

require_once __DIR__ . '/config.php';

$db_host = env('DB_HOST', 'localhost');
$db_name = env('DB_NAME', 'afroevents_db');
$db_user = env('DB_USER', 'root');
$db_pass = env('DB_PASS', '');

$dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";
try {
    $pdo = new PDO($dsn, $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    error_log('db.php connection error: ' . $e->getMessage());
    throw $e;
}
