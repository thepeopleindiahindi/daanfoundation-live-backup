<?php
/**
 * WooCommerce e-mails: full width on phones, centred 600 px on desktop. Layout only; no text changes.
 * Works with woocommerce/emails/email-header.php + email-footer.php. Rollback: remove the require in functions.php.
 *
 * @package Daan
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'woocommerce_email_styles',
	function ( $css ) {
		return $css . '
#wrapper{padding:16px 0 !important;width:100%;max-width:600px;margin:0 auto;box-sizing:border-box;}
#template_container,#template_header,#template_body,#template_footer{width:100% !important;}
#header_wrapper{padding:20px 16px !important;}
#body_content table td{padding:20px 16px;}
#body_content table td td{padding:10px 8px;}
#body_content_inner{word-break:break-word;overflow-wrap:anywhere;}
#body_content_inner table{width:100% !important;}
#body_content_inner img{max-width:100%;height:auto;}
@media only screen and (max-width:480px){
.container{width:100% !important;}
#header_wrapper{padding:16px !important;}
#header_wrapper h1{font-size:22px !important;line-height:1.3 !important;}
a.upq-btn{display:block !important;margin:0 0 8px !important;text-align:center !important;box-sizing:border-box;}
}';
	}
);
