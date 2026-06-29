<?php
/**
 * SMTP Configuration for Daan Foundation
 *
 * Add these constants to wp-config.php (preferred) or paste via Code Snippets.
 * All credentials read from environment variables ONLY.
 *
 * @package DaanCustom
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// -------------------------------------------------------------------------
// Read SMTP settings from environment variables with wp-config.php fallback
// -------------------------------------------------------------------------

if ( ! defined( 'SMTP_HOST' ) ) {
    $host = getenv( 'SMTP_HOST' ) ?: ( $_ENV['SMTP_HOST'] ?? '' );
    if ( $host ) {
        define( 'SMTP_HOST', $host );
    }
}

if ( ! defined( 'SMTP_PORT' ) ) {
    $port = getenv( 'SMTP_PORT' ) ?: ( $_ENV['SMTP_PORT'] ?? '' );
    if ( $port ) {
        define( 'SMTP_PORT', intval( $port ) );
    }
}

if ( ! defined( 'SMTP_USER' ) ) {
    $user = getenv( 'SMTP_USER' ) ?: ( $_ENV['SMTP_USER'] ?? '' );
    if ( $user ) {
        define( 'SMTP_USER', $user );
    }
}

if ( ! defined( 'SMTP_PASS' ) ) {
    $pass = getenv( 'SMTP_PASS' ) ?: ( $_ENV['SMTP_PASS'] ?? '' );
    if ( $pass ) {
        define( 'SMTP_PASS', $pass );
    }
}

if ( ! defined( 'SMTP_SECURE' ) ) {
    $secure = getenv( 'SMTP_SECURE' ) ?: ( $_ENV['SMTP_SECURE'] ?? '' );
    if ( $secure ) {
        define( 'SMTP_SECURE', $secure );
    }
}

if ( ! defined( 'SMTP_FROM' ) ) {
    $from = getenv( 'SMTP_FROM' ) ?: ( $_ENV['SMTP_FROM'] ?? '' );
    if ( $from ) {
        define( 'SMTP_FROM', $from );
    }
}

if ( ! defined( 'SMTP_FROM_NAME' ) ) {
    $from_name = getenv( 'SMTP_FROM_NAME' ) ?: ( $_ENV['SMTP_FROM_NAME'] ?? '' );
    if ( $from_name ) {
        define( 'SMTP_FROM_NAME', $from_name );
    }
}

// -------------------------------------------------------------------------
// Configure PHPMailer instance
// -------------------------------------------------------------------------

add_action( 'phpmailer_init', 'daan_configure_smtp' );

function daan_configure_smtp( $phpmailer ) {
    if ( ! defined( 'SMTP_HOST' ) || ! SMTP_HOST ) {
        return;
    }

    $phpmailer->isSMTP();
    $phpmailer->Host       = SMTP_HOST;
    $phpmailer->SMTPAuth   = true;
    $phpmailer->Port       = defined( 'SMTP_PORT' ) ? SMTP_PORT : 587;
    $phpmailer->Username   = defined( 'SMTP_USER' ) ? SMTP_USER : '';
    $phpmailer->Password   = defined( 'SMTP_PASS' ) ? SMTP_PASS : '';
    $phpmailer->SMTPSecure = defined( 'SMTP_SECURE' ) ? SMTP_SECURE : 'tls';
    $phpmailer->From       = defined( 'SMTP_FROM' ) ? SMTP_FROM : 'noreply@daanfoundation.in';
    $phpmailer->FromName   = defined( 'SMTP_FROM_NAME' ) ? SMTP_FROM_NAME : 'Daan Foundation';
}
