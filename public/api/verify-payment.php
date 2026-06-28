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

require_once __DIR__ . '/db-config.php';

$input = json_decode(file_get_contents('php://input'), true);
$orderId = $input['razorpay_order_id'] ?? '';
$paymentId = $input['razorpay_payment_id'] ?? '';
$signature = $input['razorpay_signature'] ?? '';

$keySecret = getenv('RAZORPAY_KEY_SECRET') ?: 'your_test_secret';
$expectedSignature = hash_hmac('sha256', "$orderId|$paymentId", $keySecret);

if ($expectedSignature !== $signature) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Payment verification failed']);
    exit;
}

$firstName = htmlspecialchars($input['firstName'] ?? '');
$lastName = htmlspecialchars($input['lastName'] ?? '');
$email = htmlspecialchars($input['email'] ?? '');
$phone = htmlspecialchars($input['phone'] ?? '');
$cause = htmlspecialchars($input['cause'] ?? '');
$amount = intval($input['amount'] ?? 0);

$conn = getDbConnection();
$stmt = $conn->prepare("INSERT INTO daan_donations (firstName, lastName, email, phone, amount, cause, paymentId, orderId) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssisss", $firstName, $lastName, $email, $phone, $amount, $cause, $paymentId, $orderId);
$stmt->execute();
$stmt->close();
$conn->close();

$to = 'daanfoundationindia@gmail.com';
$subject = "New Donation Received - ₹$amount";
$body = "Donation Details:\n\nName: $firstName $lastName\nEmail: $email\nPhone: $phone\nCause: $cause\nAmount: ₹$amount\nPayment ID: $paymentId\nOrder ID: $orderId";
$headers = "From: daanfoundationindia@gmail.com";

mail($to, $subject, $body, $headers);

echo json_encode(['success' => true, 'message' => 'Payment verified and donation recorded']);
