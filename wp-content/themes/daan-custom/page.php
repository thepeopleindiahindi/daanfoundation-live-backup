<?php
/**
 * Default page template
 */
get_header();

while ( have_posts() ) :
    the_post();
    ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="page-hero">
                <?php the_post_thumbnail( 'full', [ 'class' => 'hero-image' ] ); ?>
            </div>
        <?php endif; ?>

        <div class="page-content">
            <h1 class="page-title"><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </div>
    </article>
    <?php
endwhile;

get_footer();
