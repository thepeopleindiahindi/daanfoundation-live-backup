<?php
/**
 * Daan Foundation — Security, Hardening & Backup
 *
 * Included from functions.php. Handles XML-RPC, login limiting,
 * version hiding, user enumeration, security headers, admin
 * redirection, reCAPTCHA constants, and file editing lock.
 *
 * @package Daan\Security
 */

// ── 1. Disable XML-RPC ────────────────────────────────────────────────────
add_filter('xmlrpc_enabled', '__return_false');

// ── 2. Disable file editing in dashboard (belt-and-suspenders) ────────────
if (!defined('DISALLOW_FILE_EDIT')) {
    define('DISALLOW_FILE_EDIT', true);
}

// ── 3. Limit login attempts ───────────────────────────────────────────────
const LOGIN_OPTION_PREFIX = 'daan_login_attempts_';

function daan_get_login_key(string $ip = ''): string {
    if (!$ip) {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    }
    return LOGIN_OPTION_PREFIX . md5($ip);
}

function daan_get_login_attempts(string $ip = ''): array {
    $key   = daan_get_login_key($ip);
    $entry = get_option($key, []);
    if (!is_array($entry)) {
        $entry = [];
    }
    return $entry;
}

function daan_is_login_locked(string $ip = ''): bool {
    $entry = daan_get_login_attempts($ip);
    if (empty($entry)) {
        return false;
    }

    $count   = (int) ($entry['count'] ?? 0);
    $blocked = (int) ($entry['blocked_until'] ?? 0);

    if ($blocked > time()) {
        return true; // still locked
    }

    // Lockout period expired — reset so next attempt starts fresh
    if ($blocked > 0 && $blocked <= time()) {
        delete_option(daan_get_login_key($ip));
        return false;
    }

    // No active lockout but count exceeds thresholds — apply lockout
    if ($count >= 10) {
        $entry['blocked_until'] = time() + HOUR_IN_SECONDS;
        $entry['count']         = 0;
        update_option(daan_get_login_key($ip), $entry, false);
        return true;
    }

    if ($count >= 3) {
        $entry['blocked_until'] = time() + 15 * MINUTE_IN_SECONDS;
        $entry['count']         = 0;
        update_option(daan_get_login_key($ip), $entry, false);
        return true;
    }

    return false;
}

add_action('wp_login_failed', function (string $username) {
    $ip    = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $key   = daan_get_login_key($ip);
    $entry = daan_get_login_attempts($ip);

    $entry['count']       = (int) ($entry['count'] ?? 0) + 1;
    $entry['last_attempt'] = time();

    // Remove any expired lockout so thresholds re-evaluate
    if (!empty($entry['blocked_until']) && $entry['blocked_until'] <= time()) {
        unset($entry['blocked_until']);
    }

    update_option($key, $entry, false);
});

add_filter('wp_authenticate', function ($user, $username) {
    if (daan_is_login_locked()) {
        return new WP_Error(
            'login_locked',
            __('Too many failed login attempts. Please try again later.', 'daan')
        );
    }
    return $user;
}, 10, 2);

add_action('wp_login', function (string $username) {
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    delete_option(daan_get_login_key($ip));
});

// ── 4. Remove WordPress version ───────────────────────────────────────────
remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_empty_string');

add_filter('style_loader_src', function ($src) {
    if ($src) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
});

add_filter('script_loader_src', function ($src) {
    if ($src) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
});

// ── 5. Disable user enumeration ───────────────────────────────────────────
add_filter('rest_user_query', function (array $args, WP_Query $query): array {
    if (!current_user_can('list_users')) {
        $args['post__in'] = [0]; // return no users
    }
    return $args;
}, 10, 2);

add_action('template_redirect', function () {
    if (is_author()) {
        wp_safe_redirect(home_url(), 301);
        exit;
    }
});

// ── 6. Security headers ───────────────────────────────────────────────────
add_filter('wp_headers', function (array $headers): array {
    $headers['X-Content-Type-Options'] = 'nosniff';
    $headers['X-XSS-Protection']       = '1; mode=block';
    $headers['Referrer-Policy']        = 'strict-origin-when-cross-origin';

    // Allow UPI/callback URLs to be framed (e.g., payment gateways)
    $request_uri = $_SERVER['REQUEST_URI'] ?? '';
    $allow_frame = (
        strpos($request_uri, '/upi-callback') !== false ||
        strpos($request_uri, '/payment-callback') !== false
    );

    if (!$allow_frame) {
        $headers['X-Frame-Options'] = 'SAMEORIGIN';
    }

    return $headers;
});

// ── 7. Hide wp-admin from non-admins ──────────────────────────────────────
add_action('admin_init', function () {
    if (
        is_admin() &&
        !wp_doing_ajax() &&
        !current_user_can('administrator') &&
        !current_user_can('manage_options')
    ) {
        wp_safe_redirect(home_url());
        exit;
    }
});

// ── 8. Directory listing reminder ─────────────────────────────────────────
// Ensure `Options -Indexes` is set in the site's .htaccess or Apache config
// to prevent directory listing on wp-content/uploads/, wp-includes/, etc.

// ── 9. reCAPTCHA constants from environment ───────────────────────────────
if (!defined('RECAPTCHA_SITE_KEY')) {
    $key = getenv('RECAPTCHA_SITE_KEY') ?: ($_ENV['RECAPTCHA_SITE_KEY'] ?? '');
    if ($key) {
        define('RECAPTCHA_SITE_KEY', $key);
    }
}
if (!defined('RECAPTCHA_SECRET_KEY')) {
    $key = getenv('RECAPTCHA_SECRET_KEY') ?: ($_ENV['RECAPTCHA_SECRET_KEY'] ?? '');
    if ($key) {
        define('RECAPTCHA_SECRET_KEY', $key);
    }
}
