<?php
require_once __DIR__ . '/auth.php';
require_login();
$user = current_user();

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $phone     = trim($_POST['phone'] ?? '');
    $avatar_path = null;

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $file  = $_FILES['avatar'];
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime  = $finfo->file($file['tmp_name']);
        $allowed = ['image/jpeg'=>'jpg','image/png'=>'png','image/gif'=>'gif','image/webp'=>'webp'];
        if (!isset($allowed[$mime])) {
            $errors[] = 'Avatar must be JPG/PNG/GIF/WEBP';
        } elseif ($file['size'] > 2*1024*1024) {
            $errors[] = 'Avatar must be under 2MB';
        } else {
            $ext    = $allowed[$mime];
            $fn     = 'avatar_' . $user['id'] . '_' . time() . '.' . $ext;
            $target = __DIR__ . '/uploads/users/' . $fn;
            if (!is_dir(__DIR__ . '/uploads/users/')) mkdir(__DIR__ . '/uploads/users/', 0755, true);
            if (move_uploaded_file($file['tmp_name'], $target)) {
                $avatar_path = 'uploads/users/' . $fn;
            } else {
                $errors[] = 'Failed to save avatar — check folder permissions';
            }
        }
    }

    if (empty($errors)) {
        $sql = 'UPDATE users SET full_name=:fn, phone=:ph' . ($avatar_path ? ', avatar=:av' : '') . ' WHERE id=:id';
        $stmt = $pdo->prepare($sql);
        $params = [':fn'=>$full_name, ':ph'=>$phone, ':id'=>$user['id']];
        if ($avatar_path) $params[':av'] = $avatar_path;
        $stmt->execute($params);
        $success = true;
        header('Location: /afro/profile.php?tab=profile&saved=1');
        exit;
    }
}

// Reload user
$stmt = $pdo->prepare('SELECT id, username, email, full_name, phone, avatar FROM users WHERE id=:id LIMIT 1');
$stmt->execute([':id' => $user['id']]);
$user = $stmt->fetch();

// Bookings
$bookings = [];
try {
    $bs = $pdo->prepare("SELECT b.booking_reference, b.quantity, b.unit_price, b.total_amount, b.payment_status, b.booking_status, b.created_at, b.event_id, e.title AS event_title, e.start_at AS event_start FROM bookings b LEFT JOIN events e ON b.event_id=e.id WHERE b.user_id=:uid ORDER BY b.created_at DESC");
    $bs->execute([':uid' => $user['id']]);
    $bookings = $bs->fetchAll();
} catch (Exception $e) { error_log('profile bookings: ' . $e->getMessage()); }

// Avatar URL helper
$avatarRaw = $user['avatar'] ?? '';
$avatarRaw = ltrim($avatarRaw, '/');
if ($avatarRaw && strpos($avatarRaw, 'afro/') === 0) {
    $avatarUrl = '/' . $avatarRaw;
} elseif ($avatarRaw) {
    $avatarUrl = '/afro/' . $avatarRaw;
} else {
    $avatarUrl = null;
}

$activeTab = $_GET['tab'] ?? 'profile';
$saved = isset($_GET['saved']);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
 <link rel="stylesheet" href="/afro/theme.css">
</head>
<body>
 <?php require_once __DIR__ . '/includes/header.php'; ?>
<div class="profile-page">
    <div class="profile-hero">
    <div class="profile-avatar-wrap">
            <?php if ($avatarUrl): ?>
                <img src="<?php echo htmlspecialchars($avatarUrl); ?>" alt="avatar" class="profile-avatar-img" style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid rgba(255,255,255,0.5)">
            <?php else: ?>
                <div class="profile-avatar-initial"><?php echo strtoupper(htmlspecialchars(substr($user['username'],0,1))); ?></div>
            <?php endif; ?>
        </div>
        <div class="profile-hero-info">
            <h1><?php echo htmlspecialchars($user['username']); ?></h1>
            <p><?php echo htmlspecialchars($user['email']); ?></p>
            <?php if (!empty($user['full_name'])): ?>
                <p style="opacity:0.7;font-size:0.85rem;margin-top:2px"><?php echo htmlspecialchars($user['full_name']); ?></p>
            <?php endif; ?>
        </div>
    </div>
     <div class="profile-tabs">
        <button class="tab-btn <?php echo $activeTab==='profile'?'active':''; ?>" data-tab="profile">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
            Edit Profile
        </button>
        <button class="tab-btn <?php echo $activeTab==='bookings'?'active':''; ?>" data-tab="bookings">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
            Booking History
            <?php if (count($bookings)): ?><span style="background:var(--green);color:white;border-radius:50px;padding:1px 7px;font-size:0.75rem;margin-left:4px"><?php echo count($bookings); ?></span><?php endif; ?>
        </button>
    </div>
    </div>  

<script>
// Tab switching
document.querySelectorAll('.tab-btn').forEach(function(btn){
    btn.addEventListener('click', function(){
        var tab = this.dataset.tab;
        document.querySelectorAll('.tab-btn').forEach(function(b){ b.classList.remove('active'); });
        document.querySelectorAll('.tab-panel').forEach(function(p){ p.classList.remove('active'); });
        this.classList.add('active');
        document.getElementById('panel-' + tab).classList.add('active');
        history.replaceState(null,'','/afro/profile.php?tab=' + tab);
    });
});

// Avatar live preview
document.getElementById('avatar-input') && document.getElementById('avatar-input').addEventListener('change', function(){
    var file = this.files[0];
    if (!file) return;
    var reader = new FileReader();
    reader.onload = function(e){
        var prev = document.getElementById('avatar-preview');
        var init = document.getElementById('avatar-preview-initial');
        if (prev) {
            prev.src = e.target.result;
        } else if (init) {
            var img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'avatar-preview';
            img.id = 'avatar-preview';
            img.alt = 'avatar';
            init.replaceWith(img);
        }
    };
    reader.readAsDataURL(file);
});
</script>
</body>
</html>
