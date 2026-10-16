<?php
/**
 * CyberSafe — Contact & Feedback Form
 * Accepts student reviews, bug reports, and suggestions with server-side validation,
 * CSRF token protection, and PDO prepared statement execution.
 */

$page_title = 'Contact & Feedback — Security Inquiries';
$active_nav = 'feedback';

require_once __DIR__ . '/includes/header.php';

$errors = [];
$successMessage = '';
$name = '';
$email = '';
$category = 'general';
$message = '';

// Pre-fill email and username if available
$currentUser = getCurrentUser();
if (!empty($currentUser['email']) && !$currentUser['is_guest']) {
    $email = $currentUser['email'];
    $name = $currentUser['username'];
}

// Process POST Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Validate CSRF Token
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (!verifyCsrfToken($csrfToken)) {
        $errors[] = 'Security token verification failed. Please refresh the page and try again.';
    }

    // 2. Retrieve & trim fields
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $category = trim($_POST['category'] ?? 'general');
    $message = trim($_POST['message'] ?? '');

    // 3. Server-side validation
    if (empty($name) || mb_strlen($name) < 2) {
        $errors[] = 'Please provide a valid full name (minimum 2 characters).';
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please provide a valid email address (e.g., student@university.edu).';
    }

    $validCategories = ['phishing_scenario', 'course_suggestion', 'quiz_feedback', 'technical_bug', 'general'];
    if (!in_array($category, $validCategories)) {
        $errors[] = 'Please select a valid feedback category.';
    }

    if (empty($message) || mb_strlen($message) < 10) {
        $errors[] = 'Your message must be at least 10 characters in length.';
    }

    // 4. If validation succeeds, store in MySQL
    if (empty($errors)) {
        if (isDbConnected()) {
            try {
                $db = getDb();
                $stmt = $db->prepare("INSERT INTO feedback (name, email, category, message) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $email, $category, $message]);
                $successMessage = 'Thank you, ' . sanitize($name) . '! Your feedback has been safely recorded in the database.';
                // Reset form fields
                $name = '';
                $message = '';
            } catch (Exception $e) {
                $errors[] = 'Database storage error: Unable to record feedback at this time. Please try again.';
            }
        } else {
            // Graceful fallback for offline mode
            $successMessage = 'Thank you, ' . sanitize($name) . '! Your message was received (Running in local demo mode).';
            $message = '';
        }
    }
}
?>

<div class="container form-wrap">
    <div style="text-align: center; margin-bottom: 2.5rem;">
        <span class="badge badge-cyan" style="margin-bottom: 0.75rem;">Community Input</span>
        <h1>Contact &amp; Educational Feedback</h1>
        <p class="lead">
            Have a question, discovered a suspicious email pattern you want added to our simulator, or found an issue? Send us your feedback below.
        </p>
    </div>

    <!-- Alert Notifications -->
    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success" role="alert">
            <span style="font-size: 1.25rem;">✅</span>
            <div><?= $successMessage ?></div>
        </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger" role="alert">
            <span style="font-size: 1.25rem;">⚠️</span>
            <div>
                <strong>Please resolve the following:</strong>
                <ul style="margin: 0.5rem 0 0 1.25rem; font-size: 0.9rem;">
                    <?php foreach ($errors as $err): ?>
                        <li><?= sanitize($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <!-- Feedback Submission Card -->
    <div class="card">
        <form method="POST" action="feedback.php" id="feedbackForm" novalidate>
            <!-- CSRF Protection Token -->
            <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">

            <!-- Name -->
            <div class="form-group">
                <label for="inputName" class="form-label">
                    Full Name <span class="required">*</span>
                </label>
                <input type="text" id="inputName" name="name" class="form-control" placeholder="e.g. Alex Johnson" value="<?= sanitize($name) ?>" required>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="inputEmail" class="form-label">
                    Email Address <span class="required">*</span>
                </label>
                <input type="email" id="inputEmail" name="email" class="form-control" placeholder="student@apex-university.edu" value="<?= sanitize($email) ?>" required>
                <div class="form-helper">We will never expose your email publicly or send marketing spam.</div>
            </div>

            <!-- Category -->
            <div class="form-group">
                <label for="inputCategory" class="form-label">
                    Feedback Category <span class="required">*</span>
                </label>
                <select id="inputCategory" name="category" class="form-control" required>
                    <option value="general" <?= $category === 'general' ? 'selected' : '' ?>>General Inquiries &amp; Questions</option>
                    <option value="phishing_scenario" <?= $category === 'phishing_scenario' ? 'selected' : '' ?>>Suggest a New Phishing Scenario</option>
                    <option value="course_suggestion" <?= $category === 'course_suggestion' ? 'selected' : '' ?>>Learning Curriculum Suggestion</option>
                    <option value="quiz_feedback" <?= $category === 'quiz_feedback' ? 'selected' : '' ?>>Quiz Question Clarification</option>
                    <option value="technical_bug" <?= $category === 'technical_bug' ? 'selected' : '' ?>>Report a Portal Bug / Glitch</option>
                </select>
            </div>

            <!-- Message -->
            <div class="form-group">
                <label for="inputMessage" class="form-label">
                    Detailed Message <span class="required">*</span>
                </label>
                <textarea id="inputMessage" name="message" class="form-control" rows="5" placeholder="Share your experience, recommendations, or question..." required><?= sanitize($message) ?></textarea>
                <div class="form-helper">Minimum 10 characters. Form is secured against Cross-Site Scripting (XSS).</div>
            </div>

            <!-- Submit Button -->
            <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
                <button type="reset" class="btn btn-outline">Clear Form</button>
                <button type="submit" class="btn btn-primary" id="btnSubmitFeedback">
                    <span aria-hidden="true">📤</span> Submit Feedback
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
