<?php
/**
 * Donation mail reliability: short SMTP timeout, mails of a donation request sent after the response,
 * retry queue for order mails (5 min, 30 min, 2 hours), "mail sent" flag, final note + alert.
 * Sender, subject and content are replayed exactly as WooCommerce built them.
 */

defined( 'ABSPATH' ) || exit;

const DAAN_MAIL_SENT_META   = '_daan_mail_sent';   // array: e-mail id => time really sent.
const DAAN_MAIL_QUEUE_META  = '_daan_mail_queue';  // array: e-mail id => mail waiting for a retry.
const DAAN_MAIL_FAILED_META = '_daan_mail_failed'; // array: e-mail id => time the last retry failed.
const DAAN_MAIL_GROUP       = 'daan-mail';

/** Order mails that get a retry, with the status the order must still have (empty = any). */
function daan_mail_tracked() {
	return array(
		'customer_on_hold_order'  => array( 'label' => 'donor on-hold', 'status' => 'on-hold' ),
		'new_order'               => array( 'label' => 'admin new donation', 'status' => '' ),
		'customer_completed_order' => array( 'label' => 'donor completed + receipt', 'status' => 'completed' ),
	);
}

function daan_mail_retry_delays() {
	return array( 5 * MINUTE_IN_SECONDS, 30 * MINUTE_IN_SECONDS, 2 * HOUR_IN_SECONDS );
}

// A stuck mail server gives up after 15 seconds, not after PHP's limit.
add_action(
	'phpmailer_init',
	function ( $phpmailer ) {
		$phpmailer->Timeout = 15;
	},
	9999
);

$GLOBALS['daan_mail'] = array(
	// phpcs:ignore WordPress.Security.NonceVerification -- only decides when mail goes out.
	'defer'   => ( wp_doing_ajax() && 'daan_place_order' === ( $_POST['action'] ?? '' ) ) || 'checkout' === ( $_GET['wc-ajax'] ?? '' ),
	'sending' => false,
	'last'    => null,
	'queue'   => array(),
);

// Keeps each mail as built, with what WooCommerce sets only while it calls wp_mail. On a donation request the mail is held.
add_filter(
	'pre_wp_mail',
	function ( $result, $atts ) {
		if ( $GLOBALS['daan_mail']['sending'] ) {
			return $result;
		}
		$GLOBALS['daan_mail']['last'] = array(
			'atts' => $atts,
			'from' => apply_filters( 'wp_mail_from', get_option( 'admin_email' ) ),
			'name' => apply_filters( 'wp_mail_from_name', 'WordPress' ),
			'type' => apply_filters( 'wp_mail_content_type', 'text/plain' ),
		);
		if ( ! $GLOBALS['daan_mail']['defer'] ) {
			return $result;
		}
		$GLOBALS['daan_mail']['queue'][] = $GLOBALS['daan_mail']['last'];
		return true;
	},
	1,
	2
);

function daan_mail_replay( $mail ) {
	$set = array(
		'wp_mail_from'         => function () use ( $mail ) { return $mail['from']; },
		'wp_mail_from_name'    => function () use ( $mail ) { return $mail['name']; },
		'wp_mail_content_type' => function () use ( $mail ) { return $mail['type']; },
	);
	foreach ( $set as $hook => $fn ) {
		add_filter( $hook, $fn, 99999 );
	}
	$GLOBALS['daan_mail']['sending'] = true;
	$a  = $mail['atts'];
	$ok = wp_mail( $a['to'], $a['subject'], $a['message'], $a['headers'], $a['attachments'] );
	$GLOBALS['daan_mail']['sending'] = false;
	foreach ( $set as $hook => $fn ) {
		remove_filter( $hook, $fn, 99999 );
	}
	return (bool) $ok;
}

function daan_mail_mark_sent( $order_id, $email_id ) {
	$order = wc_get_order( $order_id );
	if ( ! $order ) {
		return;
	}
	$sent              = (array) $order->get_meta( DAAN_MAIL_SENT_META );
	$sent[ $email_id ] = time();
	$order->update_meta_data( DAAN_MAIL_SENT_META, array_filter( $sent ) );
	$order->save_meta_data();
}

function daan_mail_enqueue( $order_id, $email_id, $mail ) {
	$order = wc_get_order( $order_id );
	if ( ! $order ) {
		return;
	}
	$queue              = (array) $order->get_meta( DAAN_MAIL_QUEUE_META );
	$queue[ $email_id ] = array( 'mail' => $mail, 'tries' => 0, 'at' => time() );
	$order->update_meta_data( DAAN_MAIL_QUEUE_META, array_filter( $queue ) );
	$order->save_meta_data();
	$order->add_order_note( 'Mail failed (' . daan_mail_tracked()[ $email_id ]['label'] . '), it will be tried again.', false );
	as_schedule_single_action( time() + daan_mail_retry_delays()[0], 'daan_mail_retry', array( (int) $order_id, $email_id ), DAAN_MAIL_GROUP );
}

// Which order the mail just built belongs to, and whether it really went.
add_action(
	'woocommerce_email_sent',
	function ( $ok, $email_id, $email ) {
		if ( ! isset( daan_mail_tracked()[ $email_id ] ) || ! ( $email->object instanceof WC_Order ) ) {
			return;
		}
		$order_id = $email->object->get_id();
		if ( $GLOBALS['daan_mail']['defer'] ) {
			$last = array_key_last( $GLOBALS['daan_mail']['queue'] );
			if ( null !== $last ) {
				$GLOBALS['daan_mail']['queue'][ $last ]['ctx'] = array( $order_id, $email_id );
			}
		} elseif ( $ok ) {
			daan_mail_mark_sent( $order_id, $email_id );
		} elseif ( $GLOBALS['daan_mail']['last'] ) {
			daan_mail_enqueue( $order_id, $email_id, $GLOBALS['daan_mail']['last'] );
		}
	},
	10,
	3
);

// Answer the donor first. After WooCommerce saved the session (priority 20).
add_action(
	'shutdown',
	function () {
		$queue = $GLOBALS['daan_mail']['queue'];
		if ( ! $queue ) {
			return;
		}
		ignore_user_abort( true );
		if ( function_exists( 'litespeed_finish_request' ) ) {
			litespeed_finish_request();
		} elseif ( function_exists( 'fastcgi_finish_request' ) ) {
			fastcgi_finish_request();
		}
		foreach ( $queue as $mail ) {
			$ctx = $mail['ctx'] ?? null;
			unset( $mail['ctx'] );
			$ok = daan_mail_replay( $mail );
			if ( $ctx ) {
				if ( $ok ) {
					daan_mail_mark_sent( $ctx[0], $ctx[1] );
				} else {
					daan_mail_enqueue( $ctx[0], $ctx[1], $mail );
				}
			}
		}
	},
	30
);

// One retry of one order mail.
add_action(
	'daan_mail_retry',
	function ( $order_id, $email_id ) {
		$order   = wc_get_order( $order_id );
		$tracked = daan_mail_tracked()[ $email_id ] ?? null;
		if ( ! $order || ! $tracked ) {
			return;
		}
		$queue = (array) $order->get_meta( DAAN_MAIL_QUEUE_META );
		$entry = $queue[ $email_id ] ?? null;
		if ( ! $entry ) {
			return; // Nothing waiting: never a second copy.
		}
		$sent = (array) $order->get_meta( DAAN_MAIL_SENT_META );
		$done = ! empty( $sent[ $email_id ] ) && $sent[ $email_id ] >= $entry['at'];
		$old  = '' !== $tracked['status'] && ! $order->has_status( $tracked['status'] );
		if ( $done || $old ) {
			unset( $queue[ $email_id ] );
			$order->update_meta_data( DAAN_MAIL_QUEUE_META, array_filter( $queue ) );
			$order->save_meta_data();
			if ( $old && ! $done ) {
				$order->add_order_note( 'Failed mail (' . $tracked['label'] . ') not sent again: the donation status has changed.', false );
			}
			return;
		}
		++$entry['tries'];
		if ( daan_mail_replay( $entry['mail'] ) ) {
			unset( $queue[ $email_id ] );
			$order->update_meta_data( DAAN_MAIL_QUEUE_META, array_filter( $queue ) );
			$order->save_meta_data();
			daan_mail_mark_sent( $order_id, $email_id );
			$order = wc_get_order( $order_id );
			$failed = (array) $order->get_meta( DAAN_MAIL_FAILED_META );
			unset( $failed[ $email_id ] );
			$order->update_meta_data( DAAN_MAIL_FAILED_META, array_filter( $failed ) );
			$order->save_meta_data();
			$order->add_order_note( 'Mail sent on retry ' . $entry['tries'] . ' (' . $tracked['label'] . ').', false );
			return;
		}
		$delays = daan_mail_retry_delays();
		if ( $entry['tries'] < count( $delays ) ) {
			$queue[ $email_id ] = $entry;
			$order->update_meta_data( DAAN_MAIL_QUEUE_META, $queue );
			$order->save_meta_data();
			as_schedule_single_action( time() + $delays[ $entry['tries'] ], 'daan_mail_retry', array( (int) $order_id, $email_id ), DAAN_MAIL_GROUP );
			return;
		}
		// Third retry failed: stop, tell the Foundation, show it in the digest.
		unset( $queue[ $email_id ] );
		$failed              = (array) $order->get_meta( DAAN_MAIL_FAILED_META );
		$failed[ $email_id ] = time();
		$order->update_meta_data( DAAN_MAIL_QUEUE_META, array_filter( $queue ) );
		$order->update_meta_data( DAAN_MAIL_FAILED_META, array_filter( $failed ) );
		$order->save_meta_data();
		$order->add_order_note( 'MAIL FAILED after 3 retries (' . $tracked['label'] . '). Please contact the donor or send it by hand.', false );
		wp_mail(
			DAAN_NOTIFICATION_EMAIL,
			'Mail failed – donation #' . $order->get_order_number(),
			'<p>The ' . esc_html( $tracked['label'] ) . ' mail of donation <a href="' . esc_url( $order->get_edit_order_url() ) . '">#' . esc_html( $order->get_order_number() ) . '</a> failed after 3 retries.</p>',
			array( 'Content-Type: text/html; charset=UTF-8' )
		);
	},
	10,
	2
);

/** Digest lines for mails that failed after all retries, last 14 days. */
function daan_mail_failed_digest_html() {
	$out = '';
	foreach ( wc_get_orders( array( 'type' => 'shop_order', 'limit' => 50, 'status' => array_keys( wc_get_order_statuses() ), 'date_created' => '>' . ( time() - 14 * DAY_IN_SECONDS ), 'meta_key' => DAAN_MAIL_FAILED_META, 'meta_compare' => 'EXISTS' ) ) as $order ) { // phpcs:ignore WordPress.DB.SlowDBQuery
		foreach ( array_keys( array_filter( (array) $order->get_meta( DAAN_MAIL_FAILED_META ) ) ) as $email_id ) {
			$out .= '<p style="color:#B3261E;font-weight:700;margin:4px 0;">Mail failed: <a href="' . esc_url( $order->get_edit_order_url() ) . '" style="color:#B3261E;">#' . esc_html( $order->get_order_number() ) . '</a> · ' . esc_html( daan_mail_tracked()[ $email_id ]['label'] ?? $email_id ) . '</p>';
		}
	}
	return $out;
}

/** The digest did not go out: try again 5 min, 30 min, 2 hours later, then tell the Foundation. Counting stays in the digest itself. */
function daan_digest_send_result( $sent ) {
	$state = get_option( 'daan_digest_retry', array() );
	if ( $sent ) {
		delete_option( 'daan_digest_retry' );
		return;
	}
	$tries  = (int) ( $state['tries'] ?? 0 );
	$delays = daan_mail_retry_delays();
	if ( $tries < count( $delays ) ) {
		update_option( 'daan_digest_retry', array( 'tries' => $tries + 1 ), false );
		as_schedule_single_action( time() + $delays[ $tries ], 'daan_pending_digest', array(), DAAN_MAIL_GROUP );
		return;
	}
	delete_option( 'daan_digest_retry' );
	wp_mail( DAAN_NOTIFICATION_EMAIL, 'Mail failed – daily digest', '<p>The daily digest could not be sent after 3 retries.</p>', array( 'Content-Type: text/html; charset=UTF-8' ) );
}
