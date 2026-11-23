<?php
/**
 * WooCommerce pages (donation products) — owner, 2026-11-23.
 * Breadcrumb Home / Donate / <product>; no date, author or "News";
 * product form + description on the left, donation widget + relevant links on the right.
 * Only Tailwind classes already used in single.php (the theme CSS is pre-built).
 */
get_header();

$daan_is_product = is_singular( 'product' );
$daan_title      = $daan_is_product ? get_the_title( get_queried_object_id() ) : woocommerce_page_title( false );
if ( $daan_is_product && function_exists( 'daan_product_cause' ) ) {
	$GLOBALS['daan_sidebar_cause'] = daan_product_cause( get_queried_object_id() );
}
?>
    <!-- Breadcrumbs -->
    <div class="bg-slate-50 border-b border-slate-200">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-3">
        <nav class="flex items-center gap-2 text-sm text-slate-500" aria-label="Breadcrumb">
          <a href="/" class="hover:text-orange-600 transition-colors">Home</a>
          <span>/</span>
          <a href="/donate/" class="hover:text-orange-600 transition-colors">Donate</a>
          <span>/</span>
          <span class="text-slate-900 font-medium"><?php echo esc_html( $daan_title ); ?></span>
        </nav>
      </div>
    </div>

    <!-- Hero -->
    <section class="relative bg-gradient-to-br from-orange-600 to-orange-700">
      <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        <div class="max-w-3xl">
          <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-4"><?php echo esc_html( $daan_title ); ?></h1>
        </div>
      </div>
    </section>

    <!-- Content + Sidebar -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 md:py-12">
      <div class="lg:grid lg:grid-cols-3 lg:gap-10">
        <div class="lg:col-span-2 daan-product-main">
          <?php woocommerce_content(); ?>
        </div>

        <aside class="lg:col-span-1 mt-8 lg:mt-0">
          <div class="lg:sticky lg:top-24 space-y-6">
            <?php get_template_part( 'template-parts/donation-sidebar' ); ?>
            <?php
            $daan_links = ( $daan_is_product && function_exists( 'daan_product_links' ) ) ? daan_product_links( get_queried_object_id() ) : array();
            if ( $daan_links ) : ?>
              <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-5">
                <h3 class="font-bold text-slate-900 mb-4">Learn more</h3>
                <?php foreach ( $daan_links as $daan_url => $daan_text ) : ?>
                  <a href="<?php echo esc_url( home_url( $daan_url ) ); ?>" class="flex gap-3 py-2 group">
                    <span class="text-sm font-semibold text-slate-900 group-hover:text-orange-600 transition-colors"><?php echo esc_html( $daan_text ); ?> →</span>
                  </a>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </aside>
      </div>
    </div>
<?php
get_footer();
