<?php
require_once 'wp-load.php';

// Simulate the posts page query
$page_for_posts = get_option('page_for_posts');
$page_on_front = get_option('page_on_front');

echo "page_for_posts: $page_for_posts" . PHP_EOL;
echo "page_on_front: $page_on_front" . PHP_EOL;

// Check what the News page content is (should be empty)
$news_page = get_post(6829);
echo "News page content length: " . strlen($news_page->post_content) . PHP_EOL;
echo "News page template: " . get_page_template_slug(6829) . PHP_EOL;

// Run the home query
query_posts(array(
    'post_type' => 'post',
    'posts_per_page' => 10,
    'paged' => 1,
));

global $wp_query;
echo "have_posts: " . (have_posts() ? 'YES' : 'NO') . PHP_EOL;
echo "post_count: " . $wp_query->post_count . PHP_EOL;
echo "found_posts: " . $wp_query->found_posts . PHP_EOL;
echo "is_home: " . (is_home() ? 'YES' : 'NO') . PHP_EOL;
echo "is_front_page: " . (is_front_page() ? 'YES' : 'NO') . PHP_EOL;
echo "is_archive: " . (is_archive() ? 'YES' : 'NO') . PHP_EOL;
echo "query_vars: " . PHP_EOL;
foreach ($wp_query->query_vars as $k => $v) {
    if (in_array($k, array('post_type', 'posts_per_page', 'paged', 'category', 'cat', 'tax_query', 'meta_query'))) {
        echo "  $k: " . var_export($v, true) . PHP_EOL;
    }
}

wp_reset_query();
