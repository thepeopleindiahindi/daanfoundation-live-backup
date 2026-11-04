<?php
/**
 * Floating WhatsApp button on every page. It fades out only while it would cover the UPI payment box, Copy button or the final checkout/donation button.
 * Rollback: remove the require in functions.php.
 *
 * @package Daan
 */

defined( 'ABSPATH' ) || exit;

const DAAN_WHATSAPP_NUMBER = '919528206525';
const DAAN_WHATSAPP_TEXT   = 'Hello, I have a question about donating to Daan Foundation.';

function daan_whatsapp_url() {
	return 'https://wa.me/' . DAAN_WHATSAPP_NUMBER . '?text=' . rawurlencode( DAAN_WHATSAPP_TEXT );
}

add_action(
	'wp_footer',
	function () {
		?>
		<a id="daan-wa" href="<?php echo esc_url( daan_whatsapp_url() ); ?>" target="_blank" rel="noopener" aria-label="Chat with Daan Foundation on WhatsApp"><svg width="28" height="28" viewBox="0 0 24 24" fill="#fff" aria-hidden="true"><path d="M17.5 14.4c-.3-.1-1.7-.8-2-.9-.3-.1-.5-.1-.7.1-.2.3-.8.9-.9 1.1-.2.2-.3.2-.6.1-.3-.1-1.2-.5-2.3-1.4-.9-.8-1.4-1.7-1.6-2-.2-.3 0-.5.1-.6l.4-.5c.1-.2.2-.3.3-.5.1-.2 0-.4 0-.5-.1-.1-.7-1.6-.9-2.2-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-.3.3-1 1-1 2.4s1 2.8 1.2 3c.1.2 2 3.1 4.9 4.3.7.3 1.2.5 1.6.6.7.2 1.3.2 1.8.1.6-.1 1.7-.7 1.9-1.4.2-.7.2-1.2.2-1.4-.1-.1-.3-.2-.6-.3zM12 2a10 10 0 0 0-8.6 15l-1.3 4.9 5-1.3A10 10 0 1 0 12 2z"/></svg></a>
		<style>#daan-wa{position:fixed;right:16px;bottom:16px;z-index:9990;width:52px;height:52px;border-radius:50%;background:#128C7E;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(0,0,0,.25);transition:opacity .15s}#daan-wa:focus-visible{outline:3px solid #111;outline-offset:2px}#daan-wa.is-hidden{opacity:0;pointer-events:none}@media (max-width:767px){#daan-wa{right:12px;bottom:12px;width:48px;height:48px}.site-footer{padding-bottom:72px}}@media print{#daan-wa{display:none}}</style>
		<script>(function(){var w=document.getElementById('daan-wa');if(!w){return;}var s='.upq-box,.upq-thanks,.upi-card,.upq-copy,#place_order,.checkout-button,#confirm-btn';var t;function c(){var a=w.getBoundingClientRect(),h=false,e=document.querySelectorAll(s);for(var i=0;i<e.length;i++){var b=e[i].getBoundingClientRect();if(b.width&&b.height&&b.left<a.right+4&&b.right>a.left-4&&b.top<a.bottom+4&&b.bottom>a.top-4){h=true;break;}}w.classList.toggle('is-hidden',h);}function q(){clearTimeout(t);t=setTimeout(c,60);}addEventListener('scroll',q,{passive:true});addEventListener('resize',q);document.addEventListener('click',q);if(window.jQuery){jQuery(document.body).on('updated_checkout',q);}c();})();</script>
		<?php
	},
	50
);
