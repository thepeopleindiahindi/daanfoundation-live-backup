<?php
require_once __DIR__ . '/db-config.php';

$conn = getDbConnection();

$baseUrl = 'https://daan.foundation';

$staticPages = [
    ['loc' => '/', 'priority' => '1.0', 'changefreq' => 'daily'],
    ['loc' => '/about', 'priority' => '0.8', 'changefreq' => 'monthly'],
    ['loc' => '/projects', 'priority' => '0.9', 'changefreq' => 'weekly'],
    ['loc' => '/news', 'priority' => '0.9', 'changefreq' => 'daily'],
    ['loc' => '/get-involved', 'priority' => '0.8', 'changefreq' => 'monthly'],
    ['loc' => '/contact', 'priority' => '0.7', 'changefreq' => 'monthly'],
];

header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($staticPages as $page): ?>
  <url>
    <loc><?php echo $baseUrl . $page['loc'] ?></loc>
    <priority><?php echo $page['priority'] ?></priority>
    <changefreq><?php echo $page['changefreq'] ?></changefreq>
  </url>
<?php endforeach; ?>
<?php
$result = $conn->query("SELECT slug, updated_at FROM blog_posts WHERE status='published' ORDER BY published_at DESC");
while ($post = $result->fetch_assoc()): ?>
  <url>
    <loc><?php echo $baseUrl ?>/news/<?php echo htmlspecialchars($post['slug']) ?></loc>
    <lastmod><?php echo date('c', strtotime($post['updated_at'])) ?></lastmod>
    <priority>0.7</priority>
    <changefreq>monthly</changefreq>
  </url>
<?php endwhile; $conn->close(); ?>
</urlset>
