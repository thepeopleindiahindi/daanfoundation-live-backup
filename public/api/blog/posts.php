<?php
require_once __DIR__ . '/../db-config.php';
require_once __DIR__ . '/../admin-config.php';
header('Content-Type: application/json');

$conn = getDbConnection();
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $slug = $_GET['slug'] ?? '';
        $id = (int)($_GET['id'] ?? 0);
        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = min(50, max(1, (int)($_GET['limit'] ?? 12)));
        $offset = ($page - 1) * $limit;
        $status = $conn->real_escape_string($_GET['status'] ?? 'published');
        $categorySlug = $conn->real_escape_string($_GET['category'] ?? '');
        $tagSlug = $conn->real_escape_string($_GET['tag'] ?? '');
        $search = $conn->real_escape_string($_GET['search'] ?? '');

        if ($slug) {
            $stmt = $conn->prepare("
                SELECT p.*, c.name as category_name, c.slug as category_slug,
                    GROUP_CONCAT(DISTINCT t.name SEPARATOR ',') as tag_names
                FROM blog_posts p
                LEFT JOIN blog_categories c ON p.category_id = c.id
                LEFT JOIN blog_post_tags pt ON p.id = pt.post_id
                LEFT JOIN blog_tags t ON pt.tag_id = t.id
                WHERE p.slug = ?
                GROUP BY p.id
            ");
            $stmt->bind_param('s', $slug);
            $stmt->execute();
            $post = $stmt->get_result()->fetch_assoc();
            if ($post) {
                $post['tags'] = $post['tag_names'] ? explode(',', $post['tag_names']) : [];
                echo json_encode(['success' => true, 'data' => $post]);
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Post not found']);
            }
            break;
        }

        if ($id) {
            $stmt = $conn->prepare("
                SELECT p.*, c.name as category_name, c.slug as category_slug,
                    GROUP_CONCAT(DISTINCT t.name SEPARATOR ',') as tag_names
                FROM blog_posts p
                LEFT JOIN blog_categories c ON p.category_id = c.id
                LEFT JOIN blog_post_tags pt ON p.id = pt.post_id
                LEFT JOIN blog_tags t ON pt.tag_id = t.id
                WHERE p.id = ?
                GROUP BY p.id
            ");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $post = $stmt->get_result()->fetch_assoc();
            if ($post) {
                $post['tags'] = $post['tag_names'] ? explode(',', $post['tag_names']) : [];
                echo json_encode(['success' => true, 'data' => $post]);
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Post not found']);
            }
            break;
        }

        $where = "p.status='$status'";
        if ($categorySlug) $where .= " AND c.slug='$categorySlug'";
        if ($tagSlug) $where .= " AND t.slug='$tagSlug'";
        if ($search) $where .= " AND (p.title LIKE '%$search%' OR p.excerpt LIKE '%$search%')";

        $countResult = $conn->query("SELECT COUNT(DISTINCT p.id) as total FROM blog_posts p LEFT JOIN blog_categories c ON p.category_id = c.id LEFT JOIN blog_post_tags pt ON p.id = pt.post_id LEFT JOIN blog_tags t ON pt.tag_id = t.id WHERE $where");
        $total = $countResult->fetch_assoc()['total'];

        $result = $conn->query("
            SELECT p.*, c.name as category_name, c.slug as category_slug,
                GROUP_CONCAT(DISTINCT t.name SEPARATOR ',') as tag_names
            FROM blog_posts p
            LEFT JOIN blog_categories c ON p.category_id = c.id
            LEFT JOIN blog_post_tags pt ON p.id = pt.post_id
            LEFT JOIN blog_tags t ON pt.tag_id = t.id
            WHERE $where
            GROUP BY p.id
            ORDER BY p.published_at DESC
            LIMIT $limit OFFSET $offset
        ");

        $posts = [];
        while ($row = $result->fetch_assoc()) {
            $row['tags'] = $row['tag_names'] ? explode(',', $row['tag_names']) : [];
            $posts[] = $row;
        }

        echo json_encode([
            'success' => true,
            'data' => $posts,
            'total' => (int)$total,
            'page' => $page,
            'limit' => $limit,
            'totalPages' => ceil($total / $limit),
        ]);
        break;

    case 'POST':
        requireAdminAuth();
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $title = $conn->real_escape_string($input['title']);
        $slug = $conn->real_escape_string($input['slug'] ?: strtolower(str_replace(' ', '-', $title)));
        $excerpt = $conn->real_escape_string($input['excerpt'] ?? '');
        $content = $conn->real_escape_string($input['content'] ?? '');
        $featuredImage = $conn->real_escape_string($input['featured_image'] ?? '');
        $categoryId = (int)($input['category_id'] ?? 0) ?: 'NULL';
        $author = $conn->real_escape_string($input['author'] ?? 'Daan Foundation Team');
        $seoTitle = $conn->real_escape_string($input['seo_title'] ?? '');
        $seoDescription = $conn->real_escape_string($input['seo_description'] ?? '');
        $seoKeywords = $conn->real_escape_string($input['seo_keywords'] ?? '');
        $status = $conn->real_escape_string($input['status'] ?? 'draft');
        $featured = (int)($input['featured'] ?? 0) ? 1 : 0;
        $tags = $input['tags'] ?? [];
        $publishedAt = $status === 'published' ? date('Y-m-d H:i:s') : 'NULL';
        $publishCol = $status === 'published' ? ", published_at='$publishedAt'" : '';

        $idCol = $categoryId === 'NULL' ? 'NULL' : $categoryId;

        $sql = "INSERT INTO blog_posts (title, slug, excerpt, content, featured_image, category_id, author, seo_title, seo_description, seo_keywords, status, featured $publishCol) VALUES ('$title', '$slug', '$excerpt', '$content', '$featuredImage', $idCol, '$author', '$seoTitle', '$seoDescription', '$seoKeywords', '$status', $featured)";

        if ($conn->query($sql)) {
            $postId = $conn->insert_id;
            // Handle tags
            if (!empty($tags)) {
                foreach ($tags as $tagName) {
                    $tagName = $conn->real_escape_string(trim($tagName));
                    if ($tagName) {
                        $tagSlug = strtolower(str_replace(' ', '-', $tagName));
                        $conn->query("INSERT IGNORE INTO blog_tags (name, slug) VALUES ('$tagName', '$tagSlug')");
                        $tagResult = $conn->query("SELECT id FROM blog_tags WHERE slug='$tagSlug'");
                        if ($tagResult && $tagRow = $tagResult->fetch_assoc()) {
                            $conn->query("INSERT IGNORE INTO blog_post_tags (post_id, tag_id) VALUES ($postId, {$tagRow['id']})");
                        }
                    }
                }
            }
            echo json_encode(['success' => true, 'id' => $postId]);
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $conn->error]);
        }
        break;

    case 'PUT':
        requireAdminAuth();
        $input = json_decode(file_get_contents('php://input'), true);
        $id = (int)($input['id'] ?? 0);
        if (!$id) { http_response_code(400); echo json_encode(['success' => false, 'message' => 'ID required']); exit; }

        $fields = [];
        foreach (['title', 'slug', 'excerpt', 'content', 'featured_image', 'author', 'seo_title', 'seo_description', 'seo_keywords', 'status'] as $f) {
            if (isset($input[$f])) $fields[] = "$f='" . $conn->real_escape_string($input[$f]) . "'";
        }
        if (isset($input['category_id'])) $fields[] = "category_id=" . ((int)$input['category_id'] ?: 'NULL');
        if (isset($input['featured'])) $fields[] = "featured=" . ((int)$input['featured'] ? 1 : 0);
        if (isset($input['status']) && $input['status'] === 'published') $fields[] = "published_at=NOW()";

        if (!empty($fields)) {
            $sql = "UPDATE blog_posts SET " . implode(', ', $fields) . " WHERE id=$id";
            if ($conn->query($sql)) {
                // Handle tags if provided
                if (isset($input['tags']) && is_array($input['tags'])) {
                    $conn->query("DELETE FROM blog_post_tags WHERE post_id=$id");
                    foreach ($input['tags'] as $tagName) {
                        $tagName = $conn->real_escape_string(trim($tagName));
                        if ($tagName) {
                            $tagSlug = strtolower(str_replace(' ', '-', $tagName));
                            $conn->query("INSERT IGNORE INTO blog_tags (name, slug) VALUES ('$tagName', '$tagSlug')");
                            $tagResult = $conn->query("SELECT id FROM blog_tags WHERE slug='$tagSlug'");
                            if ($tagResult && $tagRow = $tagResult->fetch_assoc()) {
                                $conn->query("INSERT IGNORE INTO blog_post_tags (post_id, tag_id) VALUES ($id, {$tagRow['id']})");
                            }
                        }
                    }
                }
                echo json_encode(['success' => true]);
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => $conn->error]);
            }
        }
        break;

    case 'DELETE':
        requireAdminAuth();
        $id = (int)($_GET['id'] ?? 0);
        if ($conn->query("DELETE FROM blog_posts WHERE id=$id")) {
            $conn->query("DELETE FROM blog_post_tags WHERE post_id=$id");
            echo json_encode(['success' => true]);
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $conn->error]);
        }
        break;
}

$conn->close();
