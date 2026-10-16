<?php
/**
 * CyberSafe — Database Connection Handler
 * Uses PHP Data Objects (PDO) for secure, prepared SQL execution.
 * Includes graceful fallback if MySQL server is offline.
 */

require_once __DIR__ . '/config.php';

$pdo = null;
$db_connected = false;
$db_error_message = '';

try {
    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::ATTR_TIMEOUT            => 2, // 2 second timeout for fast fallback
    ];
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    $db_connected = true;
} catch (PDOException $e) {
    $pdo = null;
    $db_connected = false;
    $db_error_message = $e->getMessage();
}

/**
 * Get active PDO instance or null
 * @return PDO|null
 */
function getDb() {
    global $pdo;
    return $pdo;
}

/**
 * Check if database is currently reachable
 * @return bool
 */
function isDbConnected() {
    global $db_connected;
    return $db_connected;
}

/**
 * Get database error message if connection failed
 * @return string
 */
function getDbErrorMessage() {
    global $db_error_message;
    return $db_error_message;
}
?>
