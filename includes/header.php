<?php
/**
 * CyberSafe — Header Component
 * Contains document head, cybersecurity dark-theme assets, and accessible navigation.
 */

require_once __DIR__ . '/auth.php';

$pageTitle = isset($page_title) ? sanitize($page_title) . ' | CyberSafe' : 'CyberSafe — Cybersecurity Awareness & Phishing Education';
$activeNav = $active_nav ?? 'home';
$currentUser = getCurrentUser();
$isDbLive = isDbConnected();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="CyberSafe is an interactive cybersecurity education portal designed to train students in identifying phishing attacks, understanding malware, and testing security knowledge.">
    <title><?= $pageTitle ?></title>

    <!-- Project Stylesheet -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Accessible Navigation Bar -->
    <header class="navbar" role="banner">
        <div class="container nav-container">
            <a href="index.php" class="nav-brand" aria-label="CyberSafe Home">
                <div class="brand-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 2.18l7 3.11v4.71c0 4.54-3.14 8.78-7 9.87-3.86-1.09-7-5.33-7-9.87V6.29l7-3.11zM11 7h2v6h-2V7zm0 8h2v2h-2v-2z"/>
                    </svg>
                </div>
                <div class="brand-text">Cyber<span>Safe</span></div>
            </a>

            <!-- Navigation Links -->
            <nav role="navigation" aria-label="Primary Navigation">
                <ul class="nav-menu" id="navMenu">
                    <li>
                        <a href="index.php" class="nav-link <?= $activeNav === 'home' ? 'active' : '' ?>">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="learn.php" class="nav-link <?= $activeNav === 'learn' ? 'active' : '' ?>">
                            Learning Center
                        </a>
                    </li>
                    <li>
                        <a href="simulator.php" class="nav-link <?= $activeNav === 'simulator' ? 'active' : '' ?>">
                            Phishing Simulator
                        </a>
                    </li>
                    <li>
                        <a href="quiz.php" class="nav-link <?= $activeNav === 'quiz' ? 'active' : '' ?>">
                            Cyber Quiz
                        </a>
                    </li>
                    <li>
                        <a href="dashboard.php" class="nav-link <?= $activeNav === 'dashboard' ? 'active' : '' ?>">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="feedback.php" class="nav-link <?= $activeNav === 'feedback' ? 'active' : '' ?>">
                            Feedback
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Navigation Actions / Student Status -->
            <div class="nav-actions">
                <div class="nav-user-pill" title="<?= $currentUser['is_guest'] ? 'Active Guest Student Session' : 'Logged in Student' ?>">
                    <span class="status-dot" aria-hidden="true"></span>
                    <span><?= sanitize($currentUser['username']) ?></span>
                </div>

                <?php if (isAuthenticated()): ?>
                    <a href="logout.php" class="btn btn-outline btn-sm" title="Log out">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-primary btn-sm">Login / Register</a>
                <?php endif; ?>

                <!-- Mobile Hamburger Toggle Button -->
                <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation menu" aria-expanded="false">
                    &#9776;
                </button>
            </div>
        </div>
    </header>

    <?php if (!$isDbLive): ?>
        <!-- Non-intrusive Graceful Standalone Notification -->
        <div style="background: rgba(245, 158, 11, 0.1); border-bottom: 1px solid rgba(245, 158, 11, 0.3); padding: 0.6rem 1rem; text-align: center; font-size: 0.85rem; color: #fbbf24;">
            <div class="container">
                ℹ️ <strong>Standalone Mode:</strong> MySQL database is offline. All client-side simulators, lessons, and quizzes are fully functional! To enable persistent database logging, start MySQL in XAMPP and import <code>database/database.sql</code>.
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Content Area Starts -->
    <main class="main-content" id="mainContent" role="main">
