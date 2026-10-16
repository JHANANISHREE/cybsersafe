<?php
/**
 * CyberSafe — Home Page
 * Welcoming hero, platform purpose, dynamic statistics, and core cybersecurity pillars.
 */

$page_title = 'Home — Cybersecurity Education Portal';
$active_nav = 'home';

require_once __DIR__ . '/includes/header.php';

// Fetch live statistics if database is connected
$statTotalLearners = 1;
$statModulesCompleted = 0;
$statQuizAttempts = 0;
$statAverageScore = 0;

if (isDbConnected()) {
    try {
        $db = getDb();
        // Count registered learners
        $stmt = $db->query("SELECT COUNT(*) FROM users");
        $statTotalLearners = max(1, (int)$stmt->fetchColumn());

        // Count completed modules
        $stmt = $db->query("SELECT COUNT(*) FROM learning_progress");
        $statModulesCompleted = (int)$stmt->fetchColumn();

        // Count quiz attempts and average
        $stmt = $db->query("SELECT COUNT(*), COALESCE(AVG(percentage), 0) FROM quiz_attempts");
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $statQuizAttempts = (int)$row[0];
        $statAverageScore = round((float)$row[1]);
    } catch (Exception $e) {
        // Fallback to defaults gracefully
    }
}
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-pill">
            <span aria-hidden="true">🛡️</span> Interactive Defensive Security Training
        </div>
        <h1>
            Master Cybersecurity Defense.<br>
            <span class="hero-highlight">Detect Phishing Before It Strikes.</span>
        </h1>
        <p>
            CyberSafe is an interactive portal built for college students. Learn how cybercriminals exploit human psychology, inspect realistic simulated phishing emails safely, and evaluate your knowledge with real-time feedback.
        </p>
        <div class="hero-actions">
            <a href="learn.php" class="btn btn-primary btn-lg">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2l-5.5 9h11zM3 13.5h18v7H3z"/>
                </svg>
                Start Learning
            </a>
            <a href="simulator.php" class="btn btn-outline btn-lg">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
                Launch Phishing Simulator
            </a>
            <a href="quiz.php" class="btn btn-success btn-lg">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                </svg>
                Take Cyber Quiz
            </a>
        </div>

        <!-- Dynamic Platform Metrics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value cyan">6</div>
                <div class="stat-label">Core Modules</div>
            </div>
            <div class="stat-card">
                <div class="stat-value green"><?= $statModulesCompleted > 0 ? $statModulesCompleted : '6' ?></div>
                <div class="stat-label"><?= $statModulesCompleted > 0 ? 'Topics Mastered' : 'Curated Topics' ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-value cyan"><?= $statQuizAttempts > 0 ? $statQuizAttempts : '15+' ?></div>
                <div class="stat-label"><?= $statQuizAttempts > 0 ? 'Quizzes Taken' : 'Practice MCQs' ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-value amber"><?= $statAverageScore > 0 ? $statAverageScore . '%' : '5' ?></div>
                <div class="stat-label"><?= $statAverageScore > 0 ? 'Average Score' : 'Simulated Attacks' ?></div>
            </div>
        </div>
    </div>
</section>

<!-- Core Pillars Section -->
<section class="section" style="background-color: var(--bg-secondary);">
    <div class="container">
        <div class="section-title">
            <h2>Essential Cybersecurity Pillars</h2>
            <p>Understand the most frequent attack vectors targeted at college students and developers.</p>
        </div>

        <div class="features-grid">
            <!-- Pillar 1: Phishing Attacks -->
            <article class="card card-glow-cyan">
                <div class="card-header">
                    <div class="card-icon red">
                        📧
                    </div>
                    <span class="badge badge-red">Critical Threat</span>
                </div>
                <h3>Phishing &amp; Email Spoofing</h3>
                <p>
                    Deceptive messages disguised as legitimate communications designed to trick users into handing over credentials, clicking malicious links, or sharing sensitive personal data.
                </p>
                <div style="margin-top: 1rem;">
                    <a href="learn.php#topic-phishing" class="btn btn-outline btn-sm">Read Module &rarr;</a>
                </div>
            </article>

            <!-- Pillar 2: Malware & Ransomware -->
            <article class="card card-glow-cyan">
                <div class="card-header">
                    <div class="card-icon amber">
                        🦠
                    </div>
                    <span class="badge badge-amber">System Defense</span>
                </div>
                <h3>Malware &amp; Ransomware</h3>
                <p>
                    Malicious programs such as trojans, keyloggers, and ransomware that compromise operating systems, log keystrokes, and encrypt personal project files for extortion.
                </p>
                <div style="margin-top: 1rem;">
                    <a href="learn.php#topic-malware" class="btn btn-outline btn-sm">Read Module &rarr;</a>
                </div>
            </article>

            <!-- Pillar 3: Password Security -->
            <article class="card card-glow-green">
                <div class="card-header">
                    <div class="card-icon green">
                        🔑
                    </div>
                    <span class="badge badge-green">Credential Hygiene</span>
                </div>
                <h3>Password Security &amp; MFA</h3>
                <p>
                    Why simple passwords succumb to brute-force and credential stuffing attacks in seconds, and how Multi-Factor Authentication (MFA) blocks up to 99% of automated account takeovers.
                </p>
                <div style="margin-top: 1rem;">
                    <a href="learn.php#topic-passwords" class="btn btn-outline btn-sm">Read Module &rarr;</a>
                </div>
            </article>

            <!-- Pillar 4: Social Engineering -->
            <article class="card card-glow-cyan">
                <div class="card-header">
                    <div class="card-icon cyan">
                        🎭
                    </div>
                    <span class="badge badge-cyan">Human Factor</span>
                </div>
                <h3>Social Engineering</h3>
                <p>
                    The art of manipulating individuals into breaking standard security procedures by exploiting cognitive biases, fear of missing out, urgency, and misplaced trust.
                </p>
                <div style="margin-top: 1rem;">
                    <a href="learn.php#topic-social-eng" class="btn btn-outline btn-sm">Read Module &rarr;</a>
                </div>
            </article>
        </div>
    </div>
</section>

<!-- Call to Action Simulator Spotlight -->
<section class="section">
    <div class="container">
        <div class="card" style="background: linear-gradient(135deg, rgba(0, 242, 254, 0.08), rgba(16, 185, 129, 0.08)), var(--bg-card); border-color: rgba(0, 242, 254, 0.3); padding: 3rem 2rem; text-align: center;">
            <span class="badge badge-cyan" style="margin-bottom: 1rem;">Hands-on Interactive Lab</span>
            <h2 style="margin-bottom: 1rem;">Can You Spot The Hidden Traps?</h2>
            <p style="max-width: 650px; margin: 0 auto 2rem auto;">
                Don't just read about cybersecurity theory. Open our interactive simulated email client, hover over disguised hyperlinks, inspect spoofed header addresses, and practice spotting red flags in a completely safe sandbox.
            </p>
            <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                <a href="simulator.php" class="btn btn-primary btn-lg">Open Phishing Simulator</a>
                <a href="quiz.php" class="btn btn-outline btn-lg">Test Knowledge (15 MCQs)</a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
