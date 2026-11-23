<?php
/**
 * Daan Foundation — SEO fallback fixes
 *
 * Fills in a meta description via Rank Math's own override filter only when
 * Rank Math has none set for that page/post — never touches pages that
 * already have one. Text is drawn from each page's own existing hero/
 * subtitle copy (page-content.php / page templates), not newly authored.
 *
 * @package Daan\Seo
 */

add_filter( 'rank_math/frontend/description', function ( $description ) {
	if ( ! empty( $description ) ) {
		return $description;
	}

	if ( is_front_page() ) {
		return 'No one should sleep hungry. Daan Foundation provides meals, Zakat, Sadaqah, and emergency relief to vulnerable communities across India.';
	}

	if ( is_home() ) {
		return "Read the latest news, updates, and impact stories from Daan Foundation's work across India.";
	}

	if ( is_page() ) {
		$slug = get_post_field( 'post_name', get_queried_object_id() );

		$fallbacks = array(
			'donate'             => 'Your generosity transforms lives. 100% of your donation goes directly to those in need.',
			'faq'                => 'Answers to common questions about Zakat, Sadaqah, Fidya, and Kaffarah.',
			'about'              => 'Daan Foundation – Serving Humanity With Compassion Since 2020.',
			'zakat-calculator'   => "Calculate your Zakat accurately with Daan Foundation's free online Zakat calculator, based on current Nisab and market rates.",
			'our-work'           => 'See how Daan Foundation works — our impact, history, transparency, and the causes your donations support across India.',
			'ramadan'            => 'Daan Foundation was born during the blessed month of Ramadan in 2020 through a simple humanitarian effort: providing Iftar meals to people in need.',
			'winter-appeal'      => 'Warmth for Every Needy — Protecting Lives During Harsh Winters in India.',
			'zakat-al-fitr'      => 'A compulsory charitable donation given before Eid prayer, ensuring everyone can celebrate Eid with dignity.',
			'kaffarah'           => 'Feeding those in need through Daan Foundation — fulfil your Kaffarah with compassion.',
			'fidya'              => 'A charitable compensation for those unable to fast during Ramadan due to valid long-term reasons.',
			'sadaqah'            => 'Voluntary charity given sincerely for the sake of Allah. Every contribution, no matter how small, makes a difference.',
			'sadaqah-jariyah'    => 'Ongoing charity that continues benefiting people, even after the donor has passed away.',
			'where-most-needed'  => 'Your donation reaches the most urgent humanitarian needs across India.',
			'where-we-work'      => 'Daan Foundation: serving vulnerable communities across India with compassion and dignity.',
			'orphan-sponsorship' => "Change a child's life with your monthly support — sponsor an orphan's education, food, and care through Daan Foundation.",
			'water'              => "Provide clean water to families in need and reduce waterborne disease — support Daan Foundation's Water for Life project.",
			'eid-gifts'          => "Supporting Children with Love & Dignity — Daan Foundation's Eid Gift Initiative.",
			'contact'            => "We're here to help. Reach out to us with any questions, feedback, or inquiries.",
		);

		if ( isset( $fallbacks[ $slug ] ) ) {
			return $fallbacks[ $slug ];
		}
	}

	return $description;
} );

/**
 * Exclude specific duplicate/leftover pages from the Rank Math XML sitemap.
 * ('home-2' — orphaned pre-migration duplicate of the homepage, U1/I2.)
 */
add_filter( 'rank_math/sitemap/entry', function ( $url, $type, $post ) {
	if ( 'post' === $type && isset( $post->post_name ) && 'home-2' === $post->post_name ) {
		return false;
	}
	return $url;
}, 10, 3 );

/**
 * Google Search Console verification meta tag.
 *
 * This token was added to the old React SPA's index.html (commit 463dcc1,
 * 20 Jul 2026) but the SPA isn't what's actually deployed -- WordPress is
 * (see CLAUDE.md). It never made it into the live theme, so the property
 * has had no verification meta tag on the site WordPress actually serves.
 * Re-adding it here, on the site that's really live.
 */
add_action( 'wp_head', function () {
	echo '<meta name="google-site-verification" content="S_1Rlrv2YgpxMZuKYHkg7m7mnEBH9Na2xtNLJVU-Qbs" />' . "\n";
}, 1 );

/**
 * Fix incorrect address fields in the JSON-LD schema. Found during a Rank
 * Math audit: postalCode had a stray leading digit ("2444221" instead of
 * the real 6-digit PIN), addressCountry held "91" (India's phone calling
 * code, not an ISO country code), and addressLocality duplicated the
 * street name instead of naming the actual district -- addressRegion had
 * the same mix-up, holding the district ("Amroha") where the state
 * belongs. Corrected to match the address already published in the site
 * footer (footer.php): Katkoi Street, District Amroha, Uttar Pradesh -
 * 244221, India.
 *
 * This same wrong address turned out to be duplicated across more than
 * one schema entity (the "NGO"/"Organization" node AND a separate
 * "Place" node both carry their own address block) -- rather than list
 * every @type that happens to carry it, this matches on the address data
 * itself (the known-wrong postal code) so it's fixed everywhere it
 * appears, present or future.
 */
add_filter( 'rank_math/json_ld', function ( $data ) {
	foreach ( $data as $key => $entity ) {
		if ( empty( $entity['address']['postalCode'] ) || '2444221' !== $entity['address']['postalCode'] ) {
			continue;
		}
		$data[ $key ]['address']['addressLocality'] = 'Amroha';
		$data[ $key ]['address']['addressRegion']    = 'Uttar Pradesh';
		$data[ $key ]['address']['postalCode']       = '244221';
		$data[ $key ]['address']['addressCountry']   = 'IN';
	}
	return $data;
}, 99 );

/**
 * Single source of truth for the /faq/ page's Q&A content -- used by both
 * the visible page-faq.php template and the FAQPage schema below, so the
 * two can never drift out of sync with each other. 14 real Q&A pairs
 * across 3 categories (Zakat, Sadaqah, Fidya & Kaffarah). Note: the audit
 * that flagged this (S1) said "18 Q&A pairs" -- the page's actual content
 * has always been 14; the schema below matches what's really on the page,
 * not the audit's count.
 */
function daan_get_faq_data() {
	return array(
		array(
			'topic' => 'Zakat',
			'faqs'  => array(
				array( 'What is Zakat?', "Zakat is one of the five pillars of Islam. It is a mandatory charitable contribution, typically 2.5% of a Muslim's total savings and wealth above a minimum amount known as the Nisab." ),
				array( 'Who must pay Zakat?', 'Zakat is obligatory for every adult Muslim who owns wealth above the Nisab threshold for one lunar year. The wealth must be in excess of basic needs and debts.' ),
				array( 'What is the Nisab?', 'The Nisab is the minimum amount of wealth a Muslim must possess before Zakat becomes obligatory. It is calculated based on the value of gold (87.48 grams) or silver (612.36 grams).' ),
				array( 'How is Zakat calculated?', 'Zakat is calculated as 2.5% of your total zakatable assets minus any debts. Zakatable assets include cash, savings, investments, gold, silver, and business inventory.' ),
				array( 'When should I pay Zakat?', 'Zakat is due once a full lunar year has passed since your wealth exceeded the Nisab. Many Muslims choose to pay during Ramadan for increased blessings.' ),
				array( 'Who can receive Zakat?', 'Zakat can be given only to a Muslim who is genuinely in need, meaning someone who does not own wealth equal to the Nisab beyond their basic needs, and who is not a Sayyid. It is always given so that the recipient becomes its owner; in our Community Kitchen each eligible person receives a full plate of food, or has their own container filled, and takes it as their own.' ),
			),
		),
		array(
			'topic' => 'Sadaqah',
			'faqs'  => array(
				array( 'What is Sadaqah?', 'Sadaqah is a voluntary act of charity given out of compassion, love, or generosity. Unlike Zakat, there is no minimum amount and it can be given at any time.' ),
				array( 'What is the difference between Sadaqah and Zakat?', 'Zakat is obligatory and has specific rules about amounts and recipients. Sadaqah is voluntary, can be any amount, and can be given to anyone in need.' ),
				array( 'What is Sadaqah Jariyah?', "Sadaqah Jariyah means 'ongoing charity': charity whose benefit continues over time. Your Sadaqah Jariyah supports the lasting needs of our Community Kitchen, such as utensils, stoves and storage. When these needs are met, it supports the kitchen's work of feeding people." ),
				array( 'Can I give Sadaqah to non-Muslims?', 'Yes, Sadaqah can be given to anyone in need regardless of their faith. The key is the intention to help those who are struggling.' ),
			),
		),
		array(
			'topic' => 'Fidya & Kaffarah',
			'faqs'  => array(
				array( 'Can I give Fidya or Kaffarah through Daan Foundation right now?', 'No. Daan Foundation is no longer accepting Fidyah or Kaffarah donations. Our kitchen serves food at only one time of the day, and Kaffarah for a broken oath needs two full meals at two separate times of the day for each of ten people. Our Iftar and Community Kitchen donations are not Fidyah or Kaffarah; Community Kitchen donations may be given as Zakat or as Sadaqah.' ),
				array( 'What is Fidya?', 'Fidya is a donation made when someone cannot fast during Ramadan due to illness or old age and cannot make up the fasts later. For each missed fast, the fidya is equal to sadaqat-ul-fitr.' ),
				array( 'How much is Fidya?', 'One sadaqat-ul-fitr per missed fast: about 1.75 kg of wheat, or its price. An Iftar meal, or an Iftar plus one meal, is not Fidya.' ),
				array( 'What is Kaffarah?', 'Kaffarah is the expiation for deliberately breaking a Ramadan fast without a valid reason, or for breaking a sworn oath. For a broken oath it is feeding ten needy people two full meals each at two separate times of the day. For other details, please ask a qualified mufti.' ),
				array( 'When should I pay Fidya vs Kaffarah?', 'Fidya is for someone who cannot fast due to long-term illness or old age. Kaffarah is for someone who deliberately broke a fast without valid excuse, or broke an oath.' ),
			),
		),
	);
}

/**
 * FAQPage schema for /faq/ (S1) -- the page has 14 real, visible Q&A pairs
 * but no FAQPage/Question/Answer markup at all. Pulls from the exact same
 * daan_get_faq_data() the visible page renders, so the schema can never
 * list a question that isn't actually on the page (or vice versa).
 */
add_filter( 'rank_math/json_ld', function ( $data ) {
	if ( ! is_page( 'faq' ) ) {
		return $data;
	}

	$main_entity = array();
	foreach ( daan_get_faq_data() as $category ) {
		foreach ( $category['faqs'] as $faq ) {
			$main_entity[] = array(
				'@type'          => 'Question',
				'name'           => $faq[0],
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => $faq[1],
				),
			);
		}
	}

	$data['faqPage'] = array(
		'@type'      => 'FAQPage',
		'@id'        => home_url( '/faq/#faqpage' ),
		'mainEntity' => $main_entity,
	);

	return $data;
}, 99 );

/**
 * SEO title/description + FAQPage schema for the "Kaffara for Broken Oath
 * (Qasam)" blog post (slug kaffara-for-broken-oath-qasam, post ID 6946).
 * Rank Math meta fields aren't reliably settable via the REST API on this
 * site, so these are set here the same way as the rest of this file --
 * a code-level filter, not a manual wp-admin edit.
 */
add_filter( 'rank_math/frontend/title', function ( $title ) {
	if ( is_singular( 'post' ) && 'kaffara-for-broken-oath-qasam' === get_post_field( 'post_name', get_queried_object_id() ) ) {
		return 'Kaffara for Broken Oath (Qasam) - Rules Explained';
	}
	return $title;
} );

add_filter( 'rank_math/frontend/description', function ( $description ) {
	if ( is_singular( 'post' ) && 'kaffara-for-broken-oath-qasam' === get_post_field( 'post_name', get_queried_object_id() ) ) {
		return 'Kaffara for a broken oath: the correct rule is to feed 10 poor people two full meals each at two separate times of the day, not 60. Daan Foundation no longer accepts Kaffarah donations.';
	}
	return $description;
} );

add_filter( 'rank_math/json_ld', function ( $data ) {
	if ( ! is_singular( 'post' ) || 'kaffara-for-broken-oath-qasam' !== get_post_field( 'post_name', get_queried_object_id() ) ) {
		return $data;
	}

	$data['faqPage'] = array(
		'@type'      => 'FAQPage',
		'@id'        => home_url( '/kaffara-for-broken-oath-qasam/#faqpage' ),
		'mainEntity' => array(
			array(
				'@type'          => 'Question',
				'name'           => 'What is Kaffara for breaking an oath (Qasam) in Islam?',
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => "It's the expiation required when a person swears by Allah's name and cannot keep that promise -- fulfilled by feeding ten needy people, clothing them, or freeing a slave, with fasting three days as a fallback.",
				),
			),
			array(
				'@type'          => 'Question',
				'name'           => 'How many people do I need to feed for Kaffara-e-Qasam?',
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => 'Ten people, each given a full meal. This is different from fasting-Kaffara, which requires feeding sixty people or fasting sixty consecutive days.',
				),
			),
			array(
				'@type'          => 'Question',
				'name'           => 'Kya main apna oath ka Kaffara online pay kar sakta hoon Daan Foundation ke through?',
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => 'Haan, bilkul -- aap online donate kar sakte hain aur humein bata sakte hain ki yeh oath ka Kaffara hai, taaki hum ise sahi tarah se track karke 10 logon tak pohcha sakein.',
				),
			),
			array(
				'@type'          => 'Question',
				'name'           => 'How do I pay Kaffara for breaking a promise online?',
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => "Donate through Daan Foundation's website, noting that the donation is for oath-Kaffara. Our team directs it to feeding ten people through our Community Kitchen and can confirm once it's fulfilled.",
				),
			),
			array(
				'@type'          => 'Question',
				'name'           => 'Is oath-Kaffara the same as Fidyah?',
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => "No. Fidyah applies to someone unable to fast during Ramadan due to illness or old age, while oath-Kaffara applies specifically to a broken promise sworn in Allah's name -- they are separate obligations with separate rules.",
				),
			),
		),
	);

	return $data;
}, 99 );

add_filter( 'rank_math/json_ld', function ( $data ) {
	// D-039 (2026-11-23): this older FAQ said kaffara could be paid through Daan and fidyah = one meal (wrong).
	// The corrected FAQ for this post comes from the SEO27 json_ld filter (daan_seo27_*), so this one is off.
	return $data;
	if ( ! is_singular( 'post' ) || 'kaffara-missed-ramadan-fast' !== get_post_field( 'post_name', get_queried_object_id() ) ) {
		return $data;
	}

	$data['faqPage'] = array(
		'@type'      => 'FAQPage',
		'@id'        => home_url( '/kaffara-missed-ramadan-fast/#faqpage' ),
		'mainEntity' => array(
			array(
				'@type'          => 'Question',
				'name'           => 'How can I pay kaffara online in India?',
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => "You can donate the equivalent value of feeding 60 people directly through Daan Foundation's donation page, mentioning it's a kaffara payment -- we distribute it as real meals through our Amroha community kitchen.",
				),
			),
			array(
				'@type'          => 'Question',
				'name'           => 'What is kaffara in Islam for a missed fast?',
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => "It's the compensation required for deliberately breaking a Ramadan fast without a valid excuse -- typically feeding 60 poor people or fasting 60 consecutive days if feeding isn't possible.",
				),
			),
			array(
				'@type'          => 'Question',
				'name'           => 'Is kaffara the same as fidyah?',
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => 'No. Fidyah is for people with a valid long-term reason for not fasting, usually one meal per missed day. Kaffara is for deliberately breaking a fast without excuse, and is a larger obligation -- typically feeding 60 people.',
				),
			),
			array(
				'@type'          => 'Question',
				'name'           => 'Kya main kaffara ek hi baar mein online de sakta hoon?',
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => 'Haan, aap poori kaffara amount ek hi baar mein Daan Foundation ko donate kar sakte hain, aur hum ise 60 logon tak meals ke roop mein pahuncha dete hain -- aapko khud logon dhundhne ki zaroorat nahi.',
				),
			),
			array(
				'@type'          => 'Question',
				'name'           => 'Where does my kaffara donation actually go?',
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => "It goes directly into Daan Foundation's community kitchen operations in Amroha -- real ingredients, real cooking, and real meals served to families in need, with no funds diverted elsewhere.",
				),
			),
		),
	);

	return $data;
}, 99 );

/**
 * Social-sharing meta tag fixes (M8 + M9).
 *
 * M9: Rank Math outputs og:type="article" for every non-post URL, including
 * the front page's own og:type slot on some templates and every static
 * Page (Donate, FAQ, Zakat Calculator, ...) -- confirmed live via curl.
 * Only real blog posts should be "article"; everything else is "website".
 *
 * M8: none of the site's Pages have a featured image, and Rank Math has no
 * sitewide fallback image configured (that's a Titles & Meta setting in
 * wp-admin, which we don't have access to) -- so og:image is missing
 * entirely on every Page, and Twitter's summary_large_image card ships
 * with no image either. Spot-checked a live blog post too: it also has no
 * og:image, so the fallback is applied everywhere Rank Math didn't already
 * supply an image, not just on Pages.
 *
 * There's no documented Rank Math filter guaranteed to fire when it has no
 * image to begin with (its image-output method short-circuits before any
 * filter runs when the thumbnail is empty), so rather than guess at
 * internal hook names this buffers the <head> output and corrects/adds the
 * tags directly -- works regardless of Rank Math's internal logic, and is
 * verifiable against the real rendered HTML.
 */
add_action( 'wp_head', function () {
	ob_start();
}, 1 );

add_action( 'wp_head', function () {
	$head = ob_get_clean();

	if ( ! is_singular( 'post' ) ) {
		$head = str_replace(
			'<meta property="og:type" content="article" />',
			'<meta property="og:type" content="website" />',
			$head
		);
	}

	if ( false === strpos( $head, 'property="og:image"' ) ) {
		$logo = home_url( '/images/daan-foundation-logo.png' );
		$tags = '<meta property="og:image" content="' . esc_url( $logo ) . '" />' . "\n";
		$tags .= '<meta property="og:image:width" content="500" />' . "\n";
		$tags .= '<meta property="og:image:height" content="500" />' . "\n";

		if ( false === strpos( $head, 'name="twitter:image"' ) ) {
			$tags .= '<meta name="twitter:image" content="' . esc_url( $logo ) . '" />' . "\n";
		}

		if ( false !== strpos( $head, '<meta property="og:site_name"' ) ) {
			$head = str_replace( '<meta property="og:site_name"', $tags . '<meta property="og:site_name"', $head );
		} else {
			$head .= $tags;
		}
	}

	echo $head; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $head is Rank Math's own already-escaped output plus our own esc_url()'d tags.
}, 999 );

/**
 * BreadcrumbList schema for the 10 "Our Work" subpages (I6).
 *
 * Audit found zero BreadcrumbList schema anywhere on the site; these 10
 * pages were the specific example (they also had no visible breadcrumb --
 * added separately in tpl-sidebar-content.php). Scoped by WP page hierarchy
 * (post_parent's slug is 'our-work'), not a hardcoded slug list, so any
 * subpage added under the hub later picks this up automatically.
 */
add_filter( 'rank_math/json_ld', function ( $data ) {
	if ( ! is_page() ) {
		return $data;
	}

	$post_id     = get_queried_object_id();
	$parent_id   = wp_get_post_parent_id( $post_id );
	$parent_slug = $parent_id ? get_post_field( 'post_name', $parent_id ) : '';

	if ( 'our-work' !== $parent_slug ) {
		return $data;
	}

	$data['breadcrumbList'] = array(
		'@type'           => 'BreadcrumbList',
		'@id'             => get_permalink( $post_id ) . '#breadcrumblist',
		'itemListElement' => array(
			array( '@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => home_url( '/' ) ),
			array( '@type' => 'ListItem', 'position' => 2, 'name' => 'Our Work', 'item' => home_url( '/our-work/' ) ),
			array( '@type' => 'ListItem', 'position' => 3, 'name' => get_the_title( $post_id ), 'item' => get_permalink( $post_id ) ),
		),
	);

	return $data;
}, 99 );

/**
 * 301 redirects for indexed junk pages removed from the technical audit.
 *
 * test/ and test-2/ (post IDs 5015, 5506) were empty dev-leftover posts.
 * hello-world/ (post ID 1) was WordPress's own default installer sample
 * post ("Welcome to WordPress..."). All three were trashed (not hard-
 * deleted -- restorable from wp-admin trash) via the REST API. Hooked at
 * priority 5, before WordPress's own wp_old_slug_redirect() (priority 10),
 * which was otherwise sending test/ to /product/test-product/ -- itself
 * another leftover WooCommerce test product, not a real destination.
 *
 * bank-detail/ (page ID 5638) is a stale duplicate of bank-details/ (page
 * ID 6781, the URL actually linked sitewide in the footer). Both show the
 * same account number/IFSC/branch, but bank-detail/'s UPI ID (42818355421@sbi)
 * and QR code differ from bank-details/'s current ones (8899152910@ptsbi) --
 * flagged, not resolved here; bank-details/ is the actively-maintained page
 * so it's kept as the redirect target as-is.
 */
add_action( 'template_redirect', function () {
	$path = trim( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );

	$redirect_map = array(
		'test'         => home_url( '/' ),
		'test-2'       => home_url( '/' ),
		'hello-world'  => home_url( '/news/' ),
		'bank-detail'  => home_url( '/bank-details/' ),
	);

	if ( isset( $redirect_map[ $path ] ) ) {
		wp_safe_redirect( $redirect_map[ $path ], 301 );
		exit;
	}
}, 5 );

/**
 * Self-referencing canonical for WooCommerce cart/checkout/my-account (H2 fix).
 *
 * Rank Math correctly sets noindex on these three -- confirmed live, and
 * intentionally left alone here, per WooCommerce/Rank Math's own default
 * (noindex a dynamic account/cart page, but it can still be canonical). What
 * Rank Math does NOT do is output any canonical tag at all on these three --
 * confirmed empty on all three live before this fix. Same buffer-and-inject
 * technique as the earlier og:image fix (M8), since there's no reliable
 * Rank Math filter that fires when it has no canonical to begin with.
 */
add_action( 'wp_head', function () {
	if ( function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() ) ) {
		ob_start();
	}
}, 1 );

add_action( 'wp_head', function () {
	if ( ! function_exists( 'is_cart' ) || ! ( is_cart() || is_checkout() || is_account_page() ) ) {
		return;
	}

	$head = ob_get_clean();

	if ( false === strpos( $head, 'rel="canonical"' ) ) {
		if ( is_cart() ) {
			$self_url = wc_get_cart_url();
		} elseif ( is_checkout() ) {
			$self_url = wc_get_checkout_url();
		} else {
			$self_url = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
		}
		$head .= '<link rel="canonical" href="' . esc_url( $self_url ) . '" />' . "\n";
	}

	echo $head;
}, 99 );

/**
 * Item 4b/4c/4d -- title/description fixes for the technical audit's
 * >60-char-title, missing/oversized-description, and duplicate-title
 * items. Rank Math's own title/description meta fields aren't reliably
 * settable via REST on this site (confirmed by testing rank_math_title
 * directly: write silently accepted, live title unchanged) -- same
 * code-filter pattern as every other title/description fix this session.
 *
 * Three separate slug=>value maps (post/page/product) because WordPress
 * allows the same slug across different post types (e.g. the content
 * page "zakat" and the product "zakat" are two different posts sharing
 * one slug) -- a single flat lookup would collide between them.
 */
add_filter( 'rank_math/frontend/title', function ( $title ) {
	if ( is_singular( 'post' ) ) {
		$slug   = get_post_field( 'post_name', get_queried_object_id() );
		$titles = array(
		'zakat-distribution-drive-2027' => 'Zakat Distribution Drive 2027',
		'reliable-ramadan-iftar-donation-websites' => 'Reliable Ramadan Iftar Donation Websites',
		'why-no-one-should-sleep-hungry-daan-foundations-food-mission' => 'Why No One Should Sleep Hungry',
		'looking-for-a-reliable-islamic-charity-ngo-learn-how-to-donate-zakat-online-pay-kaffara-and-support-ramadan-iftaar-meals-in-india-daan-foundation-amroha-helps-you-feed-the-poor-through-sadqah-and' => 'Islamic Charity NGO for Zakat & Iftar',
		'how-%e2%82%b955-can-feed-a-hungry-person-for-a-day-a-ground-reality-from-the-daan-foundations-community-kitchen' => 'How ₹55 Feeds a Hungry Person for a Day',
		'ramadan-2026-iftar-donation-guide-how-to-support-families-in-need' => 'Ramadan 2026 Iftar Donation Guide',
		'how-to-calculate-fidyah-for-sick-person-in-ramadan-2026-fidyah-payment-kaffara-feeding-zakat-donation-sadqah-charity-guide-india' => 'How to Calculate Fidyah in Ramadan 2026',
		'meals-with-dignity-how-we-maintain-hygiene-and-respect-at-daan-foundation' => 'Meals with Dignity: Hygiene & Respect',
		'volunteers-speak-serving-food-changed-my-life' => 'Volunteers Speak: Food Changed My Life',
		'behind-the-scenes-how-we-cook-1000-meals-a-day' => 'How Our Community Kitchen Cooks for 100–120 People Every Day',
		'feeding-the-poor-daily-life-inside-a-community-kitchen' => 'Daily Life Inside a Community Kitchen',
		'what-is-a-community-kitchen-and-how-does-it-work-in-india' => 'What is a Community Kitchen in India?',
		'the-timeless-virtue-of-feeding-a-fasting-person-a-tradition-over-a-millennium-old' => 'The Virtue of Feeding a Fasting Person',
		'where-does-your-iftar-donation-go' => 'Where Does Your Iftar Donation Go?',
		'kaffara-missed-ramadan-fast' => 'Kaffara for a Missed Ramadan Fast: Meaning, Amount & Rules',
		);
		if ( isset( $titles[ $slug ] ) ) {
			return $titles[ $slug ] . ' - Daan Foundation';
		}
	}

	if ( is_singular( 'product' ) ) {
		$slug   = get_post_field( 'post_name', get_queried_object_id() );
		$titles = array(
		'where-most-needed' => 'Donate to Where Most Needed',
		'serving-iftar' => 'Donate to Serving Iftar',
		'community-kitchen' => 'Donate to Community Kitchen',
		'sadqah' => 'Donate Sadqah Online',
		'bank-interest' => 'Donate Bank Interest',
		'fidya-and-kaffara' => 'Donate Fidya & Kaffara',
		'zakat' => 'Donate Zakat Online',
		);
		if ( isset( $titles[ $slug ] ) ) {
			return $titles[ $slug ] . ' - Daan Foundation';
		}
	}

	return $title;
} );

add_filter( 'rank_math/frontend/description', function ( $description ) {
	if ( is_singular( 'post' ) ) {
		$slug  = get_post_field( 'post_name', get_queried_object_id() );
		$descs = array(
		'zakat-distribution-drive-2027' => 'Daan Foundation\'s Zakat Distribution Drive 2027 channels Zakat directly to eligible families in India, with full transparency on every rupee.',
		'reliable-ramadan-iftar-donation-websites' => 'Looking for a trustworthy Ramadan donation website? Learn what makes an Iftar platform reliable, and how Daan Foundation reaches fasting families.',
		'why-no-one-should-sleep-hungry-daan-foundations-food-mission' => 'Daan Foundation\'s food mission: no one should sleep hungry. See how our Community Kitchen and relief work reach vulnerable families across India.',
		'behind-the-scenes-how-we-cook-1000-meals-a-day' => 'A behind-the-scenes look at how Daan Foundation\'s Community Kitchen in Amroha serves a hot, freshly cooked meal to 100–120 people in need every day.',
		'feeding-the-poor-daily-life-inside-a-community-kitchen' => 'An inside look at daily life in Daan Foundation\'s Community Kitchen -- how meals are planned, cooked, and distributed to families in need every day.',
		'where-does-your-iftar-donation-go' => 'See exactly where your iftar donation goes: a ' . "\u{20B9}" . ( function_exists( 'daan_iftar_kit_price' ) ? daan_iftar_kit_price() : 91 ) . ' Iftar kit, tracked from payment to a fasting person at Daan Foundation, Amroha.',
		'kaffara-missed-ramadan-fast' => 'What is kaffara for a missed Ramadan fast? Daan Foundation explains the rule. Daan Foundation no longer accepts Kaffarah donations.',
		);
		if ( isset( $descs[ $slug ] ) ) {
			return $descs[ $slug ];
		}
	}

	if ( is_page() ) {
		$post_obj    = get_queried_object();
		$parent_slug = $post_obj->post_parent ? get_post_field( 'post_name', $post_obj->post_parent ) : '';
		$slug        = $parent_slug ? $parent_slug . '/' . $post_obj->post_name : $post_obj->post_name;
		$descs = array(
		'bank-details' => 'Donate directly to Daan Foundation via bank transfer or UPI. Find our verified account number, IFSC code, and branch details for secure direct donations.',
		'appeals' => 'Current emergency appeals from Daan Foundation -- support our Community Kitchen and other urgent relief efforts serving vulnerable families across India.',
		'donation-confirmation' => 'Your donation to Daan Foundation has been received and is being processed. Thank you for supporting our work with vulnerable communities across India.',
		'donor-dashboard' => 'View your donation history and account details with Daan Foundation. Track your contributions to Zakat, Sadaqah, and Community Kitchen programs.',
		'donate-now' => 'Donate now to Daan Foundation. Support Zakat, Sadaqah, and emergency relief for vulnerable families across India -- every rupee reaches those in need.',
		'our-work/why-transparency' => 'Daan Foundation is committed to full financial transparency -- we account for every donation, not a fixed annual report format.',
		'our-work/serving-with-dignity' => 'Daan Foundation serves every person in need with dignity and respect, ensuring aid is delivered in a way that preserves the recipient\'s self-worth.',
		'serving-iftar' => 'Daan Foundation\'s Serving Iftar program provides Iftar meals to fasting families in need during Ramadan, funded entirely by individual donations.',
		'refund-policy' => 'Daan Foundation\'s refund policy for donations made through our website -- read the terms covering cancellations, errors, and refund requests.',
		'sadqah' => 'Give Sadqah online through Daan Foundation. Your voluntary charity directly funds meals and support for vulnerable families, with full transparency.',
		);
		if ( isset( $descs[ $slug ] ) ) {
			return $descs[ $slug ];
		}
	}

	if ( is_singular( 'product' ) ) {
		$slug  = get_post_field( 'post_name', get_queried_object_id() );
		$descs = array(
		'serving-iftar' => 'Donate to fund Iftar meals for families in need this Ramadan. Every contribution goes directly to Daan Foundation\'s Iftar program.',
		'community-kitchen' => 'Donate to Daan Foundation\'s Community Kitchen in Amroha, which serves a hot meal to 100–120 people in need every day, since 2020. ₹' . ( function_exists( 'daan_meal_price' ) ? daan_meal_price() : 60 ) . ' feeds one person.',
		'sadqah' => 'Give Sadqah online to Daan Foundation. Your voluntary charity provides consistent food and essential support to needy families, with full transparency.',
		'bank-interest' => 'Donate disallowed bank interest (riba) to Daan Foundation for distribution to those in need, in line with Islamic guidance on handling interest income.',
		'fidya-and-kaffara' => 'Daan Foundation is no longer accepting Fidyah or Kaffarah donations. Read the rules and see other ways to help families in need.',
		'zakat' => 'Donate your Zakat online to Daan Foundation. Your Zakat funds our community kitchens and food distribution programs, reaching families in genuine need.',
		'education-aid' => 'Donate to Daan Foundation\'s Education Aid program, extending support to deserving children and families with limited access to quality education.',
		);
		if ( isset( $descs[ $slug ] ) ) {
			return $descs[ $slug ];
		}
	}

	return $description;
}, 5 );

/**
 * FAQPage schema for "Where Does Your Iftar Donation Go?" (post 6967) --
 * same technique as /faq/ and the earlier Kaffara post: Rank Math merges
 * this onto the post's own WebPage node rather than keeping a separate
 * entity, which is the correct schema.org pattern, not a bug.
 */
add_filter( 'rank_math/json_ld', function ( $data ) {
	if ( ! is_singular( 'post' ) || 'where-does-your-iftar-donation-go' !== get_post_field( 'post_name', get_queried_object_id() ) ) {
		return $data;
	}

	$data['faqPage'] = array(
		'@type'      => 'FAQPage',
		'@id'        => home_url( '/where-does-your-iftar-donation-go/#faqpage' ),
		'mainEntity' => array(
			array(
				'@type'          => 'Question',
				'name'           => 'Where does my iftar donation actually go?',
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => "It funds a specific Iftar meal -- dates, a hot meal, and water -- prepared fresh at Daan Foundation's Amroha kitchen and distributed the same day to a fasting individual or family, costed at Rs.90 per person.",
				),
			),
			array(
				'@type'          => 'Question',
				'name'           => 'How much does one Iftar meal cost through Daan Foundation?',
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => 'Rs.90 per person. This figure is specific to Iftar meals during Ramadan and is different from the Rs.59 figure used for the year-round Community Kitchen program.',
				),
			),
			array(
				'@type'          => 'Question',
				'name'           => 'Can I donate bank interest toward Iftar meals?',
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => 'Yes -- many donors direct disallowed bank interest toward feeding the needy rather than keeping it, and Iftar distribution is a valid use for it, since the funds go directly to feeding people in need.',
				),
			),
			array(
				'@type'          => 'Question',
				'name'           => 'Kya mera iftar donation sirf Amroha mein use hota hai ya doosre shehron mein bhi?',
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => 'Zyadatar Amroha mein hi, jahan roz ka kitchen chalta hai -- lekin Ramadan ke dauran kabhi-kabhi doosre shehron mein bhi pilot Iftar stalls lagte hain, agar us waqt active ho.',
				),
			),
			array(
				'@type'          => 'Question',
				'name'           => 'Is Iftar donation the same as Zakat?',
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => 'Not automatically -- Zakat has specific eligibility rules for both giver and recipient. Many donors give Iftar donations as Sadaqah instead, which has no such restrictions and can be given by anyone, to fund a meal for anyone in need.',
				),
			),
		),
	);

	return $data;
}, 99 );

/* -------------------------------------------------------------------------
 * SEO Ramadan 2027 (owner approved, 2026-11-21; reports/seo-ramadan-2027/,
 * docs/fiqh/decisions.md). Runs after the older filters above and replaces
 * their output where the older text had wrong claims. Old URLs/slugs unchanged.
 * Amounts come from the settings in plugin daan-order-tools.
 * ------------------------------------------------------------------------- */

function daan_seo27_money( $fn, $fallback ) {
	return '₹' . number_format( function_exists( $fn ) ? call_user_func( $fn ) : $fallback );
}

/** Slug key of the current page/post/product for the maps below ('' if none). */
function daan_seo27_key() {
	if ( is_page() ) {
		return 'page:' . get_post_field( 'post_name', get_queried_object_id() );
	}
	if ( is_singular( 'post' ) ) {
		return 'post:' . get_post_field( 'post_name', get_queried_object_id() );
	}
	if ( is_singular( 'product' ) ) {
		return 'product:' . get_post_field( 'post_name', get_queried_object_id() );
	}
	return '';
}

add_filter( 'rank_math/frontend/title', function ( $title ) {
	$fitra = daan_seo27_money( 'daan_fitrana_rate', 90 );
	$kit   = daan_seo27_money( 'daan_kit_price', 1536 );
	$map   = array(
		'page:ramadan'                       => 'Donate Iftar in India | Ramadan 2027 Iftar Kits – Daan Foundation',
		'page:zakat-al-fitr'                 => 'Fitrana 2027 India: Amount ' . $fitra . ', Pay Online | Daan Foundation',
		'page:bank-interest'                 => 'Donate Bank Interest (Riba) as Ration Kits | Daan Foundation',
		'post:ration-kit-distribution-india' => 'Ration Kit Donation for Poor Families in India (' . $kit . ') | Daan Foundation',
		'product:ration-kit-donation'        => 'Donate Ration Kit for Poor Families in India | ' . $kit,
		// Quick wins (owner, 2026-11-23, D-038): high impressions, low CTR.
		'page:home'                          => 'Daan Foundation – Iftar Kits, Ration Kits & Community Kitchen, Amroha',
		'page:about'                         => 'About Daan Foundation – Community Kitchen in Amroha Since 2020',
		'post:what-is-a-community-kitchen-and-how-does-it-work-in-india' => 'Community Kitchen Meaning & How It Works in India | Daan Foundation',
		'post:how-%e2%82%b955-can-feed-a-hungry-person-for-a-day-a-ground-reality-from-the-daan-foundations-community-kitchen' => 'How ' . daan_seo27_money( 'daan_meal_price', 60 ) . ' Feeds a Hungry Person a Full Meal – Amroha Community Kitchen',
	);
	$key = daan_seo27_key();
	return isset( $map[ $key ] ) ? $map[ $key ] : $title;
}, 20 );

add_filter( 'rank_math/frontend/description', function ( $description ) {
	$fitra = daan_seo27_money( 'daan_fitrana_rate', 90 );
	$kit   = daan_seo27_money( 'daan_kit_price', 1536 );
	$iftar = daan_seo27_money( 'daan_iftar_kit_price', 91 );
	$map   = array(
		'page:ramadan'                       => 'Donate Iftar online for fasting people in Amroha, UP. One Iftar kit ' . $iftar . ': veg biryani, dates, fruit, egg and a soft drink. Give through Daan Foundation.',
		'page:zakat-al-fitr'                 => 'Fitrana 2027: ' . $fitra . ' per person (wheat, the minimum). Give your family\'s Fitrana online as a ' . $kit . ' ration kit. Please pay at least 3 days before Eid.',
		'page:donate'                        => 'Donate online to Daan Foundation by UPI: Community Kitchen meals, Iftar kits, Zakat, Sadaqah and ration kits for families in need in India.',
		'page:bank-interest'                 => 'Interest money must be given away without any intention of reward. We use it only for ration kits (' . $kit . ') that families own. Not Zakat. Daan Foundation.',
		'post:ration-kit-distribution-india' => 'Donate a ration kit (' . $kit . ') for a poor family: atta, rice, dal, oil and more. See the full kit list. Daan Foundation, Amroha, Uttar Pradesh.',
		'product:fitrana-ration-kit'         => 'Give your family\'s Fitrana as a complete ration kit (' . $kit . ') for a family in need. Fitrana from ' . $fitra . ' per person, counted from the food items only.',
		'product:ration-kit-donation'        => 'Donate a complete ration kit (' . $kit . ') to a poor family in India: 18 essential items including atta, rice, dal, oil and spices. Daan Foundation, Amroha.',
		'product:ramadan-iftar'              => 'Sponsor Iftar kits for fasting people in need. Each kit ' . $iftar . ': veg biryani, dates, fruit, egg and a soft drink. Handed out at our Amroha kitchen.',
		// Quick wins (owner, 2026-11-23, D-038).
		'page:home'                          => 'Daan Foundation (founded 2020) runs a Community Kitchen in Amroha, UP, feeding 100–120 people every day. Donate an Iftar kit (' . $iftar . ') or a ration kit (' . $kit . ') by UPI.',
		'page:about'                         => 'Daan Foundation was founded in 2020 in Amroha, UP, by a team with 12–15 years of community service. Our Community Kitchen feeds 100–120 people every day.',
		'page:kaffarah'                      => 'What is Kaffarah? The rules for a broken fast and a broken oath (feed 10 poor people two full meals each at two separate times of the day). Daan Foundation no longer accepts Kaffarah donations.',
		'post:what-is-a-community-kitchen-and-how-does-it-work-in-india' => 'Community kitchen meaning: a kitchen that cooks and serves free meals to people in need. See how ours in Amroha feeds 100–120 people every day, ' . daan_seo27_money( 'daan_meal_price', 60 ) . ' a meal.',
		'post:how-%e2%82%b955-can-feed-a-hungry-person-for-a-day-a-ground-reality-from-the-daan-foundations-community-kitchen' => 'Just ' . daan_seo27_money( 'daan_meal_price', 60 ) . ' feeds one person a full, freshly cooked meal at our Community Kitchen in Amroha, which serves 100–120 people every day.',
	);
	$key = daan_seo27_key();
	return isset( $map[ $key ] ) ? $map[ $key ] : $description;
}, 30 );

/** FAQPage node from [question, answer] pairs. */
function daan_seo27_faq( $id_url, $pairs ) {
	$items = array();
	foreach ( $pairs as $p ) {
		$items[] = array(
			'@type'          => 'Question',
			'name'           => wp_strip_all_tags( $p[0] ),
			'acceptedAnswer' => array( '@type' => 'Answer', 'text' => wp_strip_all_tags( $p[1] ) ),
		);
	}
	return array( '@type' => 'FAQPage', '@id' => $id_url . '#faqpage', 'mainEntity' => $items );
}

/** The visible FAQ items of a sidebar-layout page (inc/page-content.php), so schema and page always match. */
function daan_seo27_page_faq_pairs( $slug ) {
	$data  = function_exists( 'daan_get_page_data' ) ? daan_get_page_data( $slug ) : null;
	$pairs = array();
	foreach ( (array) ( $data['sections'] ?? array() ) as $section ) {
		if ( 'faq' === ( $section['type'] ?? '' ) ) {
			foreach ( $section['items'] as $item ) {
				$pairs[] = array( $item['q'], $item['a'] );
			}
		}
	}
	return $pairs;
}

/** Visible FAQ of the Bank Interest page (its Elementor text holds the same strings). */
function daan_seo27_bank_interest_pairs() {
	return array(
		array( 'Sood ka paisa kisko dena chahiye? (Who should receive interest money?)', 'To people in need, without any intention of reward (Darul Ifta, Darul Uloom Deoband). Daan Foundation uses it only for ration kits that each family receives and owns.' ),
		array( 'Can I give interest money to charity?', 'Interest money must be given away to people in need, without any intention of reward. Through Daan Foundation it goes only into ration kits.' ),
		array( 'Is interest money counted as Zakat?', 'No. Interest money is not counted as Zakat.' ),
		array( 'Who pays for transport and delivery?', 'Your entire interest amount goes into the kit items; the cost of transport and our website is paid by Daan Foundation from its general funds.' ),
	);
}

/** Visible FAQ added to the ration kit post (its content holds the same strings). */
function daan_seo27_ration_pairs() {
	$kit = daan_seo27_money( 'daan_kit_price', 1536 );
	return array(
		array( 'What is the ration kit price?', 'One ration kit is ' . $kit . '.' ),
		array( 'Can I give interest money for ration kits?', 'Yes. Interest money is given without any intention of reward, only through the Ration Kit (Interest Money). Its delivery cost is paid by Daan Foundation from its general funds.' ),
		array( 'Can I give my Fitrana as a ration kit?', 'Yes. Daan Foundation accepts Fitrana only as complete Fitrana Ration Kits; Fitrana is counted from the food items in the kit.' ),
	);
}

add_filter( 'rank_math/json_ld', function ( $data ) {
	$key = daan_seo27_key();
	if ( '' === $key ) {
		return $data;
	}
	$url = get_permalink( get_queried_object_id() );
	switch ( $key ) {
		case 'page:ramadan':
		case 'page:zakat-al-fitr':
			$pairs = daan_seo27_page_faq_pairs( substr( $key, 5 ) );
			if ( $pairs ) {
				$data['faqPage'] = daan_seo27_faq( $url, $pairs );
			}
			break;
		case 'page:bank-interest':
			$data['faqPage'] = daan_seo27_faq( $url, daan_seo27_bank_interest_pairs() );
			break;
		case 'post:ration-kit-distribution-india':
			$data['faqPage'] = daan_seo27_faq( $url, daan_seo27_ration_pairs() );
			break;
		case 'post:kaffara-for-broken-oath-qasam':
			$data['faqPage'] = daan_seo27_faq( $url, array(
				array( 'What is Kaffara for breaking an oath (Qasam) in Islam?', "It\u{2019}s the expiation required when a person swears by Allah\u{2019}s name and cannot keep that promise \u{2014} fulfilled by feeding ten needy people two full meals at two separate times of the day, clothing them, or freeing a slave, with fasting three days as a fallback." ),
				array( 'How many people do I need to feed for Kaffara-e-Qasam?', 'Ten needy people, each given two full meals at two separate times of the day (such as morning and evening).' ),
				array( 'Can I give oath Kaffara through Daan Foundation?', 'No. Daan Foundation is no longer accepting Kaffarah donations, because our kitchen serves food at only one time of the day and cannot serve at two separate times, as Kaffarah needs.' ),
				array( 'Is oath-Kaffara the same as Fidyah?', "No. Fidyah applies to someone unable to fast during Ramadan due to illness or old age, while oath-Kaffara applies specifically to a broken promise sworn in Allah\u{2019}s name \u{2014} they are separate obligations with separate rules." ),
			) );
			break;
		case 'post:kaffara-missed-ramadan-fast':
			$data['faqPage'] = daan_seo27_faq( $url, array(
				array( 'What is kaffara in Islam for a missed fast?', "It\u{2019}s the compensation required for deliberately breaking a Ramadan fast without a valid excuse \u{2014} fasting 60 consecutive days, or, only if a person cannot fast, feeding 60 poor people two full meals each at two separate times of the day." ),
				array( 'Is kaffara the same as fidyah?', 'No. Fidyah is for people with a lasting reason for not fasting (like chronic illness), equal to sadaqat-ul-fitr (about 1.75 kg of wheat or its price) per missed fast. Kaffara is for deliberately breaking a fast without excuse.' ),
				array( 'Kya abhi Daan Foundation ke zariye roze ka kaffara de sakte hain?', 'Nahi. Daan Foundation ab Kaffara aur Fidyah ki donation nahi leta, kyunki hamara kitchen din me ek hi waqt ka khana deta hai.' ),
			) );
			break;
		case 'post:where-does-your-iftar-donation-go':
			$iftar = daan_seo27_money( 'daan_iftar_kit_price', 91 );
			$items = function_exists( 'daan_iftar_kit_items_text' ) ? daan_iftar_kit_items_text() : '';
			$data['faqPage'] = daan_seo27_faq( $url, array(
				array( 'Where does my iftar donation actually go?', "It funds a specific Iftar kit \u{2014} " . $items . " \u{2014} prepared fresh at Daan Foundation\u{2019}s Amroha kitchen and handed out the same day after Asr, costed at " . $iftar . ' per kit.' ),
				array( 'How much does one Iftar kit cost through Daan Foundation?', $iftar . ' per kit. This figure is specific to Iftar kits during Ramadan and is different from the ₹60 figure used for the year-round Community Kitchen program.' ),
				array( 'Is bank interest used for Iftar meals?', 'No. Bank interest should be given away without any intention of reward, and we use interest donations only to provide ration kits, which each family receives and owns. It is not Zakat.' ),
				array( 'Is my iftar donation used only in Amroha, or in other cities too?', 'In Amroha, where the daily kitchen runs.' ),
				array( 'Is Iftar donation the same as Zakat?', "Not automatically \u{2014} Zakat has specific eligibility rules for both giver and recipient. Many donors give Iftar donations as Sadaqah instead, which has no such restrictions and can be given by anyone, to fund a meal for anyone in need." ),
			) );
			break;
	}
	return $data;
}, 120 );
