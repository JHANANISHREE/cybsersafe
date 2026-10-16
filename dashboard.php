<?php
/**
 * CyberSafe — Student Dashboard
 * Visualizes real user learning progress, quiz attempts, simulator scores,
 * and personalized recommended topics with clean empty states.
 */

$page_title = 'Student Dashboard — Progress & Scores';
$active_nav = 'dashboard';

require_once __DIR__ . '/includes/header.php';

$currentUser = getCurrentUser();
$userId = $currentUser['numeric_id'];

// Default zero-state values
$completedTopicsCount = 0;
$completedSlugs = [];
$quizAttempts = [];
$bestQuizScore = 0;
$simulatorAttemptsCount = 0;
$simulatorCorrectCount = 0;
$simulatorAccuracy = 0;

// All 6 defined topics
$allTopics = [
    'phishing' => ['title' => 'Phishing Attacks', 'category' => 'Social Exploits', 'icon' => '🎣'],
    'malware' => ['title' => 'Malware & Ransomware', 'category' => 'System Security', 'icon' => '🦠'],
    'passwords' => ['title' => 'Password Security & MFA', 'category' => 'Access Control', 'icon' => '🔑'],
    'social-eng' => ['title' => 'Social Engineering', 'category' => 'Human Factors', 'icon' => '🎭'],
    'safe-browsing' => ['title' => 'Safe Browsing & Public Wi-Fi', 'category' => 'Network Defense', 'icon' => '📡'],
    'mfa' => ['title' => 'Multi-Factor Authentication', 'category' => 'Authentication', 'icon' => '🛡️']
];

// Fetch genuine stored data if database is connected
if (isDbConnected() && $userId) {
    try {
        $db = getDb();

        // 1. Fetch completed topics
        $stmt = $db->prepare("SELECT topic_slug, completed_at FROM learning_progress WHERE user_id = ? ORDER BY completed_at DESC");
        $stmt->execute([$userId]);
        $rows = $stmt->fetchAll();
        foreach ($rows as $r) {
            $completedSlugs[] = $r['topic_slug'];
        }
        $completedTopicsCount = count($completedSlugs);

        // 2. Fetch quiz attempts
        $stmt = $db->prepare("SELECT id, score, total_questions, percentage, completed_at FROM quiz_attempts WHERE user_id = ? ORDER BY completed_at DESC");
        $stmt->execute([$userId]);
        $quizAttempts = $stmt->fetchAll();

        if (!empty($quizAttempts)) {
            $percentages = array_column($quizAttempts, 'percentage');
            $bestQuizScore = max($percentages);
        }

        // 3. Fetch simulator attempts
        $stmt = $db->prepare("SELECT COUNT(*) as total, SUM(CASE WHEN is_correct = 1 THEN 1 ELSE 0 END) as correct FROM simulator_attempts WHERE user_id = ?");
        $stmt->execute([$userId]);
        $simRow = $stmt->fetch();
        if ($simRow && $simRow['total'] > 0) {
            $simulatorAttemptsCount = (int)$simRow['total'];
            $simulatorCorrectCount = (int)$simRow['correct'];
            $simulatorAccuracy = round(($simulatorCorrectCount / $simulatorAttemptsCount) * 100);
        }
    } catch (Exception $e) {
        // Handled gracefully
    }
}

// Calculate Cyber Readiness Badge & Level
$overallScore = 0;
$moduleWeight = ($completedTopicsCount / 6) * 50; // up to 50 pts
$quizWeight = ($bestQuizScore / 100) * 50;        // up to 50 pts
$overallReadiness = round($moduleWeight + $quizWeight);

$readinessTier = 'Security Novice';
$badgeColor = 'badge-amber';
if ($overallReadiness >= 85) {
    $readinessTier = 'Master Cyber Guardian';
    $badgeColor = 'badge-green';
} elseif ($overallReadiness >= 60) {
    $readinessTier = 'Security Practitioner';
    $badgeColor = 'badge-cyan';
} elseif ($overallReadiness >= 25) {
    $readinessTier = 'Developing Defender';
    $badgeColor = 'badge-amber';
}
?>

<div class="container">
    <!-- Student Profile Header Card -->
    <div class="dashboard-profile-card">
        <div class="avatar-shield" aria-hidden="true">
            <?= strtoupper(substr($currentUser['username'], 0, 1)) ?>
        </div>
        <div style="flex: 1;">
            <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap; margin-bottom: 0.25rem;">
                <h2 style="margin-bottom: 0;"><?= sanitize($currentUser['username']) ?></h2>
                <span class="badge <?= $badgeColor ?>"><?= $readinessTier ?></span>
                <?php if ($currentUser['is_guest']): ?>
                    <span class="badge badge-cyan">Guest Session</span>
                <?php endif; ?>
            </div>
            <p style="color: var(--text-muted); margin-bottom: 0.5rem; font-size: 0.9rem;">
                Registered Email: <code><?= sanitize($currentUser['email']) ?></code> &bull; Overall Readiness: <strong><?= $overallReadiness ?>%</strong>
            </p>
            <div class="progress-bar-bg" style="max-width: 400px; height: 8px;">
                <div class="progress-bar-fill" style="width: <?= $overallReadiness ?>%;"></div>
            </div>
        </div>
        <div>
            <a href="quiz.php" class="btn btn-primary btn-sm">Retake Quiz</a>
        </div>
    </div>

    <!-- 4 Key Metrics Cards -->
    <div class="stats-grid" style="margin-bottom: 2.5rem;">
        <div class="stat-card">
            <div class="stat-value cyan"><?= $completedTopicsCount ?> / 6</div>
            <div class="stat-label">Modules Completed</div>
        </div>
        <div class="stat-card">
            <div class="stat-value green"><?= $bestQuizScore > 0 ? $bestQuizScore . '%' : 'None' ?></div>
            <div class="stat-label">Best Quiz Score</div>
        </div>
        <div class="stat-card">
            <div class="stat-value amber"><?= count($quizAttempts) ?></div>
            <div class="stat-label">Quiz Attempts</div>
        </div>
        <div class="stat-card">
            <div class="stat-value cyan"><?= $simulatorAttemptsCount > 0 ? $simulatorAccuracy . '%' : 'Unranked' ?></div>
            <div class="stat-label">Phishing Accuracy</div>
        </div>
    </div>

    <!-- Two-column Dashboard Layout -->
    <div class="dashboard-grid">
        <!-- Main Column: Quiz Attempts & History -->
        <div>
            <!-- Quiz History Card -->
            <div class="card" style="margin-bottom: 2rem;">
                <div class="card-header">
                    <h3>Quiz Assessment History</h3>
                    <a href="quiz.php" class="btn btn-outline btn-sm">Take New Quiz</a>
                </div>

                <?php if (empty($quizAttempts)): ?>
                    <div class="empty-state">
                        <div class="empty-state-icon" aria-hidden="true">📝</div>
                        <h4>No Quiz Attempts Recorded Yet</h4>
                        <p>Complete the 15-question cybersecurity assessment to track your scores and test your readiness.</p>
                        <a href="quiz.php" class="btn btn-primary btn-sm" style="margin-top: 0.5rem;">Start Assessment Now</a>
                    </div>
                <?php else: ?>
                    <div class="dashboard-table-wrap">
                        <table class="cyber-table">
                            <thead>
                                <tr>
                                    <th>Attempt #</th>
                                    <th>Score</th>
                                    <th>Percentage</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($quizAttempts as $i => $att): ?>
                                    <tr>
                                        <td>#<?= count($quizAttempts) - $i ?></td>
                                        <td><strong><?= (int)$att['score'] ?></strong> / <?= (int)$att['total_questions'] ?></td>
                                        <td>
                                            <span style="color: <?= $att['percentage'] >= 70 ? 'var(--accent-green)' : 'var(--accent-red)' ?>; font-weight: 700;">
                                                <?= (float)$att['percentage'] ?>%
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($att['percentage'] >= 70): ?>
                                                <span class="badge badge-green">Passed</span>
                                            <?php else: ?>
                                                <span class="badge badge-red">Review Needed</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="color: var(--text-muted); font-size: 0.85rem;">
                                            <?= date('M d, Y H:i', strtotime($att['completed_at'])) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Curriculum Progress Breakdown -->
            <div class="card">
                <div class="card-header">
                    <h3>Curriculum Completion Status</h3>
                    <a href="learn.php" class="btn btn-outline btn-sm">Open Learning Center</a>
                </div>

                <div style="display: flex; flex-direction: column; gap: 0.85rem;">
                    <?php foreach ($allTopics as $slug => $topicInfo): ?>
                        <?php $isDone = in_array($slug, $completedSlugs); ?>
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.85rem 1rem; background-color: var(--bg-input); border: 1px solid var(--border-color); border-radius: var(--radius-md);">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <span style="font-size: 1.25rem;"><?= $topicInfo['icon'] ?></span>
                                <div>
                                    <strong style="color: var(--text-primary); font-size: 0.95rem;"><?= sanitize($topicInfo['title']) ?></strong>
                                    <div style="font-size: 0.8rem; color: var(--text-muted);"><?= sanitize($topicInfo['category']) ?></div>
                                </div>
                            </div>
                            <div>
                                <?php if ($isDone): ?>
                                    <span class="badge badge-green">✓ Completed</span>
                                <?php else: ?>
                                    <a href="learn.php#topic-<?= sanitize($slug) ?>" class="btn btn-outline btn-sm">Study</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar Column: Recommended Actions -->
        <div>
            <!-- Recommended Next Step Card -->
            <div class="card card-glow-cyan" style="margin-bottom: 1.75rem;">
                <h4 style="color: var(--accent-cyan); margin-bottom: 0.75rem;">🎯 Recommended Action</h4>
                <?php
                $nextUnfinishedSlug = null;
                foreach ($allTopics as $slug => $tInfo) {
                    if (!in_array($slug, $completedSlugs)) {
                        $nextUnfinishedSlug = $slug;
                        break;
                    }
                }
                ?>

                <?php if ($nextUnfinishedSlug): ?>
                    <p style="font-size: 0.925rem; margin-bottom: 1rem;">
                        Strengthen your defenses by studying our recommended module:
                    </p>
                    <div style="padding: 1rem; background-color: var(--bg-input); border-radius: var(--radius-md); margin-bottom: 1rem;">
                        <strong style="color: var(--text-primary);"><?= $allTopics[$nextUnfinishedSlug]['icon'] ?> <?= sanitize($allTopics[$nextUnfinishedSlug]['title']) ?></strong>
                        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem;">Category: <?= sanitize($allTopics[$nextUnfinishedSlug]['category']) ?></div>
                    </div>
                    <a href="learn.php#topic-<?= sanitize($nextUnfinishedSlug) ?>" class="btn btn-primary" style="width: 100%;">
                        Continue Learning &rarr;
                    </a>
                <?php elseif (empty($quizAttempts)): ?>
                    <p style="font-size: 0.925rem; margin-bottom: 1rem;">
                        You've completed all curriculum topics! Put your skills to the test with our 15-question quiz.
                    </p>
                    <a href="quiz.php" class="btn btn-success" style="width: 100%;">
                        Launch Cyber Quiz &rarr;
                    </a>
                <?php else: ?>
                    <p style="font-size: 0.925rem; color: var(--accent-green); margin-bottom: 1rem;">
                        🎉 Outstanding work! All topics reviewed. Try practicing with the Phishing Simulator or retake the quiz to improve your score!
                    </p>
                    <a href="simulator.php" class="btn btn-primary" style="width: 100%;">
                        Inspect Phishing Scenarios &rarr;
                    </a>
                <?php endif; ?>
            </div>

            <!-- College Project Viva Tip Card -->
            <div class="card">
                <h4 style="color: var(--accent-green); margin-bottom: 0.75rem;">💡 Viva Knowledge Capsule</h4>
                <p style="font-size: 0.85rem; color: var(--text-secondary); line-height: 1.6; margin-bottom: 0.75rem;">
                    <strong>Q: Why is Prepared Statement SQL used in CyberSafe?</strong><br>
                    <span style="color: var(--text-muted);">
                        Prepared statements pre-compile the SQL template on the database engine and transmit user input separately as parameters. This neutralizes SQL Injection by ensuring malicious input is never interpreted as executable SQL syntax.
                    </span>
                </p>
                <div style="font-size: 0.8rem; color: var(--accent-cyan); text-align: right;">
                    <a href="learn.php">Review Security Guides &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
