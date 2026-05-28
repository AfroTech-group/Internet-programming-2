<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile — HabeshaEvents</title>
    <link rel="stylesheet" href="/afro/public/css/theme.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: Inter, system-ui, sans-serif; background: var(--bg, #f7f8fc); }

        .profile-wrap {
            max-width: 680px;
            margin: 0 auto;
            padding: 40px 20px 80px;
        }

        /* ── Hero banner ── */
        .profile-hero {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 32px;
            background: linear-gradient(135deg, #0d1b2a 0%, #1a3a5c 60%, #0d2137 100%);
            padding: 36px 32px 32px;
        }
        .profile-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 70% 60% at 10% 20%, rgba(0,184,148,0.2) 0%, transparent 60%),
                radial-gradient(ellipse 50% 70% at 90% 80%, rgba(43,108,176,0.2) 0%, transparent 60%);
            pointer-events: none;
        }
        .hero-inner { position: relative; z-index: 1; display: flex; align-items: center; gap: 24px; flex-wrap: wrap; }

        /* Avatar */
        .avatar-zone { position: relative; flex-shrink: 0; }
        .avatar-img, .avatar-initial {
            width: 88px; height: 88px; border-radius: 50%;
            border: 3px solid rgba(255,255,255,0.25);
            object-fit: cover;
        }
        .avatar-initial {
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #00b894, #2b6cb0);
            font-size: 2.2rem; font-weight: 800; color: white;
        }
        .avatar-edit-btn {
            position: absolute; bottom: 0; right: 0;
            width: 28px; height: 28px; border-radius: 50%;
            background: #00b894; border: 2px solid white;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: background 0.2s, transform 0.2s;
        }
        .avatar-edit-btn:hover { background: #00a085; transform: scale(1.1); }
        .avatar-edit-btn svg { color: white; }
        #avatar-file-input { display: none; }

        .hero-info { flex: 1; min-width: 0; }
        .hero-info h1 { font-size: 1.6rem; font-weight: 800; color: white; margin-bottom: 4px; letter-spacing: -0.5px; }
        .hero-info .hero-username { color: rgba(255,255,255,0.5); font-size: 0.9rem; margin-bottom: 12px; }
        .hero-info .hero-role {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(0,184,148,0.2); border: 1px solid rgba(0,184,148,0.35);
            color: #68d391; font-size: 0.78rem; font-weight: 600;
            padding: 3px 10px; border-radius: 50px; text-transform: capitalize;
        }

        .hero-actions { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 4px; }
        .btn-bookings {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 20px; border-radius: 10px;
            background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);
            color: white; font-family: inherit; font-size: 0.875rem; font-weight: 600;
            cursor: pointer; text-decoration: none;
            transition: background 0.2s, border-color 0.2s, transform 0.2s;
        }
        .btn-bookings:hover { background: rgba(255,255,255,0.18); border-color: rgba(255,255,255,0.35); transform: translateY(-2px); }

        /* ── Form card ── */
        .form-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }
        .form-card-title {
            font-size: 1.1rem; font-weight: 700; color: #1a202c;
            margin-bottom: 24px; padding-bottom: 16px;
            border-bottom: 1px solid #e2e8f0;
            display: flex; align-items: center; gap: 10px;
        }
        .form-card-title svg { color: #00b894; }

        .alert {
            border-radius: 10px; padding: 12px 16px; margin-bottom: 20px; font-size: 0.875rem;
        }
        .alert-error { background: #fff5f5; border: 1px solid #fed7d7; color: #c53030; }
        .alert-success { background: #f0fff4; border: 1px solid #9ae6b4; color: #276749; }
        .alert p { margin: 0; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
        .form-group { margin-bottom: 0; }
        .form-group.full { grid-column: 1 / -1; }

        .form-group label {
            display: block; font-size: 0.8rem; font-weight: 600;
            color: #4a5568; margin-bottom: 7px; text-transform: uppercase; letter-spacing: 0.4px;
        }
        .form-group .hint { font-size: 0.75rem; color: #a0aec0; margin-top: 5px; }

        .input-wrap { position: relative; }
        .input-wrap svg {
            position: absolute; left: 12px; top: 50%;
            transform: translateY(-50%); color: #a0aec0; pointer-events: none;
        }
        .form-group input {
            width: 100%; padding: 11px 12px 11px 38px;
            border: 1.5px solid #e2e8f0; border-radius: 10px;
            font-family: inherit; font-size: 0.9rem; color: #1a202c;
            background: #f7f8fc;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .form-group input:focus {
            outline: none; border-color: #00b894;
            box-shadow: 0 0 0 3px rgba(0,184,148,0.12); background: white;
        }
        .form-group input:disabled {
            background: #edf2f7; color: #718096; cursor: not-allowed;
        }

        /* Avatar preview inside form */
        .avatar-preview-row {
            display: flex; align-items: center; gap: 16px;
            padding: 14px; background: #f7f8fc; border-radius: 10px;
            border: 1.5px dashed #e2e8f0; cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
        }
        .avatar-preview-row:hover { border-color: #00b894; background: #f0fff4; }
        .avatar-preview-row img,
        .avatar-preview-row .avatar-preview-initial {
            width: 52px; height: 52px; border-radius: 50%; object-fit: cover;
            border: 2px solid #e2e8f0; flex-shrink: 0;
        }
        .avatar-preview-row .avatar-preview-initial {
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #00b894, #2b6cb0);
            font-size: 1.3rem; font-weight: 700; color: white;
        }
        .avatar-preview-text strong { display: block; font-size: 0.875rem; font-weight: 600; color: #1a202c; }
        .avatar-preview-text span { font-size: 0.78rem; color: #a0aec0; }

        .divider { height: 1px; background: #e2e8f0; margin: 24px 0; grid-column: 1 / -1; }

        .section-label {
            grid-column: 1 / -1;
            font-size: 0.78rem; font-weight: 700; color: #a0aec0;
            text-transform: uppercase; letter-spacing: 0.6px;
            display: flex; align-items: center; gap: 8px;
        }
        .section-label::after { content: ''; flex: 1; height: 1px; background: #e2e8f0; }

        .btn-save {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 12px 28px; background: linear-gradient(135deg, #00b894, #00a085);
            color: white; border: none; border-radius: 10px;
            font-family: inherit; font-size: 0.9rem; font-weight: 700;
            cursor: pointer; margin-top: 24px;
            transition: opacity 0.2s, transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 16px rgba(0,184,148,0.3);
        }
        .btn-save:hover { opacity: 0.92; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,184,148,0.4); }

        @media (max-width: 600px) {
            .form-grid { grid-template-columns: 1fr; }
            .form-group.full { grid-column: 1; }
            .profile-hero { padding: 24px 20px; }
            .form-card { padding: 20px; }
        }
    </style>
</head>
<body>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="profile-wrap">

    <!-- Hero banner -->
    <div class="profile-hero">
        <div class="hero-inner">
            <!-- Avatar with edit button -->
            <div class="avatar-zone">
                <?php
                $avatarRaw = ltrim($user['avatar'] ?? '', '/');
                if ($avatarRaw && str_starts_with($avatarRaw, 'afro/')) {
                    $avatarUrl = '/' . $avatarRaw;
                } elseif ($avatarRaw) {
                    $avatarUrl = '/afro/' . $avatarRaw;
                } else {
                    $avatarUrl = null;
                }
                ?>
                <?php if ($avatarUrl): ?>
                    <img src="<?php echo htmlspecialchars($avatarUrl); ?>" alt="avatar" class="avatar-img" id="hero-avatar">
                <?php else: ?>
                    <div class="avatar-initial" id="hero-avatar-initial">
                        <?php echo strtoupper(htmlspecialchars(substr($user['username'] ?? 'U', 0, 1))); ?>
                    </div>
                <?php endif; ?>
                <label class="avatar-edit-btn" for="avatar-file-input" title="Change photo">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </label>
            </div>

            <div class="hero-info">
                <h1><?php echo htmlspecialchars($user['full_name'] ?: $user['username']); ?></h1>
                <p class="hero-username">@<?php echo htmlspecialchars($user['username']); ?></p>
                <span class="hero-role">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2l3 7h7l-5.5 4 2 7L12 16l-6.5 4 2-7L2 9h7z"/></svg>
                    <?php echo htmlspecialchars($user['role'] ?? 'user'); ?>
                </span>
            </div>

            <div class="hero-actions">
                <a href="/afro/?page=bookings" class="btn-bookings">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                    Booking History
                </a>
            </div>
        </div>
    </div>

    <!-- Edit form -->
    <div class="form-card">
        <div class="form-card-title">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Edit Profile
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $e): ?><p><?php echo htmlspecialchars($e); ?></p><?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><p>Profile updated successfully!</p></div>
        <?php endif; ?>

        <form method="post" action="/afro/?page=profile" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="form-grid">

                <!-- Profile photo -->
                <div class="form-group full">
                    <label>Profile Photo</label>
                    <label class="avatar-preview-row" for="avatar-file-input">
                        <?php if ($avatarUrl): ?>
                            <img src="<?php echo htmlspecialchars($avatarUrl); ?>" alt="avatar" id="avatar-preview-img">
                        <?php else: ?>
                            <div class="avatar-preview-initial" id="avatar-preview-initial">
                                <?php echo strtoupper(htmlspecialchars(substr($user['username'] ?? 'U', 0, 1))); ?>
                            </div>
                        <?php endif; ?>
                        <div class="avatar-preview-text">
                            <strong id="avatar-filename">Click to upload a new photo</strong>
                            <span>JPG, PNG, GIF or WebP — max 3 MB</span>
                        </div>
                    </label>
                    <input type="file" id="avatar-file-input" name="avatar" accept="image/*">
                </div>

                <!-- Username (read-only) -->
                <div class="form-group">
                    <label>Username</label>
                    <div class="input-wrap">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                        <input type="text" value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" disabled>
                    </div>
                    <p class="hint">Username cannot be changed</p>
                </div>

                <!-- Full name -->
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <div class="input-wrap">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <input type="text" id="full_name" name="full_name"
                               placeholder="Abebe Girma"
                               value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>">
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group full">
                    <label for="email">Email Address</label>
                    <div class="input-wrap">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <input type="email" id="email" name="email"
                               placeholder="you@example.com"
                               value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">
                    </div>
                </div>

                <div class="section-label">Change Password</div>

                <!-- New password -->
                <div class="form-group full">
                    <label for="password">New Password</label>
                    <div class="input-wrap">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <input type="password" id="password" name="password"
                               placeholder="Leave blank to keep current password">
                    </div>
                    <p class="hint">Minimum 6 characters</p>
                </div>

            </div>

            <button type="submit" class="btn-save">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Save Changes
            </button>
        </form>
    </div>
</div>

<script>
// Live avatar preview
document.getElementById('avatar-file-input').addEventListener('change', function () {
    var file = this.files[0];
    if (!file) return;
    document.getElementById('avatar-filename').textContent = file.name;
    var reader = new FileReader();
    reader.onload = function (e) {
        // Update hero avatar
        var heroImg = document.getElementById('hero-avatar');
        var heroInit = document.getElementById('hero-avatar-initial');
        if (heroImg) { heroImg.src = e.target.result; }
        else if (heroInit) {
            var img = document.createElement('img');
            img.src = e.target.result; img.className = 'avatar-img'; img.id = 'hero-avatar';
            heroInit.replaceWith(img);
        }
        // Update form preview
        var prevImg = document.getElementById('avatar-preview-img');
        var prevInit = document.getElementById('avatar-preview-initial');
        if (prevImg) { prevImg.src = e.target.result; }
        else if (prevInit) {
            var img2 = document.createElement('img');
            img2.src = e.target.result; img2.alt = 'avatar'; img2.id = 'avatar-preview-img';
            img2.style.cssText = 'width:52px;height:52px;border-radius:50%;object-fit:cover;border:2px solid #e2e8f0;flex-shrink:0';
            prevInit.replaceWith(img2);
        }
    };
    reader.readAsDataURL(file);
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
</body>
</html>
