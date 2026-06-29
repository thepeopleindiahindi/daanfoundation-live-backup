# Daan Foundation — Design Tokens

> Extracted from the React (Vite + Tailwind v3.4 + shadcn/ui) frontend.
> Migrate these values into `theme.json` and `style.css` for the WordPress custom theme.

---

## 1. Brand Colors (HSL)

All colors defined as CSS custom properties in `src/index.css`. The base is a white background with an orange primary.

| Token | HSL Value | Tailwind Class | Hex Equivalent |
|---|---|---|---|
| `--primary` | `25 95% 53%` | `bg-orange-500` / `text-orange-500` | #F97316 |
| `--primary-foreground` | `0 0% 100%` | `text-white` | #FFFFFF |
| `--foreground` | `0 0% 6.7%` | `text-slate-900` | #111111 |
| `--background` | `0 0% 100%` | `bg-white` | #FFFFFF |
| `--secondary` | `220 13% 96%` | `bg-gray-100` / `bg-[#F3F4F6]` | #F3F4F6 |
| `--secondary-foreground` | `0 0% 6.7%` | — | #111111 |
| `--muted` | `220 13% 96%` | — | #F3F4F6 |
| `--muted-foreground` | `0 0% 40%` | `text-slate-600` | #666666 |
| `--accent` | `33 100% 97%` | `bg-[#FFF7ED]` | #FFF7ED |
| `--accent-foreground` | `0 0% 6.7%` | — | #111111 |
| `--card` | `0 0% 100%` | `bg-white` | #FFFFFF |
| `--card-foreground` | `0 0% 6.7%` | — | #111111 |
| `--border` | `220 13% 91%` | `border-gray-200` | #E5E7EB |
| `--input` | `220 13% 91%` | — | #E5E7EB |
| `--ring` | `25 95% 53%` | `ring-orange-500` | #F97316 |
| `--radius` | `0.5rem` | `rounded-lg` (8px) | 8px |
| `--destructive` | `0 84.2% 60.2%` | `bg-red-500` | #EF4444 |

### Component-specific colours

| Usage | Value | Tailwind |
|---|---|---|
| Section bg light | `#F3F4F6` | `bg-[#F3F4F6]` |
| Section bg warm | `#FFF7ED` | `bg-[#FFF7ED]` |
| CTA overlay | `#F97316 / 90%` | `bg-orange-500/90` |
| Gradient overlay (cards) | `from-slate-900 via-slate-900/40 to-transparent` | Tailwind gradient |
| White overlay (light text bg) | `white/20 backdrop-blur-sm` | Badge on images |
| Orange CTA buttons | `#F97316` bg, `white` text | Default primary |

---

## 2. Typography

| Property | Value | Source |
|---|---|---|
| Font family | `'Open Sans', ui-sans-serif, system-ui, sans-serif` | `tailwind.config.ts` + `index.css` |
| Base body size | `16px` (default) | Browser default |
| Paragraph alignment | `justify` | `index.css` `p, .prose p, .description, .leading-relaxed` |
| Heading alignment | `left` (unless parent has `.text-center`) | `index.css` |

### Heading sizes (from usage across components)

| Level | Desktop | Mobile | Weight |
|---|---|---|---|
| H1 (Hero title) | `text-4xl` (36px) md:`5xl`(48px) | `text-3xl`(30px) | `font-bold` |
| H2 (Section title) | `text-3xl`(30px) md:`4xl`(36px) | `text-2xl`(24px) | `font-bold` |
| H3 (Card title) | `text-xl`(20px) or `text-2xl`(24px) | same | `font-bold` |
| Body / Description | `text-lg`(18px) or `text-base`(16px) | same | `text-slate-600` |
| Small / Meta | `text-sm`(14px) | same | various |

### Line heights
- Headings: `leading-tight` (approx 1.25)
- Body paragraphs: `leading-relaxed` (approx 1.625)

---

## 3. Spacing & Grid

| Concept | Value |
|---|---|
| Max content width | `max-w-7xl` (1280px) |
| Page X padding | `px-4 sm:px-6 lg:px-8` |
| Section Y padding | `py-16 md:py-24` (64px / 96px) |
| Card gap (3-col) | `gap-6` (24px) |
| Card gap (4-col) | `gap-6` (24px) |
| Container padding (max) | `2rem` (from `tailwind.config.ts`) |
| Card border radius | `rounded-2xl` (16px) |
| Image border radius | `rounded-xl` (12px) or `rounded-2xl` (16px) |
| Badge border radius | `rounded-full` (pill shape) |
| Button radius | `rounded-full` (pill) or `rounded-xl` (12px) |

### Grid patterns
- **3-column**: `md:grid-cols-2 lg:grid-cols-3 gap-6` (program cards)
- **4-column**: `sm:grid-cols-2 lg:grid-cols-4 gap-6` (campaign cards)
- **2+4 gallery**: `grid-cols-2 md:grid-cols-4` (hero image + 4 squares)
- **6-bottom gallery**: `grid-cols-3 md:grid-cols-6`

---

## 4. Component-specific Layout

### Program Cards (HomePage "Our Programs")
```
Aspect ratio: aspect-[4/5]
Image: absolute inset-0, object-cover, scale-105 on hover
Overlay: gradient-to-t from-slate-900 via-slate-900/40 to-transparent
Content: absolute bottom-0 p-6
Badge: inline-block px-3 py-1 [color]-500 bg, white text, rounded-full, mb-3
Title: text-2xl font-bold text-white mb-2
Desc: text-white/80
```

### Campaign Cards
```
Card: bg-white rounded-2xl overflow-hidden, shadow-sm hover:shadow-xl
Image wrapper: aspect-[4/3] overflow-hidden
Image: object-cover, scale-105 on hover
Overlay: gradient-to-t from-slate-900/60
Progress bar: h-1.5 bg-white/30 rounded-full with orange-500 fill
Content padding: p-5
Title: font-bold text-slate-900, hover:text-orange-500
```

### Hero Slideshow
```
Full viewport width, slides as CSS backgroundImage
Overlay: dark gradient (from-black/60 to-transparent)
Slide interval: 3.5s crossfade
Donation widget: right side panel (absolute positioned)
```

### Impact Stories
```
Full-bleed aspect-[4/5] cards
Same image/card pattern as Program Cards
Optional play button overlay (h-16 w-16 rounded-full bg-white/90)
Category badge: bg-white/20 backdrop-blur-sm
```

### Photo Gallery
```
First item: col-span-2 md:row-span-2, full coverage
Small items: aspect-square, object-cover, rounded-xl
```

---

## 5. Effects & Transitions

| Effect | CSS/Tailwind |
|---|---|
| Hover zoom | `group-hover:scale-105 transition-transform duration-500` |
| Shadow lift | `hover:shadow-xl transition-all duration-300` |
| Crossfade slides | `transition-opacity duration-700` |
| Icon scale | `group-hover:scale-110 transition-transform` |
| Arrow slide | `group-hover:gap-2 transition-all` (or `group-hover:translate-x-1`) |
| Image quality | `image-rendering: auto` (NOT crisp-edges) |
| Smooth rendering | `-webkit-font-smoothing: antialiased`, `backface-visibility: hidden` |

---

## 6. Breakpoints (Tailwind defaults)

| Name | Min-width | Device |
|---|---|---|
| `sm` | 640px | Mobile landscape |
| `md` | 768px | Tablet |
| `lg` | 1024px | Desktop |
| `xl` | 1280px | Large desktop |
| `2xl` | 1400px (container max) | Wide |

---

## 7. Icons

- Library: **Lucide React** (`lucide-react`)
- Common icons used: `Heart`, `Calculator`, `HandHeart`, `Utensils`, `Users`, `Moon`, `Gift`, `ArrowRight`, `Play`, `Menu`, `X`
- Sizes: `h-5 w-5` (buttons), `h-6 w-6` (play button), `h-7 w-7` (feature cards)
- Icon colors: Primary `text-orange-500`, white on dark backgrounds

---

## 8. Image Patterns

| Pattern | Usage |
|---|---|
| `object-cover` | All display images (fill container, maintain aspect ratio) |
| `absolute inset-0` | Card background images |
| `aspect-square` | Gallery thumbnails, profile images |
| `aspect-[4/3]` | Campaign card images |
| `aspect-[4/5]` | Program cards, impact story cards |
| Hover zoom on parent group | Every card with an image |
| Gradient overlay | Every card image for text readability |
