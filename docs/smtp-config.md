# SMTP Configuration for Daan Foundation

WordPress uses `wp_mail()` which defaults to PHP's `mail()` function. Most hosting providers block or rate-limit PHP `mail()`, causing donation receipts and contact form notifications to never arrive. **Configure SMTP to fix this.**

---

## Option A: WP Mail SMTP Plugin (Recommended)

1. Install and activate [WP Mail SMTP](https://wordpress.org/plugins/wp-mail-smtp/) from Plugins → Add New.
2. Go to **Settings → WP Mail SMTP**.
3. Choose your mailer:
   - **Gmail / Google Workspace** – use the Gmail mailer with OAuth (most reliable).
   - **Other SMTP** – use if you have SMTP credentials from SendGrid, SMTP2Go, etc.
4. Enter the settings from your provider (see below).
5. Click **Save Settings**.
6. Go to the **Email Test** tab and send a test email.

---

## Option B: Code Snippet (inc/smtp-config.php)

The file `wp-content/themes/daan-custom/inc/smtp-config.php` is already included from `functions.php`. It reads all credentials from environment variables so **no secrets are hardcoded**.

### Add to `.env` (in the WordPress root):

```
SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_USER=daanfoundationindia@gmail.com
SMTP_PASS=your_app_password
SMTP_SECURE=tls
SMTP_FROM=daanfoundationindia@gmail.com
SMTP_FROM_NAME="Daan Foundation"
```

### Or add constants to `wp-config.php`:

```php
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'daanfoundationindia@gmail.com');
define('SMTP_PASS', 'your_app_password');
define('SMTP_SECURE', 'tls');
define('SMTP_FROM', 'daanfoundationindia@gmail.com');
define('SMTP_FROM_NAME', 'Daan Foundation');
```

> **Never commit SMTP_PASS to Git.** Use `.env` or wp-config.php (outside the repo).

---

## Where to Get SMTP Credentials

### Gmail SMTP (Free)

1. Enable [2-Step Verification](https://myaccount.google.com/security) on your Google Account.
2. Generate an [App Password](https://myaccount.google.com/apppasswords):
   - Select **Mail** and **Windows Computer**.
   - Copy the 16-character password.
3. Use the app password as `SMTP_PASS` (not your regular Gmail password).

| Setting | Value |
|---------|-------|
| SMTP_HOST | `smtp.gmail.com` |
| SMTP_PORT | `587` |
| SMTP_SECURE | `tls` |
| SMTP_USER | Your full Gmail address |
| SMTP_PASS | 16-character App Password |

### SendGrid (Free tier: 100 emails/day)

- SMTP Host: `smtp.sendgrid.net`
- Port: `587`
- Username: `apikey`
- Password: Your SendGrid API key

### SMTP2Go (Free tier: 1000 emails/month)

- SMTP Host: `mail.smtp2go.com`
- Port: `587`
- Username: Your SMTP2Go username
- Password: Your SMTP2Go password

---

## Testing Email Sending

- **WP Mail SMTP plugin** has a built-in **Email Test** tab.
- Without the plugin, install [Check & Log Email](https://wordpress.org/plugins/check-email/) or [WP Mail Logging](https://wordpress.org/plugins/wp-mail-logging/) and trigger a contact form submission.
- Check your spam folder if test emails don't arrive.

---

## Troubleshooting

| Problem | Solution |
|---------|----------|
| Emails going to spam | Add SPF/DKIM/DMARC DNS records for your domain |
| Gmail "Application-specific password required" | Generate a new App Password |
| Connection refused (port 25) | Use port 587 (TLS) instead |
| Emails not sending at all | Check your host's firewall (some block outbound SMTP) |
