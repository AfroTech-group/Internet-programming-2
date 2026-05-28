<?php
// app/models/User.php - User model

require_once __DIR__ . '/Database.php';

class User
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, username, email, full_name, role, avatar FROM users WHERE id = :id LIMIT 1'
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM users WHERE email = :email LIMIT 1'
        );
        $stmt->execute([':email' => $email]);
        return $stmt->fetch() ?: null;
    }

    public function findByUsername(string $username): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM users WHERE username = :username LIMIT 1'
        );
        $stmt->execute([':username' => $username]);
        return $stmt->fetch() ?: null;
    }
    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO users (username, email, password_hash, full_name, role, avatar, created_at)
             VALUES (:username, :email, :password_hash, :full_name, :role, :avatar, NOW())'
        );
