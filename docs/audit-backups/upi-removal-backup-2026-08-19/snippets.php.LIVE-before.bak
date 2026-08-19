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

add_action( 'wp_ajax_nopriv_daan_contact_form', 'daan_handle_contact_form' );
add_action( 'wp_ajax_daan_contact_form', 'daan_handle_contact_form' );

function daan_handle_contact_form() {
    if ( ! wp_verify_nonce( $_POST['daan_contact_nonce'] ?? '', 'daan_contact' ) ) {
        wp_send_json_error( array( 'message' => 'Security check failed.' ) );
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

    $email_body = "Name: $first_name $last_name\nEmail: $email\nSubject: $subject\n\nMessage:\n$message";
    $email_body .= "\n\n---\nSubmitted via Daan Foundation website contact form.";

    wp_mail(
        DAAN_NOTIFICATION_EMAIL,
        "Contact Form: $subject",
        $email_body,
        array( "From: $email", "Reply-To: $email" )
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
        "Thank you for subscribing to the Daan Foundation newsletter!\n\nYou will now receive updates on our campaigns, impact stories, and Islamic giving opportunities.\n\nWarm regards,\nDaan Foundation Team"
    );

    wp_send_json_success( array( 'message' => 'Thank you for subscribing!' ) );
}

/* -------------------------------------------------------------------------
 * 4. Donation Order — WooCommerce Order Creation
 * ------------------------------------------------------------------------- */

add_action( 'wp_ajax_daan_place_order', 'daan_place_order' );
add_action( 'wp_ajax_nopriv_daan_place_order', 'daan_place_order' );

function daan_place_order() {
    $amount         = intval( $_POST['amount'] ?? 0 );
    $cause          = sanitize_text_field( $_POST['cause'] ?? 'Where Most Needed' );
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

    if ( ! $first_name || ! $last_name || ! $email ) {
        wp_send_json_error( array( 'message' => 'Please fill all required fields.' ) );
    }

    if ( ! in_array( $payment_method, array( 'bacs', 'cheque' ), true ) ) {
        wp_send_json_error( array( 'message' => 'Invalid payment method.' ) );
    }

    if ( ! class_exists( 'WooCommerce' ) ) {
        wp_send_json_error( array( 'message' => 'Checkout system unavailable.' ) );
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

    $fee = new WC_Order_Item_Fee();
    $fee->set_name( "Donation — $cause" );
    $fee->set_amount( $amount );
    $fee->set_total( $amount );
    $fee->set_tax_status( 'none' );
    $order->add_item( $fee );

    if ( 'bacs' === $payment_method ) {
        $order->set_payment_method( 'bacs' );
    } else {
        $order->set_payment_method( 'cheque' );
    }

    $order->update_meta_data( '_daan_donation_cause', $cause );
    $order->update_meta_data( '_daan_donation_frequency', $frequency );
    $order->update_meta_data( '_daan_donation_type', 'custom_form' );

    $order->calculate_totals();
    $order->set_status( 'on-hold', 'Donation placed via /donate/ form.' );
    $order->save();

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

<p>Your donation receipt serves as a record for your contribution. For 80G tax exemption certificates, please contact us with your donation details.</p>

<div class='bank-info'>
<strong>For 80G Certificate Reference:</strong><br>
Bank: State Bank of India<br>
A/C: 42818355421<br>
IFSC: SBIN0003448<br>
Branch: Amroha, UP<br>
UPI: 8899152910@ptsbi
</div>

<p>With gratitude,<br><strong>Daan Foundation Team</strong></p>
<p><a href='https://daanfoundation.in' style='color:#F97316;'>daanfoundation.in</a></p>
</div>
<div class='footer'>
<p>Daan Foundation | Registered Charity No. 124456</p>
<p>Katkoi Street, Near DiwanKhana, Plot No. 141, District Amroha, Uttar Pradesh - 244221, India</p>
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
 * 7. 80G Certificate Generator
 * ------------------------------------------------------------------------- */

add_action( 'template_redirect', 'daan_generate_80g_certificate' );

function daan_generate_80g_certificate() {
    if ( empty( $_GET['receipt'] ) ) {
        return;
    }

    $input_id = sanitize_text_field( $_GET['receipt'] );

    global $wpdb;

    $donor_name = '';
    $donor_email = '';
    $donor_amount = 0;
    $donor_cause = '';
    $donor_frequency = '';
    $donor_city = '';
    $donor_state = '';
    $donor_pincode = '';
    $donor_date = '';
    $donor_payment_id = '';
    $donor_order_id = '';

    // Try custom daan_donations table first (legacy Razorpay donations)
    $table = $wpdb->prefix . 'daan_donations';
    $donor = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table WHERE order_id = %s LIMIT 1", $input_id ) );

    if ( $donor ) {
        $donor_name      = $donor->first_name . ' ' . $donor->last_name;
        $donor_email     = $donor->email;
        $donor_amount    = $donor->amount;
        $donor_cause     = $donor->cause;
        $donor_frequency = $donor->frequency;
        $donor_city      = $donor->city;
        $donor_state     = $donor->state;
        $donor_pincode   = $donor->pincode;
        $donor_date      = date_i18n( 'F j, Y', strtotime( $donor->created_at ) );
        $donor_payment_id = $donor->payment_id;
        $donor_order_id  = $donor->order_id;
        $txn_type        = 'Online Payment (Razorpay)';
    }

    // Fallback: WooCommerce order
    if ( ! $donor && function_exists( 'wc_get_order' ) ) {
        $order = wc_get_order( intval( $input_id ) );
        if ( $order ) {
            $billing = $order->get_address( 'billing' );
            $donor_name      = $billing['first_name'] . ' ' . $billing['last_name'];
            $donor_email     = $billing['email'];
            $donor_amount    = $order->get_total();
            $donor_cause     = $order->get_meta( '_daan_donation_cause' ) ?: 'Donation';
            $donor_frequency = $order->get_meta( '_daan_donation_frequency' ) ?: 'one-time';
            $donor_city      = $billing['city'];
            $donor_state     = $billing['state'];
            $donor_pincode   = $billing['postcode'];
            $donor_date      = $order->get_date_created()->date_i18n( 'F j, Y' );
            $donor_order_id  = $order->get_order_number();
            $payment_method  = $order->get_payment_method_title();
            $txn_type        = $payment_method ?: 'Bank Transfer / UPI';
        }
    }

    if ( ! $donor_name ) {
        wp_die( 'Donation not found.', '404', array( 'response' => 404 ) );
    }

    $amount_display = '₹' . number_format( $donor_amount );
    $address_line   = trim(
        ( $donor_city ? $donor_city : '' )
        . ( $donor_city && $donor_state ? ', ' : '' )
        . ( $donor_state ? $donor_state : '' )
        . ( $donor_pincode ? ' - ' . $donor_pincode : '' )
    );

    ?>
<!DOCTYPE html>
<html>
<head><title>80G Tax Exemption Receipt - Daan Foundation</title>
<style>
body{font-family:'Open Sans',Arial,sans-serif;color:#333;margin:40px;line-height:1.6}
.receipt{max-width:800px;margin:0 auto;border:2px solid #333;padding:40px}
.header{text-align:center;border-bottom:2px solid #333;padding-bottom:20px;margin-bottom:20px}
.header h1{margin:0;font-size:22px;color:#EA580C}
.header h2{margin:5px 0;font-size:18px}
.content table{width:100%;border-collapse:collapse}
.content td{padding:8px 12px;border-bottom:1px solid #E2E8F0}
.content td:first-child{font-weight:600;width:180px;color:#475569}
.footer{margin-top:30px;padding-top:20px;border-top:1px solid #E2E8F0;font-size:13px;color:#64748B}
.stamp{text-align:right;margin-top:30px}
.stamp img{width:120px}
@media print{body{margin:0}.receipt{border:none}.no-print{display:none}}
</style></head>
<body>
<div class="receipt">
<div class="header">
<h1>Daan Foundation</h1>
<h2>80G Tax Exemption Certificate</h2>
<p>Registered Charity No. 124456</p>
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
<tr><td>Order / Receipt No</td><td><?php echo esc_html( $donor_order_id ); ?></td></tr>
<tr><td>Transaction Type</td><td><?php echo esc_html( $txn_type ); ?></td></tr>
</table>
</div>

<div class="footer">
<p>This is a computer-generated receipt and does not require a physical signature.</p>
<p>For verification, please contact: <strong>daanfoundationindia@gmail.com</strong></p>
<p><strong>Bank Details for 80G Reference:</strong><br>
State Bank of India | A/C: 42818355421 | IFSC: SBIN0003448 | Branch: Amroha, UP</p>
<p style="margin-top:12px;"><em>Daan Foundation is registered under Section 12A/80G of the Income Tax Act, 1961.</em></p>
</div>

<div class="stamp">
<p style="margin:0;">Authorised Signatory</p>
<p style="margin:0;">Daan Foundation</p>
</div>
</div>

<div class="no-print" style="text-align:center;margin-top:20px;">
<button onclick="window.print()" style="padding:10px 24px;background:#F97316;color:#fff;border:none;border-radius:8px;cursor:pointer;font-size:16px;">Print Receipt</button>
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
