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
