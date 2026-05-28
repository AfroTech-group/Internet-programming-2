<?php
// app/models/Event.php - Event model

require_once __DIR__ . '/Database.php';

class Event
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    /**
     * Fetch active events with optional search/filter/sort params.
     */
    public function getAll(array $filters = []): array
    {
        $where  = ["e.status = 'active'"];
        $params = [];

        if (!empty($filters['search'])) {
            $s = '%' . $filters['search'] . '%';
            $where[]              = '(e.title LIKE :s1 OR e.description LIKE :s2 OR e.location LIKE :s3)';
            $params[':s1'] = $s;
            $params[':s2'] = $s;
            $params[':s3'] = $s;
        }
        if (!empty($filters['category'])) {
            $where[]             = 'e.category = :category';
            $params[':category'] = $filters['category'];
        }
        if (!empty($filters['event_type'])) {
            $where[]               = 'e.event_type = :event_type';
            $params[':event_type'] = $filters['event_type'];
        }
        if (!empty($filters['price_filter'])) {
            if ($filters['price_filter'] === 'free') {
                $where[] = '(e.ticket_price IS NULL OR e.ticket_price = 0)';
            } elseif ($filters['price_filter'] === 'paid') {
                $where[] = '(e.ticket_price IS NOT NULL AND e.ticket_price > 0)';
            }
        }

        $order = match($filters['sort'] ?? 'date_asc') {
            'date_desc'  => 'e.start_at DESC',
            'price_asc'  => 'COALESCE(e.ticket_price, 0) ASC',
            'price_desc' => 'COALESCE(e.ticket_price, 0) DESC',
            default      => 'e.start_at ASC',
        };

        $sql = 'SELECT e.id, e.title, e.category, e.description, e.start_at, e.event_image,
                       e.location, e.ticket_price, e.tickets_sold, e.ticket_quantity,
                       e.status, e.event_type
                FROM events e
                WHERE ' . implode(' AND ', $where) . '
                ORDER BY ' . $order;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Fetch all events regardless of status (admin use).
     */
    public function getAllAdmin(array $filters = []): array
    {
        $where  = ['1=1'];
        $params = [];

        if (!empty($filters['search'])) {
            $s = '%' . $filters['search'] . '%';
            $where[]       = '(e.title LIKE :s1 OR e.description LIKE :s2 OR e.location LIKE :s3)';
            $params[':s1'] = $s;
            $params[':s2'] = $s;
            $params[':s3'] = $s;
        }
        if (!empty($filters['category'])) {
            $where[]             = 'e.category = :category';
            $params[':category'] = $filters['category'];
        }
        if (!empty($filters['event_type'])) {
            $where[]               = 'e.event_type = :event_type';
            $params[':event_type'] = $filters['event_type'];
        }
        if (!empty($filters['price_filter'])) {
            if ($filters['price_filter'] === 'free') {
                $where[] = '(e.ticket_price IS NULL OR e.ticket_price = 0)';
            } elseif ($filters['price_filter'] === 'paid') {
                $where[] = '(e.ticket_price IS NOT NULL AND e.ticket_price > 0)';
            }
        }

        $order = match($filters['sort'] ?? 'date_asc') {
            'date_desc'  => 'e.start_at DESC',
            'price_asc'  => 'COALESCE(e.ticket_price, 0) ASC',
            'price_desc' => 'COALESCE(e.ticket_price, 0) DESC',
            default      => 'e.start_at ASC',
        };

        $sql = 'SELECT e.id, e.title, e.category, e.description, e.start_at, e.event_image,
                       e.location, e.ticket_price, e.tickets_sold, e.ticket_quantity,
                       e.status, e.event_type
                FROM events e
                WHERE ' . implode(' AND ', $where) . '
                ORDER BY ' . $order;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT e.*, u.username, u.email AS creator_email, u.full_name AS creator_name
             FROM events e
             LEFT JOIN users u ON e.user_id = u.id
             WHERE e.id = :id AND e.status = \'active\''
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function findByIdAdmin(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT e.*, u.username, u.email AS creator_email, u.full_name AS creator_name
             FROM events e
             LEFT JOIN users u ON e.user_id = u.id
             WHERE e.id = :id'
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function getPending(): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT id, user_id, title, category, start_at, location, event_image, created_at
             FROM events WHERE status = 'pending' ORDER BY created_at ASC"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Return counts of events grouped by status.
     * Returns an array like ['pending' => 3, 'active' => 12, 'rejected' => 2]
     */
    public function getStatusCounts(): array
    {
        $stmt = $this->pdo->query(
            "SELECT status, COUNT(*) AS cnt FROM events GROUP BY status"
        );
        $rows   = $stmt->fetchAll();
        $counts = ['pending' => 0, 'active' => 0, 'rejected' => 0];
        foreach ($rows as $row) {
            $counts[$row['status']] = (int) $row['cnt'];
        }
        return $counts;
    }

    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->pdo->prepare('UPDATE events SET status = :s WHERE id = :id');
        return $stmt->execute([':s' => $status, ':id' => $id]);
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO events (user_id, title, category, description, tags, start_at, location,
                                 full_address, event_image, event_type, duration, ticket_type,
                                 ticket_price, ticket_quantity, early_bird_enabled, early_bird_price,
                                 early_bird_deadline, organizer_name, organizer_email, organizer_phone,
                                 website, facebook_url, instagram_url, twitter_url, status)
             VALUES (:user_id, :title, :category, :description, :tags, :start_at, :location,
                     :full_address, :event_image, :event_type, :duration, :ticket_type,
                     :ticket_price, :ticket_quantity, :early_bird_enabled, :early_bird_price,
                     :early_bird_deadline, :organizer_name, :organizer_email, :organizer_phone,
                     :website, :facebook_url, :instagram_url, :twitter_url, :status)'
        );
        $stmt->execute([
            ':user_id'             => $data['user_id'],
            ':title'               => $data['title'],
            ':category'            => $data['category'],
            ':description'         => $data['description'],
            ':tags'                => $data['tags'] ?? null,
            ':start_at'            => $data['start_at'],
            ':location'            => $data['location'],
            ':full_address'        => $data['full_address'] ?? null,
            ':event_image'         => $data['event_image'] ?? null,
            ':event_type'          => $data['event_type'] ?? 'in-person',
            ':duration'            => $data['duration'] ?? null,
            ':ticket_type'         => $data['ticket_type'] ?? 'free',
            ':ticket_price'        => $data['ticket_price'] ?? null,
            ':ticket_quantity'     => $data['ticket_quantity'] ?? 0,
            ':early_bird_enabled'  => $data['early_bird_enabled'] ?? 0,
            ':early_bird_price'    => $data['early_bird_price'] ?? null,
            ':early_bird_deadline' => $data['early_bird_deadline'] ?? null,
            ':organizer_name'      => $data['organizer_name'] ?? null,
            ':organizer_email'     => $data['organizer_email'] ?? null,
            ':organizer_phone'     => $data['organizer_phone'] ?? null,
            ':website'             => $data['website'] ?? null,
            ':facebook_url'        => $data['facebook_url'] ?? null,
            ':instagram_url'       => $data['instagram_url'] ?? null,
            ':twitter_url'         => $data['twitter_url'] ?? null,
            ':status'              => $data['status'] ?? 'pending',
        ]);
        return (int) $this->pdo->lastInsertId();
    }
}
