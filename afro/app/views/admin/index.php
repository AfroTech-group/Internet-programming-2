<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin — Pending Events · Habesha Events</title>
    <link rel="stylesheet" href="/afro/public/css/theme.css">
    <link rel="stylesheet" href="/afro/public/css/style.css">
    <link rel="stylesheet" href="/afro/public/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="admin-page">

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

    <!-- Page header -->
    <div class="admin-page-header">
        <h1>
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
            </svg>
            Pending Events
        </h1>
        <span class="admin-badge">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <?php echo count($pending ?? []); ?> awaiting review
        </span>
    </div>

    <!-- Stats -->
    <div class="admin-stats">
        <div class="stat-card pending">
            <span class="stat-label">Pending</span>
            <span class="stat-value"><?php echo count($pending ?? []); ?></span>
        </div>
        <?php
        // Quick counts from the same DB if available, otherwise show dashes
        $approvedCount = isset($approvedCount) ? $approvedCount : '—';
        $rejectedCount = isset($rejectedCount) ? $rejectedCount : '—';
        ?>
        <div class="stat-card approved">
            <span class="stat-label">Approved</span>
            <span class="stat-value"><?php echo htmlspecialchars((string)$approvedCount); ?></span>
        </div>
        <div class="stat-card rejected">
            <span class="stat-label">Rejected</span>
            <span class="stat-value"><?php echo htmlspecialchars((string)$rejectedCount); ?></span>
        </div>
    </div>

    <!-- Event list -->
    <?php if (empty($pending)): ?>
        <div class="admin-empty">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                <circle cx="12" cy="12" r="10"/><path d="M8 12h8M12 8v8"/>
            </svg>
            <h3>All clear!</h3>
            <p>There are no events waiting for review right now.</p>
        </div>
    <?php else: ?>
        <div class="admin-events-list">
            <?php foreach ($pending as $e): ?>
                <div class="admin-event-card">
                    <div class="admin-event-thumb">
                        <img src="<?php echo htmlspecialchars($e['event_image'] ?: '/afro/public/images/placeholder.jpg'); ?>"
                             alt="<?php echo htmlspecialchars($e['title']); ?>">
                    </div>

                    <div class="admin-event-body">
                        <div class="admin-event-title">
                            <a href="/afro/?page=admin_event_detail&id=<?php echo (int)$e['id']; ?>">
                                <?php echo htmlspecialchars($e['title']); ?>
                            </a>
                        </div>

                        <div class="admin-event-meta">
                            <span>
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                                <?php echo htmlspecialchars($e['start_at']); ?>
                            </span>
                            <span>
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                <?php echo htmlspecialchars($e['location']); ?>
                            </span>
                            <span>
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                                <?php echo htmlspecialchars($e['category']); ?>
                            </span>
                        </div>

                        <div>
                            <span class="status-badge status-pending">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                Pending Review
                            </span>
                        </div>
                    </div>

                    <div class="admin-event-actions">
                        <a href="/afro/?page=admin_event_detail&id=<?php echo (int)$e['id']; ?>" class="btn-view">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            View
                        </a>
                        <form method="post" action="/afro/?page=admin_action" style="margin:0">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="event_id" value="<?php echo (int)$e['id']; ?>">
                            <input type="hidden" name="action" value="approve">
                            <button type="submit" class="btn-approve">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                Approve
                            </button>
                        </form>
                        <form method="post" action="/afro/?page=admin_action" style="margin:0">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="event_id" value="<?php echo (int)$e['id']; ?>">
                            <input type="hidden" name="action" value="reject">
                            <button type="submit" class="btn-reject">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                Reject
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
</body>
</html>
