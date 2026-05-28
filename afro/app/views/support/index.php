<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support - Habesha Events</title>
    <link rel="stylesheet" href="/afro/public/css/theme.css">
    <link rel="stylesheet" href="/afro/public/css/style.css">
    <link rel="stylesheet" href="/afro/public/css/support.css?v=2">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<!-- Support Hero -->
<section class="support-hero">
    <div class="container">
        <div class="support-hero-content">
            <h1>How Can We <span class="accent">Help You?</span></h1>
            <p>Find answers, guides, and contact options for all your Habesha Events needs</p>
            <div class="support-search">
                <div class="search-container">
                    <i class="fas fa-search"></i>
                    <input type="text" id="support-search-input" placeholder="Search for help articles, guides, or FAQs...">
                    <button class="btn btn-primary" id="search-btn">Search</button>
                </div>
                <div class="search-suggestions">
                    <span>Popular: </span>
                    <a href="#faq">Ticket Purchase</a>
                    <a href="#faq">Event Posting</a>
                    <a href="#faq">Refund Policy</a>
                    <a href="#contact">Contact Support</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Support Options -->
<section class="support-options">
    <div class="container">
        <div class="options-grid">
            <a href="#faq" class="option-card"><div class="option-icon"><i class="fas fa-question-circle"></i></div><h3>FAQs</h3><p>Find answers to frequently asked questions</p></a>
            <a href="#guides" class="option-card"><div class="option-icon"><i class="fas fa-book"></i></div><h3>Guides &amp; Tutorials</h3><p>Step-by-step guides for all features</p></a>
            <a href="#contact" class="option-card"><div class="option-icon"><i class="fas fa-envelope"></i></div><h3>Contact Us</h3><p>Get in touch with our support team</p></a>
            <a href="#community" class="option-card"><div class="option-icon"><i class="fas fa-users"></i></div><h3>Community</h3><p>Connect with other users and organizers</p></a>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section" id="faq">
    <div class="container">
        <div class="section-header">
            <h2>Frequently Asked Questions</h2>
            <p>Quick answers to common questions about Habesha Events</p>
        </div>
        <div class="faq-categories">
            <div class="category-tabs">
                <button class="category-tab active" data-category="general">General</button>
                <button class="category-tab" data-category="tickets">Tickets</button>
                <button class="category-tab" data-category="organizers">For Organizers</button>
                <button class="category-tab" data-category="technical">Technical</button>
            </div>
            <div class="faq-container">
                <div class="faq-category active" id="general-faq">
                    <div class="faq-item">
                        <button class="faq-question">What is Habesha Events? <i class="fas fa-chevron-down"></i></button>
                        <div class="faq-answer"><p>Habesha Events is Ethiopia's premier platform for discovering, attending, and hosting events of all types — from cultural festivals and music concerts to business workshops and community gatherings.</p></div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question">Is Habesha Events free to use? <i class="fas fa-chevron-down"></i></button>
                        <div class="faq-answer"><p>Yes, browsing and attending events is completely free. Event organizers pay a small service fee only when they sell tickets. There are no subscription fees for attendees.</p></div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question">How do I create an account? <i class="fas fa-chevron-down"></i></button>
                        <div class="faq-answer"><p>Click the "Sign Up" button in the top navigation and provide your username, email, and password.</p></div>
                    </div>
                </div>
                <div class="faq-category" id="tickets-faq">
                    <div class="faq-item">
                        <button class="faq-question">How do I purchase tickets? <i class="fas fa-chevron-down"></i></button>
                        <div class="faq-answer"><p>Find an event and click "Get Ticket". Select the number of tickets, review the total, and complete checkout. You'll receive a confirmation email with your tickets.</p></div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question">Can I get a refund? <i class="fas fa-chevron-down"></i></button>
                        <div class="faq-answer"><p>Refund policies are set by the event organizer. Check the event page before purchasing for the specific refund policy.</p></div>
                    </div>
                </div>
                <div class="faq-category" id="organizers-faq">
                    <div class="faq-item">
                        <button class="faq-question">How do I post an event? <i class="fas fa-chevron-down"></i></button>
                        <div class="faq-answer"><p>Click "Post Event" in the navigation and follow the step-by-step form. Your event will be reviewed and published within 24 hours.</p></div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question">What are the fees for organizers? <i class="fas fa-chevron-down"></i></button>
                        <div class="faq-answer"><p>Habesha Events charges 3–5% per ticket sold for paid events. Free events have no fees.</p></div>
                    </div>
                </div>
                <div class="faq-category" id="technical-faq">
                    <div class="faq-item">
                        <button class="faq-question">The website isn't loading properly. What should I do? <i class="fas fa-chevron-down"></i></button>
                        <div class="faq-answer"><p>Try refreshing the page or clearing your browser cache. Make sure you're using an updated browser.</p></div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question">I didn't receive my confirmation email. <i class="fas fa-chevron-down"></i></button>
                        <div class="faq-answer"><p>Check your spam folder. You can also access your tickets by logging in and going to "My Bookings". Contact support at +251 91 234 5678 if needed.</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section" id="contact">
    <div class="container">
        <div class="section-header">
            <h2>Contact Our Support Team</h2>
            <p>We're here to help you with any questions or issues</p>
        </div>
        <div class="contact-container">
            <div class="contact-info">
                <h3>Get in Touch</h3>
                <div class="contact-methods">
                    <div class="contact-method">
                        <div class="method-icon"><i class="fas fa-envelope"></i></div>
                        <div class="method-details"><h4>Email Us</h4><p>support@habeshaevents.com</p><small>Typically respond within 24 hours</small></div>
                    </div>
                    <div class="contact-method">
                        <div class="method-icon"><i class="fas fa-phone"></i></div>
                        <div class="method-details"><h4>Call Us</h4><p>+251 91 234 5678</p><small>Mon–Fri, 8:30 AM – 5:30 PM EAT</small></div>
                    </div>
                    <div class="contact-method">
                        <div class="method-icon"><i class="fab fa-telegram"></i></div>
                        <div class="method-details"><h4>Telegram</h4><p>@HabeshaEventsSupport</p><small>Fast responses via Telegram</small></div>
                    </div>
                </div>
            </div>
            <div class="contact-form-container">
                <h3>Send Us a Message</h3>
                <form class="contact-form" id="support-contact-form">
                    <div class="form-group"><label for="support-name">Your Name *</label><input type="text" id="support-name" required></div>
                    <div class="form-group"><label for="support-email">Email Address *</label><input type="email" id="support-email" required></div>
                    <div class="form-group">
                        <label for="support-category">Issue Category *</label>
                        <select id="support-category" required>
                            <option value="">Select a category</option>
                            <option value="technical">Technical Issue</option>
                            <option value="billing">Billing/Payment</option>
                            <option value="event">Event-Related</option>
                            <option value="account">Account Issue</option>
                            <option value="general">General Inquiry</option>
                        </select>
                    </div>
                    <div class="form-group"><label for="support-subject">Subject *</label><input type="text" id="support-subject" required></div>
                    <div class="form-group"><label for="support-message">Message *</label><textarea id="support-message" rows="6" required placeholder="Please describe your issue in detail..."></textarea></div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

<script src="/afro/public/js/common.js"></script>
<script src="/afro/public/js/support.js"></script>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
</body>
</html>
