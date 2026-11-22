<?php
/**
 * Daan Foundation — Centralized Custom Functionality
 *
 * All AJAX handlers, database setup, donation processing, and email logic.
 * Include this file from functions.php.
 *
 * @package DaanCustom
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* -------------------------------------------------------------------------
 * 0. Razorpay Constants (from environment / wp-config.php)
 * ------------------------------------------------------------------------- */

define( 'DAAN_NOTIFICATION_EMAIL', 'daanfoundationindia@gmail.com' );

/* -------------------------------------------------------------------------
 * 1. Database Setup (theme activation)
 * ------------------------------------------------------------------------- */

register_activation_hook( __FILE__, 'daan_create_custom_tables' );
add_action( 'after_switch_theme', 'daan_create_custom_tables' );

function daan_create_custom_tables() {
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    $table_contacts = $wpdb->prefix . 'daan_contacts';
    $sql1 = "CREATE TABLE IF NOT EXISTS $table_contacts (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(100) NOT NULL,
        last_name VARCHAR(100) NOT NULL,
        email VARCHAR(255) NOT NULL,
        subject VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) $charset_collate;";

    $table_subscribers = $wpdb->prefix . 'daan_subscribers';
    $sql2 = "CREATE TABLE IF NOT EXISTS $table_subscribers (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        subscribed_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) $charset_collate;";

    $table_donations = $wpdb->prefix . 'daan_donations';
    $sql3 = "CREATE TABLE IF NOT EXISTS $table_donations (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(100) NOT NULL,
        last_name VARCHAR(100) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(20) DEFAULT '',
        city VARCHAR(100) DEFAULT '',
        state VARCHAR(100) DEFAULT '',
        pincode VARCHAR(10) DEFAULT '',
        amount INT UNSIGNED NOT NULL,
        cause VARCHAR(100) DEFAULT '',
        frequency VARCHAR(20) DEFAULT 'one-time',
        payment_id VARCHAR(100) DEFAULT '',
        order_id VARCHAR(100) DEFAULT '',
        status VARCHAR(20) DEFAULT 'completed',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    dbDelta( $sql1 );
    dbDelta( $sql2 );
    dbDelta( $sql3 );
}

/* -------------------------------------------------------------------------
 * 2. Contact Form AJAX Handler
 * ------------------------------------------------------------------------- */

/**
 * Per-IP limit for public forms: true once $max submissions were made from this IP within $window seconds.
 */
function daan_form_rate_limited( $form, $max, $window ) {
    $key   = 'daan_form_rl_' . $form . '_' . md5( $_SERVER['REMOTE_ADDR'] ?? '' );
    $tries = (int) get_transient( $key );
    if ( $tries >= $max ) {
        return true;
    }
    set_transient( $key, $tries + 1, $window );
    return false;
}

add_action( 'wp_ajax_nopriv_daan_contact_form', 'daan_handle_contact_form' );
add_action( 'wp_ajax_daan_contact_form', 'daan_handle_contact_form' );

function daan_handle_contact_form() {
    if ( ! wp_verify_nonce( $_POST['daan_contact_nonce'] ?? '', 'daan_contact' ) ) {
        wp_send_json_error( array( 'message' => 'Security check failed.' ) );
    }

    if ( daan_form_rate_limited( 'contact', 5, HOUR_IN_SECONDS ) ) {
        wp_send_json_error( array( 'message' => 'Too many messages from your connection. Please try again in an hour, or call us.' ) );
    }

    $first_name = sanitize_text_field( $_POST['first_name'] ?? '' );
    $last_name  = sanitize_text_field( $_POST['last_name'] ?? '' );
    $email      = sanitize_email( $_POST['email'] ?? '' );
    $subject    = sanitize_text_field( $_POST['subject'] ?? '' );
    $message    = sanitize_textarea_field( $_POST['message'] ?? '' );

    if ( ! $first_name || ! $last_name || ! $email || ! $subject || ! $message ) {
        wp_send_json_error( array( 'message' => 'All required fields must be filled.' ) );
    }

    if ( ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Invalid email address.' ) );
    }

    global $wpdb;
    $table = $wpdb->prefix . 'daan_contacts';

    $wpdb->insert(
        $table,
        array(
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'email'      => $email,
            'subject'    => $subject,
            'message'    => $message,
        ),
        array( '%s', '%s', '%s', '%s', '%s' )
    );

    wp_mail(
        DAAN_NOTIFICATION_EMAIL,
        "Contact Form: $subject",
        daan_email_contact_html( $first_name, $last_name, $email, $subject, $message ),
        array( "Reply-To: $email", 'Content-Type: text/html; charset=UTF-8' )
    );

    wp_send_json_success( array( 'message' => 'Thank you for contacting us. We will get back to you within 24-48 hours.' ) );
}

/* -------------------------------------------------------------------------
 * 3. Newsletter AJAX Handler
 * ------------------------------------------------------------------------- */

add_action( 'wp_ajax_nopriv_daan_newsletter_signup', 'daan_handle_newsletter_signup' );
add_action( 'wp_ajax_daan_newsletter_signup', 'daan_handle_newsletter_signup' );

function daan_handle_newsletter_signup() {
    $nonce = $_POST['_wpnonce'] ?? '';
    if ( ! wp_verify_nonce( $nonce, 'daan_newsletter' ) ) {
        wp_send_json_error( array( 'message' => 'Security check failed.' ) );
    }

    if ( daan_form_rate_limited( 'newsletter', 5, HOUR_IN_SECONDS ) ) {
        wp_send_json_error( array( 'message' => 'Too many sign-ups from your connection. Please try again later.' ) );
    }

    $email = sanitize_email( $_POST['email'] ?? '' );

    if ( ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Invalid email address.' ) );
    }

    global $wpdb;
    $table = $wpdb->prefix . 'daan_subscribers';

    $existing = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM $table WHERE email = %s", $email ) );

    if ( $existing ) {
        wp_send_json_success( array( 'message' => 'You are already subscribed!' ) );
    }

    $wpdb->insert(
        $table,
        array( 'email' => $email ),
        array( '%s' )
    );

    wp_mail(
        $email,
        'Welcome to Daan Foundation Newsletter',
        daan_email_newsletter_html(),
        array( 'Content-Type: text/html; charset=UTF-8' )
    );

    wp_send_json_success( array( 'message' => 'Thank you for subscribing!' ) );
}

/* -------------------------------------------------------------------------
 * 4. Donation Order — WooCommerce Order Creation
 * ------------------------------------------------------------------------- */

/** Key for one submitted form: its hidden token plus what was donated. '' when the form sent no token. */
function daan_idem_key( $token, $parts ) {
    $token = preg_replace( '/[^a-zA-Z0-9-]/', '', (string) wp_unslash( $token ) );
    return '' === $token ? '' : 'daan_idem_' . md5( $token . '|' . implode( '|', $parts ) );
}

/** Returns the order this form already made in the last 2 minutes. Otherwise holds a database lock until daan_idem_finish(), so a second copy waits. */
function daan_idem_begin( $key ) {
    if ( '' === $key ) {
        return null;
    }
    global $wpdb;
    $wpdb->get_var( $wpdb->prepare( 'SELECT GET_LOCK(%s, 15)', $key ) );
    $id = (int) get_transient( $key );
    if ( ! $id ) {
        return null;
    }
    $wpdb->get_var( $wpdb->prepare( 'SELECT RELEASE_LOCK(%s)', $key ) );
    $order = wc_get_order( $id );
    return $order ? $order : null;
}

function daan_idem_finish( $key, $order ) {
    if ( '' === $key ) {
        return;
    }
    global $wpdb;
    set_transient( $key, $order->get_id(), 2 * MINUTE_IN_SECONDS );
    $wpdb->get_var( $wpdb->prepare( 'SELECT RELEASE_LOCK(%s)', $key ) );
}

add_action( 'wp_ajax_daan_place_order', 'daan_place_order' );
add_action( 'wp_ajax_nopriv_daan_place_order', 'daan_place_order' );

/** Causes the /donate/ form may send: the live causes. */
function daan_donation_causes() {
    return array( 'Where Most Needed', 'Community Kitchen', 'Ramadan Iftar', 'Ration Kit', 'Ration Kit (Interest Money)', 'Fitrana Ration Kit', 'Zakat', 'Sadaqah', 'Sadaqah Jariyah', 'Fidyah & Kaffarah', 'Eid Gifts', 'Winter Appeal', 'Education Aid', 'General' );
}

/** Causes shown as choices on the /donate/ form. */
function daan_donate_form_causes() {
    $causes = array( 'Where Most Needed', 'Community Kitchen', 'Ramadan Iftar', 'Ration Kit', 'Ration Kit (Interest Money)', 'Fitrana Ration Kit', 'Zakat', 'Sadaqah', 'Fidyah & Kaffarah', 'Eid Gifts', 'Winter Appeal' );
    if ( ! function_exists( 'daan_fixed_causes' ) ) { // Plugin off: the fixed-price causes cannot be priced.
        $causes = array_values( array_diff( $causes, array( 'Ramadan Iftar', 'Ration Kit', 'Ration Kit (Interest Money)', 'Fitrana Ration Kit' ) ) );
    }
    if ( daan_fk_hold_on() ) {
        $causes = array_values( array_diff( $causes, array( 'Fidyah & Kaffarah' ) ) );
    }
    return $causes;
}

/** <option>s for the homepage widget and the sidebars: same causes as the /donate/ form, fixed ones with their price. */
/** "₹1,536" style price for menus, from the plugin setting function (fallback when the plugin is off). */
function daan_menu_price( $fn, $fallback ) {
    $n = function_exists( $fn ) ? (int) call_user_func( $fn ) : (int) $fallback;
    return '₹' . number_format_i18n( $n > 0 ? $n : $fallback );
}

function daan_widget_cause_options( $selected = '' ) {
    $fixed = function_exists( 'daan_fixed_causes' ) ? daan_fixed_causes() : array();
    $out   = '';
    foreach ( daan_donate_form_causes() as $cause ) {
        if ( in_array( $cause, array( 'Eid Gifts', 'Winter Appeal' ), true ) ) {
            continue; // Seasonal: on the /donate/ form only (as before).
        }
        $label = isset( $fixed[ $cause ] ) ? $cause . ' (₹' . number_format_i18n( $fixed[ $cause ]['unit'] ) . ' per ' . $fixed[ $cause ]['one'] . ')' : $cause;
        $out  .= '<option value="' . esc_attr( $cause ) . '"' . selected( $cause, $selected, false ) . '>' . esc_html( $label ) . '</option>';
    }
    return $out;
}

/** Temporary hold on new Fidyah & Kaffarah donations (setting in plugin daan-order-tools). */
function daan_fk_hold_on() {
    return function_exists( 'daan_fk_paused' ) && daan_fk_paused();
}

/** The one mapping from a ?cause= value (name or slug, any case or spelling variant) to a cause. '' = not recognised. */
function daan_cause_from_link( $raw ) {
    $key = strtolower( html_entity_decode( (string) $raw, ENT_QUOTES, 'UTF-8' ) );
    $key = trim( preg_replace( '/\s+/', ' ', str_replace( array( '&', '+', '-', '_' ), array( ' and ', ' ', ' ', ' ' ), $key ) ) );
    $map = array(
        'Where Most Needed' => array( 'where most needed', 'where needed', 'most needed' ),
        'Community Kitchen' => array( 'community kitchen', 'kitchen' ),
        'Ramadan Iftar'     => array( 'ramadan iftar', 'ramadan iftaar', 'serving iftar', 'iftar', 'iftaar', 'ramadan' ),
        'Zakat'             => array( 'zakat', 'zakaat' ),
        'Zakat al-Fitr'     => array( 'zakat al fitr', 'zakat ul fitr', 'zakat al fitrah', 'zakat fitr', 'zakatul fitr', 'fitrana', 'fitra', 'fitrah' ),
        'Sadaqah'           => array( 'sadaqah', 'sadaqa', 'sadqah', 'sadqa' ),
        'Sadaqah Jariyah'   => array( 'sadaqah jariyah', 'sadaqah jariya', 'sadqah jariyah', 'sadqa jariya' ),
        'Fidyah & Kaffarah' => array( 'fidyah and kaffarah', 'fidya and kaffara', 'fidya and kaffarah', 'fidyah and kaffara', 'fidya kaffarah', 'fidya kaffara', 'fidyah kaffarah', 'fidyah kaffara', 'fidya', 'fidyah', 'kaffara', 'kaffarah' ),
        'Eid Gifts'         => array( 'eid gifts', 'eid gift', 'eid' ),
        'Winter Appeal'     => array( 'winter appeal', 'winter' ),
        'Education Aid'     => array( 'education aid', 'education' ),
        'Bank Interest'     => array( 'bank interest' ),
        'Ration Kit'        => array( 'ration kit', 'ration kits', 'ration', 'ration kit donation' ),
        'Ration Kit (Interest Money)' => array( 'ration kit (interest money)', 'ration kit interest money', 'interest money', 'interest' ),
        'Fitrana Ration Kit' => array( 'fitrana ration kit', 'fitrana kit' ),
        'General'           => array( 'general', 'general donation' ),
    );
    foreach ( $map as $cause => $names ) {
        if ( in_array( $key, $names, true ) ) {
            return $cause;
        }
    }
    return '';
}

function daan_place_order() {
    // The /donate/ page is never page-cached, so its nonce is always fresh; an old open tab gets a refresh message.
    if ( ! check_ajax_referer( 'daan_place_order', 'daan_order_nonce', false ) ) {
        wp_send_json_error( array( 'message' => 'This page has expired. Please refresh the page and try again.' ) );
    }

    // At most 10 donation orders per IP in 10 minutes (shared mobile IPs stay well below this; scripts do not).
    $ip_key = 'daan_order_rl_' . md5( $_SERVER['REMOTE_ADDR'] ?? '' );
    $tries  = (int) get_transient( $ip_key );
    if ( $tries >= 10 ) {
        wp_send_json_error( array( 'message' => 'Too many donation attempts. Please wait a few minutes and try again.' ) );
    }
    set_transient( $ip_key, $tries + 1, 10 * MINUTE_IN_SECONDS );

    $amount        = intval( $_POST['amount'] ?? 0 );
    // The form can send & as &amp; when the cause came from the page address.
    $cause          = html_entity_decode( sanitize_text_field( $_POST['cause'] ?? 'Where Most Needed' ), ENT_QUOTES, 'UTF-8' );
    $first_name     = sanitize_text_field( $_POST['first_name'] ?? '' );
    $last_name      = sanitize_text_field( $_POST['last_name'] ?? '' );
    $email          = sanitize_email( $_POST['email'] ?? '' );
    $phone          = sanitize_text_field( $_POST['phone'] ?? '' );
    $city           = sanitize_text_field( $_POST['city'] ?? '' );
    $state          = sanitize_text_field( $_POST['state'] ?? '' );
    $pincode        = sanitize_text_field( $_POST['pincode'] ?? '' );
    $frequency      = sanitize_text_field( $_POST['frequency'] ?? 'one-time' );
    $payment_method = sanitize_text_field( $_POST['payment_method'] ?? '' );

    if ( $amount < 1 ) {
        wp_send_json_error( array( 'message' => 'Invalid donation amount.' ) );
    }
    if ( $amount > DAAN_MAX_DONATION ) {
        wp_send_json_error( array( 'message' => daan_max_donation_message() ) );
    }
    if ( ! in_array( $cause, daan_donation_causes(), true ) ) {
        wp_send_json_error( array( 'message' => 'Please choose a cause from the list.' ) );
    }
    if ( 'Fidyah & Kaffarah' === $cause && daan_fk_hold_on() ) {
        wp_send_json_error( array( 'message' => DAAN_OT_FK_MESSAGE ) );
    }
    // Fixed-price causes (meals, kits): amount must be count × price from the settings, checked here on the server.
    $fixed = function_exists( 'daan_fixed_causes' ) ? ( daan_fixed_causes()[ $cause ] ?? null ) : null;
    if ( ! $fixed && in_array( $cause, array( 'Ramadan Iftar', 'Ration Kit', 'Ration Kit (Interest Money)', 'Fitrana Ration Kit' ), true ) ) {
        wp_send_json_error( array( 'message' => 'Please choose a cause from the list.' ) );
    }
    $qty  = 0;
    $fund = '';
    if ( $fixed ) {
        $qty = intval( $_POST['qty'] ?? 0 );
        if ( $qty < 1 || $qty > daan_fixed_max_qty( $fixed['unit'] ) ) {
            wp_send_json_error( array( 'message' => 'Please choose between 1 and ' . daan_fixed_max_qty( $fixed['unit'] ) . ' ' . $fixed['many'] . '.' ) );
        }
        if ( $amount !== $qty * (int) $fixed['unit'] ) {
            wp_send_json_error( array( 'message' => 'The amount is not correct. Each ' . $fixed['one'] . ' is ₹' . number_format_i18n( $fixed['unit'] ) . '. Please refresh the page and try again.' ) );
        }
        if ( $fixed['fund'] ) {
            $fund = daan_kit_fund( wp_unslash( $_POST['kit_fund'] ?? '' ) );
            if ( ! $fund ) {
                wp_send_json_error( array( 'message' => 'Please choose whether this is your Zakat or Sadaqah.' ) );
            }
        }
    }
    $kit_type    = $fixed ? $fixed['kit'] : '';
    $kit_product = $kit_type ? wc_get_product( (int) get_option( 'daan_kit_' . $kit_type . '_product', 0 ) ) : null;
    if ( $kit_type && ! $kit_product ) { // Kit product missing: refuse instead of taking a free amount.
        wp_send_json_error( array( 'message' => 'This kit is not available right now. Please try again later.' ) );
    }
    if ( ! in_array( $frequency, array( 'one-time', 'monthly' ), true ) ) {
        wp_send_json_error( array( 'message' => 'Please choose one-time or monthly.' ) );
    }
    foreach ( array( 'city' => $city, 'state' => $state ) as $label => $place ) {
        if ( ! preg_match( "/^[\\p{L}\\p{M}][\\p{L}\\p{M} .,'&()-]{1,99}$/u", $place ) ) {
            wp_send_json_error( array( 'message' => 'Please enter a valid ' . $label . '.' ) );
        }
    }

    if ( ! $first_name || ! $last_name || ! $email ) {
        wp_send_json_error( array( 'message' => 'Please fill all required fields.' ) );
    }

    // Mobile is mandatory and PAN optional (plugin daan-order-tools); saved normalized.
    $pan = '';
    if ( function_exists( 'daan_ot_normalize_mobile' ) ) {
        $phone = daan_ot_normalize_mobile( $phone );
        if ( ! $phone ) {
            wp_send_json_error( array( 'message' => DAAN_OT_MOBILE_ERROR ) );
        }
        $pan = daan_ot_normalize_pan( wp_unslash( $_POST['pan'] ?? '' ) );
        if ( false === $pan ) {
            wp_send_json_error( array( 'message' => DAAN_OT_PAN_ERROR ) );
        }
    }

    // Bank transfer was closed on 2026-10-27: an old cached form that still sends 'bacs' becomes a UPI order.
    // Since 2026-10-30 new donations use the UPI QR gateway (plugin upi-qr-payment); an old cached form
    // that still sends 'cheque' or 'bacs' is accepted and becomes a UPI QR donation too.
    if ( in_array( $payment_method, array( 'bacs', 'cheque' ), true ) ) {
        $payment_method = 'upq_manual_qr';
    }
    if ( 'upq_manual_qr' !== $payment_method ) {
        wp_send_json_error( array( 'message' => 'Invalid payment method.' ) );
    }

    if ( ! class_exists( 'WooCommerce' ) ) {
        wp_send_json_error( array( 'message' => 'Checkout system unavailable.' ) );
    }

    // The same form sent again (double click, retry on a slow network) goes to the order already made.
    $idem_key = daan_idem_key( $_POST['daan_token'] ?? '', array( $email, $amount, $cause, $qty, $fund ) );
    $existing = daan_idem_begin( $idem_key );
    if ( $existing ) {
        wp_send_json_success( array( 'order_id' => $existing->get_id(), 'redirect_url' => $existing->get_checkout_order_received_url() ) );
    }

    $order = wc_create_order();
    if ( is_wp_error( $order ) ) {
        wp_send_json_error( array( 'message' => 'Could not create donation order.' ) );
    }

    $address = array(
        'first_name' => $first_name,
        'last_name'  => $last_name,
        'email'      => $email,
        'phone'      => $phone,
        'city'       => $city,
        'state'      => $state,
        'postcode'   => $pincode,
        'country'    => 'IN',
    );
    $order->set_address( $address, 'billing' );

    $saved_cause = $cause;
    if ( $kit_type ) {
        // A kit: the kit product with its number of kits (same line as the product page makes; no execution e-mail).
        $saved_cause = 'general' === $kit_type ? daan_kit_general_cause( $fund ) : daan_kit_cause( $kit_type );
        $item_id     = $order->add_product( $kit_product, $qty, array( 'subtotal' => $amount, 'total' => $amount ) );
        if ( $item_id ) {
            wc_add_order_item_meta( $item_id, 'Cause', $saved_cause );
        }
        $order->update_meta_data( '_daan_kit_type', $kit_type );
    } else {
        $fee = new WC_Order_Item_Fee();
        $fee->set_name( "Donation — $cause" ); // Community Kitchen keeps its line name (receipts, digest, execution e-mail).
        $fee->set_amount( $amount );
        $fee->set_total( $amount );
        $fee->set_tax_status( 'none' );
        if ( $fixed ) {
            $fee->add_meta_data( 'Meals', $qty, true );
        }
        $order->add_item( $fee );
    }

    if ( function_exists( 'upq_is_upi_order' ) ) {
        $order->set_payment_method( 'upq_manual_qr' ); // UPI QR (manual verification).
        $order->set_payment_method_title( 'Pay via QR Code (UPI)' );
        $order->update_meta_data( '_upq_receipt_pending', 'yes' );
    } else {
        $order->set_payment_method( 'cheque' ); // fallback if the plugin is off.
    }

    $order->update_meta_data( '_daan_donation_cause', $saved_cause );
    $order->update_meta_data( '_daan_donation_frequency', $frequency );
    $order->update_meta_data( '_daan_donation_type', 'custom_form' );
    if ( $pan ) {
        $order->update_meta_data( DAAN_OT_PAN_META, $pan );
    }

    $order->calculate_totals();
    $order->set_status( 'on-hold', 'Donation placed via /donate/ form.' );
    $order->save();
    daan_idem_finish( $idem_key, $order );

    $redirect_url = $order->get_checkout_order_received_url();

    wp_send_json_success(
        array(
            'order_id'    => $order->get_id(),
            'redirect_url' => $redirect_url,
        )
    );
}

/* -------------------------------------------------------------------------
 * 6. Auto-Receipt Email
 * ------------------------------------------------------------------------- */

function daan_send_donation_receipt( $to_email, $first_name, $last_name, $amount, $cause, $payment_id, $order_id, $frequency, $city = '', $state = '', $pincode = '' ) {
    $display_amount = '₹' . number_format( $amount );

    $body = "
<html>
<head><style>
body{font-family:'Open Sans',Arial,sans-serif;color:#333;line-height:1.6;margin:0;padding:0}
.container{max-width:600px;margin:0 auto;padding:24px}
.header{background:linear-gradient(135deg,#EA580C,#F97316);color:#fff;padding:32px 24px;text-align:center;border-radius:12px 12px 0 0}
.header h1{margin:0;font-size:24px}
.content{padding:24px;background:#fff;border:1px solid #E2E8F0;border-top:none}
.details{background:#F8FAFC;border-radius:8px;padding:16px;margin:16px 0}
.details dt{font-weight:600;color:#475569;font-size:14px}
.details dd{margin:0 0 12px 0;color:#111827;font-size:16px}
.bank-info{background:#FFFBEB;border:1px solid #FDE68A;border-radius:8px;padding:16px;margin:16px 0;font-size:14px;color:#92400E}
.footer{text-align:center;padding:16px;font-size:12px;color:#94A3B8}
</style></head>
<body>
<div class='container'>
<div class='header'><h1>Thank You for Your Donation</h1></div>
<div class='content'>
<p>Dear $first_name $last_name,</p>
<p>Thank you for your generous contribution to <strong>Daan Foundation</strong>. Your support helps us serve those in need with dignity and compassion.</p>

<div class='details'>
<dl>
<dt>Amount</dt><dd>$display_amount</dd>
<dt>Cause</dt><dd>$cause</dd>
                        <dt>Frequency</dt><dd>$frequency</dd>
                        <dt>City</dt><dd>$city</dd>
                        <dt>State</dt><dd>$state</dd>
                        <dt>Pincode</dt><dd>$pincode</dd>
                        <dt>Date</dt><dd>" . current_time( 'F j, Y g:i A' ) . "</dd>
<dt>Payment ID</dt><dd>$payment_id</dd>
<dt>Order ID</dt><dd>$order_id</dd>
</dl>
</div>

<p>Your donation receipt serves as a record for your contribution.</p>

<p>Note: Daan Foundation is not registered under Section 80G; this donation is not eligible for tax deduction.</p>

" . ( daan_receipt_url( $order_id ) ? "<p><a href='" . esc_url( daan_receipt_url( $order_id ) ) . "' style='color:#C2410C;'>View or print your receipt</a></p>" : "" ) . "

<p>With gratitude,<br><strong>Daan Foundation Team</strong></p>
<p><a href='https://daanfoundation.in' style='color:#F97316;'>daanfoundation.in</a></p>
</div>
<div class='footer'>
<p>Daan Foundation (Registered Trust) | Reg. No. 149/11-20/302 (Tehsil Amroha) | PAN: AAETD5465E</p>
<p>Katkoi Plot No. 145, Amroha District, Uttar Pradesh, India 244221</p>
</div>
</div>
</body>
</html>";

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Daan Foundation <noreply@daanfoundation.in>',
    );

    wp_mail( $to_email, "Your Donation Receipt - Daan Foundation ($display_amount)", $body, $headers );
}

/* -------------------------------------------------------------------------
 * 7. Donation receipt page
 * ------------------------------------------------------------------------- */

add_action( 'template_redirect', 'daan_generate_donation_receipt_page' );

/**
 * Receipt links look like  /?receipt=<order id>&key=<WooCommerce order key>.
 * Without the right key a visitor must type the e-mail address of the order. Every failed try
 * looks identical (no hint whether the order exists) and is rate-limited per IP address and per order.
 * Only paid orders (completed / processing) have a receipt.
 */
/** Causes of a donation for the receipt: its lines first, then the saved cause, otherwise "Donation". Reads only. */
function daan_receipt_cause( $order ) {
    $causes = array();
    foreach ( $order->get_items( array( 'line_item', 'fee' ) ) as $item ) {
        $name = trim( preg_replace( '/^Donation\s*[—–-]\s*/u', '', html_entity_decode( $item->get_name(), ENT_QUOTES, 'UTF-8' ) ) );
        if ( '' !== $name && 'Donation' !== $name ) {
            $causes[ $name ] = $name;
        }
    }
    return $causes ? implode( ', ', $causes ) : ( $order->get_meta( '_daan_donation_cause' ) ?: 'Donation' );
}

function daan_receipt_url( $order ) {
    if ( is_numeric( $order ) && function_exists( 'wc_get_order' ) ) {
        $order = wc_get_order( (int) $order );
    }
    if ( ! $order || ! is_a( $order, 'WC_Order' ) ) {
        return '';
    }
    return add_query_arg(
        array(
            'receipt' => $order->get_id(),
            'key'     => $order->get_order_key(),
        ),
        home_url( '/' )
    );
}

function daan_receipt_client_ip() {
    // The server's own value: forwarded-IP headers can be set by the visitor and would dodge the limits.
    return isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
}

function daan_receipt_shell( $title, $inner, $status = 200 ) {
    status_header( $status );
    nocache_headers();
    header( 'X-Robots-Tag: noindex, nofollow' );
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex,nofollow"><title>' . esc_html( $title ) . '</title>';
    echo '<style>body{font-family:"Open Sans",Arial,sans-serif;color:#333;margin:0;background:#F8FAFC;line-height:1.6}.box{max-width:460px;margin:60px auto;background:#fff;border:1px solid #E2E8F0;border-radius:12px;padding:32px}h1{font-size:22px;margin:0 0 12px;color:#111827}.msg{background:#FFF7ED;border:1px solid #FDBA74;border-radius:8px;padding:10px 12px;color:#9A3412;font-size:14px}label{display:block;font-weight:600;font-size:14px;margin:16px 0 6px}input[type=email]{width:100%;box-sizing:border-box;padding:12px 14px;border:2px solid #E2E8F0;border-radius:10px;font-size:16px}button{margin-top:16px;width:100%;padding:12px;border:0;border-radius:10px;background:#C2410C;color:#fff;font-size:16px;font-weight:700;cursor:pointer}</style></head><body><div class="box">';
    echo $inner; // built from escaped parts only.
    echo '</div></body></html>';
    exit;
}

function daan_receipt_form_html( $receipt_id, $message = '' ) {
    $action = add_query_arg( 'receipt', rawurlencode( $receipt_id ), home_url( '/' ) );
    $html   = '<h1>Donation receipt</h1>';
    if ( '' !== $message ) {
        $html .= '<p class="msg">' . esc_html( $message ) . '</p>';
    }
    $html .= '<p>To see this receipt, please enter the e-mail address you used for the donation.</p>';
    $html .= '<form method="post" action="' . esc_url( $action ) . '"><label for="receipt_email">E-mail address</label><input type="email" id="receipt_email" name="receipt_email" required autocomplete="email"><button type="submit">Show receipt</button></form>';
    return $html;
}

function daan_generate_donation_receipt_page() {
    if ( empty( $_GET['receipt'] ) ) {
        return;
    }

    $input_id = sanitize_text_field( wp_unslash( $_GET['receipt'] ) );
    $key      = isset( $_GET['key'] ) ? sanitize_text_field( wp_unslash( $_GET['key'] ) ) : '';
    $email    = '';
    if ( isset( $_SERVER['REQUEST_METHOD'] ) && 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['receipt_email'] ) ) {
        $email = strtolower( trim( sanitize_email( wp_unslash( $_POST['receipt_email'] ) ) ) );
    }

    // Rate limit: at most 5 failed tries per IP per 15 minutes and 10 per receipt number per hour.
    $ip_key    = 'daan_rcpt_ip_' . md5( daan_receipt_client_ip() );
    $order_key = 'daan_rcpt_id_' . md5( $input_id );
    $ip_fails  = (int) get_transient( $ip_key );
    $id_fails  = (int) get_transient( $order_key );
    if ( $ip_fails >= 5 || $id_fails >= 10 ) {
        daan_receipt_shell( 'Too many attempts', '<h1>Too many attempts</h1><p>Please wait a while and try again later.</p>', 429 );
    }

    global $wpdb;
    $record = null;

    // WooCommerce order: valid key OR matching billing e-mail, paid orders only.
    if ( function_exists( 'wc_get_order' ) && ctype_digit( $input_id ) ) {
        $order = wc_get_order( (int) $input_id );
        if ( $order && 'shop_order' === $order->get_type() && in_array( $order->get_status(), array( 'completed', 'processing' ), true ) ) {
            $billing       = $order->get_address( 'billing' );
            $billing_email = strtolower( trim( (string) $order->get_billing_email() ) );
            $key_ok        = ( '' !== $key && hash_equals( (string) $order->get_order_key(), $key ) );
            $email_ok      = ( '' !== $email && '' !== $billing_email && hash_equals( $billing_email, $email ) );
            if ( $key_ok || $email_ok ) {
                $created = $order->get_date_created();
                $record  = array(
                    'name'       => trim( $billing['first_name'] . ' ' . $billing['last_name'] ),
                    'email'      => $billing['email'],
                    'amount'     => $order->get_total(),
                    'cause'      => daan_receipt_cause( $order ),
                    'frequency'  => $order->get_meta( '_daan_donation_frequency' ) ?: 'one-time',
                    'city'       => $billing['city'],
                    'state'      => $billing['state'],
                    'pincode'    => $billing['postcode'],
                    'date'       => $created ? $created->date_i18n( 'F j, Y' ) : '',
                    'payment_id' => '',
                    'order_id'   => $order->get_order_number(),
                    'txn_type'   => $order->get_payment_method_title() ?: 'Bank Transfer / UPI',
                );
            }
        }
    }

    // Legacy table (older Razorpay donations): e-mail must match.
    if ( ! $record && '' !== $email ) {
        $table = $wpdb->prefix . 'daan_donations';
        $donor = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table WHERE order_id = %s LIMIT 1", $input_id ) );
        if ( $donor && '' !== trim( (string) $donor->email ) && hash_equals( strtolower( trim( (string) $donor->email ) ), $email ) ) {
            $record = array(
                'name'       => trim( $donor->first_name . ' ' . $donor->last_name ),
                'email'      => $donor->email,
                'amount'     => $donor->amount,
                'cause'      => $donor->cause,
                'frequency'  => $donor->frequency,
                'city'       => $donor->city,
                'state'      => $donor->state,
                'pincode'    => $donor->pincode,
                'date'       => date_i18n( 'F j, Y', strtotime( $donor->created_at ) ),
                'payment_id' => $donor->payment_id,
                'order_id'   => $donor->order_id,
                'txn_type'   => 'Online Payment (Razorpay)',
            );
        }
    }

    if ( ! $record ) {
        if ( '' !== $key || '' !== $email ) {
            set_transient( $ip_key, $ip_fails + 1, 15 * MINUTE_IN_SECONDS );
            set_transient( $order_key, $id_fails + 1, HOUR_IN_SECONDS );
            daan_receipt_shell( 'Donation receipt', daan_receipt_form_html( $input_id, 'We could not find a receipt for these details. Please check and try again.' ) );
        }
        daan_receipt_shell( 'Donation receipt', daan_receipt_form_html( $input_id ) );
    }

    nocache_headers();
    header( 'X-Robots-Tag: noindex, nofollow' );

    $donor_name       = $record['name'];
    $donor_email      = $record['email'];
    $donor_amount     = $record['amount'];
    $donor_cause      = $record['cause'];
    $donor_frequency  = $record['frequency'];
    $donor_city       = $record['city'];
    $donor_state      = $record['state'];
    $donor_pincode    = $record['pincode'];
    $donor_date       = $record['date'];
    $donor_payment_id = $record['payment_id'];
    $donor_order_id   = $record['order_id'];
    $txn_type         = $record['txn_type'];

    $amount_display = '₹' . number_format( (float) $donor_amount, 2 );
    $address_line   = trim(
        ( $donor_city ? $donor_city : '' )
        . ( $donor_city && $donor_state ? ', ' : '' )
        . ( $donor_state ? $donor_state : '' )
        . ( $donor_pincode ? ' - ' . $donor_pincode : '' )
    );

    ?>
<!DOCTYPE html>
<html>
<head><title>Donation Receipt - Daan Foundation</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body{font-family:'Open Sans',Arial,sans-serif;color:#111111;background:#F3F4F6;margin:0;padding:24px 12px;line-height:1.6}
.receipt{max-width:800px;margin:0 auto;background:#fff;border:1px solid #E5E7EB;border-top:4px solid #EA580C;border-radius:8px;padding:32px 24px;box-sizing:border-box}
.header{text-align:center;border-bottom:1px solid #E5E7EB;padding-bottom:20px;margin-bottom:20px}
.header img{width:180px;max-width:60%;height:auto;margin-bottom:8px}
.header h1{margin:0;font-size:22px;color:#C2410C}
.header h2{margin:5px 0;font-size:18px}
.content table{width:100%;border-collapse:collapse}
.content td{padding:8px 12px;border-bottom:1px solid #E5E7EB;overflow-wrap:anywhere}
.content td:first-child{font-weight:600;width:40%;color:#666666}
.footer{margin-top:30px;padding-top:20px;border-top:1px solid #E5E7EB;font-size:13px;color:#666666}
.stamp{text-align:right;margin-top:30px}
.stamp img{width:120px}
@media print{body{margin:0;padding:0;background:#fff}.receipt{border:none}.no-print{display:none}}
</style></head>
<body>
<div class="receipt">
<div class="header">
<img src="<?php echo esc_url( (string) get_option( 'woocommerce_email_header_image' ) ); ?>" alt="Daan Foundation">
<h1>Daan Foundation</h1>
<h2>Donation Receipt</h2>
<p>Daan Foundation (Registered Trust) | Reg. No. 149/11-20/302 (Tehsil Amroha) | PAN: AAETD5465E</p>
</div>

<div class="content">
<p style="font-size:16px;font-weight:600;text-align:center;margin-bottom:20px;">Receipt for Donation</p>

<table>
<tr><td>Donor Name</td><td><?php echo esc_html( $donor_name ); ?></td></tr>
<tr><td>Email</td><td><?php echo esc_html( $donor_email ); ?></td></tr>
<tr><td>Donation Amount</td><td><?php echo $amount_display; ?></td></tr>
<tr><td>Cause</td><td><?php echo esc_html( $donor_cause ); ?></td></tr>
<tr><td>Frequency</td><td><?php echo esc_html( $donor_frequency ); ?></td></tr>
<?php if ( ! empty( $address_line ) ) : ?>
<tr><td>Address</td><td><?php echo esc_html( $address_line ); ?></td></tr>
<?php endif; ?>
<tr><td>Date of Donation</td><td><?php echo $donor_date; ?></td></tr>
<?php if ( $donor_payment_id ) : ?>
<tr><td>Payment ID</td><td><?php echo esc_html( $donor_payment_id ); ?></td></tr>
<?php endif; ?>
<tr><td>Donation / Receipt No</td><td><?php echo esc_html( $donor_order_id ); ?></td></tr>
<tr><td>Payment method</td><td><?php echo esc_html( $txn_type ); ?></td></tr>
</table>
</div>

<div class="footer">
<p>This is a computer-generated receipt and does not require a physical signature.</p>
<p>For verification, please contact: <strong>daanfoundationindia@gmail.com</strong></p>
<p style="margin-top:12px;"><em>Note: Daan Foundation is not registered under Section 80G; this donation is not eligible for tax deduction.</em></p>
</div>

<div class="stamp">
<p style="margin:0;">Authorised Signatory</p>
<p style="margin:0;">Daan Foundation</p>
</div>
</div>

<div class="no-print" style="text-align:center;margin-top:20px;">
<button onclick="window.print()" style="padding:10px 24px;background:#C2410C;color:#fff;border:none;border-radius:8px;cursor:pointer;font-size:16px;">Print Receipt</button>
</div>
</body>
</html>
    <?php
    exit;
}

/* -------------------------------------------------------------------------
 * 8. Custom WooCommerce Donation Product Creator
 * ------------------------------------------------------------------------- */

add_action( 'after_switch_theme', 'daan_create_donation_products' );

function daan_create_donation_products() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return;
    }

    $donation_causes = array(
        'community-kitchen' => array(
            'name'  => 'Community Kitchen',
            'price' => 59,
            'cause' => 'Community Kitchen',
        ),
        'ramadan-iftar' => array(
            'name'  => 'Ramadan Iftar',
            'price' => 100,
            'cause' => 'Ramadan Iftar',
        ),
        'zakat' => array(
            'name'  => 'Zakat',
            'price' => 1000,
            'cause' => 'Zakat',
        ),
        'sadaqah' => array(
            'name'  => 'Sadaqah',
            'price' => 500,
            'cause' => 'Sadaqah',
        ),
        'sadaqah-jariyah' => array(
            'name'  => 'Sadaqah Jariyah',
            'price' => 1000,
            'cause' => 'Sadaqah',
        ),
        'fidyah-kaffarah' => array(
            'name'  => 'Fidyah & Kaffarah',
            'price' => 500,
            'cause' => 'Fidyah & Kaffarah',
        ),
        'where-most-needed' => array(
            'name'  => 'Where Most Needed',
            'price' => 500,
            'cause' => 'Where Most Needed',
        ),
    );

    $category_id = 0;
    $term = term_exists( 'donations', 'product_cat' );
    if ( ! $term ) {
        $result = wp_insert_term( 'Donations', 'product_cat', array( 'slug' => 'donations' ) );
        if ( ! is_wp_error( $result ) ) {
            $category_id = $result['term_id'];
        }
    } else {
        $category_id = intval( $term['term_id'] );
    }

    foreach ( $donation_causes as $slug => $info ) {
        $existing = get_posts(
            array(
                'post_type'   => 'product',
                'name'        => $slug,
                'post_status' => 'any',
                'numberposts' => 1,
                'fields'      => 'ids',
            )
        );

        if ( ! empty( $existing ) ) {
            continue;
        }

        $product_id = wp_insert_post(
            array(
                'post_title'   => $info['name'],
                'post_name'    => $slug,
                'post_type'    => 'product',
                'post_status'  => 'publish',
                'post_content' => "Donation for {$info['name']}. All proceeds go directly to those in need.",
            )
        );

        if ( $product_id && ! is_wp_error( $product_id ) ) {
            wp_set_object_terms( $product_id, 'simple', 'product_type' );
            wp_set_object_terms( $product_id, array( (int) $category_id ), 'product_cat' );
            update_post_meta( $product_id, '_price', $info['price'] );
            update_post_meta( $product_id, '_regular_price', $info['price'] );
            update_post_meta( $product_id, '_virtual', 'yes' );
            update_post_meta( $product_id, '_donation', 'yes' );
            update_post_meta( $product_id, '_daan_cause', $info['cause'] );
            update_post_meta( $product_id, '_sold_individually', 'yes' );
            update_post_meta( $product_id, '_manage_stock', 'no' );
            update_post_meta( $product_id, '_stock_status', 'instock' );
        }
    }
}

/* -------------------------------------------------------------------------
 * 9. Pending Donation Cleanup (Cron)
 * ------------------------------------------------------------------------- */

add_action( 'wp', 'daan_schedule_cleanup_cron' );

function daan_schedule_cleanup_cron() {
    if ( ! wp_next_scheduled( 'daan_hourly_cleanup' ) ) {
        wp_schedule_event( time(), 'hourly', 'daan_hourly_cleanup' );
    }
}

add_action( 'daan_hourly_cleanup', 'daan_cleanup_pending_donations' );

function daan_cleanup_pending_donations() {
    global $wpdb;

    $table = $wpdb->prefix . 'daan_donations';
    $cutoff = date( 'Y-m-d H:i:s', strtotime( '-24 hours' ) );

    $wpdb->query(
        $wpdb->prepare(
            "UPDATE $table SET status = 'cancelled' WHERE status = 'pending' AND created_at < %s",
            $cutoff
        )
    );
}
