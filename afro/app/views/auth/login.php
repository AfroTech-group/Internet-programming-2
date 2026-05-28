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
