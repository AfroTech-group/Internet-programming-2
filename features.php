<?php
require_once __DIR__ . '/auth.php';

$tpl = __DIR__ . '/features.html';
if (!file_exists($tpl)) { echo 'Template not found'; exit; }
$html = file_get_contents($tpl);

$map = [
	'index.html' => 'index.php', 'events.html' => 'events.php',
	'post-event.html' => 'post-event.php', 'features.html' => 'features.php',
	'support.html' => 'support.php', 'contact.html' => 'contact.php'
];
$html = str_replace(array_keys($map), array_values($map), $html);

if (strpos($html, 'theme.css') === false) {
	$html = str_replace('</head>', '<link rel="stylesheet" href="/afro/theme.css"></head>', $html);
}
$html = preg_replace('/<nav class="navbar"[^>]*>.*?<\/nav>/s', '', $html);

$html = preg_replace('/<footer class="footer"[^>]*>.*?<\/footer>/s', '', $html);

ob_start(); include __DIR__ . '/includes/header.php'; $headerHtml = ob_get_clean();
$html = preg_replace('/(<body[^>]*>)/i', "$1\n" . $headerHtml, $html, 1);

ob_start(); include __DIR__ . '/includes/footer.php'; $footerHtml = ob_get_clean();
$html = str_replace('</body>', $footerHtml . '</body>', $html);

echo $html;
