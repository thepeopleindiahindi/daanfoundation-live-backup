<?php
/**
 * Daan Foundation — one-off content cleanups for specific published posts
 *
 * Three posts were published with raw, unedited AI-content-brief scaffolding
 * still in the body: leaked "Slug:"/"Meta Description:" lines, instructional
 * heading annotations like "(H2)"/"(Snippet-Friendly Numbered List)", leaked
 * "Tags:"/"Categories:"/"Word Count:" metadata, a bracketed image-alt note,
 * an unfinished bare-URL citation, a duplicate H1, and a broken email address
 * missing its "@". This only removes/corrects those specific artifacts and
 * fixes the one broken email address — it does not add or rewrite any real
 * copy.
 *
 * @package Daan\Content
 */

add_filter( 'the_content', function ( $content ) {
	if ( ! is_singular( 'post' ) ) {
		return $content;
	}

	$post_id = get_the_ID();

	// Post 6555 — "Ramadan 2026 Iftar Donation Guide — How to Support Families in Need"
	if ( 6555 === $post_id ) {
		$replacements = array(
			// Leaked "Slug:" line — was never meant to be visible body text.
			'<p class="wp-block-paragraph"><strong>Slug:</strong> <code>/ramadan-2026-iftar-donation-guide</code></p>' => '',
			// Instructional annotations left in headings.
			'Introduction (EVERGREEN INTRO LINE)' => 'Introduction',
			'How Your Zakat &amp; Sadqah Support Families (H2)' => 'How Your Zakat &amp; Sadqah Support Families',
			'5 Easy Ways to Donate Zakat Online (Snippet-Friendly Numbered List)' => '5 Easy Ways to Donate Zakat Online',
			'Iftar Donation Options for Ramadan 2026 (H2)' => 'Iftar Donation Options for Ramadan 2026',
			'How Daan Foundation Works Across India (H2)' => 'How Daan Foundation Works Across India',
			'Voice Search Questions to Target (H2)' => 'Common Questions Donors Ask',
			'How Your Donation Creates Real Impact (H2)' => 'How Your Donation Creates Real Impact',
			'Internal Link Suggestion' => 'Related Reading',
			'Q &amp; A Section (For Google Snippets)' => 'Frequently Asked Questions',
			'Call to Action (CTA)' => 'Support a Family This Ramadan',
			// Leaked production notes not meant for readers.
			'<p class="wp-block-paragraph"><strong>Image Suggestion (ALT Text):</strong><br><code>Ramadan-iftar-kit-donation-zakat-poor-India.jpg</code><br><strong>ALT:</strong> “Zakat donation for poor in India — Ramadan Iftaar Kit Distribution”</p>' => '',
			'<p class="wp-block-paragraph">Adding such search-friendly lines helps the blog appear in voice search, especially on mobile.</p>' => '',
			'<p class="wp-block-paragraph">Short paragraphs (mobile-friendly):</p>' => '',
			// Unfinished/broken citation — bare embedded URL with no anchor text or context.
			"<hr class=\"wp-block-separator has-alpha-channel-opacity\"/><h2 class=\"wp-block-heading\"><strong>External Link (Government/Research)</strong></h2><figure class=\"wp-block-embed\"><div class=\"wp-block-embed__wrapper\">\nhttps://impact.economist.com/sustainability/project/food-security-index\n</div></figure>" => '',
			// Backend taxonomy metadata that leaked into the visible article body.
			'<hr class="wp-block-separator has-alpha-channel-opacity"/><h2 class="wp-block-heading"><strong>Tags &amp; Categories</strong></h2><p class="wp-block-paragraph"><strong>Tags:</strong> Zakat, Sadqah, Islamic Charity, Food Distribution, Ramadan Donation India<br><strong>Categories:</strong> NGO, Charity, Islamic Giving, Uttar Pradesh NGO</p>' => '',
			// Duplicate H1 — every other section uses H2, this one should match.
			'<h1 class="wp-block-heading"><strong>Conclusion</strong></h1>' => '<h2 class="wp-block-heading"><strong>Conclusion</strong></h2>',
		);
		$content = str_replace( array_keys( $replacements ), array_values( $replacements ), $content );
	}

	// Post 6767 — "Zakat Donation and Kaffara in Islam..." (title itself is a separate, known issue — M5, not in this batch)
	if ( 6767 === $post_id ) {
		$replacements = array(
			// Duplicate H1: the post title already renders as the page's H1 via
			// the template; this in-content heading duplicated it. Demoted to H2.
			'<h1 class="wp-block-heading">Zakat Donation and Kaffara in Islam: A Complete Guide to Feeding the Poor in India</h1>' => '<h2 class="wp-block-heading">Zakat Donation and Kaffara in Islam: A Complete Guide to Feeding the Poor in India</h2>',
			// Leaked bracketed image-alt production note.
			'<p class="wp-block-paragraph">[Image Alt Text: Zakat donation for poor in India &#8211; Daan Foundation feeding the hungry]</p>' => '',
			// "(External Link: ...)" label wrapper — keep the real, working link, drop the internal label.
			'(External Link: <a target="_blank" rel="noreferrer noopener" href="https://www.fao.org/hunger">fao.org/hunger</a>)' => '(<a target="_blank" rel="noreferrer noopener" href="https://www.fao.org/hunger">fao.org/hunger</a>)',
			// Leaked editorial metadata (word count / category / tag suggestions).
			'<p class="wp-block-paragraph"><strong>Word Count:</strong> 1,148 words</p><p class="wp-block-paragraph"><strong>Category:</strong> Islamic Charity, NGO, Zakat, Food for Poor</p><p class="wp-block-paragraph"><strong>Tags:</strong> Zakat Donation, Sadqah, Ramadan 2026, Kaffara, Daan Foundation, India Charity</p>' => '',
			// Leaked instruction label (the actual CTA link paragraph right after it stays).
			'<p class="wp-block-paragraph"><strong>Call to Action:</strong></p>' => '',
		);
		$content = str_replace( array_keys( $replacements ), array_values( $replacements ), $content );
	}

	// Post 6768 — "How to Calculate Fidyah for Sick Person in Ramadan 2026..."
	if ( 6768 === $post_id ) {
		$replacements = array(
			// Leaked "Meta Description:" and "Slug:" lines — never meant to be visible body text.
			'<p class="wp-block-paragraph"><strong>Meta Description:</strong> Learn how to calculate Fidyah for sick person in Ramadan with simple steps. Understand Fidyah payment vs kaffara in Islam and donate zakat, sadqah charity or bank interest to feed poor families. Daan Foundation Amroha offers reliable Islamic charity NGO support for iftaar donation and ramadan food distribution across India. (148 characters)</p>' => '',
			'<p class="wp-block-paragraph"><strong>Slug:</strong> /how-to-calculate-fidyah-for-sick-person-in-ramadan</p>' => '',
			// Leaked editorial metadata.
			'<p class="wp-block-paragraph"><strong>Tags:</strong> NGO, Islamic Charity, Zakat, Food for Poor, Ramadan Donation India, Fidyah, Kaffara Feeding<br><strong>Categories:</strong> Islamic Charity, Zakat, Sadqah, Food Charity NGO Amroha, Ramadan 2026 Charity</p>' => '',
			'<p class="wp-block-paragraph"></p>' => '',
			// Broken contact email (missing "@") — corrected to match the address used everywhere else on the site.
			'daanfoundationindiagmail.com' => 'daanfoundationindia@gmail.com',
		);
		$content = str_replace( array_keys( $replacements ), array_values( $replacements ), $content );
	}

	return $content;
}, 20 );

/**
 * Meta description overrides for posts where Rank Math already has a value
 * set, but it's the same leaked placeholder text as above (so the normal
 * "only fill in if empty" fallback in seo-fixes.php doesn't apply).
 */
add_filter( 'rank_math/frontend/description', function ( $description ) {
	if ( ! is_singular( 'post' ) ) {
		return $description;
	}

	$overrides = array(
		// "Ramadan 2026 Iftar Donation Guide" — was literally "Slug: /ramadan-2026-iftar-donation-guide"
		6555 => 'A guide to Ramadan 2026 Iftar donations — how to give Zakat, Sadaqah, and support poor families through Daan Foundation, Amroha.',
		// "How to Calculate Fidyah..." — was literally prefixed "Meta Description: ..." and truncated mid-sentence
		6768 => 'Learn how to calculate Fidyah for a sick person in Ramadan with simple steps, and donate to feed poor families through Daan Foundation, Amroha.',
	);

	$post_id = get_the_ID();
	if ( isset( $overrides[ $post_id ] ) ) {
		return $overrides[ $post_id ];
	}

	return $description;
}, 5 );
