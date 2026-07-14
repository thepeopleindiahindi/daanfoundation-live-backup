# Dan Foundation — WordPress vs Original Design Cross-Verification & Fix Command

**Purpose:** Give this command as-is to Claude Code / Open Code to cross-verify
`daanfoundation.in` (live WordPress site) against the original design backup,
find all regressions, and fix them with proof (before/after screenshots).

---

```
TASK: Cross-verify daanfoundation.in (live WordPress site) against the original 
design backup, fix all visual/functional regressions in PHASES, and document 
every phase in a Markdown report.

CONTEXT:
- Original design source: GitHub repo aamir306/my-sweet-page-09 (private, React/Vite + Lovable-generated frontend)
- Live/current site: daanfoundation.in, WordPress theme "daan-custom", hosted on Hostinger
- Known already-flagged issues: oversized header button on mobile, hero image hidden 
  behind donation panel on mobile
- Goal: WordPress site should visually and functionally match the original design 
  unless a deliberate change was made for WooCommerce/WordPress functionality
- Work must proceed phase-by-phase. I will verify and approve each phase before 
  you start the next one. Do not skip ahead.

PHASE 0 — Backup the CURRENT LIVE WEBSITE first (MANDATORY, do this before anything else)
1. Take a full backup of the current live daanfoundation.in — theme folder 
   (daan-custom), uploads folder, and a database export (.sql).
2. Push this backup to a GitHub repo (new repo or a dedicated backup branch, 
   e.g. "daanfoundation-live-backup") so that if anything breaks later, we can 
   restore the site exactly as it is today.
3. Do NOT modify, push to, or write into the ORIGINAL reference repo 
   (aamir306/my-sweet-page-09) under any circumstance — that one stays 
   read-only, reference-only, separate from this new live-site backup.
4. Report back: the GitHub repo/branch name, what was included in the backup, 
   and confirm the backup is restorable before touching any live file further.
5. If cloning/pushing fails due to auth/access issues, STOP and report the 
   exact error — do not attempt workarounds.

>>> PAUSE HERE. Do not proceed to Phase 1 until I confirm the backup is done 
    and safe. <<<

PHASE 1 — Pull and run the original design reference
1. Clone aamir306/my-sweet-page-09 locally into a separate folder (do NOT touch 
   the live WordPress files)
2. Run `npm install` then `npm run dev` to boot the original design locally
3. Confirm it loads correctly and share the local URL/port used

PHASE 2 — Capture reference screenshots (original design)
Take full-page screenshots at 3 breakpoints: Desktop (1440px), Tablet (768px), 
Mobile (375px), for each of these views:
- Home page (full scroll, including hero + donation panel)
- Header/navbar (all breakpoints)
- Footer
- Any inner page (About, Services, Contact — whichever exist)
- Blog/news listing and a single blog post page
Save in: /reference-screenshots/[breakpoint]/[page-name].png

PHASE 3 — Capture current-state screenshots (live WordPress site)
Repeat the EXACT same pages and breakpoints on https://daanfoundation.in
Save in: /live-screenshots/[breakpoint]/[page-name].png

PHASE 4 — Side-by-side comparison and issue list
For each matching pair of screenshots, list every difference found:
- Layout breaks (overlapping elements, misaligned sections)
- Spacing/padding/margin mismatches
- Font size/family/weight differences
- Color mismatches
- Missing sections or elements present in original but absent in WordPress
- Broken responsive behavior (elements not stacking/resizing correctly)

Output as a numbered issue list: 
[Issue #] [Page] [Breakpoint] [Description] [Severity: Critical/Major/Minor]

>>> PAUSE HERE. Do not start fixing until I approve the issue list and the 
    order in which issues should be fixed. <<<

PHASE 5 ONWARDS — Fix issues ONE GROUP AT A TIME (Critical → Major → Minor)
Break the approved issue list into small fix-batches (e.g. one page or one 
type of issue per phase — do not fix everything in one giant phase).

For EACH phase/batch, do the fix AND write it up in the Markdown report using 
this exact structure so it can also be used to justify a "reward" to Claude 
Code / Open Code for the work done:

  ## Phase [N]: [short title of what this phase covers]
  
  **Issues addressed in this phase:** [Issue #s from Phase 4 list]
  
  **What was wrong (before):**
  - Describe the actual visual/physical problem in plain language 
    (e.g. "Header button was overflowing its container on mobile, 
    text was cut off on the right side")
  
  **What was changed:**
  - Exact file(s) edited (e.g. style.css, header.php)
  - Exact change made (e.g. "reduced button padding from 24px to 12px 
    and added max-width: 100% on mobile breakpoint")
  
  **Physical difference — before vs after (mandatory, describe clearly):**
  - Before: [what it looked like / did]
  - After: [what it looks like / does now]
  - Attach before screenshot and after screenshot side by side
  
  **Status:** Fixed / Deferred / Won't Fix (with reason)

After writing up a phase, STOP and wait for me to verify that phase before 
starting the next one.

FINAL REPORT (after all phases are approved)
Compile all phase write-ups into a single Markdown file, 5–10 pages long, 
containing:
- Table of contents (list of phases)
- Full issue list from Phase 4 with final status of each
- Every phase's before/after write-up and screenshots (as above)
- List of every file modified across all phases
- Location of the Phase 0 live-site backup (repo/branch name) so it's clear 
  a rollback is possible
- Confirmation that the original reference repo (aamir306/my-sweet-page-09) 
  was never modified

RULE: No issue may be marked "Fixed" without an actual before/after screenshot 
and a plain-language physical description of what changed. Verbal confirmation 
alone is not accepted.
```
