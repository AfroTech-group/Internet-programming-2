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
 $stmt->execute([
            ':username'      => $data['username'],
            ':email'         => $data['email'],
            ':password_hash' => $data['password'],   // caller passes plain 'password' key
            ':full_name'     => $data['full_name'] ?? '',
            ':role'          => $data['role'] ?? 'user',
            ':avatar'        => $data['avatar'] ?? null,
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        // Whitelist of columns that are safe to update — prevents column-name injection
        $allowed = [
            'username', 'email', 'full_name', 'phone',
            'password_hash', 'role', 'status', 'avatar',
        ];

        $fields = [];
        $params = [':id' => $id];

        foreach ($data as $key => $value) {
            if (!in_array($key, $allowed, true)) {
                continue; // silently skip unknown / disallowed columns
            }
            $fields[]        = "{$key} = :{$key}";
            $params[":{$key}"] = $value;
        }

        if (empty($fields)) {
            return false; // nothing safe to update
        }

        $sql  = 'UPDATE users SET ' . implode(', ', $fields) . ' WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Return all users with booking count, ordered by created_at desc.
     */
    public function getAll(string $search = '', string $role = '', string $status = ''): array
    {
        $where  = ['1=1'];
        $params = [];

        if ($search !== '') {
            $s = '%' . $search . '%';
            $where[]       = '(u.username LIKE :s1 OR u.email LIKE :s2 OR u.full_name LIKE :s3)';
            $params[':s1'] = $s;
            $params[':s2'] = $s;
            $params[':s3'] = $s;
        }
        if ($role !== '') {
            $where[]      = 'u.role = :role';
            $params[':role'] = $role;
        }
        if ($status !== '') {
            $where[]        = 'u.status = :status';
            $params[':status'] = $status;
        }

        $sql = 'SELECT u.id, u.username, u.email, u.full_name, u.phone,
                       u.role, u.status, u.avatar, u.created_at,
                       COUNT(b.id) AS booking_count
                FROM users u
                LEFT JOIN bookings b ON b.user_id = u.id
                WHERE ' . implode(' AND ', $where) . '
                GROUP BY u.id
                ORDER BY u.created_at DESC';
