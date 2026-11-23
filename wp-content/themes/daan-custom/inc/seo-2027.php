<?php
/**
 * SEO 2027 technical fixes (owner, 2026-11-23, D-038).
 * - Feeds: X-Robots-Tag noindex (Google was crawling /feed/, /tag/x/feed/, post feeds).
 * - /category/blog/ and /product-category/* : noindex (owner OK). URLs unchanged.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'template_redirect', function () {
	if ( is_feed() ) {
		header( 'X-Robots-Tag: noindex, follow', true );
	}
}, 1 );
add_filter( 'rank_math/frontend/robots', function ( $robots ) {
	if ( is_category( 'blog' ) || ( function_exists( 'is_product_category' ) && is_product_category() ) ) {
		$robots['index'] = 'noindex';
		$robots['follow'] = 'follow';
	}
	return $robots;
} );

/* Internal links (D-038): every related post links to its hub; the ration hub shows its Hinglish FAQ. */
function daan_related_groups() {
	return array(
		'iftar'   => array( 'hub' => array( '/ramadan/', 'Ramadan Iftar: sponsor Iftar kits' ), 'links' => array( '/whats-inside-iftar-kit/' => "What's inside an Iftar kit", '/roza-iftar-karane-ka-sawab/' => 'Roza iftar karane ka sawab', '/where-does-your-iftar-donation-go/' => 'Where does your iftar donation go?', '/product/ramadan-iftar/' => 'Sponsor an Iftar kit' ),
			'slugs' => array( 'whats-inside-iftar-kit', 'roza-iftar-karane-ka-sawab', 'where-does-your-iftar-donation-go', 'donate-iftar-safely-upi', 'reliable-ramadan-iftar-donation-websites', 'ramadan-2026-iftar-donation-guide-how-to-support-families-in-need', 'the-timeless-virtue-of-feeding-a-fasting-person-a-tradition-over-a-millennium-old', 'ramadan-last-10-nights-iftar' ) ),
		'ration'  => array( 'hub' => array( '/ration-kit-distribution-india/', 'Ration Kit Donation for poor families' ), 'links' => array( '/ration-kit-list-price/' => 'Ration kit list & price', '/can-zakat-be-given-as-ration-kit/' => 'Can Zakat be given as a ration kit?', '/sood-ka-paisa-kahan-de-bank-interest-ration-kit/' => 'Sood ka paisa kahan de?', '/fitrana-2027-india-amount/' => 'Fitrana 2027 in India', '/product/ration-kit-donation/' => 'Donate a ration kit' ),
			'slugs' => array( 'ration-kit-list-price', 'can-zakat-be-given-as-ration-kit', 'sood-ka-paisa-kahan-de-bank-interest-ration-kit', 'fitrana-2027-india-amount', 'ration-kit-distribution-volunteers', 'zakat-distribution-drive-2027' ) ),
		'kitchen' => array( 'hub' => array( '/community-kitchen/', 'Our Community Kitchen' ), 'links' => array( '/inside-amroha-community-kitchen/' => 'Inside our Amroha Community Kitchen', '/what-is-a-community-kitchen-and-how-does-it-work-in-india/' => 'What is a community kitchen?', '/ramadan/' => 'Ramadan Iftar', '/ration-kit-distribution-india/' => 'Ration kits for families', '/product/community-kitchen/' => 'Feed a person' ),
			'slugs' => array( 'inside-amroha-community-kitchen', 'what-is-a-community-kitchen-and-how-does-it-work-in-india', 'behind-the-scenes-how-we-cook-1000-meals-a-day', 'volunteers-speak-serving-food-changed-my-life', 'feeding-the-poor-daily-life-inside-a-community-kitchen', 'meals-with-dignity-how-we-maintain-hygiene-and-respect-at-daan-foundation', 'how-%e2%82%b955-can-feed-a-hungry-person-for-a-day-a-ground-reality-from-the-daan-foundations-community-kitchen', 'why-no-one-should-sleep-hungry-daan-foundations-food-mission' ) ),
	);
}
add_filter( 'the_content', function ( $content ) {
	if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}
	$slug = get_post_field( 'post_name', get_the_ID() );
	if ( 'ration-kit-distribution-india' === $slug && function_exists( 'daan_ration_hinglish_pairs' ) ) {
		$f = '<h2>Aapke sawaal (FAQ)</h2>';
		foreach ( daan_ration_hinglish_pairs() as $p ) {
			$f .= '<p><strong>' . esc_html( $p[0] ) . '</strong><br>' . esc_html( $p[1] ) . '</p>';
		}
		$f .= '<p>Read more: <a href="/ration-kit-list-price/">Ration kit list &amp; price</a> · <a href="/can-zakat-be-given-as-ration-kit/">Can Zakat be given as a ration kit?</a> · <a href="/sood-ka-paisa-kahan-de-bank-interest-ration-kit/">Sood ka paisa kahan de?</a> · <a href="/fitrana-2027-india-amount/">Fitrana 2027</a></p>';
		return $content . $f;
	}
	foreach ( daan_related_groups() as $g ) {
		if ( in_array( $slug, $g['slugs'], true ) ) {
			$h = '<aside class="daan-related" style="border:1px solid #E2E8F0;border-radius:14px;padding:16px 18px;margin:28px 0;background:#F8FAFC;"><p style="margin:0 0 8px;font-weight:700;color:#111827;">Related reading</p><ul style="margin:0;padding-left:20px;">';
			$h .= '<li><a href="' . esc_url( home_url( $g['hub'][0] ) ) . '"><strong>' . esc_html( $g['hub'][1] ) . '</strong></a></li>';
			foreach ( $g['links'] as $u => $t ) {
				if ( false !== strpos( $u, '/' . $slug . '/' ) ) { continue; }
				$h .= '<li><a href="' . esc_url( home_url( $u ) ) . '">' . esc_html( $t ) . '</a></li>';
			}
			return $content . $h . '</ul></aside>';
		}
	}
	return $content;
}, 28 );

