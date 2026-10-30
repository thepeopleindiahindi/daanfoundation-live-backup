<?php
/**
 * Plugin Name: UPI QR Payment (manual verification)
 * Description: "Pay via QR Code (UPI)" WooCommerce gateway for Daan Foundation. Shows the QR, amount, UPI ID (Copy) and instructions at checkout. Donations go ON HOLD until a human verifies the money. Admin "new order" email gets signed one-time buttons (Payment received / not received); on-hold UPQ donations are escalated after 7 days, every 4 days, never auto-cancelled. "Payment received" sets the donation to COMPLETED.
 * Version: 1.0.0-daan
 * Requires Plugins: woocommerce
 *
 * Based on docs/UNIVERSAL_UPI_QR_Payment_System_Handover.md. Daan changes:
 *  - no upi:// "Pay" button anywhere;
 *  - the thank-you page box and the customer e-mail block come from the theme (inc/payment-instructions.php),
 *    which merges this gateway's settings with the existing UTR form, pending page and daily digest;
 *  - "Payment received" -> Completed (the Completed e-mail carries the receipt link); no stock handling;
 *  - only orders paid with this gateway get buttons, the on-hold timestamp and watcher e-mails.
 *    Older on-hold orders (cheque / bacs / wc-upi / dew-wc-upi) are never touched;
 *  - customer-facing text says "donation"; no WhatsApp lines.
 *
 * Secrets: UPQ_LINK_SECRET (required for buttons) and UPQ_OWNER_CC (optional) in wp-config.php only.
 */

defined( 'ABSPATH' ) || exit;

define( 'UPQ_GATEWAY_ID', 'upq_manual_qr' );

/* =====================================================================
 * 1. Gateway
 * ================================================================== */

add_filter( 'woocommerce_payment_gateways', function ( $gateways ) {
	if ( class_exists( 'UPQ_Gateway' ) ) {
		$gateways[] = 'UPQ_Gateway';
	}
	return $gateways;
} );

add_action( 'plugins_loaded', function () {
	if ( ! class_exists( 'WC_Payment_Gateway' ) || class_exists( 'UPQ_Gateway' ) ) {
		return;
	}

	class UPQ_Gateway extends WC_Payment_Gateway {

		public function __construct() {
			$this->id                 = UPQ_GATEWAY_ID;
			$this->method_title       = 'Pay via QR Code (UPI)';
			$this->method_description = 'Manual UPI QR payment. The donation stays on hold until your team verifies the money in the UPI/bank app.';
			$this->has_fields         = false;
			$this->supports           = array( 'products' );

			$this->init_form_fields();
			$this->init_settings();

			$this->title       = $this->get_option( 'title' );
			$this->description = $this->get_option( 'description' );

			add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
		}

		public function init_form_fields() {
			$this->form_fields = array(
				'enabled'      => array( 'title' => 'Enable', 'type' => 'checkbox', 'label' => 'Enable Pay via QR Code (UPI)', 'default' => 'no' ),
				'title'        => array( 'title' => 'Title', 'type' => 'text', 'default' => 'Pay via QR Code (UPI)' ),
				'description'  => array( 'title' => 'Description', 'type' => 'textarea', 'default' => 'Scan the QR code with any UPI app, or pay to the UPI ID shown below.' ),
				'qr_url'       => array( 'title' => 'QR image URL', 'type' => 'text', 'description' => 'Media Library URL of the official QR image. The method stays hidden until this and the UPI ID are filled.', 'default' => '' ),
				'qr_alt'       => array( 'title' => 'QR image alt text', 'type' => 'text', 'default' => 'UPI QR code - Daan Foundation' ),
				'qr_width'     => array( 'title' => 'QR display width (px)', 'type' => 'number', 'default' => '180', 'custom_attributes' => array( 'min' => '120', 'max' => '420' ) ),
				'upi_id'       => array( 'title' => 'UPI ID (shown with a Copy button)', 'type' => 'text', 'description' => 'Must be the same address as inside the QR code.', 'default' => '' ),
				'payee_name'   => array( 'title' => 'Payee name shown by UPI apps (reference only)', 'type' => 'text', 'default' => '' ),
				'payee_note'   => array( 'title' => 'Payee-name note (shown under the UPI ID; empty = hidden)', 'type' => 'textarea', 'default' => '' ),
				'contact'      => array( 'title' => 'Contact phone (shown on the card)', 'type' => 'text', 'default' => '+91 88991 52910' ),
				'instructions' => array( 'title' => 'Instructions', 'type' => 'textarea', 'description' => 'Placeholder: {upi_id}.', 'default' => 'Scan the QR or pay to {upi_id}, enter the exact amount, then submit your UTR / transaction ID below. Your donation stays pending until our team verifies it.' ),
			);
		}

		/** Hidden at checkout until a QR image and a UPI ID are configured. */
		public function is_available() {
			return parent::is_available() && '' !== trim( (string) $this->get_option( 'qr_url' ) ) && '' !== trim( (string) $this->get_option( 'upi_id' ) );
		}

		public function payment_fields() {
			$amount = ( function_exists( 'WC' ) && WC()->cart ) ? WC()->cart->get_total() : '';
			echo upq_card_html( $amount, 'checkout' ); // phpcs:ignore WordPress.Security.EscapeOutput -- built from escaped parts.
		}

		public function process_payment( $order_id ) {
			$order = wc_get_order( $order_id );
			if ( ! $order ) {
				return array( 'result' => 'failure' );
			}
			$order->update_meta_data( '_upq_receipt_pending', 'yes' );
			$order->update_status( 'on-hold', 'Awaiting UPI payment. Check the money in the UPI/bank app, then press Payment received.' );
			// Donations are virtual: no stock handling.
			WC()->cart->empty_cart();
			return array(
				'result'   => 'success',
				'redirect' => $this->get_return_url( $order ),
			);
		}
	}
}, 20 );

/* =====================================================================
 * 2. Settings + the one payment card (checkout; the theme reuses it on the pending page)
 * ================================================================== */

function upq_settings() {
	$s = get_option( 'woocommerce_' . UPQ_GATEWAY_ID . '_settings', array() );
	return is_array( $s ) ? $s : array();
}

function upq_value( $key, $default = '' ) {
	$s = upq_settings();
	return isset( $s[ $key ] ) && '' !== $s[ $key ] ? $s[ $key ] : $default;
}

function upq_is_upi_order( $order ) {
	return $order instanceof WC_Order && UPQ_GATEWAY_ID === $order->get_payment_method();
}

/** Instructions with {upi_id} filled in. */
function upq_instructions() {
	$text = (string) upq_value( 'instructions' );
	return '' === $text ? '' : strtr( $text, array( '{upi_id}' => (string) upq_value( 'upi_id' ) ) );
}

/**
 * One clean card: heading, amount (if given), QR, UPI ID + Copy, payee note, instructions, contact.
 * Uses the theme's .upi-card / .upi-card--light styles (same look as the footer card).
 *
 * @param string $amount_html Formatted amount ('' = not shown).
 * @param string $heading_tag h3 on the pending page, h4 at checkout.
 */
function upq_card_html( $amount_html = '', $context = 'checkout' ) {
	$qr  = trim( (string) upq_value( 'qr_url' ) );
	$upi = trim( (string) upq_value( 'upi_id' ) );
	if ( '' === $qr || '' === $upi ) {
		return '';
	}
	$tag  = 'checkout' === $context ? 'h4' : 'h3';
	$w    = max( 120, min( 420, (int) upq_value( 'qr_width', 180 ) ) );
	$note = trim( (string) upq_value( 'payee_note' ) );
	$ins  = upq_instructions();
	$tel  = trim( (string) upq_value( 'contact' ) );

	$h  = '<div class="upi-card upi-card--light upq-card">';
	$h .= '<' . $tag . ' class="upi-card-title">Pay with UPI</' . $tag . '>';
	if ( '' !== $amount_html ) {
		$h .= '<p class="upq-amount">Amount to pay: <strong>' . wp_kses_post( $amount_html ) . '</strong></p>';
	}
	$h .= '<img class="upi-card-qr" src="' . esc_url( $qr ) . '" alt="' . esc_attr( upq_value( 'qr_alt', 'UPI QR code' ) ) . '" style="width:' . $w . 'px" loading="eager" decoding="async">';
	$h .= '<p class="upi-card-id"><span class="upi-card-label">UPI ID:</span> <span class="upi-card-value">' . esc_html( $upi ) . '</span> <button type="button" class="upi-copy-btn upq-copy" data-copy="' . esc_attr( $upi ) . '" aria-label="Copy UPI ID">Copy</button></p>';
	if ( '' !== $note ) {
		$h .= '<p class="upq-payee">' . esc_html( $note ) . '</p>';
	}
	if ( '' !== $ins ) {
		$h .= '<p class="upi-card-text upq-instructions">' . esc_html( $ins ) . '</p>';
	}
	if ( '' !== $tel ) {
		$h .= '<p class="upi-card-contact">Contact: <a href="tel:' . esc_attr( preg_replace( '/[^0-9+]/', '', $tel ) ) . '">' . esc_html( $tel ) . '</a></p>';
	}
	return $h . '</div>';
}

/* Copy button at checkout: the payment box is re-rendered by AJAX, so the click handler is delegated. */
add_action( 'wp_footer', function () {
	if ( ! function_exists( 'is_checkout' ) || ! is_checkout() || is_order_received_page() ) {
		return;
	}
	echo '<style>.upq-card{margin:8px auto}.upq-card .upq-amount{margin:0 0 .6rem;font-size:.95rem;color:#111827}.upq-card .upq-payee{font-size:.8125rem;color:#475569;margin:0 0 .6rem}.upq-card .upq-instructions{text-align:center}</style>';
	echo '<script>(function(){document.addEventListener("click",function(e){var b=e.target.closest&&e.target.closest(".upq-copy");if(!b||b.getAttribute("data-upq-bound")){return;}e.preventDefault();var v=b.getAttribute("data-copy")||"";var done=function(){b.textContent="Copied";setTimeout(function(){b.textContent="Copy";},2000);};if(navigator.clipboard&&window.isSecureContext){navigator.clipboard.writeText(v).then(done,function(){fb(v,done);});}else{fb(v,done);}function fb(t,cb){var a=document.createElement("textarea");a.value=t;a.setAttribute("readonly","");a.style.position="absolute";a.style.left="-9999px";document.body.appendChild(a);a.select();try{document.execCommand("copy");}catch(x){}document.body.removeChild(a);cb();}});})();</script>';
}, 50 );

/* Admin e-mails for UPQ orders: the one-tap buttons above the order table. (Customer e-mail content comes from the theme.) */
add_action( 'woocommerce_email_before_order_table', function ( $order, $sent_to_admin, $plain_text ) {
	if ( ! upq_is_upi_order( $order ) || ! $sent_to_admin || $plain_text ) {
		return;
	}
	echo upq_admin_buttons_block( $order ); // phpcs:ignore WordPress.Security.EscapeOutput
}, 20, 3 );

/* =====================================================================
 * 3. Admin mail helpers
 * ================================================================== */

/** Admin recipient = WooCommerce "New order" recipient (first address). */
function upq_admin_to() {
	$s = get_option( 'woocommerce_new_order_settings', array() );
	$r = is_array( $s ) && ! empty( $s['recipient'] ) ? $s['recipient'] : get_option( 'admin_email' );
	return trim( explode( ',', (string) $r )[0] );
}

function upq_owner_cc() {
	return defined( 'UPQ_OWNER_CC' ) ? (string) UPQ_OWNER_CC : '';
}

function upq_send_admin_mail( $subject, $html ) {
	$to      = upq_admin_to();
	$headers = array( 'Content-Type: text/html; charset=UTF-8' );
	$cc      = upq_owner_cc();
	if ( '' !== $cc && false === stripos( $to, $cc ) ) {
		$headers[] = 'Cc: ' . $cc;
	}
	return wp_mail( $to, $subject, $html, $headers );
}

add_filter( 'woocommerce_email_headers', function ( $headers, $email_id = '' ) {
	if ( '' !== upq_owner_cc() && in_array( $email_id, array( 'new_order', 'cancelled_order', 'failed_order' ), true ) ) {
		$headers .= 'Cc: ' . upq_owner_cc() . "\r\n";
	}
	return $headers;
}, 20, 2 );

/* Remember when a UPQ order first went on hold (for the 7-day watcher). Other gateways: untouched. */
add_action( 'woocommerce_order_status_on-hold', function ( $order_id ) {
	$o = wc_get_order( $order_id );
	if ( $o && upq_is_upi_order( $o ) && ! $o->get_meta( '_upq_hold_since' ) ) {
		$o->update_meta_data( '_upq_hold_since', time() );
		$o->save_meta_data();
	}
} );

/* =====================================================================
 * 4. ONE state machine
 *    unpaid (pending / on-hold) -> Payment received, Not received (+ Cancel in the warning e-mail)
 *    done   (anything else)     -> no buttons
 * ================================================================== */

function upq_state( $order ) {
	if ( ! $order instanceof WC_Order ) {
		return 'done';
	}
	return in_array( $order->get_status(), array( 'pending', 'on-hold' ), true ) ? 'unpaid' : 'done';
}

function upq_actions_allowed( $order, $context = '' ) {
	if ( ! upq_is_upi_order( $order ) || 'unpaid' !== upq_state( $order ) ) {
		return array();
	}
	return 'warning' === $context ? array( 'pay_ok', 'pay_no', 'cancel' ) : array( 'pay_ok', 'pay_no' );
}

/** label, confirmation question, colour. */
function upq_action_defs() {
	return array(
		'pay_ok' => array( 'Payment received', 'mark donation #%s as PAYMENT RECEIVED (it becomes Completed and the donor gets the Completed e-mail with the receipt link)', '#18A957' ),
		'pay_no' => array( 'Payment not received', 'record that the payment for donation #%s was NOT received (it stays On hold)', '#B3261E' ),
		'cancel' => array( 'Cancel donation', 'CANCEL donation #%s (the donor gets the cancellation e-mail)', '#B3261E' ),
	);
}

function upq_record_action( $order, $action, $via ) {
	$d = upq_action_defs();
	$order->update_meta_data( '_upq_last_action', array( 'label' => isset( $d[ $action ] ) ? $d[ $action ][0] : $action, 'by' => $via, 'at' => time() ) );
	$order->save_meta_data();
}

function upq_already_text( $order ) {
	$no = $order->get_order_number();
	$l  = $order->get_meta( '_upq_last_action' );
	$st = wc_get_order_status_name( $order->get_status() );
	if ( is_array( $l ) && ! empty( $l['label'] ) ) {
		return 'Already done: ' . $l['label'] . ', by ' . $l['by'] . ', at ' . wp_date( 'j M, g:i A', (int) $l['at'] ) . '. Donation #' . $no . ' is now: ' . $st . '.';
	}
	return 'No change: donation #' . $no . ' is now: ' . $st . '.';
}

/** Run an action. Returns array( ok, message, kind ) with kind = done | already | failed. */
function upq_run_action( $order, $action, $via = 'email button' ) {
	$no = $order->get_order_number();
	if ( ! in_array( $action, upq_actions_allowed( $order, 'warning' ), true ) ) {
		return array( false, upq_already_text( $order ), 'already' );
	}
	$res = array( false, 'Unknown action.', 'failed' );
	try {
		switch ( $action ) {
			case 'pay_ok':
				$order->delete_meta_data( '_upq_receipt_pending' );
				$order->add_order_note( 'Payment received via ' . $via . '.' );
				$order->update_status( 'completed', 'Payment received (confirmed by admin ' . $via . ').' );
				$res = array( true, 'Donation #' . $no . ' is marked Payment received (Completed).', 'done' );
				break;
			case 'pay_no':
				$order->update_meta_data( '_upq_pay_not_received_at', time() );
				$order->add_order_note( 'Payment NOT received, via ' . $via . '.' );
				if ( $order->has_status( 'pending' ) ) {
					$order->update_status( 'on-hold', 'Payment not received (admin ' . $via . ').' );
				} else {
					$order->save();
				}
				$res = array( true, 'Donation #' . $no . ' stays On hold. A note was added.', 'done' );
				break;
			case 'cancel':
				$order->add_order_note( 'Cancelled via ' . $via . '.' );
				$order->update_status( 'cancelled', 'Cancelled (' . $via . ').' );
				$res = array( true, 'Donation #' . $no . ' is cancelled.', 'done' );
				break;
		}
	} catch ( Throwable $e ) {
		$res = array( false, 'Error: ' . $e->getMessage(), 'failed' );
	}
	$fresh = wc_get_order( $order->get_id() );
	if ( 'done' === $res[2] ) {
		upq_record_action( $fresh, $action, $via );
		do_action( 'upq_state_changed', $fresh, $action, $via );
	} elseif ( 'failed' === $res[2] ) {
		$fresh->add_order_note( 'Action "' . $action . '" via ' . $via . ' FAILED: ' . $res[1] );
		upq_send_admin_mail( 'Action failed – donation #' . $no, '<p>The action <b>' . esc_html( $action ) . '</b> (via ' . esc_html( $via ) . ') did not work: ' . esc_html( $res[1] ) . '. Nothing was changed. Please open the donation.</p>' );
	}
	return $res;
}

/* =====================================================================
 * 5. Signed one-time links (HMAC) + confirm page
 * ================================================================== */

function upq_secret() {
	return defined( 'UPQ_LINK_SECRET' ) ? (string) UPQ_LINK_SECRET : '';
}

function upq_sig( $payload ) {
	return substr( hash_hmac( 'sha256', $payload, upq_secret() ), 0, 40 );
}

function upq_token_make( $order_id, $action, $days = 14 ) {
	if ( '' === upq_secret() ) {
		return '';
	}
	$payload = (int) $order_id . '|' . $action . '|' . ( time() + $days * DAY_IN_SECONDS );
	return rtrim( strtr( base64_encode( $payload ), '+/', '-_' ), '=' ) . '.' . upq_sig( $payload );
}

/** @return array|false [order_id, action, exp, sig] */
function upq_token_parse( $token ) {
	$token = (string) $token;
	if ( '' === upq_secret() || ! preg_match( '/^[A-Za-z0-9_-]+\.[a-f0-9]{40}$/', $token ) ) {
		return false;
	}
	list( $b, $sig ) = explode( '.', $token );
	$payload         = base64_decode( strtr( $b, '-_', '+/' ), true );
	if ( false === $payload || ! hash_equals( upq_sig( $payload ), $sig ) ) {
		return false;
	}
	$p = explode( '|', $payload );
	if ( 3 !== count( $p ) || ! isset( upq_action_defs()[ $p[1] ] ) ) {
		return false;
	}
	return array( (int) $p[0], $p[1], (int) $p[2], $sig );
}

function upq_link_url( $order_id, $action ) {
	$t = upq_token_make( $order_id, $action );
	return '' === $t ? '' : home_url( '/?upq_act=' . $t );
}

function upq_buttons_html( $order_id, $actions ) {
	$defs = upq_action_defs();
	$out  = '';
	foreach ( $actions as $a ) {
		$u = upq_link_url( $order_id, $a );
		if ( '' === $u ) {
			continue;
		}
		$out .= '<a href="' . esc_url( $u ) . '" style="display:inline-block;margin:0 8px 8px 0;padding:11px 16px;background:' . $defs[ $a ][2] . ';color:#ffffff;font-family:Arial,Helvetica,sans-serif;font-weight:700;font-size:14px;text-decoration:none;border-radius:6px;">' . esc_html( $defs[ $a ][0] ) . '</a>';
	}
	return $out;
}

function upq_admin_buttons_block( $order, $context = '' ) {
	$b = upq_buttons_html( $order->get_id(), upq_actions_allowed( $order, $context ) );
	if ( '' === $b ) {
		return '';
	}
	return '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="width:100%;margin:0 0 20px;"><tr><td style="background:#FFF7ED;border:1px solid #FED7AA;border-radius:6px;padding:14px 16px;font-family:Arial,Helvetica,sans-serif;">'
		. '<div style="font-size:12px;text-transform:uppercase;letter-spacing:0.04em;color:#9A3412;font-weight:700;margin:0 0 10px;">UPI payment check &mdash; one tap (check the money in the UPI/bank app first)</div>'
		. $b . '<div style="font-size:12px;color:#5a5548;margin-top:4px;">Each button opens a confirmation page first. Links work once and expire in 14 days.</div></td></tr></table>';
}

/** Small standalone page for the link flow (never cached, never indexed). */
function upq_page( $title, $body, $code = 200 ) {
	status_header( $code );
	nocache_headers();
	header( 'X-Robots-Tag: noindex, nofollow' );
	header( 'X-LiteSpeed-Cache-Control: no-cache' );
	header( 'Content-Type: text/html; charset=UTF-8' );
	echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex,nofollow"><title>' . esc_html( $title ) . '</title></head>'
		. '<body style="margin:0;background:#F8FAFC;font-family:Arial,Helvetica,sans-serif;color:#111827;"><div style="max-width:520px;margin:40px auto;padding:0 16px;"><div style="background:#fff;border:1px solid #E2E8F0;border-radius:10px;padding:26px 22px;">'
		. '<div style="font-weight:700;color:#C2410C;margin:0 0 12px;">' . esc_html( get_bloginfo( 'name' ) ) . ' &middot; admin</div>' . $body . '</div></div></body></html>'; // phpcs:ignore WordPress.Security.EscapeOutput
	exit;
}

add_action( 'template_redirect', function () {
	$is_post = 'POST' === ( $_SERVER['REQUEST_METHOD'] ?? '' );
	$raw     = $is_post ? ( $_POST['upq_act_token'] ?? '' ) : ( $_GET['upq_act'] ?? '' ); // phpcs:ignore WordPress.Security.NonceVerification
	if ( '' === (string) $raw ) {
		return;
	}
	if ( ! defined( 'DONOTCACHEPAGE' ) ) {
		define( 'DONOTCACHEPAGE', true );
	}
	$token = sanitize_text_field( wp_unslash( $raw ) );
	$p     = upq_token_parse( $token );
	$bad   = '<h2 style="margin:0 0 8px;">This link cannot be used</h2><p>It is not valid. No change was made.</p>';
	if ( ! $p ) {
		upq_page( 'Link not valid', $bad, 400 );
	}
	list( $oid, $action, $exp, $sig ) = $p;
	$order = wc_get_order( $oid );
	if ( ! $order || 'shop_order' !== $order->get_type() || ! upq_is_upi_order( $order ) ) {
		upq_page( 'Link not valid', $bad, 400 );
	}
	if ( $exp < time() ) {
		upq_page( 'Link expired', '<h2 style="margin:0 0 8px;">This link has expired</h2><p>No change was made. Please open the donation in the dashboard.</p>', 410 );
	}
	if ( ! in_array( $action, upq_actions_allowed( $order, 'warning' ), true ) ) {
		upq_page( 'Already done', '<h2 style="margin:0 0 8px;">Already done</h2><p style="line-height:1.6;">' . esc_html( upq_already_text( $order ) ) . '</p><p style="font-size:13px;color:#5a5548;">No change was made.</p>' );
	}
	if ( in_array( $sig, (array) $order->get_meta( '_upq_links_used' ), true ) ) {
		upq_page( 'Link already used', '<h2 style="margin:0 0 8px;">This link was already used</h2><p>Each link works only once. No change was made.</p>', 410 );
	}
	$defs = upq_action_defs();
	$no   = $order->get_order_number();
	if ( ! $is_post ) {
		// GET = confirmation only (e-mail scanners open links; they never press the button).
		upq_page(
			'Confirm',
			'<h2 style="margin:0 0 10px;font-size:20px;">Confirm: ' . esc_html( $defs[ $action ][0] ) . '</h2><p style="line-height:1.6;">Do you want to ' . sprintf( $defs[ $action ][1], esc_html( $no ) ) . '?</p>'
			. '<p style="color:#5a5548;font-size:14px;">Donation #' . esc_html( $no ) . ' &middot; ' . esc_html( trim( $order->get_billing_first_name() ) ) . ' &middot; ' . wp_kses_post( $order->get_formatted_order_total() ) . ' &middot; ' . esc_html( wc_get_order_status_name( $order->get_status() ) ) . '</p>'
			. '<form method="post" action="' . esc_url( home_url( '/' ) ) . '"><input type="hidden" name="upq_act_token" value="' . esc_attr( $token ) . '"><button type="submit" style="width:100%;padding:14px;border:0;border-radius:6px;background:' . $defs[ $action ][2] . ';color:#fff;font-weight:700;font-size:16px;cursor:pointer;">Yes, ' . esc_html( $defs[ $action ][0] ) . '</button></form>'
			. '<p style="margin:14px 0 0;font-size:13px;color:#5a5548;">Not you? Just close this page; nothing happens.</p>'
		);
	}
	// POST: act, then consume the link (a real failure leaves it usable for a retry).
	list( $ok, $msg, $kind ) = upq_run_action( $order, $action );
	if ( 'failed' !== $kind ) {
		$o2     = wc_get_order( $oid );
		$used   = (array) $o2->get_meta( '_upq_links_used' );
		$used[] = $sig;
		$o2->update_meta_data( '_upq_links_used', array_slice( $used, -50 ) );
		$o2->save_meta_data();
	}
	upq_page( $ok ? 'Done' : 'Not done', '<h2 style="margin:0 0 8px;color:' . ( $ok ? '#0E7A3E' : '#B3261E' ) . ';">' . ( $ok ? 'Done' : 'Not done' ) . '</h2><p style="line-height:1.6;">' . esc_html( $msg ) . '</p>', $ok ? 200 : 409 );
}, 0 );

/* =====================================================================
 * 6. On-hold watcher (UPQ donations only): warn after 7 days, then every 4 days. NEVER auto-cancel.
 *    Sends only to the admin; never to donors; never for older gateways' orders.
 * ================================================================== */

add_action( 'init', function () {
	if ( ! wp_next_scheduled( 'upq_hold_watch_job' ) ) {
		wp_schedule_event( time() + 600, 'hourly', 'upq_hold_watch_job' );
	}
} );

add_action( 'upq_hold_watch_job', function () {
	if ( '' === upq_secret() ) {
		return;
	}
	$orders = wc_get_orders( array( 'limit' => 100, 'status' => array( 'on-hold' ), 'payment_method' => UPQ_GATEWAY_ID ) );
	foreach ( $orders as $o ) {
		if ( ! upq_is_upi_order( $o ) ) { // belt and braces
			continue;
		}
		$since = (int) $o->get_meta( '_upq_hold_since' );
		if ( ! $since ) {
			$since = $o->get_date_created() ? $o->get_date_created()->getTimestamp() : time();
		}
		$last = (int) $o->get_meta( '_upq_hold_warned_at' );
		$due  = $last ? $last + 4 * DAY_IN_SECONDS : $since + 7 * DAY_IN_SECONDS;
		if ( time() < $due ) {
			continue;
		}
		$no   = $o->get_order_number();
		$html = '<p style="font-family:Arial,sans-serif;font-size:15px;line-height:1.6;">Donation <b>#' . esc_html( $no ) . '</b> (' . esc_html( $o->get_formatted_billing_full_name() ) . ', ' . esc_html( $o->get_billing_phone() ) . ', ' . wp_kses_post( $o->get_formatted_order_total() ) . ') has been <b>on hold since ' . esc_html( wp_date( 'j M Y', $since ) ) . '</b>. It will NOT be cancelled automatically. Please check the UPI/bank app and choose:</p>'
			. upq_admin_buttons_block( $o, 'warning' );
		if ( upq_send_admin_mail( 'Donation still on hold – #' . $no, $html ) ) {
			$o->update_meta_data( '_upq_hold_warned_at', time() );
			$o->save_meta_data();
		}
	}
} );

register_deactivation_hook( __FILE__, function () {
	wp_clear_scheduled_hook( 'upq_hold_watch_job' );
} );
