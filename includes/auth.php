<?php
/**
 * CyberSafe — Authentication & Session Management
 * Handles student login sessions, one-click guest access, and CSRF protection.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/db.php';

// Generate CSRF token if one does not exist for this session
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/**
 * Return current CSRF token for forms
 * @return string
 */
function getCsrfToken() {
    return $_SESSION['csrf_token'] ?? '';
}

/**
 * Validate CSRF token against active session
 * @param string $token
 * @return bool
 */
function verifyCsrfToken($token) {
    if (empty($token) || empty($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Sanitize and escape string for HTML rendering (Prevents XSS attacks)
 * @param string|null $data
 * @return string
 */
function sanitize($data) {
    if ($data === null) return '';
    return htmlspecialchars(trim((string)$data), ENT_QUOTES, 'UTF-8');
}

/**
 * Auto-initialize a guest student session if not already logged in
 * Ensures seamless experience for college evaluators without forced registration
 */
function initGuestSessionIfEmpty() {
    if (!isset($_SESSION['user_id'])) {
        $sessionId = session_id();
        $guestHash = substr(md5($sessionId), 0, 6);
        $_SESSION['user_id'] = 'guest_' . $guestHash;
        $_SESSION['numeric_user_id'] = null; // Will map to real DB user if registered
        $_SESSION['username'] = 'Student_' . $guestHash;
        $_SESSION['email'] = 'guest_' . $guestHash . '@cybersafe.local';
        $_SESSION['is_guest'] = true;
        $_SESSION['created_at'] = date('Y-m-d H:i:s');
    }
}

// Call on include to guarantee active student context
initGuestSessionIfEmpty();

/**
 * Get current user information array
 * @return array
 */
function getCurrentUser() {
    return [
        'id' => $_SESSION['user_id'] ?? 'guest',
        'numeric_id' => $_SESSION['numeric_user_id'] ?? null,
        'username' => $_SESSION['username'] ?? 'Guest Student',
        'email' => $_SESSION['email'] ?? 'guest@cybersafe.local',
        'is_guest' => !empty($_SESSION['is_guest']),
        'created_at' => $_SESSION['created_at'] ?? date('Y-m-d H:i:s'),
    ];
}

/**
 * Check if current user is an authenticated (non-guest) registered student
 * @return bool
 */
function isAuthenticated() {
    return !empty($_SESSION['numeric_user_id']) && empty($_SESSION['is_guest']);
}

/**
 * Register or login user into active session
 * @param int $numericId
 * @param string $username
 * @param string $email
 */
function loginUser($numericId, $username, $email) {
    $_SESSION['numeric_user_id'] = $numericId;
    $_SESSION['user_id'] = (string)$numericId;
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['is_guest'] = false;
    $_SESSION['created_at'] = date('Y-m-d H:i:s');
}

/**
 * Log out active user and reset to fresh guest session
 */
function logoutUser() {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}
?>
