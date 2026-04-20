<?php
// index.php - serve index.html as a PHP page, inject DB-driven featured events and wire auth
require_once __DIR__ . '/auth.php';

// Load the static HTML template
$tplPath = __DIR__ . '/index.html';
if (!file_exists($tplPath)) {
	echo "Template not found";
	exit;
}
$html = file_get_contents($tplPath);

// Replace navigation links to point to PHP wrappers
$map = [
	'index.html' => 'index.php',
	'events.html' => 'events.php',
	'post-event.html' => 'post-event.php',
	'features.html' => 'features.php',
	'support.html' => 'support.php',
	'contact.html' => 'contact.php'
];
$html = str_replace(array_keys($map), array_values($map), $html);

// Inject executed header include into the template so PHP header (avatar/profile) appears at top
ob_start();
include __DIR__ . '/includes/header.php';
$headerHtml = ob_get_clean();
// insert header right after opening <body> tag
$html = preg_replace('/(<body[^>]*>)/i', "$1\n" . $headerHtml, $html, 1);

// Hide the static HTML nav (replaced by PHP header)
$html = preg_replace('/<nav class="navbar"[^>]*>.*?<\/nav>/s', '', $html);

// Inject PHP footer before </body>
ob_start();
include __DIR__ . '/includes/footer.php';
$footerHtml = ob_get_clean();
// Replace the static footer with PHP footer
$html = preg_replace('/<footer class="footer"[^>]*>.*?<\/footer>/s', $footerHtml, $html);
if (strpos($html, $footerHtml) === false) {
	$html = str_replace('</body>', $footerHtml . '</body>', $html);
}

// Ensure events.css is present on the homepage so event cards use the same styles as events.php
if (strpos($html, 'events.css') === false) {
	$html = str_replace('</head>', '<link rel="stylesheet" href="/afro/events.css"></head>', $html);
}

// Query featured / upcoming events from DB
try {
	$stmt = $pdo->prepare("SELECT id, title, category, description, start_at, event_image, location, ticket_price, ticket_quantity FROM events WHERE status = 'active' ORDER BY featured DESC, start_at ASC LIMIT 6");
	$stmt->execute();
	$events = $stmt->fetchAll();
} catch (Exception $e) {
	error_log('index.php: failed to load events: ' . $e->getMessage());
	$events = [];
}

// Build event cards HTML
$cards = '';
foreach ($events as $ev) {
	$img = htmlspecialchars($ev['event_image'] ?: 'images.jpg');
	$title = htmlspecialchars($ev['title']);
	$category = htmlspecialchars($ev['category']);
	$date = htmlspecialchars(date('F j, Y | g:i A', strtotime($ev['start_at'] ?? 'now')));
	$location = htmlspecialchars($ev['location'] ?? '');
	$price = $ev['ticket_price'] ? 'ETB ' . number_format($ev['ticket_price'], 2) : 'Free';
	$tickets = is_null($ev['ticket_quantity']) ? '—' : intval($ev['ticket_quantity']);
	$desc = htmlspecialchars(mb_substr($ev['description'] ?? '', 0, 140));

	$cards .= "<div class=\"event-card\">\n" .
			  "  <div class=\"event-image\">\n" .
			  "    <img src=\"{$img}\" alt=\"{$title}\">\n" .
			  "    <span class=\"event-category\">{$category}</span>\n" .
			  "    <span class=\"event-price\">{$price}</span>\n" .
			  "  </div>\n" .
			  "  <div class=\"event-info\">\n" .
			  "    <h3><a href=\"/afro/event_detail.php?id={$ev['id']}\" style=\"color:inherit;text-decoration:none;\">{$title}</a></h3>\n" .
			  "    <p class=\"event-date\"><i class=\"far fa-calendar\"></i> {$date}</p>\n" .
			  "    <p class=\"event-location\"><i class=\"fas fa-map-marker-alt\"></i> {$location}</p>\n" .
			  "    <p class=\"event-description\">{$desc}</p>\n" .
			  "    <div class=\"event-footer\">\n" .
			  "      <div class=\"tickets-available\">\n" .
			  "        <i class=\"fas fa-ticket-alt\"></i> <span class=\"ticket-count\">{$tickets}</span> tickets left\n" .
			  "      </div>\n" .
			  "    </div>\n" .
			  "    <div class=\"event-actions\" style=\"margin-top:15px;\">\n" .
			  "      <a href=\"/afro/event_detail.php?id={$ev['id']}\" class=\"btn btn-primary\">View Details</a>\n" .
			  "      <a href=\"/afro/event_detail.php?id={$ev['id']}#booking\" class=\"btn btn-success\">Get Ticket</a>\n" .
			  "    </div>\n" .
			  "  </div>\n" .
			  "</div>\n";
}

// If no cards were generated, show a simple message instead of demo HTML
if (trim($cards) === '') {
	$cards = '<p>No featured events found.</p>';
}

// Inject cards into the template by replacing the whole .events-grid block (removes any static/demo cards)
$pattern = '/(<div[^>]*class="events-grid"[^>]*>)(.*?)(<\/div>\s*<div class="section-footer">)/s';
$replacement = "<div class=\"events-grid events-grid-expanded\">" . $cards . "</div>\n\3";
$new = preg_replace($pattern, $replacement, $html, 1, $replaced);
if ($replaced) {
	$html = $new;
} else {
	// Fallback: replace inner content between first .events-grid and its next closing </div>
	$html = preg_replace('/(<div[^>]*class="events-grid"[^>]*>)(.*?)(<\/div>)/s', "\1" . $cards . "\3", $html, 1);
}

echo $html;
