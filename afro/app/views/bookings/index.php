<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History — HabeshaEvents</title>
    <link rel="stylesheet" href="/afro/public/css/theme.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: Inter, system-ui, sans-serif; background: var(--bg, #f7f8fc); }

        .bookings-wrap {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 20px 80px;
        }

        /* ── Page header ── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 32px;
        }
        .page-header-left h1 {
            font-size: 1.8rem;
            font-weight: 800;
            color: #1a202c;
            letter-spacing: -0.5px;
            margin-bottom: 4px;
        }
        .page-header-left p { color: #718096; font-size: 0.9rem; }

        .btn-back {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 18px; border-radius: 10px;
            background: white; border: 1.5px solid #e2e8f0;
            color: #4a5568; font-family: inherit; font-size: 0.875rem; font-weight: 600;
            text-decoration: none; transition: border-color 0.2s, color 0.2s, transform 0.2s;
        }
        .btn-back:hover { border-color: #00b894; color: #00b894; transform: translateY(-1px); }

        /* ── Stats row ── */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }
        .stat-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 20px 22px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 1px 6px rgba(0,0,0,0.04);
        }
        .stat-icon {
            width: 44px; height: 44px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .stat-icon.green { background: rgba(0,184,148,0.1); color: #00b894; }
        .stat-icon.blue  { background: rgba(43,108,176,0.1); color: #2b6cb0; }
        .stat-icon.amber { background: rgba(214,158,46,0.1); color: #d69e2e; }
        .stat-num { font-size: 1.5rem; font-weight: 800; color: #1a202c; line-height: 1; }
        .stat-label { font-size: 0.8rem; color: #718096; margin-top: 3px; }

        /* ── Empty state ── */
        .empty-state {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 64px 32px;
            text-align: center;
            box-shadow: 0 1px 6px rgba(0,0,0,0.04);
        }
        .empty-icon {
            width: 72px; height: 72px; border-radius: 50%;
            background: rgba(0,184,148,0.08);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            color: #00b894;
        }
        .empty-state h3 { font-size: 1.2rem; font-weight: 700; color: #1a202c; margin-bottom: 8px; }
        .empty-state p { color: #718096; font-size: 0.9rem; margin-bottom: 24px; }
        .btn-explore {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 12px 24px; border-radius: 10px;
            background: linear-gradient(135deg, #00b894, #00a085);
            color: white; font-family: inherit; font-size: 0.9rem; font-weight: 700;
            text-decoration: none; transition: opacity 0.2s, transform 0.2s;
            box-shadow: 0 4px 16px rgba(0,184,148,0.3);
        }
        .btn-explore:hover { opacity: 0.9; transform: translateY(-2px); }

        /* ── Booking cards ── */
        .bookings-list { display: flex; flex-direction: column; gap: 14px; }

        .booking-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 20px 22px;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 16px;
            align-items: start;
            box-shadow: 0 1px 6px rgba(0,0,0,0.04);
            transition: box-shadow 0.2s, transform 0.2s;
            animation: fadeUp 0.35s ease both;
        }
        .booking-card:hover { box-shadow: 0 6px 24px rgba(0,0,0,0.1); transform: translateY(-2px); }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .booking-card:nth-child(2) { animation-delay: 0.05s; }
        .booking-card:nth-child(3) { animation-delay: 0.1s; }
        .booking-card:nth-child(4) { animation-delay: 0.15s; }
        .booking-card:nth-child(5) { animation-delay: 0.2s; }

        .booking-main { min-width: 0; }
        .booking-event-name {
            font-size: 1rem; font-weight: 700; color: #1a202c;
            margin-bottom: 6px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
            text-decoration: none;
        }
        .booking-event-name:hover { color: #00b894; }

        .booking-meta {
            display: flex; flex-wrap: wrap; gap: 14px;
            font-size: 0.8rem; color: #718096; margin-bottom: 12px;
        }
        .booking-meta span { display: flex; align-items: center; gap: 5px; }
        .booking-meta svg { flex-shrink: 0; }

        .booking-ref {
            font-size: 0.75rem; font-weight: 600; color: #a0aec0;
            font-family: 'Courier New', monospace; letter-spacing: 0.5px;
        }

        .booking-right { text-align: right; flex-shrink: 0; }
        .booking-total {
            font-size: 1.2rem; font-weight: 800; color: #1a202c; margin-bottom: 8px;
        }
        .booking-badges { display: flex; gap: 6px; justify-content: flex-end; flex-wrap: wrap; }

        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: 50px;
            font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.4px;
        }
        .badge-paid    { background: #f0fff4; color: #276749; border: 1px solid #9ae6b4; }
        .badge-pending { background: #fffbeb; color: #92400e; border: 1px solid #fcd34d; }
        .badge-failed  { background: #fff5f5; color: #c53030; border: 1px solid #feb2b2; }
        .badge-confirmed { background: #ebf8ff; color: #1a4f8a; border: 1px solid #90cdf4; }
        .badge-cancelled { background: #f7fafc; color: #718096; border: 1px solid #e2e8f0; }

        @media (max-width: 640px) {
            .stats-row { grid-template-columns: 1fr; }
            .booking-card { grid-template-columns: 1fr; }
            .booking-right { text-align: left; }
            .booking-badges { justify-content: flex-start; }
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
        .skeleton-booking {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 20px 22px;
            margin-bottom: 14px;
        }
        .skeleton-line { height: 14px; margin-bottom: 10px; }
        .skeleton-line.short  { width: 40%; }
        .skeleton-line.medium { width: 70%; }
        .skeleton-line.long   { width: 90%; }
    </style>
</head>
<body>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="bookings-wrap">

    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-left">
            <h1>Booking History</h1>
            <p>All your event bookings in one place</p>
        </div>
        <a href="/afro/?page=profile" class="btn-back">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            Back to Profile
        </a>
    </div>

    <?php
    $totalBookings = count($bookings);
    $totalSpent    = array_sum(array_column($bookings, 'total_amount'));
    $paidCount     = count(array_filter($bookings, fn($b) => $b['payment_status'] === 'paid'));
    ?>

    <!-- Stats -->
    <div class="stats-row" id="stats-row">
        <!-- Skeleton while loading -->
        <div class="stat-card"><div class="stat-icon green"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg></div><div><div class="skeleton skeleton-line short" style="height:24px;margin-bottom:6px"></div><div class="skeleton skeleton-line short" style="height:12px"></div></div></div>
        <div class="stat-card"><div class="stat-icon blue"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div><div><div class="skeleton skeleton-line short" style="height:24px;margin-bottom:6px"></div><div class="skeleton skeleton-line short" style="height:12px"></div></div></div>
        <div class="stat-card"><div class="stat-icon amber"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div><div><div class="skeleton skeleton-line short" style="height:24px;margin-bottom:6px"></div><div class="skeleton skeleton-line short" style="height:12px"></div></div></div>
    </div>

    <!-- Bookings list — populated by REST API -->
    <div id="bookings-list">
        <div class="skeleton-booking"><div class="skeleton skeleton-line long"></div><div class="skeleton skeleton-line medium"></div><div class="skeleton skeleton-line short"></div></div>
        <div class="skeleton-booking"><div class="skeleton skeleton-line long"></div><div class="skeleton skeleton-line medium"></div><div class="skeleton skeleton-line short"></div></div>
        <div class="skeleton-booking"><div class="skeleton skeleton-line long"></div><div class="skeleton skeleton-line medium"></div><div class="skeleton skeleton-line short"></div></div>
    </div>

</div>

<script>
(function () {
    var statsRow    = document.getElementById('stats-row');
    var listEl      = document.getElementById('bookings-list');

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

    function formatShortDate(dateStr) {
        if (!dateStr) return '\u2014';
        var d = new Date(dateStr);
        return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    }

    function payBadgeClass(status) {
        return status === 'paid' ? 'badge-paid' : status === 'pending' ? 'badge-pending' : 'badge-failed';
    }

    function statusBadgeClass(status) {
        return status === 'confirmed' ? 'badge-confirmed' : status === 'cancelled' ? 'badge-cancelled' : 'badge-pending';
    }

    function renderStats(stats) {
        statsRow.innerHTML =
            '<div class="stat-card"><div class="stat-icon green"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg></div><div><div class="stat-num">' + stats.total_bookings + '</div><div class="stat-label">Total Bookings</div></div></div>'
          + '<div class="stat-card"><div class="stat-icon blue"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div><div><div class="stat-num">ETB ' + Math.round(stats.total_spent).toLocaleString() + '</div><div class="stat-label">Total Spent</div></div></div>'
          + '<div class="stat-card"><div class="stat-icon amber"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div><div><div class="stat-num">' + stats.paid_count + '</div><div class="stat-label">Confirmed Paid</div></div></div>';
    }

    function renderBooking(b, idx) {
        var eventTitle  = b.event_title || 'Event removed';
        var eventDate   = formatDate(b.event_start);
        var qty         = b.quantity;
        var total       = 'ETB ' + parseFloat(b.total_amount).toFixed(2);
        var created     = formatShortDate(b.created_at);
        var eventLink   = b.event_id ? '/afro/?page=event_detail&id=' + b.event_id : '#';
        var delay       = (idx * 0.05).toFixed(2);

        return '<div class="booking-card" style="animation-delay:' + delay + 's">'
            + '<div class="booking-main">'
            + '<a href="' + eventLink + '" class="booking-event-name">' + escHtml(eventTitle) + '</a>'
            + '<div class="booking-meta">'
            + '<span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>' + eventDate + '</span>'
            + '<span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 12V22H4V12"/><path d="M22 7H2v5h20V7z"/></svg>' + qty + ' ticket' + (qty !== 1 ? 's' : '') + '</span>'
            + '<span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Booked ' + created + '</span>'
            + '</div>'
            + '<div class="booking-ref"># ' + escHtml(b.booking_reference) + '</div>'
            + '</div>'
            + '<div class="booking-right">'
            + '<div class="booking-total">' + total + '</div>'
            + '<div class="booking-badges">'
            + '<span class="badge ' + payBadgeClass(b.payment_status) + '">' + escHtml(b.payment_status) + '</span>'
            + '<span class="badge ' + statusBadgeClass(b.booking_status) + '">' + escHtml(b.booking_status) + '</span>'
            + '</div>'
            + '</div>'
            + '</div>';
    }

    function renderEmpty() {
        return '<div class="empty-state">'
            + '<div class="empty-icon"><svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg></div>'
            + '<h3>No bookings yet</h3>'
            + '<p>You haven\'t booked any events. Start exploring and grab your first ticket!</p>'
            + '<a href="/afro/?page=events" class="btn-explore"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>Browse Events</a>'
            + '</div>';
    }

    fetch('/afro/?page=api_bookings')
        .then(function (res) {
            if (!res.ok) throw new Error('API error ' + res.status);
            return res.json();
        })
        .then(function (data) {
            if (!data.success) throw new Error(data.error || 'Unknown error');

            renderStats(data.stats);

            var bookings = data.bookings || [];
            listEl.innerHTML = bookings.length
                ? '<div class="bookings-list">' + bookings.map(renderBooking).join('') + '</div>'
                : renderEmpty();
        })
        .catch(function (err) {
            console.error('Bookings API error:', err);
            statsRow.innerHTML = '';
            listEl.innerHTML = '<div class="empty-state">'
                + '<div class="empty-icon" style="background:rgba(229,62,62,0.08);color:#e53e3e"><svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>'
                + '<h3>Could not load bookings</h3>'
                + '<p>Please refresh the page or try again later.</p>'
                + '</div>';
        });
})();
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
</body>
</html>
