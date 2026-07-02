<?php
/**
 * Daan Custom Theme Functions
 */

if ( ! defined( 'DAAN_THEME_VERSION' ) ) {
    define( 'DAAN_THEME_VERSION', '1.0.0' );
}

/**
 * Theme Setup
 */
add_action( 'after_setup_theme', 'daan_theme_setup' );
function daan_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );
    add_theme_support( 'custom-logo', [
        'height'      => 80,
        'width'       => 280,
        'flex-height' => true,
        'flex-width'  => true,
    ] );
    add_theme_support( 'align-wide' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'editor-styles' );
    add_theme_support( 'wp-block-styles' );

    register_nav_menus( [
        'primary' => __( 'Primary Menu', 'daan-custom' ),
        'footer'  => __( 'Footer Menu', 'daan-custom' ),
    ] );
}

/**
 * Enqueue Scripts & Styles
 */
add_action( 'wp_enqueue_scripts', 'daan_enqueue_assets' );
function daan_enqueue_assets() {
    // Styles
    wp_enqueue_style( 'daan-google-fonts', 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&display=swap', [], null );
    wp_enqueue_style( 'daan-tailwind', site_url( '/css/tailwind.min.css' ), [], filemtime( ABSPATH . 'css/tailwind.min.css' ) );
    $theme_css = file_exists( get_template_directory() . '/assets/css/theme.min.css' ) ? '/assets/css/theme.min.css' : '/assets/css/theme.css';
    wp_enqueue_style( 'daan-theme', get_template_directory_uri() . $theme_css, ['daan-tailwind'], filemtime( get_template_directory() . $theme_css ) );

    // Scripts
    wp_enqueue_script( 'daan-theme', get_template_directory_uri() . '/assets/js/theme.js', [], filemtime( get_template_directory() . '/assets/js/theme.js' ), true );
}

/**
 * Re-add version query string after plugins strip it (Rank Math etc.)
 */
add_filter( 'style_loader_tag', 'daan_cache_bust_style', 10, 4 );
function daan_cache_bust_style( $tag, $handle, $href, $media ) {
    if ( $handle === 'daan-theme' && strpos( $tag, '?ver=' ) === false ) {
        $mtime = filemtime( get_template_directory() . '/assets/css/theme.css' );
        $tag   = str_replace( "href='$href'", "href='{$href}?ver={$mtime}'", $tag );
    }
    return $tag;
}

/**
 * Auto-add width and height to images in content
 * Prevents Cumulative Layout Shift (CLS)
 */
function daan_add_image_dimensions( $content ) {
    if ( preg_match_all( '/<img[^>]+>/i', $content, $matches ) ) {
        foreach ( $matches[0] as $img_tag ) {
            if ( preg_match( '/width\s*=|height\s*=/i', $img_tag ) ) {
                continue;
            }

            if ( preg_match( '/src=[\'"]([^\'"]+)[\'"]/i', $img_tag, $src_match ) ) {
                $image_url = $src_match[1];
                $image_size = @getimagesize( $image_url );

                if ( $image_size ) {
                    $width  = $image_size[0];
                    $height = $image_size[1];

                    $new_img_tag = str_replace(
                        '/>',
                        " width=\"$width\" height=\"$height\" loading=\"lazy\" />",
                        $img_tag
                    );
                    $new_img_tag = str_replace(
                        '>',
                        " width=\"$width\" height=\"$height\" loading=\"lazy\" >",
                        $new_img_tag
                    );

                    $content = str_replace( $img_tag, $new_img_tag, $content );
                }
            }
        }
    }

    return $content;
}
add_filter( 'the_content', 'daan_add_image_dimensions', 10 );

/**
 * Required Files
 */
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/blocks.php';
require_once get_template_directory() . '/inc/page-content.php';
require_once get_template_directory() . '/inc/smtp-config.php';
require_once get_template_directory() . '/inc/snippets.php';
require_once get_template_directory() . '/inc/security.php';
