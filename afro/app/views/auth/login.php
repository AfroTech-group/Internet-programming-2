<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — HabeshaEvents</title>
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

        /* ── Left panel ── */
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
        .auth-panel-left .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.15;
        }
        .blob-1 { width: 300px; height: 300px; background: #00b894; top: -80px; left: -80px; }
        .blob-2 { width: 250px; height: 250px; background: #2b6cb0; bottom: -60px; right: -60px; }

        .left-content { position: relative; z-index: 1; }
        .left-logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: white;
            letter-spacing: -0.5px;
            margin-bottom: 48px;
            display: inline-block;
        }
        .left-logo span { color: #00b894; }

        .left-headline {
            font-size: 2.6rem;
            font-weight: 800;
            color: white;
            line-height: 1.15;
            margin-bottom: 20px;
            letter-spacing: -1px;
        }
        .left-headline span { color: #00b894; }

        .left-sub {
            color: rgba(255,255,255,0.6);
            font-size: 1rem;
            line-height: 1.7;
            max-width: 380px;
            margin-bottom: 48px;
        }

        .left-stats {
            display: flex;
            gap: 32px;
        }
        .stat { }
        .stat-num {
            font-size: 1.8rem;
            font-weight: 800;
            color: white;
            line-height: 1;
        }
        .stat-label {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.5);
            margin-top: 4px;
        }

        /* ── Right panel ── */
        .auth-panel-right {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
            background: #0a0f1e;
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

        .auth-box h1 {
            font-size: 1.9rem;
            font-weight: 800;
            color: white;
            margin-bottom: 6px;
            letter-spacing: -0.5px;
        }
        .auth-box .auth-sub {
            color: rgba(255,255,255,0.45);
            font-size: 0.9rem;
            margin-bottom: 32px;
        }

        .error-box {
            background: rgba(229,62,62,0.12);
            border: 1px solid rgba(229,62,62,0.3);
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 20px;
            color: #fc8181;
            font-size: 0.875rem;
        }
        .error-box p { margin: 0; }

        .success-box {
            background: rgba(0,184,148,0.12);
            border: 1px solid rgba(0,184,148,0.3);
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 20px;
            color: #68d391;
            font-size: 0.875rem;
        }

        .form-group { margin-bottom: 18px; }
        .form-group label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: rgba(255,255,255,0.5);
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 8px;
        }
        .input-wrap { position: relative; }
        .input-wrap svg {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.25);
            pointer-events: none;
        }
        .form-group input {
            width: 100%;
            padding: 13px 14px 13px 42px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            font-family: inherit;
            font-size: 0.95rem;
            color: white;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        }
        .form-group input::placeholder { color: rgba(255,255,255,0.25); }
        .form-group input:focus {
            outline: none;
            border-color: #00b894;
            background: rgba(0,184,148,0.06);
            box-shadow: 0 0 0 3px rgba(0,184,148,0.15);
        }

        .btn-auth {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #00b894, #00a085);
            color: white;
            border: none;
            border-radius: 10px;
            font-family: inherit;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 8px;
            transition: opacity 0.2s, transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 20px rgba(0,184,148,0.35);
            letter-spacing: 0.3px;
        }
        .btn-auth:hover {
            opacity: 0.92;
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(0,184,148,0.45);
        }
        .btn-auth:active { transform: translateY(0); }

        .auth-footer-link {
            text-align: center;
            margin-top: 24px;
            font-size: 0.875rem;
            color: rgba(255,255,255,0.4);
        }
        .auth-footer-link a {
            color: #00b894;
            font-weight: 600;
            text-decoration: none;
        }
        .auth-footer-link a:hover { text-decoration: underline; }

        /* Mobile */
        @media (max-width: 768px) {
            body { grid-template-columns: 1fr; }
            .auth-panel-left { display: none; }
            .auth-panel-right { background: linear-gradient(145deg, #0d1b2a, #0a0f1e); min-height: 100vh; }
        }
    </style>
</head>
<body>

<!-- Left decorative panel -->
<div class="auth-panel-left">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="left-content">
        <a class="left-logo" href="/afro/">HABESHA<span>EVENTS</span></a>
        <h1 class="left-headline">Ethiopia's <span>premier</span> event platform</h1>
        <p class="left-sub">Discover concerts, festivals, workshops and cultural celebrations happening across Ethiopia — all in one place.</p>
        <div class="left-stats">
            <div class="stat"><div class="stat-num">500+</div><div class="stat-label">Events Listed</div></div>
            <div class="stat"><div class="stat-num">12K+</div><div class="stat-label">Happy Attendees</div></div>
            <div class="stat"><div class="stat-num">50+</div><div class="stat-label">Cities</div></div>
        </div>
    </div>
</div>

<!-- Right form panel -->
<div class="auth-panel-right">
    <div class="auth-box">
        <h1>Welcome back</h1>
        <p class="auth-sub">Sign in to your account to continue</p>

        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <?php foreach ($errors as $e): ?>
                    <p><?php echo htmlspecialchars($e); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="/afro/?page=login" novalidate>
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-wrap">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                    <input type="text" id="username" name="username" required autocomplete="username"
                           placeholder="your_username"
                           value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <input type="password" id="password" name="password" required autocomplete="current-password"
                           placeholder="••••••••">
                </div>
            </div>

            <button type="submit" class="btn-auth">Sign In</button>
        </form>

        <p class="auth-footer-link">
            Don't have an account? <a href="/afro/?page=register">Create one</a>
        </p>
    </div>
</div>

</body>
</html>
