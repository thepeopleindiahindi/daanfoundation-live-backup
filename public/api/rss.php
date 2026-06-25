<?php
require_once __DIR__ . '/db-config.php';

$conn = getDbConnection();
$baseUrl = 'https://daan.foundation';

$result = $conn->query("SELECT p.*, c.name as category_name FROM blog_posts p LEFT JOIN blog_categories c ON p.category_id = c.id WHERE p.status='published' ORDER BY p.published_at DESC LIMIT 20");

header('Content-Type: application/rss+xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss/">
<channel>
  <title>Daan Foundation</title>
  <link><?php echo $baseUrl ?></link>
  <description>Stories and updates from the Daan Foundation</description>
  <language>en</language>
  <lastBuildDate><?php echo date('r') ?></lastBuildDate>
  <atom:link href="<?php echo $baseUrl ?>/api/rss.php" rel="self" type="application/rss+xml"/>
<?php while ($post = $result->fetch_assoc()): ?>
  <item>
    <title><?php echo htmlspecialchars($post['title']) ?></title>
    <link><?php echo $baseUrl ?>/news/<?php echo htmlspecialchars($post['slug']) ?></link>
    <guid isPermaLink="true"><?php echo $baseUrl ?>/news/<?php echo htmlspecialchars($post['slug']) ?></guid>
    <description><?php echo htmlspecialchars($post['excerpt']) ?></description>
    <pubDate><?php echo date('r', strtotime($post['published_at'])) ?></pubDate>
    <category><?php echo htmlspecialchars($post['category_name'] ?? 'News') ?></category>
    <author><?php echo htmlspecialchars($post['author']) ?></author>
    <?php if ($post['featured_image']): ?>
    <media:content url="<?php echo $baseUrl . htmlspecialchars($post['featured_image']) ?>" medium="image"/>
    <?php endif; ?>
  </item>
<?php endwhile; $conn->close(); ?>
</channel>
</rss>
