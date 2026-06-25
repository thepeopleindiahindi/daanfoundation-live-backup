<?php
require_once __DIR__ . '/../db-config.php';
header('Content-Type: application/json');

$conn = getDbConnection();

$queries = [
    "CREATE TABLE IF NOT EXISTS blog_categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL UNIQUE,
        slug VARCHAR(100) NOT NULL UNIQUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    "CREATE TABLE IF NOT EXISTS blog_tags (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL UNIQUE,
        slug VARCHAR(100) NOT NULL UNIQUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    "CREATE TABLE IF NOT EXISTS blog_posts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NOT NULL UNIQUE,
        excerpt TEXT,
        content LONGTEXT,
        featured_image VARCHAR(500),
        category_id INT,
        author VARCHAR(100) DEFAULT 'Daan Foundation Team',
        seo_title VARCHAR(255),
        seo_description TEXT,
        seo_keywords TEXT,
        status ENUM('draft', 'published') DEFAULT 'draft',
        featured TINYINT(1) DEFAULT 0,
        published_at TIMESTAMP NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (category_id) REFERENCES blog_categories(id) ON DELETE SET NULL
    )",

    "CREATE TABLE IF NOT EXISTS blog_post_tags (
        post_id INT NOT NULL,
        tag_id INT NOT NULL,
        PRIMARY KEY (post_id, tag_id),
        FOREIGN KEY (post_id) REFERENCES blog_posts(id) ON DELETE CASCADE,
        FOREIGN KEY (tag_id) REFERENCES blog_tags(id) ON DELETE CASCADE
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

// Insert default category if none exist
$catCheck = $conn->query("SELECT COUNT(*) as cnt FROM blog_categories");
if ($catCheck && $catCheck->fetch_assoc()['cnt'] == 0) {
    $conn->query("INSERT INTO blog_categories (name, slug) VALUES ('News', 'news'), ('Stories', 'stories'), ('Updates', 'updates')");
}

$conn->close();

echo json_encode([
    'success' => true,
    'tables' => [
        'blog_categories' => $results[0],
        'blog_tags' => $results[1],
        'blog_posts' => $results[2],
        'blog_post_tags' => $results[3],
    ],
]);
