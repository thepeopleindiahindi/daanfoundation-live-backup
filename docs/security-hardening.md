# Daan Foundation — Security Hardening Guide

> **Phase 5** of the WordPress migration project.  
> Covers `wp-config.php` hardening, file permissions, SSL, plugin
> recommendations, maintenance routines, and reCAPTCHA setup.

---

## 1. wp-config.php Hardening

Add or verify the following constants in `wp-config.php` (above the
`/* That's all, stop editing! */` line):

```php
// ── Disable file editor in admin dashboard ──
define('DISALLOW_FILE_EDIT', true);

// ── Disable plugin/theme install/update from dashboard ──
define('DISALLOW_FILE_MODS', true);         // false if you need auto-updates

// ── Core updates ──
define('WP_AUTO_UPDATE_CORE', false);       // manual after staging test

// ── Force SSL for admin / login ──
define('FORCE_SSL_ADMIN', true);

// ── Limit post revisions ──
define('WP_POST_REVISIONS', 5);

// ── Empty trash interval (days) ──
define('EMPTY_TRASH_DAYS', 30);

// ── Autosave interval (seconds) ──
define('AUTOSAVE_INTERVAL', 120);

// ── WP memory limit ──
define('WP_MEMORY_LIMIT', '256M');
```

> **Note:** The theme's `inc/security.php` also sets `DISALLOW_FILE_EDIT`
> as a safety net if the constant is missing from `wp-config.php`.

---

## 2. File Permissions

Run these commands from the WordPress root after every deploy:

```bash
# Files — 644
find . -type f -exec chmod 644 {} \;

# Directories — 755
find . -type d -exec chmod 755 {} \;

# Sensitive files — stricter
chmod 640 wp-config.php       # or 600 if group doesn't need read
chmod 644 .htaccess
```

**Ownership** (adjust user/group to your setup):

```bash
chown -R www-data:www-data .
```

Typical production setup:

| Path                | Owner        | Permissions |
|---------------------|--------------|-------------|
| All files           | www-data     | 644         |
| All directories     | www-data     | 755         |
| `wp-config.php`     | www-data     | 640 / 600   |
| `.htaccess`         | www-data     | 644         |

---

## 3. SSL / HTTPS

Verify the SSL certificate is valid and not expiring soon.  
Force HTTPS via `.htaccess` (already included in the site root):

```apache
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}/$1 [R=301,L]
</IfModule>
```

Also confirm `FORCE_SSL_ADMIN` is set in `wp-config.php` (see §1).

---

## 4. Plugin Security Recommendations

| Plugin                        | Purpose                              |
|-------------------------------|--------------------------------------|
| **Wordfence Security**        | Firewall, malware scan, login guard  |
| **WPS Hide Login**            | Change `/wp-admin` to a custom slug  |
| **Sucuri Security**           | Monitoring, hardening, post-hack     |
| **Really Simple SSL**         | SSL setup helper (if needed)         |

After installing, disable any plugin that duplicates features already
handled by `inc/security.php` (login limiting, version hiding, etc.).

---

## 5. Regular Maintenance

| Frequency | Task                                              |
|-----------|---------------------------------------------------|
| **Daily** | Automated backup (see `scripts/backup.sh`)        |
| **Weekly**| Apply WordPress core + plugin updates*            |
| **Monthly**| Review user accounts; remove inactive / unused    |
| **Monthly**| Check failed login logs (Wordfence or custom)     |

*\*Always test updates on a staging site before applying to production.*

---

## 6. reCAPTCHA Setup

Used by contact forms and registration forms on the site.

1. Go to [https://www.google.com/recaptcha/admin](https://www.google.com/recaptcha/admin)
2. Register a new site — **daanfoundation.in**
3. Choose **reCAPTCHA v2** → "I'm not a robot" checkbox
4. Copy the **Site Key** and **Secret Key**

Add to the environment (`.env` file on the server):

```bash
RECAPTCHA_SITE_KEY=6Lxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
RECAPTCHA_SECRET_KEY=6Lxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

Alternatively, add directly to `wp-config.php`:

```php
define('RECAPTCHA_SITE_KEY', '6Lxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
define('RECAPTCHA_SECRET_KEY', '6Lxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
```

The theme's `inc/security.php` reads these from environment variables
or `$_ENV` automatically. No further code changes are needed.

---

## 7. What `inc/security.php` Handles

Review the file at `wp-content/themes/daan-custom/inc/security.php`:

| Feature                         | Mechanism                                          |
|---------------------------------|----------------------------------------------------|
| XML-RPC disabled                | `xmlrpc_enabled` filter → `__return_false`         |
| File editing disabled           | `DISALLOW_FILE_EDIT` constant                      |
| Login attempt limiting          | Custom option-based tracker (3× → 15 min, 10× → 1h)|
| WP version removed              | `wp_generator` action + `the_generator` filter     |
| Query string `?ver=` removed    | `style_loader_src` / `script_loader_src` filters   |
| User enumeration blocked        | `rest_user_query` filter + author archive redirect |
| Security headers                | `X-Content-Type-Options`, `X-Frame-Options`, etc.  |
| Admin hidden from non-admins    | `admin_init` redirect (except AJAX)                |
| reCAPTCHA constants             | Read from environment / `$_ENV`                    |

---

*Last updated: June 2026 — Daan Foundation IT Team*
