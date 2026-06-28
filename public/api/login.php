<?php
require_once __DIR__ . '/admin-config.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$password = $input['password'] ?? '';

if ($password === ADMIN_PASSWORD) {
    $token = hash('sha256', ADMIN_PASSWORD);
    $expiry = time() + 86400 * 7; // 7 days
    setcookie('admin_token', $token, $expiry, '/', '', false, true);
    echo json_encode(['success' => true, 'message' => 'Login successful']);
} else {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Invalid password']);
}
