<?php
require_once 'wp-load.php';

// Check if "News" page exists
$news_page = get_page_by_path('news');
if (!$news_page) {
    $page_id = wp_insert_post(array(
        'post_title'   => 'News',
        'post_name'    => 'news',
        'post_content' => '',
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'post_author'  => 1,
    ));
    if (is_wp_error($page_id)) {
        echo 'Error creating news page: ' . $page_id->get_error_message() . PHP_EOL;
        exit;
    }
    echo 'Created News page with ID: ' . $page_id . PHP_EOL;
} else {
    $page_id = $news_page->ID;
    echo 'News page already exists with ID: ' . $page_id . PHP_EOL;
}

// Set page_for_posts
update_option('page_for_posts', $page_id);
echo 'Set page_for_posts to ' . $page_id . PHP_EOL;

// Verify
$fp = get_option('page_for_posts');
echo 'Verified: page_for_posts = ' . $fp . PHP_EOL;
echo 'Page slug: ' . get_post($fp)->post_name . PHP_EOL;
echo 'Done. Visit /news/ to test.' . PHP_EOL;
