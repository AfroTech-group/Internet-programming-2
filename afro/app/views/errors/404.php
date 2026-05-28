<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | Habesha Events</title>
    <link rel="stylesheet" href="/afro/public/css/theme.css">
    <link rel="stylesheet" href="/afro/public/css/style.css">
    <style>
        .error-page { text-align: center; padding: 100px 20px; }
        .error-page h1 { font-size: 6rem; color: var(--accent-color, #00b894); margin: 0; }
        .error-page h2 { font-size: 1.8rem; margin-bottom: 16px; }
        .error-page p  { color: #666; margin-bottom: 32px; }
    </style>
</head>
<body>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="error-page">
    <h1>404</h1>
    <h2>Page Not Found</h2>
    <p>The page you're looking for doesn't exist or has been moved.</p>
    <a href="/afro/" class="btn btn-primary">Back to Home</a>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
</body>
</html>
