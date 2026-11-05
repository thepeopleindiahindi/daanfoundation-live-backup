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

// The same upper limit as the /donate/ form.
add_action(
	'woocommerce_after_checkout_validation',
	function ( $data, $errors ) {
		if ( WC()->cart && (float) WC()->cart->get_total( 'edit' ) > DAAN_MAX_DONATION ) {
			$errors->add( 'daan_max_donation', daan_max_donation_message() );
		}
		foreach ( WC()->cart ? WC()->cart->get_cart() : array() as $item ) {
			if ( 'donation' === $item['data']->get_type() && (float) $item['data']->get_price( 'edit' ) < 1 ) {
				$errors->add( 'daan_min_donation', daan_donation_amount_message() );
				break;
			}
		}
	},
	10,
	2
);

/** A typed donation amount is a number from Rs 1 up to the limit. */
function daan_donation_amount_ok( $value ) {
	return is_numeric( $value ) && (float) $value >= 1 && (float) $value <= DAAN_MAX_DONATION;
}

function daan_donation_amount_message() {
	return 'Please enter an amount of at least ₹1. ' . daan_max_donation_message();
}

// Amount box on donation products: whole rupees from 1 up to the limit, in the browser and on the server.
add_filter(
	'get_post_metadata',
	function ( $value, $object_id, $meta_key ) {
		return '_donation_amount_increment' === $meta_key ? array( 1 ) : $value;
	},
	10,
	3
);
add_action( 'woocommerce_before_add_to_cart_button', 'ob_start', 9, 0 );
add_action(
	'woocommerce_before_add_to_cart_button',
	function () {
		echo str_replace( 'min="0"', 'min="1" max="' . (int) DAAN_MAX_DONATION . '"', (string) ob_get_clean() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	},
	11,
	0
);
add_filter(
	'woocommerce_cart_item_price',
	function ( $price ) {
		return str_replace( 'min="0"', 'min="1" max="' . (int) DAAN_MAX_DONATION . '"', $price );
	},
	20
);
add_filter(
	'woocommerce_add_to_cart_validation',
	function ( $passed, $product_id ) {
		$product = wc_get_product( $product_id );
		// phpcs:ignore WordPress.Security.NonceVerification.Missing -- only read to refuse a bad amount.
		if ( $product && 'donation' === $product->get_type() && isset( $_POST['donation_amount'] ) && ! daan_donation_amount_ok( wp_unslash( $_POST['donation_amount'] ) ) ) {
			wc_add_notice( daan_donation_amount_message(), 'error' );
			return false;
		}
		return $passed;
	},
	10,
	2
);
add_filter(
	'woocommerce_update_cart_action_cart_updated',
	function ( $updated ) {
		foreach ( WC()->cart->get_cart() as $key => $item ) {
			$field = 'donation_amount_' . $key;
			// phpcs:ignore WordPress.Security.NonceVerification.Missing -- WooCommerce checked the cart nonce.
			if ( isset( $_POST[ $field ] ) && ! daan_donation_amount_ok( wp_unslash( $_POST[ $field ] ) ) ) {
				unset( $_POST[ $field ] );
				wc_add_notice( daan_donation_amount_message(), 'error' );
			}
		}
		return $updated;
	},
	1
);

// An account e-mail with no name greets the donor.
add_filter(
	'woocommerce_mail_content',
	function ( $content ) {
		return str_replace( 'Dear ,', 'Dear Donor,', $content );
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
