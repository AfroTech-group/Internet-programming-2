<?php
/**
 * index.php — Front Controller / Router
 *
 * Single entry point for the entire application.
 * Routes ?page=xxx to the correct controller and method.
 *
 * Examples:
 *   /afro/                          → HomeController::index()
 *   /afro/?page=events              → EventController::index()
 *   /afro/?page=event_detail&id=5   → EventController::show()
 *   /afro/?page=login               → AuthController::login()
 */

declare(strict_types=1);

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/core/Auth.php';
require_once __DIR__ . '/app/core/Security.php';

// Send security headers on every response
send_security_headers();

$page = $_GET['page'] ?? 'home';

// Route map: slug => [ControllerClass, method]
$routes = [
    // ── REST API routes ──────────────────────────────────────────
    // Events API
    'api_events'         => ['EventApiController',   $_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id']) ? 'index' : 'show'],
    // Bookings API
    'api_bookings'       => ['BookingApiController', $_SERVER['REQUEST_METHOD'] === 'POST' ? 'store' : 'index'],

    // ── Page routes ──────────────────────────────────────────────
    'home'               => ['HomeController',      'index'],
    'events'             => ['EventController',     'index'],
    'event_detail'       => ['EventController',     'show'],
    'bookings'           => ['BookingController',   'index'],
    'admin'              => ['AdminController',     'index'],
    'admin_event_detail' => ['AdminController',     'show'],
    'admin_action'       => ['AdminController',     'action'],
    'admin_users'        => ['AdminController',     'users'],
    'admin_user_get'     => ['AdminController',     'userGet'],
    'admin_user_save'    => ['AdminController',     'userSave'],
    'admin_user_delete'  => ['AdminController',     'userDelete'],
    'login'              => ['AuthController',      'login'],
    'register'           => ['AuthController',      'register'],
    'signup'             => ['AuthController',      'register'],
    'logout'             => ['AuthController',      'logout'],
    'profile'            => ['ProfileController',   $_SERVER['REQUEST_METHOD'] === 'POST' ? 'update' : 'show'],
    'contact'            => ['ContactController',   'index'],
    'features'           => ['FeaturesController',  'index'],
    'support'            => ['SupportController',   'index'],
    'post-event'         => ['PostEventController', 'handle'],
];

if (!isset($routes[$page])) {
    http_response_code(404);
    include __DIR__ . '/app/views/errors/404.php';
    exit;
}

[$controllerClass, $method] = $routes[$page];

// Look in api/ subdirectory for API controllers, then fall back to controllers/
$controllerFile = __DIR__ . '/app/controllers/api/' . $controllerClass . '.php';
if (!file_exists($controllerFile)) {
    $controllerFile = __DIR__ . '/app/controllers/' . $controllerClass . '.php';
}

if (!file_exists($controllerFile)) {
    http_response_code(500);
    echo 'Controller not found: ' . htmlspecialchars($controllerClass);
    exit;
}

require_once $controllerFile;
$controller = new $controllerClass();
$controller->$method();
