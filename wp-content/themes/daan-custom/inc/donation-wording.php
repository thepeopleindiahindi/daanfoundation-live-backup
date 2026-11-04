<?php
/**
 * Donor-facing WooCommerce wording on product, cart and checkout pages: donation words, not shop words.
 * Only labels change; fields, totals and the payment flow do not. Rollback: remove the require in functions.php.
 *
 * @package Daan
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'woocommerce_product_single_add_to_cart_text', function () { return 'Donate'; } );
add_filter( 'woocommerce_product_add_to_cart_text', function () { return 'Donate'; } );
add_filter( 'woocommerce_order_button_text', function () { return 'Complete donation'; } );

add_filter(
	'gettext_woocommerce',
	function ( $translation, $text ) {
		static $map = array(
			'Billing details'                        => 'Donor details',
			'Billing &amp; Shipping'                 => 'Donor details',
			'Your order'                             => 'Your donation',
			'Product'                                => 'Cause',
			'Subtotal'                               => 'Amount',
			'Order notes'                            => 'Donation notes',
			'Notes about your order, e.g. special notes for delivery.' => 'Any note about your donation.',
			'Cart totals'                            => 'Donation total',
			'Proceed to checkout'                    => 'Continue to donate',
			'Update cart'                            => 'Update donation',
			'Your cart is currently empty.'          => 'You have not selected a donation yet.',
			'Return to shop'                         => 'Choose a cause',
			'Related products'                       => 'Other causes',
			'You may also like&hellip;'              => 'Other causes',
		);
		return ( ! is_admin() && isset( $map[ $text ] ) ) ? $map[ $text ] : $translation;
	},
	20,
	2
);

// "Choose a cause" goes to the donate page, not the empty shop page.
add_filter(
	'woocommerce_return_to_shop_redirect',
	function () {
		return home_url( '/donate/' );
	}
);

// One of each cause: no quantity box on product or cart; the value stays 1, and donating again keeps it at 1.
add_filter( 'woocommerce_is_sold_individually', '__return_true' );
add_filter( 'woocommerce_add_to_cart_sold_individually_found_in_cart', '__return_false' );
add_filter(
	'option_woocommerce_checkout_privacy_policy_text',
	function ( $text ) {
		return str_replace( 'process your order', 'process your donation', (string) $text );
	}
);
