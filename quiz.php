<?php
/**
 * CyberSafe — Interactive Cyber Quiz
 * 15 Multiple-Choice Questions covering the 6 cybersecurity modules with single-question
 * stepper, real-time score math, instant feedback, and detailed post-quiz review.
 */

$page_title = 'Interactive Cyber Quiz — 15 Questions';
$active_nav = 'quiz';
$page_scripts = ['assets/js/quiz.js'];

require_once __DIR__ . '/includes/header.php';
?>

<div class="container quiz-container">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 2rem;">
        <span class="badge badge-green" style="margin-bottom: 0.75rem;">Knowledge Assessment</span>
        <h1>Interactive Cybersecurity Quiz</h1>
        <p class="lead" style="max-width: 680px; margin: 0 auto;">
            Evaluate your knowledge across 15 multiple-choice questions covering phishing, malware, passwords, social engineering, Wi-Fi safety, and MFA.
        </p>
    </div>

    <!-- Active Quiz Card Area -->
    <div id="quizActiveArea">
        <!-- Progress Bar & Indicator -->
        <div class="quiz-progress-wrap">
            <div class="quiz-progress-meta">
                <span id="quizCounterText">Question 1 of 15</span>
                <span id="quizScoreRunningText">Current Score: 0</span>
            </div>
            <div class="progress-bar-bg" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="15" aria-label="Quiz progress">
                <div class="progress-bar-fill" id="quizProgressBar" style="width: 6.66%;"></div>
            </div>
        </div>

        <!-- Question Container -->
        <article class="quiz-card" id="questionCard">
            <!-- Category Tag -->
            <div class="quiz-question-category">
                <span class="badge badge-cyan" id="questionCategory">Phishing Attacks</span>
            </div>

            <!-- Question Prompt -->
            <h2 class="quiz-question-text" id="questionText">
                Loading question...
            </h2>

            <!-- Answer Options (A, B, C, D) -->
            <div class="quiz-options" id="optionsContainer" role="radiogroup" aria-label="Question options">
                <!-- Injected via quiz.js -->
            </div>

            <!-- In-line Explanation Box (Revealed after selection) -->
            <div class="quiz-explanation-box" id="quizExplanationBox">
                <div id="explanationVerdict" style="font-weight: 700; margin-bottom: 0.35rem;"></div>
                <div id="explanationText" style="color: var(--text-secondary); font-size: 0.95rem;"></div>
            </div>

            <!-- Footer Action Controls -->
            <div class="quiz-footer-actions">
                <button type="button" class="btn btn-outline btn-sm" id="btnRestartEarly" title="Restart quiz from Question 1">
                    Restart
                </button>
                <button type="button" class="btn btn-primary" id="btnNextQuestion" disabled>
                    Next Question &rarr;
                </button>
            </div>
        </article>
    </div>

    <!-- Final Results Screen (Hidden initially) -->
    <div id="quizResultsScreen" style="display: none;">
        <div class="card quiz-results-card">
            <span class="badge badge-cyan" style="margin-bottom: 1rem;">Quiz Complete</span>
            <h2>Your Performance Summary</h2>
            <p style="color: var(--text-muted); margin-bottom: 2rem;">
                Here is your comprehensive breakdown and cybersecurity readiness score:
            </p>

            <!-- Circular Score Dial -->
            <div class="score-circle" id="scoreCircle">
                <div class="score-number" id="finalScoreNumber">0/15</div>
                <div class="score-total" id="finalPercentage">0%</div>
            </div>

            <div id="performanceBadge" style="margin-bottom: 1.5rem; font-size: 1.15rem; font-weight: 700;">
                <!-- Grade title injected dynamically -->
            </div>

            <p id="performanceFeedbackText" style="max-width: 580px; margin: 0 auto 2rem auto; color: var(--text-secondary);">
                <!-- Dynamic feedback text -->
            </p>

            <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                <button type="button" class="btn btn-primary btn-lg" id="btnRetakeQuiz">
                    Retake Quiz
                </button>
                <a href="dashboard.php" class="btn btn-success btn-lg">
                    View in Dashboard
                </a>
                <a href="learn.php" class="btn btn-outline btn-lg">
                    Review Learning Center
                </a>
            </div>

            <!-- Detailed Question-by-Question Review -->
            <div class="review-list">
                <h3 style="margin-bottom: 1.25rem;">Detailed Answer Review</h3>
                <div id="detailedReviewContainer">
                    <!-- Populated dynamically via quiz.js -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
