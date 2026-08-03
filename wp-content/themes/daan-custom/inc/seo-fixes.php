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
				array( 'Who can receive Zakat?', 'There are eight categories of Zakat recipients mentioned in the Quran: the poor, the needy, Zakat administrators, those whose hearts are to be reconciled, freeing captives, those in debt, in the cause of Allah, and travelers in need.' ),
			),
		),
		array(
			'topic' => 'Sadaqah',
			'faqs'  => array(
				array( 'What is Sadaqah?', 'Sadaqah is a voluntary act of charity given out of compassion, love, or generosity. Unlike Zakat, there is no minimum amount and it can be given at any time.' ),
				array( 'What is the difference between Sadaqah and Zakat?', 'Zakat is obligatory and has specific rules about amounts and recipients. Sadaqah is voluntary, can be any amount, and can be given to anyone in need.' ),
				array( 'What is Sadaqah Jariyah?', "Sadaqah Jariyah means 'ongoing charity.' It refers to charitable acts that continue to benefit others long after the initial gift, such as building a well or school." ),
				array( 'Can I give Sadaqah to non-Muslims?', 'Yes, Sadaqah can be given to anyone in need regardless of their faith. The key is the intention to help those who are struggling.' ),
			),
		),
		array(
			'topic' => 'Fidya & Kaffarah',
			'faqs'  => array(
				array( 'What is Fidya?', 'Fidya is a donation made when someone cannot fast during Ramadan due to illness or old age and cannot make up the fasts later. It involves feeding one person for each missed fast.' ),
				array( 'What is Kaffarah?', 'Kaffarah is a penalty paid for deliberately breaking a fast without valid reason. It requires fasting for 60 consecutive days or feeding 60 poor people for each fast broken.' ),
				array( 'When should I pay Fidya vs Kaffarah?', 'Pay Fidya if you cannot fast due to long-term illness or old age. Pay Kaffarah if you deliberately broke a fast without valid excuse.' ),
				array( 'How much is Fidya?', 'Fidya is the cost of one meal per missed fast. The amount varies by region but is typically approximately ₹59 per day (cost of one meal).' ),
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
