<?php
/**
 * WooCommerce e-mails: donation wording and the site's colours, font and footer.
 * Layout rules stay in inc/email-layout.php; custom HTML mails get the same look from mu-plugins/daan-email-layout.php.
 * Rollback: remove the require in functions.php.
 *
 * @package Daan
 */

defined( 'ABSPATH' ) || exit;

/** Subject and heading per e-mail id. %s = donation number. */
function daan_email_brand_titles() {
	return array(
		'customer_on_hold_order'    => array( 'Thank you for your donation #%s', '' ),
		'customer_processing_order' => array( 'We have received your donation #%s', 'Thank you for your donation' ),
		'customer_completed_order'  => array( 'Payment received — your donation #%s is confirmed', 'Thank you for your donation' ),
		'customer_refunded_order'   => array( 'Your donation #%s has been refunded', 'Your donation has been refunded' ),
		'customer_failed_order'     => array( 'Your donation #%s could not be completed', 'Your donation could not be completed' ),
		'customer_cancelled_order'  => array( 'Your donation #%s has been cancelled', 'Your donation has been cancelled' ),
		'customer_invoice'          => array( 'Please complete your donation #%s', 'Thank you for your donation' ),
		'customer_note'             => array( 'An update on your donation #%s', 'An update on your donation' ),
		'cancelled_order'           => array( '[Daan Foundation] Donation #%s has been cancelled', 'Donation cancelled: #%s' ),
		'failed_order'              => array( '[Daan Foundation] Donation #%s has failed', 'Donation failed: #%s' ),
	);
}

foreach ( daan_email_brand_titles() as $daan_email_id => $daan_email_title ) {
	add_filter(
		'woocommerce_email_subject_' . $daan_email_id,
		function ( $subject, $order = null ) use ( $daan_email_title ) {
			return $order instanceof WC_Order ? sprintf( $daan_email_title[0], $order->get_order_number() ) : $subject;
		},
		30,
		2
	);
	if ( '' !== $daan_email_title[1] ) {
		add_filter(
			'woocommerce_email_heading_' . $daan_email_id,
			function ( $heading, $order = null ) use ( $daan_email_title ) {
				return $order instanceof WC_Order ? sprintf( $daan_email_title[1], $order->get_order_number() ) : $heading;
			},
			30,
			2
		);
	}
}

// Account mails: only sent if an account is ever created (sign-up is off on this site).
add_filter( 'woocommerce_email_subject_customer_reset_password', function () { return 'Reset your Daan Foundation password'; }, 30 );
add_filter( 'woocommerce_email_subject_customer_new_account', function () { return 'Your Daan Foundation account'; }, 30 );
add_filter( 'woocommerce_email_heading_customer_reset_password', function () { return 'Reset your password'; }, 30 );
add_filter( 'woocommerce_email_heading_customer_new_account', function () { return 'Welcome to Daan Foundation'; }, 30 );

// Closing lines such as "We look forward to fulfilling your order soon". The invoice keeps its saved payment text.
foreach ( array( 'customer_on_hold_order', 'customer_processing_order', 'customer_refunded_order', 'customer_failed_order', 'customer_cancelled_order', 'customer_note', 'customer_reset_password', 'customer_new_account', 'new_order', 'cancelled_order', 'failed_order' ) as $daan_email_id ) {
	add_filter( 'woocommerce_email_additional_content_' . $daan_email_id, '__return_empty_string', 30 );
}
add_filter(
	'woocommerce_email_additional_content_customer_completed_order',
	function () {
		return 'Thank you for your generous donation.';
	},
	30
);

/** Exact WooCommerce strings used inside e-mails. */
function daan_email_brand_strings() {
	return array(
		'Hi %s,'  => 'Dear %s,',
		'Hi,'     => 'Dear donor,',
		'[Donation Receipt #%s]' => 'Donation #%s',
		'[Donation #%s]'         => 'Donation #%s',
		'Just to let you know &mdash; we\'ve received your order #%s, and it is now being processed:' => 'We have received your donation #%s. We will confirm it once the payment has been received.',
		'Just to let you know &mdash; we’ve received your order #%s, and it is now being processed:'  => 'We have received your donation #%s. We will confirm it once the payment has been received.',
		'We have finished processing your order.' => 'Your payment has been received and your donation is confirmed.',
		'Your order on %s has been partially refunded. There are more details below for your reference:' => 'Your donation on %s has been partially refunded. The details are below.',
		'Your order on %s has been refunded. There are more details below for your reference:' => 'Your donation on %s has been refunded. The details are below.',
		'Unfortunately, we couldn\'t complete your order due to an issue with your payment method.' => 'Unfortunately, we could not complete your donation because of a problem with the payment.',
		'Unfortunately, we couldn’t complete your order due to an issue with your payment method.'  => 'Unfortunately, we could not complete your donation because of a problem with the payment.',
		'If you\'d like to continue with your purchase, please return to %s and try a different method of payment.' => 'If you would like to try again, please return to %s.',
		'If you’d like to continue with your purchase, please return to %s and try a different method of payment.'  => 'If you would like to try again, please return to %s.',
		'Your order details are as follows:' => 'Your donation details are below.',
		'Here are the details of your order placed on %s:' => 'Here are the details of your donation made on %s:',
		'Sorry, your order on %1$s was unsuccessful. Your order details are below, with a link to try your payment again: %2$s' => 'Sorry, your donation on %1$s could not be completed. The details are below, with a link to try the payment again: %2$s',
		'An order has been created for you on %1$s. Your order details are below, with a link to make payment when you’re ready: %2$s' => 'A donation has been created for you on %1$s. The details are below, with a link to make the payment: %2$s',
		'Pay for this order' => 'Complete this donation',
		'The following note has been added to your order:' => 'The following note has been added to your donation:',
		'As a reminder, here are your order details:' => 'Here are your donation details:',
		'Billing address' => 'Donor details',
		'You can access your account area to view orders, change your password, and more via the link below:' => 'You can open your account, view your donations and change your password with the link below:',
		'Thanks for creating an account on %s. Here’s a copy of your user details.' => 'Thank you for creating an account on %s. Here are your details.',
		'We’re sorry to let you know that your order #%1$s has been cancelled.' => 'We are sorry to let you know that your donation #%1$s has been cancelled.',
		'Thanks for creating an account on %1$s. Your username is %2$s. You can access your account area to view orders, change your password, and more at: %3$s' => 'Thank you for creating an account on %1$s. Your username is %2$s. You can open your account, view your donations and change your password at: %3$s',
		// Admin
		'Notification to let you know &mdash; order #%1$s belonging to %2$s has been cancelled:' => 'Donation #%1$s from %2$s has been cancelled:',
		'Payment for order #%1$s from %2$s has failed. The order was as follows:' => 'Payment for donation #%1$s from %2$s has failed. The details are below:',
		'You’ve received a new donation from %s:' => 'New donation from %s:',
	);
}

function daan_email_brand_gettext( $translation, $text ) {
	// Completed mail, first line, with the donation number (2026-11-15).
	if ( 'We have finished processing your order.' === $text && ! empty( $GLOBALS['daan_email_order'] ) ) {
		return '✅ We have received your payment. Your donation #' . $GLOBALS['daan_email_order']->get_order_number() . ' is confirmed.';
	}
	$map = daan_email_brand_strings();
	return $map[ $text ] ?? $translation;
}
add_action(
	'woocommerce_email_header',
	function ( $heading = '', $email = null ) {
		$GLOBALS['daan_email_order'] = ( $email && isset( $email->object ) && $email->object instanceof WC_Order ) ? $email->object : null;
		add_filter( 'gettext_woocommerce', 'daan_email_brand_gettext', 20, 2 );
	},
	1,
	2
);
add_action( 'woocommerce_email_footer', function () { remove_filter( 'gettext_woocommerce', 'daan_email_brand_gettext', 20 ); $GLOBALS['daan_email_order'] = null; }, 99 );

add_filter(
	'woocommerce_email_footer_text',
	function () {
		return daan_email_footer_lines();
	},
	30
);

add_filter(
	'woocommerce_email_styles',
	function ( $css ) {
		$font = "'Open Sans',Arial,Helvetica,sans-serif";
		return $css . "
body,#outer_wrapper{background-color:#F3F4F6 !important;}
#template_header_image{text-align:center;padding:8px 0 16px;}
#template_header_image p{margin:0 !important;}
#template_header_image img{display:inline-block;width:140px;max-width:none;height:auto;box-sizing:content-box;background:#FFFFFF;padding:8px 12px;border-radius:8px;}
#template_container{background-color:#FFFFFF !important;border:1px solid #E5E7EB !important;border-top:4px solid #EA580C !important;border-radius:8px !important;box-shadow:none !important;}
#template_header{background-color:#FFFFFF !important;color:#111111 !important;border-radius:8px 8px 0 0 !important;}
#header_wrapper{padding-bottom:0 !important;}
#header_wrapper h1,h1{color:#111111 !important;background:none !important;font-family:{$font} !important;font-size:24px !important;line-height:1.3 !important;font-weight:700 !important;text-align:left !important;text-shadow:none !important;margin:0 !important;}
#body_content,#body_content_inner{background-color:#FFFFFF !important;color:#111111 !important;font-family:{$font} !important;font-size:15px !important;line-height:1.6 !important;}
#body_content_inner p{color:#111111;margin:0 0 14px;text-align:left;}
h2{color:#111111 !important;font-family:{$font} !important;font-size:18px !important;line-height:1.4 !important;font-weight:700 !important;margin:20px 0 10px !important;text-align:left !important;}
#body_content_inner a,.link{color:#C2410C !important;font-weight:700;}
#body_content_inner a.upq-btn{color:#FFFFFF !important;}
.td,#body_content_inner table.td,#body_content_inner table.td th,#body_content_inner table.td td{border:1px solid #E5E7EB !important;color:#111111 !important;font-family:{$font} !important;}
#body_content_inner table.td th{background-color:#FFF7ED;}
.address{border:1px solid #E5E7EB !important;border-radius:8px;color:#111111 !important;font-style:normal !important;padding:12px !important;}
#template_footer #credit,#credit,#credit p{color:#666666 !important;font-family:{$font} !important;font-size:13px !important;line-height:1.6 !important;text-align:center !important;}
#credit a{color:#C2410C !important;}
@media screen and (max-width:600px){
#body_content_inner,#body_content_inner p,#body_content_inner table.td th,#body_content_inner table.td td,.address{font-size:15px !important;}
}
@media (prefers-color-scheme:dark){
body,#outer_wrapper{background-color:#111111 !important;}
#credit,#credit p{color:#D1D5DB !important;}
#credit a{color:#FDBA74 !important;}
}";
	},
	30
);

/** Contact form mail for the Foundation. Values are the visitor's own text, so they are escaped. */
function daan_email_contact_html( $first_name, $last_name, $email, $subject, $message ) {
	$p = '<p style="font-family:Arial,Helvetica,sans-serif;font-size:15px;line-height:1.6;color:#111111;margin:0 0 12px;">';
	return '<h1 style="font-family:Arial,Helvetica,sans-serif;font-size:22px;line-height:1.3;color:#111111;margin:0 0 14px;">New message from the website</h1>'
		. $p . '<b>Name:</b> ' . esc_html( trim( $first_name . ' ' . $last_name ) ) . '<br><b>Email:</b> ' . esc_html( $email ) . '<br><b>Subject:</b> ' . esc_html( $subject ) . '</p>'
		. $p . '<b>Message:</b><br>' . nl2br( esc_html( $message ) ) . '</p>'
		. '<p style="font-family:Arial,Helvetica,sans-serif;font-size:13px;line-height:1.6;color:#666666;margin:0;">Submitted via Daan Foundation website contact form.</p>';
}

function daan_email_newsletter_html() {
	$p = '<p style="font-family:Arial,Helvetica,sans-serif;font-size:15px;line-height:1.6;color:#111111;margin:0 0 14px;">';
	return '<h1 style="font-family:Arial,Helvetica,sans-serif;font-size:22px;line-height:1.3;color:#111111;margin:0 0 14px;">Welcome</h1>'
		. $p . 'Thank you for subscribing to the Daan Foundation newsletter!</p>'
		. $p . 'You will now receive updates on our campaigns, impact stories, and Islamic giving opportunities.</p>'
		. $p . 'Warm regards,<br>Daan Foundation Team</p>';
}

// The WooCommerce mobile-app advert in admin e-mails.
add_filter(
	'wc_get_template',
	function ( $template, $name ) {
		return 'emails/email-mobile-messaging.php' === $name ? __DIR__ . '/email-empty.php' : $template;
	},
	10,
	2
);
