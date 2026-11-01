<?php
/**
 * Pending-payment flow ("Option A"), 2026-10-14.
 *
 *  a) Thank-you page for ON-HOLD donations: big bilingual "PENDING" message, UPI (amount, UPI ID, QR,
 *     mobile "pay with UPI app" button) or bank details, instead of "your donation has been received".
 *  b) "I have paid" form: UTR / transaction number (+ optional screenshot) -> private order note,
 *     status stays on-hold, e-mail to the shop owner.
 *  c) The customer "on-hold" e-mail carries the same payment instructions.
 *  d) Daily morning digest of on-hold orders to the shop owner.
 *  e) "View / print your receipt" link only in the COMPLETED e-mail.
 *
 * Nothing here is visible to donors until the option  daan_payment_box_live  is set to 1.
 * Preview: add  ?daan_preview=<secret token stored in option daan_payment_preview_token>  to a page URL
 * (no write happens in preview mode, the form only validates).
 *
 * Payment details are exactly those already shown on the live site. Bank transfer was closed on 2026-10-27:
 * every pending order (old bank-transfer orders too) now shows the UPI ID, QR and UPI app button.
 */
defined( 'ABSPATH' ) || exit;

/* -------------------------------------------------------------------------
 * Configuration and helpers
 * ------------------------------------------------------------------------- */

function daan_payment_details() {
	// Since 2026-10-30 the UPI QR gateway settings (plugin upi-qr-payment) are the single source.
	if ( function_exists( 'upq_value' ) && '' !== trim( (string) upq_value( 'upi_id' ) ) && '' !== trim( (string) upq_value( 'qr_url' ) ) ) {
		return array(
			'payee'  => 'Daan Foundation',
			'upi_id' => trim( (string) upq_value( 'upi_id' ) ),
			'qr_url' => trim( (string) upq_value( 'qr_url' ) ),
		);
	}
	return array(
		'payee'        => 'Daan Foundation',
		'upi_id'       => 'sbibhim.instant90923460741799790@sbipay',
		'qr_url'       => 'https://daanfoundation.in/wp-content/uploads/2026/08/QR-Code-SBI-Payment-Daan-Foundation.jpeg',
	);
}

/** '' (off) | 'live' | 'preview'. */
function daan_pay_mode() {
	static $mode = null;
	if ( null !== $mode ) {
		return $mode;
	}
	$mode = '';
	if ( '1' === (string) get_option( 'daan_payment_box_live', '0' ) ) {
		$mode = 'live';
	} else {
		$token = (string) get_option( 'daan_payment_preview_token', '' );
		$given = isset( $_REQUEST['daan_preview'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['daan_preview'] ) ) : '';
		if ( '' !== $token && '' !== $given && hash_equals( $token, $given ) ) {
			$mode = 'preview';
		}
	}
	return $mode;
}

function daan_pay_is_pending( $order ) {
	return $order && is_a( $order, 'WC_Order' ) && $order->has_status( 'on-hold' )
		&& in_array( $order->get_payment_method(), array( 'bacs', 'cheque', 'wc-upi', 'dew-wc-upi', 'upq_manual_qr' ), true );
}

/** "cheque" is the gateway that is titled "Pay via UPI" on this site. */
function daan_pay_is_upi( $order ) {
	return in_array( $order->get_payment_method(), array( 'cheque', 'wc-upi', 'dew-wc-upi', 'upq_manual_qr' ), true );
}

function daan_pay_method_label( $order ) {
	$map = array(
		'cheque'        => 'UPI',
		'upq_manual_qr' => 'UPI QR',
		'bacs'       => 'Bank transfer',
		'wc-upi'     => 'UPI QR (old plugin)',
		'dew-wc-upi' => 'UPI QR (old plugin)',
	);
	$m = $order->get_payment_method();
	return isset( $map[ $m ] ) ? $map[ $m ] : ( $order->get_payment_method_title() ?: $m );
}

function daan_pay_amount_text( $order ) {
	return '₹' . number_format_i18n( (float) $order->get_total(), 2 );
}

function daan_pay_upi_link( $order ) {
	$d = daan_payment_details();
	return 'upi://pay?pa=' . $d['upi_id']
		. '&pn=' . rawurlencode( $d['payee'] )
		. '&am=' . number_format( (float) $order->get_total(), 2, '.', '' )
		. '&cu=INR'
		. '&tn=' . rawurlencode( 'Order ' . $order->get_order_number() );
}

function daan_pay_utr_ok( $utr, $is_upi ) {
	if ( $is_upi ) {
		return (bool) preg_match( '/^[0-9]{12}$/', $utr );
	}
	// Bank transfers: IMPS/UPI references are 12 digits, NEFT/RTGS references are 16-22 letters+digits.
	return (bool) preg_match( '/^[0-9]{12}$|^[A-Z0-9]{16,22}$/', $utr );
}

function daan_pay_notify_recipient() {
	$s = get_option( 'woocommerce_new_order_settings', array() );
	$r = is_array( $s ) && ! empty( $s['recipient'] ) ? $s['recipient'] : get_option( 'admin_email' );
	return $r;
}

/* -------------------------------------------------------------------------
 * (a) Thank-you page
 * ------------------------------------------------------------------------- */

add_filter(
	'woocommerce_thankyou_order_received_text',
	function ( $text, $order ) {
		if ( daan_pay_mode() && daan_pay_is_pending( $order ) ) {
			return '<strong>Status: PENDING</strong> &mdash; payment not received yet.';
		}
		return $text;
	},
	30,
	2
);

add_filter(
	'woocommerce_endpoint_order-received_title',
	function ( $title ) {
		if ( ! daan_pay_mode() ) {
			return $title;
		}
		$id    = absint( get_query_var( 'order-received' ) );
		$order = $id ? wc_get_order( $id ) : null;
		return daan_pay_is_pending( $order ) ? 'Donation Pending — Complete Your Payment' : $title;
	},
	30
);

add_action(
	'woocommerce_before_thankyou',
	function ( $order_id ) {
		if ( ! daan_pay_mode() ) {
			return;
		}
		$order = wc_get_order( $order_id );
		if ( ! daan_pay_is_pending( $order ) ) {
			return;
		}
		// Since 2026-10-31 UPI QR donations use the plugin's "Complete your payment" section (handover look);
		// this old card + "I have paid" form stay only for older on-hold orders of other gateways.
		if ( 'upq_manual_qr' === $order->get_payment_method() && function_exists( 'upq_email_html' ) ) {
			return;
		}
		// The gateways' own thank-you text would repeat (or contradict) the box below.
		if ( function_exists( 'WC' ) && WC()->payment_gateways() ) {
			$gws = WC()->payment_gateways->payment_gateways();
			foreach ( array( 'bacs', 'cheque' ) as $gid ) {
				if ( isset( $gws[ $gid ] ) ) {
					remove_action( 'woocommerce_thankyou_' . $gid, array( $gws[ $gid ], 'thankyou_page' ) );
				}
			}
		}
		echo daan_pay_box_html( $order ); // phpcs:ignore WordPress.Security.EscapeOutput -- built from escaped parts.
	},
	5
);

/*
 * Pending page of a UPI QR donation: the page starts with the status line and the "Complete your payment" box.
 * Hidden only there: the theme title line (kept for screen readers as the page H1) and the checkout page's
 * Elementor "Donate Now !" heading section. The status line is left-aligned (the theme justifies paragraphs).
 */
function daan_is_upq_pending_view() {
	static $is = null;
	if ( ! did_action( 'wp' ) ) {
		return false; // query not parsed yet (early gettext calls): do not cache.
	}
	if ( null === $is ) {
		$is = false;
		if ( function_exists( 'is_order_received_page' ) && is_order_received_page() ) {
			$id    = absint( get_query_var( 'order-received' ) );
			$order = $id ? wc_get_order( $id ) : null;
			$is    = $order && 'upq_manual_qr' === $order->get_payment_method() && $order->has_status( array( 'on-hold', 'pending' ) );
		}
	}
	return $is;
}

add_action(
	'wp_head',
	function () {
		if ( ! daan_is_upq_pending_view() ) {
			return;
		}
		// Order overview: 2x2 grid on phones, one row from 768 px; no dotted dividers.
		echo '<style id="daan-upq-pending">.page-content>.page-title{position:absolute!important;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}.elementor-element-2a824ff{display:none!important}.woocommerce-thankyou-order-received{text-align:left!important}'
			. 'ul.woocommerce-order-overview{display:grid!important;grid-template-columns:1fr 1fr;gap:14px 16px;list-style:none;margin:12px 0 24px!important;padding:0!important}ul.woocommerce-order-overview::before,ul.woocommerce-order-overview::after{display:none!important}ul.woocommerce-order-overview li{float:none!important;border:0!important;margin:0!important;padding:0!important;min-width:0;overflow-wrap:anywhere}@media(min-width:768px){ul.woocommerce-order-overview{grid-template-columns:repeat(4,auto);justify-content:start;column-gap:40px}}</style>' . "\n";
	},
	99
);

// Pending page of a UPI QR donation: "Order number:" -> "Donation number:" in the overview.
add_filter(
	'gettext_woocommerce',
	function ( $translation, $text ) {
		return ( 'Order number:' === $text && daan_is_upq_pending_view() ) ? 'Donation number:' : $translation;
	},
	10,
	2
);

function daan_pay_box_html( $order ) {
	$d      = daan_payment_details();
	$is_upi = daan_pay_is_upi( $order );
	$amount = daan_pay_amount_text( $order );
	$oid    = $order->get_order_number();
	$mode   = daan_pay_mode();

	ob_start();
	?>
<style>
.daan-pay{max-width:760px;margin:0 auto 28px;font-family:"Open Sans",Arial,"Noto Sans Devanagari","Nirmala UI",sans-serif;color:#1F2937}
.daan-pay *{box-sizing:border-box}
.daan-pay,.daan-pay p,.daan-pay li,.daan-pay dd,.daan-pay dt,.daan-pay label{text-align:left!important;text-justify:auto}
.daan-pay-steps{list-style:decimal!important;padding-left:22px!important}.daan-pay-steps li{display:list-item!important;margin:0 0 8px!important}
.daan-pay-card h3{font-weight:700!important}.daan-pay-kv dd{overflow-wrap:anywhere}
.daan-pay-banner{background:#FFF7ED;border:2px solid #C2410C;border-radius:14px;padding:20px 22px;margin:0 0 18px}
.daan-pay-banner .hi{font-size:1.45rem;font-weight:800;line-height:1.35;margin:0 0 6px;color:#7C2D12}
.daan-pay-banner .en{font-size:1.15rem;font-weight:700;margin:0 0 10px;color:#9A3412}
.daan-pay-banner .sub{font-size:.95rem;margin:0;color:#44403C}
.daan-pay-card{background:#fff;border:1px solid #E2E8F0;border-radius:14px;padding:20px 22px;margin:0 0 18px}
.daan-pay-card h3{font-size:1.1rem;margin:0 0 12px;color:#111827}
.daan-pay-meta{display:flex;flex-wrap:wrap;gap:8px 28px;margin:0 0 14px;font-size:1rem}
.daan-pay-meta strong{font-size:1.15rem}
.daan-pay-steps{margin:0 0 14px;padding-left:20px;font-size:.95rem;line-height:1.6}
.daan-pay-kv{display:grid;grid-template-columns:auto 1fr;gap:6px 14px;font-size:1rem;margin:0 0 12px}
.daan-pay-kv dt{font-weight:600;color:#475569}.daan-pay-kv dd{margin:0;word-break:break-all;font-weight:700}
.daan-pay-qr{text-align:center;margin:10px 0}.daan-pay-qr img{width:220px;max-width:100%;height:auto;border:1px solid #E2E8F0;border-radius:10px}
.daan-upi-btn{display:none;text-align:center;background:#C2410C;color:#fff!important;font-weight:700;border-radius:12px;padding:14px 16px;text-decoration:none;margin:10px 0}
@media (max-width:900px){.daan-upi-btn{display:block}}
.daan-pay-card label{display:block;font-weight:600;font-size:.95rem;margin:12px 0 6px}
.daan-pay-card input[type=text],.daan-pay-card input[type=file]{width:100%;padding:12px 14px;border:2px solid #CBD5E1;border-radius:10px;font-size:1rem;background:#fff}
.daan-pay-card button{margin-top:14px;width:100%;padding:14px;border:0;border-radius:12px;background:#C2410C;color:#fff;font-size:1.05rem;font-weight:700;cursor:pointer}
.daan-pay-card button[disabled]{opacity:.6;cursor:wait}
.daan-msg{margin-top:12px;font-weight:600}.daan-msg.ok{color:#166534}.daan-msg.err{color:#B91C1C}
.daan-hp{position:absolute;left:-9999px;height:0;overflow:hidden}
.daan-pay .upi-card p{text-align:center!important}.daan-pay-card .upi-copy-btn{width:auto;margin:0 0 0 .4rem;padding:.2rem .65rem;font-size:.75rem;border-radius:6px}
</style>
<section class="daan-pay" id="daan-pay">
	<div class="daan-pay-banner" role="status">
		<p class="en">Your donation is PENDING — please complete the payment.</p>
		<p class="sub">Your donation is counted only after we receive the payment.</p>
	</div>

	<div class="daan-pay-card">
		<p class="daan-pay-meta"><span>Donation <strong>#<?php echo esc_html( $oid ); ?></strong></span><span>Amount <strong><?php echo esc_html( $amount ); ?></strong></span></p>
		<?php if ( ! $is_upi ) : ?><p style="margin:0 0 12px;font-size:.95rem">Bank transfer is no longer offered; please pay by UPI.</p><?php endif; ?>
			<?php if ( function_exists( 'upq_card_html' ) && '' !== upq_card_html( '', 'pending' ) ) : ?>
				<?php echo upq_card_html( '', 'pending' ); // phpcs:ignore WordPress.Security.EscapeOutput -- built from escaped parts. ?>
			<?php else : ?>
			<div class="upi-card upi-card--light">
				<h3 class="upi-card-title">Pay with UPI</h3>
				<img class="upi-card-qr" src="<?php echo esc_url( $d['qr_url'] ); ?>" alt="UPI QR code - Daan Foundation" decoding="async">
				<p class="upi-card-text">Scan the QR code with any UPI app to donate.</p>
				<p class="upi-card-id"><span class="upi-card-label">UPI ID:</span> <span class="upi-card-value"><?php echo esc_html( $d['upi_id'] ); ?></span> <button type="button" class="upi-copy-btn" data-copy="<?php echo esc_attr( $d['upi_id'] ); ?>" aria-label="Copy UPI ID">Copy</button></p>
				<p class="upi-card-contact">Contact: <a href="tel:+918899152910">+91 88991 52910</a></p>
			</div>
			<?php endif; ?>
	</div>

	<div class="daan-pay-card">
		<h3>I have paid</h3>
		<form id="daan-proof-form" method="post" enctype="multipart/form-data" data-url="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
			<div class="daan-fields">
				<input type="hidden" name="action" value="daan_payment_proof">
				<input type="hidden" name="order_id" value="<?php echo esc_attr( $order->get_id() ); ?>">
				<input type="hidden" name="order_key" value="<?php echo esc_attr( $order->get_order_key() ); ?>">
				<?php wp_nonce_field( 'daan_payment_proof', 'daan_nonce' ); ?>
				<?php if ( 'preview' === $mode ) : ?>
					<input type="hidden" name="daan_preview" value="<?php echo esc_attr( isset( $_REQUEST['daan_preview'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['daan_preview'] ) ) : '' ); ?>">
				<?php endif; ?>
				<div class="daan-hp" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
				<label for="daan-utr">UTR <?php echo $is_upi ? '(12 digits)' : ''; ?></label>
				<input type="text" id="daan-utr" name="utr" required inputmode="text" autocomplete="off" maxlength="22" placeholder="<?php echo $is_upi ? '123456789012' : 'UTR / reference'; ?>">
				<label for="daan-proof">Screenshot (optional) — JPG, PNG, PDF, max 3 MB</label>
				<input type="file" id="daan-proof" name="proof" accept="image/jpeg,image/png,application/pdf">
				<button type="submit">I have paid</button>
			</div>
			<div class="daan-msg" role="status" aria-live="polite"></div>
		</form>
	</div>
</section>
<script>
(function(){
	var f=document.getElementById('daan-proof-form'); if(!f){return;}
	f.addEventListener('submit',function(e){
		e.preventDefault();
		var b=f.querySelector('button'),m=f.querySelector('.daan-msg'); b.disabled=true; m.className='daan-msg'; m.textContent='…';
		fetch(f.getAttribute('data-url'),{method:'POST',body:new FormData(f),credentials:'same-origin'})
			.then(function(r){return r.json();})
			.then(function(j){
				m.className='daan-msg '+(j&&j.success?'ok':'err'); m.textContent=(j&&j.data&&j.data.message)||'Error';
				if(j&&j.success){f.querySelector('.daan-fields').style.display='none';}else{b.disabled=false;}
			})
			.catch(function(){m.className='daan-msg err'; m.textContent='Network error, please try again.'; b.disabled=false;});
	});
})();
</script>
	<?php
	return ob_get_clean();
}

/* -------------------------------------------------------------------------
 * (b) "I have paid" form handler
 * ------------------------------------------------------------------------- */

function daan_pay_proof_dir() {
	$u = wp_upload_dir();
	return trailingslashit( $u['basedir'] ) . 'daan-payment-proofs';
}

add_action( 'wp_ajax_nopriv_daan_payment_proof', 'daan_pay_handle_proof' );
add_action( 'wp_ajax_daan_payment_proof', 'daan_pay_handle_proof' );

function daan_pay_handle_proof() {
	$mode = daan_pay_mode();
	$fail = function ( $msg, $code = 400 ) {
		wp_send_json_error( array( 'message' => $msg ), $code );
	};
	$generic = 'We could not record this. Please contact us.';

	if ( ! $mode ) {
		$fail( $generic, 403 );
	}
	if ( ! empty( $_POST['website'] ) ) { // honeypot: pretend success.
		wp_send_json_success( array( 'message' => 'Thank you.' ) );
	}
	if ( ! check_ajax_referer( 'daan_payment_proof', 'daan_nonce', false ) ) {
		$fail( 'This page expired, please reload it.', 403 );
	}

	$ip_key = 'daan_pp_ip_' . md5( function_exists( 'daan_receipt_client_ip' ) ? daan_receipt_client_ip() : 'x' );
	$tries  = (int) get_transient( $ip_key );
	if ( $tries >= 10 ) {
		$fail( 'Too many attempts. Please try again later.', 429 );
	}
	set_transient( $ip_key, $tries + 1, HOUR_IN_SECONDS );

	$order_id = isset( $_POST['order_id'] ) ? absint( $_POST['order_id'] ) : 0;
	$key      = isset( $_POST['order_key'] ) ? sanitize_text_field( wp_unslash( $_POST['order_key'] ) ) : '';
	$order    = $order_id ? wc_get_order( $order_id ) : null;
	if ( ! daan_pay_is_pending( $order ) || '' === $key || ! hash_equals( (string) $order->get_order_key(), $key ) ) {
		$fail( $generic );
	}
	if ( (int) $order->get_meta( '_daan_proof_count' ) >= 5 ) {
		$fail( 'We already have your details and are checking them.' );
	}

	$utr = strtoupper( preg_replace( '/\s+/', '', isset( $_POST['utr'] ) ? sanitize_text_field( wp_unslash( $_POST['utr'] ) ) : '' ) );
	if ( ! daan_pay_utr_ok( $utr, daan_pay_is_upi( $order ) ) ) {
		$fail( daan_pay_is_upi( $order )
			? 'The UTR must be exactly 12 digits.'
			: 'Please enter a valid UTR / reference (12 digits, or 16–22 letters and digits).' );
	}

	// Optional screenshot: jpg / png / pdf, 3 MB, checked by content (not by the file name).
	$stored = '';
	$f      = isset( $_FILES['proof'] ) ? $_FILES['proof'] : null;
	if ( $f && ! empty( $f['name'] ) ) {
		if ( UPLOAD_ERR_OK !== (int) $f['error'] || ! is_uploaded_file( $f['tmp_name'] ) ) {
			$fail( 'The screenshot could not be uploaded.' );
		}
		if ( (int) $f['size'] > 3 * 1024 * 1024 ) {
			$fail( 'The file is larger than 3 MB.' );
		}
		$ext = strtolower( pathinfo( $f['name'], PATHINFO_EXTENSION ) );
		if ( ! in_array( $ext, array( 'jpg', 'jpeg', 'png', 'pdf' ), true ) ) {
			$fail( 'Only JPG, PNG or PDF.' );
		}
		$mime = '';
		if ( function_exists( 'finfo_open' ) ) {
			$fi   = finfo_open( FILEINFO_MIME_TYPE );
			$mime = (string) finfo_file( $fi, $f['tmp_name'] );
			finfo_close( $fi );
		}
		$map = array(
			'image/jpeg'      => 'jpg',
			'image/png'       => 'png',
			'application/pdf' => 'pdf',
		);
		if ( ! isset( $map[ $mime ] ) || ( 'application/pdf' !== $mime && ! @getimagesize( $f['tmp_name'] ) ) ) {
			$fail( 'This file type is not accepted.' );
		}
		if ( 'preview' !== $mode ) {
			$dir = daan_pay_proof_dir();
			if ( ! is_dir( $dir ) ) {
				wp_mkdir_p( $dir );
			}
			$stored = bin2hex( random_bytes( 16 ) ) . '.' . $map[ $mime ];
			if ( ! move_uploaded_file( $f['tmp_name'], $dir . '/' . $stored ) ) {
				$fail( 'The screenshot could not be saved.' );
			}
			@chmod( $dir . '/' . $stored, 0640 );
		}
	}

	$ok_msg = 'Thank you! We will confirm within 24–48 hours.';
	if ( 'preview' === $mode ) { // dry run: validation only, nothing is written or sent.
		wp_send_json_success( array( 'message' => $ok_msg . ' [preview: nothing was saved]', 'dry' => true ) );
	}

	// Same UTR already given on another order?
	$dups = wc_get_orders(
		array(
			'limit'      => 3,
			'return'     => 'ids',
			'exclude'    => array( $order->get_id() ),
			'meta_query' => array( array( 'key' => '_daan_utr', 'value' => $utr ) ), // phpcs:ignore WordPress.DB.SlowDBQuery
		)
	);

	$order->update_meta_data( '_daan_utr', $utr );
	$order->update_meta_data( '_daan_proof_count', (int) $order->get_meta( '_daan_proof_count' ) + 1 );
	if ( $stored ) {
		$order->update_meta_data( '_daan_proof_file', $stored );
	}
	$note = 'DONOR SAYS PAYMENT IS DONE (not verified yet). UTR: ' . $utr . '.';
	if ( $stored ) {
		$note .= ' Screenshot: <a href="' . esc_url( admin_url( 'admin-post.php?action=daan_proof&order=' . $order->get_id() ) ) . '">open (admins only)</a>.';
	}
	if ( $dups ) {
		$note .= ' WARNING: the same UTR was also given on order(s) #' . implode( ', #', array_map( 'intval', $dups ) ) . '.';
	}
	$order->add_order_note( $note, false ); // private note, no customer e-mail. Status stays on-hold.
	$order->save();

	$body  = '<p>A donor reports that the payment is done. <strong>Please check your bank/UPI statement</strong>, then set the order to Completed.</p>';
	$body .= '<table cellpadding="6" style="border-collapse:collapse;font-family:Arial,sans-serif;font-size:14px">';
	$body .= '<tr><td>Order</td><td><a href="' . esc_url( $order->get_edit_order_url() ) . '">#' . esc_html( $order->get_order_number() ) . '</a></td></tr>';
	$body .= '<tr><td>Amount</td><td>' . esc_html( daan_pay_amount_text( $order ) ) . '</td></tr>';
	$body .= '<tr><td>Method</td><td>' . esc_html( daan_pay_method_label( $order ) ) . '</td></tr>';
	$body .= '<tr><td>UTR</td><td>' . esc_html( $utr ) . '</td></tr>';
	$body .= '<tr><td>Screenshot</td><td>' . ( $stored ? 'yes (open it from the order note)' : 'no' ) . '</td></tr>';
	if ( $dups ) {
		$body .= '<tr><td style="color:#B91C1C">Warning</td><td style="color:#B91C1C">same UTR on order(s) #' . esc_html( implode( ', #', array_map( 'intval', $dups ) ) ) . '</td></tr>';
	}
	$body .= '</table>';
	// Answer the donor first; the e-mail (SMTP takes several seconds) is sent after the response is closed.
	ignore_user_abort( true );
	$json = wp_json_encode( array( 'success' => true, 'data' => array( 'message' => $ok_msg ) ) );
	status_header( 200 );
	header( 'Content-Type: application/json; charset=utf-8' );
	header( 'Content-Length: ' . strlen( $json ) );
	header( 'Connection: close' );
	echo $json; // phpcs:ignore WordPress.Security.EscapeOutput -- JSON built by wp_json_encode.
	if ( function_exists( 'litespeed_finish_request' ) ) {
		litespeed_finish_request();
	} elseif ( function_exists( 'fastcgi_finish_request' ) ) {
		fastcgi_finish_request();
	} else {
		@ob_end_flush();
		@flush();
	}
	wp_mail( daan_pay_notify_recipient(), '[Daan] Payment reported — order #' . $order->get_order_number() . ' ' . daan_pay_amount_text( $order ), $body, array( 'Content-Type: text/html; charset=UTF-8' ) );
	exit;
}

// Admins open screenshots through WordPress (the folder itself is closed to the web).
add_action(
	'admin_post_daan_proof',
	function () {
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			wp_die( 'Not allowed.', '', array( 'response' => 403 ) );
		}
		$order = wc_get_order( isset( $_GET['order'] ) ? absint( $_GET['order'] ) : 0 );
		$file  = $order ? (string) $order->get_meta( '_daan_proof_file' ) : '';
		if ( ! preg_match( '/^[a-f0-9]{32}\.(jpg|png|pdf)$/', $file ) ) {
			wp_die( 'No screenshot.', '', array( 'response' => 404 ) );
		}
		$path = daan_pay_proof_dir() . '/' . $file;
		if ( ! is_file( $path ) ) {
			wp_die( 'No screenshot.', '', array( 'response' => 404 ) );
		}
		$types = array( 'jpg' => 'image/jpeg', 'png' => 'image/png', 'pdf' => 'application/pdf' );
		header( 'Content-Type: ' . $types[ substr( $file, -3 ) ] );
		header( 'Content-Length: ' . filesize( $path ) );
		header( 'X-Content-Type-Options: nosniff' );
		header( 'Cache-Control: private, no-store' );
		readfile( $path );
		exit;
	}
);

/* -------------------------------------------------------------------------
 * (c) "On hold" customer e-mail and (e) receipt link in the "Completed" e-mail
 * ------------------------------------------------------------------------- */

function daan_pay_email_html( $order ) {
	$d      = daan_payment_details();
	$is_upi = daan_pay_is_upi( $order );
	$amount = daan_pay_amount_text( $order );
	$oid    = $order->get_order_number();
	$page   = $order->get_checkout_order_received_url();

	$h  = '<div style="font-family:Arial,sans-serif;font-size:15px;color:#1F2937;line-height:1.55">';
	$h .= '<div style="background:#FFF7ED;border:2px solid #C2410C;border-radius:10px;padding:14px 16px;margin:0 0 16px">';
	$h .= '<p style="margin:0 0 6px;font-size:16px;font-weight:bold;color:#9A3412">Your donation is PENDING — please complete the payment.</p>';
	$h .= '<p style="margin:0;font-size:13px">Your donation is counted only after we receive the payment.</p></div>';
	$h .= '<p style="margin:0 0 10px">Donation <strong>#' . esc_html( $oid ) . '</strong> &nbsp;·&nbsp; Amount <strong>' . esc_html( $amount ) . '</strong></p>';
	$h .= '<p style="margin:0 0 6px"><strong>UPI ID:</strong> ' . esc_html( $d['upi_id'] ) . ' (' . esc_html( $d['payee'] ) . ')</p>';
	$h .= '<p style="margin:14px 0 6px">QR code, the "I have paid" form and full details are here:</p>';
	$h .= '<p style="margin:0 0 6px"><a href="' . esc_url( $page ) . '" style="display:inline-block;background:#C2410C;color:#fff;text-decoration:none;font-weight:bold;padding:12px 18px;border-radius:8px">Open payment page</a></p>';
	$h .= '</div>';
	return $h;
}

/** Echoes the block and returns true when it applies (live mode, pending order). */
function daan_pay_email_intro( $order ) {
	if ( 'live' !== daan_pay_mode() || ! daan_pay_is_pending( $order ) ) {
		return false;
	}
	// UPI QR donations: the plugin's upq_email_html() block is the "bill" (above the order table).
	if ( 'upq_manual_qr' === $order->get_payment_method() && function_exists( 'upq_email_html' ) ) {
		return false;
	}
	echo daan_pay_email_html( $order ); // phpcs:ignore WordPress.Security.EscapeOutput
	return true;
}

add_filter(
	'woocommerce_email_heading_customer_on_hold_order',
	function ( $heading, $order = null ) {
		if ( 'live' === daan_pay_mode() && daan_pay_is_pending( $order ) ) {
			return 'Your donation is PENDING — please complete the payment';
		}
		return $heading;
	},
	20,
	2
);

add_action(
	'woocommerce_email_order_meta',
	function ( $order, $sent_to_admin, $plain_text, $email ) {
		if ( 'live' !== daan_pay_mode() || $sent_to_admin || $plain_text || ! $email || 'customer_completed_order' !== $email->id ) {
			return;
		}
		$url = function_exists( 'daan_receipt_url' ) ? daan_receipt_url( $order ) : '';
		if ( $url ) {
			echo '<p style="margin:16px 0"><a href="' . esc_url( $url ) . '" style="color:#C2410C;font-weight:bold">View or print your receipt</a></p>';
		}
	},
	20,
	4
);

/* -------------------------------------------------------------------------
 * (d) Daily morning digest of on-hold orders (09:00 India time = 03:30 UTC)
 * ------------------------------------------------------------------------- */

function daan_pay_digest_html() {
	$orders = wc_get_orders( array( 'status' => 'on-hold', 'limit' => -1, 'orderby' => 'date', 'order' => 'ASC' ) );
	$now    = time();
	$old    = array();
	$new    = array();
	$withutr = 0;
	foreach ( $orders as $o ) {
		$has = (string) $o->get_meta( '_daan_utr' ) !== '';
		$withutr += $has ? 1 : 0;
		$row = array( 'o' => $o, 'utr' => $has, 'age' => $now - ( $o->get_date_created() ? $o->get_date_created()->getTimestamp() : $now ) );
		if ( $row['age'] > 3 * DAY_IN_SECONDS ) {
			$old[] = $row;
		} else {
			$new[] = $row;
		}
	}
	// Older than 3 days first (those that already sent a UTR on top), then the newer ones.
	usort( $old, function ( $a, $b ) { return ( $b['utr'] <=> $a['utr'] ) ?: ( $b['age'] <=> $a['age'] ); } );
	usort( $new, function ( $a, $b ) { return ( $b['utr'] <=> $a['utr'] ) ?: ( $b['age'] <=> $a['age'] ); } );

	$cap  = 150;
	$rows = array_slice( array_merge( $old, $new ), 0, $cap );
	$h  = '<div style="font-family:Arial,sans-serif;font-size:14px;color:#1F2937">';
	$h .= '<p><strong>' . count( $orders ) . '</strong> on-hold donations · <strong>' . count( $old ) . '</strong> older than 3 days · <strong>' . $withutr . '</strong> with a UTR from the donor.</p>';
	$h .= '<p>Compare each UTR with your bank/UPI statement; if the money is there, open the order and set it to <em>Completed</em> (the donor then gets the receipt e-mail).</p>';
	$h .= '<table cellpadding="6" cellspacing="0" border="1" style="border-collapse:collapse;border-color:#CBD5E1"><tr style="background:#F1F5F9"><th>Order</th><th>Date</th><th>Amount</th><th>Method</th><th>UTR?</th><th>Age</th></tr>';
	foreach ( $rows as $r ) {
		$o   = $r['o'];
		$bg  = $r['age'] > 3 * DAY_IN_SECONDS ? '#FFF7ED' : '#FFFFFF';
		$h  .= '<tr style="background:' . $bg . '"><td><a href="' . esc_url( $o->get_edit_order_url() ) . '">#' . esc_html( $o->get_order_number() ) . '</a></td><td>' . esc_html( $o->get_date_created() ? $o->get_date_created()->date_i18n( 'd M Y' ) : '' ) . '</td><td>' . esc_html( daan_pay_amount_text( $o ) ) . '</td><td>' . esc_html( daan_pay_method_label( $o ) ) . '</td><td>' . ( $r['utr'] ? '<strong>YES</strong>' : 'no' ) . '</td><td>' . (int) floor( $r['age'] / DAY_IN_SECONDS ) . ' d</td></tr>';
	}
	$h .= '</table>';
	if ( count( $orders ) > $cap ) {
		$h .= '<p>… and ' . ( count( $orders ) - $cap ) . ' more: WooCommerce → Orders → On hold.</p>';
	}
	$h .= '</div>';
	return array( 'html' => $h, 'total' => count( $orders ), 'old' => count( $old ), 'utr' => $withutr );
}

add_action(
	'daan_pending_digest',
	function () {
		if ( 'live' !== daan_pay_mode() ) {
			return;
		}
		$d = daan_pay_digest_html();
		if ( 0 === $d['total'] ) {
			return;
		}
		wp_mail( daan_pay_notify_recipient(), '[Daan] ' . $d['total'] . ' on-hold donations (' . $d['old'] . ' older than 3 days, ' . $d['utr'] . ' with UTR)', $d['html'], array( 'Content-Type: text/html; charset=UTF-8' ) );
	}
);

add_action(
	'init',
	function () {
		if ( 'live' === daan_pay_mode() && ! wp_next_scheduled( 'daan_pending_digest' ) ) {
			$t = strtotime( 'today 03:30:00 UTC' );
			if ( $t <= time() ) {
				$t += DAY_IN_SECONDS;
			}
			wp_schedule_event( $t, 'daily', 'daan_pending_digest' );
		}
	}
);

/* -------------------------------------------------------------------------
 * Preview pages (secret token only; nothing is sent or written)
 *   /?daan_preview=TOKEN&daan_show=digest
 *   /?daan_preview=TOKEN&daan_show=email&order=ID
 * ------------------------------------------------------------------------- */

add_action(
	'template_redirect',
	function () {
		if ( 'preview' !== daan_pay_mode() || empty( $_GET['daan_show'] ) ) {
			return;
		}
		nocache_headers();
		header( 'X-Robots-Tag: noindex, nofollow' );
		$show = sanitize_key( wp_unslash( $_GET['daan_show'] ) );
		echo '<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Preview</title></head><body style="margin:20px;background:#fff">';
		if ( 'digest' === $show ) {
			$d = daan_pay_digest_html();
			echo $d['html']; // phpcs:ignore WordPress.Security.EscapeOutput
		} elseif ( 'email' === $show ) {
			$o = wc_get_order( isset( $_GET['order'] ) ? absint( $_GET['order'] ) : 0 );
			if ( daan_pay_is_pending( $o ) ) {
				echo daan_pay_email_html( $o ); // phpcs:ignore WordPress.Security.EscapeOutput
			}
		}
		echo '</body></html>';
		exit;
	},
	1
);
