# Phase 5 — Migration Complete: Stable State Log

**Date:** 2026-06-26
**Domain:** daanfoundation.in
**Server:** LiteSpeed LSAPI V8.1 CloudLinux, PHP 8.x

---

## 1. WordPress Core Repair

- **Issue:** Site returned blank pages; 3,507 core files missing (wp-includes/, wp-load.php, wp-settings.php, etc.)
- **Fix:** Downloaded WP 7.0 via `file_get_contents`, extracted with `ZipArchive`, copied all missing files via FTP
- **Verification:** Checksums pristine — 3,951/3,951 matched (0 mismatched, 0 missing)
- **Status:** `wp-admin`, `wp-login.php`, all core REST endpoints return HTTP 200

## 2. Theme & Pages

- **Theme:** `daan-custom` (custom-built) active, set as static front page
- **31 pages created:**
  - 9 direct template pages: about, appeals, bank-details, contact, donate, orphan-sponsorship, water, where-we-work, zakat-calculator
  - 11 sidebar-content pages: community-kitchen, zakat, sadaqah, fidya, kaffarah, ramadan, winter-appeal, where-most-needed, sadaqah-jariyah, eid-gifts, zakat-al-fitr
  - 10 our-work child pages: impact, charity-in-action, community-trust, history, annual-report, serving-with-dignity, supporting-women, donation-is-trust, empowering-livelihoods, why-transparency
  - 1 home page
- **All pages return HTTP 200** verified via curl
- **Sidebar template bug fixed:** `tpl-sidebar-content.php` reads `$page_data['title']` (was using wrong hero key)

## 3. .htaccess Deployment

Incremental deployment with curl verification after each step:

| Step | Directive | Status |
|------|-----------|--------|
| 1 | Force HTTPS + Remove WWW + WordPress permalinks | Tested OK |
| 2 | 4 Redirect 301 rules (/index.html → /, /fitrana → /zakat-al-fitr, /iftar → /ramadan, /winter → /winter-appeal) | Tested OK |
| 3 | User enumeration block (`?author=N` → 403) | Tested OK |
| 4 | wp-config.php and .htaccess file protection (403) | Tested OK |

- **Backup:** `backups/htaccess-production-live.txt`
- **LiteSpeed-compatible:** No `<IfModule>`, no `Require all denied`, no `Options -Indexes`

## 4. Email Delivery

### Root Cause
WP Mail SMTP v4.9.0 options were saved via `update_option()` directly, bypassing the plugin's `Options::set()` method. This caused `Options::get('mail', 'mailer')` to return `'mail'` (default) instead of `'smtp'`, so `Processor::phpmailer_init()` skipped SMTP configuration entirely. All emails went through PHP's default `mail()` (localhost:25) which silently failed.

### Fix
Re-saved all settings through the plugin's own API (`Options::set()`), which properly encrypts the password and populates the internal options cache.

### Verified
- Mailer: `smtp` → Host: `smtp.gmail.com:587`, TLS, auth with Gmail App Password
- Direct `wp_mail()` test emails → delivered to both daanfoundationindia@gmail.com and arksuri@gmail.com
- WooCommerce New Order (admin) + On-Hold (donor) emails → delivered successfully

### Theme SMTP File
`inc/smtp-config.php` exists in the theme and registers `daan_configure_smtp` on `phpmailer_init` (priority 10). This is a no-op unless `SMTP_HOST` constant is defined — it does not interfere when WP Mail SMTP is active.

## 5. Payment Gateways

### Direct Bank Transfer (BACS)
- **Gateway:** WooCommerce BACS, enabled
- **Title:** "Direct Bank Transfer (NEFT)"
- **Bank details:**
  - Bank: State Bank of India
  - Account Name: Daan Foundation
  - Account Number: 42818355421
  - IFSC Code: SBIN0003448
  - Branch: Amroha, UP
- **Custom hook:** `woocommerce_email_after_order_table` appends bank transfer details to on-hold order emails
- **Test order #6823:** ?500, Aisha Khan, on-hold, both emails received

### Pay via UPI (Cheque Gateway)
- **Gateway:** WooCommerce Cheque (renamed), enabled
- **Title:** "Pay via UPI"
- **UPI ID:** `8899152910@ptsbi`
- **QR code:** `/wp-content/themes/daan-custom/assets/images/upi-qr-code.jpg` (generated for `upi://pay?pa=8899152910@ptsbi&pn=Daan%20Foundation&cu=INR`)
- **Description:** HTML block with QR code image, UPI ID, scan/pay instructions, supported apps list
- **Payment flow:** Manual — donor pays via UPI app, clicks Place Order, admin confirms manually

### Razorpay (Custom Donate Page — Not Yet Configured)
- Donate page (`page-donate.php`) uses a custom 3-step form (Amount → Details → Payment) with inline JS
- Calls `admin-ajax.php?action=daan_create_order` / `daan_verify_payment`
- Stores donations in custom `wp_daan_donations` table
- **Blocks:** `RAZORPAY_KEY_ID` and `RAZORPAY_KEY_SECRET` not defined on server (pending user-provided keys)
- `/donation-success` page created (ID: 6821, HTTP 200) — displays payment details from URL params

## 6. /blog Cleanup

- **Old install:** Duplicate WordPress at `/blog/` subdirectory
- **Database:** Shared `u772581407_QB3Oj` (NOT touched)
- **Action:** Deleted all `/blog/` files only — `wp-config.php`, `wp-includes/`, `wp-admin/`, `wp-content/plugins`, `wp-content/themes`, etc.
- **Verification:** `/blog/` root returns 404 (no longer resolves to a WP install)
- **Old data preserved:** Legacy pages, orders, and custom table records remain in the shared database

## 7. Shipping

- **Disabled entirely:** `woocommerce_ship_to_countries` = `disabled`
- **Shipping calculator:** Disabled
- **All donation products:** Set to virtual (no physical delivery)
- **Checkout fields:** billing_first_name, billing_last_name, billing_country, billing_address_1, billing_city, billing_state, billing_postcode, billing_email, billing_phone — all required

## 8. Outstanding Items (Next Phase)

| Item | Priority | Notes |
|------|----------|-------|
| Razorpay keys (RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET) | Medium | User to provide; set as env vars on server |
| Cosmetic email HTML design | Low | Current receipts use inline-styled HTML |
| Old-page SEO cleanup | Low | Legacy React SPA pages still indexed? |
| 80G certificate PDF generation | Low | `/receipt?order_id=` route works but is basic HTML |

---

*This document represents the stable, fully-tested state after Phase 5 migration. No further changes should be made without explicit instruction.*
