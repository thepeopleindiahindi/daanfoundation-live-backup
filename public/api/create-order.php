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

$input = json_decode(file_get_contents('php://input'), true);
$amount = intval($input['amount'] ?? 0);
$currency = 'INR';

if ($amount <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid amount']);
    exit;
}

$keyId = getenv('RAZORPAY_KEY_ID') ?: 'rzp_test_xxxxxxxxxxxx';
$keySecret = getenv('RAZORPAY_KEY_SECRET') ?: 'your_test_secret';

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'https://api.razorpay.com/v1/orders',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_USERPWD => "$keyId:$keySecret",
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode([
        'amount' => $amount * 100,
        'currency' => $currency,
        'receipt' => 'donation_' . time(),
        'payment_capture' => 1,
    ]),
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    $order = json_decode($response, true);
    echo json_encode([
        'success' => true,
        'id' => $order['id'],
        'amount' => $order['amount'],
        'currency' => $order['currency'],
        'key' => $keyId,
    ]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to create payment order']);
}
