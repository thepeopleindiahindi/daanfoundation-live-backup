<?php
/**
 * Daan Foundation — performance fixes
 *
 * Frontend-only asset cleanup. Nothing here touches wp-admin, the
 * Customizer, or any plugin's own admin-side functionality — only what
 * gets enqueued on public-facing pages.
 *
 * @package Daan\Performance
 */

/**
 * Astra Sites' onboarding-wizard "template preview" script
 * (starter-templates-zip-preview-js, astra-sites plugin, served from
 * inc/lib/onboarding/assets/dist/template-preview/main.js) was loading on
 * every public page -- confirmed live via page source on the homepage and
 * several other pages. That script exists to preview starter templates
 * inside the wp-admin onboarding wizard; it has no reason to load for a
 * site visitor. Dequeued here rather than deactivating the whole plugin,
 * since Astra Sites may still be in active use for other admin-side
 * features (theme starter-template imports) -- this only strips the one
 * script from the frontend, wp-admin is completely unaffected.
 */
add_action( 'wp_enqueue_scripts', function () {
	if ( is_admin() ) {
		return;
	}
	wp_dequeue_script( 'starter-templates-zip-preview' );
	wp_deregister_script( 'starter-templates-zip-preview' );
}, PHP_INT_MAX );
