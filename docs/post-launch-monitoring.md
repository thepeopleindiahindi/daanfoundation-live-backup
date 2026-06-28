# Post-Launch Monitoring Guide — Daan Foundation WordPress Go-Live (Phase 5)

## Week 1: Daily Checks

- [ ] Check Google Search Console for crawl errors, sitemap status, manual actions
- [ ] Monitor uptime (use UptimeRobot or free service) — SMS/email alerts on downtime
- [ ] Review WordPress error log (`/wp-content/debug.log` if WP_DEBUG enabled)
- [ ] Check server error log for PHP fatals, 404 spikes
- [ ] Check contact form is still receiving submissions
- [ ] Verify donation emails still arriving (send test donation daily for first 3 days)

## Week 2: Every Other Day

- [ ] Review Google Analytics: traffic compared to pre-migration baseline
- [ ] Check Search Console: impressions, clicks, average position by page
- [ ] Look for 404s in Google Search Console → add 301 redirects as needed
- [ ] Review form spam logs (if using reCAPTCHA + honeypot)
- [ ] Verify backup ran successfully (check backup directory)

## Common Post-Migration Issues & Solutions

### Traffic drop

- Check Search Console for "Crawled - currently not indexed" — request indexing
- Submit sitemap again in Search Console
- Check for noindex tags accidentally applied
- Verify redirects are 301 (not 302)
- Allow 1-2 weeks for Google to re-crawl and adjust rankings

### 404 spikes

- Add specific 301 redirects for any missed old URLs
- Use a 404 monitoring plugin (Redirection plugin logs 404s)
- Check internal links pointing to old URLs

### Form/donation email not arriving

- Verify SMTP settings in WP Mail SMTP
- Send test email from WP Mail SMTP settings
- Check spam folder
- Verify email sending limits not exceeded (Gmail: 500/day, SendGrid: 100/day free)

### Slow page loads

- Enable caching plugin: WP Rocket or Flying Press (paid) or W3 Total Cache (free)
- Optimize images with Smush or ShortPixel
- Enable Cloudflare CDN (free plan sufficient)
- Minify CSS/JS

## Tools to Use

| Tool | Purpose | Free? |
|---|---|---|
| UptimeRobot | Uptime monitoring (5-min checks) | Yes (50 monitors) |
| Google Search Console | SEO monitoring, crawl errors | Yes |
| Google Analytics | Traffic analysis | Yes |
| WP Mail SMTP Email Log | Track email delivery | Yes |
| Query Monitor (plugin) | Debug PHP errors, DB queries | Yes |
| Redirection (plugin) | Log 404s, manage redirects | Yes |
| Wordfence | Security monitoring | Yes |
| Health Check & Troubleshooting (plugin) | WP health checks | Yes |

## Rollback Decision Guide

Roll back if any of these occur within 48 hours:

- Traffic drops >50% with no recovery after 48 hours
- Payment gateway consistently fails (lost donations)
- Contact form submissions not arriving at all
- Critical security vulnerability discovered

Don't roll back for:

- Minor styling differences (fix forward)
- Slow page loads (enable caching, CDN)
- Missing images (upload to media library)
- 404s on low-traffic pages (add redirects)
