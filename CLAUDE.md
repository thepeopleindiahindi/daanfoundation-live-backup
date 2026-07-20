# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this repo is

The website for Daan Foundation (daanfoundation.in), an India-based nonprofit. It is currently **three overlapping things in one tree**, at different stages of a migration:

1. **A React SPA** — Vite + React 18 + TypeScript, built and FTP-deployed to Hostinger by CI. **This is NOT the live site**, despite being the thing CI actually builds and deploys — see "Live site vs. this repo's build pipeline" below.
2. **A hand-rolled PHP/MySQL blog API** (`public/api/`) that the SPA's `/news` section talks to — not WordPress, a custom `blog_posts`/`blog_categories`/`blog_tags` schema.
3. **A WordPress theme** (`wp-content/themes/daan-custom/`) — **this is what's actually live** on daanfoundation.in (confirmed 2026-07-20). The "in-progress migration" framing below is about this repo's workflow, not about whether it's live.

Don't assume "the site" means only one of these; check which layer a task actually concerns before editing.

### Live site vs. this repo's build pipeline (read this before touching "the live site")

**daanfoundation.in currently serves WordPress** — Elementor + Rank Math, running the `daan-custom` theme — **not the React SPA.** Verify this yourself before trusting it, since it can drift again: `curl -sI https://daanfoundation.in/` should show `X-Powered-By: PHP`, a `Link: <.../wp-json/>` header, and Rank Math's generator meta tag in `<head>`.

Consequences:
- Editing `index.html` / `src/` and letting CI build+deploy `dist/` to Hostinger **has no effect on what daanfoundation.in actually renders** — WordPress answers the request dynamically before any static SPA file would matter. The CI deploy still runs and "succeeds," which makes this easy to miss.
- The remote actually wired to that CI is the `backup` git remote (`github.com/thepeopleindiahindi/daanfoundation-live-backup`) — confirmed via its successful "Build & Deploy to Hostinger" workflow runs. The `origin` remote (`github.com/aamir306/my-sweet-page-09`) is dead (404 on GitHub) and should not be pushed to.
- There is **no CI/CD for the WordPress theme**. Changes to `wp-content/themes/daan-custom/` only reach production via **manual FTP** directly to the live server. (FTP credentials used to live in a plaintext `ftp_upload.txt` at the repo root — that file has been deleted and gitignored, commit `ccca3f9`. Any future FTP deploy should pull credentials from somewhere secure, not a committed/repo-root file.)
- **Google Search Console verification** for daanfoundation.in is done via an HTML meta tag (`google-site-verification`) injected through a `wp_head` action hook in the live theme's `functions.php`. Do not remove that hook — doing so drops the verification and Search Console will flag the property as unverified.

## Commands

Run from the repo root (this is the Vite project root, not `my-sweet-page-09/`):

- `npm run dev` — Vite dev server on port 8080; proxies `/api` and `/images` to `http://localhost` (see `vite.config.ts`), so a local PHP server needs to be running on port 80 for blog/API features to work in dev.
- `npm run build` / `npm run build:dev` — production / dev-mode build to `dist/`.
- `npm run lint` — ESLint (flat config, `eslint.config.js`).
- `npm run test` — Vitest, single run. `npm run test:watch` for watch mode.
- Single test file: `npx vitest run src/path/to/file.test.ts`
- `npm run preview` — preview the production build locally.

There is no local WordPress or PHP dev command in `package.json` — see `docs/local-dev-setup.md` for standing up the WP/theme side locally (XAMPP/Laragon + MySQL).

## Deployment

`.github/workflows/deploy-hostinger.yml` runs on every push to `main`: `npm install && npm run build`, then FTPS-deploys `./dist/` to the Hostinger webroot. **No lint or test gate in CI** — broken code can reach production on merge.

`scripts/go-live.sh`, `backup.sh`, `rollback.sh`, `import-pages.sh` are for the *separate* WordPress cutover (require WP-CLI and a real server; not runnable locally as-is — `SITE_ROOT` etc. are placeholder paths).

## Frontend architecture (`src/`)

- `src/App.tsx` is the single route table — every page is registered here under `MainLayout` (`src/components/layout/MainLayout.tsx`: Header + Footer + scroll-to-top on navigation).
- `src/lib/routes.ts` — the `ROUTES` constant is the source of truth for paths; prefer it over hardcoded route strings.
- `src/pages/` — one file per route. `src/pages/ourwork/` holds the "Our Work" subsection pages, routed under `/our-work/*`.
- `src/components/layout`, `sections`, `donation`, `ui` — `ui/` is shadcn/Radix primitives (`components.json` controls the shadcn aliases/paths); `sections/` are page-building blocks (Hero, CampaignCards, ImpactStats, NewsGrid, QuickActions, PartnerLogos); `donation/` has the Zakat calculator and donation sidebar/layout.
- `src/lib/blog-api.ts` — typed fetch wrapper for the PHP blog API described below.
- `src/data/` — static content (`appeals.ts`, `faqs.ts`, `news.ts`) not backed by the DB.
- Path alias `@/` → `src/` — defined in `vite.config.ts`, `tsconfig.json`, `vitest.config.ts`, and `components.json`; keep all four in sync if it ever changes.
- Tests live next to nothing in particular — `src/test/` has global setup (`setup.ts`, jest-dom + `matchMedia` mock) wired via `vitest.config.ts`; test files match `src/**/*.{test,spec}.{ts,tsx}`.

## Blog API (`public/api/`)

Custom PHP endpoints (`blog/posts.php`, `blog/categories.php`, `blog/tags.php`, `blog/upload.php`, `login.php`/`logout.php`/`check-auth.php`), using `mysqli` prepared statements against `db-config.php` + `admin-config.php`. This is what `src/lib/blog-api.ts` and `/news` actually call — it is **not** WordPress.

- `public/api/db-config.php` has live production MySQL credentials committed in plaintext, and ships as-is into `dist/`/production. Treat it as sensitive; don't paste its contents into chat or commits unnecessarily.
- `scripts/publish-blog.js` publishes an article against the **live** site (`https://daanfoundation.in`, hardcoded `BASE_URL`) via `login.php` → `posts.php`, reading `ADMIN_PASSWORD` from the root `.env`. It is not a local/dev tool — running it affects production content. Article JSON shape is in `scripts/article-template.json`.

## WordPress migration track (`wp-content/themes/daan-custom/`, this IS live — see above)

A theme built from scratch (`functions.php`, `header.php`/`footer.php`, `page.php`, `single.php`, `archive.php`, `inc/customizer.php`, `inc/blocks.php`, `template-parts/`). `docs/functionality-migration-guide.md` maps each SPA feature to its WP equivalent (Razorpay via WooCommerce, WPForms for contact, Mailchimp/WP Mail SMTP for newsletter/email, `inc/snippets.php` for 80G donation receipts). Other docs worth checking before touching this track: `docs/asset-inventory.md`, `docs/design-tokens.md`, `docs/url-redirect-map.csv`, `docs/security-hardening.md`, `docs/qa-checklist.md`, `docs/post-launch-monitoring.md`, `docs/smtp-config.md`.

The theme's Tailwind CSS is built **separately** from the SPA's — see Known Issues below, this is where it gets confusing.

## `.github/agents/*.md` and design system

Copilot subagents split page-building by concern: `page-coordinator` orchestrates `layout-architect`, `donation-flow`, `content-sections`, and `navigation`. The actual design-system rules (brand colors — orange/amber primary, emerald buttons, slate neutrals; spacing scale; page rhythm: sticky header → hero → alternating sections → dark footer) live in `.github/copilot-instructions.md` — read it before building new page sections, it's the single source of truth for visual conventions regardless of which agent (or Claude) is doing the work.

## Known issues / gotchas

- **`tailwind.config.ts` no longer covers the React app.** Commit `808f343` ("replace Tailwind CDN with local pre-built CSS") repurposed the root `tailwind.config.ts` for the WordPress theme's build: its `content` globs now only scan `wp-content/themes/daan-custom/**`, not `src/**/*.tsx`, and it dropped the shadcn theme extensions (`darkMode`, `container`, `colors`, `fontFamily`, animation keyframes) the React app's components rely on. If Tailwind utility classes look unstyled in a fresh `npm run build` of the SPA, this is almost certainly why.
- **`public/.htaccess` has a WordPress permalink rewrite block** (`RewriteRule . /index.php`) that gets copied verbatim into `dist/` and FTP'd to production. The React build only ships `index.html`, not `index.php` — this can break direct URL loads/refreshes on SPA routes other than `/`.
- **`my-sweet-page-09/` is a git submodule** containing a near-duplicate copy of this same project (same file names, its own `.git`). It's not a subdirectory of the live app — edits belong in the repo root unless you're intentionally updating the submodule.
- **Root-level clutter**: numerous one-off artifacts from prior scrape/debug/backup sessions live at the repo root (`wp-login-result*.html`, `temp_*.txt`, `tmp_*.txt`, `*.BACKUP-*.php`, `*.LIVE-BACKUP.php`, `wp-cookies.txt`, `output.txt`, `.docx`-derived content dumps, a 39MB `II update.zip`). These are not part of the build — don't assume they're referenced anywhere before deleting or editing them. (`ftp_upload.txt`, formerly in this list, has been deleted and gitignored — see "Live site vs. this repo's build pipeline" above.)
