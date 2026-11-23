<?php
/**
 * Product page suggestions (owner, 2026-11-23).
 *
 * - No WooCommerce related products, upsells or cross-sells anywhere
 *   (product page, cart, checkout).
 * - A theme-styled "Other ways to give" section under each product instead
 *   (Iftar Kit, Ration Kit, Community Kitchen, Zakat, Sadaqah; the current
 *   product is left out).
 * - Products without a featured image show no image and no Woo placeholder.
 * - Hidden (exclude-from-search) products and retired 2024 pages are kept out
 *   of site search. URLs stay 200/index (owner URL rule).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* 1. Switch off Woo suggestions. */
add_filter( 'woocommerce_related_products', '__return_empty_array', 99 );
add_filter( 'woocommerce_product_get_upsell_ids', '__return_empty_array', 99 );
add_filter( 'woocommerce_product_get_cross_sell_ids', '__return_empty_array', 99 );
add_filter( 'woocommerce_cart_crosssell_ids', '__return_empty_array', 99 );

add_action( 'wp', function () {
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

	/* No image → no gallery and no placeholder. */
	if ( function_exists( 'is_product' ) && is_product() ) {
		$p = wc_get_product( get_queried_object_id() );
		if ( $p && ! $p->get_image_id() && ! $p->get_gallery_image_ids() ) {
			remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
			add_filter( 'body_class', function ( $c ) { $c[] = 'daan-product-noimg'; return $c; } );
		}
	}
} );

/* Block-based cart/checkout: drop the cross-sells block if it is ever used. */
add_filter( 'render_block', function ( $html, $block ) {
	if ( isset( $block['blockName'] ) && in_array( $block['blockName'], array( 'woocommerce/cart-cross-sells-block', 'woocommerce/product-collection', 'woocommerce/related-products' ), true ) && ( is_cart() || is_checkout() || is_product() ) ) {
		return '';
	}
	return $html;
}, 10, 2 );

/* Never show the Woo placeholder for a product without an image (loops, cart). */
add_filter( 'woocommerce_placeholder_img', function ( $html ) {
	return ( is_cart() || is_checkout() || is_product() ) ? '' : $html;
} );

/* 2. "Other ways to give". */
function daan_other_ways_items() {
	$kit   = function_exists( 'daan_kit_price' ) ? daan_kit_price() : 1536;
	$iftar = function_exists( 'daan_iftar_kit_price' ) ? daan_iftar_kit_price() : 91;
	$meal  = function_exists( 'daan_meal_price' ) ? daan_meal_price() : 60;
	return array(
		array( 'ramadan-iftar', 'Iftar Kit', 'Iftar for those fasting in need: ₹' . number_format_i18n( $iftar ) . ' per kit', '/product/ramadan-iftar/', 'linear-gradient(135deg, #F43F5E, #E11D48)', 'M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z' ),
		array( 'ration-kit-donation', 'Ration Kit Donation', 'A complete ration kit for a family in need: ₹' . number_format_i18n( $kit ) . ' per kit', '/product/ration-kit-donation/', 'linear-gradient(135deg, #06B6D4, #0D9488)', 'M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z M3 6h18 M16 10a4 4 0 01-8 0' ),
		array( 'community-kitchen', 'Community Kitchen', 'Feed the hungry: ₹' . number_format_i18n( $meal ) . ' provides one meal', '/product/community-kitchen/', 'linear-gradient(135deg, #F59E0B, #EA580C)', 'M3 2v7c0 1.1.9 2 2 2h4a2 2 0 002-2V2 M7 2v20 M14 2v20h4a2 2 0 002-2V2' ),
		array( 'zakat', 'Zakat', 'Calculate and pay your Zakat accurately', '/product/zakat/', 'linear-gradient(135deg, #F97316, #EA580C)', 'M4 2h16a2 2 0 012 2v16a2 2 0 01-2 2H4a2 2 0 01-2-2V4a2 2 0 012-2z M8 6h8 M8 10h8 M8 14h5 M16 14h1 M8 18h8 M16 18h1' ),
		array( 'sadaqah', 'Sadaqah', 'Voluntary charity for families in need', '/product/sadaqah/', 'linear-gradient(135deg, #3B82F6, #4F46E5)', 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z' ),
	);
}

add_action( 'woocommerce_after_single_product_summary', function () {
	$current = get_post_field( 'post_name', get_queried_object_id() );
	echo '<section class="daan-other-ways" aria-labelledby="daan-other-ways-h"><h2 id="daan-other-ways-h">Other ways to give</h2><div class="quick-actions-grid">';
	foreach ( daan_other_ways_items() as $it ) {
		if ( $it[0] === $current ) {
			continue;
		}
		printf(
			'<a href="%1$s" class="qa-card"><div class="qa-icon" style="background:%2$s"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="%3$s"/></svg></div><h3>%4$s</h3><p>%5$s</p><div class="qa-arrow"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></div></a>',
			esc_url( home_url( $it[3] ) ),
			esc_attr( $it[4] ),
			esc_attr( $it[5] ),
			esc_html( $it[1] ),
			esc_html( $it[2] )
		);
	}
	echo '</div></section>';
}, 20 );

add_action( 'wp_head', function () {
	if ( ! function_exists( 'is_product' ) || ! is_product() ) {
		return;
	}
	echo '<style id="daan-other-ways-css">.daan-other-ways{clear:both;padding:40px 0 8px}.daan-other-ways h2{font-size:1.5rem;font-weight:700;color:#0f172a;margin:0 0 20px}.daan-other-ways a,.daan-other-ways a h3,.daan-other-ways a p{text-decoration:none!important}.daan-product-noimg div.product .summary{width:100%!important;float:none!important}</style>' . "\n";
} );

/* 3. Site search: hide exclude-from-search products and retired 2024 pages. */
add_action( 'pre_get_posts', function ( $q ) {
	if ( is_admin() || ! $q->is_main_query() || ! $q->is_search() ) {
		return;
	}
	$hidden = get_posts( array(
		'post_type'      => 'product',
		'post_status'    => 'any',
		'fields'         => 'ids',
		'posts_per_page' => -1,
		'tax_query'      => array( array( 'taxonomy' => 'product_visibility', 'field' => 'slug', 'terms' => array( 'exclude-from-search' ) ) ),
	) );
	// Retired 2024 pages (URLs stay live; owner URL rule): education-aid, fidya-and-kaffara, donate-now, old donation status pages.
	$pages = array( 5843, 5849, 5893, 5898, 5899, 5900, 6821 );
	$q->set( 'post__not_in', array_merge( (array) $q->get( 'post__not_in' ), $hidden, $pages ) );
} );

/* 4. No previous/next product links (they can point at hidden 2024 products). */
add_filter( 'previous_post_link', function ( $o ) { return ( function_exists( 'is_product' ) && is_product() ) ? '' : $o; } );
add_filter( 'next_post_link', function ( $o ) { return ( function_exists( 'is_product' ) && is_product() ) ? '' : $o; } );
