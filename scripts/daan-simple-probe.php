<?php echo "PROBE_OK\n"; echo "ACTIVE_PLUGINS:\n";
$plugins = get_option("active_plugins");
sort($plugins);
foreach ($plugins as $p) { echo "  $p\n"; }
echo "page_for_posts: " . get_option("page_for_posts") . "\n";
echo "show_on_front: " . get_option("show_on_front") . "\n";
echo "permalink: " . get_option("permalink_structure") . "\n";
echo "RANK_MATH: " . (defined("RANK_MATH_VERSION") ? RANK_MATH_VERSION : "NOT_DEFINED") . "\n";
?>