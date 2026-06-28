<?php
/**
 * Purge LiteSpeed server cache by sending X-LiteSpeed-Purge header.
 * Must be called before any output.
 */
header('X-LiteSpeed-Purge: *');
header('Cache-Control: no-cache, no-store, must-revalidate');

require_once 'wp-load.php';

// Also try plugin-level purge if available
if (defined('LSCWP_V')) {
    if (class_exists('\LiteSpeed\Purge')) {
        \LiteSpeed\Purge::purge_all();
    }
    do_action('litespeed_purge_all');
}

flush_rewrite_rules();
wp_cache_flush();

$page = get_post(6829);
echo 'PURGE: X-LiteSpeed-Purge: * sent' . PHP_EOL;
echo 'Page 6829: ' . ($page ? $page->post_title . ' (' . $page->post_status . ')' : 'NOT FOUND') . PHP_EOL;
echo 'page_for_posts: ' . get_option('page_for_posts') . PHP_EOL;
echo 'LSCWP active: ' . (defined('LSCWP_V') ? LSCWP_V : 'NO') . PHP_EOL;
