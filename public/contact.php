<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

require_once __DIR__ . '/api/db-config.php';

$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request body']);
    exit;
}

$firstName = trim($input['firstName'] ?? '');
$lastName = trim($input['lastName'] ?? '');
$email = trim($input['email'] ?? '');
$subject = trim($input['subject'] ?? '');
$message = trim($input['message'] ?? '');

if (!$firstName || !$email || !$subject || !$message) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'All required fields must be filled']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid email address']);
    exit;
}

$conn = getDbConnection();
$stmt = $conn->prepare("INSERT INTO daan_contacts (firstName, lastName, email, subject, message) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $firstName, $lastName, $email, $subject, $message);
$stmt->execute();
$stmt->close();
$conn->close();

$to = 'daanfoundationindia@gmail.com';
$emailSubject = "Contact Form: $subject";
$emailBody = "Name: $firstName $lastName\nEmail: $email\nSubject: $subject\n\nMessage:\n$message";
$headers = "From: $email\r\nReply-To: $email\r\n";

mail($to, $emailSubject, $emailBody, $headers);

echo json_encode(['success' => true, 'message' => 'Thank you for contacting us. We will get back to you within 24-48 hours.']);
