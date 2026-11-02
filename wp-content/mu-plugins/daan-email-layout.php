<?php
/**
 * Plugin Name: Daan E-mail Layout
 * Description: Wraps custom HTML e-mails (digest, 7-day warning, payment reported, action failed) in one mobile-friendly centred card. Full HTML documents (WooCommerce) and plain-text e-mails are left alone; text, subject and recipients are never changed. Safe to delete to roll back.
 */
defined( 'ABSPATH' ) || exit;

add_filter( 'wp_mail', function ( $args ) {
	$headers = is_array( $args['headers'] ) ? implode( "\n", $args['headers'] ) : (string) $args['headers'];
	$message = (string) $args['message'];
	if ( false === stripos( $headers, 'text/html' ) || false !== stripos( $message, '<html' ) ) {
		return $args;
	}
	$args['message'] = '<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">'
		. '<style>@media only screen and (max-width:480px){.container{width:100% !important;}a.upq-btn{display:block !important;margin:0 0 8px !important;text-align:center !important;box-sizing:border-box;}}</style></head>'
		. '<body style="margin:0;padding:0;background:#F8FAFC;">'
		. '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="width:100%;background:#F8FAFC;"><tr><td align="center" style="padding:0;">'
		. '<!--[if mso]><table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0"><tr><td><![endif]-->'
		. '<table role="presentation" class="container" width="100%" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;margin:0 auto;background:#ffffff;"><tr><td style="padding:20px 16px;font-family:Arial,Helvetica,sans-serif;word-break:break-word;">'
		. $message
		. '</td></tr></table><!--[if mso]></td></tr></table><![endif]--></td></tr></table></body></html>';
	return $args;
} );
