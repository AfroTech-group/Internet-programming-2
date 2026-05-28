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
