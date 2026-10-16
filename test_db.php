<?php
/**
 * CyberSafe — Backend & Database Diagnostic Checker
 * Open http://localhost:8000/test_db.php (or http://localhost/cybersaafe/test_db.php)
 * to test and verify your backend connection in real time!
 */

$page_title = 'Backend Database Diagnostics';
$active_nav = 'dashboard';

require_once __DIR__ . '/includes/config.php';

// Check loaded extensions
$pdoAvailable = extension_loaded('pdo');
$pdoMysqlAvailable = extension_loaded('pdo_mysql');

$dbStatus = false;
$dbMessage = '';
$tablesFound = [];
$sampleUsers = 0;

if ($pdoMysqlAvailable) {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $testPdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 2
        ]);
        $dbStatus = true;
        $dbMessage = 'Successfully connected to MySQL on ' . DB_HOST . ':' . DB_PORT . ' with database "' . DB_NAME . '"!';

        // Check tables
        $stmt = $testPdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        $expected = ['users', 'topics', 'learning_progress', 'quiz_attempts', 'simulator_attempts', 'feedback'];
        foreach ($expected as $exp) {
            $tablesFound[$exp] = in_array($exp, $tables);
        }

        // Count users if table exists
        if (!empty($tablesFound['users'])) {
            $stmt = $testPdo->query("SELECT COUNT(*) FROM users");
            $sampleUsers = (int)$stmt->fetchColumn();
        }
    } catch (PDOException $e) {
        $dbStatus = false;
        $dbMessage = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberSafe — Backend Diagnostics</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .diag-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .diag-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
        .status-badge-ok {
            background: rgba(16, 185, 129, 0.15);
            color: var(--accent-green);
            border: 1px solid rgba(16, 185, 129, 0.3);
            padding: 0.3rem 0.75rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 700;
        }
        .status-badge-bad {
            background: rgba(239, 68, 68, 0.15);
            color: var(--accent-red);
            border: 1px solid rgba(239, 68, 68, 0.3);
            padding: 0.3rem 0.75rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 700;
        }
    </style>
</head>
<body style="padding: 2rem 0;">
    <div class="container" style="max-width: 800px;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <div class="brand-text" style="font-size: 1.75rem; font-weight: 800; margin-bottom: 0.5rem;">
                Cyber<span style="color: var(--accent-cyan);">Safe</span> Backend Diagnostics
            </div>
            <p style="color: var(--text-muted);">
                Use this page to verify if PHP, MySQL, and your database tables are communicating properly.
            </p>
            <a href="index.php" class="btn btn-outline btn-sm">&larr; Back to CyberSafe Portal</a>
        </div>

        <!-- 1. PHP Runtime Check -->
        <div class="diag-card">
            <div class="diag-header">
                <div>
                    <h3 style="margin: 0;">1. PHP Server &amp; Extensions</h3>
                    <span style="font-size: 0.85rem; color: var(--text-muted);">Current PHP Version: <?= phpversion() ?></span>
                </div>
                <span class="status-badge-ok">ACTIVE</span>
            </div>
            <div style="font-size: 0.95rem; line-height: 1.7;">
                <div>PDO Core Driver: <strong><?= $pdoAvailable ? '✅ Installed' : '❌ Missing' ?></strong></div>
                <div>PDO MySQL Driver: <strong><?= $pdoMysqlAvailable ? '✅ Enabled' : '❌ Disabled in php.ini' ?></strong></div>
            </div>
        </div>

        <!-- 2. MySQL Connection Check -->
        <div class="diag-card">
            <div class="diag-header">
                <div>
                    <h3 style="margin: 0;">2. MySQL Database Connection</h3>
                    <span style="font-size: 0.85rem; color: var(--text-muted);">Host: <?= DB_HOST ?>:<?= DB_PORT ?> &bull; User: <?= DB_USER ?> &bull; DB: <?= DB_NAME ?></span>
                </div>
                <?php if ($dbStatus): ?>
                    <span class="status-badge-ok">CONNECTED</span>
                <?php else: ?>
                    <span class="status-badge-bad">DISCONNECTED</span>
                <?php endif; ?>
            </div>

            <?php if ($dbStatus): ?>
                <div class="alert alert-success" style="margin-bottom: 0;">
                    <div>
                        <strong>Connection Successful!</strong><br>
                        <?= $dbMessage ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-danger" style="margin-bottom: 1rem;">
                    <div>
                        <strong>Unable to Connect to MySQL:</strong><br>
                        <code><?= htmlspecialchars($dbMessage) ?></code>
                    </div>
                </div>

                <div class="edu-callout warning" style="margin-top: 1rem;">
                    <h5>🔧 How to fix this in 30 seconds:</h5>
                    <ol style="padding-left: 1.25rem; font-size: 0.9rem; line-height: 1.7; color: var(--text-secondary);">
                        <li>Open the <strong>XAMPP Control Panel</strong> on your computer.</li>
                        <li>Click the <strong>Start</strong> button next to <strong>MySQL</strong> so it turns green.</li>
                        <li>Open <a href="http://localhost/phpmyadmin" target="_blank" style="color: var(--accent-cyan); text-decoration: underline;">http://localhost/phpmyadmin</a> in your browser.</li>
                        <li>Click <strong>New</strong> on the left, type <code>cybersafe_db</code>, and click <strong>Create</strong>.</li>
                        <li>Click the <strong>Import</strong> tab at the top &rarr; choose <code>database/database.sql</code> &rarr; click <strong>Import</strong>.</li>
                        <li>Refresh this diagnostic page!</li>
                    </ol>
                </div>
            <?php endif; ?>
        </div>

        <!-- 3. Tables Verification -->
        <?php if ($dbStatus): ?>
            <div class="diag-card">
                <div class="diag-header">
                    <div>
                        <h3 style="margin: 0;">3. Database Tables Verification</h3>
                        <span style="font-size: 0.85rem; color: var(--text-muted);">Checking the 6 required relational tables in <code>cybersafe_db</code></span>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                    <?php foreach ($tablesFound as $tableName => $exists): ?>
                        <div style="padding: 0.75rem 1rem; background: var(--bg-input); border-radius: var(--radius-md); border: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                            <code><?= htmlspecialchars($tableName) ?></code>
                            <span><?= $exists ? '<strong style="color: var(--accent-green);">✅ Created</strong>' : '<strong style="color: var(--accent-red);">❌ Missing</strong>' ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div style="margin-top: 1.5rem; text-align: center;">
                    <a href="index.php" class="btn btn-primary">Go to Home Page &rarr;</a>
                    <a href="feedback.php" class="btn btn-outline">Test Feedback Submission &rarr;</a>
                    <a href="quiz.php" class="btn btn-success">Test Quiz Score Saving &rarr;</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
