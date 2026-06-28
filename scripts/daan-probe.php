<?php
header('Content-Type: text/plain');

echo "=== ACTIVE PLUGINS ===\n";
$plugins = get_option('active_plugins');
sort($plugins);
foreach ($plugins as $p) {
    echo "ACTIVE: $p\n";
}

echo "\n=== ALL PLUGINS (from site-transient) ===\n";
$all = get_site_transient('update_plugins');
if ($all && isset($all->response)) {
    foreach ($all->response as $slug => $data) {
        echo "PLUGIN: $slug\n";
    }
}

echo "\n=== INSTALLED PLUGINS (filesystem scan) ===\n";
$dirs = glob(WP_PLUGIN_DIR . '/*', GLOB_ONLYDIR);
foreach ($dirs as $d) {
    $name = basename($d);
    $active = in_array($name . '/' . $name . '.php', $plugins) || in_array($name . '/index.php', $plugins) ? 'ACTIVE' : 'INACTIVE';
    // Check for main plugin file
    $main = $name . '.php';
    $mainPath = $d . '/' . $main;
    if (!file_exists($mainPath)) {
        $files = glob($d . '/*.php');
        if (!empty($files)) {
            $main = basename($files[0]);
            $mainPath = $files[0];
        }
    }
    $isActive = false;
    foreach ($plugins as $ap) {
        if (strpos($ap, $name . '/') === 0) {
            $isActive = true;
            break;
        }
    }
    echo ($isActive ? 'ACTIVE' : 'INACTIVE') . " : $name\n";
}

echo "\n=== THEME ===\n";
$theme = wp_get_theme();
echo "Name: " . $theme->get('Name') . "\n";
echo "Version: " . $theme->get('Version') . "\n";
echo "Template: " . $theme->get('Template') . "\n";

echo "\n=== PERMALINK STRUCTURE ===\n";
echo get_option('permalink_structure') . "\n";

echo "\n=== PAGE ON FRONT ===\n";
echo "show_on_front: " . get_option('show_on_front') . "\n";
echo "page_on_front: " . get_option('page_on_front') . "\n";
echo "page_for_posts: " . get_option('page_for_posts') . "\n";

echo "\n=== WOOCOMMERCE ===\n";
if (function_exists('WC')) {
    echo "WooCommerce: " . WC()->version . "\n";
}

echo "\n=== RANK MATH ===\n";
if (defined('RANK_MATH_VERSION')) {
    echo "Rank Math version: " . RANK_MATH_VERSION . "\n";
} else {
    echo "Rank Math constant not defined\n";
}
if (function_exists('rank_math')) {
    echo "Rank Math function exists\n";
}

echo "\n=== SEARCH CONSOLE VERIFICATION ===\n";
$verification = get_option('rank_math_google_verification');
echo "Rank Math Google Verification: " . ($verification ?: 'not set') . "\n";
$options = get_option('rank-math-options-general');
if ($options && isset($options['google_verify'])) {
    echo "Google Verify option: " . $options['google_verify'] . "\n";
}

echo "\n=== SITEMAP SETTINGS ===\n";
$sitemap = get_option('rank-math-options-sitemap');
if ($sitemap) {
    echo "Sitemap enabled: " . ($sitemap['enable_sitemap'] ?? 'not set') . "\n";
}

echo "\n=== CACHING ===\n";
echo "WP_CACHE: " . (defined('WP_CACHE') ? (WP_CACHE ? 'true' : 'false') : 'not defined') . "\n";

echo "\n=== MEMORY ===\n";
echo "WP_MEMORY_LIMIT: " . (defined('WP_MEMORY_LIMIT') ? WP_MEMORY_LIMIT : 'not defined') . "\n";

echo "\n=== DONE ===\n";