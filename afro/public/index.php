<?php
// Front controller for MVC
require_once '../config/config.php';

$url = $_GET['url'] ?? '';

// Simple router (expand as needed)
switch ($url) {
    case 'profile':
        require_once '../controllers/ProfileController.php';
        break;
    // Add more routes here
    default:
        require_once '../controllers/HomeController.php';
        break;
}
