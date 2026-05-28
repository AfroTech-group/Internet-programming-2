<?php
// app/models/Database.php - PDO connection singleton

require_once __DIR__ . '/../../config/config.php';

class Database
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $host = env('DB_HOST', 'localhost');
            $name = env('DB_NAME', 'afroevents_db');
            $user = env('DB_USER', 'root');
            $pass = env('DB_PASS', '');

            $dsn = "mysql:host={$host};dbname={$name};charset=utf8mb4";
            try {
                self::$instance = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                error_log('Database connection error: ' . $e->getMessage());
                throw $e;
            }
        }
        return self::$instance;
    }
}
