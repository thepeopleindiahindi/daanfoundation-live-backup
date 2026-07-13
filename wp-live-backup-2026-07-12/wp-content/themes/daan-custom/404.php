<?php
/**
 * 404 template
 */
get_header();
?>
<section class="error-404">
    <h1>404</h1>
    <p><?php esc_html_e( 'Page not found.', 'daan-custom' ); ?></p>
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
        <?php esc_html_e( 'Back to Home', 'daan-custom' ); ?>
    </a>
</section>
<?php
get_footer();
