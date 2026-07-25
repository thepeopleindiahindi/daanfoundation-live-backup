<?php
/**
 * Template Name: Default with Sidebar
 *
 * Generic template for sidebar pages. Falls through to Elementor if no
 * structured data is found for the current slug.
 */
get_header();

$page_slug = get_post_field( 'post_name', get_the_ID() );
require_once get_template_directory() . '/inc/page-content.php';
$page_data = daan_get_page_data( $page_slug );
?>
	<?php if ( $page_data ) : ?>

		<?php
		get_template_part( 'template-parts/hero-banner', null, array(
			'title'         => $page_data['title'] ?? '',
			'subtitle'      => $page_data['subtitle'] ?? '',
			'gradient'      => $page_data['gradient'] ?? 'from-orange-600 to-orange-700',
			'default_cause' => $page_data['default_cause'] ?? 'where-needed',
		) );

		daan_sidebar_page_start( $page_data['default_cause'] ?? 'where-needed' ); ?>

		<?php if ( ! empty( $page_data['image'] ) ) : ?>
			<div class="rounded-2xl overflow-hidden shadow-lg">
				<img src="<?php echo esc_url( $page_data['image'] ); ?>" alt="<?php echo esc_attr( $page_data['title'] ?? '' ); ?>" class="w-full h-[300px] md:h-[400px] object-cover">
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $page_data['sections'] ) ) :
			foreach ( $page_data['sections'] as $section ) :
				$type = $section['type'] ?? '';
				?>
				<?php if ( 'text' === $type ) : ?>
					<section class="prose max-w-none">
						<?php if ( ! empty( $section['heading'] ) ) : ?>
							<h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4"><?php echo esc_html( $section['heading'] ); ?></h2>
						<?php endif; ?>
						<?php foreach ( $section['paragraphs'] ?? array() as $p ) : ?>
							<p class="text-gray-700 leading-relaxed mb-3"><?php echo esc_html( $p ); ?></p>
						<?php endforeach; ?>
					</section>

				<?php elseif ( 'grid' === $type ) : ?>
					<section>
						<?php if ( ! empty( $section['heading'] ) ) : ?>
							<h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6"><?php echo esc_html( $section['heading'] ); ?></h2>
						<?php endif; ?>
						<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
							<?php foreach ( $section['items'] ?? array() as $item ) : ?>
								<div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
									<h3 class="font-semibold text-gray-900 mb-1"><?php echo esc_html( $item['title'] ?? '' ); ?></h3>
									<p class="text-sm text-gray-600"><?php echo esc_html( $item['desc'] ?? '' ); ?></p>
								</div>
							<?php endforeach; ?>
						</div>
					</section>

				<?php elseif ( 'quote' === $type ) : ?>
					<section class="bg-gray-50 rounded-xl p-8 border-l-4 border-orange-500">
						<blockquote class="text-lg italic text-gray-700 mb-2"><?php echo esc_html( $section['quote'] ?? '' ); ?></blockquote>
						<?php if ( ! empty( $section['source'] ) ) : ?>
							<p class="text-sm text-gray-500 font-medium">&mdash; <?php echo esc_html( $section['source'] ); ?></p>
						<?php endif; ?>
					</section>

				<?php elseif ( 'checklist' === $type ) : ?>
					<section>
						<?php if ( ! empty( $section['heading'] ) ) : ?>
							<h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4"><?php echo esc_html( $section['heading'] ); ?></h2>
						<?php endif; ?>
						<ul class="space-y-2">
							<?php foreach ( $section['items'] ?? array() as $item ) : ?>
								<li class="flex items-start gap-2">
									<span class="text-orange-500 mt-1">&#10003;</span>
									<span class="text-gray-700"><?php echo esc_html( $item ); ?></span>
								</li>
							<?php endforeach; ?>
						</ul>
					</section>

				<?php elseif ( 'comparison' === $type ) : ?>
					<section>
						<?php if ( ! empty( $section['heading'] ) ) : ?>
							<h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6"><?php echo esc_html( $section['heading'] ); ?></h2>
						<?php endif; ?>
						<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
							<?php foreach ( array( 'col1', 'col2' ) as $col ) : ?>
								<?php if ( ! empty( $section[ $col ]['items'] ) ) : ?>
									<div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
										<h3 class="font-bold text-gray-900 mb-3"><?php echo esc_html( $section[ $col ]['heading'] ?? '' ); ?></h3>
										<ul class="space-y-2">
											<?php foreach ( $section[ $col ]['items'] as $item ) : ?>
												<li class="text-sm text-gray-700"><?php echo esc_html( $item ); ?></li>
											<?php endforeach; ?>
										</ul>
									</div>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
					</section>

				<?php elseif ( 'testimonials' === $type ) : ?>
					<section>
						<?php if ( ! empty( $section['heading'] ) ) : ?>
							<h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6"><?php echo esc_html( $section['heading'] ); ?></h2>
						<?php endif; ?>
						<div class="space-y-4">
							<?php foreach ( $section['items'] ?? array() as $item ) : ?>
								<div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
									<p class="text-gray-700 italic mb-3">"<?php echo esc_html( $item['quote'] ?? '' ); ?>"</p>
									<p class="font-semibold text-gray-900"><?php echo esc_html( $item['name'] ?? '' ); ?></p>
									<?php if ( ! empty( $item['role'] ) ) : ?>
										<p class="text-sm text-gray-500"><?php echo esc_html( $item['role'] ); ?></p>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>
						</div>
					</section>

				<?php elseif ( 'notice' === $type ) : ?>
					<section class="bg-orange-50 rounded-xl p-6 border border-orange-200">
						<?php if ( ! empty( $section['heading'] ) ) : ?>
							<h3 class="font-bold text-orange-800 mb-1"><?php echo esc_html( $section['heading'] ); ?></h3>
						<?php endif; ?>
						<p class="text-sm text-orange-700"><?php echo esc_html( $section['content'] ?? '' ); ?></p>
					</section>

				<?php elseif ( 'cta' === $type ) : ?>
					<section class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-8 text-center">
						<h2 class="text-2xl font-bold text-white mb-2"><?php echo esc_html( $section['heading'] ?? '' ); ?></h2>
						<p class="text-white/90 mb-6 max-w-2xl mx-auto"><?php echo esc_html( $section['description'] ?? '' ); ?></p>
						<a href="<?php echo esc_url( $section['button_url'] ?? '#' ); ?>" class="inline-block bg-white text-orange-600 font-bold px-8 py-3 rounded-lg hover:bg-orange-50 transition"><?php echo esc_html( $section['button_text'] ?? 'Donate Now' ); ?></a>
					</section>

				<?php elseif ( 'faq' === $type ) : ?>
					<section>
						<?php if ( ! empty( $section['heading'] ) ) : ?>
							<h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6"><?php echo esc_html( $section['heading'] ); ?></h2>
						<?php endif; ?>
						<div class="space-y-4">
							<?php foreach ( $section['items'] ?? array() as $item ) : ?>
								<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
									<p class="font-semibold text-gray-900 mb-1"><?php echo esc_html( $item['q'] ?? '' ); ?></p>
									<p class="text-sm text-gray-700"><?php echo esc_html( $item['a'] ?? '' ); ?></p>
								</div>
							<?php endforeach; ?>
						</div>
					</section>

				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>

		<?php daan_sidebar_page_end(); ?>

	<?php else : ?>

		<!-- Fallback: Standard WordPress Content -->
		<div style="max-width:1280px;margin:0 auto;padding:48px 16px;">
			<div style="display:flex;flex-wrap:wrap;gap:32px;">
				<div style="flex:2;min-width:0;">
					<?php
					while ( have_posts() ) :
						the_post();
						the_content();
					endwhile;
					?>
				</div>
				<aside style="flex:1;min-width:280px;">
					<?php get_template_part( 'template-parts/donation-sidebar' ); ?>
				</aside>
			</div>
		</div>

	<?php endif; ?>
<?php
get_footer();
