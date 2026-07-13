<?php
/**
 * Search results template
 */
get_header();
?>
    <header class="search-header">
        <h1><?php printf( __( 'Search Results for: %s', 'daan-custom' ), get_search_query() ); ?></h1>
    </header>

<?php if ( have_posts() ) : ?>
    <div class="search-grid">
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'search-card' ); ?>>
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <div class="entry-summary"><?php the_excerpt(); ?></div>
            </article>
        <?php endwhile; ?>
    </div>
    <?php the_posts_pagination(); ?>
<?php else : ?>
    <p><?php esc_html_e( 'No results found.', 'daan-custom' ); ?></p>
<?php endif;

get_footer();
