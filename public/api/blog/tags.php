<?php
require_once __DIR__ . '/../db-config.php';
header('Content-Type: application/json');

$conn = getDbConnection();
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $result = $conn->query("SELECT * FROM blog_tags ORDER BY name");
        $tags = [];
        while ($row = $result->fetch_assoc()) {
            $tags[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $tags]);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $name = $conn->real_escape_string($input['name']);
        $slug = $conn->real_escape_string($input['slug'] ?: strtolower(str_replace(' ', '-', $name)));
        
        if ($conn->query("INSERT INTO blog_tags (name, slug) VALUES ('$name', '$slug')")) {
            echo json_encode(['success' => true, 'id' => $conn->insert_id]);
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $conn->error]);
        }
        break;
}

$conn->close();
