<?php
/**
 * Main template — fallback for all views
 * Phase 2 will replace this with full section rendering.
 */
get_header();

while ( have_posts() ) :
    the_post();
    the_content();
endwhile;

get_footer();
