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
 * Donation Email Customization
 * Orders placed via daan_place_order() land in 'on-hold' status, so the
 * donor-facing WooCommerce email is customer_on_hold_order (not
 * customer_processing_order). Admin notification is new_order.
 */
add_filter( 'woocommerce_email_heading_customer_on_hold_order', 'daan_donation_email_heading_donor', 10, 2 );
add_filter( 'woocommerce_email_subject_customer_on_hold_order', 'daan_donation_email_subject_donor', 10, 2 );
function daan_donation_email_heading_donor( $heading, $order ) {
    return $order ? sprintf( __( 'Donation Received: #%s', 'daan-custom' ), $order->get_order_number() ) : $heading;
}
function daan_donation_email_subject_donor( $subject, $order ) {
    return $order ? sprintf( __( 'Donation Received: #%s', 'daan-custom' ), $order->get_order_number() ) : $subject;
}

add_filter( 'woocommerce_email_heading_new_order', 'daan_donation_email_heading_admin', 10, 2 );
add_filter( 'woocommerce_email_subject_new_order', 'daan_donation_email_subject_admin', 10, 2 );
function daan_donation_email_heading_admin( $heading, $order ) {
    return $order ? sprintf( __( 'New Donation Received: #%s', 'daan-custom' ), $order->get_order_number() ) : $heading;
}
function daan_donation_email_subject_admin( $subject, $order ) {
    return $order ? sprintf( __( 'New Donation Received: #%s', 'daan-custom' ), $order->get_order_number() ) : $subject;
}

/**
 * Admin email footer note — replaces WooCommerce's default
 * "Congratulations on the sale." (commercial tone, not charity-appropriate).
 */
add_filter( 'woocommerce_email_additional_content_new_order', 'daan_donation_email_footer_admin', 10, 2 );
function daan_donation_email_footer_admin( $content, $order ) {
    return __( 'Thank you for supporting Daan Foundation.', 'daan-custom' );
}

/**
 * Remove the 'cart_subtotal' row from the order totals footer. Donation
 * orders are fee-only (no real product line items), so this row always
 * renders as a meaningless "₹0.00" (WC adds it whenever
 * get_subtotal_to_display() returns any non-empty string, and "₹0.00"
 * counts). Applies everywhere get_order_item_totals() is used — front-end
 * order-details and emails alike — since it's equally meaningless in both.
 *
 * NOTE: this filter also carries 'fee' rows (the donation's own totals-
 * footer line, e.g. "Donation — Cause: ₹500.00"). Do NOT strip those here —
 * emails rely on that row as their only display of the donation (the email
 * item-table intentionally excludes fees). The front-end equivalent is
 * handled locally in woocommerce/order/order-details.php instead, since
 * that page shows the fee as its own table row already and needs the
 * footer duplicate suppressed — but only there, not in emails.
 */
add_filter( 'woocommerce_get_order_item_totals', 'daan_donation_remove_subtotal_row', 10, 1 );
function daan_donation_remove_subtotal_row( $total_rows ) {
    unset( $total_rows['cart_subtotal'] );
    return $total_rows;
}

/**
 * Include 'fee' items in the front-end order-details table (Order Received /
 * My Account order view). Donations are added as a WC_Order_Item_Fee, and
 * this table only shows 'line_item' (product) types by default, so without
 * this the donation never appears as a row — only in the totals footer.
 * See woocommerce/order/order-details.php and order-details-item.php theme
 * overrides for the corresponding null-safety/display fixes this requires.
 */
add_filter( 'woocommerce_purchase_order_item_types', 'daan_include_fee_in_order_details' );
function daan_include_fee_in_order_details( $types ) {
    $types   = (array) $types;
    $types[] = 'fee';
    return array_unique( $types );
}

/**
 * Required Files
 */
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/blocks.php';
require_once get_template_directory() . '/inc/page-content.php';
require_once get_template_directory() . '/inc/smtp-config.php';
require_once get_template_directory() . '/inc/snippets.php';
require_once get_template_directory() . '/inc/security.php';
require_once get_template_directory() . '/inc/seo-fixes.php';

add_filter( 'woocommerce_checkout_fields', 'daan_make_phone_mandatory' );
function daan_make_phone_mandatory( $fields ) {
    $fields['billing']['billing_phone']['required'] = true;
    $fields['billing']['billing_phone']['label'] = 'Mobile Number';
    return $fields;
}
