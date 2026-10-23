# Daily work log — Daan Foundation (daanfoundation.in)

One entry per day, appended at the end of each working day (rule in CLAUDE.md). Never edit past entries. No secrets or donor personal data.

## 2026-10-13 + 2026-10-14 (backfill, written 2026-10-23; window: thinking + execution)
- Done: Full-site audit (reports/full-site-audit-2026-10-13/, gitignored). CI push-deploy disabled in the workflow file (3541be4, the only commit pushed to `backup`). Old React `/api/`, `/admin/`, `/contact.php` and webroot leftovers moved to a private server backup. wp-console deactivated. REST users 500 fixed and users routes hidden (4bd71e9, 04eff8c). Fake "Registered Charity No. 124456" removed (35d47b4); 80G/12A/tax claims removed, receipts show PAN + no-80G note (ee83c84); footer/receipts show trust Reg. No. 149/11-20/302 (Tehsil Amroha), owner-confirmed from the trust deed (f88a2ae). Receipt page needs order key or matching e-mail (9f42c80). Sitemap/noindex fixes, 6 duplicate-page 301s, speed (913e31b, 293a856), a11y option A buttons (80c8bb0). Payment fix: pending-payment page, "I have paid" UTR form, daily on-hold digest 09:00 IST (6dc0d4c, e03bf71).
- Verified: live checks by the thinking window: /api/* 404, users endpoints 404, home/donate 200, footer Reg. No. + PAN present, workflow file has no push trigger.
- Owner actions: confirmed no 80G/12A; confirmed Reg. No. from the trust deed; ₹1 QR test before payment page go-live.
- Risks / notes: test order #7092 is cancelled and must not be counted.

## 2026-10-23 (window: thinking)
- Done: Daily-log rule added to CLAUDE.md and this log.md started (owner request).
- Open / next (owner, priority order): 1) rotate MySQL password + wp-config.php (DB password is in public GitHub history); 2) rotate SSH password + .env; 3) make GitHub repo private; 4) disable workflow in GitHub UI + delete FTP secrets; 5) confirm test e-mails and daily digest arrived; 6) ₹1 UPI-button test on GPay/PhonePe/Paytm; 7) reconcile on-hold orders (~237) with bank/UPI statement; 8) fill site-facts.md; 9) Search Console export; 10) scholar review of drafts/02. Claude side: 0 open items without owner input (tracker 52%).
- Risks / notes: local main is ahead of `backup/main` — no push until the repo is private. Before deleting either UPI plugin, confirm which one /donate/ uses. Delete ~/private-daan-backups/ (contains donor data) by 2026-11-12.
- Done (execution window): read the new CLAUDE.md log rule; from now on every working day ends with an appended entry in log.md, and log.md / CLAUDE.md are committed by explicit path.
- Verified: git tree clean apart from an untracked favicon-307.png (not ours, left alone); nothing pushed; no site changes today.
