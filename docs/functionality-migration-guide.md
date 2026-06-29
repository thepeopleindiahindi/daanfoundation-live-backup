# Functionality Migration Guide

> **Purpose**: Configure each interactive feature on the WordPress staging site after the theme is activated.
>
> **Source**: Live site at `https://daanfoundation.in` → Staging at `https://staging.daanfoundation.in`

---

## 1. Payment Gateway (Razorpay)

The custom PHP code in `inc/snippets.php` creates Razorpay orders via AJAX. The `page-donate.php` template has a commented-out WooCommerce shortcode AND a working custom form.

**Recommended approach**: Install "Razorpay Payment Gateway for WooCommerce" plugin

- [ ] Go to Plugins → Add New → Search "Razorpay for WooCommerce" → Install & Activate
- [ ] Go to WooCommerce → Settings → Payments → Razorpay → Enable
- [ ] Enter Key ID and Key Secret from Razorpay Dashboard
- [ ] OR: Add to `wp-config.php` (the `inc/snippets.php` reads them automatically):
      ```php
      define('RAZORPAY_KEY_ID', 'rzp_live_XXXX');
      define('RAZORPAY_KEY_SECRET', 'XXXX');
      ```
- [ ] Test with Razorpay test mode before going live

---

## 2. Contact Form

WPForms Lite is already installed on the live site. `page-contact.php` has WPForms and Forminator shortcode placeholders. The custom form falls back to AJAX handler in `inc/snippets.php`.

**Recommended approach**: Use WPForms (already installed)

- [ ] Go to WPForms → Add New
- [ ] Create form with fields: First Name, Last Name, Email, Subject, Message
- [ ] Under Settings → Confirmations: set message _"Thank you for contacting us. We will get back to you within 24-48 hours."_
- [ ] Under Settings → Notifications: send to `daanfoundationindia@gmail.com`
- [ ] Publish, copy the shortcode `[wpforms id="XXX" title="false"]`
- [ ] Open `page-contact.php`, replace the placeholder shortcode comment with the actual shortcode

---

## 3. Newsletter / Email Signup

The footer currently has a fallback form that posts to an AJAX handler.

**Recommended approach**: Install "Mailchimp for WP" plugin

- [ ] Plugins → Add New → "Mailchimp for WP" → Install & Activate
- [ ] Go to Mailchimp for WP → Settings → enter Mailchimp API key
- [ ] Create email list in Mailchimp
- [ ] Use `[mc4wp_form]` shortcode in `footer.php` widgets
- [ ] **Alternative**: Install "Newsletter" plugin (simpler, no external service needed)

---

## 4. SMTP / Transactional Email

Without SMTP, emails from the contact form and donation receipts will land in spam.

**Recommended approach**: Install "WP Mail SMTP" plugin

- [ ] Plugins → Add New → "WP Mail SMTP by WPForms" → Install & Activate
- [ ] Go to Settings → WP Mail SMTP
- [ ] Choose a mailer:

| Mailer | Details |
|--------|---------|
| **Gmail / Google Workspace** | Use "Gmail" with OAuth — most reliable, free |
| **SMTP2Go** | Free tier (1,000 emails/month), simple API key setup |
| **SendGrid** | Free tier (100 emails/day) |
| **Other SMTP** | Enter SMTP Host, Port, Username, Password |

- [ ] Send a test email to verify delivery
- [ ] **Alternative**: Add SMTP constants to `wp-config.php` (see `inc/smtp-config.php`):
      ```php
      define('SMTP_HOST', 'smtp.gmail.com');
      define('SMTP_PORT', 587);
      define('SMTP_USER', 'daanfoundationindia@gmail.com');
      define('SMTP_PASS', 'your-app-password');
      define('SMTP_SECURE', 'tls');
      define('SMTP_FROM', 'daanfoundationindia@gmail.com');
      define('SMTP_FROM_NAME', 'Daan Foundation');
      ```

---

## 5. Donation System (WooCommerce)

WooCommerce is already installed on the live site.

**Recommended approach**: Use WooCommerce + "Donations for WooCommerce" (already installed)

- [ ] Go to WooCommerce → Products → Add New
- [ ] Create donation products for each cause (set as Simple product, virtual, downloadable):

| Product | Amount |
|---------|--------|
| Community Kitchen Meal | ₹59 |
| Ramadan Iftar Meal | ₹100 |
| Zakat Donation | ₹1,000 |
| Sadaqah Donation | ₹500 |
| *(add more as needed)* | |

- [ ] Enable **"Donation" toggle** from Donations for WooCommerce meta box
- [ ] Set **"Allow Custom Amount"** where applicable
- [ ] Create a **"Donate Now"** button on each product
- [ ] Open `page-donate.php`, replace the WooCommerce placeholder with the actual shortcode:
      `[products ids="123,124,125" columns="3"]`
- [ ] **Alternative**: Use GiveWP plugin (more donation-focused, requires separate install)

---

## 6. Donation Receipts & 80G Certificates

The file `inc/snippets.php` contains `daan_send_donation_receipt()` and `daan_generate_80g_certificate()`. These hook into WooCommerce order events (`woocommerce_new_order` and `woocommerce_order_status_completed`).

**To use the 80G certificate**:

- [ ] After a donation is completed, append `?receipt=ORDER_ID` to any page URL
- [ ] Example: `https://staging.daanfoundation.in/donate/?receipt=123`
- [ ] This outputs a printable HTML receipt with Daan Foundation details
- [ ] **Alternative**: Install a dedicated "Download Receipt" plugin for WooCommerce

---

## 7. Blog / News System

Already handled by WordPress core (Posts, Categories, Tags).

| Feature | Live Site | WordPress Equivalent |
|---------|-----------|---------------------|
| Sitemap | `api/sitemap.php` | Rank Math SEO sitemap |
| RSS Feed | `api/rss.php` | Built-in `/feed/` |

- [ ] No additional configuration needed
- [ ] `archive.php` and `single.php` templates render blog posts properly

---

## Testing Checklist

- [ ] **Contact form**: Submit a test message, verify email received
- [ ] **Donation form**: Process a test transaction (Razorpay test mode)
- [ ] **Donation receipt**: Check email receipt arrives with correct details
- [ ] **80G certificate**: Visit `?receipt=ORDER_ID` and confirm printable output
- [ ] **Newsletter**: Subscribe a test email, verify confirmation
- [ ] **SMTP**: Send test email from WP Mail SMTP settings
- [ ] **All pages**: Confirm no PHP errors or warnings
- [ ] **Mobile**: Test forms on mobile viewport
