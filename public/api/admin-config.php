<?php
// Admin password - change this to a strong password
define('ADMIN_PASSWORD', 'DaanAdmin2026!');

function isAdminAuthenticated() {
    return isset($_COOKIE['admin_token']) && $_COOKIE['admin_token'] === hash('sha256', ADMIN_PASSWORD);
}

function requireAdminAuth() {
    if (!isAdminAuthenticated()) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }
}
