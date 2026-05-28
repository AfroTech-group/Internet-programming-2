<?php
// app/controllers/ProfileController.php

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../core/Security.php';
require_once __DIR__ . '/../models/User.php';

class ProfileController
{
    private string $uploadDir;

    public function __construct()
    {
        $this->uploadDir = dirname(__DIR__, 2) . '/uploads/users/';
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    public function show(): void
    {
        require_login();
        $errors  = [];
        $success = false;
        $user    = current_user();
        include __DIR__ . '/../views/profile/show.php';
    }

    public function update(): void
    {
        require_login();

        // CSRF check
        csrf_verify();

        $userModel = new User();
        $data      = [];
        $errors    = [];
        $success   = false;

        // Full name
        $fullName = trim($_POST['full_name'] ?? '');
        if ($fullName !== '') {
            $data['full_name'] = $fullName;
        }

        // Email
        $email = trim($_POST['email'] ?? '');
        if ($email !== '') {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Invalid email address.';
            } else {
                $data['email'] = $email;
            }
        }

        // New password
        $password = $_POST['password'] ?? '';
        if ($password !== '') {
            if (strlen($password) < 6) {
                $errors[] = 'Password must be at least 6 characters.';
            } else {
                $data['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
            }
        }

        // Avatar upload
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $file    = $_FILES['avatar'];
            $finfo   = new finfo(FILEINFO_MIME_TYPE);
            $mime    = $finfo->file($file['tmp_name']);
            $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'];

            if (!isset($allowed[$mime])) {
                $errors[] = 'Avatar must be JPG, PNG, GIF or WebP.';
            } elseif ($file['size'] > 3 * 1024 * 1024) {
                $errors[] = 'Avatar must be under 3 MB.';
            } else {
                $ext      = $allowed[$mime];
                $filename = 'avatar_' . $_SESSION['user_id'] . '_' . time() . '.' . $ext;
                $target   = $this->uploadDir . $filename;
                if (move_uploaded_file($file['tmp_name'], $target)) {
                    $data['avatar'] = 'uploads/users/' . $filename;
                } else {
                    $errors[] = 'Failed to save avatar. Check folder permissions.';
                }
            }
        }

        if (empty($errors) && !empty($data)) {
            $userModel->update((int) $_SESSION['user_id'], $data);
            $success = true;
            // Bust the static cache in Auth so the new avatar shows immediately
            // (current_user() uses a static var — reset it by clearing session cache)
        }

        // Re-fetch fresh user data
        $user = $userModel->findById((int) $_SESSION['user_id']);
        include __DIR__ . '/../views/profile/show.php';
    }
}
