<?php
/**
 * Plugin Name: Daan Security Hardening
 * Description: Adds what inc/security.php does not: one generic login error, no author in oEmbed, application passwords for admins only, no X-Powered-By, SameSite=Lax cookies. Lockout, REST users and author redirect stay in the theme (inc/security.php). Safe to delete to roll back.
 */
defined( 'ABSPATH' ) || exit;

/* 1. oEmbed responses do not expose the author. */
add_filter( 'oembed_response_data', function ( $data ) {
	unset( $data['author_name'], $data['author_url'] );
	return $data;
} );

/* 2. One generic message for a wrong user name or a wrong password.
 *    Only these error codes are replaced, so the lockout message from inc/security.php still shows. */
add_filter( 'authenticate', function ( $user ) {
	if ( is_wp_error( $user ) && array_intersect( $user->get_error_codes(), array( 'invalid_username', 'invalid_email', 'incorrect_password' ) ) ) {
		return new WP_Error( 'authentication_failed', '<strong>Error:</strong> Incorrect username or password.' );
	}
	return $user;
}, 99 );

/* 3. Only administrators may use application passwords. */
add_filter( 'wp_is_application_passwords_available_for_user', function ( $available, $user ) {
	return $available && user_can( $user, 'manage_options' );
}, 10, 2 );

/* 4. Do not advertise the PHP version. */
add_action( 'send_headers', function () {
	header_remove( 'X-Powered-By' );
} );

/* 5. Cookies without SameSite get SameSite=Lax. */
add_action( 'init', function () {
	if ( headers_sent() || wp_doing_ajax() ) {
		return;
	}
	header_register_callback( function () {
		$cookies = array_values( array_filter( headers_list(), function ( $l ) {
			return 0 === stripos( $l, 'Set-Cookie:' );
		} ) );
		if ( ! $cookies ) {
			return;
		}
		header_remove( 'Set-Cookie' );
		foreach ( $cookies as $c ) {
			header( false === stripos( $c, 'samesite' ) ? $c . '; SameSite=Lax' : $c, false );
		}
	} );
}, 1 );
