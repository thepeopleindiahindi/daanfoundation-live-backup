# QA Checklist — Daan Foundation WordPress Go-Live (Phase 5)

## Browser Compatibility

Test on the latest 2 versions of:

- [ ] Google Chrome (desktop + mobile)
- [ ] Firefox (desktop + Android)
- [ ] Safari (desktop + iOS)
- [ ] Microsoft Edge
- [ ] Samsung Internet (Android)
- [ ] Opera

For each browser, verify:

- [ ] Homepage hero slideshow plays correctly
- [ ] Mega menu navigation works (hover + click)
- [ ] Mobile menu opens/closes
- [ ] All page templates render without layout shifts
- [ ] Donation form flows through all 3 steps
- [ ] Contact form submits
- [ ] Zakat calculator calculates correctly
- [ ] Bank details copy-to-clipboard works
- [ ] Image lazy-loading works (no broken images)
- [ ] Footer newsletter signup fields work

## Mobile Responsiveness

Test on these viewport widths:

- [ ] 360px (small phone) — menu, hero, cards all stack correctly
- [ ] 414px (large phone) — no horizontal scroll
- [ ] 768px (tablet) — 2-column grids appear
- [ ] 1024px (landscape tablet) — sidebar layout kicks in
- [ ] 1440px (desktop) — max-width constraint works

Check on each:

- [ ] No overlapping elements
- [ ] Tap targets at least 44×44px
- [ ] Font sizes legible without zoom
- [ ] Images don't overflow containers
- [ ] Forms are usable (inputs don't zoom on iOS)

## Broken Links

- [ ] Run a full crawl: `npx broken-link-checker https://staging.daanfoundation.in --recursive`
- [ ] OR use: Dr. Link Check, W3C Link Checker, or Screaming Frog
- [ ] All internal links point to existing pages (no 404s)
- [ ] All external links (social media, bank, etc.) open in new tab
- [ ] All image src attributes resolve to existing files
- [ ] No mixed content (HTTPS page loading HTTP resources)

## Page Speed

- [ ] Run Google PageSpeed Insights for mobile + desktop (target: 70+ mobile, 85+ desktop)
- [ ] Run GTmetrix
- [ ] Largest Contentful Paint (LCP) < 2.5s
- [ ] First Input Delay (FID) < 100ms
- [ ] Cumulative Layout Shift (CLS) < 0.1
- [ ] Images are next-gen format (WebP) where possible
- [ ] CSS/JS are minified
- [ ] Render-blocking resources minimized
- [ ] Lazy loading enabled for below-fold images

## Spam Protection

- [ ] All forms include nonce fields (CSRF protection)
- [ ] Contact form has reCAPTCHA v2 or v3
- [ ] Newsletter signup has reCAPTCHA
- [ ] Comment forms (if any) have reCAPTCHA
- [ ] Login page has reCAPTCHA or login limit (from security.php)
- [ ] Honeypot fields added to forms (hidden field trick)

## Forms

- [ ] Contact form: submit with valid data → success message + email received
- [ ] Contact form: submit with missing required fields → validation error shown
- [ ] Contact form: submit with invalid email → validation error shown
- [ ] Newsletter: subscribe with valid email → success
- [ ] Newsletter: subscribe with invalid email → error
- [ ] Donation form: Step 1 → Step 2 → Step 3 navigation works
- [ ] Donation form: amount buttons work, custom amount accepted
- [ ] Donation form: cause radio buttons work
- [ ] Donation form: donor details saved correctly
- [ ] Donation form: back/continue buttons work

## Payment (Test Mode)

- [ ] Razorpay test mode configured
- [ ] Create order API returns order_id
- [ ] Complete test donation with UPI test ID
- [ ] Payment verification signature check passes
- [ ] Donation recorded in database
- [ ] Donor receives receipt email
- [ ] Admin receives notification email
- [ ] Test card payment: success path
- [ ] Test card payment: failure path (insufficient funds)
- [ ] Test card payment: failure path (bank declined)

## SEO

- [ ] Each page has unique meta title and description
- [ ] Canonical URLs set correctly
- [ ] Open Graph tags present on all pages
- [ ] Twitter Card tags present
- [ ] Schema.org markup for Organization + WebSite + BreadcrumbList
- [ ] Sitemap.xml accessible at /sitemap.xml
- [ ] Robots.txt accessible and correct
- [ ] Search Console property verified
- [ ] Google Analytics / Tag Manager firing correctly
- [ ] No duplicate meta tags
- [ ] All old URLs 301 redirect to new URLs
- [ ] Redirect chain test: old → new → final (no loops)
- [ ] 404 page returns proper 404 status and shows helpful content

## Security

- [ ] HTTPS enforced (HTTP → 301 → HTTPS)
- [ ] SSL certificate valid (not expired)
- [ ] Security headers present (X-Content-Type-Options, X-Frame-Options, etc.)
- [ ] wp-admin requires HTTPS
- [ ] XML-RPC disabled (POST /xmlrpc.php returns 403)
- [ ] File editing disabled in admin
- [ ] Login page not enumerable (/wp-json/wp/v2/users/ blocked)
- [ ] .env and wp-config.php inaccessible via browser
- [ ] Directory listing disabled
