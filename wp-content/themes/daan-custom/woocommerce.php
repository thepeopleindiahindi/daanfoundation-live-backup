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
    <?php
    // Same hero as the cause pages (template-parts/hero-banner.php), breadcrumb inside it (owner, 2026-11-23).
    $daan_hero = ( $daan_is_product && function_exists( 'daan_product_hero' ) ) ? daan_product_hero( get_queried_object_id() ) : array( 'subtitle' => '', 'image' => '/images/community-queue.jpg', 'alt' => '' );
    get_template_part( 'template-parts/hero-banner', null, array(
        'title'      => $daan_title,
        'subtitle'   => $daan_hero['subtitle'],
        'gradient'   => 'from-orange-600 to-orange-700',
        'image'      => $daan_hero['image'],
        'image_alt'  => $daan_hero['alt'] ? $daan_hero['alt'] : $daan_title,
        'priority'   => false, // fetchpriority is added to the first hero image automatically (as on cause pages)
        'breadcrumb' => array( array( 'Home', home_url( '/' ) ), array( 'Donate', home_url( '/donate/' ) ), array( $daan_title, '' ) ),
    ) );
    ?>

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
