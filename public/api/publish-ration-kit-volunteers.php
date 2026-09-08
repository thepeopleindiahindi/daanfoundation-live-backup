<?php
/**
 * One-time authenticated publisher for the ration-kit volunteer article.
 * Uses the existing legacy admin session, publishes into WordPress, deploys
 * the matching SEO filters, reports the result, and removes itself.
 */
require_once __DIR__ . '/admin-config.php';
requireAdminAuth();

if ( 'POST' !== $_SERVER['REQUEST_METHOD'] ) {
	http_response_code( 405 );
	header( 'Allow: POST' );
	exit;
}

require_once dirname( __DIR__ ) . '/wp-load.php';
header( 'Content-Type: application/json; charset=utf-8' );

$raw_base = 'https://raw.githubusercontent.com/thepeopleindiahindi/daanfoundation-live-backup/main/';
$payload  = json_decode( file_get_contents( $raw_base . 'scripts/ration-kit-distribution-volunteers.json?ts=' . time() ), true );

if ( ! is_array( $payload ) || empty( $payload['slug'] ) || empty( $payload['content'] ) ) {
	http_response_code( 500 );
	echo wp_json_encode( array( 'success' => false, 'message' => 'Article payload could not be loaded.' ) );
	exit;
}

$existing = get_page_by_path( $payload['slug'], OBJECT, 'post' );
$postarr  = array(
	'ID'           => $existing ? $existing->ID : 0,
	'post_type'    => 'post',
	'post_status'  => 'publish',
	'post_title'   => $payload['title'],
	'post_name'    => $payload['slug'],
	'post_excerpt' => $payload['excerpt'],
	'post_content' => $payload['content'],
	'post_author'  => 1,
);
$post_id  = wp_insert_post( wp_slash( $postarr ), true );

if ( is_wp_error( $post_id ) ) {
	http_response_code( 500 );
	echo wp_json_encode( array( 'success' => false, 'message' => $post_id->get_error_message() ) );
	exit;
}

wp_set_post_categories( $post_id, array( 1 ), false );
wp_set_post_terms( $post_id, $payload['tags'], 'post_tag', false );

if ( ! empty( $payload['featured_media'] ) && 'attachment' === get_post_type( (int) $payload['featured_media'] ) ) {
	set_post_thumbnail( $post_id, (int) $payload['featured_media'] );
}

update_post_meta( $post_id, 'rank_math_title', $payload['seo_title'] );
update_post_meta( $post_id, 'rank_math_description', $payload['seo_description'] );
update_post_meta( $post_id, 'rank_math_focus_keyword', $payload['focus_keyword'] );

$seo_source = file_get_contents( $raw_base . 'wp-content/themes/daan-custom/inc/seo-fixes.php?ts=' . time() );
$seo_target = get_theme_file_path( 'inc/seo-fixes.php' );
$seo_ok     = false;
if ( false !== $seo_source && false !== strpos( $seo_source, 'ration-kit-distribution-volunteers' ) ) {
	$seo_ok = false !== file_put_contents( $seo_target, $seo_source, LOCK_EX );
}

clean_post_cache( $post_id );
$result = array(
	'success'        => true,
	'post_id'        => $post_id,
	'updated'        => (bool) $existing,
	'status'         => get_post_status( $post_id ),
	'url'            => get_permalink( $post_id ),
	'category_ids'   => wp_get_post_categories( $post_id ),
	'tags'           => wp_get_post_terms( $post_id, 'post_tag', array( 'fields' => 'names' ) ),
	'featured_media' => (int) get_post_thumbnail_id( $post_id ),
	'seo_deployed'   => $seo_ok,
);

@unlink( __FILE__ );
echo wp_json_encode( $result );
