<?php
/**
 * Daan Foundation - Theme Activation & Page Creation Script
 * Run once: activates daan-custom, fixes sidebar template, creates all pages.
 */
$start = microtime(true);
require_once __DIR__ . '/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/theme.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/post.php';
require_once ABSPATH . 'wp-admin/includes/taxonomy.php';

$theme_slug = 'daan-custom';
$theme_obj = wp_get_theme($theme_slug);
$log = [];

/**
 * STEP 1: Fix sidebar template hero data mismatch
 */
$tpl_path = get_theme_root() . '/' . $theme_slug . '/tpl-sidebar-content.php';
$tpl_content = file_get_contents($tpl_path);
$old = <<<'PHP'
if ( $page_data && isset( $page_data['hero'] ) ) :

	// ��� Hero Banner �����������������������������������������������
	$hero = $page_data['hero'];
	get_template_part( 'template-parts/hero-banner', null, array(
		'title'    => $hero['title'],
		'subtitle' => $hero['subtitle'],
		'gradient' => $hero['gradient'],
		'image'    => $hero['image'] ?? '',
	) );
PHP;
$new = <<<'PHP'
if ( $page_data && isset( $page_data['title'] ) ) :

	// Hero Banner
	get_template_part( 'template-parts/hero-banner', null, array(
		'title'    => $page_data['title'],
		'subtitle' => $page_data['subtitle'] ?? '',
		'gradient' => $page_data['gradient'] ?? 'from-orange-600 to-orange-700',
		'image'    => $page_data['image'] ?? '',
	) );
PHP;
$tpl_content = str_replace($old, $new, $tpl_content, $count);
if ($count === 1) {
    file_put_contents($tpl_path, $tpl_content);
    $log[] = "Fixed sidebar template hero data reference";
} else {
    $log[] = "WARNING: Sidebar template hero fix did not apply (count=$count)";
}

/**
 * STEP 2: Activate theme
 */
switch_theme($theme_slug);
$log[] = "Theme activated: $theme_slug";

/**
 * STEP 3: Create pages
 */
function create_daan_page($title, $slug, $template = '', $parent_id = 0) {
    $existing = get_page_by_path($slug, OBJECT, 'page');
    if ($existing) {
        $log_entry = "EXISTS: $slug ($title) [ID {$existing->ID}]";
        // Ensure template is set
        if ($template) {
            update_post_meta($existing->ID, '_wp_page_template', $template);
        }
        return ['id' => $existing->ID, 'log' => $log_entry];
    }
    $args = [
        'post_title'    => $title,
        'post_name'     => $slug,
        'post_status'   => 'publish',
        'post_type'     => 'page',
        'post_parent'   => $parent_id,
        'post_content'  => '',
        'meta_input'    => [],
    ];
    if ($template) {
        $args['meta_input']['_wp_page_template'] = $template;
    }
    $id = wp_insert_post($args);
    if (is_wp_error($id)) {
        return ['id' => 0, 'log' => "FAIL: $slug ($title): " . $id->get_error_message()];
    }
    return ['id' => $id, 'log' => "CREATED: $slug ($title) [ID $id]" . ($template ? " template=$template" : '')];
}

$sidebar_template = 'tpl-sidebar-content.php';

// Direct template pages
$direct = [
    'about'             => 'About Us',
    'appeals'           => 'Appeals',
    'bank-details'      => 'Bank Details',
    'contact'           => 'Contact Us',
    'donate'            => 'Donate',
    'orphan-sponsorship'=> 'Orphan Sponsorship',
    'water'             => 'Water for Life',
    'where-we-work'     => 'Where We Work',
    'zakat-calculator'  => 'Zakat Calculator',
];
foreach ($direct as $slug => $title) {
    $result = create_daan_page($title, $slug);
    $log[] = $result['log'];
}

// Sidebar-content pages
$sidebar = [
    'community-kitchen'  => 'Community Kitchen',
    'zakat'              => 'Give Your Zakat',
    'sadaqah'            => 'Give Sadaqah',
    'sadaqah-jariyah'    => 'Give Sadaqah Jariyah',
    'fidya'              => 'Fidyah',
    'kaffarah'           => 'Kaffarah',
    'ramadan'            => 'Ramadan Iftar Program',
    'winter-appeal'      => 'Winter Appeal',
    'where-most-needed'  => 'Where Most Needed',
    'eid-gifts'          => 'Eid Gifts',
    'zakat-al-fitr'      => 'Zakat al-Fitr',
];
foreach ($sidebar as $slug => $title) {
    $result = create_daan_page($title, $slug, $sidebar_template);
    $log[] = $result['log'];
}

// Our-work parent + children
$our_work = create_daan_page('Our Work', 'our-work', $sidebar_template);
$log[] = $our_work['log'];
$parent_id = $our_work['id'];

$children = [
    'impact'                => 'Our Impact',
    'charity-in-action'     => 'Your Charity in Action',
    'community-trust'       => 'Community Trust & Feedback',
    'history'               => 'The History of Daan Foundation',
    'annual-report'         => 'Annual Impact Report',
    'serving-with-dignity'  => 'Serving With Dignity',
    'supporting-women'      => 'Supporting Women With Dignity',
    'donation-is-trust'     => 'Your Donation Is a Trust',
    'empowering-livelihoods'=> 'Empowering Livelihoods',
    'why-transparency'      => 'Why Transparency Matters',
];
foreach ($children as $slug => $title) {
    $result = create_daan_page($title, $slug, $sidebar_template, $parent_id);
    $log[] = $result['log'];
}

// Home page for static front page
$home = create_daan_page('Home', 'home');
$log[] = $home['log'];
if ($home['id']) {
    update_option('page_on_front', $home['id']);
    update_option('show_on_front', 'page');
    $log[] = "Set static front page: Home [ID {$home['id']}]";
}

/**
 * STEP 4: Clean up
 */
$elapsed = round(microtime(true) - $start, 2);
echo "<h2>Daan Foundation - Activation Complete</h2>";
echo "<p>Elapsed: {$elapsed}s</p>";
echo "<pre>";
foreach ($log as $entry) {
    echo htmlspecialchars($entry) . "\n";
}
echo "</pre>";

// Delete this script
unlink(__FILE__);
echo "<p>Script deleted.</p>";
