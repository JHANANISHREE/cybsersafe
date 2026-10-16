<?php
/**
 * CyberSafe — Logout Script
 * Terminates user session and redirects to Home page.
 */

require_once __DIR__ . '/includes/auth.php';

logoutUser();

header('Location: index.php');
exit;
?>
