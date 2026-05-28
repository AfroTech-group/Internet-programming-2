<?php
// app/core/Security.php
// Centralised security helpers: CSRF, output escaping, redirect validation,
// security headers, and login rate-limiting.

declare(strict_types=1);

// ── CSRF ─────────────────────────────────────────────────────────────────────

/**
 * Return (and lazily create) the session CSRF token.
 */
function csrf_token(): string
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Emit a hidden <input> carrying the CSRF token.
 */
function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
}

/**
 * Verify the CSRF token submitted with a form or JSON request.
 * Accepts the token from $_POST['csrf_token'] or the X-CSRF-Token header.
 * Aborts with 403 on failure.
 */
function csrf_verify(): void
{
    $sessionToken = $_SESSION['csrf_token'] ?? '';

    // Accept from POST body or custom header (for fetch() / XHR)
    $submitted = $_POST['csrf_token']
        ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');

    if (
        $sessionToken === ''
        || $submitted  === ''
        || !hash_equals($sessionToken, $submitted)
    ) {
        http_response_code(403);
        header('Content-Type: text/plain');
        exit('403 Forbidden – CSRF token mismatch.');
    }
}

/**
 * Verify CSRF for API (JSON) endpoints.
 * Returns a JSON error instead of plain text.
 */
function csrf_verify_api(): void
{
    $sessionToken = $_SESSION['csrf_token'] ?? '';
    $submitted    = $_POST['csrf_token']
        ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');

    if (
        $sessionToken === ''
        || $submitted  === ''
        || !hash_equals($sessionToken, $submitted)
    ) {
        http_response_code(403);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success' => false, 'error' => 'CSRF token mismatch.']);
        exit;
    }
}

// ── Output escaping ───────────────────────────────────────────────────────────

/**
 * HTML-escape a value for safe output in HTML context.
 */
function e(mixed $value): string
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// ── Redirect validation ───────────────────────────────────────────────────────

/**
 * Validate a redirect URL so it only ever points to the same origin.
 * Falls back to $default if the URL is external or malformed.
 */
function safe_redirect(string $url, string $default = '/afro/'): string
{
    $url = trim($url);

    // Allow only relative paths that start with /afro/ (our app root)
    if (
        $url !== ''
        && str_starts_with($url, '/afro/')
        && !str_contains($url, '//')   // block protocol-relative URLs
        && !preg_match('/[\r\n]/', $url) // block header injection
    ) {
        return $url;
    }

    return $default;
}

// ── Security response headers ─────────────────────────────────────────────────

/**
 * Send security headers on every response.
 * Call this once, early in the request lifecycle (index.php).
 */
function send_security_headers(): void
{
    // Prevent MIME-type sniffing
    header('X-Content-Type-Options: nosniff');

    // Deny framing (clickjacking protection)
    header('X-Frame-Options: DENY');

    // Referrer policy — don't leak full URL to third parties
    header('Referrer-Policy: strict-origin-when-cross-origin');

    // Basic CSP — tightened for this app's known sources
    // Adjust if you add more CDNs / inline scripts
    header(
        "Content-Security-Policy: "
        . "default-src 'self'; "
        . "script-src 'self' 'unsafe-inline'; "          // inline scripts used in views
        . "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; "
        . "font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; "
        . "img-src 'self' data: https:; "
        . "connect-src 'self'; "
        . "frame-ancestors 'none';"
    );

    // Permissions policy — disable unused browser features
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
}

// ── Login rate-limiting ───────────────────────────────────────────────────────

/**
 * Record a failed login attempt for the given identifier (username or IP).
 * Stores attempt count + first-attempt timestamp in the session.
 */
function record_failed_login(string $identifier): void
{
    $key = 'login_attempts_' . md5($identifier);
    if (empty($_SESSION[$key])) {
        $_SESSION[$key] = ['count' => 0, 'first' => time()];
    }
    $_SESSION[$key]['count']++;
}

/**
 * Return true if the identifier is currently locked out.
 * Allows MAX_LOGIN_ATTEMPTS attempts within LOCKOUT_WINDOW seconds.
 */
function is_login_locked(string $identifier): bool
{
    $maxAttempts   = 5;
    $lockoutWindow = 15 * 60; // 15 minutes

    $key  = 'login_attempts_' . md5($identifier);
    $data = $_SESSION[$key] ?? null;

    if (!$data) {
        return false;
    }

    // Reset window if it has expired
    if ((time() - $data['first']) > $lockoutWindow) {
        unset($_SESSION[$key]);
        return false;
    }

    return $data['count'] >= $maxAttempts;
}

/**
 * Clear the failed-login counter for an identifier (on successful login).
 */
function clear_login_attempts(string $identifier): void
{
    $key = 'login_attempts_' . md5($identifier);
    unset($_SESSION[$key]);
}
