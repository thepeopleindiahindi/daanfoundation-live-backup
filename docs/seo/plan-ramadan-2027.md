# SEO plan: Ramadan 2027 (Daan Foundation)

Updated: 23 Nov 2026. Decisions: docs/fiqh/decisions.md D-036c, D-037a, D-038, D-039, D-040. Research and data (gitignored): reports/seo-ramadan-2027/.

## Targets

- India only (D-038). Two main products: **Ramadan Iftar** (hub /ramadan/, one month) and **Ration Kit** (hub /ration-kit-distribution-india/, all year).
- Facts used everywhere: founded 2020; team 12–15 years of community service; Community Kitchen in Amroha feeds 100–120 people every day; iftar for 200–300 people every day in Ramadan; prices from settings (meal ₹60, iftar kit ₹91, ration kit ₹1,536).

## Done (live, 23 Nov 2026)

### Technical
- 301 (one hop): /shop/ → /donate/, /photogallery/ → /our-work/ (D-036c); earlier 404s fixed (D-036b). /product/test-product/ stays 404. Literal `/*`, `/wp-admin/*`, `/wp-*.php` in GSC ignored.
- Feeds: `X-Robots-Tag: noindex, follow`. robots.txt: `Disallow: /*?wc-ajax=` and `/search/` (all bots incl. Googlebot).
- noindex: /category/blog/, /product-category/* (URLs unchanged).
- Thin products now 100–120 words of true text: Sadaqah, Sadaqah Jariyah, Where Most Needed, General Donation ("All proceeds go directly…" claim removed).
- Internal links: "Related reading" box on iftar / ration / kitchen posts (hub + siblings); /ramadan/ "Read more" list; ration hub links to all ration posts.
- Lighthouse (mobile): /ramadan/ 96 perf, a11y 100, SEO 100; ration hub 99/96→fixed/100; new post 99/96→fixed/100; ration product 97/100/100; CLS 0 everywhere. Sidebar widget active button contrast fixed (#C2410C).
- Schema: Product + Offer (INR, price from setting) on products; FAQPage on /ramadan/ (11 Q, 6 Hinglish) and ration hub (9 Q, 6 Hinglish); Organization description (D-037a).

### Content
- New posts (published): /whats-inside-iftar-kit/, /ration-kit-list-price/, /sood-ka-paisa-kahan-de-bank-interest-ration-kit/, /roza-iftar-karane-ka-sawab/, /can-zakat-be-given-as-ration-kit/, /inside-amroha-community-kitchen/, /fitrana-2027-india-amount/ (≈580–755 words rendered each, Rank Math title/meta/keyword, donate button, hub links, Hinglish FAQ, how-to-donate and trust sections).
- Draft: /ramadan-last-10-nights-iftar/ (post 7438, publish in Ramadan); Ramadan timings page 7425 (publish when owner gives timings from an Indian institution's calendar).
- Strengthened (GSC "crawled – not indexed"): behind-the-scenes (title + figures fixed earlier), volunteers-speak and zakat-distribution-drive-2027 (new title/meta, hub links).
- Quick wins: homepage, About, community kitchen post, ₹55 post (H1 now ₹60 from setting), /kaffarah/ meta.
- Fidyah/Kaffarah: public update (D-039), "two meals at two separate times of the day".
- Ration kit: no Zakat/Sadaqah head choice, owner's "About this Ration Kit" text, grouped kit list (D-040).

## In Ramadan (later)
- Daily photo + short update on /ramadan/ (owner sends photos).
- Publish draft 7438 (last 10 nights) at the start of the last ten nights.
- Publish timings page 7425 once timings are in.
- Fitrana reminder ~5 days before Eid (social + WhatsApp); after Eid, focus back on ration kits.

## Owner tasks (files in reports/seo-ramadan-2027/owner-kit/)
1. Search Console: request indexing (25 URLs over 3 days) + resubmit sitemap — 5-request-indexing.md
2. Google Business Profile + 4 posts — 1-google-business-profile.md
3. Directories (NGO Darpan, Justdial, Give.do, Sulekha) — 2-directories.md
4. Press note (Hindi + English) — 3-press-note.md
5. 8 social posts + design brief — 4-social-posts.md
6. Review request message — 6-review-message.md
7. Checklist — 7-owner-checklist.md
8. New real photos; Ramadan timings from an Indian institution.

## Needs owner OK (not done)
- None open for redirects. Any new redirect / delete / noindex still needs owner OK (URL rule).
- Competitor research could not be verified on Google India (search tool limit, US results); manual check of top results is still pending.
