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
