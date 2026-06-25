<?php
require_once __DIR__ . '/db-config.php';

header('Content-Type: application/json');

$conn = getDbConnection();

$queries = [
    "CREATE TABLE IF NOT EXISTS daan_donations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        firstName VARCHAR(100) NOT NULL,
        lastName VARCHAR(100) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(50),
        amount DECIMAL(12,2) NOT NULL,
        currency VARCHAR(10) DEFAULT 'INR',
        cause VARCHAR(100),
        frequency VARCHAR(20) DEFAULT 'single',
        paymentId VARCHAR(100),
        orderId VARCHAR(100),
        status VARCHAR(50) DEFAULT 'completed',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    "CREATE TABLE IF NOT EXISTS daan_contacts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        firstName VARCHAR(100) NOT NULL,
        lastName VARCHAR(100) NOT NULL,
        email VARCHAR(255) NOT NULL,
        subject VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    "CREATE TABLE IF NOT EXISTS daan_appeals (
        id INT AUTO_INCREMENT PRIMARY KEY,
        slug VARCHAR(100) UNIQUE NOT NULL,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        goal DECIMAL(12,2),
        raised DECIMAL(12,2) DEFAULT 0,
        active TINYINT(1) DEFAULT 1,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
];

$results = [];
foreach ($queries as $query) {
    if ($conn->query($query)) {
        $results[] = 'OK';
    } else {
        $results[] = 'ERROR: ' . $conn->error;
    }
}

$conn->close();

echo json_encode([
    'success' => !in_array('ERROR', array_map(function($r) { return explode(':', $r)[0]; }, $results)),
    'tables' => [
        'daan_donations' => $results[0],
        'daan_contacts' => $results[1],
        'daan_appeals' => $results[2],
    ],
]);
