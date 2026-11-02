<?php
/**
 * Daan Foundation — performance fixes
 *
 * Frontend-only asset cleanup. Nothing here touches wp-admin, the
 * Customizer, or any plugin's own admin-side functionality — only what
 * gets enqueued on public-facing pages.
 *
 * @package Daan\Performance
 */

/**
 * Astra Sites' onboarding-wizard "template preview" script
 * (starter-templates-zip-preview-js, astra-sites plugin, served from
 * inc/lib/onboarding/assets/dist/template-preview/main.js) was loading on
 * every public page -- confirmed live via page source on the homepage and
 * several other pages. That script exists to preview starter templates
 * inside the wp-admin onboarding wizard; it has no reason to load for a
 * site visitor. Dequeued here rather than deactivating the whole plugin,
 * since Astra Sites may still be in active use for other admin-side
 * features (theme starter-template imports) -- this only strips the one
 * script from the frontend, wp-admin is completely unaffected.
 */
add_action( 'wp_enqueue_scripts', function () {
	if ( is_admin() ) {
		return;
	}
	wp_dequeue_script( 'starter-templates-zip-preview' );
	wp_deregister_script( 'starter-templates-zip-preview' );
}, PHP_INT_MAX );

/**
 * 2026-10-13 performance batch.
 *
 * 1. Self-host Open Sans (same variable font Google served, latin + latin-ext) instead of the
 *    render-blocking fonts.googleapis.com stylesheet (~0.9 s on slow mobile).
 * 2. Preload the hero image that is the Largest Contentful Paint element on the homepage.
 * 3. On the homepage and /donate/ only, drop CSS those custom templates never use
 *    (WooCommerce shop styles, block-library, donations-for-woocommerce, brands). Cart,
 *    checkout, account, products and posts keep every stylesheet.
 */
add_action( 'wp_enqueue_scripts', function () {
	wp_dequeue_style( 'daan-google-fonts' );
	wp_deregister_style( 'daan-google-fonts' );

	if ( is_front_page() || is_page( 'donate' ) ) {
		foreach ( array( 'wp-block-library', 'hm-wcdon-frontend-styles', 'woocommerce-layout', 'woocommerce-smallscreen', 'woocommerce-general', 'brands-styles', 'wc-blocks-style' ) as $handle ) {
			wp_dequeue_style( $handle );
		}
	}
}, 100 );

add_action( 'wp_head', function () {
	$base = get_template_directory_uri() . '/assets/fonts/';
	echo '<link rel="preload" href="' . esc_url( $base . 'opensans-latin.woff2' ) . '" as="font" type="font/woff2" crossorigin>' . "
";
	if ( is_front_page() ) {
		echo '<link rel="preload" as="image" href="/images/hero-mobile-828.webp" imagesrcset="/images/hero-mobile-828.webp 828w, /images/hero-mobile.webp 1024w" imagesizes="100vw" media="(max-width: 767px)" type="image/webp" fetchpriority="high">' . "
";
		echo '<link rel="preload" as="image" href="/images/hero-new-banner.webp" media="(min-width: 768px)" type="image/webp" fetchpriority="high">' . "
";
	}
	?>
<style id="daan-fonts">
@font-face{font-family:'Open Sans';font-style:normal;font-weight:300 800;font-stretch:100%;font-display:swap;src:url('<?php echo esc_url( $base . 'opensans-latin-ext.woff2' ); ?>') format('woff2');unicode-range:U+0100-02BA,U+02BD-02C5,U+02C7-02CC,U+02CE-02D7,U+02DD-02FF,U+0304,U+0308,U+0329,U+1D00-1DBF,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20C4,U+2113,U+2C60-2C7F,U+A720-A7FF}
@font-face{font-family:'Open Sans';font-style:normal;font-weight:300 800;font-stretch:100%;font-display:swap;src:url('<?php echo esc_url( $base . 'opensans-latin.woff2' ); ?>') format('woff2');unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD}
</style>
	<?php
}, 1 );

// WooCommerce registers its blocks stylesheet late; dequeue it again right before printing.
add_action( 'wp_print_styles', function () {
	if ( is_front_page() || is_page( 'donate' ) ) {
		wp_dequeue_style( 'wc-blocks-style' );
	}
}, 100 );

// Legal pages (page-legal.php) render their content without Elementor, so
// Elementor's CSS/JS (and its "elementorFrontendConfig is not defined" error) are not needed there.
function daan_legal_drop_elementor_assets() {
	if ( ! is_page_template( 'page-legal.php' ) ) {
		return;
	}
	foreach ( array( 'elementor-frontend', 'elementor-frontend-modules', 'elementor-webpack-runtime', 'font-awesome-4-shim' ) as $h ) {
		wp_dequeue_script( $h );
	}
	foreach ( array( 'elementor-frontend', 'elementor-gf-roboto', 'elementor-gf-robotoslab', 'elementor-post-3049', 'elementor-post-' . get_queried_object_id(), 'font-awesome-4-shim', 'font-awesome-5-all' ) as $h ) {
		wp_dequeue_style( $h );
	}
}
add_action( 'wp_enqueue_scripts', 'daan_legal_drop_elementor_assets', 999 );
add_action( 'wp_print_footer_scripts', 'daan_legal_drop_elementor_assets', 1 );
add_action( 'wp_print_styles', 'daan_legal_drop_elementor_assets', 999 );

// Pages built with Elementor but rendered from theme templates (About, Zakat, Community Kitchen) never print
// Elementor's content, so its config is missing and frontend.min.js throws "elementorFrontendConfig is not defined".
// Only the scripts go; the styles stay, so the design does not change.
add_action( 'wp_print_footer_scripts', function () {
	if ( ! class_exists( '\Elementor\Plugin' ) || \Elementor\Plugin::$instance->frontend->has_elementor_in_page() ) {
		return;
	}
	foreach ( array( 'elementor-frontend', 'elementor-frontend-modules', 'elementor-webpack-runtime' ) as $h ) {
		wp_dequeue_script( $h );
	}
}, 1 );
