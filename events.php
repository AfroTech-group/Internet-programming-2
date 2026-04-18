<?php
// events.php - render events list from database and allow simple viewing
require_once __DIR__ . '/auth.php';

// Handle search and filtering
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category = $_GET['category'] ?? '';
$event_type = $_GET['event_type'] ?? '';

// Debug: Log received parameters
error_log('Search params - search: "' . $search . '", category: "' . $category . '", event_type: "' . $event_type . '"');

// Build WHERE clause
$whereConditions = ["status = 'active'"];
$params = [];

if ($search) {
    $whereConditions[] = "(title LIKE :search OR description LIKE :search OR location LIKE :search)";
    $params[':search'] = '%' . $search . '%';
}

if ($category) {
    $whereConditions[] = "category = :category";
    $params[':category'] = $category;
}

if ($event_type) {
    $whereConditions[] = "event_type = :event_type";
    $params[':event_type'] = $event_type;
}
