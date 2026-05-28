<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Event - Habesha Events</title>
    <link rel="stylesheet" href="/afro/public/css/theme.css">
    <link rel="stylesheet" href="/afro/public/css/style.css">
    <link rel="stylesheet" href="/afro/public/css/post-event.css?v=2">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<?php if (!is_logged_in()): ?>
<div class="auth-notice">
    <i class="fas fa-lock" style="margin-right:6px"></i>
    You must <a href="/afro/?page=login">log in</a> to submit an event.
</div>
<?php endif; ?>

<!-- Post Event Hero -->
<section class="post-event-hero">
    <div class="container">
        <div class="post-event-header">
            <h1>Share Your Event <span class="accent">With Ethiopia</span></h1>
            <p>Reach thousands of potential attendees across Ethiopia and make your event a success</p>
        </div>
    </div>
</section>

<!-- Post Event Form -->
<section class="post-event-form-section">
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h2>Create Your Event in Ethiopia</h2>
                <p>Fill in the details below to list your event on Habesha Events</p>
            </div>

            <form id="post-event-form" method="post" enctype="multipart/form-data" action="/afro/?page=post-event">
                <input type="hidden" name="csrf_token" id="csrf-token" value="">

                <!-- Step 1: Event Basics -->
                <div class="form-step active" id="step-1">
                    <h3 class="step-title">Step 1: Event Basics</h3>
                    <div class="form-group">
                        <label for="event-title">Event Title *</label>
                        <input type="text" id="event-title" name="event_title" placeholder="e.g., Choke Music Festival 2024" required>
                    </div>
                    <div class="form-group">
                        <label for="event-category">Category *</label>
                        <select id="event-category" name="event_category" required>
                            <option value="">Select a category</option>
                            <option value="music">Music</option>
                            <option value="business">Business</option>
                            <option value="art">Art &amp; Culture</option>
                            <option value="sports">Sports</option>
                            <option value="food">Food &amp; Drink</option>
                            <option value="tech">Technology</option>
                            <option value="education">Education</option>
                            <option value="community">Community</option>
                            <option value="religious">Religious</option>
                            <option value="traditional">Traditional</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="event-description">Event Description *</label>
                        <textarea id="event-description" name="event_description" rows="5" placeholder="Describe your event in detail..." required></textarea>
                        <small>Minimum 150 characters.</small>
                        <div class="char-count"><span id="char-count">0</span>/150 characters</div>
                    </div>
                    <div class="form-group">
                        <label for="event-tags">Tags</label>
                        <input type="text" id="event-tags" name="event_tags" placeholder="e.g., concert, festival, networking">
                    </div>
                    <div class="form-navigation">
                        <button type="button" class="btn btn-next" data-next="step-2">Next Step</button>
                    </div>
                </div>

                <!-- Step 2: Date & Location -->
                <div class="form-step" id="step-2">
                    <h3 class="step-title">Step 2: Date &amp; Location</h3>
                    <div class="form-row">
                        <div class="form-group half">
                            <label for="event-date">Event Date *</label>
                            <input type="date" id="event-date" name="event_date" required>
                        </div>
                        <div class="form-group half">
                            <label for="event-time">Event Time *</label>
                            <input type="time" id="event-time" name="event_time" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="event-location">Event Location *</label>
                        <input type="text" id="event-location" name="event_location" placeholder="e.g., Addis Ababa Stadium" required>
                    </div>
                    <div class="form-group">
                        <label for="event-address">Full Address</label>
                        <input type="text" id="event-address" name="event_address" placeholder="Street address, city, region, Ethiopia">
                    </div>
                    <div class="form-row">
                        <div class="form-group half">
                            <label>Event Type</label>
                            <div class="radio-group">
                                <label class="radio-option"><input type="radio" name="event_type" value="in-person" checked><span>In-Person</span></label>
                                <label class="radio-option"><input type="radio" name="event_type" value="online"><span>Online</span></label>
                                <label class="radio-option"><input type="radio" name="event_type" value="hybrid"><span>Hybrid</span></label>
                            </div>
                        </div>
                        <div class="form-group half">
                            <label for="event-duration">Duration</label>
                            <select id="event-duration" name="event_duration">
                                <option value="1">1 hour</option>
                                <option value="2">2 hours</option>
                                <option value="3">3 hours</option>
                                <option value="4">4 hours</option>
                                <option value="full-day">Full day</option>
                                <option value="multiple">Multiple days</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-navigation">
                        <button type="button" class="btn btn-outline btn-prev" data-prev="step-1">Previous</button>
                        <button type="button" class="btn btn-next" data-next="step-3">Next Step</button>
                    </div>
                </div>

                <!-- Step 3: Tickets & Pricing -->
                <div class="form-step" id="step-3">
                    <h3 class="step-title">Step 3: Tickets &amp; Pricing (ETB)</h3>
                    <div class="form-group">
                        <label>Ticket Type</label>
                        <div class="radio-group">
                            <label class="radio-option"><input type="radio" name="ticket_type" value="free" checked><span>Free Event</span></label>
                            <label class="radio-option"><input type="radio" name="ticket_type" value="paid"><span>Paid Event</span></label>
                        </div>
                    </div>
                    <div class="ticket-options" id="paid-ticket-options" style="display:none">
                        <div class="form-row">
                            <div class="form-group half">
                                <label for="ticket-price">Ticket Price (ETB)</label>
                                <input type="number" id="ticket-price" name="ticket_price" min="0" step="0.01" placeholder="49.99">
                            </div>
                            <div class="form-group half">
                                <label for="ticket-quantity-form">Number of Tickets *</label>
                                <input type="number" id="ticket-quantity-form" name="ticket_quantity_form" min="1" max="10000" value="100">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="checkbox-option">
                                <input type="checkbox" id="early-bird-check" name="early_bird_check">
                                <span>Enable early bird pricing</span>
                            </label>
                            <div class="early-bird-details" id="early-bird-details" style="display:none">
                                <div class="form-row">
                                    <div class="form-group half">
                                        <label for="early-price">Early Bird Price (ETB)</label>
                                        <input type="number" id="early-price" name="early_price" min="0" step="0.01">
                                    </div>
                                    <div class="form-group half">
                                        <label for="early-deadline">Early Bird Deadline</label>
                                        <input type="date" id="early-deadline" name="early_deadline">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="free-ticket-options">
                        <label for="free-ticket-quantity">Estimated Attendance</label>
                        <input type="number" id="free-ticket-quantity" name="free_ticket_quantity" min="1" max="10000" value="200">
                    </div>
                    <div class="form-navigation">
                        <button type="button" class="btn btn-outline btn-prev" data-prev="step-2">Previous</button>
                        <button type="button" class="btn btn-next" data-next="step-4">Next Step</button>
                    </div>
                </div>

                <!-- Step 4: Media & Contact -->
                <div class="form-step" id="step-4">
                    <h3 class="step-title">Step 4: Media &amp; Contact Information</h3>
                    <div class="form-group">
                        <label for="event-image">Event Image</label>
                        <div class="image-upload-area" id="image-upload-area">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Click to upload or drag and drop</p>
                            <p class="image-upload-hint">PNG, JPG or GIF (Max. 5MB)</p>
                            <input type="file" id="event-image" name="event_image" accept="image/*" style="display:none">
                        </div>
                        <div class="image-preview" id="image-preview"></div>
                    </div>
                    <div class="form-group">
                        <label for="organizer-name">Organizer Name *</label>
                        <input type="text" id="organizer-name" name="organizer_name" placeholder="Your name or organization" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group half">
                            <label for="organizer-email">Contact Email *</label>
                            <input type="email" id="organizer-email" name="organizer_email" placeholder="contact@yourevent.et" required>
                        </div>
                        <div class="form-group half">
                            <label for="organizer-phone">Contact Phone</label>
                            <input type="tel" id="organizer-phone" name="organizer_phone" placeholder="+251 91 234 5678">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="website">Event Website (Optional)</label>
                        <input type="url" id="website" name="website" placeholder="https://yourevent.et">
                    </div>
                    <div class="form-group">
                        <label>Social Media Links (Optional)</label>
                        <div class="social-inputs">
                            <div class="social-input"><i class="fab fa-facebook"></i><input type="url" name="facebook_url" placeholder="Facebook event URL"></div>
                            <div class="social-input"><i class="fab fa-telegram"></i><input type="url" name="twitter_url" placeholder="Telegram channel"></div>
                            <div class="social-input"><i class="fab fa-instagram"></i><input type="url" name="instagram_url" placeholder="Instagram profile"></div>
                        </div>
                    </div>
                    <div class="form-navigation">
                        <button type="button" class="btn btn-outline btn-prev" data-prev="step-3">Previous</button>
                        <button type="button" class="btn btn-next" data-next="step-5">Next Step</button>
                    </div>
                </div>

                <!-- Step 5: Terms & Submission -->
                <div class="form-step" id="step-5">
                    <h3 class="step-title">Step 5: Terms &amp; Submission</h3>
                    <div class="terms-container">
                        <h4>Habesha Events Terms &amp; Policies</h4>
                        <div class="terms-content">
                            <p>By submitting your event, you agree that all information is accurate, you grant Habesha Events the right to display your event, and your event complies with all applicable Ethiopian laws.</p>
                            <p>For paid events, a 5% service fee applies on all ticket sales in ETB.</p>
                        </div>
                        <div class="checkbox-option terms-checkbox">
                            <input type="checkbox" id="agree-terms" required>
                            <span>I have read and agree to the Habesha Events Terms of Service and Privacy Policy *</span>
                        </div>
                    </div>
                    <div class="event-summary-preview">
                        <h4>Event Summary</h4>
                        <div class="summary-details">
                            <div class="summary-item"><span class="summary-label">Event Title:</span><span class="summary-value" id="summary-title">-</span></div>
                            <div class="summary-item"><span class="summary-label">Date &amp; Time:</span><span class="summary-value" id="summary-date">-</span></div>
                            <div class="summary-item"><span class="summary-label">Location:</span><span class="summary-value" id="summary-location">-</span></div>
                            <div class="summary-item"><span class="summary-label">Ticket Type:</span><span class="summary-value" id="summary-ticket-type">-</span></div>
                        </div>
                    </div>
                    <div class="form-navigation">
                        <button type="button" class="btn btn-outline btn-prev" data-prev="step-4">Previous</button>
                        <button type="submit" class="btn btn-primary btn-submit" id="submit-event">Submit Event</button>
                    </div>
                </div>
            </form>

            <div class="form-progress">
                <div class="progress-bar"><div class="progress-fill" id="progress-fill" style="width:20%"></div></div>
                <div class="progress-steps">
                    <span class="progress-step active">1</span>
                    <span class="progress-step">2</span>
                    <span class="progress-step">3</span>
                    <span class="progress-step">4</span>
                    <span class="progress-step">5</span>
                </div>
                <div class="progress-labels">
                    <span>Basics</span><span>Date &amp; Location</span><span>Tickets</span><span>Media</span><span>Terms</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Success Modal -->
<div class="modal" id="success-modal">
    <div class="modal-content success-modal">
        <div class="modal-header">
            <h3>Event Submitted Successfully!</h3>
            <button class="modal-close" id="success-modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <div style="text-align:center;font-size:60px;color:#28a745;margin-bottom:16px"><i class="fas fa-check-circle"></i></div>
            <h4 style="text-align:center">Your event has been submitted for review!</h4>
            <p style="text-align:center">Our team will review your event within 24 hours. You'll receive an email confirmation once it's approved.</p>
        </div>
        <div class="modal-footer">
            <a href="/afro/?page=events" class="btn btn-primary">Browse Events</a>
        </div>
    </div>
</div>

<script src="/afro/public/js/common.js"></script>
<script src="/afro/public/js/post-event.js"></script>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
</body>
</html>
