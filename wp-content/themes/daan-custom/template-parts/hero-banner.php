<?php
$title        = $args['title'] ?? '';
$subtitle     = $args['subtitle'] ?? '';
$description  = $args['description'] ?? '';
$gradient     = $args['gradient'] ?? 'from-orange-600 to-orange-700';
$image        = $args['image'] ?? '';
$button_text  = $args['button_text'] ?? '';
$button_url   = $args['button_url'] ?? '';
?>
<section class="relative bg-gradient-to-br <?php echo esc_attr( $gradient ); ?> overflow-hidden">
	<div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 md:py-16">
		<div class="flex flex-col md:flex-row items-center gap-8">
			<div class="flex-1 max-w-3xl">
				<h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-4"><?php echo esc_html( $title ); ?></h1>
				<?php if ( $subtitle ) : ?>
					<p class="text-xl md:text-2xl text-white/95 font-semibold mb-3"><?php echo esc_html( $subtitle ); ?></p>
				<?php endif; ?>
				<?php if ( $description ) : ?>
					<p class="text-base md:text-lg text-white/85 leading-relaxed mb-6"><?php echo esc_html( $description ); ?></p>
				<?php endif; ?>
				<?php if ( $button_text ) : ?>
					<a href="<?php echo esc_url( $button_url ? $button_url : '#' ); ?>" class="inline-flex items-center gap-2 bg-white text-orange-600 font-semibold px-6 py-3 rounded-full hover:bg-orange-50 transition">
						<?php echo esc_html( $button_text ); ?> &rarr;
					</a>
				<?php endif; ?>
			</div>
			<?php if ( $image ) : ?>
				<div class="flex-1 w-full md:max-w-md">
					<div class="rounded-2xl overflow-hidden shadow-lg">
						<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>" width="800" height="600" loading="lazy" class="w-full h-[260px] md:h-[320px] object-cover">
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
