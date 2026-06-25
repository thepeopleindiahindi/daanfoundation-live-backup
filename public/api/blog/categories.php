<?php
require_once __DIR__ . '/../db-config.php';
header('Content-Type: application/json');

$conn = getDbConnection();
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $result = $conn->query("SELECT c.*, COUNT(p.id) as post_count FROM blog_categories c LEFT JOIN blog_posts p ON c.id = p.category_id AND p.status='published' GROUP BY c.id ORDER BY c.name");
        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $categories]);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $name = $conn->real_escape_string($input['name']);
        $slug = $conn->real_escape_string($input['slug'] ?: strtolower(str_replace(' ', '-', $name)));
        
        if ($conn->query("INSERT INTO blog_categories (name, slug) VALUES ('$name', '$slug')")) {
            echo json_encode(['success' => true, 'id' => $conn->insert_id]);
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $conn->error]);
        }
        break;

    case 'DELETE':
        $id = (int)($_GET['id'] ?? 0);
        if ($conn->query("DELETE FROM blog_categories WHERE id=$id")) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $conn->error]);
        }
        break;
}

$conn->close();
