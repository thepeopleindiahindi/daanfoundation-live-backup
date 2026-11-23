<?php
/**
 * Donation product pages + count stepper (owner, 2026-11-23).
 *
 * - Theme declares WooCommerce support so products use woocommerce.php
 *   (donation layout) instead of the blog template single.php.
 * - Product summary: no repeated title, no "Category:" line, no tabs;
 *   the description is printed as a plain section.
 * - Shared stepper [ − ] [n] [ + ] + live "Total: ₹X" (window.daanStepper),
 *   used by the widgets (theme.js), /donate/ (page-donate.php) and the
 *   fixed-price product pages (quantity input).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_setup_theme', function () {
	add_theme_support( 'woocommerce' );
} );

/* Product summary pieces. */
add_action( 'wp', function () {
	if ( ! function_exists( 'is_product' ) || ! is_product() ) {
		return;
	}
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
	add_action( 'woocommerce_after_single_product_summary', 'daan_product_description_section', 10 );
} );

function daan_product_description_section() {
	global $product;
	if ( ! $product ) {
		return;
	}
	$desc = $product->get_description();
	if ( '' === trim( wp_strip_all_tags( $desc ) ) ) {
		return;
	}
	echo '<section class="daan-product-desc"><h2>About this donation</h2>';
	echo apply_filters( 'the_content', $desc ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo '</section>';
}

/** Cause pre-selected in the sidebar widget for a product ('' = first cause). */
function daan_product_cause( $id ) {
	$slug = get_post_field( 'post_name', $id );
	$map  = array(
		'ramadan-iftar'             => 'Ramadan Iftar',
		'ration-kit-donation'       => 'Ration Kit',
		'ration-kit-interest-money' => 'Ration Kit (Interest Money)',
		'fitrana-ration-kit'        => 'Fitrana Ration Kit',
		'community-kitchen'         => 'Community Kitchen',
		'zakat'                     => 'Zakat',
		'sadaqah'                   => 'Sadaqah',
		'fidyah-kaffarah'           => 'Fidyah & Kaffarah',
		'where-most-needed'         => 'Where Most Needed',
	);
	return $map[ $slug ] ?? '';
}

/** "Learn more" links under the sidebar widget (current pages only). */
function daan_product_links( $id ) {
	$slug = get_post_field( 'post_name', $id );
	$kits = array( '/ration-kit-distribution-india/' => 'Ration Kit Donation for Poor Families' );
	$map  = array(
		'ramadan-iftar'             => array( '/ramadan/' => 'Donate Iftar This Ramadan' ),
		'ration-kit-donation'       => $kits,
		'ration-kit-interest-money' => $kits + array( '/bank-interest/' => 'Donate Bank Interest as Ration Kits' ),
		'fitrana-ration-kit'        => $kits + array( '/zakat-al-fitr/' => 'Fitrana (Zakat al-Fitr)' ),
		'community-kitchen'         => array( '/community-kitchen/' => 'Our Community Kitchen' ),
		'zakat'                     => array( '/zakat/' => 'Zakat', '/zakat-calculator/' => 'Zakat Calculator' ),
		'sadaqah'                   => array( '/sadaqah/' => 'Sadaqah' ),
		'sadaqah-jariyah'           => array( '/sadaqah-jariyah/' => 'Sadaqah Jariyah' ),
		'fidyah-kaffarah'           => array( '/fidya/' => 'Fidyah', '/kaffarah/' => 'Kaffarah' ),
	);
	return $map[ $slug ] ?? array( '/ramadan/' => 'Donate Iftar This Ramadan', '/ration-kit-distribution-india/' => 'Ration Kit Donation for Poor Families' );
}

/* Stepper CSS + JS (in <head>, so the widget, /donate/ and products can all use it). */
add_action( 'wp_head', function () {
	?>
<style id="daan-stepper-css">
.daan-stepper{margin:0 0 16px}
.daan-stepper-label{margin:0 0 8px;font-size:.9375rem;font-weight:700;color:#111827}
.daan-stepper-note{font-weight:500;color:#64748B;font-size:.875rem}
.daan-stepper-row{display:flex;align-items:center;gap:8px;max-width:100%}
.daan-stepper-btn{flex:0 0 48px;width:48px;height:48px;border-radius:12px;border:2px solid #E2E8F0;background:#fff;color:#C2410C;font-size:1.5rem;font-weight:700;line-height:1;cursor:pointer;display:flex;align-items:center;justify-content:center;padding:0}
.daan-stepper-btn:hover:not(:disabled){border-color:#F97316;background:#FFF7ED}
.daan-stepper-btn:disabled{opacity:.4;cursor:not-allowed}
.daan-stepper-input{width:96px!important;min-width:0;height:48px;text-align:center;border:2px solid #E2E8F0!important;border-radius:12px!important;font-size:1.125rem!important;font-weight:700;color:#111;padding:0 4px!important;margin:0!important;-moz-appearance:textfield;appearance:textfield}
.daan-stepper-input::-webkit-outer-spin-button,.daan-stepper-input::-webkit-inner-spin-button{-webkit-appearance:none;margin:0}
.daan-stepper-total{margin:10px 0 0;font-size:1rem;color:#334155}
.daan-stepper-total b{color:#C2410C;font-size:1.125rem}
.single-product div.product form.cart{display:block!important}
.single-product div.product form.cart .quantity.daan-hidden{display:none!important}
.woocommerce div.product form.cart .button,.woocommerce div.product form.cart button.single_add_to_cart_button,.woocommerce div.product form.cart .button.alt{background:#C2410C!important;color:#fff!important;border:none!important;border-radius:12px!important;padding:14px 32px!important;font-size:1.0625rem!important;font-weight:700!important;min-height:48px;float:none!important;margin:4px 0 0!important}
.woocommerce div.product form.cart .button:hover{background:#9A3412!important}
@media (max-width:639px){.woocommerce div.product form.cart .button{width:100%}}
.single-product div.product .summary{width:100%!important;float:none!important;margin-bottom:8px}
.single-product div.product .summary .price{color:#C2410C!important;font-size:1.5rem!important;font-weight:700}
.daan-product-desc{clear:both;padding:24px 0 8px;border-top:1px solid #E2E8F0;margin-top:16px;color:#475569;line-height:1.75}
.daan-product-desc h2{font-size:1.375rem;font-weight:700;color:#111827;margin:0 0 12px}
.daan-product-desc p{margin:0 0 12px}
</style>
<script id="daan-stepper-js">
(function(){
	function inr(n){return '₹'+(n||0).toLocaleString('en-IN');}
	/* o: {label, note, unit, max, value, onChange(n), input (reuse an existing <input>)} */
	window.daanStepper=function(o){
		var w=document.createElement('div');w.className='daan-stepper';
		var lab=document.createElement('p');lab.className='daan-stepper-label';lab.textContent=o.label;
		if(o.note){var nt=document.createElement('span');nt.className='daan-stepper-note';nt.textContent=' ('+o.note+')';lab.appendChild(nt);}
		var row=document.createElement('div');row.className='daan-stepper-row';
		function mk(t,a){var b=document.createElement('button');b.type='button';b.className='daan-stepper-btn';b.textContent=t;b.setAttribute('aria-label',a);return b;}
		var minus=mk('−','Decrease'),plus=mk('+','Increase');
		var inp=o.input||document.createElement('input');
		inp.type='number';inp.min=1;inp.max=o.max;inp.step=1;inp.setAttribute('inputmode','numeric');inp.classList.add('daan-stepper-input');inp.setAttribute('aria-label',o.label);
		inp.value=o.value||parseInt(inp.value,10)||1;
		var tot=document.createElement('p');tot.className='daan-stepper-total';tot.setAttribute('aria-live','polite');
		function val(){var n=parseInt(inp.value,10);return isNaN(n)?0:n;}
		function upd(){var v=val();if(v>o.max){v=o.max;inp.value=v;}tot.innerHTML='Total: <b>'+inr(v>0?v*o.unit:0)+'</b>';minus.disabled=v<=1;plus.disabled=v>=o.max;if(o.onChange)o.onChange(v);}
		minus.onclick=function(){inp.value=Math.max(1,(val()||1)-1);upd();};
		plus.onclick=function(){inp.value=Math.min(o.max,(val()||0)+1);upd();};
		inp.addEventListener('input',upd);
		inp.addEventListener('blur',function(){if(val()<1){inp.value=1;upd();}});
		row.appendChild(minus);row.appendChild(inp);row.appendChild(plus);
		w.appendChild(lab);w.appendChild(row);w.appendChild(tot);
		w.setValue=function(n){inp.value=n;upd();};w.input=inp;
		upd();return w;
	};
	/* Label used everywhere for a fixed-price cause. */
	window.daanQtyLabel=function(cause,f){return 'Number of '+(cause==='Ramadan Iftar'?'iftar kits':f.many);};
	/* Fixed-price product pages: the quantity box becomes the stepper. */
	document.addEventListener('DOMContentLoaded',function(){
		var lab=document.querySelector('.single-product form.cart .daan-qty-label, .single-product .daan-qty-label');
		var form=document.querySelector('.single-product form.cart');
		if(!lab||!form)return;
		var q=form.querySelector('input.qty');if(!q)return;
		var wrap=q.closest('.quantity');
		var unit=parseInt(lab.getAttribute('data-unit'),10)||0,max=parseInt(lab.getAttribute('data-max'),10)||1;
		var text=lab.textContent.replace(/\s*\(.*\)\s*$/,'');
		var st=window.daanStepper({label:text,note:inr(unit)+' per '+(lab.getAttribute('data-one')||'kit'),unit:unit,max:max,value:parseInt(q.value,10)||1,input:q});
		var btn=form.querySelector('button[type=submit], .single_add_to_cart_button');
		if(wrap){wrap.classList.add('daan-hidden');}
		lab.style.display='none';
		form.insertBefore(st,btn||form.firstChild);
	});
})();
</script>
	<?php
}, 5 );
