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

/* Featured image of a post = its LCP (ration photo on hub + ration posts, 2026-11-27): preload + right sizes. */
function daan_post_thumb_sizes() {
	return '(min-width: 1280px) 789px, (min-width: 1024px) calc(66vw - 60px), calc(100vw - 32px)';
}
add_filter( 'wp_get_attachment_image_attributes', function ( $attr, $att, $size ) {
	if ( 'full' === $size && is_singular( 'post' ) && (int) get_post_thumbnail_id( get_queried_object_id() ) === (int) $att->ID ) {
		$attr['sizes']         = daan_post_thumb_sizes();
		$attr['fetchpriority'] = 'high';
		$attr['decoding']      = 'async';
		unset( $attr['loading'] );
	}
	return $attr;
}, 20, 3 );
add_action( 'wp_head', function () {
	if ( ! is_singular( 'post' ) || ! has_post_thumbnail( get_queried_object_id() ) ) {
		return;
	}
	$tid = get_post_thumbnail_id( get_queried_object_id() );
	$set = wp_get_attachment_image_srcset( $tid, 'full' );
	$src = wp_get_attachment_image_url( $tid, 'full' );
	if ( $src ) {
		echo '<link rel="preload" as="image" fetchpriority="high" href="' . esc_url( $src ) . '"' . ( $set ? ' imagesrcset="' . esc_attr( $set ) . '" imagesizes="' . esc_attr( daan_post_thumb_sizes() ) . '"' : '' ) . ">\n";
	}
}, 2 );

/* Old Ramadan 2026 guide (post 6555): pointer to the 2027 guide at the top (owner OK, 2026-11-27). URL/title unchanged. */
add_filter( 'the_content', function ( $content ) {
	if ( is_singular( 'post' ) && in_the_loop() && is_main_query() && 'ramadan-2026-iftar-donation-guide-how-to-support-families-in-need' === get_post_field( 'post_name', get_the_ID() ) ) {
		$content = '<p class="daan-guide-2027" style="background:#FFF7ED;border:1px solid #FDBA74;border-left:6px solid #C2410C;border-radius:12px;padding:14px 18px;margin:0 0 24px;font-weight:700;color:#7C2D12;"><a href="' . esc_url( home_url( '/ramadan-2027-iftar-donation-guide-india/' ) ) . '" style="color:#9A3412;text-decoration:underline;text-underline-offset:3px;">For Ramadan 2027, see our updated guide &rarr;</a></p>' . $content;
	}
	return $content;
}, 1 );

/* Internal links (D-038): every related post links to its hub; the ration hub shows its Hinglish FAQ. */
function daan_related_groups() {
	return array(
		'iftar'   => array( 'hub' => array( '/ramadan/', 'Iftar donation in India: sponsor Ramadan 2027 Iftar kits' ), 'links' => array( '/whats-inside-iftar-kit/' => "What's inside an Iftar kit", '/roza-iftar-karane-ka-sawab/' => 'Roza iftar karane ka sawab', '/where-does-your-iftar-donation-go/' => 'Where does your iftar donation go?', '/iftar-ki-dua-roza-kholne-ki-dua/' => 'Iftar ki dua: meaning and Sunnah', '/ramadan-2027-iftar-donation-guide-india/' => 'Ramadan 2027 iftar donation guide', '/product/ramadan-iftar/' => 'Sponsor an Iftar kit' ),
			'slugs' => array( 'iftar-ki-dua-roza-kholne-ki-dua', 'ramadan-2027-iftar-donation-guide-india', 'whats-inside-iftar-kit', 'roza-iftar-karane-ka-sawab', 'where-does-your-iftar-donation-go', 'donate-iftar-safely-upi', 'reliable-ramadan-iftar-donation-websites', 'ramadan-2026-iftar-donation-guide-how-to-support-families-in-need', 'the-timeless-virtue-of-feeding-a-fasting-person-a-tradition-over-a-millennium-old', 'ramadan-last-10-nights-iftar' ) ),
		'ration'  => array( 'hub' => array( '/ration-kit-distribution-india/', 'Ration kit donation for poor families in India' ), 'links' => array( '/ration-kit-list-price/' => 'Ration kit list & price', '/can-zakat-be-given-as-ration-kit/' => 'Can Zakat be given as a ration kit?', '/sood-ka-paisa-kahan-de-bank-interest-ration-kit/' => 'Sood ka paisa kahan de?', '/how-to-give-zakat-online-india-upi/' => 'How to give Zakat online (UPI)', '/lillah-sadaqah-zakat-me-farq/' => 'Lillah, Sadaqah aur Zakat me farq', '/cooked-meal-or-ration-kit-how-to-help/' => 'Cooked meal or ration kit?', '/winter-ration-kits-amroha/' => 'Winter ration kits for families', '/product/ration-kit-donation/' => 'Donate a ration kit' ),
			'slugs' => array( 'winter-ration-kits-amroha', 'how-to-give-zakat-online-india-upi', 'lillah-sadaqah-zakat-me-farq', 'cooked-meal-or-ration-kit-how-to-help', 'ration-kit-list-price', 'can-zakat-be-given-as-ration-kit', 'sood-ka-paisa-kahan-de-bank-interest-ration-kit', 'fitrana-2027-india-amount', 'ration-kit-distribution-volunteers', 'zakat-distribution-drive-2027' ) ),
		'kitchen' => array( 'hub' => array( '/community-kitchen/', 'Our Community Kitchen' ), 'links' => array( '/inside-amroha-community-kitchen/' => 'Inside our Amroha Community Kitchen', '/what-is-a-community-kitchen-and-how-does-it-work-in-india/' => 'What is a community kitchen?', '/ramadan/' => 'Iftar donation (Ramadan 2027)', '/ration-kit-distribution-india/' => 'Ration kit donation', '/product/community-kitchen/' => 'Feed a person' ),
			'slugs' => array( 'inside-amroha-community-kitchen', 'what-is-a-community-kitchen-and-how-does-it-work-in-india', 'behind-the-scenes-how-we-cook-1000-meals-a-day', 'volunteers-speak-serving-food-changed-my-life', 'feeding-the-poor-daily-life-inside-a-community-kitchen', 'meals-with-dignity-how-we-maintain-hygiene-and-respect-at-daan-foundation', 'how-%e2%82%b955-can-feed-a-hungry-person-for-a-day-a-ground-reality-from-the-daan-foundations-community-kitchen', 'why-no-one-should-sleep-hungry-daan-foundations-food-mission' ) ),
	);
}
add_filter( 'the_content', function ( $content ) {
	if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}
	$slug = get_post_field( 'post_name', get_the_ID() );
	if ( 'ration-kit-distribution-india' === $slug && function_exists( 'daan_ration_hinglish_pairs' ) ) {
		// Round 4 (owner, 2026-11-28): hub depth for "ration kit donation". Facts: D-029, D-040, D-042, footer.
		$kp = function_exists( 'daan_kit_price' ) ? daan_hub_money( daan_kit_price() ) : '₹1,536';
		$f  = '<h2>Ration Kit Donation: What, Where, When and How Much</h2>'
			. '<p><strong>What:</strong> one ration kit is a complete set of 18 essential food and household items (aata, chawal, dal, oil, spices and more; full list above) that a family in need receives as their own.</p>'
			. '<p><strong>Where:</strong> kits are packed at our head office in Amroha, Uttar Pradesh, and given to families in need.</p>'
			. '<p><strong>When:</strong> all year, not only in Ramadan. Kits are given according to need.</p>'
			. '<p><strong>How much:</strong> one ration kit is ' . esc_html( $kp ) . '. You can give one kit or many.</p>'
			. '<p><strong>How:</strong> choose the number of kits and pay by UPI. We accept donations only from within India.</p>'
			. '<h2>Ration Kit Prices</h2>' . do_shortcode( '[daan_hub_prices type="ration"]' )
			. '<h2>How Your Ration Kit Reaches a Family</h2>' . do_shortcode( '[daan_hub_steps type="ration"]' )
			. '<h2>Why Donors Trust Daan Foundation</h2>' . do_shortcode( '[daan_trust]' );
		$f .= '<h2>Aapke sawaal (FAQ)</h2>';
		foreach ( daan_ration_hinglish_pairs() as $p ) {
			$f .= '<p><strong>' . esc_html( $p[0] ) . '</strong><br>' . esc_html( $p[1] ) . '</p>';
		}
		$f .= '<p>Read more: <a href="/ration-kit-list-price/">Ration kit list &amp; price</a> · <a href="/can-zakat-be-given-as-ration-kit/">Can Zakat be given as a ration kit?</a> · <a href="/sood-ka-paisa-kahan-de-bank-interest-ration-kit/">Sood ka paisa kahan de?</a> · <a href="/fitrana-2027-india-amount/">Fitrana 2027</a> · <a href="/winter-ration-kits-amroha/">Winter ration kits</a> · <a href="/cooked-meal-or-ration-kit-how-to-help/">Cooked meal or ration kit?</a> · <a href="/how-to-give-zakat-online-india-upi/">How to give Zakat online (UPI)</a> · <a href="/lillah-sadaqah-zakat-me-farq/">Lillah, Sadaqah aur Zakat me farq</a></p>';
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


/*
 * Post FAQ (SEO batch 2, 2026-11-27): visible FAQ and FAQPage schema come from the
 * same post meta "daan_faq" (JSON list of [question, answer]), so they always match.
 * Answers may hold price shortcodes ([daan_kit_price] etc.), so prices stay from settings.
 */
function daan_post_faq_pairs( $post_id ) {
	$pairs = json_decode( (string) get_post_meta( $post_id, 'daan_faq', true ), true );
	if ( ! is_array( $pairs ) ) {
		return array();
	}
	$out = array();
	foreach ( $pairs as $p ) {
		if ( is_array( $p ) && 2 === count( $p ) ) {
			$out[] = array( do_shortcode( $p[0] ), do_shortcode( $p[1] ) );
		}
	}
	return $out;
}
add_shortcode( 'daan_post_faq', function () {
	$pairs = daan_post_faq_pairs( get_the_ID() );
	if ( ! $pairs ) {
		return '';
	}
	$h = '<h2>Frequently asked questions (FAQ)</h2>';
	foreach ( $pairs as $p ) {
		$h .= '<p><strong>' . esc_html( $p[0] ) . '</strong><br>' . wp_kses_post( $p[1] ) . '</p>';
	}
	return $h;
} );
add_filter( 'rank_math/json_ld', function ( $data ) {
	if ( ! is_singular( 'post' ) ) {
		return $data;
	}
	$id    = get_queried_object_id();
	$pairs = daan_post_faq_pairs( $id );
	if ( $pairs && function_exists( 'daan_seo27_faq' ) && ! isset( $data['faqPage'] ) ) {
		$data['faqPage'] = daan_seo27_faq( get_permalink( $id ), $pairs );
	}
	return $data;
}, 40 );

/* Titles/meta with prices: built from the rate settings, so they never go stale. */
function daan_seo_b2_title( $slug ) {
	if ( 'cooked-meal-or-ration-kit-how-to-help' === $slug && function_exists( 'daan_seo27_money' ) ) {
		return 'Cooked Meal (' . daan_seo27_money( 'daan_meal_price', 60 ) . ') ya Ration Kit (' . daan_seo27_money( 'daan_kit_price', 1536 ) . '): Kaise Madad Karein';
	}
	return '';
}
add_filter( 'the_title', function ( $title, $id = 0 ) {
	$t = $id ? daan_seo_b2_title( get_post_field( 'post_name', $id ) ) : '';
	return $t ? $t : $title;
}, 20, 2 );
add_filter( 'rank_math/frontend/title', function ( $title ) {
	if ( is_singular( 'post' ) ) {
		$t = daan_seo_b2_title( get_post_field( 'post_name', get_queried_object_id() ) );
		if ( $t ) {
			return $t . ' | Daan Foundation';
		}
	}
	return $title;
}, 40 );
add_filter( 'rank_math/frontend/description', function ( $d ) {
	if ( ! is_singular( 'post' ) || ! function_exists( 'daan_seo27_money' ) ) {
		return $d;
	}
	$slug = get_post_field( 'post_name', get_queried_object_id() );
	$meal = daan_seo27_money( 'daan_meal_price', 60 );
	$kit  = daan_seo27_money( 'daan_kit_price', 1536 );
	$ift  = daan_seo27_money( 'daan_iftar_kit_price', 91 );
	$map  = array(
		'cooked-meal-or-ration-kit-how-to-help'   => 'Cooked meal or ration kit? ' . $meal . ' feeds one person a hot meal today; ' . $kit . ' gives a family 18 essential ration items. How to choose, and how to give by UPI.',
		'ramadan-2027-iftar-donation-guide-india' => 'Ramadan 2027 (around February 2027, by moon sighting): sponsor iftar in India. Iftar kit ' . $ift . '; we serve iftar to 200–300 people every day in Amroha.',
		'winter-ration-kits-amroha'               => 'Winter ration kits for families in need: 18 essential items, ' . $kit . ' per kit. What is in the kit and how to give one this winter, from Daan Foundation, Amroha.',
	);
	return isset( $map[ $slug ] ) ? $map[ $slug ] : $d;
}, 40 );

/* Ration photo attachment: add the lighter 480/640 WebP files to its srcset (mobile LCP on the ration hub, 2026-11-27). */
add_filter( 'wp_calculate_image_srcset', function ( $sources, $size_array, $image_src, $meta, $attachment_id ) {
	if ( false !== strpos( (string) ( $meta['file'] ?? '' ), 'ration-kits-head-office-amroha' ) ) {
		foreach ( array( 480, 640 ) as $w ) {
			if ( file_exists( ABSPATH . 'images/hero-p-ration-warehouse-' . $w . '.webp' ) ) {
				$sources[ $w ] = array( 'url' => home_url( '/images/hero-p-ration-warehouse-' . $w . '.webp' ), 'descriptor' => 'w', 'value' => $w );
			}
		}
		ksort( $sources );
	}
	return $sources;
}, 10, 5 );


/*
 * Round 4 (owner, 2026-11-28): hub blocks for /ramadan/ and /ration-kit-distribution-india/.
 * Prices from settings (D-012, D-029); facts only from D-037/D-037a, footer (Reg. No., PAN),
 * D-042 (update emails). No new fiqh claim, no figure without a source.
 */
function daan_hub_money( $n ) {
	return '₹' . number_format( (float) $n );
}
add_shortcode( 'daan_hub_prices', function ( $atts ) {
	$a     = shortcode_atts( array( 'type' => 'iftar' ), $atts );
	$iftar = 'iftar' === $a['type'];
	$p     = $iftar ? ( function_exists( 'daan_iftar_kit_price' ) ? daan_iftar_kit_price() : 91 ) : ( function_exists( 'daan_kit_price' ) ? daan_kit_price() : 1536 );
	$rows  = $iftar ? array( 1 => 'One fasting person', 10 => '10 people', 30 => 'One person every day of Ramadan (30 days)', 100 => '100 people' ) : array( 1 => 'One family', 2 => 'Two families', 5 => 'Five families', 10 => 'Ten families' );
	$url   = function_exists( 'daan_kit_url' ) ? daan_kit_url( $iftar ? 'iftar' : 'ration' ) : ( $iftar ? '/product/ramadan-iftar/' : '/product/ration-kit-donation/' );
	$h  = '<div style="overflow-x:auto;"><table style="width:100%;border-collapse:collapse;font-size:0.95rem;"><thead><tr style="background:#FFF7ED;"><th style="text-align:left;padding:10px;border:1px solid #FED7AA;">' . ( $iftar ? 'Iftar kits' : 'Ration kits' ) . '</th><th style="text-align:left;padding:10px;border:1px solid #FED7AA;">Who it helps</th><th style="text-align:right;padding:10px;border:1px solid #FED7AA;">Amount</th></tr></thead><tbody>';
	foreach ( $rows as $q => $who ) {
		$h .= '<tr><td style="padding:10px;border:1px solid #E2E8F0;">' . (int) $q . '</td><td style="padding:10px;border:1px solid #E2E8F0;">' . esc_html( $who ) . '</td><td style="padding:10px;border:1px solid #E2E8F0;text-align:right;font-weight:700;">' . esc_html( daan_hub_money( $p * $q ) ) . '</td></tr>';
	}
	$h .= '</tbody></table></div><p style="margin-top:10px;color:#475569;font-size:0.9rem;">' . ( $iftar ? 'One Iftar kit is ' : 'One ration kit is ' ) . esc_html( daan_hub_money( $p ) ) . '. Choose any number; the total is worked out for you. <a href="' . esc_url( $url ) . '" style="color:#9A3412;font-weight:700;text-decoration:underline;">' . ( $iftar ? 'Sponsor Iftar kits' : 'Donate ration kits' ) . ' &rarr;</a></p>';
	return $h;
} );
add_shortcode( 'daan_hub_steps', function ( $atts ) {
	$a = shortcode_atts( array( 'type' => 'iftar' ), $atts );
	if ( 'iftar' === $a['type'] ) {
		$s = array(
			array( 'Choose and pay', 'Pick the number of Iftar kits and pay by UPI. We accept donations only from within India (UPI).' ),
			array( 'Confirmation and receipt', 'Once your payment is confirmed, you receive a receipt by email showing our PAN.' ),
			array( 'Reserved for Ramadan', 'If you give before Ramadan, your kits are reserved for Ramadan 2027 (expected around February 2027, by moon sighting).' ),
			array( 'Cooked in Amroha', 'During Ramadan, the iftar is prepared fresh at our Community Kitchen in Amroha, Uttar Pradesh.' ),
			array( 'Handed out after Asr', 'Each kit is given to a fasting person as their own, after Asr. People may take it home. During Ramadan we serve iftar to 200–300 people every day.' ),
		);
		$img = '<figure style="margin:18px 0 0;"><img src="/images/hero-r27-768.webp" srcset="/images/hero-r27-480.webp 480w, /images/hero-r27-768.webp 768w, /images/hero-r27-1024.webp 1024w" sizes="(max-width: 768px) 100vw, 720px" width="768" height="432" loading="lazy" decoding="async" alt="A boy holding an iftar kit and a food container from Daan Foundation\'s Community Kitchen" style="width:100%;height:auto;border-radius:14px;"><figcaption style="font-size:0.85rem;color:#64748B;margin-top:6px;">Iftar from our Community Kitchen in Amroha.</figcaption></figure>';
	} else {
		$s = array(
			array( 'Choose and pay', 'Pick the number of ration kits and pay by UPI. We accept donations only from within India (UPI).' ),
			array( 'Confirmation and receipt', 'Once your payment is confirmed, you receive a receipt by email showing our PAN.' ),
			array( 'Packed in Amroha', 'Your kit is packed at our head office in Amroha with the full list of 18 essential items.' ),
			array( 'Scheduled for distribution', 'The kit is scheduled for a family in need.' ),
			array( 'Delivered', 'The kit is handed to the family as their own.' ),
		);
		$img = '';
	}
	$h = '<ol style="list-style:none;padding:0;margin:0;display:grid;gap:10px;">';
	foreach ( $s as $i => $x ) {
		$h .= '<li style="display:flex;gap:12px;align-items:flex-start;border:1px solid #E2E8F0;border-radius:12px;padding:12px 14px;background:#fff;"><span style="flex:0 0 32px;height:32px;border-radius:9999px;background:#C2410C;color:#fff;font-weight:700;display:flex;align-items:center;justify-content:center;">' . ( $i + 1 ) . '</span><span><strong style="color:#111827;">' . esc_html( $x[0] ) . '</strong><br><span style="color:#334155;">' . esc_html( $x[1] ) . '</span></span></li>';
	}
	$note = 'iftar' === $a['type'] ? 'For most donations, we email you a short update after your kits are put to use or reserved for Ramadan.' : 'For most donations, we email you a short update when your kit is packed, scheduled and delivered.';
	return $h . '</ol><p style="margin-top:10px;color:#475569;font-size:0.9rem;">' . esc_html( $note ) . '</p>' . $img;
} );
add_shortcode( 'daan_trust', function () {
	$meal  = function_exists( 'daan_meal_price' ) ? daan_hub_money( daan_meal_price() ) : '₹60';
	$items = array(
		array( 'Registered Trust', 'Reg. No. 149/11-20/302 (Tehsil Amroha)' ),
		array( 'PAN', 'AAETD5465E (shown on every receipt)' ),
		array( 'Since 2020', 'Founded in Ramadan 2020 in Amroha, Uttar Pradesh' ),
		array( '100–120 people every day', 'Community Kitchen meals, ' . $meal . ' per meal' ),
		array( '200–300 people a day in Ramadan', 'Iftar served at our Community Kitchen' ),
		array( 'Only from within India', 'Donations by UPI from India only' ),
	);
	$h = '<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:10px;">';
	foreach ( $items as $x ) {
		$h .= '<div style="border:1px solid #E2E8F0;border-radius:12px;padding:12px 14px;background:#F8FAFC;"><strong style="display:block;color:#111827;">' . esc_html( $x[0] ) . '</strong><span style="color:#475569;font-size:0.9rem;">' . esc_html( $x[1] ) . '</span></div>';
	}
	return $h . '</div><p style="margin-top:10px;color:#475569;font-size:0.9rem;">Daan Foundation is not registered under Section 80G, so donations do not give an 80G tax benefit.</p>';
} );


/*
 * Round 4 cannibalization (owner, 2026-11-28): only /ramadan/ targets "iftar donation india /
 * donate iftar / ramadan iftar donation"; only the ration hub + product target "ration kit donation".
 * Other posts get their own long-tail title/meta. URLs/slugs unchanged, no redirect (D-036).
 */
function daan_r4_seo_map() {
	$ift  = function_exists( 'daan_iftar_kit_price' ) ? daan_hub_money( daan_iftar_kit_price() ) : '₹91';
	$meal = function_exists( 'daan_meal_price' ) ? daan_hub_money( daan_meal_price() ) : '₹60';
	return array(
		'page:ramadan' => array( 'Iftar Donation India: Sponsor Ramadan 2027 Iftar Kits | Daan Foundation', 'Donate iftar in India this Ramadan: one Iftar kit ' . $ift . ' (veg biryani, dates, fruit, egg, drink) for a fasting person at our Amroha kitchen. 200–300 people served daily.' ),
		'post:ramadan-2027-iftar-donation-guide-india' => array( 'Ramadan 2027 in India: When It Starts & How to Plan Your Giving', 'Ramadan 2027 in India is expected around February 2027, by moon sighting. A simple plan for your Zakat, Fitrana and iftar giving before the month begins.' ),
		'post:ramadan-2026-iftar-donation-guide-how-to-support-families-in-need' => array( 'Ramadan 2026 Guide: Zakat, Sadaqah & Supporting Families (Archive)', 'Our Ramadan 2026 guide to giving Zakat and Sadaqah and supporting families in need. For Ramadan 2027, see our updated guide.' ),
		'post:reliable-ramadan-iftar-donation-websites' => array( 'How to Check if a Ramadan Donation Website Is Genuine: A Checklist', 'Before you give online this Ramadan, check registration, PAN, receipts, UPI payee name and a real address. A simple checklist for donors in India.' ),
		'post:donate-iftar-safely-upi' => array( 'UPI Donation Safety in Ramadan: How to Avoid QR Code Scams', 'Giving by UPI this Ramadan? Check the payee name, avoid QR code and fake-page scams, and keep your receipt. Simple safety steps for donors in India.' ),
		'post:where-does-your-iftar-donation-go' => array( 'From Payment to Plate: How Your Iftar Kit Reaches a Fasting Person', 'Follow one ' . $ift . ' Iftar kit from your UPI payment to a fasting person after Asr at our Community Kitchen in Amroha, step by step.' ),
		'product:ramadan-iftar' => array( 'Sponsor an Iftar Kit (' . $ift . ') | Ramadan Iftar – Daan Foundation', '' ),
		// Quick win: "community kitchen" (1,207 impressions, pos 7.9, CTR 0.08%).
		'post:what-is-a-community-kitchen-and-how-does-it-work-in-india' => array( 'Community Kitchen: Meaning, How It Works & Our Amroha Kitchen', 'A community kitchen cooks free meals for anyone in need. Ours in Amroha serves a hot meal to 100–120 people every day, since 2020. ' . $meal . ' feeds one person.' ),
		'page:community-kitchen' => array( 'Community Kitchen in Amroha: Free Meals Daily, ' . $meal . ' a Meal | Daan Foundation', 'Our Community Kitchen in Amroha serves a hot, freshly cooked meal to 100–120 people in need every day, since 2020, for every faith. ' . $meal . ' feeds one person.' ),
	);
}
function daan_r4_key() {
	if ( ! function_exists( 'daan_seo27_key' ) ) {
		return '';
	}
	return daan_seo27_key();
}
add_filter( 'rank_math/frontend/title', function ( $t ) {
	$m = daan_r4_seo_map();
	$k = daan_r4_key();
	return ( $k && ! empty( $m[ $k ][0] ) ) ? $m[ $k ][0] : $t;
}, 99 );
add_filter( 'rank_math/frontend/description', function ( $d ) {
	$m = daan_r4_seo_map();
	$k = daan_r4_key();
	return ( $k && ! empty( $m[ $k ][1] ) ) ? $m[ $k ][1] : $d;
}, 99 );
// Clear link to the iftar hub at the top of the iftar posts that used to compete with it.
add_filter( 'the_content', function ( $content ) {
	if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}
	$slugs = array( 'ramadan-2027-iftar-donation-guide-india', 'ramadan-2026-iftar-donation-guide-how-to-support-families-in-need', 'reliable-ramadan-iftar-donation-websites', 'donate-iftar-safely-upi', 'where-does-your-iftar-donation-go', 'whats-inside-iftar-kit', 'roza-iftar-karane-ka-sawab', 'iftar-ki-dua-roza-kholne-ki-dua', 'the-timeless-virtue-of-feeding-a-fasting-person-a-tradition-over-a-millennium-old' );
	if ( in_array( get_post_field( 'post_name', get_the_ID() ), $slugs, true ) ) {
		$content = '<p class="daan-hub-link" style="border-left:4px solid #C2410C;background:#FFF7ED;padding:10px 14px;border-radius:8px;margin:0 0 20px;">Want to give iftar this Ramadan? See our <a href="' . esc_url( home_url( '/ramadan/' ) ) . '" style="color:#9A3412;font-weight:700;text-decoration:underline;">Iftar donation in India</a> page.</p>' . $content;
	}
	return $content;
}, 27 );
