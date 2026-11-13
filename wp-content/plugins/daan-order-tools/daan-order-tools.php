<?php
/**
 * Plugin Name: Daan Order Tools
 * Description: Mandatory Indian mobile number and optional PAN on checkout and /donate/ (form in the theme), plus a direct "Export Customers" CSV download for admins (WooCommerce > Export Customers). PAN is visible to admins only and never goes into e-mails, order notes, logs or the digest.
 * Version: 1.0.0
 * Requires Plugins: woocommerce
 */
defined( 'ABSPATH' ) || exit;

const DAAN_OT_PAN_META     = '_daan_donor_pan';
const DAAN_OT_MOBILE_ERROR = 'Please enter a valid 10-digit Indian mobile number.';
const DAAN_OT_PAN_ERROR    = 'Please enter a valid PAN, for example ABCDE1234F, or leave this field empty.';
const DAAN_OT_PAN_HELP    = 'PAN is not required. Daan Foundation is not registered under Section 80G.';

/* -------------------------------------------------------------------------
 * 1. Validators (also used by daan_place_order() in the theme)
 * ------------------------------------------------------------------------- */

/** Returns the plain 10 digits, or '' when the number is not a valid Indian mobile. */
function daan_ot_normalize_mobile( $value ) {
	$value = preg_replace( '/[\s\-().]/', '', (string) $value );
	return preg_match( '/^(?:\+91|0091|91|0)?([6-9]\d{9})$/', $value, $m ) ? $m[1] : '';
}

/** Returns the uppercase PAN, '' when empty, or false when filled in but invalid. */
function daan_ot_normalize_pan( $value ) {
	$value = strtoupper( trim( sanitize_text_field( (string) $value ) ) );
	if ( '' === $value ) {
		return '';
	}
	return preg_match( '/^[A-Z]{5}[0-9]{4}[A-Z]$/', $value ) ? $value : false;
}

/* -------------------------------------------------------------------------
 * 2. Classic checkout
 * ------------------------------------------------------------------------- */

add_filter( 'woocommerce_checkout_fields', function ( $fields ) {
	if ( isset( $fields['billing']['billing_phone'] ) ) {
		$fields['billing']['billing_phone']['required'] = true;
		$fields['billing']['billing_phone']['label']    = 'Mobile Number';
	}
	return $fields;
}, 9999 );

// Printed by action, not as a checkout field, so the Checkout Field Editor plugin cannot drop it.
add_action( 'woocommerce_after_checkout_billing_form', function ( $checkout ) {
	woocommerce_form_field(
		'daan_pan',
		array(
			'type'              => 'text',
			'label'             => 'PAN Card Number',
			'required'          => false,
			'maxlength'         => 10,
			'description'       => DAAN_OT_PAN_HELP,
			'custom_attributes' => array( 'autocomplete' => 'off' ),
		),
		$checkout->get_value( 'daan_pan' )
	);
} );

add_filter( 'woocommerce_checkout_posted_data', function ( $data ) {
	$mobile = daan_ot_normalize_mobile( $data['billing_phone'] ?? '' );
	if ( $mobile ) {
		$data['billing_phone'] = $mobile;
	}
	return $data;
} );

add_action( 'woocommerce_after_checkout_validation', function ( $data, $errors ) {
	if ( ! daan_ot_normalize_mobile( $data['billing_phone'] ?? '' ) ) {
		$errors->add( 'billing_phone_validation', DAAN_OT_MOBILE_ERROR );
	}
	if ( false === daan_ot_normalize_pan( wp_unslash( $_POST['daan_pan'] ?? '' ) ) ) { // phpcs:ignore WordPress.Security.NonceVerification -- WooCommerce checks the checkout nonce.
		$errors->add( 'daan_pan_validation', DAAN_OT_PAN_ERROR );
	}
}, 10, 2 );

add_action( 'woocommerce_checkout_create_order', function ( $order ) {
	$pan = daan_ot_normalize_pan( wp_unslash( $_POST['daan_pan'] ?? '' ) ); // phpcs:ignore WordPress.Security.NonceVerification -- WooCommerce checks the checkout nonce.
	if ( $pan ) {
		$order->update_meta_data( DAAN_OT_PAN_META, $pan );
	}
} );

// Live checks on the checkout form; the server checks above stay the real gate.
add_action( 'wp_footer', function () {
	if ( ! function_exists( 'is_checkout' ) || ! is_checkout() || is_order_received_page() ) {
		return;
	}
	?>
	<style>#daan_pan-description{display:block!important;background:none;color:inherit;padding:0;margin:6px 0 0;font-size:0.875rem}#daan_pan-description::before{display:none}</style>
	<script>
	(function () {
		var pan = document.getElementById('daan_pan');
		if (!pan) { return; }
		function error(input, id, text) {
			var box = document.getElementById(id);
			if (!text) { if (box) { box.remove(); } return; }
			if (!box) {
				box = document.createElement('div');
				box.id = id;
				box.setAttribute('role', 'alert');
				box.style.color = '#B91C1C';
				box.style.fontSize = '0.875rem';
				input.parentNode.appendChild(box);
			}
			box.textContent = text;
		}
		pan.addEventListener('input', function () { pan.value = pan.value.toUpperCase(); });
		pan.addEventListener('blur', function () {
			var bad = pan.value && !/^[A-Z]{5}[0-9]{4}[A-Z]$/.test(pan.value.trim());
			error(pan, 'daan-pan-error', bad ? <?php echo wp_json_encode( DAAN_OT_PAN_ERROR ); ?> : '');
		});
		var phone = document.getElementById('billing_phone');
		if (phone) {
			phone.addEventListener('blur', function () {
				var bad = !/^(?:\+91|0091|91|0)?[6-9]\d{9}$/.test(phone.value.replace(/[\s\-().]/g, ''));
				error(phone, 'daan-mobile-error', bad ? <?php echo wp_json_encode( DAAN_OT_MOBILE_ERROR ); ?> : '');
			});
		}
	})();
	</script>
	<?php
} );

/* -------------------------------------------------------------------------
 * 3. Block checkout safety net: the mobile rule also holds for the Store API
 * ------------------------------------------------------------------------- */

add_action( 'woocommerce_store_api_checkout_update_order_from_request', function ( $order, $request ) {
	$address = $request['billing_address'];
	$mobile  = daan_ot_normalize_mobile( is_array( $address ) ? ( $address['phone'] ?? '' ) : $order->get_billing_phone() );
	if ( ! $mobile ) {
		throw new \Automattic\WooCommerce\StoreApi\Exceptions\RouteException( 'daan_invalid_mobile', DAAN_OT_MOBILE_ERROR, 400 );
	}
	$order->set_billing_phone( $mobile );
}, 10, 2 );

/* -------------------------------------------------------------------------
 * 4. PAN on the order screen: admins only
 * ------------------------------------------------------------------------- */

add_action( 'woocommerce_admin_order_data_after_billing_address', function ( $order ) {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$pan = $order->get_meta( DAAN_OT_PAN_META );
	if ( $pan ) {
		echo '<p><strong>PAN:</strong> ' . esc_html( $pan ) . '</p>';
	}
} );

// The WooCommerce REST API returns order meta to anyone who may read orders: PAN stays admin-only there too.
add_filter( 'woocommerce_rest_prepare_shop_order_object', function ( $response ) {
	if ( ! current_user_can( 'manage_options' ) && isset( $response->data['meta_data'] ) ) {
		$response->data['meta_data'] = array_values(
			array_filter(
				$response->data['meta_data'],
				function ( $meta ) {
					return DAAN_OT_PAN_META !== $meta->key;
				}
			)
		);
	}
	return $response;
} );

/* -------------------------------------------------------------------------
 * 5. Export Customers: direct CSV download, no e-mail
 * ------------------------------------------------------------------------- */

add_action( 'admin_menu', function () {
	add_submenu_page( 'woocommerce', 'Export Customers', 'Export Customers', 'manage_options', 'daan-export-customers', 'daan_ot_export_page' );
}, 99 );

add_action( 'admin_post_daan_export_customers', 'daan_ot_export_download' );

function daan_ot_export_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1>Export Customers</h1>
		<p>The file downloads straight to this computer. No e-mail is sent. It contains personal data, so please keep it safe.</p>
		<form id="daan-export-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="daan_export_customers">
			<?php wp_nonce_field( 'daan_export_customers' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="daan-from">From date</label></th>
					<td><input type="date" id="daan-from" name="from" value="<?php echo esc_attr( wp_date( 'Y-m-d', daan_order_cutoff() ) ); ?>"><p class="description">Starts at the cutoff by default. Choose an earlier date only when you need older orders.</p></td>
				</tr>
				<tr>
					<th scope="row"><label for="daan-to">To date</label></th>
					<td><input type="date" id="daan-to" name="to"></td>
				</tr>
				<tr>
					<th scope="row"><label for="daan-status">Status</label></th>
					<td>
						<select id="daan-status" name="status">
							<option value="">All statuses</option>
							<?php foreach ( wc_get_order_statuses() as $key => $label ) : ?>
								<option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">PAN</th>
					<td><label><input type="checkbox" name="include_pan" value="1"> Include PAN</label></td>
				</tr>
			</table>
			<p class="submit">
				<button type="submit" class="button button-primary" id="daan-export-btn">Export Customers</button>
				<span class="spinner" id="daan-export-spinner" style="float:none;"></span>
			</p>
			<div id="daan-export-error" class="notice notice-error inline" role="alert" style="display:none;"><p></p></div>
		</form>
	</div>
	<script>
	(function () {
		var form = document.getElementById('daan-export-form');
		var btn = document.getElementById('daan-export-btn');
		var spinner = document.getElementById('daan-export-spinner');
		var errorBox = document.getElementById('daan-export-error');
		if (!window.fetch || !window.URL) { return; } // Without these the form still downloads normally.
		form.addEventListener('submit', function (e) {
			e.preventDefault();
			errorBox.style.display = 'none';
			btn.disabled = true;
			btn.textContent = 'Preparing file...';
			spinner.classList.add('is-active');
			fetch(form.action, { method: 'POST', body: new FormData(form), credentials: 'same-origin' })
				.then(function (r) {
					var type = r.headers.get('Content-Type') || '';
					if (!r.ok || type.indexOf('text/csv') === -1) { throw new Error('bad response'); }
					var match = /filename="([^"]+)"/.exec(r.headers.get('Content-Disposition') || '');
					return r.blob().then(function (blob) {
						var a = document.createElement('a');
						a.href = URL.createObjectURL(blob);
						a.download = match ? match[1] : 'customers.csv';
						document.body.appendChild(a);
						a.click();
						a.remove();
						setTimeout(function () { URL.revokeObjectURL(a.href); }, 10000);
					});
				})
				.catch(function () {
					errorBox.querySelector('p').textContent = 'The download failed. Please refresh this page, check that you are still logged in, and try again.';
					errorBox.style.display = 'block';
				})
				.then(function () {
					btn.disabled = false;
					btn.textContent = 'Export Customers';
					spinner.classList.remove('is-active');
				});
		});
	})();
	</script>
	<?php
}

/** Stops spreadsheet programs from running a cell as a formula. */
function daan_ot_csv_cell( $value ) {
	$value = (string) $value;
	$first = substr( ltrim( $value, " \n" ), 0, 1 );
	return in_array( $first, array( '=', '+', '-', '@', "\t", "\r" ), true ) ? "'" . $value : $value;
}

/** Timestamp from a Y-m-d value in the site's time zone, or null when empty or invalid. */
function daan_ot_export_time( $date, $time ) {
	$date = sanitize_text_field( wp_unslash( (string) $date ) );
	$made = preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date ) ? DateTimeImmutable::createFromFormat( 'Y-m-d H:i:s', $date . ' ' . $time, wp_timezone() ) : false;
	return $made ? $made->getTimestamp() : null;
}

function daan_ot_export_download() {
	check_admin_referer( 'daan_export_customers' );
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'You are not allowed to export customers.', 'Forbidden', array( 'response' => 403 ) );
	}

	$statuses = array_keys( wc_get_order_statuses() );
	$status   = sanitize_text_field( wp_unslash( $_POST['status'] ?? '' ) );
	$query    = array(
		'type'    => 'shop_order',
		'status'  => in_array( $status, $statuses, true ) ? array( $status ) : $statuses,
		'limit'   => 200,
		'orderby' => 'ID',
		'order'   => 'ASC',
	);
	$from = daan_ot_export_time( $_POST['from'] ?? '', '00:00:00' );
	$to   = daan_ot_export_time( $_POST['to'] ?? '', '23:59:59' );
	$query['date_created'] = ( null !== $from ? $from : daan_order_cutoff() ) . '...' . ( null !== $to ? $to : time() );

	if ( function_exists( 'set_time_limit' ) ) {
		@set_time_limit( 0 ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
	}
	while ( ob_get_level() ) {
		ob_end_clean();
	}
	nocache_headers();
	header( 'Content-Type: text/csv; charset=UTF-8' );
	header( 'Content-Disposition: attachment; filename="customers-' . wp_date( 'Y-m-d' ) . '.csv"' );
	header( 'X-Content-Type-Options: nosniff' );

	$out = fopen( 'php://output', 'w' );
	daan_ot_export_write( $out, $query, ! empty( $_POST['include_pan'] ) );
	fclose( $out );
	exit;
}

/** Writes the CSV to an open stream, page by page. */
function daan_ot_export_write( $out, $query, $include_pan ) {
	fwrite( $out, "\xEF\xBB\xBF" ); // BOM, so Excel reads Hindi/Urdu names correctly.
	$header = array( 'Order ID', 'Order number', 'Date', 'Status', 'Amount', 'Currency', 'Items / cause', 'Frequency', 'First name', 'Last name', 'Email', 'Mobile', 'Address 1', 'Address 2', 'City', 'State', 'Pincode', 'Country', 'Payment method', 'Transaction ID', 'Customer note' );
	if ( $include_pan ) {
		$header[] = 'PAN';
	}
	fputcsv( $out, $header, ',', '"', '' );

	$page = 1;
	do {
		$orders = wc_get_orders( $query + array( 'page' => $page ) );
		foreach ( $orders as $order ) {
			$items = array();
			foreach ( $order->get_items( array( 'line_item', 'fee' ) ) as $item ) {
				$items[] = $item->get_name();
			}
			$created = $order->get_date_created();
			$row     = array(
				$order->get_id(),
				$order->get_order_number(),
				$created ? $created->date_i18n( 'Y-m-d H:i' ) : '',
				wc_get_order_status_name( $order->get_status() ),
				$order->get_total(),
				$order->get_currency(),
				implode( ' | ', $items ),
				$order->get_meta( '_daan_donation_frequency' ),
				$order->get_billing_first_name(),
				$order->get_billing_last_name(),
				$order->get_billing_email(),
				$order->get_billing_phone(),
				$order->get_billing_address_1(),
				$order->get_billing_address_2(),
				$order->get_billing_city(),
				$order->get_billing_state(),
				$order->get_billing_postcode(),
				$order->get_billing_country(),
				$order->get_payment_method_title(),
				$order->get_transaction_id(),
				$order->get_customer_note(),
			);
			if ( $include_pan ) {
				$row[] = $order->get_meta( DAAN_OT_PAN_META );
			}
			fputcsv( $out, array_map( 'daan_ot_csv_cell', $row ), ',', '"', '' );
		}
		flush();
		$page++;
	} while ( count( $orders ) === $query['limit'] );
}

/* -------------------------------------------------------------------------
 * 6. PAN in WordPress personal data export and erase
 * ------------------------------------------------------------------------- */

function daan_ot_orders_with_pan( $email ) {
	$orders = wc_get_orders(
		array(
			'type'          => 'shop_order',
			'billing_email' => $email,
			'status'        => array_merge( array_keys( wc_get_order_statuses() ), array( 'trash' ) ),
			'limit'         => -1,
		)
	);
	return array_filter(
		$orders,
		function ( $order ) {
			return '' !== (string) $order->get_meta( DAAN_OT_PAN_META );
		}
	);
}

add_filter( 'wp_privacy_personal_data_exporters', function ( $exporters ) {
	$exporters['daan-order-pan'] = array(
		'exporter_friendly_name' => 'Daan donor PAN',
		'callback'               => function ( $email ) {
			$data = array();
			foreach ( daan_ot_orders_with_pan( $email ) as $order ) {
				$data[] = array(
					'group_id'    => 'daan-order-pan',
					'group_label' => 'Donor PAN',
					'item_id'     => 'daan-pan-' . $order->get_id(),
					'data'        => array(
						array( 'name' => 'Donation number', 'value' => $order->get_order_number() ),
						array( 'name' => 'PAN', 'value' => $order->get_meta( DAAN_OT_PAN_META ) ),
					),
				);
			}
			return array( 'data' => $data, 'done' => true );
		},
	);
	return $exporters;
} );

add_filter( 'wp_privacy_personal_data_erasers', function ( $erasers ) {
	$erasers['daan-order-pan'] = array(
		'eraser_friendly_name' => 'Daan donor PAN',
		'callback'             => function ( $email ) {
			$removed = false;
			foreach ( daan_ot_orders_with_pan( $email ) as $order ) {
				$order->delete_meta_data( DAAN_OT_PAN_META );
				$order->save_meta_data();
				$removed = true;
			}
			return array( 'items_removed' => $removed, 'items_retained' => false, 'messages' => array(), 'done' => true );
		},
	);
	return $erasers;
} );

/* -------------------------------------------------------------------------
 * 7. Automation (one on/off setting): execution e-mail and the 24-hour timer
 * ------------------------------------------------------------------------- */

const DAAN_OT_ENABLED_OPTION = 'daan_ot_automation_enabled';
const DAAN_OT_EXEC_FLAG      = '_daan_exec_mail_sent';
const DAAN_OT_EXEC_ALERT     = '_daan_exec_mail_alert_at';
const DAAN_OT_ALERT_TO       = 'daanfoundationindia@gmail.com';
const DAAN_OT_BCC            = 'arksuri@gmail.com';
const DAAN_OT_EXEC_DELAY     = 72 * HOUR_IN_SECONDS;
const DAAN_OT_CANCEL_DELAY   = 24 * HOUR_IN_SECONDS;
const DAAN_OT_UPQ_GATEWAY    = 'upq_manual_qr';
const DAAN_OT_PAUSE_OPTION   = 'daan_ot_pause_autocancel';
const DAAN_OT_DIGEST_COUNT   = '_daan_digest_count';
const DAAN_OT_DIGEST_DAY     = '_daan_digest_last_day';
const DAAN_OT_SECOND_DIGEST  = '_daan_digest_second_at';
const DAAN_OT_AFTER_SECOND   = 6 * HOUR_IN_SECONDS;
const DAAN_OT_AUTO_CANCELLED = '_daan_auto_cancelled_at';
const DAAN_OT_REOPEN_WINDOW  = 7 * DAY_IN_SECONDS;

function daan_ot_automation_on() {
	return 'yes' === get_option( DAAN_OT_ENABLED_OPTION, 'no' );
}

/** Cause shown to the donor for a line, or '' when the line is out of scope. */
function daan_ot_exec_cause( $item ) {
	$name = trim( preg_replace( '/^Donation\s*[—–-]\s*/u', '', html_entity_decode( $item->get_name(), ENT_QUOTES, 'UTF-8' ) ) );
	$key  = strtolower( $name );
	$names = array( 'community kitchen', 'fidya', 'fidyah', 'kaffara', 'kaffarah', 'fidya and kaffara', 'fidya & kaffara', 'fidyah and kaffarah', 'fidyah & kaffarah' );
	if ( in_array( $key, $names, true ) ) {
		return $name;
	}
	// Community Kitchen, Fidyah & Kaffarah, Fidya and Kaffara: variations can carry a longer line name.
	$products = array( 5925 => 'Community Kitchen', 6812 => 'Fidyah & Kaffarah', 5922 => 'Fidya and Kaffara' );
	$id       = is_callable( array( $item, 'get_product_id' ) ) ? (int) $item->get_product_id() : 0;
	return $products[ $id ] ?? '';
}

/** @return array{causes: string[], amount: float} */
function daan_ot_exec_scope( $order ) {
	$causes = array();
	$amount = 0.0;
	foreach ( $order->get_items( array( 'line_item', 'fee' ) ) as $item ) {
		$cause = daan_ot_exec_cause( $item );
		if ( '' !== $cause ) {
			$causes[ $cause ] = $cause;
			$amount          += (float) $item->get_total();
		}
	}
	return array( 'causes' => array_values( $causes ), 'amount' => $amount );
}

/** True when this order should get its execution e-mail right now. */
function daan_ot_exec_is_due( $order ) {
	if ( ! $order instanceof WC_Order || ! $order->has_status( 'completed' ) || $order->get_meta( DAAN_OT_EXEC_FLAG ) || ! daan_order_after_cutoff( $order ) ) {
		return false;
	}
	if ( time() < $order->get_date_created()->getTimestamp() + DAAN_OT_EXEC_DELAY || $order->get_total_refunded() > 0 || ! is_email( $order->get_billing_email() ) ) {
		return false;
	}
	return (bool) daan_ot_exec_scope( $order )['causes'];
}

function daan_ot_exec_html( $order ) {
	$scope = daan_ot_exec_scope( $order );
	$first = trim( $order->get_billing_first_name() );
	$p     = '<p style="font-family:Arial,Helvetica,sans-serif;font-size:15px;line-height:1.6;color:#1F2937;margin:0 0 14px;">';
	return $p . 'Dear ' . esc_html( '' !== $first ? $first : 'Donor' ) . ',</p>'
		. $p . 'Thank you for your donation of ' . wp_kses_post( wc_price( $scope['amount'], array( 'currency' => $order->get_currency() ) ) ) . ' to ' . esc_html( implode( ' and ', $scope['causes'] ) ) . ' (Donation #' . esc_html( $order->get_order_number() ) . ').</p>'
		. $p . 'By the grace of Allah, your contribution has been used in our food distribution work, helping provide meals to people in need.</p>'
		. $p . 'May Allah accept your donation and reward you for your generosity.</p>'
		. $p . 'Team Daan Foundation</p>';
}

/** Sends once. On failure: no flag, a note and an alert at most once a day per order; the next run retries. */
function daan_ot_exec_process( $order ) {
	if ( ! daan_ot_exec_is_due( $order ) ) {
		return false;
	}
	$headers = array( 'Content-Type: text/html; charset=UTF-8' );
	$subject = 'Your donation has reached those in need';
	$html    = daan_ot_exec_html( $order );
	if ( wp_mail( $order->get_billing_email(), $subject, $html, $headers ) ) {
		$order->update_meta_data( DAAN_OT_EXEC_FLAG, time() );
		$order->save_meta_data();
		$order->add_order_note( 'Execution email sent ' . wp_date( 'j M Y, g:i A' ) );
		// Separate copy for the Foundation (replaces Bcc); the donor never sees this address.
		$copy = wp_mail( DAAN_OT_BCC, '[Copy] #' . $order->get_order_number() . ' ' . $subject, $html, $headers );
		$order->add_order_note( $copy ? 'Execution email copy sent to the Foundation.' : 'Execution email copy to the Foundation failed (donor mail was sent).' );
		return true;
	}
	if ( time() - (int) $order->get_meta( DAAN_OT_EXEC_ALERT ) >= DAY_IN_SECONDS ) {
		$order->update_meta_data( DAAN_OT_EXEC_ALERT, time() );
		$order->save_meta_data();
		$order->add_order_note( 'Execution email failed; it will be tried again on the next run.' );
		wp_mail( DAAN_OT_ALERT_TO, 'Execution email failed – donation #' . $order->get_order_number(), '<p style="font-family:Arial,Helvetica,sans-serif;font-size:15px;line-height:1.6;">The execution email for donation <b>#' . esc_html( $order->get_order_number() ) . '</b> could not be sent. It will be tried again every hour.</p>', array( 'Content-Type: text/html; charset=UTF-8' ) );
	}
	return false;
}

/** The 24-hour rule applies to this order (setting aside whether the feature is on). */
function daan_ot_timer_in_scope( $order ) {
	return $order instanceof WC_Order && DAAN_OT_UPQ_GATEWAY === $order->get_payment_method() && daan_order_after_cutoff( $order );
}

function daan_ot_autocancel_paused() {
	return 'yes' === get_option( DAAN_OT_PAUSE_OPTION, 'no' );
}

/** Status straight from the database, past every cache. */
function daan_ot_status_in_db( $order_id ) {
	global $wpdb;
	if ( \Automattic\WooCommerce\Utilities\OrderUtil::custom_orders_table_usage_is_enabled() ) {
		$status = $wpdb->get_var( $wpdb->prepare( "SELECT status FROM {$wpdb->prefix}wc_orders WHERE id = %d", $order_id ) );
	} else {
		$status = $wpdb->get_var( $wpdb->prepare( "SELECT post_status FROM {$wpdb->posts} WHERE ID = %d", $order_id ) );
	}
	return preg_replace( '/^wc-/', '', (string) $status );
}

/** Takes a lock in one database step, so only one run can hold it; a lock left by a crashed run expires after 15 minutes. */
function daan_ot_lock_take( $name ) {
	global $wpdb;
	$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->options} WHERE option_name = %s AND CAST(option_value AS UNSIGNED) < %d", $name, time() - 15 * MINUTE_IN_SECONDS ) );
	return 1 === (int) $wpdb->query( $wpdb->prepare( "INSERT IGNORE INTO {$wpdb->options} (option_name, option_value, autoload) VALUES (%s, %s, 'off')", $name, (string) time() ) );
}

function daan_ot_lock_release( $name ) {
	global $wpdb;
	$wpdb->delete( $wpdb->options, array( 'option_name' => $name ) );
}

/** When this on-hold donation will be cancelled. "Not received": 24 hours after it, whatever the digests say. No button: 6 hours after the second digest. 0 = no timer. */
function daan_ot_timer_deadline( $order ) {
	$not_received = (int) $order->get_meta( '_upq_pay_not_received_at' );
	if ( $not_received ) {
		return $not_received + DAAN_OT_CANCEL_DELAY;
	}
	$second = (int) $order->get_meta( DAAN_OT_SECOND_DIGEST );
	return $second ? $second + DAAN_OT_AFTER_SECOND : 0;
}

function daan_ot_timer_process( $order ) {
	if ( daan_ot_autocancel_paused() || ! daan_ot_timer_in_scope( $order ) || ! $order->has_status( 'on-hold' ) ) {
		return false;
	}
	$deadline = daan_ot_timer_deadline( $order );
	if ( ! $deadline || time() < $deadline ) {
		return false;
	}
	// Last look in the database: Payment received may have been pressed after this run loaded the order.
	if ( 'on-hold' !== daan_ot_status_in_db( $order->get_id() ) ) {
		return false;
	}
	$order->update_meta_data( DAAN_OT_AUTO_CANCELLED, time() );
	$order->save_meta_data();
	$order->update_status( 'cancelled', $order->get_meta( '_upq_pay_not_received_at' ) ? 'Auto-cancelled: payment not received within 24 hours of "Payment not received".' : 'Auto-cancelled: payment not received after two digests.' );
	return true;
}

function daan_ot_today() {
	return wp_date( 'Y-m-d', null, new DateTimeZone( 'Asia/Kolkata' ) );
}

/** Counts a digest that really went out, once a day per order, only for the orders it really showed. */
function daan_ot_mark_in_digest( $ids ) {
	if ( daan_ot_autocancel_paused() ) {
		return;
	}
	foreach ( (array) $ids as $id ) {
		$order = wc_get_order( $id );
		if ( ! daan_ot_timer_in_scope( $order ) || ! $order->has_status( 'on-hold' ) || daan_ot_today() === $order->get_meta( DAAN_OT_DIGEST_DAY ) ) {
			continue;
		}
		$count = (int) $order->get_meta( DAAN_OT_DIGEST_COUNT ) + 1;
		$order->update_meta_data( DAAN_OT_DIGEST_COUNT, $count );
		$order->update_meta_data( DAAN_OT_DIGEST_DAY, daan_ot_today() );
		if ( 2 === $count ) {
			$order->update_meta_data( DAAN_OT_SECOND_DIGEST, time() );
		}
		$order->save_meta_data();
	}
}

/** For the top section of the digest: this digest is (or already was) the second one, and no button was pressed. */
function daan_ot_digest_will_cancel( $order ) {
	if ( daan_ot_autocancel_paused() || ! daan_ot_timer_in_scope( $order ) || $order->get_meta( '_upq_pay_not_received_at' ) ) {
		return false;
	}
	$count = (int) $order->get_meta( DAAN_OT_DIGEST_COUNT );
	return $count >= 2 || ( 1 === $count && daan_ot_today() !== $order->get_meta( DAAN_OT_DIGEST_DAY ) );
}

/** After a pause every running timer keeps the time it had left, so nothing falls due at once. */
add_filter( 'pre_update_option_' . DAAN_OT_PAUSE_OPTION, function ( $new, $old ) {
	if ( 'yes' === $new && 'yes' !== $old ) {
		update_option( 'daan_ot_paused_since', time(), false );
	} elseif ( 'yes' !== $new && 'yes' === $old ) {
		$paused = max( 0, time() - (int) get_option( 'daan_ot_paused_since', time() ) );
		delete_option( 'daan_ot_paused_since' );
		foreach ( daan_ot_query_after_cutoff( array( 'status' => array( 'wc-on-hold' ), 'payment_method' => DAAN_OT_UPQ_GATEWAY ) ) as $order ) {
			foreach ( array( '_upq_pay_not_received_at', DAAN_OT_SECOND_DIGEST ) as $key ) {
				$at = (int) $order->get_meta( $key );
				if ( $at ) {
					$order->update_meta_data( $key, $at + $paused );
				}
			}
			$order->save_meta_data();
		}
	}
	return $new;
}, 10, 2 );

/** True only for a donation this plugin auto-cancelled, for 7 days. */
function daan_ot_auto_cancel_open( $order ) {
	$at = (int) $order->get_meta( DAAN_OT_AUTO_CANCELLED );
	return $at && $order->has_status( 'cancelled' ) && time() < $at + DAAN_OT_REOPEN_WINDOW;
}

function daan_ot_auto_cancelled_orders() {
	return array_values( array_filter( daan_ot_query_after_cutoff( array( 'status' => array( 'wc-cancelled' ), 'payment_method' => DAAN_OT_UPQ_GATEWAY ) ), 'daan_ot_auto_cancel_open' ) );
}

// Leaving on-hold ends the timers, and leaving cancelled ends the auto-cancel mark, so old times never act later.
add_action( 'woocommerce_order_status_changed', function ( $order_id, $from ) {
	if ( ! in_array( $from, array( 'on-hold', 'cancelled' ), true ) ) {
		return;
	}
	$order = wc_get_order( $order_id );
	if ( ! daan_ot_timer_in_scope( $order ) ) {
		return;
	}
	foreach ( 'on-hold' === $from ? array( '_upq_pay_not_received_at', DAAN_OT_DIGEST_COUNT, DAAN_OT_DIGEST_DAY, DAAN_OT_SECOND_DIGEST ) : array( DAAN_OT_AUTO_CANCELLED ) as $key ) {
		$order->delete_meta_data( $key );
	}
	$order->save_meta_data();
}, 10, 2 );

function daan_ot_query_after_cutoff( $args ) {
	return wc_get_orders( $args + array( 'type' => 'shop_order', 'limit' => -1, 'date_created' => daan_order_cutoff_range() ) );
}

function daan_ot_exec_candidates() {
	return array_filter( daan_ot_query_after_cutoff( array( 'status' => array( 'wc-completed' ) ) ), 'daan_ot_exec_is_due' );
}

function daan_ot_timer_candidates() {
	return array_filter(
		daan_ot_query_after_cutoff( array( 'status' => array( 'wc-on-hold' ), 'payment_method' => DAAN_OT_UPQ_GATEWAY ) ),
		function ( $order ) {
			$deadline = daan_ot_timer_deadline( $order );
			return $deadline && time() >= $deadline;
		}
	);
}

add_action( 'daan_ot_hourly', function () {
	if ( ! daan_ot_automation_on() ) {
		return;
	}
	if ( ! daan_ot_lock_take( 'daan_ot_cron_lock' ) ) {
		return;
	}
	try {
		foreach ( daan_ot_autocancel_paused() ? array() : daan_ot_timer_candidates() as $order ) {
			daan_ot_timer_process( $order );
		}
		foreach ( daan_ot_exec_candidates() as $order ) {
			daan_ot_exec_process( wc_get_order( $order->get_id() ) );
		}
	} finally {
		daan_ot_lock_release( 'daan_ot_cron_lock' );
	}
} );

// The server resolves its own domain to an IPv6 address that resets the connection, so the WP-Cron
// loopback (and Action Scheduler's) never ran from 11 Nov 2026. Requests to this site go over IPv4.
add_action( 'http_api_curl', function ( $handle, $args, $url ) {
	if ( wp_parse_url( $url, PHP_URL_HOST ) === wp_parse_url( site_url(), PHP_URL_HOST ) && defined( 'CURL_IPRESOLVE_V4' ) ) {
		curl_setopt( $handle, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
	}
}, 10, 3 );

/* Cron heartbeat: every cron run saves its time; a stop of over 3 hours gives an alert mail (max 1 a day),
 * a red wp-admin notice, and a 503 on the secret status URL /?daan_cron_status=TOKEN (token in wp-admin only). */
const DAAN_OT_CRON_LAST     = 'daan_ot_cron_last';      // any cron run (web or server)
const DAAN_OT_CRON_CLI_LAST = 'daan_ot_cron_cli_last';  // run started by the server cron (CLI)
const DAAN_OT_CRON_ALERTED  = 'daan_ot_cron_alerted_at';
const DAAN_OT_CRON_TOKEN    = 'daan_ot_cron_token';
const DAAN_OT_CRON_STALE    = 3 * HOUR_IN_SECONDS;

function daan_ot_cron_beat() {
	update_option( DAAN_OT_CRON_LAST, time(), false );
	if ( 'cli' === PHP_SAPI ) {
		update_option( DAAN_OT_CRON_CLI_LAST, time(), false );
	}
}
add_action( 'shutdown', function () {
	if ( wp_doing_cron() ) {
		daan_ot_cron_beat();
	}
} );
add_action( 'daan_ot_hourly', 'daan_ot_cron_beat', 1 );

function daan_ot_cron_age() {
	$last = (int) get_option( DAAN_OT_CRON_LAST, 0 );
	return $last ? time() - $last : PHP_INT_MAX;
}

function daan_ot_cron_stale() {
	return daan_ot_cron_age() > DAAN_OT_CRON_STALE;
}

function daan_ot_cron_token() {
	$token = (string) get_option( DAAN_OT_CRON_TOKEN, '' );
	if ( '' === $token ) {
		$token = wp_generate_password( 32, false );
		update_option( DAAN_OT_CRON_TOKEN, $token, false );
	}
	return $token;
}

function daan_ot_cron_when( $key ) {
	$t = (int) get_option( $key, 0 );
	return $t ? wp_date( 'j M Y, g:i A', $t, new DateTimeZone( 'Asia/Kolkata' ) ) : 'never';
}

// Checked on normal page loads (not by cron, which may be the thing that stopped), at most every 10 minutes.
add_action( 'shutdown', function () {
	if ( wp_doing_cron() || ( defined( 'WP_CLI' ) && WP_CLI ) || ! daan_ot_cron_stale() || get_transient( 'daan_ot_cron_checked' ) ) {
		return;
	}
	set_transient( 'daan_ot_cron_checked', 1, 10 * MINUTE_IN_SECONDS );
	if ( time() - (int) get_option( DAAN_OT_CRON_ALERTED, 0 ) < DAY_IN_SECONDS ) {
		return;
	}
	update_option( DAAN_OT_CRON_ALERTED, time(), false );
	if ( function_exists( 'fastcgi_finish_request' ) ) {
		fastcgi_finish_request();
	}
	$html = '<p style="font-family:Arial,Helvetica,sans-serif;font-size:15px;line-height:1.6;">The site cron has not run since <b>' . esc_html( daan_ot_cron_when( DAAN_OT_CRON_LAST ) ) . '</b>. Execution emails, auto-cancel, the digest and mail retries are waiting. Please check the hPanel cron job.</p>';
	wp_mail( array( DAAN_OT_ALERT_TO, DAAN_OT_BCC ), 'Cron stopped – daanfoundation.in', $html, array( 'Content-Type: text/html; charset=UTF-8' ) );
}, 20 );

add_action( 'admin_notices', function () {
	if ( current_user_can( 'manage_options' ) && daan_ot_cron_stale() ) {
		echo '<div class="notice notice-error"><p><b>Cron stopped:</b> the site cron has not run since ' . esc_html( daan_ot_cron_when( DAAN_OT_CRON_LAST ) ) . '. Execution emails, auto-cancel, digest and mail retries are waiting.</p></div>';
	}
} );

// Outside check (UptimeRobot): 200 "CRON OK" or 503 "CRON STALE", with the last run time. Nothing else is shown.
add_action( 'init', function () {
	if ( ! isset( $_GET['daan_cron_status'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		return;
	}
	$given = (string) wp_unslash( $_GET['daan_cron_status'] ); // phpcs:ignore WordPress.Security.NonceVerification,WordPress.Security.ValidatedSanitizedInput
	$token = (string) get_option( DAAN_OT_CRON_TOKEN, '' );
	if ( '' === $token || ! hash_equals( $token, $given ) ) {
		return;
	}
	nocache_headers();
	header( 'Content-Type: text/plain; charset=UTF-8' );
	header( 'X-Robots-Tag: noindex, nofollow' );
	$stale = daan_ot_cron_stale();
	status_header( $stale ? 503 : 200 );
	echo ( $stale ? 'CRON STALE' : 'CRON OK' ) . "\nlast run: " . esc_html( daan_ot_cron_when( DAAN_OT_CRON_LAST ) ) . "\nserver cron last run: " . esc_html( daan_ot_cron_when( DAAN_OT_CRON_CLI_LAST ) ) . "\n";
	exit;
}, 0 );

add_action( 'init', function () {
	if ( ! wp_next_scheduled( 'daan_ot_hourly' ) ) {
		wp_schedule_event( time() + 600, 'hourly', 'daan_ot_hourly' );
	}
} );

register_deactivation_hook( __FILE__, function () {
	wp_clear_scheduled_hook( 'daan_ot_hourly' );
} );

add_action( 'admin_init', function () {
	register_setting(
		'daan_ot_automation',
		DAAN_OT_PAUSE_OPTION,
		array(
			'type'              => 'string',
			'default'           => 'no',
			'sanitize_callback' => function ( $value ) {
				return 'yes' === $value ? 'yes' : 'no';
			},
		)
	);
	register_setting(
		'daan_ot_automation',
		DAAN_OT_ENABLED_OPTION,
		array(
			'type'              => 'string',
			'default'           => 'no',
			'sanitize_callback' => function ( $value ) {
				return 'yes' === $value ? 'yes' : 'no';
			},
		)
	);
} );

add_action( 'admin_menu', function () {
	add_submenu_page( 'woocommerce', 'Order Automation', 'Order Automation', 'manage_options', 'daan-order-automation', function () {
		?>
		<div class="wrap">
			<h1>Order Automation</h1>
			<p>Applies only to orders created from <?php echo esc_html( wp_date( 'j M Y, g:i A', daan_order_cutoff() ) ); ?> on.</p>
			<h2>Cron</h2>
			<p>Last cron run: <b><?php echo esc_html( daan_ot_cron_when( DAAN_OT_CRON_LAST ) ); ?></b> · server cron (hPanel) last run: <b><?php echo esc_html( daan_ot_cron_when( DAAN_OT_CRON_CLI_LAST ) ); ?></b><?php echo daan_ot_cron_stale() ? ' · <b style="color:#b32d2e">STALE</b>' : ''; ?></p>
			<p>Status URL for UptimeRobot (keep private): <code><?php echo esc_html( add_query_arg( 'daan_cron_status', daan_ot_cron_token(), home_url( '/' ) ) ); ?></code></p>
			<form method="post" action="options.php">
				<?php settings_fields( 'daan_ot_automation' ); ?>
				<p><label><input type="checkbox" name="<?php echo esc_attr( DAAN_OT_ENABLED_OPTION ); ?>" value="yes" <?php checked( daan_ot_automation_on() ); ?>> Send execution e-mails and auto-cancel unpaid donations</label></p>
				<p><label><input type="checkbox" name="<?php echo esc_attr( DAAN_OT_PAUSE_OPTION ); ?>" value="yes" <?php checked( daan_ot_autocancel_paused() ); ?>> Pause auto-cancel</label></p>
				<p class="description">No button pressed: cancelled 6 hours after the second digest. "Payment not received": cancelled after 24 hours. While paused, nothing is cancelled and digests are not counted; timers continue from where they stopped. Execution e-mails are not affected.</p>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	} );
}, 99 );
