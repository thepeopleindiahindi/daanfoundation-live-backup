<?php
header("Content-Type: text/plain");
echo "PLUGINS:\n";
$plugs = get_option("active_plugins");
sort($plugs);
foreach ($plugs as $p) { echo "  $p\n"; }
echo "\npage_for_posts: " . var_export(get_option("page_for_posts"), true) . "\n";
echo "show_on_front: " . get_option("show_on_front") . "\n";
echo "page_on_front: " . get_option("page_on_front") . "\n";
echo "permalink: " . get_option("permalink_structure") . "\n";
echo "RM_VER: " . (defined("RANK_MATH_VERSION") ? RANK_MATH_VERSION : "undef") . "\n";
echo "WC_VER: " . (defined("WC_VERSION") ? WC_VERSION : "undef") . "\n";
echo "ELEM_VER: " . (defined("ELEMENTOR_VERSION") ? ELEMENTOR_VERSION : "undef") . "\n";
echo "WP_CACHE: " . (defined("WP_CACHE") ? (WP_CACHE?"yes":"no") : "undef") . "\n";
echo "WP_MEM: " . (defined("WP_MEMORY_LIMIT") ? WP_MEMORY_LIMIT : "undef") . "\n";
echo "ABSPATH: " . ABSPATH . "\n";