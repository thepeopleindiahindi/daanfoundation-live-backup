<?php
/**
 * Plugin Name: Daan Order Cutoff
 * Description: The one place for the order cutoff. Digest, watcher, automation and the Export Customers default only look at orders created from this moment on.
 */
defined( 'ABSPATH' ) || exit;

const DAAN_ORDER_CUTOFF = '2026-11-01 00:00:00 +05:30';
const DAAN_MAX_DONATION = 1000000; // Largest single donation in rupees, on /donate/ and checkout.

function daan_order_cutoff() {
	return (int) apply_filters( 'daan_order_cutoff', strtotime( DAAN_ORDER_CUTOFF ) );
}

/** Value for the date_created argument of wc_get_orders(). */
function daan_order_cutoff_range() {
	return daan_order_cutoff() . '...' . time();
}

function daan_order_after_cutoff( $order ) {
	$created = $order->get_date_created();
	return $created && $created->getTimestamp() >= daan_order_cutoff();
}

function daan_max_donation_message() {
	$rupees = preg_replace( '/(\d)(?=(\d\d)+\d$)/', '$1,', (string) DAAN_MAX_DONATION );
	return 'The largest donation we accept online is ₹' . $rupees . '. Please contact us for a larger amount.';
}
