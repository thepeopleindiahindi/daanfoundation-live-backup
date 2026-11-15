<?php
/**
 * Plugin Name: UPI QR Payment (manual verification)
 * Description: "Pay via QR Code (UPI)" WooCommerce gateway for Daan Foundation. Shows the QR, amount, UPI ID (Copy) and instructions at checkout. Donations go ON HOLD until a human verifies the money. Admin "new order" email gets signed one-time buttons (Payment received / not received); on-hold UPQ donations are escalated after 7 days, every 4 days, never auto-cancelled. "Payment received" sets the donation to COMPLETED.
 * Version: 1.0.0-daan
 * Requires Plugins: woocommerce
 *
 * Based on docs/UNIVERSAL_UPI_QR_Payment_System_Handover.md. Daan changes:
 *  - no upi:// "Pay" button anywhere;
 *  - since 2026-10-31 the handover box (upq-box), the thank-you "Complete your payment" section and
 *    upq_email_html() are used as in the handover (Daan colours, contact line, no caveat/WhatsApp);
 *    the theme's old pending card + "I have paid" UTR form are skipped for this gateway's orders
 *    (inc/payment-instructions.php; older on-hold orders keep their old page). upq_card_html() is kept unused;
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
				'contact'      => array( 'title' => 'Contact phone (shown on the card)', 'type' => 'text', 'default' => '+91 95282 06525' ),
				'instructions' => array( 'title' => 'Instructions', 'type' => 'textarea', 'description' => 'Placeholder: {upi_id}.', 'default' => 'Scan the QR or pay to {upi_id}, enter the exact amount, then submit your UTR / transaction ID below. Your donation stays pending until our team verifies it.' ),
			);
		}

		/** Hidden at checkout until a QR image and a UPI ID are configured. */
		public function is_available() {
			return parent::is_available() && '' !== trim( (string) $this->get_option( 'qr_url' ) ) && '' !== trim( (string) $this->get_option( 'upi_id' ) );
		}

		public function payment_fields() {
			// Live cart total: WooCommerce re-renders this box whenever the checkout refreshes.
			$amount = ( function_exists( 'WC' ) && WC()->cart ) ? WC()->cart->get_total() : '';
			echo upq_box_html( $amount ); // phpcs:ignore WordPress.Security.EscapeOutput -- built from escaped parts.
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

/** UPI QR donation made from the order cutoff on: donor text "Thank you", QR below as "If you haven't paid yet" (2026-11-15). */
function upq_is_new_order( $order ) {
	return upq_is_upi_order( $order ) && function_exists( 'daan_order_after_cutoff' ) && daan_order_after_cutoff( $order );
}

/** The one line donors see on the thank-you page and in the on-hold e-mail. */
function upq_thanks_text() {
	return 'Thank you! We have received your donation request. Our team verifies every UPI payment, and you will receive a confirmation email soon.';
}

function upq_not_paid_text() {
	return 'If you haven\'t paid yet, scan this QR with any UPI app or pay to ' . trim( (string) upq_value( 'upi_id' ) ) . '.';
}

const UPQ_WHATSAPP = '+91 95282 06525';

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

/* ---- Handover box (same markup as qurbanieasy.com, Daan colours) — used at checkout, on /donate/, thank-you page, e-mail ---- */

/** QR image: centred, max width from settings, NOT lazy-loaded (it is in the checkout fold). */
function upq_qr_html( $max_width = 0 ) {
	$url = trim( (string) upq_value( 'qr_url' ) );
	if ( '' === $url ) {
		return '';
	}
	$w  = $max_width ? (int) $max_width : (int) upq_value( 'qr_width', 260 );
	$w  = max( 120, min( 420, $w ) );
	$h  = '';
	$id = attachment_url_to_postid( $url );
	if ( $id ) {
		$m = wp_get_attachment_metadata( $id );
		if ( ! empty( $m['width'] ) && ! empty( $m['height'] ) ) {
			$h = ' height="' . (int) round( $w * $m['height'] / $m['width'] ) . '"';
		}
	}
	return '<p class="upq-qr-wrap" style="text-align:center;margin:12px 0;"><img class="upq-qr" src="' . esc_url( $url ) . '" alt="' . esc_attr( upq_value( 'qr_alt', 'UPI QR code' ) ) . '" width="' . $w . '"' . $h . ' style="display:block;margin:0 auto;width:100%;max-width:' . $w . 'px;height:auto;" loading="eager" decoding="async" fetchpriority="high"></p>';
}

/** UPI ID as text with a Copy button (copies exactly data-upi). */
function upq_upi_html() {
	$upi = trim( (string) upq_value( 'upi_id' ) );
	if ( '' === $upi ) {
		return '';
	}
	return '<p class="upq-upi" style="text-align:center;margin:8px 0;">UPI ID: <strong class="upq-upi-id">' . esc_html( $upi ) . '</strong> <button type="button" class="upq-copy" data-upi="' . esc_attr( $upi ) . '" aria-label="Copy UPI ID ' . esc_attr( $upi ) . '" style="margin-left:6px;padding:4px 12px;border:1px solid #047857;border-radius:4px;background:#fff;color:#047857;font-weight:700;cursor:pointer;">Copy</button></p>';
}

/** Payee-name note directly under the UPI ID ('' while the setting is empty). */
function upq_payee_html( $style = '' ) {
	$note = trim( (string) upq_value( 'payee_note' ) );
	if ( '' === $note ) {
		return '';
	}
	return '<p class="upq-payee" style="' . esc_attr( $style ?: 'text-align:center;margin:4px 0 10px;font-size:14px;line-height:1.5;' ) . '">' . esc_html( $note ) . '</p>';
}

/** Contact line (Daan addition; no WhatsApp). */
function upq_contact_html( $style = '' ) {
	$tel = trim( (string) upq_value( 'contact' ) );
	if ( '' === $tel ) {
		return '';
	}
	return '<p class="upq-contact" style="' . esc_attr( $style ?: 'text-align:center;margin:8px 0 0;font-size:14px;' ) . '">Contact: <a href="tel:' . esc_attr( preg_replace( '/[^0-9+]/', '', $tel ) ) . '">' . esc_html( $tel ) . '</a></p>';
}

/** The handover payment box. $amount_html '' = no amount line (the /donate/ form has no cart). */
function upq_box_html( $amount_html = '' ) {
	$h  = '<div class="upq-box">';
	$d  = (string) upq_value( 'description' );
	if ( '' !== $d ) {
		$h .= wp_kses_post( wpautop( $d ) );
	}
	if ( '' !== $amount_html ) {
		$h .= '<p class="upq-amount" style="text-align:center;margin:8px 0;font-size:16px;">Amount to pay: <strong>' . wp_kses_post( $amount_html ) . '</strong></p>';
	}
	$h .= upq_qr_html() . upq_upi_html() . upq_payee_html();
	$ins = upq_instructions();
	if ( '' !== $ins ) {
		$h .= '<p class="upq-instructions"><strong>' . esc_html( $ins ) . '</strong></p>';
	}
	return $h . upq_contact_html() . '</div>';
}

/** Copy-button script + small styles: checkout, thank-you page and /donate/ only. */
function upq_needs_assets() {
	return ( function_exists( 'is_checkout' ) && is_checkout() ) || is_page_template( 'page-donate.php' ) || is_page( 'donate' );
}

add_action( 'wp_footer', function () {
	if ( ! upq_needs_assets() ) {
		return;
	}
	echo '<style>.upq-box{text-align:left}.upq-box p{margin:0 0 8px}.upq-box p,.upq-thanks p{text-align:left;hyphens:none;overflow-wrap:anywhere}.upq-instructions{font-size:14px;line-height:1.55}.payment_method_upq_manual_qr .payment_box{background:#FFF7ED!important;border:1px solid #FED7AA}.payment_method_upq_manual_qr .payment_box::before{border-bottom-color:#FFF7ED!important}.upq-upi-id{overflow-wrap:anywhere}.upq-thanks{border:1px solid #E2E8F0;border-left:4px solid #C2410C;border-radius:8px;padding:16px 18px;margin:0 0 24px;background:#fff}.upq-thanks h2{margin:0 0 8px;font-size:1.15rem}</style>';
	echo '<script>(function(){document.addEventListener("click",function(e){var b=e.target.closest&&e.target.closest(".upq-copy");if(!b){return;}e.preventDefault();var v=b.getAttribute("data-upi")||"";var done=function(){b.textContent="Copied";setTimeout(function(){b.textContent="Copy";},2000);};if(navigator.clipboard&&window.isSecureContext){navigator.clipboard.writeText(v).then(done,function(){fb(v,done);});}else{fb(v,done);}function fb(t,cb){var a=document.createElement("textarea");a.value=t;a.setAttribute("readonly","");a.style.position="absolute";a.style.left="-9999px";document.body.appendChild(a);a.select();try{document.execCommand("copy");}catch(x){}document.body.removeChild(a);cb();}});})();</script>';
}, 50 );

/* Thank-you page: QR + amount + donation number + instructions, only while payment is still unverified. */
add_action( 'woocommerce_thankyou_' . UPQ_GATEWAY_ID, function ( $order_id ) {
	$order = wc_get_order( $order_id );
	if ( ! $order || ! $order->has_status( array( 'on-hold', 'pending' ) ) || upq_is_new_order( $order ) ) {
		return; // New donations: the smaller box below the donation details (next hook).
	}
	echo '<section class="upq-thanks"><h2>Complete your payment</h2>';
	echo '<p><strong>Donation number: #' . esc_html( $order->get_order_number() ) . '</strong></p>';
	echo '<p class="upq-amount" style="text-align:center;margin:8px 0;font-size:16px;">Amount to pay: <strong>' . wp_kses_post( $order->get_formatted_order_total() ) . '</strong></p>';
	echo upq_qr_html() . upq_upi_html() . upq_payee_html(); // phpcs:ignore WordPress.Security.EscapeOutput
	echo '<p class="upq-instructions">' . esc_html( upq_instructions() ) . '</p>';
	echo upq_contact_html(); // phpcs:ignore WordPress.Security.EscapeOutput
	echo '</section>';
}, 20 );

/* New donations: "If you haven't paid yet" box below the donation details (WooCommerce prints them at priority 10). */
add_action( 'woocommerce_thankyou', function ( $order_id ) {
	$order = wc_get_order( $order_id );
	if ( ! $order || ! upq_is_new_order( $order ) || ! $order->has_status( array( 'on-hold', 'pending' ) ) ) {
		return;
	}
	echo '<section class="upq-thanks upq-thanks--small"><h2>If you haven\'t paid yet</h2>';
	echo '<p>' . esc_html( upq_not_paid_text() ) . '</p>';
	echo '<p class="upq-amount" style="text-align:center;margin:8px 0;font-size:16px;">Donation #' . esc_html( $order->get_order_number() ) . ' &middot; Amount: <strong>' . wp_kses_post( $order->get_formatted_order_total() ) . '</strong></p>';
	echo upq_qr_html( 180 ) . upq_upi_html() . upq_payee_html(); // phpcs:ignore WordPress.Security.EscapeOutput
	echo upq_contact_html(); // phpcs:ignore WordPress.Security.EscapeOutput
	echo '</section>';
}, 20 );

/** "Complete your payment" block for customer e-mails (inline styles only). '' once paid. */
function upq_email_html( $order ) {
	if ( ! upq_is_upi_order( $order ) || ! $order->has_status( array( 'on-hold', 'pending' ) ) ) {
		return '';
	}
	$p    = 'margin:0 0 10px;font-size:15px;line-height:1.6;color:#1F2937;text-align:left;';
	$url  = trim( (string) upq_value( 'qr_url' ) );
	$upi  = trim( (string) upq_value( 'upi_id' ) );
	$html = '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="width:100%;margin:0 0 20px;"><tr><td style="border:1px solid #FED7AA;background:#FFF7ED;border-radius:8px;padding:16px;box-sizing:border-box;">';
	$html .= '<p style="' . $p . '"><strong>Complete your payment.</strong> Scan this QR code with any UPI app, or pay to the UPI ID below.</p>';
	if ( '' !== $url ) {
		$html .= '<p style="margin:0 0 10px;text-align:center;"><img src="' . esc_url( $url ) . '" alt="' . esc_attr( upq_value( 'qr_alt', 'UPI QR code' ) ) . '" width="240" style="display:block;margin:0 auto;width:240px;max-width:100%;height:auto;border:1px solid #E2E8F0;border-radius:6px;"></p>';
	}
	if ( '' !== $upi ) {
		$html .= '<p style="' . $p . 'text-align:center;">UPI ID: <strong style="font-size:16px;word-break:break-all;">' . esc_html( $upi ) . '</strong></p>';
		$html .= upq_payee_html( 'margin:0 0 10px;font-size:14px;line-height:1.5;color:#1F2937;text-align:center;' );
	}
	$html .= '<p style="' . $p . '"><strong>Donation number: #' . esc_html( $order->get_order_number() ) . '</strong> &middot; Amount: <strong>' . wp_kses_post( $order->get_formatted_order_total() ) . '</strong></p>';
	$html .= '<p style="' . $p . '">' . esc_html( upq_instructions() ) . '</p>';
	$html .= upq_contact_html( 'margin:0;font-size:14px;line-height:1.5;color:#1F2937;' );
	return $html . '</td></tr></table>';
}

/** New donations: small "If you haven't paid yet" block for the customer e-mail, below the donation details. '' once paid. */
function upq_email_small_html( $order ) {
	if ( ! upq_is_new_order( $order ) || ! $order->has_status( array( 'on-hold', 'pending' ) ) ) {
		return '';
	}
	$p    = 'margin:0 0 8px;font-size:14px;line-height:1.6;color:#1F2937;text-align:left;';
	$url  = trim( (string) upq_value( 'qr_url' ) );
	$upi  = trim( (string) upq_value( 'upi_id' ) );
	$html = '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="width:100%;margin:16px 0 20px;"><tr><td style="border:1px solid #E5E7EB;background:#F9FAFB;border-radius:8px;padding:14px;box-sizing:border-box;">';
	$html .= '<p style="' . $p . '">' . esc_html( upq_not_paid_text() ) . '</p>';
	if ( '' !== $url ) {
		$html .= '<p style="margin:0 0 8px;text-align:center;"><img src="' . esc_url( $url ) . '" alt="' . esc_attr( upq_value( 'qr_alt', 'UPI QR code' ) ) . '" width="160" style="display:block;margin:0 auto;width:160px;max-width:100%;height:auto;border:1px solid #E2E8F0;border-radius:6px;"></p>';
	}
	if ( '' !== $upi ) {
		$html .= '<p style="' . $p . 'text-align:center;">UPI ID: <strong style="word-break:break-all;">' . esc_html( $upi ) . '</strong></p>';
		$html .= upq_payee_html( 'margin:0 0 8px;font-size:13px;line-height:1.5;color:#1F2937;text-align:center;' );
	}
	$html .= '<p style="' . $p . 'text-align:center;">Donation #' . esc_html( $order->get_order_number() ) . ' &middot; Amount: <strong>' . wp_kses_post( $order->get_formatted_order_total() ) . '</strong></p>';
	$html .= upq_contact_html( 'margin:0;font-size:13px;line-height:1.5;color:#1F2937;text-align:center;' );
	return $html . '</td></tr></table>';
}

add_action( 'woocommerce_email_after_order_table', function ( $order, $sent_to_admin, $plain_text, $email = null ) {
	if ( $sent_to_admin || ! upq_is_new_order( $order ) || ! $order->has_status( array( 'on-hold', 'pending' ) ) ) {
		return;
	}
	if ( $email && ! in_array( $email->id, array( 'customer_on_hold_order', 'customer_invoice' ), true ) ) {
		return; // Only the "Thank you" (on-hold) mail and a manual invoice carry the QR.
	}
	if ( $plain_text ) {
		echo "\n" . esc_html( upq_not_paid_text() ) . "\nDonation number: #" . esc_html( $order->get_order_number() ) . "\n"; // phpcs:ignore
		return;
	}
	echo upq_email_small_html( $order ); // phpcs:ignore WordPress.Security.EscapeOutput
}, 20, 4 );

/* E-mails: customer on-hold / pending get the QR block above the order table (the "bill"); admin e-mails get the buttons. */
add_action( 'woocommerce_email_before_order_table', function ( $order, $sent_to_admin, $plain_text ) {
	if ( ! upq_is_upi_order( $order ) ) {
		return;
	}
	if ( $sent_to_admin ) {
		if ( ! $plain_text ) {
			echo upq_admin_buttons_block( $order ); // phpcs:ignore WordPress.Security.EscapeOutput
		}
		return;
	}
	if ( upq_is_new_order( $order ) ) {
		return; // New donations: small block after the details (above).
	}
	if ( $plain_text ) {
		if ( $order->has_status( array( 'on-hold', 'pending' ) ) ) {
			echo "\nPay by UPI: " . esc_html( upq_value( 'upi_id' ) ) . "\nDonation number: #" . esc_html( $order->get_order_number() ) . "\n" . esc_html( upq_instructions() ) . "\n"; // phpcs:ignore
		}
		return;
	}
	echo upq_email_html( $order ); // phpcs:ignore WordPress.Security.EscapeOutput
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
	if ( ! upq_is_upi_order( $order ) ) {
		return array();
	}
	// An auto-cancelled donation can still be marked as paid for 7 days; one an admin cancelled cannot.
	if ( function_exists( 'daan_ot_auto_cancel_open' ) && daan_ot_auto_cancel_open( $order ) ) {
		return array( 'pay_ok' );
	}
	if ( 'unpaid' !== upq_state( $order ) ) {
		return array();
	}
	return 'warning' === $context ? array( 'pay_ok', 'pay_no', 'cancel' ) : array( 'pay_ok', 'pay_no' );
}

/** label, confirmation question, colour. */
function upq_action_defs() {
	return array(
		'pay_ok' => array( 'Payment received', 'mark donation #%s as PAYMENT RECEIVED (it becomes Completed and the donor gets the Completed e-mail with the receipt link)', '#18A957' ),
		'pay_no' => array( 'Payment not received', 'record that the payment for donation #%s was NOT received (it stays On hold; the donor gets one e-mail asking for the screenshot or UTR on WhatsApp within 24 hours)', '#B3261E' ),
		'cancel' => array( 'Cancel donation', 'CANCEL donation #%s', '#B3261E' ),
	);
}

function upq_record_action( $order, $action, $via ) {
	$d = upq_action_defs();
	$order->update_meta_data( '_upq_last_action', array( 'label' => isset( $d[ $action ] ) ? $d[ $action ][0] : $action, 'by' => $via, 'at' => time() ) );
	$order->save_meta_data();
}

/** What happens after "Payment not received", when the 24-hour rule applies to this order. */
function upq_timer_text( $order ) {
	if ( ! function_exists( 'daan_ot_automation_on' ) || ! daan_ot_automation_on() || ! daan_ot_timer_in_scope( $order ) ) {
		return '';
	}
	if ( daan_ot_autocancel_paused() ) {
		return ' Auto-cancel is paused.';
	}
	$at = (int) $order->get_meta( '_upq_pay_not_received_at' );
	return ' It will be cancelled automatically' . ( $at ? ' at ' . wp_date( 'j M, g:i A', $at + DAAN_OT_CANCEL_DELAY, new DateTimeZone( 'Asia/Kolkata' ) ) . ' IST' : ' 24 hours after this' ) . ' unless Payment received is pressed first.';
}

/** "Payment received" stays reachable after "Payment not received": a fresh signed link behind a button. */
function upq_pay_ok_form( $order ) {
	$token = upq_token_make( $order->get_id(), 'pay_ok' );
	if ( '' === $token ) {
		return '';
	}
	$defs = upq_action_defs();
	return '<form method="post" action="' . esc_url( home_url( '/' ) ) . '" style="margin-top:16px;"><input type="hidden" name="upq_act_token" value="' . esc_attr( $token ) . '"><button type="submit" style="width:100%;padding:14px;border:0;border-radius:6px;background:' . $defs['pay_ok'][2] . ';color:#fff;font-weight:700;font-size:16px;cursor:pointer;">Yes, ' . esc_html( $defs['pay_ok'][0] ) . '</button></form>';
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
				if ( ! $order->get_meta( '_upq_pay_not_received_at' ) ) { // A second press must not add time.
					$order->update_meta_data( '_upq_pay_not_received_at', time() );
				}
				$order->add_order_note( 'Payment NOT received, via ' . $via . '.' );
				if ( $order->has_status( 'pending' ) ) {
					$order->update_status( 'on-hold', 'Payment not received (admin ' . $via . ').' );
				} else {
					$order->save();
				}
				$res = array( true, 'Donation #' . $no . ' stays On hold. A note was added.' . upq_timer_text( $order ) . upq_not_found_mail( $order ), 'done' );
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

/* ---- "We could not find your payment": donor e-mail on the first "Payment not received" (2026-11-15) ---- */

const UPQ_NF_EMAIL_ID = 'customer_payment_not_found';
const UPQ_NF_META     = '_upq_not_found_mail'; // time of the one send; never cleared, so a second press sends nothing.

add_filter( 'woocommerce_email_classes', function ( $emails ) {
	if ( ! class_exists( 'UPQ_Email_Payment_Not_Found' ) && class_exists( 'WC_Email' ) ) {
		/** Same WooCommerce layout (header, card, footer) as the other donor mails; tracked by the mail retry queue. */
		class UPQ_Email_Payment_Not_Found extends WC_Email {
			public function __construct() {
				$this->id             = UPQ_NF_EMAIL_ID;
				$this->customer_email = true;
				$this->title          = 'Payment not found (donor)';
				$this->description    = 'Sent once to the donor when "Payment not received" is first pressed on a UPI QR donation.';
				$this->placeholders   = array( '{order_number}' => '', '{order_date}' => '' );
				parent::__construct();
			}
			public function get_default_subject() {
				return 'We could not find your payment — donation #{order_number}';
			}
			public function get_default_heading() {
				return 'We could not find your payment';
			}
			public function trigger( $order_id ) {
				$this->setup_locale();
				$order        = wc_get_order( $order_id );
				$this->object = $order;
				$ok           = false;
				if ( $order ) {
					$this->recipient                     = $order->get_billing_email();
					$this->placeholders['{order_number}'] = $order->get_order_number();
					$this->placeholders['{order_date}']   = wc_format_datetime( $order->get_date_created() );
					if ( $this->is_enabled() && $this->get_recipient() ) {
						$ok = $this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
					}
				}
				$this->restore_locale();
				return $ok;
			}
			private function amount() {
				return html_entity_decode( wp_strip_all_tags( wc_price( $this->object->get_total(), array( 'currency' => $this->object->get_currency() ) ) ), ENT_QUOTES, 'UTF-8' );
			}
			public function body_text() {
				$no = $this->object->get_order_number();
				return array(
					'We could not find your payment for donation #' . $no . ' of ' . $this->amount() . '.',
					'If you have already paid, please send the payment screenshot or UTR on WhatsApp ' . UPQ_WHATSAPP . ' within 24 hours. Otherwise this donation will be cancelled.',
				);
			}
			public function get_content_html() {
				$name = trim( (string) $this->object->get_billing_first_name() );
				$t    = $this->body_text();
				$wa   = 'https://wa.me/' . preg_replace( '/[^0-9]/', '', UPQ_WHATSAPP );
				ob_start();
				do_action( 'woocommerce_email_header', $this->get_heading(), $this );
				echo '<p>Dear ' . esc_html( '' !== $name ? $name : 'Donor' ) . ',</p>';
				echo '<p>' . esc_html( $t[0] ) . '</p>';
				echo '<p>' . str_replace( esc_html( UPQ_WHATSAPP ), '<a href="' . esc_url( $wa ) . '">' . esc_html( UPQ_WHATSAPP ) . '</a>', esc_html( $t[1] ) ) . '</p>'; // phpcs:ignore WordPress.Security.EscapeOutput
				do_action( 'woocommerce_email_footer', $this );
				return ob_get_clean();
			}
			public function get_content_plain() {
				$name = trim( (string) $this->object->get_billing_first_name() );
				return 'Dear ' . ( '' !== $name ? $name : 'Donor' ) . ",\n\n" . implode( "\n\n", $this->body_text() ) . "\n";
			}
		}
	}
	if ( class_exists( 'UPQ_Email_Payment_Not_Found' ) ) {
		$emails['UPQ_Email_Payment_Not_Found'] = new UPQ_Email_Payment_Not_Found();
	}
	return $emails;
} );

/** First "Payment not received" on a new UPI QR donation: one e-mail to the donor, recorded in an order note. Returns text for the admin page. */
function upq_not_found_mail( $order ) {
	$order = wc_get_order( $order->get_id() );
	if ( ! $order || ! upq_is_new_order( $order ) || ! $order->has_status( 'on-hold' ) || $order->get_meta( UPQ_NF_META ) || ! $order->get_billing_email() ) {
		return '';
	}
	// Flag first: a second press or a parallel request never sends a second copy. A failed send goes to the retry queue.
	$order->update_meta_data( UPQ_NF_META, time() );
	$order->save_meta_data();
	$emails = WC()->mailer()->get_emails();
	$ok     = isset( $emails['UPQ_Email_Payment_Not_Found'] ) && $emails['UPQ_Email_Payment_Not_Found']->trigger( $order->get_id() );
	$order  = wc_get_order( $order->get_id() );
	$order->add_order_note( $ok ? 'Donor e-mail sent: "We could not find your payment" (screenshot or UTR on WhatsApp within 24 hours).' : 'Donor e-mail "We could not find your payment" did not go out now; it is in the retry queue.', false );
	return $ok ? ' The donor was e-mailed once (screenshot or UTR on WhatsApp within 24 hours).' : ' The donor e-mail did not go out now; it will be tried again.';
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
		$out .= '<a class="upq-btn" href="' . esc_url( $u ) . '" style="display:inline-block;margin:0 8px 8px 0;padding:11px 16px;background:' . $defs[ $a ][2] . ';color:#ffffff;font-family:Arial,Helvetica,sans-serif;font-weight:700;font-size:14px;text-decoration:none;border-radius:6px;">' . esc_html( $defs[ $a ][0] ) . '</a>';
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
		if ( 'pay_no' === $action ) {
			upq_page( 'Payment not received', '<h2 style="margin:0 0 8px;">Payment not received is already recorded</h2><p style="line-height:1.6;">No change was made. If the money has arrived, press the button below.' . esc_html( upq_timer_text( $order ) ) . '</p>' . upq_pay_ok_form( $order ) );
		}
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
			. ( 'pay_no' === $action ? '<p style="margin:14px 0 0;font-size:13px;color:#5a5548;">' . esc_html( trim( upq_timer_text( $order ) ) ) . '</p>' : '' ) . '<p style="margin:14px 0 0;font-size:13px;color:#5a5548;">Not you? Just close this page; nothing happens.</p>'
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
	upq_page( $ok ? 'Done' : 'Not done', '<h2 style="margin:0 0 8px;color:' . ( $ok ? '#0E7A3E' : '#B3261E' ) . ';">' . ( $ok ? 'Done' : 'Not done' ) . '</h2><p style="line-height:1.6;">' . esc_html( $msg ) . '</p>' . ( $ok && 'pay_no' === $action ? upq_pay_ok_form( wc_get_order( $oid ) ) : '' ), $ok ? 200 : 409 );
}, 0 );

/* =====================================================================
 * 6. On-hold watcher (UPQ donations only): warn after 7 days, then every 4 days. Auto-cancel lives in plugin daan-order-tools.
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
	$orders = wc_get_orders( array( 'limit' => 100, 'status' => array( 'on-hold' ), 'payment_method' => UPQ_GATEWAY_ID, 'date_created' => daan_order_cutoff_range() ) );
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
		$html = '<p style="font-family:Arial,sans-serif;font-size:15px;line-height:1.6;">Donation <b>#' . esc_html( $no ) . '</b> (' . esc_html( $o->get_formatted_billing_full_name() ) . ', ' . esc_html( $o->get_billing_phone() ) . ', ' . wp_kses_post( $o->get_formatted_order_total() ) . ') has been <b>on hold since ' . esc_html( wp_date( 'j M Y', $since ) ) . '</b>. With no button pressed it is cancelled 6 hours after its second digest; after "Payment not received", after 24 hours. Please check the UPI/bank app and choose:</p>'
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
