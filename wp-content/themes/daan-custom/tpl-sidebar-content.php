<?php
/**
 * Template Name: Default with Sidebar
 *
 * Generic template for sidebar pages. Falls through to Elementor if no
 * structured data is found for the current slug.
 */
get_header();

$page_slug     = get_post_field( 'post_name', get_the_ID() );
$parent_id     = wp_get_post_parent_id( get_the_ID() );
$parent_slug   = $parent_id ? get_post_field( 'post_name', $parent_id ) : '';
require_once get_template_directory() . '/inc/page-content.php';
$page_data = daan_get_page_data( $page_slug );
?>
	<?php if ( $page_data ) : ?>

		<?php if ( 'our-work' === $parent_slug ) : ?>
			<!-- Breadcrumb: Our Work subpage back to hub (I6) -->
			<div style="background:#F8FAFC;border-bottom:1px solid #E2E8F0;">
				<div style="max-width:1280px;margin:0 auto;padding:12px 16px;">
					<nav style="display:flex;align-items:center;gap:8px;font-size:0.875rem;color:#64748B;flex-wrap:wrap;">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:#64748B;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#EA580C'" onmouseout="this.style.color='#64748B'">Home</a>
						<span>/</span>
						<a href="<?php echo esc_url( home_url( '/our-work' ) ); ?>" style="color:#64748B;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#EA580C'" onmouseout="this.style.color='#64748B'">Our Work</a>
						<span>/</span>
						<span style="color:#111827;font-weight:600;"><?php echo esc_html( $page_data['title'] ?? '' ); ?></span>
					</nav>
				</div>
			</div>
		<?php endif; ?>

		<?php
		get_template_part( 'template-parts/hero-banner', null, array(
			'title'         => $page_data['title'] ?? '',
			'subtitle'      => $page_data['subtitle'] ?? '',
			'description'   => $page_data['hero_description'] ?? '',
			'gradient'      => $page_data['gradient'] ?? 'from-orange-600 to-orange-700',
			'image'         => $page_data['image'] ?? '',
			'button_text'   => $page_data['button_text'] ?? '',
			'button_url'    => $page_data['button_url'] ?? '',
			'default_cause' => $page_data['default_cause'] ?? 'where-needed',
		) );

		daan_sidebar_page_start( $page_data['default_cause'] ?? 'where-needed' ); ?>

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

				<?php elseif ( 'linkgrid' === $type ) : ?>
					<section>
						<?php if ( ! empty( $section['heading'] ) ) : ?>
							<h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6"><?php echo esc_html( $section['heading'] ); ?></h2>
						<?php endif; ?>
						<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
							<?php foreach ( $section['items'] ?? array() as $item ) : ?>
								<a href="<?php echo esc_url( home_url( $item['url'] ?? '#' ) ); ?>" class="block bg-white rounded-xl shadow-md p-6 border border-gray-100 hover:shadow-lg hover:border-orange-200 transition">
									<h3 class="font-semibold text-gray-900 mb-1"><?php echo esc_html( $item['title'] ?? '' ); ?></h3>
									<p class="text-sm text-gray-600"><?php echo esc_html( $item['desc'] ?? '' ); ?></p>
								</a>
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
		<?php if ( have_posts() ) : the_post(); ?>
			<div style="max-width:1280px;margin:0 auto;padding:48px 16px;">
				<h1 style="font-size:2.25rem;font-weight:800;color:#111827;line-height:1.15;margin:0 0 1.5rem;"><?php the_title(); ?></h1>
				<div class="sidebar-fallback-row">
					<div class="sidebar-fallback-content">
						<?php the_content(); ?>
					</div>
					<aside class="sidebar-fallback-aside">
						<?php get_template_part( 'template-parts/donation-sidebar' ); ?>
					</aside>
				</div>
			</div>
		<?php endif; ?>

	<?php endif; ?>
<?php
get_footer();
