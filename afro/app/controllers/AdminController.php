<?php
// app/controllers/AdminController.php

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../models/Event.php';
require_once __DIR__ . '/../models/User.php';

class AdminController
{
    private Event $eventModel;
    private User  $userModel;

    public function __construct()
    {
        $this->eventModel = new Event();
        $this->userModel  = new User();
    }

    // ─────────────────────────────────────────────
    //  EVENT MANAGEMENT
    // ─────────────────────────────────────────────

    /** Admin dashboard — list pending events. */
    public function index(): void
    {
        require_admin();
        $pending       = [];
        $approvedCount = 0;
        $rejectedCount = 0;
        try {
            $pending       = $this->eventModel->getPending();
            $counts        = $this->eventModel->getStatusCounts();
            $approvedCount = $counts['active']   ?? 0;
            $rejectedCount = $counts['rejected'] ?? 0;
        } catch (Exception $e) {
            error_log('AdminController::index - ' . $e->getMessage());
        }
        include __DIR__ . '/../views/admin/index.php';
    }

    /** Show a single event for admin review. */
    public function show(): void
    {
        require_admin();
        $eventId = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($eventId <= 0) {
            header('Location: /afro/?page=admin');
            exit;
        }

        $event = null;
        try {
            $event = $this->eventModel->findByIdAdmin($eventId);
            if (!$event) {
                header('Location: /afro/?page=admin');
                exit;
            }
        } catch (Exception $e) {
            error_log('AdminController::show - ' . $e->getMessage());
        }

        include __DIR__ . '/../views/admin/show.php';
    }

    /** Handle approve / reject POST action. */
    public function action(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Method not allowed';
            exit;
        }

        require_admin();

        // CSRF check
        require_once __DIR__ . '/../core/Security.php';
        csrf_verify();

        $eventId = isset($_POST['event_id']) ? intval($_POST['event_id']) : 0;
        $action  = $_POST['action'] ?? '';

        if ($eventId <= 0 || !in_array($action, ['approve', 'reject'], true)) {
            http_response_code(400);
            echo 'Bad request';
            exit;
        }

        try {
            $status = $action === 'approve' ? 'active' : 'rejected';
            $this->eventModel->updateStatus($eventId, $status);
            header('Location: /afro/?page=admin');
            exit;
        } catch (Exception $e) {
            error_log('AdminController::action - ' . $e->getMessage());
            http_response_code(500);
            echo 'Server error';
        }
    }

    // ─────────────────────────────────────────────
    //  USER MANAGEMENT
    // ─────────────────────────────────────────────

    /** List all users with search / filter. */
    public function users(): void
    {
        require_admin();

        $search = trim($_GET['search'] ?? '');
        $role   = $_GET['role']   ?? '';
        $status = $_GET['status'] ?? '';

        $users      = [];
        $roleCounts = ['total' => 0, 'admin' => 0, 'organizer' => 0, 'user' => 0, 'inactive' => 0];

        try {
            $users      = $this->userModel->getAll($search, $role, $status);
            $roleCounts = $this->userModel->getRoleCounts();
        } catch (Exception $e) {
            error_log('AdminController::users - ' . $e->getMessage());
        }

        include __DIR__ . '/../views/admin/users.php';
    }

    /** Return a single user as JSON (for the edit modal). */
    public function userGet(): void
    {
        require_admin();
        header('Content-Type: application/json');

        $id   = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $user = $id > 0 ? $this->userModel->findById($id) : null;

        if (!$user) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
            exit;
        }

        // Never expose password hash
        unset($user['password_hash']);
        echo json_encode($user);
    }

    /** Create or update a user via POST (handles both add & edit). */
    public function userSave(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }
        require_admin();
        header('Content-Type: application/json');

        // CSRF check (API variant returns JSON on failure)
        require_once __DIR__ . '/../core/Security.php';
        csrf_verify_api();

        $id       = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $username = trim($_POST['username'] ?? '');
        $email    = trim($_POST['email']    ?? '');
        $fullName = trim($_POST['full_name'] ?? '');
        $phone    = trim($_POST['phone']    ?? '');
        $role     = $_POST['role']   ?? 'user';
        $status   = $_POST['status'] ?? 'active';
        $password = $_POST['password'] ?? '';

        // Basic validation
        $errors = [];
        if ($username === '')  $errors[] = 'Username is required.';
        if ($email    === '')  $errors[] = 'Email is required.';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email address.';
        if (!in_array($role,   ['user','organizer','admin'], true)) $errors[] = 'Invalid role.';
        if (!in_array($status, ['active','inactive'],        true)) $errors[] = 'Invalid status.';
        if ($id === 0 && $password === '') $errors[] = 'Password is required for new users.';
        if ($password !== '' && strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';

        if ($id === 0) {
            if ($this->userModel->emailTaken($email))       $errors[] = 'Email is already in use.';
            if ($this->userModel->usernameTaken($username)) $errors[] = 'Username is already taken.';
        } else {
            if ($this->userModel->emailTaken($email, $id))       $errors[] = 'Email is already in use.';
            if ($this->userModel->usernameTaken($username, $id)) $errors[] = 'Username is already taken.';
        }

        if ($errors) {
            http_response_code(422);
            echo json_encode(['errors' => $errors]);
            exit;
        }

        try {
            $data = [
                'username'  => $username,
                'email'     => $email,
                'full_name' => $fullName,
                'phone'     => $phone,
                'role'      => $role,
                'status'    => $status,
            ];

            if ($password !== '') {
                $data['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
            }

            if ($id === 0) {
                // Create
                $newId = $this->userModel->create([
                    'username'  => $username,
                    'email'     => $email,
                    'password'  => password_hash($password, PASSWORD_DEFAULT),
                    'full_name' => $fullName,
                    'phone'     => $phone,
                    'role'      => $role,
                    'status'    => $status,
                ]);
                echo json_encode(['success' => true, 'id' => $newId, 'message' => 'User created successfully.']);
            } else {
                // Update
                $this->userModel->update($id, $data);
                echo json_encode(['success' => true, 'id' => $id, 'message' => 'User updated successfully.']);
            }
        } catch (Exception $e) {
            error_log('AdminController::userSave - ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['errors' => ['Server error. Please try again.']]);
        }
    }

    /** Delete a user via POST. */
    public function userDelete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }
        require_admin();
        header('Content-Type: application/json');

        // CSRF check (API variant returns JSON on failure)
        require_once __DIR__ . '/../core/Security.php';
        csrf_verify_api();

        $id      = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $current = current_user();

        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid user ID.']);
            exit;
        }

        if ((int)($current['id'] ?? 0) === $id) {
            http_response_code(400);
            echo json_encode(['error' => 'You cannot delete your own account.']);
            exit;
        }

        try {
            $this->userModel->delete($id);
            echo json_encode(['success' => true, 'message' => 'User deleted.']);
        } catch (Exception $e) {
            error_log('AdminController::userDelete - ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Server error. Please try again.']);
        }
    }
}
