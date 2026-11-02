<?php
/**
 * Plugin Name: Daan Order Cutoff
 * Description: The one place for the order cutoff. Digest, watcher, automation and the Export Customers default only look at orders created from this moment on.
 */
defined( 'ABSPATH' ) || exit;

const DAAN_ORDER_CUTOFF = '2026-11-01 00:00:00 +05:30';

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
