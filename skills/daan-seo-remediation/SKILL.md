# Daan Foundation SEO Remediation

## Scope and authority

Use only for `D:/claude/daan`. Production is WordPress at `https://daanfoundation.in`; the repository React/Vite build is not the live rendering layer. Read `CLAUDE.md` and these reports before work: `reports/site-architecture-baseline.md`, `reports/master-url-inventory.md`, `reports/technical-seo-audit.md`, `reports/final-site-closure-audit.md`, `reports/master-seo-remediation-tracker.md`, `reports/final-open-issues-register.md`, `reports/seo-action-plan.md`, and `reports/seo-batch-plan.md`.

Treat dated findings as historical until a current public check reproduces them. A 200 response never proves indexing, ranking, content quality, or visual/functional correctness.

## Method

Audit homepage, main static/service/program pages, shared templates, and conversion templates before blogs. Audit blogs only after main pages are closed/accepted. Record stable issue IDs, source references, exact URLs/files, evidence, dependencies, status, and verification. Use search intent and approved factual sources.

Do not fabricate testimonials, impact figures, references, reviews, authors, prices, schema facts, or SEO results. Preserve brand/design, donation/checkout functionality, canonical URLs, and sensitive/factual claims. Do not mass-delete, alter URLs/slugs, make speculative redirects, change payment settings, or alter sensitive claims.

Retirement/consolidation requires URL-level GSC data, backlink/referring-domain data, historical identity evidence, owner canonical choice, relevant replacement, and a retirement manifest. Unknown is `UNRESOLVED — NO ACTION`.

## Change workflow

1. Record issue, affected URL/file, evidence, and rollback backup path before an approved edit.
2. Make the smallest focused change and preserve unrelated dirty worktree changes.
3. Supported project commands are `npm run lint`, `npm run test`, and `npm run build`; these test the React project and do not validate live WordPress. Local WordPress needs the separate PHP/MySQL/WordPress setup in `docs/local-dev-setup.md`.
4. Record **LOCAL IMPLEMENTATION**, **DEPLOYMENT**, **ORIGIN VERIFICATION**, and **PUBLIC/CDN VERIFICATION** separately. A local/source pass is not production proof.
5. Deploy only through an owner-approved path. Never invent FTP, wp-admin, WP-CLI, CDN, or cache-purge access, and never commit credentials.
6. Use the owner-provided cache purge procedure, then verify public rendered output, HTTP status, responsive state where relevant, and shared-template regressions.
7. Update tracker, closure audit, and open-issues register; commit only related, non-secret work.

