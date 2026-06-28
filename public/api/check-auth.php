<?php
require_once __DIR__ . '/admin-config.php';
header('Content-Type: application/json');

echo json_encode([
    'success' => true,
    'authenticated' => isAdminAuthenticated(),
]);
