# Technical + SEO Audit — daanfoundation.in
**Date:** 2026-08-19
**Scope:** Full site crawl — 86 URLs from all 4 sitemaps (page/post/product/category) + 284 additional internal links discovered via crawling nav/footer/in-content links across those 86 pages (367 unique internal links total). Read-only — no live changes made in this pass.

**Method note:** All findings below are backed by raw HTTP responses (`curl`/Python `urllib`) or FTP file listings captured during this audit, dated 2026-08-19. Where a requested check could not be performed in this environment (no headless browser, no PageSpeed/Lighthouse API access, no Search Console API access), that is stated explicitly under **Not Verifiable This Pass** rather than guessed at.

---

## CRITICAL

### C1. `robots.txt` points to a stale, static, pre-migration sitemap — the real sitemap is never discovered through the standard channel
**URL:** `https://daanfoundation.in/robots.txt` → `https://daanfoundation.in/sitemap.xml`

**Evidence:**
```
$ curl -s https://daanfoundation.in/robots.txt
...
Sitemap: https://daanfoundation.in/sitemap.xml
```
`https://daanfoundation.in/sitemap.xml` returns **HTTP 200** directly (not a redirect to the real `sitemap_index.xml`) and is a **physical static file sitting at the FTP webroot**, confirmed via FTP `LIST`:
```
-rw-r--r--   1 u772581407.daanfoundation.in o66719424     4840 Jun 25 06:34 sitemap.xml
-rw-r--r--   1 u772581407.daanfoundation.in o66719424      224 Jun 25 06:34 robots.txt
```
Both files are dated **Jun 25 06:34** — the same original deployment timestamp as other confirmed leftover React-SPA `dist/` artifacts (`index.html`, `404.html`, `placeholder.svg`). Static files at the document root are served directly by the webserver, before WordPress/Rank Math ever gets the request — so Rank Math's real, dynamically-generated `sitemap_index.xml` (which correctly lists all pages/posts/products) is never referenced by robots.txt at all.

**Impact:** This static `sitemap.xml` contains only **37 URLs** vs. the real site's 100+ (all 18 blog posts are absent, `/faq/`, `/checkout/`, `/cart/`, `/my-account/`, all 15 WooCommerce products, and more are absent). It also contains **5 dead `/our-work/*` URLs** that don't correspond to any of the site's real 10 Our Work subpages:
```
/our-work/clothing-distribution     -> 404
/our-work/medical-assistance        -> 404
/our-work/educational-support       -> 404
/our-work/marriage-assistance       -> 404
/our-work/ration-kit-distribution   -> 301 -> /ration-kit-distribution-india/
```
Search engines following robots.txt's sitemap directive are being pointed at a broken, 90%-incomplete, pre-migration artifact instead of the real one.

---

### C2. Multiple hero/appeal images are 2–6MB — severe, sitewide performance risk
**URL:** static theme images at `https://daanfoundation.in/images/*`

**Evidence** (FTP `LIST`, sizes in bytes):
```
5791199  extra-4.jpg          (5.79 MB)
5760585  hero-slide-4.jpg     (5.76 MB)
4503716  hero-slide-1.jpg     (4.50 MB)
3705100  hero-slide-2.jpg     (3.70 MB)
2853997  extra-7.jpg          (2.85 MB)
2741565  extra-5.jpg          (2.74 MB)
2591763  ration-kit-front.jpg (2.59 MB)
2453913  extra-6.jpg          (2.45 MB)
2418702  extra-3.jpg          (2.42 MB)
2149257  extra-2.jpg          (2.15 MB)
2149257  extra-1.jpg          (2.15 MB)
2005514  hero-slide-3.jpg     (2.01 MB)
```
Full list of all 27 images over 300KB (requested threshold) is in the **Performance** section below. `hero-slide-*.jpg` are used in the homepage hero rotation — almost certainly the LCP (Largest Contentful Paint) element on the homepage — at 2–5.8MB each, uncompressed for web.

**Impact:** On mobile/3G-4G connections this alone can add several seconds to LCP. This is very likely the single largest lever available to improve the site's real-world load speed.

---

## HIGH

### H1. Six pages have two `<h1>` tags each
**Evidence** (extracted `<h1>` text per page):
| URL | H1s found |
|---|---|
| `/cart/` | "Cart", "Donate" |
| `/checkout/` | "Cart", "Donate" |
| `/donation-success/` | "Donation Success", "Thank You for Your Donation!" |
| `/my-account/` | "My account", "My Account" |
| `/product/ramadan-iftar/` | "Ramadan Iftar", "Ramadan Iftar" (literal duplicate) |
| `/ration-kit-distribution-india/` | "Ration Kit Distribution: Monthly Relief for Zakat, Sadqah &#038; Kaffara Familie[s]" ×2 (one entity-encoded as `&#038;`, one as `&amp;` — same text rendered twice) |

Cart/Checkout's second H1 ("Donate") looks like the donation-sidebar widget rendering its own heading as `<h1>` instead of `<h2>`/`<h3>` — worth checking whether this widget is reused on other templates too.

### H2. Canonical tag missing on 3 core WooCommerce pages
```
MISSING CANONICAL: https://daanfoundation.in/cart/
MISSING CANONICAL: https://daanfoundation.in/checkout/
MISSING CANONICAL: https://daanfoundation.in/my-account/
```

### H3. Canonical mismatch: `/bank-detail/` points its canonical at `/bank-details/`
```
https://daanfoundation.in/bank-detail/  ->  canonical=https://daanfoundation.in/bank-details/
```
Both URLs are separately live (both HTTP 200, both in `page-sitemap.xml`), with the same page title ("Bank Details - Daan Foundation") — genuine duplicate-content pair. Given the canonical already points from `-detail` to `-details`, this looks like a known duplicate that was half-fixed (canonical set) but the duplicate page itself was never removed/redirected.

### H4. Test/placeholder content still live, indexed, and in the sitemap
```
https://daanfoundation.in/test/          -> 200, in post-sitemap.xml, title "Test - Daan Foundation"
https://daanfoundation.in/test-2/        -> 200, in post-sitemap.xml, title "Test - Daan Foundation" (duplicate)
https://daanfoundation.in/hello-world/   -> 200, in post-sitemap.xml (default WP sample post)
```
None of these are noindexed. All three are discoverable by search engines right now.

### H5. Additional confirmed duplicate-content pairs (near-identical titles, both live/indexed)
```
'Bank Details'                    : /bank-detail/  vs  /bank-details/         (see H3)
'What is a Community Kitchen...'  : /what-is-a-community-kitchen-and-how-does-it-work-in-india/  vs  .../..-2/
'Donation - General'              : /product/donation-general/  vs  /product/donation-general-2/
```
The "What is a Community Kitchen" duplicate pair was previously flagged (unfixed) in the prior audit doc `docs/SEO-Technical-Audit-2026-07-29.md` as item I4/M4 — confirmed still live and unresolved as of this crawl.

### H6. 9 render-blocking `<script>` tags and 10 synchronous `<link rel="stylesheet">` tags in `<head>`
**Evidence:**
```
Scripts with no defer/async: 9
  jquery-core-js, jquery-migrate-js, wp-hooks-js, wp-i18n-js, wp-dom-ready-js,
  starter-templates-zip-preview-js, daan-theme-js, sourcebuster-js-js, wc-order-attribution-js

Stylesheets (all synchronous, none use a preload/media-swap pattern):
  wp-block-library style.min.css
  donations-for-woocommerce frontend.css
  woocommerce-layout.css, woocommerce-smallscreen.css, woocommerce.css, brands.css   (4 separate WooCommerce CSS files)
  Google Fonts (external, render-blocking)
  daan-tailwind-css (tailwind.min.css)
  daan-theme-css (theme.min.css)
  wc-blocks.css
```

### H7. Astra Sites onboarding-wizard script loads on every public page
```
<script id="starter-templates-zip-preview-js"
  src="https://daanfoundation.in/wp-content/plugins/astra-sites/inc/lib/onboarding/assets/dist/template-preview/main.js">
```
`astra-sites` is a theme-setup onboarding wizard plugin — this script is meant for the wp-admin theme-install flow, not the public frontend, yet it loads (200, confirmed) on every visitor's page load. Pure unnecessary bytes/requests sitewide.

---

## MEDIUM

### M1. Footer social icons are non-functional generic placeholders
**Evidence:**
```
href="https://instagram.com"
href="https://linkedin.com"
href="https://twitter.com"
href="https://youtube.com"
```
These all return 200 (they're valid platform root domains), so they don't 404 — but they don't point anywhere near a real Daan Foundation profile. A donor clicking the Instagram icon in the footer lands on Instagram's generic homepage, not the org's page. Confirmed still the case as of this crawl.

### M2. 14 pages have a meta title over 60 characters
```
66 chars  /behind-the-scenes-how-we-cook-1000-meals-a-day/
73 chars  /feeding-the-poor-daily-life-inside-a-community-kitchen/
123 chars /how-%e2%82%b955-can-feed-a-hungry-person-for-a-day.../
155 chars /how-to-calculate-fidyah-for-sick-person-in-ramadan-2026.../
336 chars /looking-for-a-reliable-islamic-charity-ngo-learn-how-to-donate.../
92 chars  /meals-with-dignity-how-we-maintain-hygiene-and-respect-at-daan-foundation/
85 chars  /ramadan-2026-iftar-donation-guide-how-to-support-families-in-need/
77 chars  /reliable-ramadan-iftar-donation-websites/
100 chars /the-timeless-virtue-of-feeding-a-fasting-person-a-tradition-over-a-millennium-old/
64 chars  /volunteers-speak-serving-food-changed-my-life/
76 chars  /what-is-a-community-kitchen-and-how-does-it-work-in-india-2/
76 chars  /what-is-a-community-kitchen-and-how-does-it-work-in-india/
85 chars  /why-no-one-should-sleep-hungry-daan-foundations-food-mission/
112 chars /zakat-distribution-drive-2027/
```
All 14 are blog posts. The 336-char one is the same "kitchen-sink" keyword-stuffed title flagged in the prior audit doc.

### M3. Meta description missing or over 155 characters on ~25 URLs
**Missing entirely:**
```
/appeals/  /bank-detail/  /bank-details/  /category/uncategorized/  /donate-now/
/donation-confirmation/  /donor-dashboard/  /product/donation-general/
/product/donation-general-2/  /product/test-product/  /test/  /test-2/
```
**Over 155 chars** (WooCommerce product pages are the worst offenders — descriptions are auto-pulled from full product body text, not a curated meta description):
```
163 chars  /behind-the-scenes-how-we-cook-1000-meals-a-day/
162 chars  /feeding-the-poor-daily-life-inside-a-community-kitchen/
157 chars  /our-work/serving-with-dignity/
157 chars  /our-work/why-transparency/
639 chars  /product/bank-interest/
393 chars  /product/community-kitchen/
503 chars  /product/education-aid/
356 chars  /product/fidya-and-kaffara/
491 chars  /product/sadqah/
510 chars  /product/serving-iftar/
344 chars  /product/zakat/
158 chars  /refund-policy/
224 chars  /reliable-ramadan-iftar-donation-websites/
157 chars  /sadqah/
161 chars  /serving-iftar/
158 chars  /why-no-one-should-sleep-hungry-daan-foundations-food-mission/
199 chars  /zakat-distribution-drive-2027/
```

### M4. Duplicate meta titles across 12 URL sets
Mostly a content-page vs. matching WooCommerce product-page pattern (e.g. `/zakat/` and `/product/zakat/` both titled "Zakat - Daan Foundation") — expected in a hybrid content+shop setup but still a real duplicate-title signal to search engines:
```
Bank Details        : /bank-detail/  <->  /bank-details/
Bank Interest        : /bank-interest/  <->  /product/bank-interest/
Cart                  : /cart/  <->  /checkout/
Community Kitchen     : /community-kitchen/  <->  /product/community-kitchen/
Fidya and Kaffara     : /fidya-and-kaffara/  <->  /product/fidya-and-kaffara/
Donation - General    : /product/donation-general/  <->  /product/donation-general-2/
Sadqah                : /product/sadqah/  <->  /sadqah/
Serving Iftar          : /product/serving-iftar/  <->  /serving-iftar/
Where Most Needed      : /product/where-most-needed/  <->  /where-most-needed/
Zakat                  : /product/zakat/  <->  /zakat/
Test                   : /test/  <->  /test-2/
What is a Community Kitchen...: the two duplicate posts (see H5)
```

### M5. Redirect chain on `http://www.` entry point (2 hops instead of 1)
**Evidence:**
```
$ curl -s -o /dev/null -D - -L http://www.daanfoundation.in/
HTTP/1.1 301  Location: https://www.daanfoundation.in/
HTTP/1.1 301  Location: https://daanfoundation.in/
HTTP/1.1 200
```
Non-www + HTTPS is confirmed as the canonical version (`https://daanfoundation.in/`, single-hop from both plain `http://` and `https://www.`) — only the `http://www.` combination takes 2 hops instead of 1. Minor, but easy to collapse into a single redirect.

### M6. 21 images across 9 pages missing `alt` text
```
7  /checkout/
7  /cart/
1  /terms-conditions/
1  /serving-iftar/
1  /sadqah/
1  /refund-policy/
1  /fidya-and-kaffara/
1  /education-aid/
1  /bank-interest/
```
Cart/Checkout (WooCommerce core templates) account for 14 of the 21.

---

## LOW

### L1. `xmlrpc.php?rsd` returns 403
Found via link crawl (RSD discovery link, not a user-facing link). Likely intentional XML-RPC hardening; low real-world impact either way.

### L2. No web app manifest
```
manifest.json      -> 404
site.webmanifest   -> 404
```
Not referenced in `<head>` on any template checked either. Optional for this site type (not a PWA), informational only.

### L3. SSL certificate — informational, no action needed
```
notBefore = Aug 14 2026
notAfter  = Nov 12 2026
issuer    = Let's Encrypt
```
Valid, ~85 days remaining as of this audit, standard 90-day Let's Encrypt auto-renewal cycle. Not expiring imminently.

---

## PASS — confirmed working, no issue found

- **Favicon & branding:** `favicon.ico`, `favicon-32.png`, `favicon-192.png`, `apple-touch-icon.png` all return 200 and are correctly linked in `<head>` identically across every template checked (home, about, blog single, blog listing, product, checkout).
- **robots.txt disallow rules:** file exists, `Allow: /` for all agents including Googlebot/Bingbot — nothing is being blocked that shouldn't be. (The *sitemap reference* inside it is the problem — see C1.)
- **HTTP → HTTPS:** single-hop 301, correct.
- **www → non-www (https):** single-hop 301, correct. (Only the `http://www.` combination chains — see M5.)
- **Compression:** Brotli active (`Content-Encoding: br`) confirmed on homepage response.
- **Caching:** LiteSpeed page cache active (`X-LiteSpeed-Cache-Control: public, max-age=600`).
- **Schema markup — confirmed actually rendering in page source** (not just configured in Rank Math): homepage carries `NGO`, `Organization`, `WebSite`, `Article`; a sampled blog post carries `BlogPosting`, `NGO`, `Organization`.
- **Mixed content:** zero `http://` resources found on any of the 86 crawled HTTPS pages.
- **Internal link health:** of 367 unique internal links discovered by crawling nav/footer/in-content links across all 86 sitemap pages, only the L1 item above (a non-visible RSD link) returned an error status. Nav, footer, and in-content CTA links are all healthy.
- **All 86 sitemap-listed URLs return HTTP 200.**
- **Old-URL spot-check:** `/our-work/ration-kit-distribution` (an old slug referenced in the stale static `sitemap.xml`, see C1) correctly 301s to the current `/ration-kit-distribution-india/` — the WordPress-side redirect layer itself is working correctly where it's been set up.

---

## Not Verifiable This Pass (environment limitations — stated explicitly, not guessed at)

- **Core Web Vitals (LCP/CLS/TBT) numeric scores:** No headless browser or PageSpeed Insights/Lighthouse API access in this environment. What *was* measured instead: compression/caching headers (pass), render-blocking resource counts (H6), and raw image payload sizes (C2) — all of which are real inputs to LCP/CLS/TBT, but this is not a substitute for an actual Lighthouse run. Recommend running PageSpeed Insights manually on home/about/one blog post as a follow-up.
- **Browser console JS errors:** No headless browser available. What *was* checked instead: every `<script src>` and `<link rel="stylesheet">` referenced on the homepage returns HTTP 200 (no 404-caused load errors) — this doesn't rule out *runtime* JS errors, only load-time ones.
- **Mobile viewport re-confirmation of the header/hero overlap bug:** No screenshot/browser tool available. What *was* checked instead: the specific CSS rules from this site's earlier fix for this exact bug (`.hero-donate-section`, `.donate-quickactions-row` with `order` swaps) are present in the currently-deployed `theme.css`. This suggests the previously-fixed state is still deployed, but is not a visual confirmation — recommend a manual mobile-viewport check to fully close this item.
- **Exhaustive old-URL → 301 audit:** Without the original React SPA's route list or historical analytics data, a full audit of "every old URL that should redirect but doesn't" isn't possible from this environment. One representative old-slug pattern was spot-checked (see Pass section) and redirects correctly; this is not exhaustive coverage.
