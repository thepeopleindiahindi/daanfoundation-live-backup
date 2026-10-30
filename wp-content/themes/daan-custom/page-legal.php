<?php
/**
 * Template Name: Legal Page
 *
 * Reusable layout for legal pages (Terms, Privacy, Refund) built in Elementor.
 * It shows the SAME content in the theme style: it reads the page's Elementor
 * data (image + text-editor widgets, in order) and renders it without the
 * Elementor layout. The Elementor data itself is not changed.
 * Rollback: set the page template back to "Default".
 *
 * If the content starts with "<h2>…</h2><p><em>…</em></p>" (document title +
 * "Last Updated" line) those two blocks are shown in the title area, in the
 * same order. Headings in the body get ids and feed the "On this page" list.
 */
get_header();

while ( have_posts() ) :
	the_post();

	$daan_legal_image = null;
	$daan_legal_html  = '';
	$daan_legal_raw   = get_post_meta( get_the_ID(), '_elementor_data', true );
	$daan_legal_tree  = is_string( $daan_legal_raw ) ? json_decode( $daan_legal_raw, true ) : null;

	if ( is_array( $daan_legal_tree ) ) {
		$daan_legal_walk = function ( $elements ) use ( &$daan_legal_walk, &$daan_legal_image, &$daan_legal_html ) {
			foreach ( $elements as $el ) {
				$type     = $el['widgetType'] ?? '';
				$settings = $el['settings'] ?? array();
				if ( 'image' === $type && ! $daan_legal_image && ! empty( $settings['image'] ) ) {
					$daan_legal_image = $settings['image'];
				} elseif ( 'text-editor' === $type && isset( $settings['editor'] ) ) {
					// Same steps as Elementor's text-editor widget output.
					$daan_legal_html .= wptexturize( do_shortcode( shortcode_unautop( $settings['editor'] ) ) );
				}
				if ( ! empty( $el['elements'] ) ) {
					$daan_legal_walk( $el['elements'] );
				}
			}
		};
		$daan_legal_walk( $daan_legal_tree );
	}
	if ( '' === $daan_legal_html ) {
		$daan_legal_html = apply_filters( 'the_content', get_the_content() );
	}

	// Title-area blocks: leading document heading + "Last Updated" line.
	$daan_legal_intro = '';
	if ( preg_match( '#^\s*(<h2[^>]*>.*?</h2>)\s*(<p>\s*<em>.*?</em>\s*</p>)#s', $daan_legal_html, $m ) ) {
		$daan_legal_intro = $m[1] . $m[2];
		$daan_legal_html  = substr( $daan_legal_html, strlen( $m[0] ) );
	}

	// Anchor ids for H2/H3 + table of contents.
	$daan_legal_toc  = array();
	$daan_legal_used = array();
	$daan_legal_html = preg_replace_callback(
		'#<(h[23])(\s[^>]*)?>(.*?)</\1>#s',
		function ( $mm ) use ( &$daan_legal_toc, &$daan_legal_used ) {
			$text = trim( wp_strip_all_tags( $mm[3] ) );
			$id   = sanitize_title( $text );
			$id   = $id ? $id : 'section';
			$base = $id;
			$n    = 2;
			while ( isset( $daan_legal_used[ $id ] ) ) {
				$id = $base . '-' . $n++;
			}
			$daan_legal_used[ $id ] = true;
			$daan_legal_toc[]       = array( 'level' => $mm[1], 'id' => $id, 'text' => $text );
			return '<' . $mm[1] . ' id="' . esc_attr( $id ) . '"' . ( $mm[2] ?? '' ) . '>' . $mm[3] . '</' . $mm[1] . '>';
		},
		$daan_legal_html
	);

	$daan_legal_toc_html = '';
	if ( count( $daan_legal_toc ) > 2 ) {
		$daan_legal_toc_html .= '<ol class="legal-toc-list">';
		foreach ( $daan_legal_toc as $t ) {
			$daan_legal_toc_html .= '<li class="legal-toc-' . esc_attr( $t['level'] ) . '"><a href="#' . esc_attr( $t['id'] ) . '">' . esc_html( $t['text'] ) . '</a></li>';
		}
		$daan_legal_toc_html .= '</ol>';
	}
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'legal-page' ); ?>>
		<header class="legal-hero">
			<div class="legal-hero-inner">
				<h1 class="legal-title"><?php the_title(); ?></h1>
				<?php if ( $daan_legal_intro ) : ?>
					<div class="legal-intro"><?php echo $daan_legal_intro; // phpcs:ignore WordPress.Security.EscapeOutput -- page content, as Elementor printed it ?></div>
				<?php endif; ?>
			</div>
		</header>

		<div class="legal-layout<?php echo $daan_legal_toc_html ? ' has-toc' : ''; ?>">
			<?php if ( $daan_legal_toc_html ) : ?>
				<aside class="legal-toc" aria-label="On this page">
					<details class="legal-toc-box" open>
						<summary>On this page</summary>
						<nav class="legal-toc-nav"><?php echo $daan_legal_toc_html; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped above ?></nav>
					</details>
				</aside>
			<?php endif; ?>

			<div class="legal-body">
				<?php
				if ( ! empty( $daan_legal_image['id'] ) ) {
					echo wp_get_attachment_image(
						(int) $daan_legal_image['id'],
						'large',
						false,
						array(
							'class'         => 'legal-image',
							'loading'       => 'eager',
							'fetchpriority' => 'high',
							'sizes'         => '(max-width: 800px) 100vw, 760px',
						)
					);
				}
				?>
				<div class="legal-content">
					<?php echo $daan_legal_html; // phpcs:ignore WordPress.Security.EscapeOutput -- page content, as Elementor printed it ?>
				</div>
			</div>
		</div>
	</article>
	<script>
	/* Mobile: TOC starts collapsed; desktop: always open. */
	(function () {
		var d = document.querySelector('.legal-toc-box');
		if (d && window.matchMedia('(max-width: 1023px)').matches) { d.removeAttribute('open'); }
	})();
	</script>
	<?php
endwhile;

get_footer();
