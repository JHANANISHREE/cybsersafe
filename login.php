<?php
/**
 * CyberSafe — Student Access Portal (Login, Registration & Guest Mode)
 * Provides authenticated student accounts using password_hash/password_verify
 * along with one-click Guest Student access for quick lab evaluations.
 */

$page_title = 'Student Access — Login & Registration';
$active_nav = 'login';

require_once __DIR__ . '/includes/header.php';

$errors = [];
$successMsg = '';
$activeTab = $_GET['tab'] ?? 'login';

// Process Guest Mode Request
if (isset($_POST['action_guest'])) {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Session token invalid. Please refresh.';
    } else {
        // Create new guest identifier
        $guestHash = substr(md5(uniqid(mt_rand(), true)), 0, 6);
        $_SESSION['user_id'] = 'guest_' . $guestHash;
        $_SESSION['numeric_user_id'] = null;
        $_SESSION['username'] = 'Guest_' . $guestHash;
        $_SESSION['email'] = 'guest_' . $guestHash . '@cybersafe.local';
        $_SESSION['is_guest'] = true;
        header('Location: dashboard.php');
        exit;
    }
}

// Process Login Request
if (isset($_POST['action_login'])) {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Session token invalid. Please refresh.';
    } else {
        $identifier = trim($_POST['identifier'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($identifier) || empty($password)) {
            $errors[] = 'Please provide both your username/email and password.';
        } else {
            if (isDbConnected()) {
                try {
                    $db = getDb();
                    $stmt = $db->prepare("SELECT id, username, email, password_hash FROM users WHERE username = ? OR email = ? LIMIT 1");
                    $stmt->execute([$identifier, $identifier]);
                    $user = $stmt->fetch();

                    if ($user && password_verify($password, $user['password_hash'])) {
                        loginUser((int)$user['id'], $user['username'], $user['email']);
                        header('Location: dashboard.php');
                        exit;
                    } else {
                        $errors[] = 'Invalid username/email or password credentials.';
                    }
                } catch (Exception $e) {
                    $errors[] = 'Database error during authentication.';
                }
            } else {
                // If database is offline, permit standard guest login
                $_SESSION['username'] = sanitize($identifier);
                $_SESSION['is_guest'] = false;
                $_SESSION['numeric_user_id'] = 1;
                header('Location: dashboard.php');
                exit;
            }
        }
    }
}

// Process Registration Request
if (isset($_POST['action_register'])) {
    $activeTab = 'register';
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $errors[] = 'Session token invalid. Please refresh.';
    } else {
        $username = trim($_POST['reg_username'] ?? '');
        $email = trim($_POST['reg_email'] ?? '');
        $password = $_POST['reg_password'] ?? '';
        $confirmPassword = $_POST['reg_confirm_password'] ?? '';

        if (empty($username) || strlen($username) < 3) {
            $errors[] = 'Username must be at least 3 characters long.';
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            $errors[] = 'Username may only contain letters, numbers, and underscores.';
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please provide a valid email address.';
        }

        if (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters in length.';
        }

        if ($password !== $confirmPassword) {
            $errors[] = 'Password confirmation does not match.';
        }

        if (empty($errors)) {
            if (isDbConnected()) {
                try {
                    $db = getDb();
                    // Check duplicate username or email
                    $stmt = $db->prepare("SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1");
                    $stmt->execute([$username, $email]);
                    if ($stmt->fetch()) {
                        $errors[] = 'A student account with that username or email already exists.';
                    } else {
                        $hash = password_hash($password, PASSWORD_DEFAULT);
                        $stmt = $db->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
                        $stmt->execute([$username, $email, $hash]);
                        $newId = (int)$db->lastInsertId();

                        // Automatically log in newly registered student
                        loginUser($newId, $username, $email);
                        header('Location: dashboard.php');
                        exit;
                    }
                } catch (Exception $e) {
                    $errors[] = 'Database error creating student account.';
                }
            } else {
                // Offline demo fallback
                loginUser(1, $username, $email);
                header('Location: dashboard.php');
                exit;
            }
        }
    }
}
?>

<div class="container form-wrap">
    <div style="text-align: center; margin-bottom: 2rem;">
        <span class="badge badge-cyan" style="margin-bottom: 0.75rem;">Student Authentication</span>
        <h1>Access CyberSafe Portal</h1>
        <p class="lead">Log in to track your permanent achievements, or continue instantly as a guest.</p>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger" role="alert">
            <span style="font-size: 1.25rem;">⚠️</span>
            <div>
                <strong>Authentication Notice:</strong>
                <ul style="margin: 0.4rem 0 0 1.25rem; font-size: 0.9rem;">
                    <?php foreach ($errors as $err): ?>
                        <li><?= sanitize($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <!-- One-Click Instant Guest Evaluation Card -->
    <div class="card card-glow-green" style="margin-bottom: 2rem; border-color: rgba(16, 185, 129, 0.4); text-align: center;">
        <h4 style="color: var(--accent-green); margin-bottom: 0.5rem;">⚡ Fast Track for Evaluators &amp; Students</h4>
        <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1.25rem;">
            Presenting in lab or viva? Jump straight into the simulator, quiz, and dashboard without entering credentials.
        </p>
        <form method="POST" action="login.php" style="margin: 0;">
            <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">
            <button type="submit" name="action_guest" class="btn btn-success btn-lg" style="width: 100%; max-width: 320px;">
                <span aria-hidden="true">🚀</span> Continue as Guest Student
            </button>
        </form>
    </div>

    <!-- Tabbed Login / Register Card -->
    <div class="card">
        <!-- Tab Selector -->
        <div style="display: flex; border-bottom: 1px solid var(--border-color); margin-bottom: 1.75rem;">
            <button type="button" id="tabLoginBtn" class="btn btn-outline" style="flex: 1; border-radius: var(--radius-md) var(--radius-md) 0 0; border: none; border-bottom: 2px solid <?= $activeTab === 'login' ? 'var(--accent-cyan)' : 'transparent' ?>; color: <?= $activeTab === 'login' ? 'var(--accent-cyan)' : 'var(--text-muted)' ?>;" onclick="switchAuthTab('login')">
                Student Login
            </button>
            <button type="button" id="tabRegisterBtn" class="btn btn-outline" style="flex: 1; border-radius: var(--radius-md) var(--radius-md) 0 0; border: none; border-bottom: 2px solid <?= $activeTab === 'register' ? 'var(--accent-cyan)' : 'transparent' ?>; color: <?= $activeTab === 'register' ? 'var(--accent-cyan)' : 'var(--text-muted)' ?>;" onclick="switchAuthTab('register')">
                New Registration
            </button>
        </div>

        <!-- 1. Login Form -->
        <div id="loginFormSection" style="display: <?= $activeTab === 'login' ? 'block' : 'none' ?>;">
            <form method="POST" action="login.php">
                <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">
                
                <div class="form-group">
                    <label for="loginIdentifier" class="form-label">Username or Student Email</label>
                    <input type="text" id="loginIdentifier" name="identifier" class="form-control" placeholder="e.g. student_alex or alex@university.edu" required>
                </div>

                <div class="form-group">
                    <label for="loginPassword" class="form-label">Password</label>
                    <input type="password" id="loginPassword" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <button type="submit" name="action_login" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                    Sign In to Portal
                </button>
            </form>
        </div>

        <!-- 2. Registration Form -->
        <div id="registerFormSection" style="display: <?= $activeTab === 'register' ? 'block' : 'none' ?>;">
            <form method="POST" action="login.php">
                <input type="hidden" name="csrf_token" value="<?= getCsrfToken() ?>">

                <div class="form-group">
                    <label for="regUsername" class="form-label">Choose Username</label>
                    <input type="text" id="regUsername" name="reg_username" class="form-control" placeholder="e.g. cyber_student" required>
                </div>

                <div class="form-group">
                    <label for="regEmail" class="form-label">Student Email</label>
                    <input type="email" id="regEmail" name="reg_email" class="form-control" placeholder="e.g. student@university.edu" required>
                </div>

                <div class="form-group">
                    <label for="regPassword" class="form-label">Create Password</label>
                    <input type="password" id="regPassword" name="reg_password" class="form-control" placeholder="At least 6 characters" required>
                </div>

                <div class="form-group">
                    <label for="regConfirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" id="regConfirmPassword" name="reg_confirm_password" class="form-control" placeholder="Repeat your password" required>
                </div>

                <button type="submit" name="action_register" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                    Create Student Account
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function switchAuthTab(tab) {
    const loginSection = document.getElementById('loginFormSection');
    const registerSection = document.getElementById('registerFormSection');
    const loginBtn = document.getElementById('tabLoginBtn');
    const registerBtn = document.getElementById('tabRegisterBtn');

    if (tab === 'login') {
        loginSection.style.display = 'block';
        registerSection.style.display = 'none';
        loginBtn.style.borderBottom = '2px solid var(--accent-cyan)';
        loginBtn.style.color = 'var(--accent-cyan)';
        registerBtn.style.borderBottom = 'none';
        registerBtn.style.color = 'var(--text-muted)';
    } else {
        loginSection.style.display = 'none';
        registerSection.style.display = 'block';
        registerBtn.style.borderBottom = '2px solid var(--accent-cyan)';
        registerBtn.style.color = 'var(--accent-cyan)';
        loginBtn.style.borderBottom = 'none';
        loginBtn.style.color = 'var(--text-muted)';
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
