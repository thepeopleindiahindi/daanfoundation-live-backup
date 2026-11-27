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
	// D-042: orders completed after the new update rule went live are handled only by donor-updates.php.
	if ( function_exists( 'daan_upd_completed_at' ) && daan_upd_completed_at( $order ) >= daan_upd_live_at() ) {
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
				<?php if ( function_exists( 'daan_upd_settings_rows' ) ) { daan_upd_settings_rows(); } ?>
				<h2>Fidyah &amp; Kaffarah</h2>
				<p><label><input type="checkbox" name="<?php echo esc_attr( DAAN_OT_FK_PAUSE_OPTION ); ?>" value="yes" <?php checked( daan_fk_paused() ); ?>> Pause Fidyah &amp; Kaffarah donations</label></p>
				<p class="description">While ticked, no NEW Fidyah &amp; Kaffarah donation can be made (form, links, product page, checkout) and donors see a notice. Existing orders are not affected: digest, buttons, auto-cancel, receipts and execution e-mails continue. Untick to reopen.</p>
				<h2>Fitrana, Fidyah &amp; Ration Kits</h2>
				<p class="description"><b>This year's estimate; may change in Ramadan.</b> Every amount on the site (Zakat, Zakat al-Fitr, Fidya, Bank Interest pages, Terms, both kit products) comes from here (docs/fiqh/decisions.md D-006, D-021, D-029).</p>
				<table class="form-table" role="presentation">
					<tr><th>Fitrana: wheat (₹ per person)</th><td><input type="number" min="1" step="1" style="width:110px" name="<?php echo esc_attr( DAAN_OT_FITRANA_OPTION ); ?>" value="<?php echo esc_attr( daan_fitrana_rate() ); ?>"> <span class="description">The minimum. Also Fidyah per missed fast.</span></td></tr>
					<tr><th>Fitrana: barley (₹ per person)</th><td><input type="number" min="1" step="1" style="width:110px" name="daan_rate_barley" value="<?php echo esc_attr( daan_rate( 'barley' ) ); ?>"></td></tr>
					<tr><th>Fitrana: dates (₹ per person)</th><td><input type="number" min="1" step="1" style="width:110px" name="daan_rate_dates" value="<?php echo esc_attr( daan_rate( 'dates' ) ); ?>"></td></tr>
					<tr><th>Fitrana: raisins (₹ per person)</th><td><input type="number" min="1" step="1" style="width:110px" name="daan_rate_raisins" value="<?php echo esc_attr( daan_rate( 'raisins' ) ); ?>"></td></tr>
					<tr><th>Iftar kit price (₹ per kit)</th><td><input type="number" min="1" step="1" style="width:110px" name="daan_iftar_kit_price" value="<?php echo esc_attr( daan_iftar_kit_price() ); ?>"> <span class="description">Ramadan Iftar product (quantity). Iftar is never Fidyah or Fitrana (D-012).</span></td></tr>
					<tr><th>Iftar kit items</th><td><textarea name="daan_iftar_kit_items" rows="3" cols="60"><?php echo esc_textarea( daan_iftar_kit_items_text() ); ?></textarea></td></tr>
					<tr><th>Ration kit price (₹ per kit)</th><td><input type="number" min="1" step="1" style="width:110px" name="daan_kit_price" value="<?php echo esc_attr( daan_kit_price() ); ?>"> <span class="description">All three ration kit products: Ration Kit (Zakat/Sadaqah), Ration Kit (Interest Money) and Fitrana Ration Kit.</span></td></tr>
					<tr><th>Community Kitchen meal price (₹ per meal)</th><td><input type="number" min="1" step="1" style="width:110px" name="daan_meal_price" value="<?php echo esc_attr( daan_meal_price() ); ?>"> <span class="description">Donation forms: Community Kitchen is chosen as a number of meals.</span></td></tr>
					<tr><th>Kit food value for Fitrana (internal, not shown)</th><td><input type="number" min="0" step="1" style="width:110px" name="daan_kit_food_value" value="<?php echo esc_attr( (string) get_option( 'daan_kit_food_value', '' ) ); ?>"> <span class="description">₹ value of the food items in one kit. Leave EMPTY until confirmed: while empty, the Fitrana calculator stays hidden.</span></td></tr>
					<tr><th>Ration kit items (one per line)</th><td><textarea name="daan_kit_items" rows="18" cols="60"><?php echo esc_textarea( daan_kit_items_text() ); ?></textarea><p class="description">Name and weight only, no prices. The same list shows on both kit products, the Bank Interest page and the Zakat al-Fitr page.</p></td></tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	} );
}, 99 );

/* -------------------------------------------------------------------------
 * 8. Temporary hold on NEW Fidyah & Kaffarah donations (owner, 2026-11-20).
 *    One checkbox under WooCommerce > Order Automation. Existing orders are
 *    untouched: digest, buttons, auto-cancel, receipts and execution e-mails
 *    keep running. Untick the box to reopen; nothing here deletes anything.
 * ------------------------------------------------------------------------- */

const DAAN_OT_FK_PAUSE_OPTION = 'daan_ot_fk_paused';
const DAAN_OT_FK_PRODUCTS     = array( 6812, 5922 );
const DAAN_OT_FK_POSTS        = array( 5849, 6768, 6946, 6978 ); // Pages/posts about Fidyah or Kaffarah.
const DAAN_OT_FK_MESSAGE      = 'Daan Foundation is no longer accepting Fidyah or Kaffarah donations. Please choose another cause.';

function daan_fk_paused() {
	return 'yes' === get_option( DAAN_OT_FK_PAUSE_OPTION, 'no' );
}

/** True for any spelling of the Fidyah & Kaffarah cause or line name. */
function daan_fk_is_cause( $name ) {
	$key = strtolower( html_entity_decode( (string) $name, ENT_QUOTES, 'UTF-8' ) );
	return (bool) preg_match( '/fid[iy]a|kaff?ara/', $key );
}

function daan_fk_is_product( $product ) {
	$product = is_numeric( $product ) ? wc_get_product( $product ) : $product;
	if ( ! $product ) {
		return false;
	}
	$id = $product->get_parent_id() ? $product->get_parent_id() : $product->get_id();
	return in_array( (int) $id, DAAN_OT_FK_PRODUCTS, true );
}

function daan_fk_notice_html() {
	return '<div class="daan-fk-notice" role="status" style="border:2px solid #F59E0B;background:#FFFBEB;color:#78350F;border-radius:12px;padding:16px 20px;margin:16px 0;text-align:left;font-size:1rem;line-height:1.6;">'
		. '<strong style="display:block;font-size:1.0625rem;margin-bottom:6px;color:#78350F;">We are no longer accepting Fidyah or Kaffarah donations.</strong>'
		. 'Our kitchen serves food at only one time of the day, so we cannot serve at two separate times, as Kaffarah requires. Please read our update on the <a href="/fidya/" style="color:#B45309;font-weight:700;text-decoration:underline;">Fidyah page</a>. For guidance, contact us on WhatsApp '
		. '<a href="https://wa.me/919528206525" target="_blank" rel="noopener" style="color:#B45309;font-weight:700;text-decoration:underline;">+91 95282 06525</a>.'
		. '</div>';
}

// Products 6812 and 5922 cannot be bought (cart, checkout and Store API all check this).
add_filter( 'woocommerce_is_purchasable', function ( $ok, $product ) {
	return ( $ok && daan_fk_paused() && daan_fk_is_product( $product ) ) ? false : $ok;
}, 20, 2 );
add_filter( 'woocommerce_variation_is_purchasable', function ( $ok, $product ) {
	return ( $ok && daan_fk_paused() && daan_fk_is_product( $product ) ) ? false : $ok;
}, 20, 2 );

add_filter( 'woocommerce_add_to_cart_validation', function ( $ok, $product_id ) {
	if ( $ok && daan_fk_paused() && daan_fk_is_product( (int) $product_id ) ) {
		wc_add_notice( DAAN_OT_FK_MESSAGE, 'error' );
		return false;
	}
	return $ok;
}, 20, 2 );

// Checkout (classic and block): no NEW order with a Fidyah & Kaffarah line or cause.
add_action( 'woocommerce_checkout_create_order', function ( $order ) {
	if ( ! daan_fk_paused() ) {
		return;
	}
	foreach ( $order->get_items() as $item ) {
		if ( daan_fk_is_product( (int) $item->get_product_id() ) || daan_fk_is_cause( $item->get_name() ) ) {
			throw new Exception( DAAN_OT_FK_MESSAGE );
		}
	}
	if ( daan_fk_is_cause( $order->get_meta( '_daan_donation_cause' ) ) ) {
		throw new Exception( DAAN_OT_FK_MESSAGE );
	}
}, 5 );
add_action( 'woocommerce_store_api_checkout_update_order_from_request', function ( $order ) {
	if ( ! daan_fk_paused() ) {
		return;
	}
	foreach ( $order->get_items() as $item ) {
		if ( daan_fk_is_product( (int) $item->get_product_id() ) ) {
			if ( class_exists( '\Automattic\WooCommerce\StoreApi\Exceptions\RouteException' ) ) {
				throw new \Automattic\WooCommerce\StoreApi\Exceptions\RouteException( 'daan_fk_paused', DAAN_OT_FK_MESSAGE, 400 );
			}
			throw new Exception( DAAN_OT_FK_MESSAGE );
		}
	}
} );

// Product page: notice where the add-to-cart button was.
add_action( 'woocommerce_single_product_summary', function () {
	global $product;
	if ( daan_fk_paused() && $product && daan_fk_is_product( $product ) ) {
		echo daan_fk_notice_html(); // phpcs:ignore WordPress.Security.EscapeOutput
	}
}, 25 );

// Pages/posts: donate links for this cause become the notice; content stays as it is.
add_filter( 'the_content', function ( $content ) {
	if ( ! daan_fk_paused() || is_admin() ) {
		return $content;
	}
	$pattern = '~<a\b[^>]*href=["\'][^"\']*(?:cause=(?:fid|kaff)[^"\']*|/product/(?:fidyah-kaffarah|fidya-and-kaffara)/?|add-to-cart=(?:6812|5922)[^"\']*)["\'][^>]*>.*?</a>~is';
	$content = preg_replace( $pattern, daan_fk_notice_html(), $content );
	if ( in_array( (int) get_the_ID(), DAAN_OT_FK_POSTS, true ) && in_the_loop() && is_singular() ) {
		// Plain /donate/ links here would lead to a form without this cause: keep the words, drop the link.
		$content = preg_replace( '~<a\b[^>]*href=["\'](?:https?://(?:www\.)?daanfoundation\.in)?/donate/?["\'][^>]*>(.*?)</a>~is', '$1', $content );
		if ( false === strpos( $content, 'daan-fk-notice' ) ) {
			$content = daan_fk_notice_html() . $content;
		}
	}
	return $content;
}, 20 );

add_action( 'admin_init', function () {
	register_setting(
		'daan_ot_automation',
		DAAN_OT_FK_PAUSE_OPTION,
		array(
			'type'              => 'string',
			'default'           => 'no',
			'sanitize_callback' => function ( $value ) {
				return 'yes' === $value ? 'yes' : 'no';
			},
		)
	);
} );

/* -------------------------------------------------------------------------
 * 9. Fitrana, Fidyah and Ration Kits (owner, 2026-11-21;
 *    docs/fiqh/decisions.md D-006, D-019 to D-022, D-029, D-030).
 *    All amounts and the kit list are set under WooCommerce > Order Automation.
 *    Shortcodes: [daan_fitrana_rate] (wheat), [daan_rate item="barley"],
 *    [daan_kit_price], [daan_kit_items], [daan_fitrana_calculator].
 *    Two kit products (ids in options daan_kit_interest_product and
 *    daan_kit_fitrana_product): fixed price from the setting, quantity only on
 *    these two, never in one cart together, no execution e-mail.
 * ------------------------------------------------------------------------- */

const DAAN_OT_FITRANA_OPTION = 'daan_fitrana_rate'; // Wheat, per person; also Fidyah per missed fast.

function daan_fitrana_rate() {
	$rate = (int) get_option( DAAN_OT_FITRANA_OPTION, 90 );
	return $rate > 0 ? $rate : 90;
}

/** Fitrana rate per person for wheat, barley, dates or raisins. */
function daan_rate( $item ) {
	$defaults = array( 'wheat' => 90, 'barley' => 175, 'dates' => 525, 'raisins' => 3500 );
	if ( 'wheat' === $item ) {
		return daan_fitrana_rate();
	}
	if ( ! isset( $defaults[ $item ] ) ) {
		return 0;
	}
	$rate = (int) get_option( 'daan_rate_' . $item, $defaults[ $item ] );
	return $rate > 0 ? $rate : $defaults[ $item ];
}

function daan_kit_price() {
	$price = (int) get_option( 'daan_kit_price', 1536 );
	return $price > 0 ? $price : 1536;
}

/** Internal value of the food items in one kit; 0 while the setting is empty. */
function daan_kit_food_value() {
	$value = (int) get_option( 'daan_kit_food_value', 0 );
	return $value > 0 ? $value : 0;
}

function daan_kit_items_text() {
	$text = trim( (string) get_option( 'daan_kit_items', '' ) );
	if ( '' !== $text ) {
		return $text;
	}
	return implode(
		"\n",
		array(
			'Aata (Wheat Flour) — 5 kg',
			'Chawal (Rice) — 5 kg',
			'Cheeni (Sugar) — 1 kg',
			'Chai Patti (Tea) — 250 g',
			'Haldi (Turmeric) — 100 g',
			'Lal Mirch (Red Chilli) — 100 g',
			'Dhaniya (Coriander) — 100 g',
			'Namak (Salt) — 1 kg',
			'Refined Oil — 3 pouch',
			'Surf (Detergent) — 500 g',
			'Kala Chana (Black Chickpea) — 500 g',
			'Arhar Dal (Pigeon Pea) — 200 g',
			'Moong Dal (Green Gram) — 200 g',
			'Masoor Dal (Red Lentil) — 200 g',
			'Urad Dal (Black Gram) — 200 g',
			'Chana Dal (Split Chickpea) — 200 g',
			'Aaloo (Potato) — 3 kg',
			'Garam Masala Mix — 100 g (60 g Jeera/Cumin + 40 g other spices)',
		)
	);
}

function daan_kit_items_html() {
	$lines = array_filter( array_map( 'trim', explode( "\n", daan_kit_items_text() ) ) );
	$html  = '<ul class="daan-kit-items" style="columns:2;column-gap:24px;margin:8px 0 16px;padding-left:20px;">';
	foreach ( $lines as $line ) {
		$html .= '<li style="margin:0 0 4px;break-inside:avoid;">' . esc_html( $line ) . '</li>';
	}
	return $html . '</ul>';
}

function daan_rupees( $amount ) {
	return '&#8377;' . number_format_i18n( (int) $amount );
}

add_shortcode( 'daan_fitrana_rate', function () {
	return daan_rupees( daan_fitrana_rate() );
} );
add_shortcode( 'daan_rate', function ( $atts ) {
	$atts = shortcode_atts( array( 'item' => 'wheat' ), $atts );
	return daan_rupees( daan_rate( sanitize_key( $atts['item'] ) ) );
} );
add_shortcode( 'daan_kit_price', function () {
	return daan_rupees( daan_kit_price() );
} );
add_shortcode( 'daan_kit_items', 'daan_kit_items_html' );

add_action( 'admin_init', function () {
	$positive = function ( $default ) {
		return function ( $value ) use ( $default ) {
			$value = (int) $value;
			return $value > 0 ? $value : $default;
		};
	};
	register_setting( 'daan_ot_automation', DAAN_OT_FITRANA_OPTION, array( 'type' => 'integer', 'default' => 90, 'sanitize_callback' => $positive( 90 ) ) );
	register_setting( 'daan_ot_automation', 'daan_rate_barley', array( 'type' => 'integer', 'default' => 175, 'sanitize_callback' => $positive( 175 ) ) );
	register_setting( 'daan_ot_automation', 'daan_rate_dates', array( 'type' => 'integer', 'default' => 525, 'sanitize_callback' => $positive( 525 ) ) );
	register_setting( 'daan_ot_automation', 'daan_rate_raisins', array( 'type' => 'integer', 'default' => 3500, 'sanitize_callback' => $positive( 3500 ) ) );
	register_setting( 'daan_ot_automation', 'daan_kit_price', array( 'type' => 'integer', 'default' => 1536, 'sanitize_callback' => $positive( 1536 ) ) );
	register_setting( 'daan_ot_automation', 'daan_iftar_kit_price', array( 'type' => 'integer', 'default' => 91, 'sanitize_callback' => $positive( 91 ) ) );
	register_setting( 'daan_ot_automation', 'daan_meal_price', array( 'type' => 'integer', 'default' => 60, 'sanitize_callback' => $positive( 60 ) ) );
	register_setting( 'daan_ot_automation', 'daan_iftar_kit_items', array( 'type' => 'string', 'default' => '', 'sanitize_callback' => 'sanitize_textarea_field' ) );
	register_setting(
		'daan_ot_automation',
		'daan_kit_food_value',
		array(
			'type'              => 'string',
			'default'           => '',
			'sanitize_callback' => function ( $value ) {
				$value = trim( (string) $value );
				return ( '' === $value || (int) $value <= 0 ) ? '' : (string) (int) $value; // Empty keeps the calculator hidden.
			},
		)
	);
	register_setting(
		'daan_ot_automation',
		'daan_kit_items',
		array(
			'type'              => 'string',
			'default'           => '',
			'sanitize_callback' => function ( $value ) {
				$lines = array_filter( array_map( 'sanitize_text_field', explode( "\n", str_replace( "\r", '', (string) $value ) ) ) );
				return implode( "\n", $lines );
			},
		)
	);
} );

/* ---- The kit products: Interest kit, Fitrana kit, Iftar kit (D-012, D-019, D-022) ---- */

/** Iftar kit price per kit (separate from the ration kit price and from Fitrana; ₹91 is never ₹90). */
function daan_iftar_kit_price() {
	$price = (int) get_option( 'daan_iftar_kit_price', 91 );
	return $price > 0 ? $price : 91;
}

function daan_iftar_kit_items_text() {
	$text = trim( (string) get_option( 'daan_iftar_kit_items', '' ) );
	return '' !== $text ? $text : 'A full plate of veg biryani, 2 dates, 1 banana or seasonal fruit, 1 egg and 1 soft drink (sometimes 2 eggs instead of the drink).';
}

add_shortcode( 'daan_iftar_kit_price', function () {
	return daan_rupees( daan_iftar_kit_price() );
} );
add_shortcode( 'daan_iftar_kit_items', function () {
	return esc_html( daan_iftar_kit_items_text() );
} );

/** 'interest', 'fitrana', 'iftar' or '' for any product (or variation) id. */
function daan_kit_type( $product_id ) {
	$product_id = (int) $product_id;
	if ( $product_id <= 0 ) {
		return '';
	}
	if ( $product_id === (int) get_option( 'daan_kit_interest_product', 0 ) ) {
		return 'interest';
	}
	if ( $product_id === (int) get_option( 'daan_kit_fitrana_product', 0 ) ) {
		return 'fitrana';
	}
	if ( $product_id === (int) get_option( 'daan_kit_iftar_product', 0 ) ) {
		return 'iftar';
	}
	if ( $product_id === (int) get_option( 'daan_kit_general_product', 0 ) ) {
		return 'general';
	}
	if ( DAAN_OT_MEAL_PRODUCT === $product_id ) {
		return 'meal'; // Community Kitchen product: meals x meal price (owner, 2026-11-23).
	}
	return '';
}

/** Community Kitchen: price of one meal (setting; ₹60). */
function daan_meal_price() {
	$price = (int) get_option( 'daan_meal_price', 60 );
	return $price > 0 ? $price : 60;
}

/** General Ration Kit: the donor's own choice, 'zakat' or 'sadaqah' ('' when missing or wrong). */
function daan_kit_fund( $raw ) {
	$raw = strtolower( sanitize_text_field( (string) $raw ) );
	return in_array( $raw, array( 'zakat', 'sadaqah' ), true ) ? $raw : '';
}

/** Order cause of a General Ration Kit: "Ration Kit (Zakat)" or "Ration Kit (Sadaqah)" (Zakat kept apart, D-008). */
function daan_kit_general_cause( $fund = '' ) {
	// D-040 (owner, 2026-11-23): no Zakat/Sadaqah head for the general Ration Kit; new orders are simply "Ration Kit".
	// Old orders keep the cause saved on them ("Ration Kit (Zakat)" / "Ration Kit (Sadaqah)").
	return 'Ration Kit';
}

/**
 * Fixed-price causes on the donation forms (homepage, /donate/, sidebars). Amount = unit × count; units from settings.
 * kit = kit type ('' = Community Kitchen, a fee line); fund = donor chooses Zakat or Sadaqah.
 */
function daan_fixed_causes() {
	$kit = daan_kit_price();
	return array(
		'Community Kitchen'           => array( 'unit' => daan_meal_price(), 'one' => 'meal', 'many' => 'meals', 'kit' => '', 'fund' => false ),
		'Ramadan Iftar'               => array( 'unit' => daan_iftar_kit_price(), 'one' => 'kit', 'many' => 'kits', 'kit' => 'iftar', 'fund' => false ),
		'Ration Kit'                  => array( 'unit' => $kit, 'one' => 'kit', 'many' => 'kits', 'kit' => 'general', 'fund' => false ), // D-040: no head choice
		'Ration Kit (Interest Money)' => array( 'unit' => $kit, 'one' => 'kit', 'many' => 'kits', 'kit' => 'interest', 'fund' => false ),
		'Fitrana Ration Kit'          => array( 'unit' => $kit, 'one' => 'kit', 'many' => 'kits', 'kit' => 'fitrana', 'fund' => false ),
	);
}

/** Most units in one donation for a fixed cause (₹10,00,000 limit ÷ unit). */
function daan_fixed_max_qty( $unit ) {
	$limit = defined( 'DAAN_MAX_DONATION' ) ? DAAN_MAX_DONATION : 1000000;
	return max( 1, (int) floor( $limit / max( 1, (int) $unit ) ) );
}

/** Price of one kit of this type, always from the settings. */
function daan_kit_unit_price( $type ) {
	if ( 'meal' === $type ) {
		return daan_meal_price();
	}
	return 'iftar' === $type ? daan_iftar_kit_price() : daan_kit_price();
}

/** "kits" / "meals" for messages; "Number of iftar kits" style label for the product page. */
function daan_kit_unit_words( $type ) {
	return 'meal' === $type ? array( 'meal', 'meals' ) : array( 'kit', 'kits' );
}
function daan_kit_qty_label( $type ) {
	if ( 'meal' === $type ) {
		return 'Number of meals';
	}
	return 'iftar' === $type ? 'Number of iftar kits' : 'Number of kits';
}

function daan_kit_cause( $type ) {
	$causes = array( 'interest' => 'Ration Kit (Interest Money)', 'fitrana' => 'Zakat al-Fitr', 'iftar' => 'Ramadan Iftar', 'general' => 'Ration Kit', 'meal' => 'Community Kitchen' );
	return $causes[ $type ] ?? '';
}

function daan_kit_url( $type ) {
	$options = array( 'interest' => 'daan_kit_interest_product', 'fitrana' => 'daan_kit_fitrana_product', 'iftar' => 'daan_kit_iftar_product', 'general' => 'daan_kit_general_product' );
	$id      = isset( $options[ $type ] ) ? (int) get_option( $options[ $type ], 0 ) : 0;
	return $id ? get_permalink( $id ) : home_url( '/donate/' );
}

// Price always comes from the setting (server side); a typed amount is never used for a kit.
foreach ( array( 'woocommerce_product_get_price', 'woocommerce_product_get_regular_price' ) as $daan_kit_price_hook ) {
	add_filter( $daan_kit_price_hook, function ( $price, $product ) {
		$type = daan_kit_type( $product->get_id() );
		return $type ? (string) daan_kit_unit_price( $type ) : $price;
	}, 20, 2 );
}

// Quantity only on the kits; every other cause stays at one (theme: inc/donation-wording.php).
add_filter( 'woocommerce_is_sold_individually', function ( $individually, $product ) {
	return ( $product && daan_kit_type( $product->get_id() ) ) ? false : $individually;
}, 20, 2 );

/** Most kits in one donation: the site's upper limit (₹10,00,000) divided by the kit price. */
function daan_kit_max_qty( $type = 'interest' ) {
	$limit = defined( 'DAAN_MAX_DONATION' ) ? DAAN_MAX_DONATION : 1000000;
	return max( 1, (int) floor( $limit / daan_kit_unit_price( $type ) ) );
}

add_filter( 'woocommerce_quantity_input_args', function ( $args, $product ) {
	$type = $product ? daan_kit_type( $product->get_id() ) : '';
	if ( $type ) {
		$args['min_value'] = 1;
		$args['max_value'] = daan_kit_max_qty( $type );
		$args['step']      = 1;
	}
	return $args;
}, 20, 2 );

add_action( 'woocommerce_before_add_to_cart_quantity', function () {
	global $product;
	$type = $product ? daan_kit_type( $product->get_id() ) : '';
	if ( $type ) {
		$w = daan_kit_unit_words( $type );
		printf( '<p class="daan-qty-label" data-unit="%1$d" data-max="%2$d" data-one="%3$s" data-many="%4$s" style="margin:0 0 6px;font-weight:600;">%5$s (%6$s each)</p>', (int) daan_kit_unit_price( $type ), (int) daan_kit_max_qty( $type ), esc_attr( $w[0] ), esc_attr( $w[1] ), esc_html( daan_kit_qty_label( $type ) ), daan_rupees( daan_kit_unit_price( $type ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
} );

function daan_kit_types_in_cart( $skip_key = '' ) {
	$types = array();
	if ( function_exists( 'WC' ) && WC()->cart ) {
		foreach ( WC()->cart->get_cart() as $key => $item ) {
			$type = daan_kit_type( $item['product_id'] );
			if ( $type && $key !== $skip_key ) {
				$types[ $type ] = true;
			}
		}
	}
	return array_keys( $types );
}

function daan_kit_mix_message() {
	return 'Ration Kits, Fitrana Ration Kits and Ration Kits (Interest Money) are kept completely separate. Please give them as separate donations.';
}

/** True when the cart (plus an optional new type) holds Interest + Fitrana kits, or a Ration Kit with any other kit. */
function daan_kit_mixed( $types ) {
	$types = array_values( array_diff( array_unique( $types ), array( 'meal' ) ) ); // meals mix with anything
	if ( in_array( 'general', $types, true ) && count( $types ) > 1 ) {
		return true;
	}
	return in_array( 'interest', $types, true ) && in_array( 'fitrana', $types, true );
}

/** Zakat/Sadaqah choices of the Ration Kits already in the cart. */
function daan_kit_funds_in_cart() {
	$funds = array();
	if ( function_exists( 'WC' ) && WC()->cart ) {
		foreach ( WC()->cart->get_cart() as $item ) {
			if ( 'general' === daan_kit_type( $item['product_id'] ) && ! empty( $item['daan_kit_fund'] ) ) {
				$funds[ $item['daan_kit_fund'] ] = true;
			}
		}
	}
	return array_keys( $funds );
}

// Interest kits and Fitrana kits never in one cart (their money is never mixed). Iftar kits may go with either.
add_filter( 'woocommerce_add_to_cart_validation', function ( $passed, $product_id, $quantity = 1 ) {
	$type = daan_kit_type( $product_id );
	if ( ! $type ) {
		return $passed;
	}
	if ( daan_kit_mixed( array_merge( daan_kit_types_in_cart(), array( $type ) ) ) ) {
		wc_add_notice( daan_kit_mix_message(), 'error' );
		return false;
	}
	if ( (int) $quantity < 1 || (int) $quantity > daan_kit_max_qty( $type ) ) {
		wc_add_notice( 'Please choose between 1 and ' . daan_kit_max_qty( $type ) . ' ' . daan_kit_unit_words( $type )[1] . '.', 'error' );
		return false;
	}
	return $passed; // D-040: the general Ration Kit has no Zakat/Sadaqah choice.
}, 20, 3 );

// General Ration Kit: the Zakat/Sadaqah choice on the product page (required), kept on the cart line.
add_action( 'woocommerce_before_add_to_cart_button', function () {
	return; // D-040: no Zakat/Sadaqah choice on the general Ration Kit any more.
	global $product;
	if ( ! $product || 'general' !== daan_kit_type( $product->get_id() ) ) {
		return;
	}
	?>
	<fieldset class="daan-kit-fund" style="border:2px solid #FDBA74;border-radius:12px;padding:12px 16px;margin:0 0 14px;background:#FFF7ED;">
		<legend style="font-weight:700;padding:0 6px;">This is my: <span style="color:#B91C1C;">*</span></legend>
		<label style="display:inline-flex;align-items:center;gap:8px;margin:4px 20px 4px 0;cursor:pointer;"><input type="radio" name="daan_kit_fund" value="zakat" required onchange="document.getElementById('daan-zakat-line').style.display='block'"> Zakat</label>
		<label style="display:inline-flex;align-items:center;gap:8px;margin:4px 0;cursor:pointer;"><input type="radio" name="daan_kit_fund" value="sadaqah" required onchange="document.getElementById('daan-zakat-line').style.display='none'"> Sadaqah</label>
		<p id="daan-zakat-line" style="display:none;margin:8px 0 0;font-size:0.9375rem;"><?php echo esc_html( DAAN_OT_ZAKAT_KIT_LINE ); ?></p>
	</fieldset>
	<?php
} );
const DAAN_OT_MEAL_PRODUCT = 5925;
const DAAN_OT_ZAKAT_KIT_LINE = 'Your Zakat is given only to eligible Muslim families, who receive and own the kit.';

add_filter( 'woocommerce_add_cart_item_data', function ( $data, $product_id ) {
	if ( 'general' === daan_kit_type( $product_id ) ) {
		$fund = daan_kit_fund( wp_unslash( $_POST['daan_kit_fund'] ?? '' ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
		if ( $fund ) {
			$data['daan_kit_fund'] = $fund;
		}
	}
	return $data;
}, 10, 2 );

add_filter( 'woocommerce_get_item_data', function ( $rows, $item ) {
	if ( 'general' === daan_kit_type( $item['product_id'] ?? 0 ) && ! empty( $item['daan_kit_fund'] ) ) {
		$rows[] = array( 'key' => 'This is my', 'value' => 'zakat' === $item['daan_kit_fund'] ? 'Zakat' : 'Sadaqah' );
	}
	return $rows;
}, 10, 2 );

// Cart and checkout (classic and block): amount must be kits x kit price, and no mixing.
add_action( 'woocommerce_check_cart_items', function () {
	if ( ! WC()->cart ) {
		return;
	}
	if ( daan_kit_mixed( daan_kit_types_in_cart() ) ) {
		wc_add_notice( daan_kit_mix_message(), 'error' );
	}
	foreach ( WC()->cart->get_cart() as $item ) {
		$type = daan_kit_type( $item['product_id'] );
		if ( ! $type ) {
			continue;
		}
		$unit     = daan_kit_unit_price( $type );
		$qty      = (int) $item['quantity'];
		$expected = $qty * $unit;
		$line     = (float) ( $item['line_subtotal'] ?? ( $item['data']->get_price( 'edit' ) * $qty ) );
		if ( $qty < 1 || $qty > daan_kit_max_qty( $type ) || abs( $line - $expected ) > 0.01 ) {
			wc_add_notice( 'meal' === $type ? 'The amount is not correct. Each meal is ' . daan_rupees( $unit ) . '. Please update your donation.' : 'The kit amount is not correct. Each kit is ' . daan_rupees( $unit ) . '. Please update your donation.', 'error' );
		}
		if ( false && 'general' === $type && empty( $item['daan_kit_fund'] ) ) { // D-040: choice removed
			wc_add_notice( 'Please remove the Ration Kit and add it again, choosing Zakat or Sadaqah.', 'error' );
		}
	}
	if ( false && count( daan_kit_funds_in_cart() ) > 1 ) { // D-040
		wc_add_notice( 'Zakat and Sadaqah Ration Kits are kept separate. Please give them as two separate donations.', 'error' );
	}
} );

// Order line and order: the cause (receipt, digest, export read the line name; this adds the cause).
add_action( 'woocommerce_checkout_create_order_line_item', function ( $item, $cart_item_key, $values ) {
	$type = daan_kit_type( $values['product_id'] ?? 0 );
	if ( $type ) {
		$item->add_meta_data( 'Cause', 'general' === $type ? daan_kit_general_cause( $values['daan_kit_fund'] ?? '' ) : daan_kit_cause( $type ), true );
	}
}, 10, 3 );
add_action( 'woocommerce_checkout_create_order', function ( $order ) {
	foreach ( WC()->cart ? WC()->cart->get_cart() : array() as $item ) {
		$type = daan_kit_type( $item['product_id'] );
		if ( $type && 'iftar' !== $type ) {
			$order->update_meta_data( '_daan_donation_cause', 'general' === $type ? daan_kit_general_cause( $item['daan_kit_fund'] ?? '' ) : daan_kit_cause( $type ) );
			$order->update_meta_data( '_daan_kit_type', $type );
			break;
		}
	}
} );

/** [daan_iftar_buy]: number of Iftar kits + button straight to the cart (used on /ramadan/). */
add_shortcode( 'daan_iftar_buy', function () {
	$id = (int) get_option( 'daan_kit_iftar_product', 0 );
	if ( ! $id ) {
		return '';
	}
	$price = daan_iftar_kit_price();
	ob_start();
	?>
	<form method="post" action="<?php echo esc_url( get_permalink( $id ) ); ?>" style="border:2px solid #FDBA74;border-radius:16px;padding:20px;margin:0 0 16px;background:#FFF7ED;">
		<p style="margin:0 0 6px;font-weight:700;font-size:1.125rem;">Iftar kit: <?php echo daan_rupees( $price ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> each</p>
		<p style="margin:0 0 12px;"><?php echo esc_html( daan_iftar_kit_items_text() ); ?></p>
		<label style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin:0 0 12px;">
			<span style="font-weight:600;">Number of kits</span>
			<input type="number" name="quantity" value="1" min="1" max="<?php echo (int) daan_kit_max_qty( 'iftar' ); ?>" step="1" style="width:100px;border:2px solid #E2E8F0;border-radius:8px;padding:6px 8px;" oninput="this.form.querySelector('.daan-iftar-total').textContent='₹'+((parseInt(this.value,10)||0)*<?php echo (int) $price; ?>).toLocaleString('en-IN');">
			<span>Total: <b class="daan-iftar-total">₹<?php echo esc_html( number_format_i18n( $price ) ); ?></b></span>
		</label>
		<button type="submit" name="add-to-cart" value="<?php echo (int) $id; ?>" style="border:none;border-radius:9999px;background:#C2410C;color:#fff;padding:12px 24px;font-weight:700;cursor:pointer;">Donate Iftar Kits</button>
	</form>
	<?php
	return ob_get_clean();
} );

// Old product URLs stay LIVE and indexed (owner, 2026-11-21, D-032: old URLs are our property). Same title, meta,
// slug, canonical; they cannot be bought; each page shows the current product and a button to it.
// 5923 /product/bank-interest/ → Interest kit; 5920 /product/serving-iftar/ → Iftar kit;
// 5924 /product/sadqah/ → /product/sadaqah/; 5922 /product/fidya-and-kaffara/ → "temporarily paused", no donate.
const DAAN_OT_OLD_INTEREST_PRODUCT = 5923;

function daan_old_product_kind( $id ) {
	$map = array( 5923 => 'interest', 5920 => 'iftar', 5924 => 'sadqah', 5922 => 'fidya' );
	return $map[ (int) $id ] ?? '';
}

add_filter( 'woocommerce_is_purchasable', function ( $ok, $product ) {
	return ( $product && daan_old_product_kind( $product->get_id() ) ) ? false : $ok;
}, 30, 2 );

function daan_old_product_html( $kind ) {
	$btn = function ( $url, $label ) {
		return '<p><a href="' . esc_url( $url ) . '" style="display:inline-block;border-radius:9999px;background:#C2410C;color:#fff;padding:12px 24px;font-weight:700;text-decoration:none;">' . esc_html( $label ) . '</a></p>';
	};
	if ( 'interest' === $kind ) {
		return '<p>Interest money must be given away, without any intention of reward, to people in need. Daan Foundation uses it only for ration kits, which each family receives and owns. Your entire interest amount goes into the kit items; the cost of transport and our website is paid by Daan Foundation from its general funds. It is not counted as Zakat and is never used for staff, buildings or running costs.</p>'
			. '<p><strong>Each kit: ' . daan_rupees( daan_kit_price() ) . '. What is in one kit:</strong></p>' . daan_kit_items_html()
			. $btn( daan_kit_url( 'interest' ), 'Give Ration Kits (' . html_entity_decode( daan_rupees( daan_kit_price() ) ) . ' each)' );
	}
	if ( 'iftar' === $kind ) {
		return '<p>Our Iftar programme now gives Iftar kits. Each kit is ' . daan_rupees( daan_iftar_kit_price() ) . ': ' . esc_html( daan_iftar_kit_items_text() ) . '</p>'
			. '<p>Iftar kits are handed out at our Community Kitchen in Amroha after Asr, and people may take them home. Iftar is Sadaqah; Zakat may be given, but we request Sadaqah for Iftar so that more fasting people can be reached.</p>'
			. $btn( daan_kit_url( 'iftar' ), 'Donate Iftar Kits (' . html_entity_decode( daan_rupees( daan_iftar_kit_price() ) ) . ' each)' );
	}
	if ( 'sadqah' === $kind ) {
		$url = get_permalink( 6810 ) ?: home_url( '/product/sadaqah/' );
		return '<p>Sadaqah is voluntary charity given for the sake of Allah. Your Sadaqah through Daan Foundation supports our Community Kitchen, ration kits and help for families in need.</p>'
			. $btn( $url, 'Give Sadaqah' );
	}
	if ( 'fidya' === $kind ) {
		return '<p><strong>Fidyah &amp; Kaffarah donations are temporarily paused</strong> while we update this programme with our scholars. Iftar and Community Kitchen donations are not Fidyah or Kaffarah.</p>';
	}
	return '';
}

// Old product pages: the short description and the long description show the current text (DB fields untouched).
add_filter( 'woocommerce_short_description', function ( $text ) {
	$kind = is_singular( 'product' ) ? daan_old_product_kind( get_queried_object_id() ) : '';
	return $kind ? daan_old_product_html( $kind ) : $text;
}, 20 );
// The old long description held outdated claims: its tab is removed; the short description above has the current text.
add_filter( 'woocommerce_product_tabs', function ( $tabs ) {
	global $product;
	if ( $product && daan_old_product_kind( $product->get_id() ) ) {
		unset( $tabs['description'] );
	}
	return $tabs;
}, 30 );

// ?cause=bank-interest goes to the Interest kit; ?cause=fitrana goes to the Fitrana kit (added 2026-11-21).
add_action( 'template_redirect', function () {
	if ( isset( $_GET['cause'] ) && function_exists( 'daan_cause_from_link' ) && is_page( 'donate' ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$cause = daan_cause_from_link( sanitize_text_field( wp_unslash( $_GET['cause'] ) ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( 'Bank Interest' === $cause && get_option( 'daan_kit_interest_product' ) ) {
			wp_safe_redirect( daan_kit_url( 'interest' ), 301 );
			exit;
		}
		if ( 'Zakat al-Fitr' === $cause && get_option( 'daan_kit_fitrana_product' ) ) {
			wp_safe_redirect( daan_kit_url( 'fitrana' ), 301 );
			exit;
		}
	}
}, 5 );

/* ---- Fitrana calculator (D-030): hidden while "Kit food value for Fitrana" is empty ---- */

function daan_fitrana_calc( $counts ) {
	$food = daan_kit_food_value();
	if ( ! $food ) {
		return null;
	}
	$total = 0;
	foreach ( array( 'wheat', 'barley', 'dates', 'raisins' ) as $item ) {
		$total += max( 0, min( 100, (int) ( $counts[ $item ] ?? 0 ) ) ) * daan_rate( $item );
	}
	$kits = $total > 0 ? (int) ceil( $total / $food ) : 0;
	return array( 'total' => $total, 'kits' => $kits );
}

add_shortcode( 'daan_fitrana_calculator', function () {
	if ( ! daan_kit_food_value() || ! get_option( 'daan_kit_fitrana_product' ) ) {
		return '';
	}
	$rows = '';
	foreach ( array( 'wheat' => 'Wheat', 'barley' => 'Barley', 'dates' => 'Dates', 'raisins' => 'Raisins' ) as $key => $label ) {
		$rows .= '<label style="display:flex;justify-content:space-between;align-items:center;gap:12px;margin:0 0 10px;">'
			. '<span>' . esc_html( $label ) . ' (' . daan_rupees( daan_rate( $key ) ) . ' per person) — number of people</span>'
			. '<input type="number" min="0" max="100" step="1" value="0" data-item="' . esc_attr( $key ) . '" style="width:80px;border:2px solid #E2E8F0;border-radius:8px;padding:6px 8px;"></label>';
	}
	$nonce = wp_create_nonce( 'daan_fitrana_calc' );
	$ajax  = esc_url( admin_url( 'admin-ajax.php' ) );
	ob_start();
	?>
	<div id="daan-fitrana-calc" style="border:2px solid #E2E8F0;border-radius:16px;padding:20px;margin:16px 0;background:#fff;">
		<h3 style="margin:0 0 12px;font-size:1.25rem;">Fitrana Calculator</h3>
		<?php echo $rows; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<button type="button" id="daan-fc-go" style="border:none;border-radius:9999px;background:#C2410C;color:#fff;padding:10px 20px;font-weight:700;cursor:pointer;">Calculate</button>
		<div id="daan-fc-out" style="display:none;margin-top:14px;">
			<p style="margin:0 0 6px;font-weight:700;" id="daan-fc-text"></p>
			<p style="margin:0 0 10px;">The extra amount is counted as voluntary Sadaqah.</p>
			<a id="daan-fc-cart" href="#" style="display:inline-block;border-radius:9999px;background:#047857;color:#fff;padding:10px 20px;font-weight:700;text-decoration:none;">Give Fitrana Kits</a>
		</div>
	</div>
	<script>
	(function () {
		var box = document.getElementById('daan-fitrana-calc');
		document.getElementById('daan-fc-go').addEventListener('click', function () {
			var data = new FormData();
			data.append('action', 'daan_fitrana_calc');
			data.append('nonce', '<?php echo esc_js( $nonce ); ?>');
			box.querySelectorAll('input[data-item]').forEach(function (i) { data.append(i.getAttribute('data-item'), i.value || 0); });
			fetch('<?php echo $ajax; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>', { method: 'POST', body: data, credentials: 'same-origin' })
				.then(function (r) { return r.json(); })
				.then(function (r) {
					if (!r.success) { return; }
					document.getElementById('daan-fc-text').textContent = "Your family's Fitrana: " + r.data.total_text + '. Kits needed: ' + r.data.kits + '.';
					document.getElementById('daan-fc-cart').href = r.data.cart;
					document.getElementById('daan-fc-cart').style.display = r.data.kits > 0 ? 'inline-block' : 'none';
					document.getElementById('daan-fc-out').style.display = 'block';
				});
		});
	})();
	</script>
	<?php
	return ob_get_clean();
} );

foreach ( array( 'wp_ajax_daan_fitrana_calc', 'wp_ajax_nopriv_daan_fitrana_calc' ) as $daan_calc_hook ) {
	add_action( $daan_calc_hook, function () {
		check_ajax_referer( 'daan_fitrana_calc', 'nonce' );
		$res = daan_fitrana_calc( array_map( 'intval', wp_unslash( $_POST ) ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		if ( ! $res ) {
			wp_send_json_error();
		}
		$id = (int) get_option( 'daan_kit_fitrana_product', 0 );
		wp_send_json_success(
			array(
				'total_text' => html_entity_decode( daan_rupees( $res['total'] ), ENT_QUOTES, 'UTF-8' ),
				'kits'       => $res['kits'],
				'cart'       => add_query_arg( array( 'add-to-cart' => $id, 'quantity' => max( 1, $res['kits'] ) ), get_permalink( $id ) ),
			)
		);
	} );
}

// Elementor buttons do not run shortcodes: a literal [daan_kit_price] in a button label shows the kit price setting.
add_filter( 'elementor/frontend/the_content', function ( $content ) {
	return false === strpos( $content, '[daan_kit_price]' ) ? $content : str_replace( '[daan_kit_price]', daan_rupees( daan_kit_price() ), $content );
} );

// D-042 donor update emails (2026-11-27).
require_once __DIR__ . '/donor-updates.php';
