<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin — <?php echo htmlspecialchars($event['title'] ?? 'Event Details'); ?> · Habesha Events</title>
    <link rel="stylesheet" href="/afro/public/css/theme.css">
    <link rel="stylesheet" href="/afro/public/css/style.css">
    <link rel="stylesheet" href="/afro/public/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="admin-detail-page">

    <!-- Admin sub-nav -->
    <nav class="admin-subnav">
        <a href="/afro/?page=admin" class="admin-subnav-link active">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            Events
        </a>
        <a href="/afro/?page=admin_users" class="admin-subnav-link">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Users
        </a>
    </nav>

    <!-- Back link -->
    <a href="/afro/?page=admin" class="admin-back-link">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Back to Pending Events
    </a>

    <?php if ($event): ?>

        <!-- Hero card -->
        <div class="admin-detail-hero">
            <div class="admin-detail-image">
                <img src="<?php echo htmlspecialchars($event['event_image'] ?: '/afro/public/images/placeholder.jpg'); ?>"
                     alt="<?php echo htmlspecialchars($event['title']); ?>">
            </div>
            <div class="admin-detail-hero-info">
                <div>
                    <span class="status-badge status-<?php echo htmlspecialchars($event['status']); ?>">
                        <?php if ($event['status'] === 'pending'): ?>
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <?php elseif ($event['status'] === 'active'): ?>
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <?php else: ?>
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        <?php endif; ?>
                        <?php echo ucfirst(htmlspecialchars($event['status'])); ?>
                    </span>
                </div>
                <h1><?php echo htmlspecialchars($event['title']); ?></h1>
                <p class="submitted-at">
                    Submitted on <?php echo htmlspecialchars($event['created_at']); ?>
                </p>
            </div>
        </div>

        <!-- Description -->
        <div class="admin-section">
            <div class="admin-section-header">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="17" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="17" y1="18" x2="3" y2="18"/></svg>
                <h3>Description</h3>
            </div>
            <div class="admin-section-body">
                <p class="admin-description"><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
            </div>
        </div>

        <!-- Event details -->
        <div class="admin-section">
            <div class="admin-section-header">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                <h3>Event Details</h3>
            </div>
            <div class="admin-section-body">
                <div class="admin-detail-grid">
                    <div class="admin-detail-item">
                        <div class="admin-detail-label">Category</div>
                        <div class="admin-detail-value"><?php echo htmlspecialchars($event['category']); ?></div>
                    </div>
                    <div class="admin-detail-item">
                        <div class="admin-detail-label">Date &amp; Time</div>
                        <div class="admin-detail-value"><?php echo htmlspecialchars($event['start_at']); ?></div>
                    </div>
                    <div class="admin-detail-item">
                        <div class="admin-detail-label">Location</div>
                        <div class="admin-detail-value"><?php echo htmlspecialchars($event['location']); ?></div>
                    </div>
                    <div class="admin-detail-item">
                        <div class="admin-detail-label">Event Type</div>
                        <div class="admin-detail-value"><?php echo htmlspecialchars($event['event_type'] ?: 'In-person'); ?></div>
                    </div>
                    <?php if (!empty($event['ticket_price'])): ?>
                    <div class="admin-detail-item">
                        <div class="admin-detail-label">Ticket Price</div>
                        <div class="admin-detail-value"><?php echo htmlspecialchars($event['ticket_price']); ?> ETB</div>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($event['ticket_quantity'])): ?>
                    <div class="admin-detail-item">
                        <div class="admin-detail-label">Tickets Available</div>
                        <div class="admin-detail-value"><?php echo htmlspecialchars($event['ticket_quantity']); ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Organizer -->
        <div class="admin-section">
            <div class="admin-section-header">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <h3>Organizer</h3>
            </div>
            <div class="admin-section-body">
                <div class="admin-detail-grid">
                    <div class="admin-detail-item">
                        <div class="admin-detail-label">Name</div>
                        <div class="admin-detail-value"><?php echo htmlspecialchars($event['organizer_name'] ?: ($event['creator_name'] ?? 'N/A')); ?></div>
                    </div>
                    <div class="admin-detail-item">
                        <div class="admin-detail-label">Email</div>
                        <div class="admin-detail-value"><?php echo htmlspecialchars($event['organizer_email'] ?: ($event['creator_email'] ?? 'N/A')); ?></div>
                    </div>
                    <?php if (!empty($event['organizer_phone'])): ?>
                    <div class="admin-detail-item">
                        <div class="admin-detail-label">Phone</div>
                        <div class="admin-detail-value"><?php echo htmlspecialchars($event['organizer_phone']); ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Actions panel -->
        <?php if ($event['status'] === 'pending'): ?>
        <div class="admin-actions-panel">
            <div>
                <h3>Admin Decision</h3>
                <p>Approve to publish this event, or reject to decline it.</p>
            </div>
            <div class="admin-action-btns">
                <form method="post" action="/afro/?page=admin_action" style="margin:0">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="event_id" value="<?php echo (int)$event['id']; ?>">
                    <input type="hidden" name="action" value="approve">
                    <button type="submit" class="btn-approve-lg">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        Approve Event
                    </button>
                </form>
                <form method="post" action="/afro/?page=admin_action" style="margin:0">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="event_id" value="<?php echo (int)$event['id']; ?>">
                    <input type="hidden" name="action" value="reject">
                    <button type="submit" class="btn-reject-lg">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        Reject Event
                    </button>
                </form>
            </div>
        </div>
        <?php else: ?>
        <div class="admin-actions-panel">
            <div class="admin-already-actioned">
                <?php if ($event['status'] === 'active'): ?>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#38a169" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    This event was <strong>approved</strong> and is now live.
                <?php else: ?>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#e53e3e" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    This event was <strong>rejected</strong>.
                <?php endif; ?>
            </div>
            <a href="/afro/?page=admin" class="btn-view">← Back to Admin Panel</a>
        </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="admin-empty">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <h3>Event not found</h3>
            <p><a href="/afro/?page=admin" style="color:var(--green)">Back to Admin Panel</a></p>
        </div>
    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
</body>
</html>
