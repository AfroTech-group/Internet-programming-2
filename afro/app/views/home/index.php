<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habesha Events - Discover Amazing Events in Ethiopia</title>
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
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', system-ui, sans-serif; color: var(--text); background: var(--bg); }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes blobFloat {
            0%, 100% { transform: translateY(0) scale(1); }
            50%       { transform: translateY(-30px) scale(1.05); }
        }

        /* ── HERO ── */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: linear-gradient(135deg, #0d1b2a 0%, #1a3a5c 55%, #0d2137 100%);
        }
        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 60% 50% at 20% 40%, rgba(0,184,148,0.18) 0%, transparent 70%),
                radial-gradient(ellipse 50% 60% at 80% 60%, rgba(43,108,176,0.18) 0%, transparent 70%);
            pointer-events: none;
        }
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.25;
            animation: blobFloat 8s ease-in-out infinite;
        }
        .blob-1 { width: 420px; height: 420px; background: #00b894; top: -80px; left: -100px; animation-delay: 0s; }
        .blob-2 { width: 320px; height: 320px; background: #2b6cb0; bottom: -60px; right: -80px; animation-delay: 3s; }
        .blob-3 { width: 200px; height: 200px; background: #00b894; top: 50%; right: 15%; animation-delay: 5s; }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 40px 20px;
            max-width: 780px;
            animation: fadeUp 0.8s ease both;
        }
        .hero-label {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--green);
            background: rgba(0,184,148,0.12);
            border: 1px solid rgba(0,184,148,0.3);
            padding: 5px 16px;
            border-radius: 50px;
            margin-bottom: 24px;
        }
        .hero-title {
            font-size: clamp(2.2rem, 5vw, 3.8rem);
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
            margin-bottom: 20px;
            letter-spacing: -1px;
        }
        .hero-title .accent { color: var(--green); }
        .hero-subtitle {
            font-size: 1.1rem;
            color: rgba(255,255,255,0.72);
            line-height: 1.7;
            margin-bottom: 36px;
            max-width: 580px;
            margin-left: auto;
            margin-right: auto;
        }
        .hero-buttons {
            display: flex;
            gap: 14px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 56px;
        }
        .btn-hero {
            padding: 14px 32px;
            background: linear-gradient(135deg, #00b894, #00a085);
            color: #fff;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.95rem;
            box-shadow: 0 4px 20px rgba(0,184,148,0.4);
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
        }
        .btn-hero:hover { transform: translateY(-3px); box-shadow: 0 8px 28px rgba(0,184,148,0.5); }
        .btn-hero-outline {
            padding: 14px 32px;
            background: transparent;
            color: #fff;
            border: 2px solid rgba(255,255,255,0.4);
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: border-color 0.2s, background 0.2s;
            text-decoration: none;
        }
        .btn-hero-outline:hover { border-color: #fff; background: rgba(255,255,255,0.08); }

        .hero-stats {
            display: flex;
            gap: 40px;
            justify-content: center;
            flex-wrap: wrap;
            padding-top: 32px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        .stat-item { text-align: center; }
        .stat-number { font-size: 1.8rem; font-weight: 800; color: var(--green); display: block; }
        .stat-label  { font-size: 0.8rem; color: rgba(255,255,255,0.55); text-transform: uppercase; letter-spacing: 1px; }

        /* ── FEATURED EVENTS ── */
        .featured-events {
            background: #fff;
            padding: 80px 0;
        }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

        .section-label {
            display: inline-block;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: var(--green);
            margin-bottom: 10px;
        }
        .section-header { text-align: center; margin-bottom: 48px; }
        .section-header h2 { font-size: 2rem; font-weight: 800; color: var(--text); margin-bottom: 10px; }
        .section-header p  { color: var(--muted); font-size: 1rem; }

        .events-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }
        @media (max-width: 700px) { .events-grid { grid-template-columns: 1fr; } }

        .event-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 1px 6px rgba(0,0,0,0.04);
            display: flex;
            flex-direction: column;
            transition: transform 0.25s, box-shadow 0.25s;
            animation: fadeUp 0.5s ease both;
        }
        .event-card:nth-child(2) { animation-delay: 0.07s; }
        .event-card:nth-child(3) { animation-delay: 0.14s; }
        .event-card:nth-child(4) { animation-delay: 0.21s; }
        .event-card:hover { transform: translateY(-6px); box-shadow: 0 12px 32px rgba(0,0,0,0.1); }

        .event-image { position: relative; height: 210px; overflow: hidden; background: #e2e8f0; }
        .event-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; }
        .event-card:hover .event-image img { transform: scale(1.06); }

        .event-category {
            position: absolute; top: 12px; left: 12px;
            background: var(--green); color: #fff;
            padding: 4px 12px; border-radius: 50px;
            font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .event-price {
            position: absolute; top: 12px; right: 12px;
            background: #fff; color: var(--text);
            padding: 4px 12px; border-radius: 50px;
            font-size: 0.8rem; font-weight: 700;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
        }
        .event-price.free { background: var(--green); color: #fff; }

        .event-info { padding: 18px 20px; flex: 1; display: flex; flex-direction: column; }
        .event-info h3 { font-size: 1.05rem; font-weight: 700; margin-bottom: 10px; color: var(--text); line-height: 1.3; }
        .event-meta { display: flex; flex-direction: column; gap: 4px; margin-bottom: 10px; }
        .event-meta span { font-size: 0.82rem; color: var(--muted); display: flex; align-items: center; gap: 6px; }
        .event-meta svg { flex-shrink: 0; }
        .event-description { font-size: 0.85rem; color: var(--muted); line-height: 1.6; margin-bottom: 14px; flex: 1; }

        .event-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 14px;
            border-top: 1px solid var(--border);
            margin-top: auto;
        }
        .tickets-left { font-size: 0.8rem; color: var(--muted); display: flex; align-items: center; gap: 5px; }
        .tickets-left svg { color: var(--green); }

        .btn-ticket {
            background: linear-gradient(135deg, #00b894, #00a085);
            color: #fff;
            padding: 8px 18px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 700;
            text-decoration: none;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 10px rgba(0,184,148,0.3);
        }
        .btn-ticket:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(0,184,148,0.45); }

        .section-footer { text-align: center; margin-top: 40px; }
        .btn-explore {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 13px 30px;
            background: linear-gradient(135deg, #00b894, #00a085);
            color: #fff;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.95rem;
            text-decoration: none;
            box-shadow: 0 4px 16px rgba(0,184,148,0.35);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-explore:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,184,148,0.45); }

        /* ── HOW IT WORKS ── */
        .how-it-works {
            background: linear-gradient(135deg, #0d1b2a 0%, #1a3a5c 55%, #0d2137 100%);
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }
        .how-it-works::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 50% 60% at 10% 50%, rgba(0,184,148,0.12) 0%, transparent 70%),
                radial-gradient(ellipse 40% 50% at 90% 50%, rgba(43,108,176,0.12) 0%, transparent 70%);
            pointer-events: none;
        }
        .how-it-works .section-header h2 { color: #fff; }
        .how-it-works .section-header p  { color: rgba(255,255,255,0.6); }
        .how-it-works .section-label     { color: var(--green); }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            position: relative;
            z-index: 1;
        }
        @media (max-width: 700px) { .steps-grid { grid-template-columns: 1fr; } }

        .step {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 14px;
            padding: 32px 24px;
            text-align: center;
            animation: fadeUp 0.5s ease both;
            transition: background 0.25s, transform 0.25s;
        }
        .step:nth-child(2) { animation-delay: 0.1s; }
        .step:nth-child(3) { animation-delay: 0.2s; }
        .step:hover { background: rgba(255,255,255,0.09); transform: translateY(-4px); }

        .step-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px; height: 48px;
            background: linear-gradient(135deg, #00b894, #00a085);
            color: #fff;
            border-radius: 50%;
            font-size: 1.2rem;
            font-weight: 800;
            margin-bottom: 16px;
            box-shadow: 0 4px 16px rgba(0,184,148,0.4);
        }
        .step-icon {
            width: 64px; height: 64px;
            background: rgba(0,184,148,0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }
        .step-icon svg { width: 28px; height: 28px; color: var(--green); }
        .step h3 { font-size: 1.05rem; font-weight: 700; color: #fff; margin-bottom: 10px; }
        .step p  { font-size: 0.88rem; color: rgba(255,255,255,0.6); line-height: 1.65; }

        /* notification */
        .notification {
            position: fixed; bottom: 24px; right: 24px;
            background: var(--text); color: #fff;
            padding: 12px 20px; border-radius: 10px;
            font-size: 0.875rem; font-weight: 500;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
            opacity: 0; pointer-events: none;
            transition: opacity 0.3s;
            z-index: 9999;
        }
        .notification.show { opacity: 1; pointer-events: auto; }
    </style>
</head>
<body>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<!-- Hero Section -->
<section class="hero">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>
    <div class="hero-content">
        <span class="hero-label">🇪🇹 Ethiopia's #1 Event Platform</span>
        <h1 class="hero-title">
            Discover <span class="accent">Amazing</span><br>Events in Ethiopia
        </h1>
        <p class="hero-subtitle">From concerts and festivals to workshops and networking events — find your next unforgettable experience in the heart of Ethiopia.</p>
        <div class="hero-buttons">
            <a href="/afro/?page=events" class="btn-hero">Explore Events</a>
            <a href="/afro/?page=post-event" class="btn-hero-outline">Post Your Event</a>
        </div>
        <div class="hero-stats">
            <div class="stat-item">
                <span class="stat-number">500+</span>
                <span class="stat-label">Events</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">12K+</span>
                <span class="stat-label">Attendees</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">50+</span>
                <span class="stat-label">Cities</span>
            </div>
        </div>
    </div>
</section>

<!-- Featured Events -->
<section class="featured-events">
    <div class="container">
        <div class="section-header">
            <span class="section-label">Featured</span>
            <h2>Featured Events in Ethiopia</h2>
            <p>Check out these exciting upcoming events across the country</p>
        </div>

        <div class="events-grid">
            <?php if (!empty($featuredEvents)): ?>
                <?php foreach ($featuredEvents as $event): ?>
                    <div class="event-card">
                        <div class="event-image">
                            <?php
                            $imgSrc = $event['event_image'] ?? '';
                            if ($imgSrc && !str_starts_with($imgSrc, 'http') && !str_starts_with($imgSrc, '/')) {
                                $imgSrc = '/afro/' . $imgSrc;
                            }
                            $imgSrc = $imgSrc ?: '/afro/public/images/placeholder.jpg';
                            ?>
                            <img src="<?php echo htmlspecialchars($imgSrc); ?>"
                                 alt="<?php echo htmlspecialchars($event['title']); ?>"
                                 onerror="this.src='/afro/public/images/placeholder.jpg'">
                            <span class="event-category"><?php echo htmlspecialchars($event['category']); ?></span>
                            <span class="event-price <?php echo $event['ticket_price'] == 0 ? 'free' : ''; ?>">
                                <?php echo $event['ticket_price'] == 0 ? 'Free' : 'ETB ' . number_format($event['ticket_price'], 2); ?>
                            </span>
                        </div>
                        <div class="event-info">
                            <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                            <div class="event-meta">
                                <span>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    <?php echo htmlspecialchars($event['start_at']); ?>
                                </span>
                                <span>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    <?php echo htmlspecialchars($event['location']); ?>
                                </span>
                            </div>
                            <p class="event-description"><?php echo htmlspecialchars(substr($event['description'], 0, 120)) . '...'; ?></p>
                            <div class="event-footer">
                                <div class="tickets-left">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v2z"/></svg>
                                    <span><?php echo max(0, ($event['ticket_quantity'] ?? 0) - ($event['tickets_sold'] ?? 0)); ?> tickets left</span>
                                </div>
                                <a href="/afro/?page=event_detail&id=<?php echo (int) $event['id']; ?>" class="btn-ticket">Get Ticket</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align:center;color:var(--muted);grid-column:1/-1;padding:40px 0">No featured events at the moment. Check back soon!</p>
            <?php endif; ?>
        </div>

        <div class="section-footer">
            <a href="/afro/?page=events" class="btn-explore">
                Explore More Events
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="how-it-works">
    <div class="container">
        <div class="section-header">
            <span class="section-label">Simple Process</span>
            <h2>How Habesha Events Works</h2>
            <p>Three simple steps to find or create amazing events in Ethiopia</p>
        </div>
        <div class="steps-grid">
            <div class="step">
                <div class="step-number">1</div>
                <div class="step-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </div>
                <h3>Discover Events</h3>
                <p>Browse through hundreds of events across Ethiopia or search by category, date, or price.</p>
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <div class="step-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v2z"/></svg>
                </div>
                <h3>Get Tickets</h3>
                <p>Secure your spot with our easy booking system. Get instant confirmation for your tickets.</p>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <div class="step-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                </div>
                <h3>Host Events</h3>
                <p>Have an event to share? Post it on Habesha Events and reach thousands of potential attendees.</p>
            </div>
        </div>
    </div>
</section>

<!-- Notification -->
<div class="notification" id="notification">
    <span id="notification-message"></span>
</div>

<script src="/afro/public/js/common.js"></script>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
</body>
</html>
