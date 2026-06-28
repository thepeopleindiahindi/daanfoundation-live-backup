<?php
require_once 'wp-load.php';
$fp = get_option('page_for_posts', 'not set');
$fo = get_option('page_on_front', 'not set');
$sof = get_option('show_on_front', 'not set');
echo 'page_for_posts: ' . var_export($fp, true) . PHP_EOL;
echo 'page_on_front: ' . var_export($fo, true) . PHP_EOL;
echo 'show_on_front: ' . var_export($sof, true) . PHP_EOL;
if (is_numeric($fp) && $fp > 0) {
    $p = get_post($fp);
    echo 'page_for_posts post: ' . ($p ? $p->post_title . ' (' . $p->post_name . ', status=' . $p->post_status . ')' : 'NOT FOUND') . PHP_EOL;
}
// Also check what pages exist
$pages = get_posts(array('post_type' => 'page', 'post_status' => 'publish', 'numberposts' => -1));
echo 'All published pages:' . PHP_EOL;
foreach ($pages as $page) {
    echo '  ID ' . $page->ID . ': ' . $page->post_title . ' (slug: ' . $page->post_name . ')' . PHP_EOL;
}
echo 'Number of posts: ' . wp_count_posts('post')->publish . PHP_EOL;
echo 'Theme: ' . wp_get_theme()->get('TextDomain') . PHP_EOL;
echo 'Active plugins: ' . PHP_EOL;
$plugins = get_option('active_plugins');
foreach ($plugins as $plugin) {
    echo '  ' . $plugin . PHP_EOL;
}
