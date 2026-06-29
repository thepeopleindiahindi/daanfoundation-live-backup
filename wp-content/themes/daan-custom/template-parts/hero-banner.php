<?php
/**
 * Hero Banner Template Part
 *
 * Accepts: $args['title'], $args['subtitle'], $args['gradient'], $args['image']
 */
$title    = $args['title'] ?? '';
$subtitle = $args['subtitle'] ?? '';
$gradient = $args['gradient'] ?? 'from-orange-600 to-orange-700';
$image    = $args['image'] ?? '';
?>
<section class="relative bg-gradient-to-br <?php echo esc_attr( $gradient ); ?> overflow-hidden">
	<?php if ( $image ) : ?>
		<div class="absolute inset-0">
			<img src="<?php echo esc_url( $image ); ?>" alt="" class="w-full h-full object-cover opacity-30" aria-hidden="true">
			<div class="absolute inset-0 bg-black/40"></div>
		</div>
	<?php endif; ?>
	<div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 md:py-16">
		<div class="max-w-3xl">
			<h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-4"><?php echo esc_html( $title ); ?></h1>
			<?php if ( $subtitle ) : ?>
				<p class="text-xl text-white/90 leading-relaxed max-w-2xl"><?php echo esc_html( $subtitle ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>
