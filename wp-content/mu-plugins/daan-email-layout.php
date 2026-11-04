<?php
/**
 * Plugin Name: Daan E-mail Layout
 * Description: Wraps custom HTML e-mails (digest, 7-day warning, execution e-mail, alerts, contact, newsletter) in the site's look: logo, one card, footer. Full width on phones, 600 px on desktop.
 */
defined( 'ABSPATH' ) || exit;

/** The footer of every Daan e-mail. Registration line as printed on the receipt. */
function daan_email_footer_lines() {
	return 'Daan Foundation (Registered Trust) | Reg. No. 149/11-20/302 (Tehsil Amroha) | PAN: AAETD5465E<br>Contact: +91 95282 06525 | <a href="mailto:daanfoundationindia@gmail.com" style="color:#C2410C;">daanfoundationindia@gmail.com</a>';
}

add_filter( 'wp_mail', function ( $args ) {
	$headers = is_array( $args['headers'] ) ? implode( "\n", $args['headers'] ) : (string) $args['headers'];
	$message = (string) $args['message'];
	if ( false === stripos( $headers, 'text/html' ) || false !== stripos( $message, '<html' ) ) {
		return $args;
	}
	$logo = esc_url( (string) get_option( 'woocommerce_email_header_image' ) );
	$font = "'Open Sans',Arial,Helvetica,sans-serif";
	$args['message'] = '<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">'
		. '<style>@media only screen and (max-width:480px){.container{width:100% !important;}a.upq-btn{display:block !important;margin:0 0 8px !important;text-align:center !important;box-sizing:border-box;}}'
		. '@media (prefers-color-scheme:dark){.daan-page{background-color:#111111 !important;}.daan-foot,.daan-foot a{color:#D1D5DB !important;}}</style></head>'
		. '<body style="margin:0;padding:0;background:#F3F4F6;">'
		. '<table role="presentation" class="daan-page" width="100%" cellpadding="0" cellspacing="0" border="0" style="width:100%;background:#F3F4F6;"><tr><td align="center" style="padding:16px 0;">'
		. '<!--[if mso]><table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0"><tr><td><![endif]-->'
		. '<table role="presentation" class="container" width="100%" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;">'
		. ( $logo ? '<tr><td align="center" style="padding:8px 0 16px;"><a href="' . esc_url( home_url( '/' ) ) . '"><img src="' . $logo . '" alt="Daan Foundation" width="140" style="display:inline-block;width:140px;height:auto;box-sizing:content-box;background:#FFFFFF;padding:8px 12px;border-radius:8px;border:0;"></a></td></tr>' : '' )
		. '<tr><td style="background:#FFFFFF;border:1px solid #E5E7EB;border-top:4px solid #EA580C;border-radius:8px;padding:24px 16px;font-family:' . $font . ';font-size:15px;line-height:1.6;color:#111111;word-break:break-word;overflow-wrap:anywhere;">'
		. $message
		. '</td></tr>'
		. '<tr><td class="daan-foot" align="center" style="padding:16px;font-family:' . $font . ';font-size:13px;line-height:1.6;color:#666666;">' . daan_email_footer_lines() . '</td></tr>'
		. '</table><!--[if mso]></td></tr></table><![endif]--></td></tr></table></body></html>';
	return $args;
} );
