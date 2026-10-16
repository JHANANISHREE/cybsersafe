<?php
/**
 * CyberSafe API — Submit Quiz Assessment
 * Receives quiz scoring via JSON POST, validates payload, resolves student ID,
 * and saves attempt to the database via PDO prepared statements.
 */

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

// Read JSON input stream
$rawInput = file_get_contents('php://input');
$data = json_decode($rawInput, true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid JSON input']);
    exit;
}

$score = isset($data['score']) ? (int)$data['score'] : null;
$total = isset($data['total_questions']) ? (int)$data['total_questions'] : null;
$percentage = isset($data['percentage']) ? (float)$data['percentage'] : null;

// Validation
if ($score === null || $total === null || $total <= 0 || $score < 0 || $score > $total) {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'Invalid score parameters']);
    exit;
}

if (!isDbConnected()) {
    // Graceful offline fallback
    echo json_encode(['success' => true, 'mode' => 'offline', 'message' => 'Recorded in offline session']);
    exit;
}

try {
    $db = getDb();
    $currentUser = getCurrentUser();
    $numericUserId = $currentUser['numeric_id'];

    // If guest student has no numeric DB id yet, create a persistent guest record in users table
    if (!$numericUserId) {
        $guestUsername = sanitize($currentUser['username']);
        $guestEmail = sanitize($currentUser['email']);
        $dummyHash = password_hash('guest_pass_' . bin2hex(random_bytes(8)), PASSWORD_DEFAULT);

        $stmt = $db->prepare("INSERT INTO users (username, email, password_hash, role, is_guest) VALUES (?, ?, ?, 'student', 1)");
        $stmt->execute([$guestUsername, $guestEmail, $dummyHash]);
        $numericUserId = (int)$db->lastInsertId();
        $_SESSION['numeric_user_id'] = $numericUserId;
    }

    // Insert Quiz Attempt
    $stmt = $db->prepare("INSERT INTO quiz_attempts (user_id, score, total_questions, percentage) VALUES (?, ?, ?, ?)");
    $stmt->execute([$numericUserId, $score, $total, $percentage]);
    $attemptId = (int)$db->lastInsertId();

    echo json_encode([
        'success' => true,
        'attempt_id' => $attemptId,
        'message' => 'Quiz result saved successfully'
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error recording quiz result']);
}
?>
