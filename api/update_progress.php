<?php
/**
 * CyberSafe API — Update Learning Progress
 * Toggles a curriculum topic's completion status for the active student.
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
    echo json_encode(['success' => false, 'error' => 'Invalid JSON']);
    exit;
}

$slug = trim($data['slug'] ?? '');
$status = trim($data['status'] ?? 'completed');

$validSlugs = ['phishing', 'malware', 'passwords', 'social-eng', 'safe-browsing', 'mfa'];
if (!in_array($slug, $validSlugs)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'Unknown topic identifier']);
    exit;
}

if (!isDbConnected()) {
    echo json_encode(['success' => true, 'mode' => 'offline', 'slug' => $slug, 'status' => $status]);
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

    if ($status === 'completed') {
        $stmt = $db->prepare("INSERT INTO learning_progress (user_id, topic_slug) VALUES (?, ?) ON DUPLICATE KEY UPDATE completed_at = CURRENT_TIMESTAMP");
        $stmt->execute([$numericUserId, $slug]);
    } else {
        $stmt = $db->prepare("DELETE FROM learning_progress WHERE user_id = ? AND topic_slug = ?");
        $stmt->execute([$numericUserId, $slug]);
    }

    echo json_encode(['success' => true, 'slug' => $slug, 'status' => $status]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error updating progress']);
}
?>
