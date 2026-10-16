<?php
/**
 * CyberSafe API — Record Phishing Simulator Attempt
 * Stores the user's scenario evaluation and whether their assessment was correct.
 */

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

$rawInput = file_get_contents('php://input');
$data = json_decode($rawInput, true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid JSON input']);
    exit;
}

$scenarioId = trim($data['scenario_id'] ?? '');
$userVerdict = trim($data['user_verdict'] ?? '');
$isCorrect = !empty($data['is_correct']) ? 1 : 0;

if (empty($scenarioId) || !in_array($userVerdict, ['phishing', 'legitimate'])) {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'Invalid parameters']);
    exit;
}

if (!isDbConnected()) {
    echo json_encode(['success' => true, 'mode' => 'offline']);
    exit;
}

try {
    $db = getDb();
    $currentUser = getCurrentUser();
    $numericUserId = $currentUser['numeric_id'];

    if (!$numericUserId) {
        $guestUsername = sanitize($currentUser['username']);
        $guestEmail = sanitize($currentUser['email']);
        $dummyHash = password_hash('guest_pass_' . bin2hex(random_bytes(8)), PASSWORD_DEFAULT);

        $stmt = $db->prepare("INSERT INTO users (username, email, password_hash, role, is_guest) VALUES (?, ?, ?, 'student', 1)");
        $stmt->execute([$guestUsername, $guestEmail, $dummyHash]);
        $numericUserId = (int)$db->lastInsertId();
        $_SESSION['numeric_user_id'] = $numericUserId;
    }

    $stmt = $db->prepare("INSERT INTO simulator_attempts (user_id, scenario_id, user_verdict, is_correct) VALUES (?, ?, ?, ?)");
    $stmt->execute([$numericUserId, $scenarioId, $userVerdict, $isCorrect]);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error recording attempt']);
}
?>
