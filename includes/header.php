<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../auth.php';
$user = current_user();
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<header class="site-header">
    <div class="header-inner">
        <a class="logo" href="/afro/index.php">HABESHA<span>EVENTS</span></a>

        <nav class="main-nav" id="main-nav">
            <a href="/afro/index.php" class="nav-link<?php echo $currentPage==='index.php'?' active':''; ?>">Home</a>
            <a href="/afro/events.php" class="nav-link<?php echo $currentPage==='events.php'?' active':''; ?>">Events</a>
            <a href="/afro/post-event.php" class="nav-link<?php echo $currentPage==='post-event.php'?' active':''; ?>">Post Event</a>
        </nav>

        <div class="header-right">
            <?php if ($user): ?>
                <?php
                $avatarRaw = $user['avatar'] ?? '';
                // Normalize: strip leading slash or afro/ prefix, then build correct URL
                $avatarRaw = ltrim($avatarRaw, '/');
                if ($avatarRaw && strpos($avatarRaw, 'afro/') === 0) {
                    $avatarUrl = '/' . $avatarRaw;
                } elseif ($avatarRaw) {
                    $avatarUrl = '/afro/' . $avatarRaw;
                } else {
                    $avatarUrl = null;
                }
                ?>
                <div class="profile-menu" id="profile-menu">
                    <button class="profile-trigger" id="profile-trigger" aria-expanded="false">
                        <?php if ($avatarUrl): ?>
                            <img src="<?php echo htmlspecialchars($avatarUrl); ?>" alt="avatar" class="header-avatar">
                        <?php else: ?>
                            <span class="header-initial"><?php echo strtoupper(htmlspecialchars(substr($user['username'],0,1))); ?></span>
                        <?php endif; ?>
                        <span class="profile-name"><?php echo htmlspecialchars($user['username']); ?></span>
                        <svg class="chevron" width="12" height="12" viewBox="0 0 12 12"><path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/></svg>
                    </button>
                    <div class="profile-dropdown" id="profile-dropdown">
                        <a href="/afro/profile.php" class="dropdown-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                            Edit Profile
                        </a>
                        <a href="/afro/bookings.php" class="dropdown-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                            Booking History
                        </a>
                        <?php if (($user['role'] ?? '') === 'admin'): ?>
                        <a href="/afro/admin.php" class="dropdown-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3 7h7l-5.5 4 2 7L12 16l-6.5 4 2-7L2 9h7z"/></svg>
                            Admin Panel
                        </a>
                        <?php endif; ?>
                        <div class="dropdown-divider"></div>
                        <a href="/afro/logout.php" class="dropdown-item logout-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                            Logout
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="auth-btns">
                    <a href="/afro/login.php" class="btn-nav-login">Log in</a>
                    <a href="/afro/signup.php" class="btn-nav-signup">Sign up</a>
                </div>
            <?php endif; ?>
            <button class="menu-toggle" id="menu-toggle" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</header>
<script>
(function(){
    // Mobile menu
    var toggle = document.getElementById('menu-toggle');
    var nav = document.getElementById('main-nav');
    if (toggle && nav) {
        toggle.addEventListener('click', function(){
            nav.classList.toggle('open');
            toggle.classList.toggle('open');
        });
    }
    // Profile dropdown
    var trigger = document.getElementById('profile-trigger');
    var dropdown = document.getElementById('profile-dropdown');
    if (trigger && dropdown) {
        trigger.addEventListener('click', function(e){
            e.stopPropagation();
            var open = dropdown.classList.toggle('open');
            trigger.setAttribute('aria-expanded', open);
        });
        document.addEventListener('click', function(){
            dropdown.classList.remove('open');
            trigger && trigger.setAttribute('aria-expanded','false');
        });
    }
})();
</script>
