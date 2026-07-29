# SEO Technical Audit — daanfoundation.in

**Date:** 2026-07-29
**Scope:** Live production site (WordPress + Elementor + WooCommerce + Rank Math, Hostinger/LiteSpeed). Confirmed live via `X-Powered-By: PHP/8.2.30`, Rank Math `wp-json` links, and `Server: LiteSpeed` response headers. This audit does **not** cover the React SPA in this repo (`src/`) — that build is not what daanfoundation.in serves.
**Status:** Phase 1 (audit only) — complete. **No changes have been made to the live site.** Awaiting Ahmad's review and approval of the priority order before any Phase 2 repair work begins.
**Method:** Live HTTP checks (curl/openssl) against the production domain, full HTML/JSON-LD parsing of 40+ pages (all "Our Work" subpages, key funnel pages, 9 sampled blog posts, and pages found via sitemap/link-graph cross-referencing), plus the four current XML sitemaps and robots.txt.

---

## 1. Performance

| # | Page/URL | Severity | Description | Recommended fix |
|---|---|---|---|---|
| P1 | Homepage `/` | **Critical** | 23 unique homepage images total **~18.0 MB**. Individual files are full-resolution uploads served without resizing: `extra-7.jpg` 2.85MB, `extra-5.jpg` 2.74MB (rendered at 800×360), `ration-kit-front.jpg` 2.59MB (rendered at 800×360), `extra-6.jpg` 2.45MB. The above-the-fold hero, `hero-new-banner.webp`, alone is **1.9MB** and is almost certainly the LCP element. | Re-encode/resize all homepage images to actual display dimensions; target the hero well under 200KB. These are hardcoded `/images/*` paths outside `wp-content/uploads`, so WP core's automatic `srcset` generation doesn't apply — needs a manual or plugin-driven resize pass. |
| P2 | All pages (`/`, `/donate/`, `/our-work/impact/` tested) | **Critical** | No `Cache-Control`, `Expires`, or LiteSpeed cache header on any WordPress-generated HTML response. LSCache page caching is not active — every visit (including every crawler hit) regenerates the page via PHP from scratch. | Install/enable/verify LiteSpeed Cache for WordPress; confirm `X-LiteSpeed-Cache: hit` appears on repeat requests. |
| P3 | Static CSS/JS assets sitewide (e.g. `theme.min.css`, `jquery.min.js`, `woocommerce.css`) | **Major** | All CSS/JS return `Cache-Control: no-cache, must-revalidate` paired with a future `Expires` date — a self-defeating combination that forces a revalidation round-trip on every load regardless of the `Expires` header. Images, by contrast, correctly use `public, max-age=604800`. | Apply `public, max-age=604800` (or longer, with versioned/hashed filenames) to CSS/JS instead of `no-cache, must-revalidate`. |
| P4 | Homepage `/` | **Major** | 10 render-blocking `<link rel="stylesheet">` and multiple non-deferred `<script>` tags in `<head>`, including 4 separate WooCommerce CSS files (`woocommerce-layout.css`, `woocommerce-smallscreen.css`, `woocommerce.css`, `brands.css`) plus `wc-blocks.css` loading on the homepage, which has no shop content. jQuery core/migrate load with no `defer`/`async` while several WooCommerce scripts on the same page correctly use `defer`. Google Fonts loads via `dns-prefetch` only, not `preconnect`. | Dequeue WooCommerce CSS/JS on non-checkout/non-shop pages; defer jQuery core where possible; add `preconnect` for `fonts.googleapis.com` and `fonts.gstatic.com`. |
| P5 | Homepage `/` | **Major** | Of 34 `<img>` references, 31 are legacy `.jpg`, 2 `.png`, and only 1 `.webp` (the still-oversized hero). No AVIF anywhere. | Convert JPEGs to WebP/AVIF with responsive `srcset` — likely the single highest-leverage fix given the ~18MB total image weight. |
| P6 | Homepage `/` | **Minor** | Astra Sites ("Starter Templates") onboarding plugin JS (`astra-sites/.../template-preview/main.js`) is enqueued on the live public homepage — an admin-onboarding utility with no reason to load for visitors. | Dequeue for non-admin contexts, or deactivate/remove the Astra Sites plugin if theme setup is finalized. |
| P7 | Static images sitewide | Pass | `Cache-Control: public, max-age=604800` correctly set on images, confirming static-asset caching works at the server level — the gap is isolated to HTML (P2) and CSS/JS (P3). | No action needed. |
| P8 | Homepage `/`, `/donate/` | Pass | Brotli compression (`Content-Encoding: br`) confirmed active on GET responses (a HEAD-only check would have wrongly flagged this as missing — LiteSpeed omits the encoding header on HEAD). | No action needed. |

---

## 2. Crawlability

| # | Page/URL | Severity | Description | Recommended fix |
|---|---|---|---|---|
| C1 | `/news/`, `/ration-kit-distribution-india/`, `/reliable-ramadan-iftar-donation-websites/` | **Major** | Three real, indexable, internally-linked pages (all `index,follow`, self-canonical, 200 OK) are absent from every XML sitemap (`page-sitemap.xml` / `post-sitemap.xml`). Google can only find them by crawling links, not via sitemap. | Check post type/visibility/date filters in Rank Math's sitemap settings for these three; regenerate and resubmit the sitemap in Search Console. |
| C2 | Nav links sitewide (≈30+ URLs: `/about`, `/donate`, all 9 `/our-work/*` links, `/ramadan`, `/zakat`, etc.) | **Major** | Primary nav menu items are built without trailing slashes, so nearly every nav click forces an unnecessary 301 to the canonical trailing-slash URL. | Update WP menu item URLs to the canonical trailing-slash form to eliminate ~30+ redundant redirect hops sitewide. |
| C3 | `/winter` → `/winter-appeal` → `/winter-appeal/` | **Major** | Confirmed 2-hop redirect chain (should be 1 hop directly to the final URL). | Repoint `/winter` directly to `/winter-appeal/`. |
| C4 | `page-sitemap.xml` — `/cart/`, `/checkout/` (and likely `/my-account/`) | **Minor** | These pages are correctly marked `noindex, follow` on-page but are still listed in the XML sitemap — a contradictory signal to Google. Rank Math is expected to auto-exclude noindexed URLs. | Check Rank Math's sitemap exclusion settings / flush sitemap cache. |
| C5 | `/test/`, `/test-2/`, `/hello-world/` | **Minor** | Default WordPress placeholder content is live, indexed, and listed in `post-sitemap.xml` (lastmod 2024-12-02). | Delete or unpublish; remove from sitemap. |
| C6 | `/product/test-product/` | **Minor** | Same issue for WooCommerce — a "test product" is live, indexed, and in `product-sitemap.xml`. | Delete or unpublish. |
| C7 | `product-sitemap.xml` | **Minor** | `/product/ramadan-iftar/` is listed twice with identical `<loc>`/`<lastmod>` — likely a duplicate product row or a sitemap-cache glitch. | Check for a duplicate product in the DB; flush the Rank Math sitemap cache. |
| C8 | robots.txt | Pass | No `Disallow` rules anywhere; explicit `Allow: /` for major crawlers plus a `Sitemap:` directive. Nothing is blocked. | No action needed. |
| C9 | All 4 sub-sitemaps | Pass | Well-formed XML, plausible non-future `<lastmod>` dates ranging 2024-01-08 to 2026-07-28. | No action needed. |
| C10 | 55 internal links sampled across homepage, `/our-work/`, `/donate/`, `/faq/` | Pass | Zero broken links (404/5xx) found in this sample — all resolve to 200 or a valid 301→200. | No action needed. |

---

## 3. URL Structure

| # | Page/URL | Severity | Description | Recommended fix |
|---|---|---|---|---|
| U1 | `/home-2/` vs `/` | **Critical** | `/home-2/` is a fully live, indexable (200, `index,follow`, self-canonical), wholesale duplicate of the actual homepage — same banner images and content blocks, and its own intro paragraph is duplicated twice within its own HTML. | Unpublish, delete, or 301-redirect to `/`, and remove from the sitemap immediately. |
| U2 | `/bank-details/` vs `/bank-detail/`; `/sadaqah/` vs `/sadqah/`; `/fidya/` vs `/fidya-and-kaffara/`; `/donate/` vs `/donate-now/` | **Major** | Each pair is live, indexable, and self-canonical with no redirect or `rel=canonical` consolidation between them — classic duplicate/near-duplicate content competing for the same query. (See also Internal Linking I6–I8: `/bank-detail/` additionally carries a stale UPI ID — a donor-trust issue, not just SEO.) | 301-redirect the duplicate/legacy slug to the canonical page (or set an explicit `rel=canonical`) and drop the loser from the sitemap. |
| U3 | `/donate/` | **Minor** | WooCommerce "add to cart" buttons expose ID-based query-string URLs in markup (`?add-to-cart=6808`, etc.). These 302-redirect straight to `/checkout/` so they aren't crawlable as separate pages, but it's a non-descriptive URL pattern on a key conversion page. | Low priority — cosmetic/structural note only, no urgent fix needed. |
| U4 | Site-wide | Pass | HTTPS enforced everywhere tested (`http://` → `https://`, `www.` → non-`www`, both single-hop). No mixed content found on homepage or `/donate/` (zero `http://` src/href references). | No action needed. |

---

## 4. Meta Tags

| # | Page/URL | Severity | Description | Recommended fix |
|---|---|---|---|---|
| M1 | Homepage `/`, plus 19 more of 40 pages audited (`/donate/`, `/faq/`, `/about/`, `/zakat-calculator/`, `/our-work/`, `/ramadan/`, `/winter-appeal/`, `/zakat-al-fitr/`, `/kaffarah/`, `/fidya/`, `/sadaqah/`, `/sadaqah-jariyah/`, `/where-most-needed/`, `/where-we-work/`, `/orphan-sponsorship/`, `/water/`, `/eid-gifts/`, `/contact/`, `/news/`) | **Critical** | Exactly **50% of the 40 audited pages have no `<meta name="description">` tag at all** — confirmed by raw HTML byte search, not merely an empty string. Google will auto-select homepage/snippet text instead of a curated description, hurting click-through on the site's most important funnel pages. | Populate a Rank Math meta description for every page listed, or set a template-level fallback in Rank Math → Titles & Meta. |
| M2 | Blog: "How to Calculate Fidyah for Sick Person…" | **Critical** | Live meta description literally reads `Meta Description: Learn how to calculate Fidyah for sick person in Ramadan with simple steps. Understand Fidyah payment vs kaffara in Islam and donate zakat,` — an internal field-label prefix was pasted into the content and is now shown verbatim in Google/social. Also mid-sentence-truncated. | Remove the "Meta Description:" prefix; rewrite as a complete sentence under 160 characters. |
| M3 | Blog: "Ramadan 2026 Iftar Donation Guide…" | **Critical** | Live meta description is literally `Slug: /ramadan-2026-iftar-donation-guide` — an editorial note (the URL slug), not a description, is being served to Google/social platforms. | Replace with an actual descriptive summary in Rank Math. |
| M4 | Blog: "What is a Community Kitchen…" (both `/…-india/` and `/…-india-2/`) | **Critical** | Two separate, live, indexed posts share an identical `<title>` tag character-for-character, with near-identical content covering the same topic — direct keyword cannibalization. (Cross-ref Internal Linking I11/I12.) | Canonicalize the weaker post to the stronger one via 301 + canonical, or substantially differentiate both if they must coexist. |
| M5 | Blog: "Looking for a reliable Islamic charity NGO…" | **Critical** | `<title>` tag is **336 characters** — the entire meta-description's worth of stuffed keywords crammed into the title (Zakat, Kaffara, Ramadan, iftaar, Sadqah, Uttar Pradesh, India, etc.). Also forms the URL slug, independently harming shareability. Reads as a spam signal to Google. | Shorten to a single clear, unique title under ~60 characters. |
| M6 | Blog: "How to Calculate Fidyah for Sick Person…" | **Major** | `<title>` tag is 151 characters (~2.5× the practical limit), keyword-stuffing 5+ terms. | Shorten to under ~60 characters. |
| M7 | Blog: "Hello world!" (`/hello-world/`) | **Major** | Default WordPress placeholder post is live, indexed, and in the sitemap on a production nonprofit site. (Cross-ref Crawlability C5.) | Delete/unpublish. |
| M8 | 31 of 40 audited pages (all except home/about/zakat/impact/community-kitchen) | **Major** | No `og:image` set, while `twitter:card` is set sitewide to `summary_large_image` — a card type that requires an image. Shares of `/donate/` and nearly every campaign page will render with no thumbnail, a real conversion cost for a donation-driven site. | Set a Featured Image (or explicit Rank Math social-image override) on every page lacking one, prioritizing `/donate/` and campaign pages. |
| M9 | All 40 audited pages | **Major** | `og:type` is `article` on every static/utility page (donate, faq, zakat, contact, all Our Work pages) — only the homepage and `/news/` correctly use `website`. (Same root cause as Schema S3 below.) | Ensure WP `page` post type defaults to `og:type=website` in Rank Math; reserve `article` for the `post` post type. |
| M10 | `/news/` (archive) | **Major** | `og:description`/`twitter:description` are auto-pulled from an unrelated single post's excerpt rather than describing the News archive itself; the actual `<meta description>` is absent (0 chars). | Set an explicit description for the News archive template in Rank Math's Archives settings. |
| M11 | 9 sampled blog posts | **Minor** | None have `og:image`/`twitter:image` set, despite the `summary_large_image` card type requiring one. | Set a Featured Image on every post (also fixes Schema S5). |
| M12 | Blog "How to Calculate Fidyah…" | **Minor** | Title is 76 characters — moderately over the ~50–60 char guideline (secondary to M4/M6). | Shorten alongside the M4 consolidation fix. |
| M13 | All 40 pages | Pass | Canonical tags present, self-referential, and correct on every page checked. | No action needed. |

---

## 5. Schema Markup / Structured Data

| # | Page/URL | Severity | Description | Recommended fix |
|---|---|---|---|---|
| S1 | `/faq/` | **Critical** | Page has 18 real, well-marked-up Q&A pairs across 3 categories (Zakat, Sadaqah, Fidya & Kaffarah) but **zero `FAQPage`/`Question`/`Answer` schema** — a large missed opportunity for FAQ rich results in Google Search. | Add `FAQPage` schema with a `mainEntity` array matching the 18 visible Q&As, via Rank Math's FAQ block or a custom snippet. |
| S2 | Site-wide `Organization`/`NGO` schema node (every page) | **Critical** | `PostalAddress` is invalid: `addressCountry: "91"` (a phone calling code, not an ISO country code), `postalCode: "2444221"` (7 digits — Indian PINs are 6), and `streetAddress`/`addressLocality` both set to "Katkoi"/"KAtkoi" (duplicated, typo'd). Degrades Rich Results / Knowledge Panel / NGO schema validity. | Fix `addressCountry` to `"IN"`, correct the PIN to a valid 6-digit code, and populate distinct correct `streetAddress`/`addressLocality`/`addressRegion` values in Rank Math's Local SEO / Knowledge Graph settings. |
| S3 | 30 of 40 pages — home, donate, faq, about, zakat, zakat-calculator, our-work hub + all 10 subpages, all campaign pages, contact | **Major** | Every static WP `page` (not a real blog post) has a spurious `Article` schema node auto-attached, with `headline` = page title and `author` pointing to a `Person` node with **no name and a blank default Gravatar** on the homepage. Applying Article/BlogPosting schema to utility pages (Contact, Donate, FAQ) is a type mismatch that can trigger Search Console structured-data warnings. | Restrict Article/`headline`/`author`/`datePublished` schema output to the `post` post type; static pages should emit `WebPage` (or a specific type like `ContactPage`/`AboutPage`/`FAQPage`) via Rank Math's per-page Schema Type setting or its default-schema-per-post-type setting. |
| S4 | 9 sampled blog posts | **Major** | `BlogPosting` schema present with headline/author/dates, but **no `image` property** on any sampled post. Google's Article rich-result eligibility requires an image ≥1200px wide — without it these posts cannot qualify for Article rich snippets. | Set a Featured Image on every post (single fix also resolves M11/og:image). |
| S5 | Blog "How to Calculate Fidyah…" | **Minor** | The same "Meta Description:" placeholder-prefix bug (M2) is duplicated into the `BlogPosting.description` JSON-LD field, not just the visible meta tag. | Same fix as M2 — correcting the Rank Math field fixes both layers at once. |
| S6 | `/donate/` | **Minor** | The `/donate/` hub carries no `DonateAction`/`Product`/`Offer` schema itself — though the individual WooCommerce product pages it links to (`/product/sadaqah-jariyah/`, etc.) do correctly carry `Product`+`Offer` schema with price/category. Not a defect, but an enhancement opportunity on the highest-value page. | Optional: add `DonateAction` schema to `/donate/` pointing at the underlying product URLs. |
| S7 | `/news/` (archive) | **Minor** | Uses `CollectionPage` (appropriate) but is missing the `Organization`/`WebPage`/`Person` nodes present in every other page's schema graph — a structural inconsistency. | Verify intentional; if not, align the News archive schema graph with the standard template. |
| S8 | All 40 pages | Pass | Every JSON-LD block parses as valid, well-formed JSON with no syntax errors; canonical `Organization`/`NGO` name/url/logo/description fields are present and correct. | No action needed. |

---

## 6. Mobile / Core Web Vitals

| # | Page/URL | Severity | Description | Recommended fix |
|---|---|---|---|---|
| CW1 | Homepage `/` | **Critical** | 16 of 31 `<img>` tags (≈52%) are missing both `width` and `height` (no CSS aspect-ratio substitute) — a classic CLS cause. Worst offender: the hero image itself has no dimensions at all and isn't even lazy-load-excluded logic; another hero-area image relies on a CSS `object-fit: cover` rule but still has no intrinsic size for the browser to reserve layout space. Practice is inconsistent within the same template — some images further down the page correctly have `width`/`height`. | Add explicit `width`/`height` (or `aspect-ratio` CSS) to every homepage `<img>`, prioritizing the hero image first. |
| CW2 | Homepage `/` | **Critical** | Compounding P1: the unsized, non-lazy 1.9MB hero image is both the likely LCP element and a CLS trigger when it paints without reserved space — the single highest-leverage fix across Performance + CWV. | Same fix as P1/CW1 combined: resize/compress the hero image AND give it explicit dimensions. |
| CW3 | `/`, `/donate/`, `/our-work/impact/` | Pass | Correct, identical viewport meta tag (`width=device-width, initial-scale=1.0`) confirmed on all three. | No action needed. |
| CW4 | `/donate/`, `/our-work/impact/` | Pass | Zero images missing dimensions on these pages (WooCommerce templates correctly set `width`/`height`) — the CLS risk is isolated to the homepage's custom-theme markup, not sitewide. | No action needed. |
| CW5 | All pages | **Minor** | Google Fonts (`Open+Sans`) correctly uses `font-display=swap`, but only `dns-prefetch` (not `preconnect`) is set for `fonts.googleapis.com`/`fonts.gstatic.com`, adding avoidable latency. Two WooCommerce block-library fonts (Inter, Cardo) use `font-display: fallback` and load sitewide including the non-shop homepage. | Add `preconnect` for both font origins; consider dequeuing WooCommerce fonts outside shop/checkout templates. |
| CW6 | All pages | Info | PageSpeed Insights API was rate-limited during this audit (daily quota exhausted) — no actual lab-measured LCP/CLS/INP/TBT scores were available. Findings above are inferred from strong static-HTML proxies (unsized images, oversized hero, blocking scripts), not real Lighthouse data. | Recommend running PSI manually via pagespeed.web.dev or Chrome DevTools Lighthouse once quota resets, to get real scored metrics before/after fixes. |

---

## 7. Internal Linking

| # | Page/URL | Severity | Description | Recommended fix |
|---|---|---|---|---|
| I1 | `/our-work/` (hub) | **Critical** | Not reachable from normal navigation at all — the mega-menu's "Our Work" item points to `/our-work/impact`, not `/our-work/`. Footer doesn't link to it either. Zero inbound links found across 78 crawled pages. | Point the nav's "Our Work" header to `/our-work/` itself and add it to the footer. |
| I2 | `/home-2/` | **Critical** | True orphan (zero inbound links across 78 pages) and a wholesale duplicate of the homepage. (Cross-ref URL Structure U1.) | 301-redirect to `/` or delete + noindex. |
| I3 | `/bank-detail/` (singular) | **Critical** | True orphan carrying a **different, stale UPI ID** (`42818355421@sbi`) than the current, nav-linked `/bank-details/` page (`8899152910@ptsbi`), while sharing the same account number/IFSC. A donor landing here via an old bookmark or stale search result could send money to a defunct-looking UPI handle — this is a donor-trust/financial-integrity risk, not only an SEO one. | Redirect `/bank-detail/` → `/bank-details/` immediately; treat as higher priority than its SEO classification suggests. |
| I4 | "What is a Community Kitchen…" (`/…-india/` and `/…-india-2/`) | **Critical** | Unlike the orphans above, both duplicate posts are actively promoted via the sitewide "Recent Posts" widget on every blog post — splitting link equity and directly cannibalizing each other. (Cross-ref Meta M4.) | Pick one canonical URL, 301 the other, and remove the loser from the sitemap and the Recent Posts widget. |
| I5 | `/our-work/` (hub) | **Major** | Hub page has no descriptive in-content links to its 10 children — only the identical sitewide nav links to them. No intro text, no in-page link grid. | Add intro copy plus a visible grid linking to all 10 subpages with descriptive anchor text. |
| I6 | All 10 Our Work subpages | **Major** | None contain a breadcrumb or in-content link back to `/our-work/`; confirmed zero `BreadcrumbList` schema anywhere on the site. | Enable Rank Math breadcrumbs (Home > Our Work > [Page]) in the theme template; add an explicit "Back to Our Work" link. |
| I7 | Site footer | **Major** | Footer's "Our Work" column links to only 5 of 10 subpages (Impact, Charity in Action, Community Trust, History, Annual Report) — missing Why Transparency, Empowering Livelihoods, Donation Is a Trust, Supporting Women, Serving With Dignity. | Add the 5 missing links, or replace with a single "See All Our Work →" link to the fixed hub. |
| I8 | `/faq/` | **Major** | Not linked anywhere on the homepage (zero occurrences of "faq" in homepage HTML, nav or footer). | Add FAQ to primary nav or footer. |
| I9 | `/sadqah/` | **Major** | True orphan with thin legacy content (175 words) duplicating the nav-linked `/sadaqah/` (749 words). | 301 `/sadqah/` → `/sadaqah/`. |
| I10 | `/fidya-and-kaffara/` | **Major** | True orphan (173 words) overlapping in topic with the separately nav-linked `/fidya/` and `/kaffarah/` — keyword cannibalization. | Redirect to whichever of `/fidya/`/`/kaffarah/` is canonical, or merge. |
| I11 | `/refund-policy/` | **Major** | Legal/policy page with zero internal links, including from the footer (where Privacy Policy and Terms are linked). | Add to footer alongside Privacy Policy / Terms of Use. |
| I12 | `/education-aid/`, `/bank-interest/`, `/serving-iftar/` | **Minor** | True orphans, thin-to-moderate content (198/124/181 words). `/education-aid/`'s title tag is literally the raw slug ("education-aid - Daan Foundation"), suggesting it was never finished. | Either link intentionally from relevant content/nav, or noindex + prune. |
| I13 | `/hello-world/`, `/test/`, `/test-2/` | **Minor** | Confirmed true orphans in addition to being placeholder content (cross-ref C5). | Delete/unpublish. |
| I14 | Homepage, `/our-work/` | Pass | Sampled ~20 body-content links: zero use bare generic anchor text ("click here"); anchors are consistently descriptive card blocks. | No action needed — minor tightening only where "Learn More" trails an otherwise descriptive block. |

---

## 8. Content-Level SEO

| # | Page/URL | Severity | Description | Recommended fix |
|---|---|---|---|---|
| CT1 | Homepage `/` | **Critical** | **Zero `<h1>` tags** on the entire page (full-document scan confirmed). Heading order also has an H3 ("Make a Donation") appearing before the page's first H2. | Add exactly one `<h1>` to the hero section; reorder so H2 section headers precede their H3 children. |
| CT2 | Blog "Ramadan 2026 Iftar Donation Guide…" | **Critical** | Published with raw, unedited content-brief scaffolding still live in the HTML — headings literally read "Introduction (EVERGREEN INTRO LINE)", "5 Easy Ways to Donate Zakat Online (Snippet-Friendly Numbered List)", "Voice Search Questions to Target (H2)", "Internal Link Suggestion", "Tags & Categories", plus a second `<h1>` reading just "Conclusion." This is an AI-generated brief that was never cleaned up before publishing, and it's currently live and indexed. | Pull for immediate editorial review — remove placeholder/instructional headings, fix the duplicate H1, rewrite before it accrues more visibility. Flagging for Ahmad's review per standing rule (no silent content rewrites). |
| CT3 | Blog "Looking for a reliable Islamic charity NGO…" | **Critical** | Two `<h1>` tags: the first duplicates the ~300-character stuffed title verbatim; a second, real H1 appears further down. (Cross-ref Meta M5.) | Delete the duplicate first H1; shorten the title/H1 to one concise headline. |
| CT4 | `/our-work/` (hub) | **Major** | H1 present and correct, but headings jump straight from H1 to H3 with zero H2s, and body word count (excluding header/footer/nav) is **~39 words** — just the H1 and a donation widget. This appears to be the one Our Work page the recent migration commits (batch 1/3–3/3) did not touch. | Write real intro/overview copy (200+ words) with proper H2 sections; flagging for Ahmad's review rather than assuming this is intentionally minimal. |
| CT5 | 4 blog posts ("How to Calculate Fidyah…", "Meals with Dignity…", "Behind the Scenes: How We Cook 1000 Meals…", "What is a Community Kitchen…" non-"-2" version) | **Major** | Heading hierarchy skips H2 entirely — H1 followed directly by a run of H3s for the whole article body. | Promote the top-level subheadings from H3 to H2 in these 4 posts. |
| CT6 | "What is a Community Kitchen…" `-2` vs. non-`-2` | **Major** | The orphaned "-2" duplicate ironically has *better* heading structure (proper H2/H3 nesting) than the canonical, actively-linked version, which lacks H2s entirely. Cross-ref I4/M4. | When consolidating the duplicate pair, keep the better-structured content under the canonical URL. |
| CT7 | Homepage images | **Major** | 3 images use an entire blog post title as `alt` text verbatim, including the ~300-character stuffed title from CT3/M5 — reads as alt-text keyword stuffing rather than an image description. | Shorten to a genuine, concise description of the image itself. |
| CT8 | `/donate/` | **Minor** | Correct single H1 and logical nesting, but two separate `<h2>` tags both read verbatim "Ramadan Iftar" for what appear to be two different giving options. | Differentiate the labels (e.g. "Ramadan Iftar Fund" vs. "Ramadan Iftar Appeal"). |
| CT9 | Homepage images | **Minor** | Several images reuse generic, non-unique alt text: `alt="Campaign"` on 3 different images, `alt="News"` on 3 different thumbnails, single instances of `alt="Impact"`/`alt="Community support"`. | Write unique, descriptive alt text per image. |
| CT10 | Sampled long-form blog posts (3 of 9 sampled) | **Minor** | 1000–1900 word articles contain no unique body images — only the sitewide logo and a UPI QR code appear. No empty/filename-based alt text found in the sample, but no topical imagery to evaluate either. | Add relevant photos (existing kitchen/distribution imagery could be reused) with descriptive alt text. |
| CT11 | Sitewide template (every page) | **Minor** | Mega-menu column labels ("Emergency Appeal", "Seasonal Giving", "Islamic Giving", "Programs", "Impact for Good", "Stories & Values") are marked up as literal `<h4>` tags appearing before each page's actual content headings — pollutes the semantic heading outline sitewide. | Change nav/menu column labels to non-heading elements (`<span>`/`<div>`) with equivalent styling. |
| CT12 | 10 Our Work subpages | **Good / confirms prior fix** | Every subpage has exactly 1 H1, correct H1→H2→H3 nesting, and substantive word counts (268–1091 words; `empowering-livelihoods` is thinnest at 268 words — still above the thin-content threshold but flagged for an optional editorial pass). This confirms the recent "batch 1/3–3/3" migration commits **did resolve** the previously-thin Our Work content. | No fix required; only the parent hub page (CT4) was missed by that migration. |
| CT13 | `/faq/`, `/about/` | Pass | Exactly 1 H1, logical heading order, solid word counts (502 / 662 words). | No action needed. |

---

## 9. Security / Trust Signals

| # | Page/URL | Severity | Description | Recommended fix |
|---|---|---|---|---|
| SEC1 | `/xmlrpc.php` | **Critical** | XML-RPC is live and fully functional — a `system.listMethods` POST returns a complete method list including **`system.multicall`**, which specifically enables brute-force-amplification attacks (thousands of login attempts in a single HTTP request) and pingback-based DDoS/SSRF. A bare GET returns 405, which can look "blocked" at a glance but isn't. | Block `/xmlrpc.php` entirely via `.htaccess` deny rule, a security plugin, or `add_filter('xmlrpc_enabled','__return_false')`, unless Jetpack or another integration genuinely needs it — in which case at minimum disable `system.multicall`. |
| SEC2 | `/readme.html` | **Minor** | Standard "WordPress › ReadMe" page is exposed (200), confirming the CMS/default install structure to any scanner (no exact version number visible in text). | Delete or block via `.htaccess` — standard WP hardening step. |
| SEC3 | `/license.txt` | **Minor** | Standard GPL license file exposed (200) — low risk alone, but combined with SEC2 signals the install hasn't had basic hardening applied. | Block or delete alongside `/readme.html`. |
| SEC4 | Homepage `<head>` | **Minor** | `<meta name="generator" content="Elementor 3.35.4; features: ...">` publicly discloses the exact Elementor version, letting an attacker check it against known Elementor CVEs. | Strip generator meta tags (`remove_action('wp_head','wp_generator')` plus an Elementor-specific filter); keep Elementor itself patched regardless. |
| SEC5 | SSL certificate | **Minor / informational** | Valid Let's Encrypt cert, `notAfter = Sep 13 2026` — ~47 days remaining as of this audit, not expired or imminent, but a 90-day cert. | Confirm Hostinger's auto-renewal is actually active so it doesn't lapse around 2026-09-13. |
| SEC6 | `/wp-content/uploads/` | Pass | Returns 403 — directory listing is disabled. | No action needed. |
| SEC7 | `/.env`, `/wp-config.php.bak`, `/wp-config.php~`, `/wp-config-backup.php`, `/.git/config`, `/debug.log`, `/wp-content/debug.log` | Pass | All return 404/403 with no content leaked. The 403 on dot-paths (`.htaccess`, `.git/config`) is a targeted block, not a blanket rule (a genuinely nonexistent dotfile returns 404) — good defensive behavior, though it can't fully distinguish "blocked because present" from "blocked by a generic rule" from the outside. Worth a server-side sanity check that no `.git` directory is actually deployed in the production docroot. | No urgent action; optional server-side confirmation. |
| SEC8 | Homepage, `/donate/` | Pass | No mixed content found (zero `http://` src/href references). Cross-ref URL Structure U4. | No action needed. |

---

## Overall Priority List — top issues that would move the needle most

Ranked across all categories by combined SEO impact, site-wide reach, and (for a donation-driven nonprofit) donor-trust/financial risk:

1. **[Security] SEC1 — XML-RPC + `system.multicall` enabled.** Live, exploitable brute-force/DDoS vector on production. Highest-severity item on the list regardless of SEO framing.
2. **[Internal Linking] I3 — `/bank-detail/` orphan page shows a different, stale UPI ID than the real `/bank-details/` page.** A donor could pay to the wrong/defunct handle. This is a money-safety issue wearing an SEO hat — treat as urgent independent of its "Critical" SEO label.
3. **[Content] CT1 — Homepage has zero `<h1>` tags.** The single most-visited page on the site has no primary heading at all — a foundational on-page SEO defect.
4. **[Meta Tags] M1 — 50% of audited pages (including the homepage) have no meta description whatsoever.** Directly suppresses click-through from search results sitewide.
5. **[URL Structure / Internal Linking] U1 / I2 — `/home-2/` is a fully indexable duplicate of the homepage,** actively risking duplicate-content cannibalization of the real homepage.
6. **[Performance] P2 — LiteSpeed page caching is not active for HTML.** Every page load, including every crawler visit, is regenerated from scratch — a sitewide speed and Core Web Vitals tax with a straightforward fix.
7. **[Performance / Mobile-CWV] P1 / CW1 / CW2 — Homepage hero image is a 1.9MB, unsized JPEG/WebP** driving both a slow LCP and a CLS shift on the site's top page — the single highest-leverage image fix available.
8. **[Content / Meta] CT2 / CT3 / M2 / M3 — Multiple published blog posts contain literal unedited placeholder or AI-content-brief text** ("Meta Description:", "Slug: /...", "Voice Search Questions to Target (H2)") currently live and indexed — a real brand/credibility risk if a prospective donor lands on one.
9. **[Internal Linking] I1 — The `/our-work/` hub page is unreachable from primary navigation** (nav points to `/our-work/impact` instead) and has almost no content of its own — breaks the structure of a core site section.
10. **[Schema] S1 — `/faq/` has 18 real, ready-to-mark-up Q&A pairs but zero `FAQPage` schema** — a high-value, low-effort missed opportunity for FAQ rich results.

**Close runners-up worth folding into the same batches:** I4/M4 (duplicate "Community Kitchen" blog posts actively cannibalizing each other via the Recent Posts widget) and S2 (invalid India postal address in the site-wide Organization schema, affecting every page's Rich Results eligibility).

---

## Phase 2 status

**Not started.** Per the standing rules for this audit:
- No changes to `aamir306/my-sweet-page-09` (reference repo).
- Git checkpoint before any major change.
- No content changes without Ahmad's explicit sign-off — content gaps (e.g. CT2, CT4) are flagged above, not silently rewritten.
- Fixes will be applied one issue (or tightly-related group) at a time, each with a before/after note and technical reasoning, deployed and verified, then paused for confirmation before continuing.

**Priority list approved by Ahmad on 2026-07-29. Phase 2 is in progress.** Deploy access: FTPS (explicit TLS) to Hostinger, FTP-only — no wp-admin/DB access available this session. All changes below were backed up (before/after) locally under `backups/<fix-name>-20260729-1/` prior to upload, and verified live immediately after.

---

## Phase 2 fix-log

### Fix #1 — SEC1: XML-RPC / `system.multicall` — ✅ Done
The `add_filter('xmlrpc_enabled', '__return_false')` already in `inc/security.php` (committed 2026-06-29, never actually blocked `system.listMethods`/`system.multicall`/`pingback.ping`, since that filter only gates *login-based* XML-RPC methods) was superseded with a hard block at the web-server level: `<Files xmlrpc.php>Deny from all</Files>` added to root `.htaccess`. Verified: `GET`/`POST /xmlrpc.php` → 403 (was 405 / full method list). No regressions.

### Fix #2 — I3: `/bank-detail/` stale UPI ID — ✅ Done
Orphaned page `/bank-detail/` (singular) was showing an extra, stale UPI handle (`42818355421@sbi`) alongside the current one — a donor-trust/financial-integrity risk. Fixed via `Redirect 301 /bank-detail /bank-details` in `.htaccess`. Verified: 301 → `/bank-details/` → 200, correct UPI only.

### Fix #3 — CT1: Homepage missing H1 — ✅ Done
Homepage had zero `<h1>` tags. Added `<h1 class="sr-only">No one should sleep hungry — Daan Foundation</h1>` to the hero section in `front-page.php`, reusing the theme's existing `.sr-only` utility class and the exact text already used as the hero image's `alt` attribute — a purely technical fix with zero visual change. Flagged for Ahmad: a *visible* headline over the hero would generally be better for SEO/UX, but that's a design decision, not made here.

### Fix #4 — M1: 20 pages missing meta description — ✅ Done
Added a `rank_math/frontend/description` filter (new `inc/seo-fixes.php`) that supplies a description **only** when Rank Math has none set — never overwrites an existing one (verified against `/zakat/`, which was untouched). Text reused each page's own existing hero/subtitle copy from `inc/page-content.php` or its live template, not newly authored, except for `/zakat-calculator/` and `/our-work/` which got a short factual description of page contents. All 20 pages verified live.

### Fix #5 — U1/I2: Duplicate `/home-2/` homepage — ✅ Done
`/home-2/` (WP page ID 95, an orphaned 2024 Elementor draft) was live, indexable, and a wholesale duplicate of the homepage. Fixed with `Redirect 301 /home-2 /` in `.htaccess`, plus a `rank_math/sitemap/entry` filter excluding it from the sitemap (confirmed exact Rank Math filter/hook names by reading the plugin's own source on the server). Stale sitemap cache files were deleted via FTP to force regeneration. Verified: 301 → `/` → 200; `page-sitemap.xml` no longer lists it.

### Fix #6 — P2/P3: Caching — ✅ P3 done, ⚠️ P2 partial (flagged for manual follow-up)
**P3 (CSS/JS):** `Cache-Control: no-cache, must-revalidate` (self-defeating alongside a 7-day `Expires`) changed to `public, max-age=3600, must-revalidate`. Deliberately 1 hour, not the 7 days originally suggested — `?ver=` cache-busting is stripped in `security.php`, and this repo has a history of stale-CSS bugs after manual FTP deploys, so staleness risk is capped rather than maximizing cache duration. Verified live.

**P2 (HTML page cache):** No caching plugin (LiteSpeed Cache/LSCWP) is installed, and this session has FTP-only access — plugin installation requires activating via wp-admin/DB, which isn't available here. Built the safest available `.htaccess`-only approximation instead: `X-LiteSpeed-Cache-Control: public,max-age=600` + `CacheLookup on`, scoped to a fixed whitelist of static pages only (home, about, faq, contact, all 10 Our Work pages, all campaign pages), with verified hard bypasses for query strings, logged-in cookies, WooCommerce cart cookies, and every dynamic/WooCommerce page (donate, donate-now, checkout, cart, my-account, donor-dashboard, zakat-calculator, appeals, news, blog posts, products). Ahmad reviewed and approved keeping this in place.

**⚠️ Flagged — needs manual follow-up:** even with the header and `CacheLookup on` correctly set, `X-LiteSpeed-Cache: hit` never appeared on repeat requests — meaning it's unverifiable from outside whether Hostinger's shared-hosting LiteSpeed instance actually has the LSCache module enabled to act on it. **To properly complete P2:** someone with wp-admin access should install the official **LiteSpeed Cache** plugin from the WordPress plugin directory and configure it with these exclusions (derived from the `.htaccess` whitelist logic above): exclude `/donate/`, `/donate-now/`, `/checkout/`, `/cart/`, `/my-account/`, `/donor-dashboard/`, `/zakat-calculator/`, `/appeals/`, all WooCommerce product/cart/checkout pages, and anything for logged-in users — the plugin handles this exclusion + auto-purge-on-update far more reliably than a hand-written `.htaccess` rule can. The current `.htaccess` block can stay in place (harmless either way) or be removed once the plugin takes over; either is fine.

---

**>>> Phase 2 in progress. Continuing to the next approved priority item. <<<**
