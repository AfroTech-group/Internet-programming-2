<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Habesha Events</title>
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
            50%       { transform: translateY(-20px); }
        }

        /* ── HERO ── */
        .contact-hero {
            position: relative;
            padding: 100px 20px 80px;
            background: linear-gradient(135deg, #0d1b2a 0%, #1a3a5c 55%, #0d2137 100%);
            overflow: hidden;
            text-align: center;
        }
        .contact-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 55% 60% at 20% 50%, rgba(0,184,148,0.15) 0%, transparent 70%),
                radial-gradient(ellipse 45% 55% at 80% 50%, rgba(43,108,176,0.15) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            opacity: 0.2;
            animation: blobFloat 7s ease-in-out infinite;
        }
        .hero-blob-1 { width: 350px; height: 350px; background: #00b894; top: -80px; left: -60px; }
        .hero-blob-2 { width: 280px; height: 280px; background: #2b6cb0; bottom: -60px; right: -40px; animation-delay: 3s; }

        .contact-hero-content { position: relative; z-index: 1; animation: fadeUp 0.7s ease both; }
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
        .contact-hero h1 { font-size: clamp(2rem, 5vw, 3.2rem); font-weight: 800; color: #fff; margin-bottom: 14px; letter-spacing: -0.5px; }
        .contact-hero p  { font-size: 1.05rem; color: rgba(255,255,255,0.65); max-width: 520px; margin: 0 auto; line-height: 1.7; }

        /* ── CONTAINER ── */
        .container { max-width: 1100px; margin: 0 auto; padding: 0 20px; }

        /* ── INFO CARDS ── */
        .contact-info-section { padding: 64px 0 0; }
        .contact-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
        @media (max-width: 900px) { .contact-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 500px) { .contact-grid { grid-template-columns: 1fr; } }

        .contact-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 28px 20px;
            text-align: center;
            box-shadow: 0 1px 6px rgba(0,0,0,0.04);
            animation: fadeUp 0.5s ease both;
            transition: transform 0.25s, box-shadow 0.25s;
        }
        .contact-card:nth-child(2) { animation-delay: 0.07s; }
        .contact-card:nth-child(3) { animation-delay: 0.14s; }
        .contact-card:nth-child(4) { animation-delay: 0.21s; }
        .contact-card:hover { transform: translateY(-5px); box-shadow: 0 10px 28px rgba(0,0,0,0.09); }

        .contact-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }
        .contact-icon svg { width: 22px; height: 22px; }
        .icon-green  { background: rgba(0,184,148,0.12); color: var(--green); }
        .icon-blue   { background: rgba(43,108,176,0.12); color: var(--blue); }
        .icon-purple { background: rgba(128,90,213,0.12); color: #805ad5; }
        .icon-orange { background: rgba(237,137,54,0.12); color: #ed8936; }

        .contact-card h3 { font-size: 0.95rem; font-weight: 700; color: var(--text); margin-bottom: 8px; }
        .contact-card p  { font-size: 0.83rem; color: var(--muted); line-height: 1.6; }

        /* ── FORM SECTION ── */
        .contact-form-section { padding: 48px 0 80px; }
        .contact-form-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px;
        }
        @media (max-width: 760px) { .contact-form-container { grid-template-columns: 1fr; } }

        .form-card, .map-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: 0 1px 6px rgba(0,0,0,0.04);
            overflow: hidden;
            animation: fadeUp 0.5s ease both;
        }
        .map-card { animation-delay: 0.1s; }

        .card-header {
            padding: 20px 28px;
            border-bottom: 1px solid var(--border);
        }
        .card-header h2 { font-size: 1.1rem; font-weight: 700; color: var(--text); margin-bottom: 4px; }
        .card-header p  { font-size: 0.85rem; color: var(--muted); }
        .card-body { padding: 28px; }

        /* Form inputs */
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        @media (max-width: 500px) { .form-row { grid-template-columns: 1fr; } }

        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 0.8rem; font-weight: 600; color: var(--text); margin-bottom: 7px; text-transform: uppercase; letter-spacing: 0.4px; }

        .input-wrap { position: relative; }
        .input-wrap svg {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px; height: 16px;
            color: var(--muted);
            pointer-events: none;
        }
        .input-wrap.textarea-wrap svg { top: 14px; transform: none; }

        .input-wrap input,
        .input-wrap select,
        .input-wrap textarea {
            width: 100%;
            padding: 11px 14px 11px 38px;
            background: var(--bg);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: inherit;
            font-size: 0.9rem;
            color: var(--text);
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .input-wrap input:focus,
        .input-wrap select:focus,
        .input-wrap textarea:focus {
            outline: none;
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(0,184,148,0.15);
            background: #fff;
        }
        .input-wrap textarea { resize: vertical; padding-top: 11px; }

        .checkbox-option { display: flex; align-items: center; gap: 10px; font-size: 0.875rem; color: var(--muted); cursor: pointer; }
        .checkbox-option input[type="checkbox"] { width: 16px; height: 16px; accent-color: var(--green); }

        .btn-submit {
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
            margin-top: 6px;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,184,148,0.45); }

        /* Map placeholder */
        .map-placeholder {
            height: 220px;
            background: linear-gradient(135deg, #e2e8f0, #edf2f7);
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: var(--muted);
            margin-bottom: 24px;
        }
        .map-placeholder svg { width: 40px; height: 40px; color: var(--green); opacity: 0.7; }
        .map-placeholder p { font-size: 0.875rem; font-weight: 500; }

        /* Social */
        .social-contact h3 { font-size: 0.95rem; font-weight: 700; color: var(--text); margin-bottom: 14px; }
        .social-icons { display: flex; gap: 12px; flex-wrap: wrap; }
        .social-icon {
            width: 44px; height: 44px;
            background: var(--bg);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--muted);
            text-decoration: none;
            transition: background 0.2s, border-color 0.2s, color 0.2s, transform 0.2s;
        }
        .social-icon:hover { background: var(--green); border-color: var(--green); color: #fff; transform: translateY(-3px); }
        .social-icon svg { width: 18px; height: 18px; }

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
            max-width: 440px;
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
        .modal-body { padding: 28px 24px; text-align: center; }
        .success-icon { font-size: 3.5rem; color: var(--green); margin-bottom: 14px; }
        .success-icon svg { width: 56px; height: 56px; }
        .modal-body h4 { font-size: 1.05rem; font-weight: 700; margin-bottom: 8px; }
        .modal-body p  { font-size: 0.875rem; color: var(--muted); }
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

<!-- Contact Hero -->
<section class="contact-hero">
    <div class="hero-blob hero-blob-1"></div>
    <div class="hero-blob hero-blob-2"></div>
    <div class="contact-hero-content">
        <span class="section-label">Contact Us</span>
        <h1>Get In Touch</h1>
        <p>We'd love to hear from you. Reach out with questions, feedback, or partnership inquiries.</p>
    </div>
</section>

<!-- Contact Info Cards -->
<section class="contact-info-section">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-card">
                <div class="contact-icon icon-green">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <h3>Our Office</h3>
                <p>Bole Road, Olympia Area<br>Addis Ababa, Ethiopia</p>
            </div>
            <div class="contact-card">
                <div class="contact-icon icon-blue">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.18 2 2 0 0 1 3.6 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.6a16 16 0 0 0 6 6l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                </div>
                <h3>Phone Number</h3>
                <p>+251 91 234 5678<br>Mon–Fri, 8:30 AM – 5:30 PM EAT</p>
            </div>
            <div class="contact-card">
                <div class="contact-icon icon-purple">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                </div>
                <h3>Email Address</h3>
                <p>info@habeshaevents.com<br>support@habeshaevents.com</p>
            </div>
            <div class="contact-card">
                <div class="contact-icon icon-orange">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <h3>Business Hours</h3>
                <p>Mon–Fri: 8:30 AM – 5:30 PM<br>Saturday: 9:00 AM – 1:00 PM</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form + Map -->
<section class="contact-form-section">
    <div class="container">
        <div class="contact-form-container">
            <!-- Form -->
            <div class="form-card">
                <div class="card-header">
                    <h2>Send Us a Message</h2>
                    <p>Fill out the form and we'll get back to you as soon as possible.</p>
                </div>
                <div class="card-body">
                    <form id="main-contact-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="contact-name">Your Name *</label>
                                <div class="input-wrap">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    <input type="text" id="contact-name" placeholder="Abebe Kebede" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contact-email">Email Address *</label>
                                <div class="input-wrap">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                    <input type="email" id="contact-email" placeholder="you@example.com" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contact-subject">Subject *</label>
                            <div class="input-wrap">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                                <input type="text" id="contact-subject" placeholder="How can we help?" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contact-message">Message *</label>
                            <div class="input-wrap textarea-wrap">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                <textarea id="contact-message" rows="5" placeholder="Tell us more about your inquiry..." required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contact-purpose">Purpose of Contact *</label>
                            <div class="input-wrap">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                <select id="contact-purpose" required>
                                    <option value="">Select a purpose</option>
                                    <option value="general">General Inquiry</option>
                                    <option value="support">Technical Support</option>
                                    <option value="partnership">Partnership Opportunity</option>
                                    <option value="feedback">Feedback/Suggestion</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="checkbox-option">
                                <input type="checkbox" id="newsletter-optin" checked>
                                <span>Subscribe to our newsletter for event updates</span>
                            </label>
                        </div>
                        <button type="submit" class="btn-submit">Send Message</button>
                    </form>
                </div>
            </div>

            <!-- Map + Social -->
            <div class="map-card">
                <div class="card-header">
                    <h2>Find Us in Addis Ababa</h2>
                    <p>We're located in the heart of the city.</p>
                </div>
                <div class="card-body">
                    <div class="map-placeholder">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <p>Bole Road, Olympia Area, Addis Ababa</p>
                    </div>
                    <div class="social-contact">
                        <h3>Connect With Us</h3>
                        <div class="social-icons">
                            <a href="#" class="social-icon" aria-label="Facebook">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                            </a>
                            <a href="#" class="social-icon" aria-label="Telegram">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M21.198 2.433a2.242 2.242 0 0 0-1.022.215l-16.5 6.75a2.25 2.25 0 0 0 .126 4.238l3.553 1.12 1.99 6.045a.75.75 0 0 0 1.317.208l2.853-3.816 4.37 3.21a2.25 2.25 0 0 0 3.497-1.39l2.625-15.75a2.25 2.25 0 0 0-2.809-2.63z"/></svg>
                            </a>
                            <a href="#" class="social-icon" aria-label="Instagram">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                            </a>
                            <a href="#" class="social-icon" aria-label="TikTok">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.18 8.18 0 0 0 4.78 1.52V6.76a4.85 4.85 0 0 1-1.01-.07z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Success Modal -->
<div class="modal" id="contact-success-modal">
    <div class="modal-content success-modal">
        <div class="modal-header">
            <h3>Message Sent Successfully!</h3>
            <button class="modal-close" id="contact-modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <div class="success-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--green)"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <h4>Thank you for contacting us!</h4>
            <p>We'll get back to you within 24 hours.</p>
        </div>
        <div class="modal-footer">
            <button class="btn-outline" id="close-contact-modal">Close</button>
            <a href="/afro/" class="btn-primary">Return to Home</a>
        </div>
    </div>
</div>

<script src="/afro/public/js/common.js"></script>
<script src="/afro/public/js/contact.js"></script>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
</body>
</html>
