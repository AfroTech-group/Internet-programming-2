<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — HabeshaEvents</title>
    <link rel="stylesheet" href="/afro/public/css/theme.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Inter, system-ui, sans-serif;
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: #0a0f1e;
        }

        .auth-panel-left {
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 56px;
            background: linear-gradient(145deg, #0d1b2a 0%, #1a3a5c 50%, #0d2137 100%);
        }
        .auth-panel-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 60% 50% at 20% 30%, rgba(0,184,148,0.18) 0%, transparent 70%),
                radial-gradient(ellipse 50% 60% at 80% 70%, rgba(43,108,176,0.2) 0%, transparent 70%);
        }
        .blob { position: absolute; border-radius: 50%; filter: blur(60px); opacity: 0.15; }
        .blob-1 { width: 300px; height: 300px; background: #00b894; top: -80px; left: -80px; }
        .blob-2 { width: 250px; height: 250px; background: #2b6cb0; bottom: -60px; right: -60px; }

        .left-content { position: relative; z-index: 1; }
        .left-logo { font-size: 1.5rem; font-weight: 800; color: white; letter-spacing: -0.5px; margin-bottom: 48px; display: inline-block; }
        .left-logo span { color: #00b894; }
        .left-headline { font-size: 2.4rem; font-weight: 800; color: white; line-height: 1.15; margin-bottom: 20px; letter-spacing: -1px; }
        .left-headline span { color: #00b894; }
        .left-sub { color: rgba(255,255,255,0.6); font-size: 1rem; line-height: 1.7; max-width: 380px; margin-bottom: 40px; }

        .perks { display: flex; flex-direction: column; gap: 16px; }
        .perk { display: flex; align-items: center; gap: 14px; }
        .perk-icon {
            width: 40px; height: 40px; border-radius: 10px;
            background: rgba(0,184,148,0.15);
            border: 1px solid rgba(0,184,148,0.25);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
.perk-icon svg { color: #00b894; }
        .perk-text { font-size: 0.9rem; color: rgba(255,255,255,0.7); }
        .perk-text strong { color: white; display: block; font-size: 0.95rem; }

        .auth-panel-right {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
            background: #0a0f1e;
            overflow-y: auto;
        }

        .auth-box {
            width: 100%;
            max-width: 420px;
            animation: authPop 0.5s cubic-bezier(0.34,1.56,0.64,1) both;
        }
        @keyframes authPop {
            from { opacity: 0; transform: translateY(24px) scale(0.96); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .auth-box h1 { font-size: 1.9rem; font-weight: 800; color: white; margin-bottom: 6px; letter-spacing: -0.5px; }
        .auth-sub { color: rgba(255,255,255,0.45); font-size: 0.9rem; margin-bottom: 28px; }

        .error-box {
            background: rgba(229,62,62,0.12); border: 1px solid rgba(229,62,62,0.3);
            border-radius: 10px; padding: 12px 16px; margin-bottom: 20px;
            color: #fc8181; font-size: 0.875rem;
        }
        .error-box p { margin: 0; }

        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

        .form-group { margin-bottom: 16px; }
        .form-group label {
            display: block; font-size: 0.78rem; font-weight: 600;
            color: rgba(255,255,255,0.5); text-transform: uppercase;
            letter-spacing: 0.6px; margin-bottom: 8px;
        }
        .input-wrap { position: relative; }
        .input-wrap svg {
            position: absolute; left: 14px; top: 50%;
            transform: translateY(-50%); color: rgba(255,255,255,0.25); pointer-events: none;
        }
        .form-group input {
            width: 100%; padding: 12px 14px 12px 42px;
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px; font-family: inherit; font-size: 0.9rem; color: white;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        }
        .form-group input::placeholder { color: rgba(255,255,255,0.25); }
        .form-group input:focus {
            outline: none; border-color: #00b894;
            background: rgba(0,184,148,0.06); box-shadow: 0 0 0 3px rgba(0,184,148,0.15);
        }
        .hint { font-size: 0.75rem; color: rgba(255,255,255,0.3); margin-top: 5px; }
.btn-auth {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, #00b894, #00a085);
            color: white; border: none; border-radius: 10px;
            font-family: inherit; font-size: 1rem; font-weight: 700;
            cursor: pointer; margin-top: 8px;
            transition: opacity 0.2s, transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 20px rgba(0,184,148,0.35); letter-spacing: 0.3px;
        }
        .btn-auth:hover { opacity: 0.92; transform: translateY(-2px); box-shadow: 0 8px 28px rgba(0,184,148,0.45); }
        .btn-auth:active { transform: translateY(0); }

        .auth-footer-link { text-align: center; margin-top: 20px; font-size: 0.875rem; color: rgba(255,255,255,0.4); }
        .auth-footer-link a { color: #00b894; font-weight: 600; text-decoration: none; }
        .auth-footer-link a:hover { text-decoration: underline; }

        @media (max-width: 768px) {
            body { grid-template-columns: 1fr; }
            .auth-panel-left { display: none; }
            .auth-panel-right { background: linear-gradient(145deg, #0d1b2a, #0a0f1e); min-height: 100vh; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="auth-panel-left">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="left-content">
        <a class="left-logo" href="/afro/">HABESHA<span>EVENTS</span></a>
        <h1 class="left-headline">Join the <span>community</span> today</h1>
        <p class="left-sub">Create your free account and start discovering amazing Ethiopian events near you.</p>
        <div class="perks">
            <div class="perk">
                <div class="perk-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
                <div class="perk-text"><strong>Free to join</strong>No subscription fees, ever</div>
            </div>
            <div class="perk">
                <div class="perk-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 12V22H4V12"/><path d="M22 7H2v5h20V7z"/><path d="M12 22V7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/></svg></div>
                <div class="perk-text"><strong>Book tickets instantly</strong>Secure your spot in seconds</div>
            </div>
            <div class="perk">
                <div class="perk-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                <div class="perk-text"><strong>Never miss an event</strong>Get notified about upcoming events</div>
            </div>
        </div>
    </div>
</div>

<div class="auth-panel-right">
    <div class="auth-box">
        <h1>Create account</h1>
        <p class="auth-sub">Fill in the details below to get started</p>

        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <?php foreach ($errors as $e): ?>
                    <p><?php echo htmlspecialchars($e); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="/afro/?page=register" novalidate>
            <?php echo csrf_field(); ?>
            <div class="form-row">
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-wrap">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                        <input type="text" id="username" name="username" required autocomplete="username"
                               placeholder="cooluser123"
                               value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrap">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <input type="email" id="email" name="email" required autocomplete="email"
                               placeholder="you@example.com"
                               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="full_name">Full Name <span style="color:rgba(255,255,255,0.25);font-weight:400">(optional)</span></label>
                <div class="input-wrap">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <input type="text" id="full_name" name="full_name" autocomplete="name"
                           placeholder="Abebe Girma"
                           value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <input type="password" id="password" name="password" required autocomplete="new-password"
                           placeholder="Min. 6 characters">
                </div>
                <p class="hint">At least 6 characters</p>
            </div>

            <button type="submit" class="btn-auth">Create Account</button>
        </form>

        <p class="auth-footer-link">
            Already have an account? <a href="/afro/?page=login">Sign in</a>
        </p>
    </div>
</div>

</body>
</html>
