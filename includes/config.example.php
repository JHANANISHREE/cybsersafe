<?php
/**
 * CyberSafe — Configuration Template
 * 
 * Instructions:
 * 1. Copy this file to 'config.php' in the same directory.
 * 2. Update DB_USER and DB_PASS to match your local MySQL configuration (e.g., in XAMPP default is user 'root' with empty password).
 * 3. Never commit 'config.php' with sensitive production credentials to public repositories.
 */

// Application Details
define('APP_NAME', 'CyberSafe');
define('APP_TAGLINE', 'Interactive Cybersecurity & Phishing Education Portal');
define('APP_VERSION', '1.0.0');

// Database Configuration (Supports cloud environment variables with local defaults)
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_PORT', getenv('DB_PORT') ?: '3306');
define('DB_NAME', getenv('DB_NAME') ?: 'cybersafe_db');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');

// Session Configuration
define('SESSION_LIFETIME', 86400); // 24 hours in seconds
?>
