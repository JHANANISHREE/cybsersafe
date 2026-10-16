<?php
/**
 * CyberSafe API — Submit Feedback Endpoint
 * Accepts JSON submissions from dynamic feedback forms.
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

$name = trim($data['name'] ?? '');
$email = trim($data['email'] ?? '');
$category = trim($data['category'] ?? 'general');
$message = trim($data['message'] ?? '');

$errors = [];
if (empty($name) || mb_strlen($name) < 2) {
    $errors[] = 'Full name must be at least 2 characters.';
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Valid email is required.';
}

if (empty($message) || mb_strlen($message) < 10) {
    $errors[] = 'Message must be at least 10 characters.';
}

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

if (!isDbConnected()) {
    echo json_encode(['success' => true, 'mode' => 'offline', 'message' => 'Feedback received in demo mode']);
    exit;
}

try {
    $db = getDb();
    $stmt = $db->prepare("INSERT INTO feedback (name, email, category, message) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $category, $message]);

    echo json_encode(['success' => true, 'message' => 'Feedback saved successfully']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error recording feedback']);
}
?>
