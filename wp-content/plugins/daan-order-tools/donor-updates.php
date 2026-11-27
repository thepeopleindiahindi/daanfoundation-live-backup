<?php
/**
 * D-042 (owner, 2026-11-27): automatic progress e-mails to donors.
 *
 * Rule A (general): order total up to the "Auto update limit" (default ₹9,999), any head:
 *   one "execution" mail 72 hours after the order became Completed.
 * Rule B (Ration Kit / Ration Kit (Interest Money)), same limit: three mails, day 2 / 4 / 7 after Completed
 *   (packed, scheduled, delivered). No distribution date or day is ever named in a mail.
 * Exceptions: Iftar outside the Ramadan dates = one "reserved for Ramadan 2027" mail at 72h (inside = rule A);
 *   Fitrana Ration Kit, Eid Gifts, Fidyah/Kaffarah: no automatic mail; over the limit: no automatic mail,
 *   admin buttons "Send update" on the order page (each once).
 * Safety: only orders completed after this rule went live (option daan_upd_live_at); per-order "Pause updates";
 *   only while Completed and not refunded; one mail per step (flag + order note); copy to the Foundation;
 *   failure = no flag, retried next hourly run, admin alert at most once a day per order.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const DAAN_UPD_LIVE_OPTION  = 'daan_upd_live_at';
const DAAN_UPD_LIMIT_OPTION = 'daan_upd_limit';
const DAAN_UPD_DAYS_OPTION  = 'daan_upd_ration_days';
const DAAN_UPD_RAM_START    = 'daan_ramadan_start';
const DAAN_UPD_RAM_END      = 'daan_ramadan_end';
const DAAN_UPD_PAUSE_META   = '_daan_updates_paused';
const DAAN_UPD_ALERT_META   = '_daan_upd_alert_at';
const DAAN_UPD_STEP_META    = '_daan_rk_step_'; // + 1 / 2 / 3
const DAAN_UPD_RATION_IDS   = array( 7357, 7349 );
const DAAN_UPD_FITRANA_IDS  = array( 7350 );
const DAAN_UPD_IFTAR_IDS    = array( 6808, 5920 );

/** The moment the new rule went live: set once, never moved. */
function daan_upd_live_at() {
	$t = (int) get_option( DAAN_UPD_LIVE_OPTION, 0 );
	if ( ! $t ) {
		$t = time();
		add_option( DAAN_UPD_LIVE_OPTION, $t, '', 'no' );
	}
	return (int) apply_filters( 'daan_upd_live_at', $t ); // filter used only by the test script
}
add_action( 'init', 'daan_upd_live_at' );

function daan_upd_limit() {
	$v = get_option( DAAN_UPD_LIMIT_OPTION, '' );
	return '' === $v ? 9999.0 : max( 0.0, (float) $v );
}

/** Ration kit mail days after Completed, e.g. [2, 4, 7]. */
function daan_upd_ration_days() {
	$parts = array_map( 'intval', explode( ',', (string) get_option( DAAN_UPD_DAYS_OPTION, '2,4,7' ) ) );
	$parts = array_values( array_filter( $parts, function ( $d ) { return $d >= 1 && $d <= 60; } ) );
	if ( 3 !== count( $parts ) ) {
		$parts = array( 2, 4, 7 );
	}
	sort( $parts );
	return $parts;
}

/** True when the order was created inside the Ramadan dates set in the settings (empty = never). */
function daan_upd_in_ramadan( $order ) {
	$s = (string) get_option( DAAN_UPD_RAM_START, '' );
	$e = (string) get_option( DAAN_UPD_RAM_END, '' );
	if ( ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $s ) || ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $e ) || ! $order->get_date_created() ) {
		return false;
	}
	$day = wp_date( 'Y-m-d', $order->get_date_created()->getTimestamp(), new DateTimeZone( 'Asia/Kolkata' ) );
	return $day >= $s && $day <= $e;
}

/** Cause label of the order, as on the receipt. */
function daan_upd_cause( $order ) {
	$c = trim( (string) $order->get_meta( '_daan_donation_cause' ) );
	if ( '' === $c ) {
		foreach ( $order->get_items() as $item ) {
			$c = trim( preg_replace( '/^Donation\s*[—–-]\s*/u', '', html_entity_decode( $item->get_name(), ENT_QUOTES, 'UTF-8' ) ) );
			break;
		}
	}
	return '' !== $c ? $c : 'Daan Foundation';
}

/**
 * Kind of update this order gets: 'none' | 'ration' | 'iftar' | 'general'.
 * Mixed orders: an excluded line (Fitrana kit, Eid Gifts, Fidyah/Kaffarah) wins, then ration, then iftar.
 */
function daan_upd_kind( $order ) {
	$ids   = array();
	$names = array( strtolower( (string) $order->get_meta( '_daan_donation_cause' ) ) );
	foreach ( $order->get_items() as $item ) {
		$ids[]   = (int) $item->get_product_id();
		$names[] = strtolower( html_entity_decode( $item->get_name(), ENT_QUOTES, 'UTF-8' ) );
	}
	$blob = implode( ' | ', $names );
	if ( array_intersect( $ids, DAAN_UPD_FITRANA_IDS ) || false !== strpos( $blob, 'fitr' ) || false !== strpos( $blob, 'eid gift' ) || preg_match( '/fid[iy]a|kaff?ara/', $blob ) ) {
		return 'none';
	}
	if ( array_intersect( $ids, DAAN_UPD_RATION_IDS ) || false !== strpos( $blob, 'ration kit' ) ) {
		return 'ration';
	}
	if ( array_intersect( $ids, DAAN_UPD_IFTAR_IDS ) || false !== strpos( $blob, 'iftar' ) ) {
		return 'iftar';
	}
	return 'general';
}

/** Completed time (falls back to paid / created). */
function daan_upd_completed_at( $order ) {
	$d = $order->get_date_completed() ?: ( $order->get_date_paid() ?: $order->get_date_created() );
	return $d ? $d->getTimestamp() : 0;
}

/** Order is under the new rule at all (status, refund, e-mail, live date). Limit/pause checked separately. */
function daan_upd_base_ok( $order ) {
	return $order instanceof WC_Order && 'shop_order' === $order->get_type() && $order->has_status( 'completed' )
		&& $order->get_total_refunded() <= 0 && is_email( $order->get_billing_email() )
		&& daan_upd_completed_at( $order ) >= daan_upd_live_at();
}

function daan_upd_auto_ok( $order ) {
	return daan_upd_base_ok( $order ) && ! $order->get_meta( DAAN_UPD_PAUSE_META ) && (float) $order->get_total() <= daan_upd_limit() && 'none' !== daan_upd_kind( $order );
}

/**
 * Steps of an order: list of [key, flag meta, due timestamp]. Key: 'exec' (one mail) or 'rk1'..'rk3'.
 */
function daan_upd_steps( $order ) {
	$kind = daan_upd_kind( $order );
	$at   = daan_upd_completed_at( $order );
	if ( 'ration' === $kind ) {
		$steps = array();
		foreach ( daan_upd_ration_days() as $i => $d ) {
			$steps[] = array( 'rk' . ( $i + 1 ), DAAN_UPD_STEP_META . ( $i + 1 ), $at + $d * DAY_IN_SECONDS );
		}
		return $steps;
	}
	if ( 'none' === $kind ) {
		return array();
	}
	return array( array( 'exec', DAAN_OT_EXEC_FLAG, $at + 72 * HOUR_IN_SECONDS ) );
}

/** Subject + body lines for one step. */
function daan_upd_message( $order, $key ) {
	$no     = $order->get_order_number();
	$amount = wp_strip_all_tags( wc_price( $order->get_total(), array( 'currency' => $order->get_currency() ) ) );
	$cause  = daan_upd_cause( $order );
	$lead   = 'Thank you for your donation of ' . $amount . ' to ' . $cause . ' (Donation #' . $no . ').';
	switch ( $key ) {
		case 'rk1':
			return array( 'Your ration kit is packed – Donation #' . $no, array( $lead, 'Your ration kit has been packed at our Amroha head office and is ready for distribution.' ) );
		case 'rk2':
			return array( 'Your ration kit is scheduled for distribution – Donation #' . $no, array( $lead, 'Your ration kit has been scheduled for distribution to a family in need.' ) );
		case 'rk3':
			return array( 'Your ration kit has been delivered – Donation #' . $no, array( $lead, 'Alhamdulillah, your ration kit has been distributed to a family in need. May Allah accept your donation.' ) );
	}
	if ( 'iftar' === daan_upd_kind( $order ) && ! daan_upd_in_ramadan( $order ) ) {
		return array( 'Your iftar kits are reserved for Ramadan 2027 – Donation #' . $no, array( $lead, "Your iftar kits are reserved for Ramadan 2027. We will serve them to fasting people during Ramadan, insha'Allah." ) );
	}
	if ( 0 === stripos( $cause, 'community kitchen' ) ) { // unchanged Community Kitchen text
		return array( 'Your donation has reached those in need', array( $lead, 'By the grace of Allah, your contribution has been used in our food distribution work, helping provide meals to people in need.', 'May Allah accept your donation and reward you for your generosity.' ) );
	}
	return array( 'Your donation has reached those in need', array( $lead, 'By the grace of Allah, your contribution has been put to use for people in need. May Allah accept your donation.' ) );
}

/** Same design as the execution mail (the site-wide e-mail layout wraps it). */
function daan_upd_html( $order, $lines ) {
	$first = trim( $order->get_billing_first_name() );
	$p     = '<p style="font-family:Arial,Helvetica,sans-serif;font-size:15px;line-height:1.6;color:#1F2937;margin:0 0 14px;">';
	$h     = $p . 'Dear ' . esc_html( '' !== $first ? $first : 'Donor' ) . ',</p>';
	foreach ( $lines as $l ) {
		$h .= $p . esc_html( $l ) . '</p>';
	}
	return $h . $p . 'Team Daan Foundation</p>';
}

/** Sends one step once. $manual = admin button. Returns true when sent. */
function daan_upd_send( $order, $step, $manual = false ) {
	list( $key, $flag ) = $step;
	if ( $order->get_meta( $flag ) ) {
		return false;
	}
	list( $subject, $lines ) = daan_upd_message( $order, $key );
	$html    = daan_upd_html( $order, $lines );
	$headers = array( 'Content-Type: text/html; charset=UTF-8' );
	$label   = 'exec' === $key ? 'Update email' : 'Ration kit update ' . substr( $key, 2 ) . '/3';
	if ( wp_mail( $order->get_billing_email(), $subject, $html, $headers ) ) {
		$order->update_meta_data( $flag, time() );
		$order->save_meta_data();
		$order->add_order_note( $label . ' sent' . ( $manual ? ' (button)' : '' ) . ' ' . wp_date( 'j M Y, g:i A' ) . ': "' . $subject . '"' );
		$copy = wp_mail( DAAN_OT_BCC, '[Copy] #' . $order->get_order_number() . ' ' . $subject, $html, $headers );
		$order->add_order_note( $copy ? $label . ' copy sent to the Foundation.' : $label . ' copy to the Foundation failed (donor mail was sent).' );
		$day = 'daan_upd_sent_' . daan_ot_today();
		update_option( $day, (int) get_option( $day, 0 ) + 1, false );
		return true;
	}
	if ( time() - (int) $order->get_meta( DAAN_UPD_ALERT_META ) >= DAY_IN_SECONDS ) {
		$order->update_meta_data( DAAN_UPD_ALERT_META, time() );
		$order->save_meta_data();
		$order->add_order_note( $label . ' failed; it will be tried again on the next run.' );
		wp_mail( DAAN_OT_ALERT_TO, 'Donor update email failed – donation #' . $order->get_order_number(), '<p style="font-family:Arial,Helvetica,sans-serif;font-size:15px;line-height:1.6;">The update email (' . esc_html( $label ) . ') for donation <b>#' . esc_html( $order->get_order_number() ) . '</b> could not be sent. It will be tried again every hour.</p>', $headers );
	}
	return false;
}

/** Next due, unsent step of an order (only one per run, in order), or null. */
function daan_upd_next_due( $order, $now = null ) {
	$now = $now ?? time();
	foreach ( daan_upd_steps( $order ) as $step ) {
		if ( $order->get_meta( $step[1] ) ) {
			continue;
		}
		return $now >= $step[2] ? $step : null;
	}
	return null;
}

function daan_upd_candidates() {
	return wc_get_orders( array( 'type' => 'shop_order', 'limit' => -1, 'status' => array( 'wc-completed' ), 'date_completed' => '>=' . daan_upd_live_at() ) );
}

/** One hourly run. Returns the number of mails sent. */
function daan_upd_run() {
	$sent = 0;
	foreach ( daan_upd_candidates() as $order ) {
		$sent += daan_upd_process_order( wc_get_order( $order->get_id() ) ) ? 1 : 0;
	}
	return $sent;
}

/** One order: sends its next due step (at most one per run). */
function daan_upd_process_order( $order ) {
	if ( ! daan_upd_auto_ok( $order ) ) {
		return false;
	}
	$step = daan_upd_next_due( $order );
	return $step && 'completed' === daan_ot_status_in_db( $order->get_id() ) && daan_upd_send( $order, $step );
}

add_action( 'daan_ot_hourly', function () {
	if ( ! daan_ot_automation_on() || ! daan_ot_lock_take( 'daan_upd_lock' ) ) {
		return;
	}
	try {
		daan_upd_run();
	} finally {
		daan_ot_lock_release( 'daan_upd_lock' );
	}
}, 20 );

/** For the digest: "Donor updates: X sent today · Y pending". */
function daan_upd_digest_line() {
	$pending = 0;
	foreach ( daan_upd_candidates() as $order ) {
		if ( ! daan_upd_auto_ok( $order ) ) {
			continue;
		}
		foreach ( daan_upd_steps( $order ) as $step ) {
			if ( ! $order->get_meta( $step[1] ) ) {
				$pending++;
			}
		}
	}
	return '<p style="background:#F0FDF4;padding:10px 12px;border-radius:6px;">Donor update emails: <strong>' . (int) get_option( 'daan_upd_sent_' . daan_ot_today(), 0 ) . '</strong> sent today · <strong>' . $pending . '</strong> pending (scheduled).</p>';
}

/* ---------- Order page: "Pause updates" + manual buttons (over the limit) ---------- */

add_action( 'add_meta_boxes', function () {
	$screen = function_exists( 'wc_get_page_screen_id' ) ? wc_get_page_screen_id( 'shop-order' ) : 'shop_order';
	add_meta_box( 'daan-donor-updates', 'Donor update emails', 'daan_upd_metabox', $screen, 'side', 'default' );
} );

function daan_upd_metabox( $post_or_order ) {
	$order = $post_or_order instanceof WC_Order ? $post_or_order : wc_get_order( $post_or_order->ID );
	if ( ! $order ) {
		return;
	}
	$kind = daan_upd_kind( $order );
	echo '<p><label><input type="checkbox" name="daan_updates_paused" value="1" ' . checked( (bool) $order->get_meta( DAAN_UPD_PAUSE_META ), true, false ) . '> Pause updates</label></p>';
	wp_nonce_field( 'daan_upd_pause', 'daan_upd_pause_nonce' );
	if ( 'none' === $kind ) {
		echo '<p class="description">No automatic update for this cause (Fitrana, Eid Gifts, Fidyah/Kaffarah).</p>';
		return;
	}
	foreach ( daan_upd_steps( $order ) as $step ) {
		list( $key, $flag, $due ) = $step;
		$label = 'exec' === $key ? 'Update' : array( 'rk1' => '1. Packed', 'rk2' => '2. Scheduled', 'rk3' => '3. Delivered' )[ $key ];
		$sent  = (int) $order->get_meta( $flag );
		echo '<p style="margin:6px 0;">' . esc_html( $label ) . ': ';
		if ( $sent ) {
			echo '<b>sent</b> ' . esc_html( wp_date( 'j M, g:i A', $sent ) );
		} elseif ( ! daan_upd_base_ok( $order ) ) {
			echo '—';
		} elseif ( (float) $order->get_total() > daan_upd_limit() ) {
			$url = wp_nonce_url( admin_url( 'admin-post.php?action=daan_upd_send&order=' . $order->get_id() . '&step=' . $key ), 'daan_upd_send_' . $order->get_id() . '_' . $key );
			echo '<a class="button button-small" href="' . esc_url( $url ) . '">Send update</a>';
		} else {
			echo 'automatic, ' . esc_html( wp_date( 'j M, g:i A', $due ) );
		}
		echo '</p>';
	}
}

add_action( 'woocommerce_process_shop_order_meta', function ( $order_id ) {
	if ( ! isset( $_POST['daan_upd_pause_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['daan_upd_pause_nonce'] ) ), 'daan_upd_pause' ) ) {
		return;
	}
	$order = wc_get_order( $order_id );
	if ( ! $order ) {
		return;
	}
	if ( ! empty( $_POST['daan_updates_paused'] ) ) {
		$order->update_meta_data( DAAN_UPD_PAUSE_META, time() );
	} else {
		$order->delete_meta_data( DAAN_UPD_PAUSE_META );
	}
	$order->save_meta_data();
}, 50 );

add_action( 'admin_post_daan_upd_send', function () {
	$id  = isset( $_GET['order'] ) ? absint( $_GET['order'] ) : 0;
	$key = isset( $_GET['step'] ) ? sanitize_key( wp_unslash( $_GET['step'] ) ) : '';
	if ( ! current_user_can( 'edit_shop_orders' ) || ! check_admin_referer( 'daan_upd_send_' . $id . '_' . $key ) ) {
		wp_die( 'Not allowed.' );
	}
	$order = wc_get_order( $id );
	if ( $order && daan_upd_base_ok( $order ) ) {
		foreach ( daan_upd_steps( $order ) as $step ) {
			if ( $step[0] === $key ) {
				daan_upd_send( $order, $step, true );
			}
		}
	}
	wp_safe_redirect( $order ? $order->get_edit_order_url() : admin_url() );
	exit;
} );

/* ---------- Settings (WooCommerce > Order Automation) ---------- */

add_action( 'admin_init', function () {
	register_setting( 'daan_ot_automation', DAAN_UPD_LIMIT_OPTION, array( 'type' => 'string', 'sanitize_callback' => function ( $v ) { return '' === trim( (string) $v ) ? '9999' : (string) max( 0, (float) $v ); } ) );
	register_setting( 'daan_ot_automation', DAAN_UPD_DAYS_OPTION, array( 'type' => 'string', 'sanitize_callback' => function ( $v ) {
		$d = array_values( array_filter( array_map( 'intval', explode( ',', (string) $v ) ), function ( $x ) { return $x >= 1 && $x <= 60; } ) );
		sort( $d );
		return 3 === count( $d ) ? implode( ',', $d ) : '2,4,7';
	} ) );
	foreach ( array( DAAN_UPD_RAM_START, DAAN_UPD_RAM_END ) as $opt ) {
		register_setting( 'daan_ot_automation', $opt, array( 'type' => 'string', 'sanitize_callback' => function ( $v ) { return preg_match( '/^\d{4}-\d{2}-\d{2}$/', (string) $v ) ? (string) $v : ''; } ) );
	}
}, 20 );

/** Rows printed inside the Order Automation form (called from the settings page). */
function daan_upd_settings_rows() {
	?>
	<h2>Donor update emails (D-042)</h2>
	<p class="description">Only for orders completed after <?php echo esc_html( wp_date( 'j M Y, g:i A', daan_upd_live_at() ) ); ?>. Per order: "Pause updates" box on the order page. No mail ever names a distribution date.</p>
	<table class="form-table" role="presentation">
		<tr><th>Auto update limit (₹)</th><td><input type="number" min="0" step="1" style="width:110px" name="<?php echo esc_attr( DAAN_UPD_LIMIT_OPTION ); ?>" value="<?php echo esc_attr( (string) daan_upd_limit() ); ?>"> <span class="description">Orders up to this total get automatic updates; above it, use the "Send update" buttons on the order.</span></td></tr>
		<tr><th>Ration kit mail days</th><td><input type="text" style="width:110px" name="<?php echo esc_attr( DAAN_UPD_DAYS_OPTION ); ?>" value="<?php echo esc_attr( implode( ',', daan_upd_ration_days() ) ); ?>"> <span class="description">Three numbers: days after Completed for "packed", "scheduled", "delivered" (default 2,4,7).</span></td></tr>
		<tr><th>Ramadan start / end</th><td><input type="date" name="<?php echo esc_attr( DAAN_UPD_RAM_START ); ?>" value="<?php echo esc_attr( (string) get_option( DAAN_UPD_RAM_START, '' ) ); ?>"> – <input type="date" name="<?php echo esc_attr( DAAN_UPD_RAM_END ); ?>" value="<?php echo esc_attr( (string) get_option( DAAN_UPD_RAM_END, '' ) ); ?>"> <span class="description">Iftar orders made between these dates get the normal 72-hour mail; outside (or while empty), the "reserved for Ramadan 2027" mail.</span></td></tr>
	</table>
	<?php
}
