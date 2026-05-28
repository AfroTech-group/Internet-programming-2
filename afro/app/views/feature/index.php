<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Features - Habesha Events</title>
    <link rel="stylesheet" href="/afro/public/css/theme.css">
    <link rel="stylesheet" href="/afro/public/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --green: #00b894;
            --green-dark: #00a085;
            --blue: #2b6cb0;
            --text: #1a202c;
            --muted: #718096;
            --border: #e2e8f0;
            --bg: #f7f8fc;
        }
        * { box-sizing: border-box; }
        body { font-family: 'Inter', system-ui, sans-serif; color: var(--text); background: var(--bg); }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(22px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes blobFloat {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-22px); }
        }

        /* ── HERO ── */
        .features-hero {
            position: relative;
            padding: 90px 20px 80px;
            background: linear-gradient(135deg, #0d1b2a 0%, #1a3a5c 55%, #0d2137 100%);
            overflow: hidden;
            text-align: center;
        }
        .features-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 55% 60% at 15% 50%, rgba(0,184,148,0.15) 0%, transparent 70%),
                radial-gradient(ellipse 45% 55% at 85% 50%, rgba(43,108,176,0.15) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            opacity: 0.2;
            animation: blobFloat 7s ease-in-out infinite;
        }
        .hero-blob-1 { width: 380px; height: 380px; background: #00b894; top: -100px; left: -80px; }
        .hero-blob-2 { width: 300px; height: 300px; background: #2b6cb0; bottom: -80px; right: -60px; animation-delay: 3.5s; }

        .features-hero-content { position: relative; z-index: 1; animation: fadeUp 0.7s ease both; max-width: 760px; margin: 0 auto; }

        .section-label {
            display: inline-block;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: var(--green);
            background: rgba(0,184,148,0.12);
            border: 1px solid rgba(0,184,148,0.3);
            padding: 5px 16px;
            border-radius: 50px;
            margin-bottom: 18px;
        }
        .features-hero h1 { font-size: clamp(1.8rem, 4.5vw, 3rem); font-weight: 800; color: #fff; margin-bottom: 14px; letter-spacing: -0.5px; line-height: 1.2; }
        .features-hero p  { font-size: 1rem; color: rgba(255,255,255,0.65); margin-bottom: 32px; line-height: 1.7; }

        /* Search */
        .features-search { margin-bottom: 32px; }
        .search-container {
            display: flex;
            align-items: center;
            background: rgba(255,255,255,0.1);
            border: 1.5px solid rgba(255,255,255,0.2);
            border-radius: 12px;
            overflow: hidden;
            max-width: 560px;
            margin: 0 auto;
            backdrop-filter: blur(8px);
        }
        .search-icon { padding: 0 14px; color: rgba(255,255,255,0.5); display: flex; align-items: center; }
        .search-icon svg { width: 18px; height: 18px; }
        .search-container input {
            flex: 1;
            background: transparent;
            border: none;
            padding: 13px 0;
            font-family: inherit;
            font-size: 0.9rem;
            color: #fff;
        }
        .search-container input::placeholder { color: rgba(255,255,255,0.45); }
        .search-container input:focus { outline: none; }
        .btn-search-features {
            padding: 13px 22px;
            background: linear-gradient(135deg, #00b894, #00a085);
            color: #fff;
            border: none;
            font-family: inherit;
            font-size: 0.875rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: opacity 0.2s;
        }
        .btn-search-features:hover { opacity: 0.9; }
        .btn-search-features svg { width: 15px; height: 15px; }

        /* Quick links */
        .quick-links { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
        .quick-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 18px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 50px;
            color: rgba(255,255,255,0.8);
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.2s, border-color 0.2s, color 0.2s;
        }
        .quick-link:hover { background: rgba(0,184,148,0.2); border-color: rgba(0,184,148,0.4); color: #fff; }
        .quick-link svg { width: 14px; height: 14px; }

        /* ── CONTAINER ── */
        .container { max-width: 1100px; margin: 0 auto; padding: 0 20px; }

        /* ── FEATURES GRID ── */
        .features-grid-section { padding: 72px 0 80px; }
        .section-header { text-align: center; margin-bottom: 48px; }
        .section-header .section-label { color: var(--green); background: rgba(0,184,148,0.08); border-color: rgba(0,184,148,0.2); }
        .section-header h2 { font-size: 2rem; font-weight: 800; color: var(--text); margin-bottom: 10px; }
        .section-header p  { color: var(--muted); font-size: 1rem; }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        @media (max-width: 900px) { .features-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 560px) { .features-grid { grid-template-columns: 1fr; } }

        .feature-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 28px 24px;
            box-shadow: 0 1px 6px rgba(0,0,0,0.04);
            animation: fadeUp 0.5s ease both;
            transition: transform 0.25s, box-shadow 0.25s;
        }
        .feature-card:nth-child(2) { animation-delay: 0.06s; }
        .feature-card:nth-child(3) { animation-delay: 0.12s; }
        .feature-card:nth-child(4) { animation-delay: 0.18s; }
        .feature-card:nth-child(5) { animation-delay: 0.24s; }
        .feature-card:nth-child(6) { animation-delay: 0.30s; }
        .feature-card:hover { transform: translateY(-6px); box-shadow: 0 12px 32px rgba(0,0,0,0.09); }

        .feature-icon {
            width: 56px; height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
        }
        .feature-icon svg { width: 24px; height: 24px; }
        .icon-1 { background: rgba(0,184,148,0.12); color: var(--green); }
        .icon-2 { background: rgba(43,108,176,0.12); color: var(--blue); }
        .icon-3 { background: rgba(128,90,213,0.12); color: #805ad5; }
        .icon-4 { background: rgba(237,137,54,0.12); color: #ed8936; }
        .icon-5 { background: rgba(229,62,62,0.12); color: #e53e3e; }
        .icon-6 { background: rgba(56,161,105,0.12); color: #38a169; }

        .feature-card h3 { font-size: 1rem; font-weight: 700; color: var(--text); margin-bottom: 10px; }
        .feature-card p  { font-size: 0.875rem; color: var(--muted); line-height: 1.65; margin-bottom: 16px; }

        .feature-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px; }
        .feature-list li {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            font-size: 0.82rem;
            color: #4a5568;
        }
        .feature-list li svg { width: 14px; height: 14px; color: var(--green); flex-shrink: 0; margin-top: 2px; }

        /* ── MODAL ── */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .modal.open { display: flex; }
        .modal-content {
            background: #fff;
            border-radius: 16px;
            max-width: 560px;
            width: 100%;
            box-shadow: 0 24px 64px rgba(0,0,0,0.25);
            animation: fadeUp 0.35s ease both;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
        }
        .modal-header h3 { font-size: 1rem; font-weight: 700; }
        .modal-close { background: none; border: none; font-size: 1.4rem; cursor: pointer; color: var(--muted); line-height: 1; }
        .modal-body { padding: 24px; }
        .search-stats { font-size: 0.875rem; color: var(--muted); margin-bottom: 16px; }
        .search-results { display: flex; flex-direction: column; gap: 10px; }
        .modal-footer {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            padding: 16px 24px;
            border-top: 1px solid var(--border);
        }
        .btn-outline {
            padding: 10px 20px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            background: none;
            font-family: inherit;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            color: var(--text);
            transition: border-color 0.2s;
        }
        .btn-outline:hover { border-color: var(--green); color: var(--green); }
        .btn-primary {
            padding: 10px 20px;
            background: linear-gradient(135deg, #00b894, #00a085);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.875rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
    </style>
</head>
<body>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<!-- Features Hero -->
<section class="features-hero">
    <div class="hero-blob hero-blob-1"></div>
    <div class="hero-blob hero-blob-2"></div>
    <div class="features-hero-content">
        <span class="section-label">Platform Features</span>
        <h1>Powerful Features for Ethiopian Event Discovery &amp; Management</h1>
        <p>Discover how Habesha Events makes finding, attending, and hosting events in Ethiopia simple and enjoyable</p>
        <div class="features-search">
            <div class="search-container">
                <div class="search-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </div>
                <input type="text" id="features-search-input" placeholder="Search for events, categories, or locations in Ethiopia...">
                <button class="btn-search-features" id="search-button">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Search
                </button>
            </div>
        </div>
        <div class="quick-links">
            <a href="/afro/?page=events" class="quick-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Browse Events
            </a>
            <a href="/afro/?page=post-event" class="quick-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                Post Event
            </a>
            <a href="#ticketing" class="quick-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v2z"/></svg>
                Ticketing
            </a>
            <a href="#management" class="quick-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                Management
            </a>
        </div>
    </div>
</section>

<!-- Features Grid -->
<section class="features-grid-section">
    <div class="container">
        <div class="section-header">
            <span class="section-label">What We Offer</span>
            <h2>Our Key Features</h2>
            <p>Everything you need to discover, attend, and host amazing events in Ethiopia</p>
        </div>
        <div class="features-grid">
            <div class="feature-card" id="search-discovery">
                <div class="feature-icon icon-1">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </div>
                <h3>Advanced Search &amp; Discovery</h3>
                <p>Find events across Ethiopia with powerful search and filtering by category, price, date, and location.</p>
                <ul class="feature-list">
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Smart search with Ethiopian location suggestions</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Filter free events only</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Price range filtering in ETB</li>
                </ul>
            </div>
            <div class="feature-card" id="ticketing">
                <div class="feature-icon icon-2">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v2z"/></svg>
                </div>
                <h3>Smart Ticketing System</h3>
                <p>Secure, easy-to-use ticketing with instant confirmation and real-time availability updates.</p>
                <ul class="feature-list">
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Real-time ticket availability</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Secure payment processing</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Digital ticket delivery</li>
                </ul>
            </div>
            <div class="feature-card" id="management">
                <div class="feature-icon icon-3">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                </div>
                <h3>Event Management Tools</h3>
                <p>Comprehensive tools for Ethiopian event organizers to create, manage, and promote events.</p>
                <ul class="feature-list">
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Easy event creation wizard</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Attendee management</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Real-time analytics</li>
                </ul>
            </div>
            <div class="feature-card">
                <div class="feature-icon icon-4">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                </div>
                <h3>Mobile-Friendly Experience</h3>
                <p>Access Habesha Events on any device with a seamless responsive experience.</p>
                <ul class="feature-list">
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Fully responsive design</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Fast loading on mobile networks</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Push notifications</li>
                </ul>
            </div>
            <div class="feature-card">
                <div class="feature-icon icon-5">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                </div>
                <h3>Analytics &amp; Insights</h3>
                <p>Get detailed insights into your event performance with our analytics dashboard.</p>
                <ul class="feature-list">
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Attendance tracking</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Revenue reports in ETB</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Audience demographics</li>
                </ul>
            </div>
            <div class="feature-card">
                <div class="feature-icon icon-6">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3>Security &amp; Trust</h3>
                <p>Industry-leading security measures to protect your data and transactions.</p>
                <ul class="feature-list">
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> SSL encryption</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Secure payment processing</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Verified event listings</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Search Results Modal -->
<div class="modal" id="search-results-modal">
    <div class="modal-content search-modal">
        <div class="modal-header">
            <h3>Search Results</h3>
            <button class="modal-close" id="results-modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <div class="search-stats">Found <span id="results-count">0</span> events matching your search</div>
            <div class="search-results" id="search-results-container"></div>
        </div>
        <div class="modal-footer">
            <button class="btn-outline" id="close-results">Close</button>
            <a href="/afro/?page=events" class="btn-primary">View All Events</a>
        </div>
    </div>
</div>

<script src="/afro/public/js/common.js"></script>
<script src="/afro/public/js/features.js"></script>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
</body>
</html>
