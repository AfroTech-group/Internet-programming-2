<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin — Users · Habesha Events</title>
    <link rel="stylesheet" href="/afro/public/css/theme.css">
    <link rel="stylesheet" href="/afro/public/css/style.css">
    <link rel="stylesheet" href="/afro/public/css/admin.css?v=2">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="admin-page">

    <!-- Admin sub-nav -->
    <nav class="admin-subnav">
        <a href="/afro/?page=admin"
           class="admin-subnav-link<?php echo ($currentPage ?? '') === 'admin' ? ' active' : ''; ?>">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            Events
        </a>
        <a href="/afro/?page=admin_users"
           class="admin-subnav-link active">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Users
        </a>
    </nav>

    <!-- Page header -->
    <div class="admin-page-header">
        <h1>
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            User Management
        </h1>
        <button class="btn-add-user" id="btn-add-user">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add User
        </button>
    </div>

    <!-- Stats -->
    <div class="admin-stats">
        <div class="stat-card">
            <span class="stat-label">Total Users</span>
            <span class="stat-value"><?php echo (int)($roleCounts['total'] ?? 0); ?></span>
        </div>
        <div class="stat-card approved">
            <span class="stat-label">Admins</span>
            <span class="stat-value"><?php echo (int)($roleCounts['admin'] ?? 0); ?></span>
        </div>
        <div class="stat-card" style="--accent:#7c3aed">
            <span class="stat-label">Organizers</span>
            <span class="stat-value" style="color:#7c3aed"><?php echo (int)($roleCounts['organizer'] ?? 0); ?></span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Regular Users</span>
            <span class="stat-value"><?php echo (int)($roleCounts['user'] ?? 0); ?></span>
        </div>
        <div class="stat-card rejected">
            <span class="stat-label">Inactive</span>
            <span class="stat-value"><?php echo (int)($roleCounts['inactive'] ?? 0); ?></span>
        </div>
    </div>

    <!-- Search & filter bar -->
    <form class="admin-filter-bar" method="get" action="/afro/">
        <input type="hidden" name="page" value="admin_users">
        <div class="admin-search-wrap">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" name="search" placeholder="Search by name, email or username…"
                   value="<?php echo htmlspecialchars($search ?? ''); ?>">
        </div>
        <select name="role">
            <option value="">All Roles</option>
            <option value="admin"     <?php echo ($role ?? '') === 'admin'     ? 'selected' : ''; ?>>Admin</option>
            <option value="organizer" <?php echo ($role ?? '') === 'organizer' ? 'selected' : ''; ?>>Organizer</option>
            <option value="user"      <?php echo ($role ?? '') === 'user'      ? 'selected' : ''; ?>>User</option>
        </select>
        <select name="status">
            <option value="">All Statuses</option>
            <option value="active"   <?php echo ($status ?? '') === 'active'   ? 'selected' : ''; ?>>Active</option>
            <option value="inactive" <?php echo ($status ?? '') === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
        </select>
        <button type="submit" class="btn-approve">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            Filter
        </button>
        <?php if (!empty($search) || !empty($role) || !empty($status)): ?>
        <a href="/afro/?page=admin_users" class="btn-view">Clear</a>
        <?php endif; ?>
    </form>

    <!-- Results count -->
    <div class="admin-results-meta">
        <span><strong><?php echo count($users); ?></strong> user<?php echo count($users) !== 1 ? 's' : ''; ?> found</span>
    </div>

    <!-- Users table -->
    <?php if (empty($users)): ?>
        <div class="admin-empty">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
            </svg>
            <h3>No users found</h3>
            <p>Try adjusting your search or filters.</p>
        </div>
    <?php else: ?>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Bookings</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                    <?php
                        $avatarRaw = ltrim($u['avatar'] ?? '', '/');
                        if ($avatarRaw && str_starts_with($avatarRaw, 'afro/')) {
                            $avatarUrl = '/' . $avatarRaw;
                        } elseif ($avatarRaw) {
                            $avatarUrl = '/afro/' . $avatarRaw;
                        } else {
                            $avatarUrl = null;
                        }
                        $initial = strtoupper(substr($u['username'], 0, 1));
                    ?>
                    <tr data-id="<?php echo (int)$u['id']; ?>">
                        <td>
                            <div class="user-cell">
                                <?php if ($avatarUrl): ?>
                                    <img src="<?php echo htmlspecialchars($avatarUrl); ?>"
                                         alt="<?php echo htmlspecialchars($u['username']); ?>"
                                         class="user-avatar-sm">
                                <?php else: ?>
                                    <span class="user-initial-sm"><?php echo $initial; ?></span>
                                <?php endif; ?>
                                <div>
                                    <div class="user-name"><?php echo htmlspecialchars($u['username']); ?></div>
                                    <?php if (!empty($u['full_name'])): ?>
                                    <div class="user-fullname"><?php echo htmlspecialchars($u['full_name']); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td class="user-email"><?php echo htmlspecialchars($u['email']); ?></td>
                        <td>
                            <span class="role-badge role-<?php echo htmlspecialchars($u['role']); ?>">
                                <?php echo ucfirst(htmlspecialchars($u['role'])); ?>
                            </span>
                        </td>
                        <td>
                            <span class="status-badge <?php echo $u['status'] === 'active' ? 'status-active' : 'status-rejected'; ?>">
                                <?php echo ucfirst(htmlspecialchars($u['status'])); ?>
                            </span>
                        </td>
                        <td class="text-center"><?php echo (int)$u['booking_count']; ?></td>
                        <td class="text-muted"><?php echo date('M j, Y', strtotime($u['created_at'])); ?></td>
                        <td>
                            <div class="table-actions">
                                <button class="btn-view btn-edit-user"
                                        data-id="<?php echo (int)$u['id']; ?>"
                                        title="Edit user">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    Edit
                                </button>
                                <?php if ((int)$u['id'] !== (int)($_SESSION['user_id'] ?? 0)): ?>
                                <button class="btn-reject btn-delete-user"
                                        data-id="<?php echo (int)$u['id']; ?>"
                                        data-name="<?php echo htmlspecialchars($u['username']); ?>"
                                        title="Delete user">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                    Delete
                                </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>

<!-- ── User Modal (Add / Edit) ── -->
<div class="admin-modal-overlay" id="user-modal-overlay" role="dialog" aria-modal="true" aria-labelledby="modal-title">
    <div class="admin-modal">
        <div class="admin-modal-header">
            <h2 id="modal-title">Add User</h2>
            <button class="admin-modal-close" id="modal-close" aria-label="Close">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <div class="admin-modal-body">
            <!-- Error box -->
            <div class="modal-errors" id="modal-errors" style="display:none"></div>

            <form id="user-form" novalidate>
                <input type="hidden" id="form-user-id" name="id" value="0">

                <div class="modal-form-grid">
                    <div class="modal-form-group">
                        <label for="f-username">Username *</label>
                        <input type="text" id="f-username" name="username" required autocomplete="off">
                    </div>
                    <div class="modal-form-group">
                        <label for="f-fullname">Full Name</label>
                        <input type="text" id="f-fullname" name="full_name" autocomplete="off">
                    </div>
                    <div class="modal-form-group">
                        <label for="f-email">Email *</label>
                        <input type="email" id="f-email" name="email" required autocomplete="off">
                    </div>
                    <div class="modal-form-group">
                        <label for="f-phone">Phone</label>
                        <input type="tel" id="f-phone" name="phone" placeholder="+251 91 234 5678">
                    </div>
                    <div class="modal-form-group">
                        <label for="f-role">Role *</label>
                        <select id="f-role" name="role">
                            <option value="user">User</option>
                            <option value="organizer">Organizer</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="modal-form-group">
                        <label for="f-status">Status *</label>
                        <select id="f-status" name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="modal-form-group modal-form-full">
                        <label for="f-password">
                            Password
                            <span id="password-hint" class="modal-hint">(leave blank to keep current)</span>
                        </label>
                        <div class="password-wrap">
                            <input type="password" id="f-password" name="password" autocomplete="new-password" placeholder="Min. 6 characters">
                            <button type="button" class="btn-toggle-pw" id="btn-toggle-pw" aria-label="Toggle password visibility">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" id="eye-icon"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="admin-modal-footer">
            <button type="button" class="btn-view" id="modal-cancel">Cancel</button>
            <button type="button" class="btn-approve-lg" id="modal-save">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                <span id="modal-save-label">Save User</span>
            </button>
        </div>
    </div>
</div>

<!-- ── Delete confirm modal ── -->
<div class="admin-modal-overlay" id="delete-modal-overlay" role="dialog" aria-modal="true">
    <div class="admin-modal admin-modal-sm">
        <div class="admin-modal-header">
            <h2>Delete User</h2>
            <button class="admin-modal-close" id="delete-modal-close" aria-label="Close">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="admin-modal-body">
            <div class="delete-confirm-icon">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#e53e3e" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <p class="delete-confirm-text">Are you sure you want to delete <strong id="delete-username"></strong>? This action cannot be undone and will remove all their bookings.</p>
        </div>
        <div class="admin-modal-footer">
            <button type="button" class="btn-view" id="delete-cancel">Cancel</button>
            <button type="button" class="btn-reject-lg" id="delete-confirm">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                Delete User
            </button>
        </div>
    </div>
</div>

<!-- Toast notification -->
<div class="admin-toast" id="admin-toast"></div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

<script>
(function () {
    'use strict';

    // CSRF token embedded server-side for all fetch() calls
    const CSRF_TOKEN = <?php echo json_encode(csrf_token()); ?>;

    // ── Helpers ──────────────────────────────────────────────
    const $  = id => document.getElementById(id);
    const qs = sel => document.querySelector(sel);

    function showToast(msg, type = 'success') {
        const t = $('admin-toast');
        t.textContent = msg;
        t.className   = 'admin-toast admin-toast-' + type + ' show';
        setTimeout(() => t.classList.remove('show'), 3500);
    }

    function openModal(id)  { $(id).classList.add('open');  document.body.style.overflow = 'hidden'; }
    function closeModal(id) { $(id).classList.remove('open'); document.body.style.overflow = ''; }

    function setLoading(btn, loading) {
        btn.disabled = loading;
        btn.style.opacity = loading ? '0.7' : '';
    }

    // ── Add user button ───────────────────────────────────────
    $('btn-add-user').addEventListener('click', () => {
        $('modal-title').textContent      = 'Add User';
        $('modal-save-label').textContent = 'Create User';
        $('form-user-id').value           = '0';
        $('password-hint').style.display  = 'none';
        $('user-form').reset();
        $('modal-errors').style.display   = 'none';
        openModal('user-modal-overlay');
        $('f-username').focus();
    });

    // ── Edit user buttons ─────────────────────────────────────
    document.querySelectorAll('.btn-edit-user').forEach(btn => {
        btn.addEventListener('click', async () => {
            const id = btn.dataset.id;
            try {
                const res  = await fetch('/afro/?page=admin_user_get&id=' + id);
                const user = await res.json();
                if (!res.ok) { showToast(user.error || 'Failed to load user.', 'error'); return; }

                $('modal-title').textContent      = 'Edit User';
                $('modal-save-label').textContent = 'Save Changes';
                $('form-user-id').value           = user.id;
                $('f-username').value             = user.username  || '';
                $('f-fullname').value             = user.full_name || '';
                $('f-email').value                = user.email     || '';
                $('f-phone').value                = user.phone     || '';
                $('f-role').value                 = user.role      || 'user';
                $('f-status').value               = user.status    || 'active';
                $('f-password').value             = '';
                $('password-hint').style.display  = '';
                $('modal-errors').style.display   = 'none';
                openModal('user-modal-overlay');
                $('f-username').focus();
            } catch (e) {
                showToast('Network error. Please try again.', 'error');
            }
        });
    });

    // ── Close modal ───────────────────────────────────────────
    ['modal-close', 'modal-cancel'].forEach(id => {
        $(id).addEventListener('click', () => closeModal('user-modal-overlay'));
    });
    $('user-modal-overlay').addEventListener('click', e => {
        if (e.target === $('user-modal-overlay')) closeModal('user-modal-overlay');
    });

    // ── Save user ─────────────────────────────────────────────
    $('modal-save').addEventListener('click', async () => {
        const saveBtn = $('modal-save');
        const errBox  = $('modal-errors');
        errBox.style.display = 'none';

        const fd = new FormData($('user-form'));
        fd.append('csrf_token', CSRF_TOKEN);
        setLoading(saveBtn, true);

        try {
            const res  = await fetch('/afro/?page=admin_user_save', { method: 'POST', body: fd });
            const data = await res.json();

            if (!res.ok || data.errors) {
                errBox.innerHTML = '<ul>' + (data.errors || [data.error]).map(e => '<li>' + e + '</li>').join('') + '</ul>';
                errBox.style.display = 'block';
            } else {
                closeModal('user-modal-overlay');
                showToast(data.message || 'Saved successfully.');
                setTimeout(() => location.reload(), 900);
            }
        } catch (e) {
            errBox.innerHTML = '<ul><li>Network error. Please try again.</li></ul>';
            errBox.style.display = 'block';
        } finally {
            setLoading(saveBtn, false);
        }
    });

    // ── Password toggle ───────────────────────────────────────
    $('btn-toggle-pw').addEventListener('click', () => {
        const inp = $('f-password');
        inp.type  = inp.type === 'password' ? 'text' : 'password';
    });

    // ── Delete buttons ────────────────────────────────────────
    let pendingDeleteId = null;

    document.querySelectorAll('.btn-delete-user').forEach(btn => {
        btn.addEventListener('click', () => {
            pendingDeleteId = btn.dataset.id;
            $('delete-username').textContent = btn.dataset.name;
            openModal('delete-modal-overlay');
        });
    });

    ['delete-modal-close', 'delete-cancel'].forEach(id => {
        $(id).addEventListener('click', () => closeModal('delete-modal-overlay'));
    });
    $('delete-modal-overlay').addEventListener('click', e => {
        if (e.target === $('delete-modal-overlay')) closeModal('delete-modal-overlay');
    });

    $('delete-confirm').addEventListener('click', async () => {
        if (!pendingDeleteId) return;
        const btn = $('delete-confirm');
        setLoading(btn, true);

        try {
            const fd = new FormData();
            fd.append('id', pendingDeleteId);
            fd.append('csrf_token', CSRF_TOKEN);
            const res  = await fetch('/afro/?page=admin_user_delete', { method: 'POST', body: fd });
            const data = await res.json();

            if (!res.ok || data.error) {
                closeModal('delete-modal-overlay');
                showToast(data.error || 'Failed to delete user.', 'error');
            } else {
                closeModal('delete-modal-overlay');
                showToast(data.message || 'User deleted.');
                // Remove row from table
                const row = document.querySelector('tr[data-id="' + pendingDeleteId + '"]');
                if (row) {
                    row.style.transition = 'opacity 0.3s, transform 0.3s';
                    row.style.opacity    = '0';
                    row.style.transform  = 'translateX(20px)';
                    setTimeout(() => row.remove(), 320);
                }
            }
        } catch (e) {
            showToast('Network error. Please try again.', 'error');
        } finally {
            setLoading(btn, false);
            pendingDeleteId = null;
        }
    });

    // ── Keyboard: Escape closes modals ────────────────────────
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            closeModal('user-modal-overlay');
            closeModal('delete-modal-overlay');
        }
    });

})();
</script>
</body>
</html>
