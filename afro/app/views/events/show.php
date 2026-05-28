<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($event['title'] ?? 'Event Detail'); ?> - Habesha Events</title>
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
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── BACK LINK ── */
        .back-bar {
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: 12px 0;
        }
        .back-bar .container { max-width: 1100px; margin: 0 auto; padding: 0 20px; }
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--muted);
            text-decoration: none;
            transition: color 0.2s;
        }
        .back-link:hover { color: var(--green); }
        .back-link svg { width: 16px; height: 16px; }

        /* ── HERO ── */
        .event-hero {
            position: relative;
            height: 420px;
            overflow: hidden;
            background: #0d1b2a;
        }
        .event-hero-bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            filter: brightness(0.45);
            transition: transform 8s ease;
        }
        .event-hero:hover .event-hero-bg { transform: scale(1.04); }
        .event-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(13,27,42,0.95) 0%, rgba(13,27,42,0.3) 60%, transparent 100%);
        }
        .event-hero-content {
            position: absolute;
            bottom: 36px;
            left: 0;
            right: 0;
            padding: 0 40px;
            max-width: 1100px;
            margin: 0 auto;
            animation: fadeUp 0.6s ease both;
        }
        .event-hero-badges { display: flex; gap: 10px; margin-bottom: 14px; flex-wrap: wrap; }
        .badge {
            padding: 5px 14px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .badge-category { background: var(--green); color: #fff; }
        .badge-price     { background: #fff; color: var(--text); }
        .badge-free      { background: var(--green); color: #fff; }
        .event-hero-title {
            font-size: clamp(1.6rem, 4vw, 2.6rem);
            font-weight: 800;
            color: #fff;
            line-height: 1.2;
            letter-spacing: -0.5px;
        }

        /* ── LAYOUT ── */
        .event-body {
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 20px 60px;
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 28px;
            align-items: start;
        }
        @media (max-width: 820px) {
            .event-body { grid-template-columns: 1fr; }
            .event-hero-content { padding: 0 20px; }
        }

        /* ── CARDS ── */
        .card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: 0 1px 6px rgba(0,0,0,0.04);
            overflow: hidden;
            animation: fadeUp 0.5s ease both;
        }
        .card-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .card-header svg { color: var(--green); width: 18px; height: 18px; }
        .card-body { padding: 24px; }

        /* ── DETAIL ITEMS ── */
        .detail-list { display: flex; flex-direction: column; gap: 16px; }
        .detail-item { display: flex; align-items: flex-start; gap: 14px; }
        .detail-icon {
            width: 38px; height: 38px;
            background: rgba(0,184,148,0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .detail-icon svg { width: 17px; height: 17px; color: var(--green); }
        .detail-label { font-size: 0.75rem; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px; }
        .detail-value { font-size: 0.92rem; font-weight: 600; color: var(--text); }

        /* ── ABOUT ── */
        .about-text { font-size: 0.95rem; line-height: 1.8; color: #4a5568; }

        /* ── BOOKING WIDGET ── */
        .booking-card { animation-delay: 0.1s; }
        .booking-header {
            background: linear-gradient(135deg, #00b894, #00a085);
            padding: 20px 24px;
            color: #fff;
        }
        .booking-header h3 { font-size: 1.05rem; font-weight: 700; margin-bottom: 4px; }
        .booking-header .price-display { font-size: 1.5rem; font-weight: 800; }
        .booking-header .price-display small { font-size: 0.8rem; font-weight: 400; opacity: 0.8; }

        .booking-body { padding: 24px; }
        .booking-field { margin-bottom: 18px; }
        .booking-field label { display: block; font-size: 0.8rem; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; }
        .qty-selector {
            display: flex;
            align-items: center;
            gap: 0;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
            background: var(--bg);
        }
        .qty-selector input[type="number"] {
            flex: 1;
            border: none;
            background: transparent;
            text-align: center;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text);
            padding: 10px 0;
            font-family: inherit;
            -moz-appearance: textfield;
        }
        .qty-selector input[type="number"]::-webkit-outer-spin-button,
        .qty-selector input[type="number"]::-webkit-inner-spin-button { -webkit-appearance: none; }
        .qty-selector input[type="number"]:focus { outline: none; }

        .price-breakdown {
            background: var(--bg);
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 18px;
        }
        .price-row { display: flex; justify-content: space-between; font-size: 0.85rem; color: var(--muted); margin-bottom: 6px; }
        .price-row:last-child { margin-bottom: 0; font-weight: 700; color: var(--text); font-size: 0.95rem; border-top: 1px solid var(--border); padding-top: 8px; margin-top: 4px; }

        .btn-book {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #00b894, #00a085);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-family: inherit;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(0,184,148,0.35);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-book:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,184,148,0.45); }

        .login-prompt {
            text-align: center;
            padding: 20px;
        }
        .login-prompt p { font-size: 0.9rem; color: var(--muted); margin-bottom: 14px; }
        .btn-login-book {
            display: inline-block;
            padding: 12px 28px;
            background: linear-gradient(135deg, #00b894, #00a085);
            color: #fff;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(0,184,148,0.35);
            transition: transform 0.2s;
        }
        .btn-login-book:hover { transform: translateY(-2px); }

        /* ── ALERTS ── */
        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        .alert svg { flex-shrink: 0; margin-top: 1px; }
        .alert-success { background: #f0fff4; border: 1px solid #9ae6b4; color: #276749; }
        .alert-error   { background: #fff5f5; border: 1px solid #feb2b2; color: #c53030; }
        .alert a { color: inherit; font-weight: 700; text-decoration: underline; }

        /* ── BOOKINGS TABLE ── */
        .bookings-section { margin-top: 28px; }
        .bookings-section h3 { font-size: 1rem; font-weight: 700; margin-bottom: 16px; color: var(--text); }
        .booking-item {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 10px;
            font-size: 0.875rem;
        }
        .booking-ref { font-weight: 700; color: var(--text); flex: 1; }
        .booking-meta { color: var(--muted); }
        .booking-status {
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }
        .status-confirmed { background: #f0fff4; color: #276749; }
        .status-pending   { background: #fffbeb; color: #92400e; }
        .status-cancelled { background: #fff5f5; color: #c53030; }
    </style>
</head>
<body>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<!-- Back Bar -->
<div class="back-bar">
    <div class="container">
        <a href="/afro/?page=events" class="back-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
            Back to Events
        </a>
    </div>
</div>

<?php if (!$event): ?>
    <div style="max-width:600px;margin:80px auto;text-align:center;padding:0 20px">
        <p style="color:var(--muted);margin-bottom:20px">Event not found.</p>
        <a href="/afro/?page=events" style="color:var(--green);font-weight:600">Back to events</a>
    </div>
<?php else: ?>

<!-- Event Hero -->
<div class="event-hero">
    <?php
    $heroImg = $event['event_image'] ?: '/afro/public/images/placeholder.jpg';
    ?>
    <div class="event-hero-bg" style="background-image:url('<?php echo htmlspecialchars($heroImg); ?>')"></div>
    <div class="event-hero-overlay"></div>
    <div class="event-hero-content">
        <div class="event-hero-badges">
            <span class="badge badge-category"><?php echo htmlspecialchars($event['category']); ?></span>
            <span class="badge <?php echo $event['ticket_price'] == 0 ? 'badge-free' : 'badge-price'; ?>">
                <?php echo $event['ticket_price'] == 0 ? 'Free' : 'ETB ' . number_format($event['ticket_price'], 2); ?>
            </span>
        </div>
        <h1 class="event-hero-title"><?php echo htmlspecialchars($event['title']); ?></h1>
    </div>
</div>

<!-- Body -->
<div class="event-body">
    <!-- Left Column -->
    <div>
        <!-- Alerts — populated by booking API response -->
        <div id="page-booking-alert"></div>

        <!-- About -->
        <div class="card" style="margin-bottom:24px">
            <div class="card-header">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                About This Event
            </div>
            <div class="card-body">
                <p class="about-text"><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
            </div>
        </div>

        <!-- Details -->
        <div class="card">
            <div class="card-header">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Event Details
            </div>
            <div class="card-body">
                <div class="detail-list">
                    <div class="detail-item">
                        <div class="detail-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div>
                            <div class="detail-label">Date &amp; Time</div>
                            <div class="detail-value"><?php echo htmlspecialchars($event['start_at']); ?></div>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <div>
                            <div class="detail-label">Location</div>
                            <div class="detail-value"><?php echo htmlspecialchars($event['location']); ?></div>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div>
                            <div class="detail-label">Event Type</div>
                            <div class="detail-value"><?php echo htmlspecialchars($event['event_type'] ?: 'In-person'); ?></div>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <div>
                            <div class="detail-label">Organizer</div>
                            <div class="detail-value"><?php echo htmlspecialchars($event['organizer_name'] ?? 'N/A'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User's Bookings -->
        <?php if (!empty($userBookings)): ?>
            <div class="bookings-section">
                <h3>Your Bookings for This Event</h3>
                <?php foreach ($userBookings as $b): ?>
                    <div class="booking-item">
                        <div class="booking-ref"><?php echo htmlspecialchars($b['booking_reference']); ?></div>
                        <div class="booking-meta"><?php echo (int) $b['quantity']; ?> ticket<?php echo $b['quantity'] > 1 ? 's' : ''; ?></div>
                        <div class="booking-meta">ETB <?php echo number_format($b['total_amount'], 2); ?></div>
                        <span class="booking-status status-<?php echo strtolower(htmlspecialchars($b['booking_status'])); ?>">
                            <?php echo htmlspecialchars($b['booking_status']); ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Right Column: Booking Widget -->
    <div>
        <div class="card booking-card">
            <div class="booking-header">
                <h3>Book Your Tickets</h3>
                <div class="price-display">
                    <?php if ($event['ticket_price'] == 0): ?>
                        Free <small>event</small>
                    <?php else: ?>
                        ETB <?php echo number_format($event['ticket_price'], 2); ?> <small>/ ticket</small>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (is_logged_in()): ?>
                <div class="booking-body" id="booking-widget-body">
                    <!-- Booking form — submits via REST API (POST /api/bookings) -->
                    <div id="booking-form-wrap">
                        <div class="booking-field">
                            <label for="quantity">Number of Tickets</label>
                            <div class="qty-selector">
                                <input type="number" id="quantity" name="quantity" min="1" max="10" value="1">
                            </div>
                        </div>
                        <?php if ($event['ticket_price'] > 0): ?>
                        <div class="price-breakdown" id="price-breakdown">
                            <div class="price-row">
                                <span>Price per ticket</span>
                                <span>ETB <?php echo number_format($event['ticket_price'], 2); ?></span>
                            </div>
                            <div class="price-row">
                                <span>Quantity</span>
                                <span id="qty-display">1</span>
                            </div>
                            <div class="price-row">
                                <span>Total</span>
                                <span id="total-display">ETB <?php echo number_format($event['ticket_price'], 2); ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div style="font-size:0.8rem;color:var(--muted);margin-bottom:14px" id="avail-display">
                            <?php echo max(0, ($event['ticket_quantity'] ?? 0) - ($event['tickets_sold'] ?? 0)); ?> tickets available
                        </div>
                        <div id="booking-alert" style="display:none"></div>
                        <button type="button" id="btn-book-now" class="btn-book">
                            <?php echo $event['ticket_price'] == 0 ? 'Register Free' : 'Book Now'; ?>
                        </button>
                    </div>
                    <!-- Success state (shown after API confirms) -->
                    <div id="booking-success-wrap" style="display:none">
                        <div class="alert alert-success" style="margin-bottom:0">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            <span>Booking confirmed! Check <a href="/afro/?page=bookings">My Bookings</a> for details.</span>
                        </div>
                    </div>
                </div>
            <?php elseif (!is_logged_in()): ?>
                <div class="login-prompt">
                    <p>You need to be logged in to book tickets for this event.</p>
                    <a href="/afro/?page=login&redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" class="btn-login-book">Login to Book</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php endif; ?>

<script src="/afro/public/js/common.js"></script>
<?php if (is_logged_in()): ?>
<script>
(function () {
    var eventId    = <?php echo (int) $event['id']; ?>;
    var unitPrice  = <?php echo (float) ($event['ticket_price'] ?? 0); ?>;
    var available  = <?php echo max(0, ($event['ticket_quantity'] ?? 0) - ($event['tickets_sold'] ?? 0)); ?>;

    var qtyInput      = document.getElementById('quantity');
    var qtyDisplay    = document.getElementById('qty-display');
    var totalDisplay  = document.getElementById('total-display');
    var availDisplay  = document.getElementById('avail-display');
    var bookBtn       = document.getElementById('btn-book-now');
    var alertBox      = document.getElementById('booking-alert');
    var pageAlertBox  = document.getElementById('page-booking-alert');
    var formWrap      = document.getElementById('booking-form-wrap');
    var successWrap   = document.getElementById('booking-success-wrap');

    // Live price breakdown update
    if (qtyInput) {
        qtyInput.addEventListener('input', function () {
            var qty = Math.max(1, Math.min(10, parseInt(this.value) || 1));
            this.value = qty;
            if (qtyDisplay)   qtyDisplay.textContent   = qty;
            if (totalDisplay) totalDisplay.textContent = 'ETB ' + (unitPrice * qty).toFixed(2);
        });
    }

    function showAlert(el, type, html) {
        if (!el) return;
        el.className = 'alert alert-' + type;
        el.innerHTML = html;
        el.style.display = 'flex';
    }

    function hideAlert(el) {
        if (!el) return;
        el.style.display = 'none';
    }

    if (bookBtn) {
        bookBtn.addEventListener('click', function () {
            var qty = parseInt(qtyInput ? qtyInput.value : 1) || 1;

            hideAlert(alertBox);
            bookBtn.disabled    = true;
            bookBtn.textContent = 'Processing…';

            fetch('/afro/?page=api_bookings', {
                method:  'POST',
                headers: { 'Content-Type': 'application/json' },
                body:    JSON.stringify({ event_id: eventId, quantity: qty })
            })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                if (data.success) {
                    // Show success in widget
                    if (formWrap)    formWrap.style.display    = 'none';
                    if (successWrap) successWrap.style.display = 'block';

                    // Show success at top of left column too
                    showAlert(pageAlertBox, 'success',
                        '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>'
                        + '<span>Booking confirmed! Check <a href="/afro/?page=bookings">My Bookings</a> for details.</span>');

                    // Update available count
                    available -= qty;
                    if (availDisplay) availDisplay.textContent = available + ' tickets available';
                } else {
                    var msgs = data.errors ? data.errors.join('<br>') : (data.error || 'Booking failed.');
                    showAlert(alertBox, 'error',
                        '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>'
                        + '<div>' + msgs + '</div>');
                    bookBtn.disabled    = false;
                    bookBtn.textContent = unitPrice === 0 ? 'Register Free' : 'Book Now';
                }
            })
            .catch(function (err) {
                console.error('Booking API error:', err);
                showAlert(alertBox, 'error',
                    '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>'
                    + '<div>Network error. Please try again.</div>');
                bookBtn.disabled    = false;
                bookBtn.textContent = unitPrice === 0 ? 'Register Free' : 'Book Now';
            });
        });
    }
})();
</script>
<?php endif; ?>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
</body>
</html>
