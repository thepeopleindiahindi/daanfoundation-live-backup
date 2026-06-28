<?php
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'u772581407_t4GLi');
define('DB_USER', 'u772581407_ROSKO');
define('DB_PASS', 'PstJs8HBel');

function getDbConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        exit;
    }
    return $conn;
}
