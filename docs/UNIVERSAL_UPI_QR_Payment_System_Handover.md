# Universal Handover: UPI QR Payment System for WooCommerce

**Source:** the live system on qurbanieasy.com (October 2026), rewritten brand-neutral so it can be dropped into any WordPress + WooCommerce site.
**Audience:** whoever (a developer or Claude Code) sets this up on the next website.
**Result:** one plugin file that gives:

1. A checkout payment method **"Pay via QR Code (UPI)"**, which shows:
   - the QR image,
   - the amount,
   - the UPI ID with a **Copy** button,
   - a payee-name note,
   - receipt instructions and a safety warning.
2. The order goes **On hold** (never auto-confirmed). The customer sees the same QR box on the **thank-you page** and in the **customer emails** (the "bill").
3. The admin gets a **"New booking" email with one-tap buttons**: **[Payment received] [Payment not received]**.
   - Each button is a **signed, one-time, 14-day link**.
   - It opens a **Confirm page** first, so email scanners can't trigger it.
4. **One state machine** decides which buttons are allowed for the order's *current* status. An old link pressed later says **"Already done …"** and changes nothing.
5. **On-hold watcher:** after 7 days on hold, the admin gets a warning email with **[Payment received] [Not received] [Cancel]**, repeated every 4 days. Bookings are **never auto-cancelled**.

No payment API, no keys from a bank, no card data. Money is checked by a human in the UPI/bank app.

---

## 0. Why it is built this way (lessons from the live site)

| Lesson | What we do |
|---|---|
| UPI apps (PhonePe/GPay/Paytm) **decline "Pay" deep-link buttons** (`upi://pay?...`) from websites ("declined for security reasons", tested 27 Oct 2026). | Static **QR image + UPI ID text + Copy button** only. No `upi://` buttons. |
| An old UPI plugin auto-completed orders on a screenshot upload, so customers got "completed" emails before anyone saw the money. | Order goes **On hold**. Only a human presses **Payment received**. |
| The payee name inside the QR (company legal name) differs from the brand name and worried customers. | A **payee note** under the UPI ID explains it. |
| Email links get opened by Gmail/antivirus scanners. | A link only shows a **Confirm page (GET)**. The action runs on **POST** ("Yes" button). |
| Buttons stayed in old emails after the order changed, and people pressed them again. | **One state machine**. Every link re-checks the live status. Stale = "Already done, by …, at …". |
| A failed action used to burn the link silently. | The link is marked used **only after a real outcome**. A failure adds an order note and emails the admin. |
| Page cache (LiteSpeed etc.) can cache the confirm page. | `DONOTCACHEPAGE`, `nocache_headers()`, `X-LiteSpeed-Cache-Control: no-cache`, `noindex`. |
| People sent money to the WhatsApp number. | A **warning text**: "the WhatsApp number is only for the receipt". |

---

## 1. What you need before starting

1. **Your official UPI QR image** from your bank or UPI merchant app (PNG). Upload it to **Media → Add New** and copy its URL.
2. **Your UPI ID**, exactly the one inside the QR (scan the QR with a phone to check).
3. The **payee name** the QR shows (for example, the company's legal name).
4. A **WhatsApp number** and an **email** for receipts.
5. The **admin email** that receives new-order emails: WooCommerce → Settings → Emails → New order → Recipient.
6. An optional **owner CC email**.
7. **A secret** for signing links. Generate it once:
   - `wp eval 'echo wp_generate_password(64,false);' --allow-root`
   - Put it **only** in `wp-config.php` (never in git or chat):
     ```php
     define( 'UPQ_LINK_SECRET', 'paste-the-64-char-value-here' );
     define( 'UPQ_OWNER_CC', 'owner@example.com' ); // optional, remove the line if not needed
     ```
   - Without the secret the payment method still works, but the admin buttons are hidden (safe default).

---

## 2. Install (step by step)

1. Create the folder `wp-content/plugins/upi-qr-payment/`.
2. Save the code from section 3 as `wp-content/plugins/upi-qr-payment/upi-qr-payment.php`.
3. Check the syntax with `php -l wp-content/plugins/upi-qr-payment/upi-qr-payment.php`.
4. Activate it, either with `wp plugin activate upi-qr-payment --allow-root` or from Plugins → Activate.
5. Go to **WooCommerce → Settings → Payments → Pay via QR Code (UPI)** and fill in:
   - Enable,
   - QR image URL,
   - UPI ID,
   - payee name and payee note,
   - WhatsApp, email,
   - instructions and warning.
   The method stays **hidden at checkout until the QR URL and the UPI ID are filled**.
6. **If the site has a Content-Security-Policy:** allow `img-src` for your own domain (where the QR is uploaded). Nothing external is needed.
7. Purge the page cache, for example `wp litespeed-purge all`.
8. Run the tests in section 5.

**Rename for a new brand (optional):** replace the prefix `upq_` / `UPQ_` and the gateway id `upq_manual_qr` everywhere with your own (for example `abc_`). Do this **before** the first real order, because the gateway id is saved in orders.

---

## 3. The code: `upi-qr-payment.php` (complete, one file)

```php
<?php
/**
 * Plugin Name: UPI QR Payment (manual verification)
 * Description: "Pay via QR Code (UPI)" WooCommerce gateway. Shows the QR, amount, UPI ID (Copy), payee note and receipt instructions at checkout, on the thank-you page and in customer emails. Orders go ON HOLD until a human verifies the money. Admin "new order" email gets signed one-time buttons (Payment received / not received); on-hold orders are escalated after 7 days, every 4 days, never auto-cancelled.
 * Version: 1.0.0
 * Requires Plugins: woocommerce
 *
 * Secrets: UPQ_LINK_SECRET (required for buttons) and UPQ_OWNER_CC (optional) in wp-config.php only.
 */

defined( 'ABSPATH' ) || exit;

define( 'UPQ_GATEWAY_ID', 'upq_manual_qr' );

/* =====================================================================
 * 1. Gateway
 * ================================================================== */

add_filter( 'woocommerce_payment_gateways', function ( $gateways ) {
	$gateways[] = 'UPQ_Gateway';
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
			$this->method_description = 'Manual UPI QR payment. The order stays on hold until your team verifies the money in the UPI/bank app.';
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
				'qr_url'       => array( 'title' => 'QR image URL', 'type' => 'text', 'description' => 'Media Library URL of your official QR image. The method stays hidden until this and the UPI ID are filled.', 'default' => '' ),
				'qr_alt'       => array( 'title' => 'QR image alt text', 'type' => 'text', 'default' => 'UPI QR code to pay for your order' ),
				'qr_width'     => array( 'title' => 'QR display width (px)', 'type' => 'number', 'default' => '260', 'custom_attributes' => array( 'min' => '120', 'max' => '420' ) ),
				'upi_id'       => array( 'title' => 'UPI ID (shown with a Copy button)', 'type' => 'text', 'description' => 'Must be the same address as inside the QR code.', 'default' => '' ),
				'payee_name'   => array( 'title' => 'Payee name inside the QR (reference only)', 'type' => 'text', 'default' => '' ),
				'payee_note'   => array( 'title' => 'Payee-name note (shown under the UPI ID)', 'type' => 'textarea', 'default' => 'Your UPI app will show the payee name of our registered business. This is correct.' ),
				'whatsapp'     => array( 'title' => 'Receipt WhatsApp number', 'type' => 'text', 'default' => '' ),
				'email'        => array( 'title' => 'Receipt email', 'type' => 'email', 'default' => '' ),
				'instructions' => array( 'title' => 'Receipt instructions', 'type' => 'textarea', 'description' => 'Placeholders: {upi_id}, {whatsapp}, {email}.', 'default' => 'Scan the QR or pay to {upi_id}, enter the exact order amount, then send the payment screenshot with the UPI transaction ID and your order number on WhatsApp {whatsapp} or to {email}. Your order stays on hold until our team verifies the payment.' ),
				'caveat'       => array( 'title' => 'Warning text', 'type' => 'textarea', 'default' => 'The WhatsApp number is only for sending the receipt. Please do not send money to it; pay only through the QR code or UPI ID shown here.' ),
			);
		}

		/** Hidden at checkout until a QR image and a UPI ID are configured. */
		public function is_available() {
			return parent::is_available() && '' !== trim( (string) $this->get_option( 'qr_url' ) ) && '' !== trim( (string) $this->get_option( 'upi_id' ) );
		}

		public function payment_fields() {
			echo '<div class="upq-box">';
			if ( $this->description ) {
				echo wp_kses_post( wpautop( $this->description ) );
			}
			if ( function_exists( 'WC' ) && WC()->cart ) {
				// Live cart total: WooCommerce re-renders this box whenever the checkout refreshes.
				echo '<p class="upq-amount" style="text-align:center;margin:8px 0;font-size:16px;">Amount to pay: <strong>' . WC()->cart->get_total() . '</strong></p>'; // phpcs:ignore WordPress.Security.EscapeOutput
			}
			echo upq_qr_html(); // phpcs:ignore WordPress.Security.EscapeOutput
			echo upq_upi_html(); // phpcs:ignore WordPress.Security.EscapeOutput
			echo upq_payee_html(); // phpcs:ignore WordPress.Security.EscapeOutput
			$instructions = upq_instructions();
			if ( $instructions ) {
				echo '<p class="upq-instructions"><strong>' . esc_html( $instructions ) . '</strong></p>';
			}
			$caveat = $this->get_option( 'caveat' );
			if ( $caveat ) {
				echo '<p class="upq-caveat">' . esc_html( $caveat ) . '</p>';
			}
			echo '</div>';
		}

		public function process_payment( $order_id ) {
			$order = wc_get_order( $order_id );
			if ( ! $order ) {
				return array( 'result' => 'failure' );
			}
			$order->update_meta_data( '_upq_receipt_pending', 'yes' );
			$order->update_status( 'on-hold', 'Awaiting UPI payment receipt. Check the money in the UPI/bank app, then press Payment received.' );
			wc_reduce_stock_levels( $order_id );
			WC()->cart->empty_cart();
			return array(
				'result'   => 'success',
				'redirect' => $this->get_return_url( $order ),
			);
		}
	}
}, 20 );

/* =====================================================================
 * 2. Display helpers (checkout, thank-you page, emails)
 * ================================================================== */

/** Saved gateway settings (works outside the gateway class). */
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

/** Receipt instructions with {upi_id} / {whatsapp} / {email} filled in. */
function upq_instructions() {
	$text = (string) upq_value( 'instructions' );
	if ( '' === $text ) {
		return '';
	}
	return strtr( $text, array(
		'{upi_id}'   => (string) upq_value( 'upi_id' ),
		'{whatsapp}' => (string) upq_value( 'whatsapp' ),
		'{email}'    => (string) upq_value( 'email' ),
	) );
}

/** QR image: centred, max width from settings, NOT lazy-loaded (it is in the checkout fold). */
function upq_qr_html( $max_width = 0 ) {
	$url = trim( (string) upq_value( 'qr_url' ) );
	if ( '' === $url ) {
		return '';
	}
	$w = $max_width ? (int) $max_width : (int) upq_value( 'qr_width', 260 );
	$w = max( 120, min( 420, $w ) );
	$h = '';
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
	return '<p class="upq-upi" style="text-align:center;margin:8px 0;">UPI ID: <strong class="upq-upi-id">' . esc_html( $upi ) . '</strong> <button type="button" class="upq-copy" data-upi="' . esc_attr( $upi ) . '" aria-label="Copy UPI ID ' . esc_attr( $upi ) . '" style="margin-left:6px;padding:4px 12px;border:1px solid #0E7A3E;border-radius:4px;background:#fff;color:#0E7A3E;font-weight:700;cursor:pointer;">Copy</button></p>';
}

/** Payee-name note directly under the UPI ID. */
function upq_payee_html( $style = '' ) {
	$note = trim( (string) upq_value( 'payee_note' ) );
	if ( '' === $note ) {
		return '';
	}
	return '<p class="upq-payee" style="' . esc_attr( $style ?: 'text-align:center;margin:4px 0 10px;font-size:14px;line-height:1.5;' ) . '">' . esc_html( $note ) . '</p>';
}

/** Copy-button script + small styles on checkout / thank-you pages only. */
add_action( 'wp_footer', function () {
	if ( ! function_exists( 'is_checkout' ) || ! is_checkout() ) {
		return;
	}
	echo '<style>.upq-box{text-align:left}.upq-instructions{font-size:14px;line-height:1.55}.upq-caveat{font-size:13px;color:#8A4B00;background:#FFF8E8;border:1px solid #F0D9A8;border-radius:6px;padding:8px 10px}.upq-thanks{border:1px solid #D9E3DC;border-left:4px solid #D4A017;border-radius:8px;padding:16px 18px;margin:0 0 24px;background:#fff}.upq-thanks h2{margin:0 0 8px;font-size:1.15rem}</style>';
	echo '<script>(function(){document.addEventListener("click",function(e){var b=e.target.closest&&e.target.closest(".upq-copy");if(!b){return;}var v=b.getAttribute("data-upi")||"";var done=function(){var o=b.textContent;b.textContent="Copied";setTimeout(function(){b.textContent=o||"Copy";},2000);};if(navigator.clipboard&&navigator.clipboard.writeText){navigator.clipboard.writeText(v).then(done,function(){fb(v,done);});}else{fb(v,done);}function fb(t,cb){var a=document.createElement("textarea");a.value=t;a.setAttribute("readonly","");a.style.position="absolute";a.style.left="-9999px";document.body.appendChild(a);a.select();try{document.execCommand("copy");}catch(x){}document.body.removeChild(a);cb();}});})();</script>';
}, 50 );

/* Thank-you page: QR + amount + order number + instructions, only while payment is still unverified. */
add_action( 'woocommerce_thankyou_' . UPQ_GATEWAY_ID, function ( $order_id ) {
	$order = wc_get_order( $order_id );
	if ( ! $order || ! $order->has_status( array( 'on-hold', 'pending' ) ) ) {
		return;
	}
	echo '<section class="upq-thanks"><h2>Complete your payment</h2>';
	echo '<p><strong>Order number: #' . esc_html( $order->get_order_number() ) . '</strong></p>';
	echo '<p class="upq-amount" style="text-align:center;margin:8px 0;font-size:16px;">Amount to pay: <strong>' . wp_kses_post( $order->get_formatted_order_total() ) . '</strong></p>';
	echo upq_qr_html(); // phpcs:ignore WordPress.Security.EscapeOutput
	echo upq_upi_html(); // phpcs:ignore WordPress.Security.EscapeOutput
	echo upq_payee_html(); // phpcs:ignore WordPress.Security.EscapeOutput
	echo '<p class="upq-instructions">' . esc_html( upq_instructions() ) . '</p>';
	echo '<p class="upq-instructions"><strong>Please mention order number #' . esc_html( $order->get_order_number() ) . ' with your receipt.</strong></p>';
	$caveat = upq_value( 'caveat' );
	if ( $caveat ) {
		echo '<p class="upq-caveat">' . esc_html( $caveat ) . '</p>';
	}
	echo '</section>';
}, 20 );

/** "Complete your payment" block for customer emails (inline styles only). '' once paid. */
function upq_email_html( $order ) {
	if ( ! upq_is_upi_order( $order ) || ! $order->has_status( array( 'on-hold', 'pending' ) ) ) {
		return '';
	}
	$p    = 'margin:0 0 10px;font-size:15px;line-height:1.6;color:#33322c;text-align:left;';
	$url  = trim( (string) upq_value( 'qr_url' ) );
	$upi  = trim( (string) upq_value( 'upi_id' ) );
	$html = '<div style="border:1px solid #F0D9A8;background:#FFF8E8;border-radius:8px;padding:16px;margin:0 0 20px;">';
	$html .= '<p style="' . $p . '"><strong>Complete your payment.</strong> Scan this QR code with any UPI app, or pay to the UPI ID below.</p>';
	if ( '' !== $url ) {
		$html .= '<p style="margin:0 0 10px;text-align:center;"><img src="' . esc_url( $url ) . '" alt="' . esc_attr( upq_value( 'qr_alt', 'UPI QR code' ) ) . '" width="220" style="display:inline-block;width:220px;max-width:100%;height:auto;border:1px solid #E4E4DA;border-radius:6px;"></p>';
	}
	if ( '' !== $upi ) {
		$html .= '<p style="' . $p . 'text-align:center;">UPI ID: <strong style="font-size:17px;">' . esc_html( $upi ) . '</strong></p>';
		$html .= upq_payee_html( 'margin:0 0 10px;font-size:14px;line-height:1.5;color:#33322c;text-align:center;' );
	}
	$html .= '<p style="' . $p . '"><strong>Order number: #' . esc_html( $order->get_order_number() ) . '</strong> &middot; Amount: <strong>' . wp_kses_post( $order->get_formatted_order_total() ) . '</strong></p>';
	$html .= '<p style="' . $p . '">' . esc_html( upq_instructions() ) . ' Please mention order number #' . esc_html( $order->get_order_number() ) . '.</p>';
	$caveat = upq_value( 'caveat' );
	if ( $caveat ) {
		$html .= '<p style="margin:0;font-size:13px;line-height:1.5;color:#8A4B00;">' . esc_html( $caveat ) . '</p>';
	}
	return $html . '</div>';
}

/* Customer emails (on-hold / pending): the QR block above the order table = the "bill". Admin emails get buttons instead. */
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
	if ( $plain_text ) {
		if ( $order->has_status( array( 'on-hold', 'pending' ) ) ) {
			echo "\nPay by UPI: " . esc_html( upq_value( 'upi_id' ) ) . "\nOrder number: #" . esc_html( $order->get_order_number() ) . "\n" . esc_html( upq_instructions() ) . "\n"; // phpcs:ignore
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

/* WooCommerce's own admin emails (new / cancelled / failed) also CC the owner. */
add_filter( 'woocommerce_email_headers', function ( $headers, $email_id = '' ) {
	if ( '' !== upq_owner_cc() && in_array( $email_id, array( 'new_order', 'cancelled_order', 'failed_order' ), true ) ) {
		$headers .= 'Cc: ' . upq_owner_cc() . "\r\n";
	}
	return $headers;
}, 20, 2 );

/* Remember when an order first went on hold (for the 7-day watcher). */
add_action( 'woocommerce_order_status_on-hold', function ( $order_id ) {
	$o = wc_get_order( $order_id );
	if ( $o && ! $o->get_meta( '_upq_hold_since' ) ) {
		$o->update_meta_data( '_upq_hold_since', time() );
		$o->save_meta_data();
	}
} );

/* =====================================================================
 * 4. ONE state machine (every button everywhere comes from here)
 *    unpaid (pending / on-hold) → Payment received, Not received (+ Cancel in the warning email)
 *    done   (anything else)     → no buttons
 * ================================================================== */

function upq_state( $order ) {
	if ( ! $order instanceof WC_Order ) {
		return 'done';
	}
	return in_array( $order->get_status(), array( 'pending', 'on-hold' ), true ) ? 'unpaid' : 'done';
}

function upq_actions_allowed( $order, $context = '' ) {
	if ( 'unpaid' !== upq_state( $order ) ) {
		return array();
	}
	return 'warning' === $context ? array( 'pay_ok', 'pay_no', 'cancel' ) : array( 'pay_ok', 'pay_no' );
}

/** label, confirmation question, colour. */
function upq_action_defs() {
	return array(
		'pay_ok' => array( 'Payment received', 'mark order #%s as PAYMENT RECEIVED (the customer gets the processing / payment-confirmed email)', '#18A957' ),
		'pay_no' => array( 'Payment not received', 'record that the payment for order #%s was NOT received (it stays On hold)', '#B3261E' ),
		'cancel' => array( 'Cancel order', 'CANCEL order #%s (the customer gets the cancellation email)', '#B3261E' ),
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
		return 'Already done: ' . $l['label'] . ', by ' . $l['by'] . ', at ' . wp_date( 'j M, g:i A', (int) $l['at'] ) . '. Order #' . $no . ' is now: ' . $st . '.';
	}
	return 'No change: order #' . $no . ' is now: ' . $st . '.';
}

/**
 * Run an action from any channel. Returns array( ok, message, kind ) with kind = done | already | failed.
 */
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
				$order->update_status( 'processing', 'Payment received (confirmed by admin ' . $via . ').' );
				$res = array( true, 'Order #' . $no . ' is marked Payment received.', 'done' );
				break;
			case 'pay_no':
				$order->update_meta_data( '_upq_pay_not_received_at', time() );
				$order->add_order_note( 'Payment NOT received, via ' . $via . '.' );
				if ( $order->has_status( 'pending' ) ) {
					$order->update_status( 'on-hold', 'Payment not received (admin ' . $via . ').' );
				} else {
					$order->save();
				}
				$res = array( true, 'Order #' . $no . ' stays On hold. A note was added.', 'done' );
				break;
			case 'cancel':
				$order->add_order_note( 'Cancelled via ' . $via . '.' );
				$order->update_status( 'cancelled', 'Cancelled (' . $via . ').' );
				$res = array( true, 'Order #' . $no . ' is cancelled.', 'done' );
				break;
		}
	} catch ( Throwable $e ) {
		$res = array( false, 'Error: ' . $e->getMessage(), 'failed' );
	}
	$fresh = wc_get_order( $order->get_id() );
	if ( 'done' === $res[2] ) {
		upq_record_action( $fresh, $action, $via );
		do_action( 'upq_state_changed', $fresh, $action, $via ); // hook for Telegram / Sheets / etc.
	} elseif ( 'failed' === $res[2] ) {
		$fresh->add_order_note( 'Action "' . $action . '" via ' . $via . ' FAILED: ' . $res[1] );
		upq_send_admin_mail( 'Action failed – order #' . $no, '<p>The action <b>' . esc_html( $action ) . '</b> (via ' . esc_html( $via ) . ') did not work: ' . esc_html( $res[1] ) . '. Nothing was changed. Please open the order.</p>' );
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

/** Button block for the admin "new order" email. */
function upq_admin_buttons_block( $order, $context = '' ) {
	$b = upq_buttons_html( $order->get_id(), upq_actions_allowed( $order, $context ) );
	if ( '' === $b ) {
		return '';
	}
	return '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="width:100%;margin:0 0 20px;"><tr><td style="background:#FFF8E8;border:1px solid #F0D9A8;border-radius:6px;padding:14px 16px;font-family:Arial,Helvetica,sans-serif;">'
		. '<div style="font-size:12px;text-transform:uppercase;letter-spacing:0.04em;color:#8A4B00;font-weight:700;margin:0 0 10px;">UPI payment check &mdash; one tap (check the money in the UPI/bank app first)</div>'
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
		. '<body style="margin:0;background:#f6f4ee;font-family:Arial,Helvetica,sans-serif;color:#14140F;"><div style="max-width:520px;margin:40px auto;padding:0 16px;"><div style="background:#fff;border:1px solid #E4DFD4;border-radius:10px;padding:26px 22px;">'
		. '<div style="font-weight:700;color:#18A957;margin:0 0 12px;">' . esc_html( get_bloginfo( 'name' ) ) . ' &middot; admin</div>' . $body . '</div></div></body></html>'; // phpcs:ignore WordPress.Security.EscapeOutput
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
	if ( ! $order || 'shop_order' !== $order->get_type() ) {
		upq_page( 'Link not valid', $bad, 400 );
	}
	if ( $exp < time() ) {
		upq_page( 'Link expired', '<h2 style="margin:0 0 8px;">This link has expired</h2><p>No change was made. Please open the order in the dashboard.</p>', 410 );
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
		// GET = confirmation only (email scanners open links; they never press the button).
		upq_page(
			'Confirm',
			'<h2 style="margin:0 0 10px;font-size:20px;">Confirm: ' . esc_html( $defs[ $action ][0] ) . '</h2><p style="line-height:1.6;">Do you want to ' . sprintf( $defs[ $action ][1], esc_html( $no ) ) . '?</p>'
			. '<p style="color:#5a5548;font-size:14px;">Order #' . esc_html( $no ) . ' &middot; ' . esc_html( trim( $order->get_billing_first_name() ) ) . ' &middot; ' . wp_kses_post( $order->get_formatted_order_total() ) . ' &middot; ' . esc_html( wc_get_order_status_name( $order->get_status() ) ) . '</p>'
			. '<form method="post" action="' . esc_url( home_url( '/' ) ) . '"><input type="hidden" name="upq_act_token" value="' . esc_attr( $token ) . '"><button type="submit" style="width:100%;padding:14px;border:0;border-radius:6px;background:' . $defs[ $action ][2] . ';color:#fff;font-weight:700;font-size:16px;cursor:pointer;">Yes, ' . esc_html( $defs[ $action ][0] ) . '</button></form>'
			. '<p style="margin:14px 0 0;font-size:13px;color:#5a5548;">Not you? Just close this page; nothing happens.</p>'
		);
	}
	// POST: act, then consume the link (a real failure leaves it usable for a retry).
	list( $ok, $msg, $kind ) = upq_run_action( $order, $action );
	if ( 'failed' !== $kind ) {
		$o2      = wc_get_order( $oid );
		$used    = (array) $o2->get_meta( '_upq_links_used' );
		$used[]  = $sig;
		$o2->update_meta_data( '_upq_links_used', array_slice( $used, -50 ) );
		$o2->save_meta_data();
	}
	upq_page( $ok ? 'Done' : 'Not done', '<h2 style="margin:0 0 8px;color:' . ( $ok ? '#0E7A3E' : '#B3261E' ) . ';">' . ( $ok ? 'Done' : 'Not done' ) . '</h2><p style="line-height:1.6;">' . esc_html( $msg ) . '</p>', $ok ? 200 : 409 );
}, 0 );

/* =====================================================================
 * 6. On-hold watcher: warn after 7 days, then every 4 days. NEVER auto-cancel.
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
		$html = '<p style="font-family:Arial,sans-serif;font-size:15px;line-height:1.6;">Order <b>#' . esc_html( $no ) . '</b> (' . esc_html( $o->get_formatted_billing_full_name() ) . ', ' . esc_html( $o->get_billing_phone() ) . ', ' . wp_kses_post( $o->get_formatted_order_total() ) . ') has been <b>on hold since ' . esc_html( wp_date( 'j M Y', $since ) ) . '</b>. It will NOT be cancelled automatically. Please check the UPI/bank app and choose:</p>'
			. upq_admin_buttons_block( $o, 'warning' );
		if ( upq_send_admin_mail( 'This order is about to be cancelled – #' . $no . ' (on hold)', $html ) ) {
			$o->update_meta_data( '_upq_hold_warned_at', time() );
			$o->save_meta_data();
		}
	}
} );

register_deactivation_hook( __FILE__, function () {
	wp_clear_scheduled_hook( 'upq_hold_watch_job' );
} );
```

---

## 4. How the whole flow works (for owner and staff)

| # | What happens | Order status | Customer gets | Admin gets |
|---|---|---|---|---|
| 1 | The customer picks **Pay via QR Code (UPI)** and places the order. | **On hold** | The "Order on hold" email with the **QR, UPI ID, amount, order no. and instructions** (the bill) | The **"New order"** email with **[Payment received] [Payment not received]** |
| 2 | The customer pays by scanning the QR, then sends the screenshot and UTR on WhatsApp/email. | On hold | The thank-you page shows the same QR box. | The WhatsApp message |
| 3 | Admin checks the **money in the UPI/bank app**, presses **Payment received**, then **Yes**. | **Processing** | WooCommerce's "Processing" email (payment confirmed) | The confirm page: "Done" |
| 3b | Money not found: admin presses **Payment not received**. | On hold, plus a note | Nothing | The confirm page: "Done" |
| 4 | Still on hold after 7 days. | On hold | Nothing | A warning email with **[Payment received] [Not received] [Cancel]**, every 4 days. **Never auto-cancelled.** |
| 5 | Someone presses an old button later. | (unchanged) | Nothing | "Already done: Payment received, by email button, at 30 Oct, 4:10 PM" |

**Golden rule for staff:** press **Payment received** only after you **see the money** in the UPI/bank app, with the correct amount and order number.

---

## 5. Test checklist (do all of these before going live)

Use a **test customer email of your own**. Never send test emails to real customers.

1. **Checkout:**
   - the method appears only after the QR URL and UPI ID are saved;
   - the QR shows, the amount equals the cart total, **Copy** copies the exact UPI ID;
   - it works at **360px** mobile width without sideways scroll.
2. **Scan the QR with a phone:**
   - the UPI app shows the right payee and UPI ID;
   - do a ₹1 real test only if the owner agrees.
3. Place a test order with this method:
   - the status is **On hold**,
   - stock is reduced,
   - the cart is emptied,
   - the thank-you page shows the QR box.
4. **Customer on-hold email:** it contains the QR image, UPI ID, order no., amount, instructions and warning.
5. **Admin new-order email:**
   - it shows the 2 buttons;
   - the CC goes to the owner (if set);
   - opening a button shows the **Confirm page** and **nothing changes yet**.
6. Press **Yes, Payment received**:
   - the status becomes Processing, an order note is added, the customer gets the Processing email;
   - pressing **the same link again** shows "already used" or "Already done";
   - pressing the **other button** (Not received) shows "Already done …".
7. **Tamper tests**, which must all say "not valid" and change nothing:
   - edit one letter of the token,
   - change the order id inside the token,
   - use an expired token.
8. **Hold watcher:**
   - set `_upq_hold_since` on a test order to 8 days ago,
   - run `wp cron event run upq_hold_watch_job --allow-root`,
   - check that the warning email has 3 buttons,
   - run it again at once: no second email.
9. **Cache:** with page cache ON, open a link twice in a private window. It must not show a cached page.
10. **Clean up:**
    - delete the test orders,
    - turn off any test mode,
    - purge the cache.

---

## 6. Optional add-ons (they were built on qurbanieasy.com; add later if wanted)

- **Telegram group alerts with the same buttons.** Hook `upq_state_changed` to edit old messages. Any group member may act, after a live membership check, with signed callback data. Bot token in wp-config only.
- **Google Sheets log** of every order and status change. An Apps Script web app with a shared secret, sent in the background with 3 retries.
- **Abandoned-checkout alert** 15 minutes after a phone number is typed, with a WhatsApp `wa.me` button and pre-filled text (`rawurlencode`).
- **Daily summary email** at 9 AM, sent only when something moved, grouped by state, with the same buttons.
- **Track-order page** (order no. + phone) and a custom "Performed / Delivered" customer email.

Every add-on must take its buttons from `upq_actions_allowed()`, so all channels always agree.

---

## 7. Safety rules (keep these on the new site too)

- Secrets (`UPQ_LINK_SECRET`, bot tokens, app passwords) live **only in `wp-config.php` / a local `.env`**. Never put them in git, chat, logs or emails.
- **Never auto-confirm a UPI payment.** A human checks the bank/UPI app.
- **Never auto-cancel.** Only a human presses Cancel.
- Customer emails **never** get a CC. Admin emails may CC the owner.
- **Back up** the site and database before installing. Test on test orders, and delete them after.
- Don't add `upi://` "Pay now" buttons. UPI apps decline them from websites (tested October 2026).
