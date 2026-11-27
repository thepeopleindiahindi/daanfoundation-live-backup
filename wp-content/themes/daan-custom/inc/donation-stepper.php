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

/* [daan_meal_price] → "₹60" from the "Community Kitchen meal price" setting (used in DB texts, D-037). */
add_shortcode( 'daan_meal_price', function () {
	return '₹' . number_format_i18n( function_exists( 'daan_meal_price' ) ? daan_meal_price() : 60 );
} );

/* [daan_more_box] (owner, 2026-11-23, D-038): under Fidyah/Kaffarah information pages. Never says that an
   Iftar kit or a Ration Kit is Fidyah or Kaffarah; both are given as Sadaqah. Prices from the settings. */
add_shortcode( 'daan_more_box', function () {
	$iftar = '₹' . number_format_i18n( function_exists( 'daan_iftar_kit_price' ) ? daan_iftar_kit_price() : 91 );
	$kit   = '₹' . number_format_i18n( function_exists( 'daan_kit_price' ) ? daan_kit_price() : 1536 );
	return '<div class="daan-more-box" style="border:2px solid #FDBA74;background:#FFF7ED;border-radius:16px;padding:20px;margin:24px 0;">'
		. '<p style="margin:0 0 6px;font-weight:700;font-size:1.125rem;color:#111827;">Want to do more?</p>'
		. '<p style="margin:0 0 14px;color:#334155;">Sponsor an Iftar kit (' . esc_html( $iftar ) . ') or a Ration Kit (' . esc_html( $kit ) . ') as Sadaqah. These are general charity, separate from Fidyah and Kaffarah.</p>'
		. '<p style="margin:0;display:flex;flex-wrap:wrap;gap:10px;">'
		. '<a href="' . esc_url( home_url( '/product/ramadan-iftar/' ) ) . '" style="display:inline-flex;align-items:center;min-height:44px;padding:10px 20px;border-radius:12px;background:#C2410C;color:#fff;font-weight:700;text-decoration:none;">Sponsor an Iftar Kit (' . esc_html( $iftar ) . ')</a>'
		. '<a href="' . esc_url( home_url( '/product/ration-kit-donation/' ) ) . '" style="display:inline-flex;align-items:center;min-height:44px;padding:10px 20px;border-radius:12px;border:2px solid #C2410C;color:#C2410C;font-weight:700;text-decoration:none;">Give a Ration Kit (' . esc_html( $kit ) . ')</a>'
		. '</p></div>';
} );
add_filter( 'the_content', function ( $content ) {
	if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}
	$slugs = array( 'kaffara-for-broken-oath-qasam', 'kaffara-missed-ramadan-fast', 'how-to-calculate-fidyah-for-sick-person-in-ramadan-2026-fidyah-payment-kaffara-feeding-zakat-donation-sadqah-charity-guide-india' );
	return in_array( get_post_field( 'post_name', get_the_ID() ), $slugs, true ) ? $content . do_shortcode( '[daan_more_box]' ) : $content;
}, 30 );

/* [daan_fk_update] (owner, 2026-11-23, D-039): public update, text verbatim from the owner. Shown at the top of
   every Fidyah/Kaffarah page; the rest of each page stays below it. Buttons are Sadaqah only. */
add_shortcode( 'daan_fk_update', function () {
	$meal  = '₹' . number_format_i18n( function_exists( 'daan_meal_price' ) ? daan_meal_price() : 60 );
	$iftar = '₹' . number_format_i18n( function_exists( 'daan_iftar_kit_price' ) ? daan_iftar_kit_price() : 91 );
	$p     = '<p style="margin:0 0 12px;line-height:1.7;color:#1F2937;">';
	return '<section class="daan-fk-update" aria-labelledby="daan-fk-update-h" style="border:2px solid #F97316;border-left-width:6px;background:#FFF7ED;border-radius:16px;padding:20px 20px 16px;margin:0 0 28px;">'
		. '<h2 id="daan-fk-update-h" style="margin:0 0 12px;font-size:1.375rem;line-height:1.3;color:#9A3412;">An Important Update on Fidyah and Kaffarah</h2>'
		. $p . 'From the first day, Daan Foundation&#8217;s Community Kitchen has served food at one time of the day. Until recently, to the best of our knowledge, we understood that feeding a person in need one meal fulfils Kaffarah, and that giving one iftar fulfils Fidyah.</p>'
		. $p . 'As we sought more guidance from our scholars, our knowledge has grown, and we have learned that:</p>'
		. '<ul style="margin:0 0 12px 1.25rem;padding:0;line-height:1.7;color:#1F2937;list-style:disc;">'
		. '<li>Kaffarah for a broken oath requires feeding ten people in need two full meals at two separate times of the day (such as morning and evening).</li>'
		. '<li>One fast&#8217;s Fidyah equals Sadaqat al-Fitr (about 1.75 kg of wheat or its value), not one iftar.</li></ul>'
		. $p . 'We have shared this openly so that you know exactly what was done until now. Whatever we did, we did with sincere intention and to the best of our knowledge. May Allah forgive us, and may Allah accept your Fidyah and Kaffarah.</p>'
		. $p . '<strong>Because our kitchen serves food at only one time of the day and we are not able to serve at two separate times, we are no longer accepting Fidyah or Kaffarah donations.</strong> We will share an update if we are able to make a proper arrangement in the future.</p>'
		. $p . 'Our Community Kitchen continues to serve a meal to people in need every day, and you can still support it as Sadaqah. For guidance about your own Fidyah or Kaffarah, you may consult a trusted scholar or contact us on WhatsApp <a href="https://wa.me/919528206525" target="_blank" rel="noopener" style="color:#9A3412;font-weight:700;text-decoration:underline;">+91 95282 06525</a>.</p>'
		. '<p style="margin:16px 0 0;display:flex;flex-wrap:wrap;gap:10px;">'
		. '<a href="' . esc_url( home_url( '/product/community-kitchen/' ) ) . '" style="display:inline-flex;align-items:center;justify-content:center;min-height:44px;padding:10px 20px;border-radius:12px;background:#C2410C;color:#fff;font-weight:700;text-decoration:none;">Support our Community Kitchen as Sadaqah (' . esc_html( $meal ) . ' per meal)</a>'
		. '<a href="' . esc_url( home_url( '/product/ramadan-iftar/' ) ) . '" style="display:inline-flex;align-items:center;justify-content:center;min-height:44px;padding:10px 20px;border-radius:12px;border:2px solid #C2410C;color:#C2410C;font-weight:700;text-decoration:none;background:#fff;">Sponsor an Iftar kit (' . esc_html( $iftar ) . ')</a>'
		. '</p></section>';
} );
function daan_fk_update_slugs() {
	return array( 'kaffara-for-broken-oath-qasam', 'kaffara-missed-ramadan-fast', 'where-does-your-iftar-donation-go', 'how-to-calculate-fidyah-for-sick-person-in-ramadan-2026-fidyah-payment-kaffara-feeding-zakat-donation-sadqah-charity-guide-india', 'looking-for-a-reliable-islamic-charity-ngo-learn-how-to-donate-zakat-online-pay-kaffara-and-support-ramadan-iftaar-meals-in-india-daan-foundation-amroha-helps-you-feed-the-poor-through-sadqah-and' );
}
add_filter( 'the_content', function ( $content ) {
	if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}
	return in_array( get_post_field( 'post_name', get_the_ID() ), daan_fk_update_slugs(), true ) ? do_shortcode( '[daan_fk_update]' ) . $content : $content;
}, 20 );
add_action( 'woocommerce_before_single_product', function () {
	if ( 'fidyah-kaffarah' === get_post_field( 'post_name', get_queried_object_id() ) ) {
		echo do_shortcode( '[daan_fk_update]' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
} );


/* ₹55 post (6544): the H1 shows the current meal price from the setting, like the SEO title (owner, 2026-11-23).
   post_title and slug are unchanged. */
add_filter( 'the_title', function ( $title, $id = 0 ) {
	if ( 6544 === (int) $id && ! is_admin() && function_exists( 'daan_meal_price' ) ) {
		$title = str_replace( '₹55', '₹' . number_format_i18n( daan_meal_price() ), $title );
	}
	return $title;
}, 10, 2 );

/* Ration kit list (owner, 2026-11-23): one component for the kit product, the ration hub and the Fitrana/Interest
   kit pages. Items, their count and the weight come from the "Ration kit items" setting (daan_kit_items_text()). */
function daan_kit_groups() {
	$groups = array(
		'grains'  => array( 'Grains', '🌾', array( 'aata', 'atta', 'chawal', 'rice' ) ),
		'pulses'  => array( 'Pulses', '🫘', array( 'dal', 'chana', 'rajma' ) ),
		'veg'     => array( 'Vegetables', '🥔', array( 'aaloo', 'aloo', 'potato', 'pyaaz', 'onion' ) ),
		'oil'     => array( 'Oil, Sugar & Salt', '🫙', array( 'oil', 'cheeni', 'sugar', 'namak', 'salt' ) ),
		'spices'  => array( 'Spices', '🌶️', array( 'haldi', 'mirch', 'dhaniya', 'masala', 'jeera' ) ),
		'daily'   => array( 'Daily Essentials', '🧺', array( 'patti', 'chai', 'tea', 'surf', 'soap', 'sabun' ) ),
	);
	$out = array(); foreach ( $groups as $k => $g ) { $out[ $k ] = array( 'label' => $g[0], 'icon' => $g[1], 'items' => array() ); }
	$lines = function_exists( 'daan_kit_items_text' ) ? array_filter( array_map( 'trim', explode( "\n", daan_kit_items_text() ) ) ) : array();
	$kg = 0.0; $unknown = false; $count = 0;
	foreach ( $lines as $line ) {
		$parts = preg_split( '/\s+[—–-]\s+/u', $line, 2 );
		$name  = trim( $parts[0] ); $qty = isset( $parts[1] ) ? trim( $parts[1] ) : '';
		if ( 'patti' === strtolower( $name ) ) { $name = 'Chai Patti'; }
		$count++;
		if ( preg_match( '/([\d.]+)\s*(kg|g)\b/i', $qty, $m ) ) { $kg += ( 'kg' === strtolower( $m[2] ) ) ? (float) $m[1] : (float) $m[1] / 1000; } else { $unknown = true; }
		$key = 'daily';
		foreach ( $groups as $k => $g ) { foreach ( $g[2] as $w ) { if ( false !== stripos( $name, $w ) ) { $key = $k; break 2; } } }
		$out[ $key ]['items'][] = array( $name, $qty );
	}
	$weight = $unknown ? ( (int) ceil( $kg ) ) . '+ kg' : rtrim( rtrim( number_format( $kg, 1 ), '0' ), '.' ) . ' kg';
	return array( 'groups' => array_filter( $out, function ( $g ) { return ! empty( $g['items'] ); } ), 'count' => $count, 'weight' => $weight );
}
function daan_kit_list_html() {
	$d     = daan_kit_groups();
	$price = '₹' . number_format_i18n( function_exists( 'daan_kit_price' ) ? daan_kit_price() : 1536 );
	$h  = '<div class="daan-kit-list">';
	$h .= '<p class="daan-kit-hl"><span>' . (int) $d['count'] . ' essential items</span><span aria-hidden="true">·</span><span>' . esc_html( $d['weight'] ) . '</span><span aria-hidden="true">·</span><span>' . esc_html( $price ) . '</span></p>';
	$h .= '<div class="daan-kit-grid">';
	foreach ( $d['groups'] as $g ) {
		$h .= '<div class="daan-kit-card"><p class="daan-kit-card-h"><span aria-hidden="true">' . $g['icon'] . '</span> ' . esc_html( $g['label'] ) . '</p><ul>';
		foreach ( $g['items'] as $it ) {
			$h .= '<li><span>' . esc_html( $it[0] ) . '</span><span class="daan-kit-qty">' . esc_html( $it[1] ) . '</span></li>';
		}
		$h .= '</ul></div>';
	}
	$h .= '</div><p class="daan-kit-note">Covers a family\'s basic kitchen needs: grains, pulses, oil, spices and daily essentials.</p></div>';
	return $h;
}
add_action( 'init', function () {
	remove_shortcode( 'daan_kit_items' );
	add_shortcode( 'daan_kit_items', 'daan_kit_list_html' );
}, 20 );
add_action( 'wp_head', function () {
	echo '<style id="daan-kit-list-css">.daan-kit-list{margin:12px 0 20px}.daan-kit-hl{display:flex;flex-wrap:wrap;gap:6px 10px;align-items:center;margin:0 0 14px;padding:12px 16px;border-radius:14px;background:#FFF7ED;border:2px solid #FDBA74;color:#9A3412;font-weight:800;font-size:1.125rem}.daan-kit-grid{display:grid;grid-template-columns:1fr;gap:12px}@media(min-width:640px){.daan-kit-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}@media(min-width:1100px){.daan-kit-grid{grid-template-columns:repeat(3,minmax(0,1fr))}}.daan-kit-card{background:#fff;border:1px solid #E2E8F0;border-radius:14px;padding:14px 16px}.daan-kit-card-h{margin:0 0 8px;font-weight:700;color:#111827}.daan-kit-card ul{list-style:none;margin:0;padding:0}.daan-kit-card li{display:flex;justify-content:space-between;gap:10px;padding:5px 0;border-top:1px solid #F1F5F9;font-size:.9375rem;color:#334155}.daan-kit-card li:first-child{border-top:0}.daan-kit-qty{color:#64748B;text-align:right;white-space:normal;max-width:55%}.daan-kit-note{margin:12px 0 0;color:#475569;font-size:.9375rem}</style>' . "\n";
}, 6 );

/* [daan_ration_about] (owner text, verbatim; D-040). On the Ration Kit product and the ration hub post. */
add_shortcode( 'daan_ration_about', function () {
	return '<section id="ration-kit-note" class="daan-ration-about" style="border:2px solid #F97316;border-left-width:6px;background:#FFF7ED;border-radius:14px;padding:16px 18px;margin:0 0 20px;scroll-margin-top:110px;">'
		. '<h2 style="margin:0 0 8px;font-size:1.25rem;color:#9A3412;">About this Ration Kit</h2>'
		. '<p style="margin:0 0 10px;color:#334155;line-height:1.7;">Daan Foundation receives your donation and delivers a complete ration kit to a family in need. Our kits are given to families based on need, and we do not keep Zakat and Sadaqah kits separately.</p>'
		. '<p style="margin:0;color:#334155;line-height:1.7;">Which head (Zakat, Sadaqah or any other) you give this under is a matter between you and Allah. Please consult a trusted Maulana or Mufti about whether it is suitable for your intention. Daan Foundation does not take responsibility for the head under which a donation is given; our responsibility is to deliver the kit to a family in need.</p>'
		. '</section>';
} );
add_action( 'woocommerce_single_product_summary', function () {
	if ( 'ration-kit-donation' === get_post_field( 'post_name', get_queried_object_id() ) ) {
		echo do_shortcode( '[daan_ration_about]' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}, 4 ); // top of the summary: under the heading, before the price and the stepper/Donate button
add_filter( 'the_content', function ( $content ) {
	if ( is_singular( 'post' ) && in_the_loop() && is_main_query() && 'ration-kit-distribution-india' === get_post_field( 'post_name', get_the_ID() ) ) {
		$content = do_shortcode( '[daan_ration_about]' ) . $content; // top of the hub, before its Donate button
	}
	return $content;
}, 25 );

/* Ration Kit appeal text (owner, 2026-11-23; verbatim, numbers from settings). */
function daan_ration_appeal() {
	$d     = function_exists( 'daan_kit_groups' ) ? daan_kit_groups() : array( 'count' => 18, 'weight' => '18+ kg' );
	$price = '₹' . number_format_i18n( function_exists( 'daan_kit_price' ) ? daan_kit_price() : 1536 );
	return array(
		'title' => 'Ration Kits for Families in Need',
		'text'  => 'For many families in Amroha, putting food on the table every day is a struggle. One ration kit gives a family ' . (int) $d['count'] . ' essential items (' . $d['weight'] . '): grains, pulses, oil, spices and daily essentials, delivered by our team to a household in need.',
		'price' => $price . ' per kit',
		'url'   => '/product/ration-kit-donation/',
	);
}

/* srcset for /images/hero-p-*.webp (480/640/800, plus 1200 when that file exists; 2026-11-27). */
function daan_hero_srcset( $image ) {
	if ( ! preg_match( '#^(/images/hero-p-[a-z-]+)\.webp$#', $image, $m ) ) {
		return '';
	}
	$set = $m[1] . '-480.webp 480w, ' . $m[1] . '-640.webp 640w, ' . $image . ' 800w';
	if ( file_exists( ABSPATH . ltrim( $m[1], '/' ) . '-1200.webp' ) ) {
		$set .= ', ' . $m[1] . '-1200.webp 1200w';
	}
	return $set;
}
/* Ration kit photo (owner, 2026-11-27): Head Office Amroha, Ramadan 2026 distribution. */
function daan_ration_photo() {
	return array( 'src' => '/images/hero-p-ration-warehouse.webp', 'alt' => "Ration kits packed and ready for distribution at Daan Foundation's head office in Amroha" );
}

/* Product page hero: subtitle (prices from settings) + a real site photo (owner, 2026-11-23). */
function daan_product_hero( $id ) {
	$slug  = get_post_field( 'post_name', $id );
	$kit   = '₹' . number_format_i18n( function_exists( 'daan_kit_price' ) ? daan_kit_price() : 1536 );
	$iftar = '₹' . number_format_i18n( function_exists( 'daan_iftar_kit_price' ) ? daan_iftar_kit_price() : 91 );
	$meal  = '₹' . number_format_i18n( function_exists( 'daan_meal_price' ) ? daan_meal_price() : 60 );
	$items = function_exists( 'daan_kit_groups' ) ? (int) daan_kit_groups()['count'] : 18;
	$map   = array(
		'ration-kit-donation'       => array( $kit . ' per kit · ' . $items . ' essential items', '/images/hero-p-ration-warehouse.webp', "Ration kits packed and ready for distribution at Daan Foundation's head office in Amroha" ),
		'ramadan-iftar'             => array( $iftar . ' per kit · Iftar for fasting people in Amroha', '/images/hero-p-iftar-kit.webp', 'Iftar being served at Daan Foundation in Ramadan' ),
		'community-kitchen'         => array( $meal . ' per meal · 100–120 people fed every day', '/images/hero-p-community-kitchen.webp', 'Meals being served at Daan Foundation\'s Community Kitchen' ),
		'fitrana-ration-kit'        => array( $kit . ' per kit · Give your family\'s Fitrana as a ration kit', '/images/hero-p-fitrana-kit.webp', 'Ration delivered to a family by Daan Foundation' ),
		'ration-kit-interest-money' => array( $kit . ' per kit · Interest money goes only into ration kits', '/images/hero-p-interest-kit.webp', 'Packed ration kits ready for families' ),
	);
	$h = $map[ $slug ] ?? array( '', '/images/community-queue.jpg', '' );
	return array( 'subtitle' => $h[0], 'image' => $h[1], 'alt' => $h[2] );
}

/* Preload the product hero photo (LCP element on product pages; 2026-11-23). */
add_action( 'wp_head', function () {
	if ( ! function_exists( 'is_product' ) || ! is_product() || ! function_exists( 'daan_product_hero' ) ) {
		return;
	}
	$img = daan_product_hero( get_queried_object_id() )['image'];
	$set = daan_hero_srcset( $img );
	if ( $set ) {
		echo '<link rel="preload" as="image" type="image/webp" fetchpriority="high" imagesrcset="' . esc_attr( $set ) . '" imagesizes="(min-width: 768px) 448px, calc(100vw - 32px)">' . "\n";
	}
}, 2 );

