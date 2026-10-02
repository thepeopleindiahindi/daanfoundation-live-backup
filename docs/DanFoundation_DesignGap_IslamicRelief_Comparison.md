# Dan Foundation — Design Inspiration Gap Analysis (vs islamic-relief.org/sadaqah)
Compares daanfoundation.in against the original design inspiration source 
(islamic-relief.org) to find design elements that were planned/intended 
but never fully implemented on the live site. Broken into phases — review 
and confirm each phase before the next one starts.

**Important note on scope:** This is a DESIGN-PATTERN comparison only — 
layout structure, spacing, color usage, section arrangement. Do NOT copy 
any of Islamic Relief's actual text/copy, images, logos, or branding. 
Daan Foundation's own content, name, and matter stay exactly as they are 
— only structural/visual layout ideas are being referenced, the same way 
they were used as inspiration when the site was first redesigned.

---

```
TASK: Compare daanfoundation.in's current live design against 
islamic-relief.org/sadaqah (the original design inspiration source used 
when this site was first built) and identify design elements that were 
intended to be adopted but were never fully implemented, or were 
implemented inconsistently, on the live WordPress site.

SCOPE BOUNDARY (read before starting):
- Only compare LAYOUT/STRUCTURE/VISUAL PATTERNS — section arrangement, 
  spacing, color usage, split-layout patterns, background treatments, 
  card/board designs.
- Do NOT copy, reproduce, or reference any of Islamic Relief's actual 
  text, copy, images, logos, or brand-specific content in any fix.
- All content, wording, brand name, and data on daanfoundation.in stays 
  exactly as-is — only the visual/structural presentation may change.

SPECIFIC ISSUE ALREADY FLAGGED (start here):
On inner/sub pages, the payment/donation board section currently splits 
awkwardly — roughly half the section is the payment board and half is a 
photo, in a way that doesn't look intentional or polished. Compare this 
specific section against islamic-relief.org/sadaqah's equivalent donation 
section to see how they balance photo + payment-board layout, and note 
what's different (proportions, alignment, card styling, etc.).
Also check: theme background color (green #1B6B3A / gold #C9963A / black) 
usage — it currently appears inconsistently as a background across 
different sections/pages. Compare against how islamic-relief.org uses 
background color blocking/sectioning for visual rhythm, and note where 
Daan Foundation's usage feels inconsistent or accidental rather than 
deliberate.

METHOD:
1. Fetch and review islamic-relief.org/sadaqah's live structure (layout 
   sections, color blocking patterns, donation-board + photo layout, 
   spacing rhythm).
2. Fetch/review daanfoundation.in's equivalent pages and sections.
3. Produce a numbered gap list: [Gap #] [Page/Section] [What the 
   inspiration site does] [What Daan Foundation currently does] 
   [Suggested fix] — this is a DESIGN list, not a code list yet.

PHASED EXECUTION:
Because this spans many inner pages, break the work into phases (up to 
10, as needed). Suggested phase breakdown — adjust if the actual page 
count differs:

  Phase 1 — Analysis only: produce the full numbered gap list (per METHOD 
  above) covering: donation/payment board + photo split layout (the 
  specific issue flagged), and background color usage patterns, across 
  ALL inner pages (About, Contact, Zakat, Appeals, Water, Orphan 
  Sponsorship, Bank Details, Donate, Where We Work, /our-work/* pages, 
  Blog/News). Do NOT fix anything yet in this phase.
  
  >>> PAUSE after Phase 1. Ahmad reviews the gap list and confirms which 
      gaps to fix and in what order before any code is written. <<<

  Phase 2 onward — Fix ONE page or ONE gap-type per phase (Ahmad's choice 
  after reviewing Phase 1's list — e.g. Phase 2 = fix the payment-board 
  split-layout issue on Zakat page only; Phase 3 = same fix applied to 
  Appeals page; Phase 4 = background color consistency pass on X pages; 
  etc.). For each phase:
    - State which page/gap this phase covers
    - What was wrong (before)
    - What was changed (files + exact CSS/markup changes)
    - Physical difference before vs after (with screenshot if possible)
    - PAUSE and wait for Ahmad's confirmation that the change is visible 
      and correct on the live page before starting the next phase.

RULE: Same as all previous phases in this project — no item marked 
"Fixed" without a before/after description. Do not skip the Phase 1 
pause — the full gap list must be reviewed and approved before any code 
changes begin.
```
