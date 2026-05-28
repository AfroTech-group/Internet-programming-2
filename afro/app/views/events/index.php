<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events — HabeshaEvents</title>
    <link rel="stylesheet" href="/afro/public/css/theme.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: Inter, system-ui, sans-serif; background: var(--bg, #f7f8fc); }

        /* ── Hero ── */
        .events-hero {
            background: linear-gradient(135deg, #0d1b2a 0%, #1a3a5c 55%, #0d2137 100%);
            position: relative;
            overflow: hidden;
            padding: 72px 20px 60px;
            text-align: center;
        }
        .events-hero::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 60% 70% at 15% 40%, rgba(0,184,148,0.18) 0%, transparent 65%),
                radial-gradient(ellipse 50% 60% at 85% 60%, rgba(43,108,176,0.18) 0%, transparent 65%);
            pointer-events: none;
        }
        .hero-inner { position: relative; z-index: 1; max-width: 680px; margin: 0 auto; }
        .events-hero h1 {
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            font-weight: 800; color: white;
            letter-spacing: -1px; margin-bottom: 12px;
        }
        .events-hero h1 span { color: #00b894; }
        .events-hero p { color: rgba(255,255,255,0.6); font-size: 1rem; margin-bottom: 32px; }

        /* Search bar */
        .search-bar {
            display: flex;
            background: white;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,0.25);
            max-width: 600px;
            margin: 0 auto;
        }
        .search-bar-icon {
            display: flex; align-items: center; justify-content: center;
            padding: 0 16px; color: #a0aec0; flex-shrink: 0;
        }
        .search-bar input {
            flex: 1; padding: 16px 0; border: none; outline: none;
            font-family: inherit; font-size: 0.95rem; color: #1a202c;
            background: transparent;
        }
        .search-bar input::placeholder { color: #a0aec0; }
        .search-bar button {
            padding: 14px 24px; background: #00b894; color: white;
            border: none; font-family: inherit; font-size: 0.9rem; font-weight: 700;
            cursor: pointer; transition: background 0.2s; white-space: nowrap;
            display: flex; align-items: center; gap: 8px;
        }
        .search-bar button:hover { background: #00a085; }

        /* ── Filter strip ── */
        .filter-strip {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 60px;
            z-index: 100;
        }
        .filter-strip-inner {
            max-width: 1200px; margin: 0 auto;
            padding: 0 20px;
            display: flex; align-items: center; gap: 8px;
            overflow-x: auto; scrollbar-width: none;
        }
        .filter-strip-inner::-webkit-scrollbar { display: none; }
        .filter-strip-inner { padding-top: 12px; padding-bottom: 12px; }

        .filter-chip {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 7px 16px; border-radius: 50px;
            border: 1.5px solid #e2e8f0; background: white;
            font-family: inherit; font-size: 0.82rem; font-weight: 600;
            color: #4a5568; cursor: pointer; white-space: nowrap;
            transition: border-color 0.2s, background 0.2s, color 0.2s, box-shadow 0.2s;
            text-decoration: none;
        }
        .filter-chip:hover { border-color: #00b894; color: #00b894; }
        .filter-chip.active {
            background: #00b894; border-color: #00b894;
            color: white; box-shadow: 0 2px 8px rgba(0,184,148,0.3);
        }

        /* ── Main layout ── */
        .events-layout {
            max-width: 1200px; margin: 0 auto;
            padding: 32px 20px 80px;
            display: grid;
            grid-template-columns: 240px 1fr;
            gap: 28px;
            align-items: start;
        }

        /* ── Sidebar filters ── */
        .sidebar {
            position: sticky;
            top: 110px;
        }
        .sidebar-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 1px 6px rgba(0,0,0,0.04);
        }
        .sidebar-title {
            font-size: 0.78rem; font-weight: 700; color: #a0aec0;
            text-transform: uppercase; letter-spacing: 0.6px;
            margin-bottom: 14px;
        }
        .sidebar select {
            width: 100%; padding: 9px 12px;
            border: 1.5px solid #e2e8f0; border-radius: 8px;
            font-family: inherit; font-size: 0.875rem; color: #1a202c;
            background: #f7f8fc; cursor: pointer;
            transition: border-color 0.2s;
            margin-bottom: 12px;
        }
        .sidebar select:focus { outline: none; border-color: #00b894; }
        .sidebar-divider { height: 1px; background: #e2e8f0; margin: 16px 0; }
        .btn-apply {
            width: 100%; padding: 10px;
            background: linear-gradient(135deg, #00b894, #00a085);
            color: white; border: none; border-radius: 8px;
            font-family: inherit; font-size: 0.875rem; font-weight: 700;
            cursor: pointer; transition: opacity 0.2s, transform 0.2s;
            box-shadow: 0 3px 12px rgba(0,184,148,0.3);
        }
        .btn-apply:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-reset {
            width: 100%; padding: 9px;
            background: none; border: 1.5px solid #e2e8f0;
            border-radius: 8px; font-family: inherit; font-size: 0.875rem;
            font-weight: 600; color: #718096; cursor: pointer;
            margin-top: 8px; transition: border-color 0.2s, color 0.2s;
            text-decoration: none; display: block; text-align: center;
        }
        .btn-reset:hover { border-color: #e53e3e; color: #e53e3e; }

        /* ── Results header ── */
        .results-header {
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 12px; margin-bottom: 20px;
        }
        .results-header h2 { font-size: 1.2rem; font-weight: 700; color: #1a202c; }
        .results-count {
            font-size: 0.85rem; color: #718096;
            background: #f7f8fc; border: 1px solid #e2e8f0;
            padding: 4px 12px; border-radius: 50px;
        }
        .results-count strong { color: #00b894; }

        /* Active filter tags */
        .active-filters { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 16px; }
        .filter-tag {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 4px 12px; border-radius: 50px;
            background: rgba(0,184,148,0.1); border: 1px solid rgba(0,184,148,0.25);
            color: #00a085; font-size: 0.78rem; font-weight: 600;
        }
        .filter-tag a { color: inherit; text-decoration: none; font-size: 1rem; line-height: 1; }
        .filter-tag a:hover { color: #e53e3e; }

        /* ── Event grid ── */
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .event-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            overflow: hidden;
            display: flex; flex-direction: column;
            box-shadow: 0 1px 6px rgba(0,0,0,0.04);
            transition: transform 0.25s, box-shadow 0.25s;
            animation: fadeUp 0.35s ease both;
        }
        .event-card:hover { transform: translateY(-5px); box-shadow: 0 10px 32px rgba(0,0,0,0.1); }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .event-card:nth-child(2) { animation-delay: 0.04s; }
        .event-card:nth-child(3) { animation-delay: 0.08s; }
        .event-card:nth-child(4) { animation-delay: 0.12s; }
        .event-card:nth-child(5) { animation-delay: 0.16s; }
        .event-card:nth-child(6) { animation-delay: 0.20s; }

        .event-thumb {
            position: relative; height: 180px; overflow: hidden; background: #edf2f7;
        }
        .event-thumb img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 0.5s ease;
        }
        .event-card:hover .event-thumb img { transform: scale(1.06); }

        .event-badge {
            position: absolute; top: 10px; left: 10px;
            padding: 3px 10px; border-radius: 50px;
            font-size: 0.72rem; font-weight: 700; text-transform: capitalize;
            background: #00b894; color: white;
        }
        .event-price-badge {
            position: absolute; top: 10px; right: 10px;
            padding: 3px 10px; border-radius: 50px;
            font-size: 0.75rem; font-weight: 700;
            background: white; color: #1a202c;
            box-shadow: 0 2px 6px rgba(0,0,0,0.12);
        }
        .event-price-badge.free { background: #00b894; color: white; }

        .event-body { padding: 16px; flex: 1; display: flex; flex-direction: column; }
        .event-body h3 {
            font-size: 0.975rem; font-weight: 700; color: #1a202c;
            margin-bottom: 8px; line-height: 1.35;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .event-meta { display: flex; flex-direction: column; gap: 4px; margin-bottom: 10px; }
        .event-meta-row {
            display: flex; align-items: center; gap: 6px;
            font-size: 0.8rem; color: #718096;
        }
        .event-meta-row svg { flex-shrink: 0; color: #a0aec0; }
        .event-desc {
            font-size: 0.8rem; color: #a0aec0; line-height: 1.5;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
            margin-bottom: 14px; flex: 1;
        }
        .event-footer {
            display: flex; align-items: center; justify-content: space-between;
            padding-top: 12px; border-top: 1px solid #f0f4f8;
        }
        .tickets-left { font-size: 0.78rem; color: #a0aec0; display: flex; align-items: center; gap: 5px; }
        .tickets-left svg { color: #00b894; }
        .tickets-left strong { color: #1a202c; }

        .btn-ticket {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; border-radius: 8px;
            background: linear-gradient(135deg, #00b894, #00a085);
            color: white; font-family: inherit; font-size: 0.8rem; font-weight: 700;
            text-decoration: none; transition: opacity 0.2s, transform 0.2s;
            box-shadow: 0 2px 8px rgba(0,184,148,0.3);
        }
        .btn-ticket:hover { opacity: 0.9; transform: translateY(-1px); }

        /* ── Empty state ── */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center; padding: 64px 20px;
            background: white; border: 1px solid #e2e8f0;
            border-radius: 14px;
        }
        .empty-icon {
            width: 64px; height: 64px; border-radius: 50%;
            background: rgba(0,184,148,0.08);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px; color: #00b894;
        }
        .empty-state h3 { font-size: 1.1rem; font-weight: 700; color: #1a202c; margin-bottom: 8px; }
        .empty-state p { color: #718096; font-size: 0.9rem; }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            .events-layout { grid-template-columns: 1fr; }
            .sidebar { position: static; }
        }
        @media (max-width: 600px) {
            .events-grid { grid-template-columns: 1fr; }
        }

        /* ── Loading skeleton ── */
        .skeleton {
            background: linear-gradient(90deg, #e2e8f0 25%, #f0f4f8 50%, #e2e8f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.4s infinite;
            border-radius: 8px;
        }
        @keyframes shimmer {
            0%   { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        .skeleton-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            overflow: hidden;
        }
        .skeleton-thumb { height: 180px; }
        .skeleton-body  { padding: 16px; }
        .skeleton-line  { height: 14px; margin-bottom: 10px; }
        .skeleton-line.short { width: 60%; }
        .skeleton-line.medium { width: 80%; }
    </style>
</head>
<body>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<!-- Hero + Search -->
<section class="events-hero">
    <div class="hero-inner">
        <h1>Find Your Next <span>Experience</span></h1>
        <p>Browse events happening across Ethiopia — concerts, festivals, workshops and more.</p>
        <form class="search-bar" method="get" action="/afro/">
            <input type="hidden" name="page" value="events">
            <div class="search-bar-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </div>
            <input type="text" name="search"
                   placeholder="Search by name, location or category…"
                   value="<?php echo htmlspecialchars($search ?? ''); ?>">
            <?php if (!empty($category)): ?>
                <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
            <?php endif; ?>
            <button type="submit">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                Search
            </button>
        </form>
    </div>
</section>

<!-- Category chip strip -->
<?php
$categories = [
    ''           => 'All Events',
    'music'      => '🎵 Music',
    'business'   => '💼 Business',
    'art'        => '🎨 Art & Culture',
    'sports'     => '⚽ Sports',
    'food'       => '🍽 Food & Drink',
    'tech'       => '💻 Technology',
    'education'  => '📚 Education',
    'community'  => '🤝 Community',
    'religious'  => '✨ Religious',
    'traditional'=> '🪘 Traditional',
];
?>
<div class="filter-strip">
    <div class="filter-strip-inner">
        <?php foreach ($categories as $val => $label):
            $isActive = ($category ?? '') === $val;
            $href = '/afro/?page=events' . ($val ? '&category=' . urlencode($val) : '') . (!empty($search) ? '&search=' . urlencode($search) : '');
        ?>
            <a href="<?php echo $href; ?>"
               class="filter-chip<?php echo $isActive ? ' active' : ''; ?>">
                <?php echo htmlspecialchars($label); ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- Main content -->
<div class="events-layout">

    <!-- Sidebar -->
    <aside class="sidebar">
        <form method="get" action="/afro/">
            <input type="hidden" name="page" value="events">
            <?php if (!empty($search)): ?>
                <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
            <?php endif; ?>
            <?php if (!empty($category)): ?>
                <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
            <?php endif; ?>

            <div class="sidebar-card">
                <div class="sidebar-title">Sort By</div>
                <select name="sort">
                    <option value="date_asc"  <?php echo ($_GET['sort'] ?? 'date_asc') === 'date_asc'  ? 'selected' : ''; ?>>Date (Soonest)</option>
                    <option value="date_desc" <?php echo ($_GET['sort'] ?? '') === 'date_desc' ? 'selected' : ''; ?>>Date (Latest)</option>
                    <option value="price_asc" <?php echo ($_GET['sort'] ?? '') === 'price_asc' ? 'selected' : ''; ?>>Price (Low → High)</option>
                    <option value="price_desc"<?php echo ($_GET['sort'] ?? '') === 'price_desc'? 'selected' : ''; ?>>Price (High → Low)</option>
                </select>

                <div class="sidebar-divider"></div>
                <div class="sidebar-title">Event Type</div>
                <select name="event_type">
                    <option value="">All Types</option>
                    <option value="in-person" <?php echo ($event_type ?? '') === 'in-person' ? 'selected' : ''; ?>>In-Person</option>
                    <option value="online"    <?php echo ($event_type ?? '') === 'online'    ? 'selected' : ''; ?>>Online</option>
                    <option value="hybrid"    <?php echo ($event_type ?? '') === 'hybrid'    ? 'selected' : ''; ?>>Hybrid</option>
                </select>

                <div class="sidebar-divider"></div>
                <div class="sidebar-title">Ticket Price</div>
                <select name="price_filter">
                    <option value="">Any Price</option>
                    <option value="free"    <?php echo ($_GET['price_filter'] ?? '') === 'free'     ? 'selected' : ''; ?>>Free Only</option>
                    <option value="paid"    <?php echo ($_GET['price_filter'] ?? '') === 'paid'     ? 'selected' : ''; ?>>Paid Only</option>
                </select>

                <div class="sidebar-divider"></div>
                <button type="submit" class="btn-apply">Apply Filters</button>
                <a href="/afro/?page=events" class="btn-reset">Reset All</a>
            </div>
        </form>
    </aside>

    <!-- Results -->
    <div>
        <!-- Results header -->
        <div class="results-header">
            <h2>
                <?php if (!empty($search)): ?>
                    Results for "<?php echo htmlspecialchars($search); ?>"
                <?php elseif (!empty($category)): ?>
                    <?php echo htmlspecialchars($categories[$category] ?? ucfirst($category)); ?>
                <?php else: ?>
                    All Events
                <?php endif; ?>
            </h2>
            <span class="results-count"><strong><?php echo count($events); ?></strong> event<?php echo count($events) !== 1 ? 's' : ''; ?> found</span>
        </div>

        <!-- Active filter tags -->
        <?php if (!empty($search) || !empty($category) || !empty($event_type) || !empty($_GET['price_filter'])): ?>
        <div class="active-filters">
            <?php if (!empty($search)): ?>
                <span class="filter-tag">
                    Search: <?php echo htmlspecialchars($search); ?>
                    <a href="/afro/?page=events<?php echo !empty($category) ? '&category='.urlencode($category) : ''; ?>">×</a>
                </span>
            <?php endif; ?>
            <?php if (!empty($category)): ?>
                <span class="filter-tag">
                    <?php echo htmlspecialchars($categories[$category] ?? $category); ?>
                    <a href="/afro/?page=events<?php echo !empty($search) ? '&search='.urlencode($search) : ''; ?>">×</a>
                </span>
            <?php endif; ?>
            <?php if (!empty($event_type)): ?>
                <span class="filter-tag">
                    <?php echo htmlspecialchars(ucfirst($event_type)); ?>
                    <a href="/afro/?page=events<?php echo !empty($search) ? '&search='.urlencode($search) : ''; ?><?php echo !empty($category) ? '&category='.urlencode($category) : ''; ?>">×</a>
                </span>
            <?php endif; ?>
            <?php if (!empty($_GET['price_filter'])): ?>
                <span class="filter-tag">
                    <?php echo htmlspecialchars(ucfirst($_GET['price_filter'])); ?>
                    <a href="/afro/?page=events<?php echo !empty($search) ? '&search='.urlencode($search) : ''; ?><?php echo !empty($category) ? '&category='.urlencode($category) : ''; ?>">×</a>
                </span>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Cards — populated by REST API fetch below -->
        <div class="events-grid" id="events-grid">
            <!-- Skeleton placeholders shown while API loads -->
            <?php for ($i = 0; $i < 6; $i++): ?>
            <div class="skeleton-card">
                <div class="skeleton skeleton-thumb"></div>
                <div class="skeleton-body">
                    <div class="skeleton skeleton-line medium"></div>
                    <div class="skeleton skeleton-line short"></div>
                    <div class="skeleton skeleton-line medium"></div>
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </div>

</div>

<script>
(function () {
    var params = new URLSearchParams({
        page:         'api_events',
        search:       <?php echo json_encode($search); ?>,
        category:     <?php echo json_encode($category); ?>,
        event_type:   <?php echo json_encode($event_type); ?>,
        price_filter: <?php echo json_encode($price_filter); ?>,
        sort:         <?php echo json_encode($sort); ?>
    });

    var grid    = document.getElementById('events-grid');
    var countEl = document.querySelector('.results-count');

    function escHtml(str) {
        return String(str == null ? '' : str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function formatDate(dateStr) {
        if (!dateStr) return '\u2014';
        var d = new Date(dateStr);
        return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
             + ' \u00b7 '
             + d.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
    }

    function renderCard(event) {
        var available = event.tickets_available != null ? event.tickets_available : 0;
        var isFree    = !event.ticket_price || event.ticket_price === 0;
        var dateStr   = formatDate(event.start_at);
        var imgSrc    = event.event_image || '/afro/public/images/placeholder.jpg';
        var priceText = isFree ? 'Free' : 'ETB ' + parseFloat(event.ticket_price).toFixed(2);
        var btnText   = isFree ? 'Register' : 'Get Ticket';

        return '<div class="event-card">'
            + '<div class="event-thumb">'
            + '<img src="' + escHtml(imgSrc) + '" alt="' + escHtml(event.title) + '" loading="lazy" onerror="this.src=\'/afro/public/images/placeholder.jpg\'">'
            + '<span class="event-badge">' + escHtml(event.category) + '</span>'
            + '<span class="event-price-badge' + (isFree ? ' free' : '') + '">' + priceText + '</span>'
            + '</div>'
            + '<div class="event-body">'
            + '<h3>' + escHtml(event.title) + '</h3>'
            + '<div class="event-meta">'
            + '<div class="event-meta-row"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>' + dateStr + '</div>'
            + '<div class="event-meta-row"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>' + escHtml(event.location) + '</div>'
            + '</div>'
            + '<p class="event-desc">' + escHtml(event.description) + '</p>'
            + '<div class="event-footer">'
            + '<div class="tickets-left"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 12V22H4V12"/><path d="M22 7H2v5h20V7z"/></svg><strong>' + available + '</strong>&nbsp;left</div>'
            + '<a href="/afro/?page=event_detail&id=' + event.id + '" class="btn-ticket">' + btnText + '</a>'
            + '</div>'
            + '</div>'
            + '</div>';
    }

    function renderEmpty() {
        return '<div class="empty-state">'
            + '<div class="empty-icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div>'
            + '<h3>No events found</h3>'
            + '<p>Try adjusting your search or filters, or <a href="/afro/?page=events" style="color:#00b894">browse all events</a>.</p>'
            + '</div>';
    }

    fetch('/afro/?' + params.toString())
        .then(function(res) {
            if (!res.ok) throw new Error('API error ' + res.status);
            return res.json();
        })
        .then(function(data) {
            if (!data.success) throw new Error(data.error || 'Unknown error');
            var events = data.events || [];

            if (countEl) {
                countEl.innerHTML = '<strong>' + events.length + '</strong> event' + (events.length !== 1 ? 's' : '') + ' found';
            }

            grid.innerHTML = events.length
                ? events.map(renderCard).join('')
                : renderEmpty();
        })
        .catch(function(err) {
            console.error('Events API error:', err);
            grid.innerHTML = '<div class="empty-state">'
                + '<div class="empty-icon" style="background:rgba(229,62,62,0.08);color:#e53e3e"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>'
                + '<h3>Could not load events</h3>'
                + '<p>Please refresh the page or try again later.</p>'
                + '</div>';
        });
})();
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
</body>
</html>
