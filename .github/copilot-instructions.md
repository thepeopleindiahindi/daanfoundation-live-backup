# Daan Foundation - POC Design System

This is a local POC project studying nonprofit website patterns. All content is placeholder.

## Brand

- **Name**: Daan Foundation
- **Tagline**: "Serving humanity with compassion"
- **Primary color**: Orange (`orange-500`, `orange-600`)
- **Accent color**: Amber/Orange (`amber-500`, `orange-600`)
- **Neutral**: Slate (`slate-50` to `slate-900`)

## Typography

- **Headings**: `font-bold` with tight tracking
- **Body**: `text-base` or `text-lg`, `leading-relaxed`
- **Hero headlines**: `text-4xl md:text-5xl lg:text-6xl`

## Spacing System

Use Tailwind's default scale consistently:
- Section padding: `py-16 md:py-24`
- Container: `max-w-7xl mx-auto px-4 sm:px-6 lg:px-8`
- Card gaps: `gap-6` or `gap-8`

## Component Patterns

### Buttons
- Primary: `bg-emerald-600 hover:bg-emerald-700 text-white`
- Donate CTA: `bg-amber-500 hover:bg-amber-600 text-white font-bold`
- Secondary: `border border-emerald-600 text-emerald-600 hover:bg-emerald-50`

### Cards
- `bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow`
- Image area with gradient placeholder
- Padding: `p-6`

### Image Placeholders
Use gradients instead of actual images:
```
bg-gradient-to-br from-emerald-600 to-teal-700  // Appeals, general
bg-gradient-to-br from-amber-500 to-orange-600  // Urgent, seasonal
bg-gradient-to-br from-blue-500 to-indigo-600   // Water projects
bg-gradient-to-br from-rose-500 to-pink-600     // Orphan care
bg-gradient-to-br from-slate-600 to-slate-800   // News, general
```

## Page Structure

All pages follow this rhythm:
1. Header (sticky, transparent → solid on scroll)
2. Hero section (full-width)
3. Content sections (alternating contained/full-bleed)
4. Footer (dark background)

## File Organization

```
src/
├── components/
│   ├── layout/          # Header, Footer, Container
│   ├── sections/        # Hero, CampaignGrid, ImpactStats
│   ├── donation/        # DonationForm, ZakatCalculator
│   └── ui/              # shadcn components
├── pages/
│   ├── Index.tsx        # Homepage
│   ├── Appeal.tsx       # Single appeal/campaign
│   ├── ZakatCalculator.tsx
│   ├── About.tsx
│   └── News.tsx
└── lib/
    └── utils.ts
```

## Accessibility

- All images need alt text (use descriptive placeholders)
- Form inputs need labels
- Buttons need meaningful text (not just "Click here")
- Color contrast ratio minimum 4.5:1
