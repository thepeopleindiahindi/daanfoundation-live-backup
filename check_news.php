<?php
require_once 'wp-load.php';
$page = get_post(6829);
if ($page) {
    echo 'ID: ' . $page->ID . PHP_EOL;
    echo 'Title: ' . $page->post_title . PHP_EOL;
    echo 'Status: ' . $page->post_status . PHP_EOL;
    echo 'Slug: ' . $page->post_name . PHP_EOL;
} else {
    echo 'Page 6829 not found' . PHP_EOL;
}
$fp = get_option('page_for_posts');
echo 'page_for_posts: ' . var_export($fp, true) . PHP_EOL;
echo 'show_on_front: ' . get_option('show_on_front') . PHP_EOL;
echo 'page_on_front: ' . get_option('page_on_front') . PHP_EOL;
// Flush rewrite rules
flush_rewrite_rules();
echo 'Rewrite rules flushed.' . PHP_EOL;
// Re-check after flush
$page2 = get_post(6829);
echo 'After flush - page exists: ' . ($page2 ? 'YES (' . $page2->post_status . ')' : 'NO') . PHP_EOL;
