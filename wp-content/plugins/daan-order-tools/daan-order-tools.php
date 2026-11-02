<?php
/**
 * Plugin Name: Daan Order Tools
 * Description: Mandatory Indian mobile number and optional PAN on checkout and /donate/ (form in the theme), plus a direct "Export Customers" CSV download for admins (WooCommerce > Export Customers). PAN is visible to admins only and never goes into e-mails, order notes, logs or the digest.
 * Version: 1.0.0
 * Requires Plugins: woocommerce
 */
defined( 'ABSPATH' ) || exit;

const DAAN_OT_PAN_META     = '_daan_donor_pan';
const DAAN_OT_MOBILE_ERROR = 'Please enter a valid 10-digit Indian mobile number. We call to confirm your details.';
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
					<td><input type="date" id="daan-from" name="from"></td>
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
	if ( null !== $from || null !== $to ) {
		$query['date_created'] = ( null !== $from ? $from : 1 ) . '...' . ( null !== $to ? $to : time() ); // A start of 0 matches nothing.
	}

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
