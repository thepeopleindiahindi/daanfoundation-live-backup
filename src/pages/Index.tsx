import { useState } from "react";
import {
  Heart,
  Search,
  Menu,
  X,
  ChevronRight,
  ChevronLeft,
  Play,
  Mail,
  Phone,
  MapPin,
  Globe,
  Droplets,
  Users,
  HandHeart,
  Calculator,
  Gift,
  Briefcase,
  ArrowRight,
} from "lucide-react";

/* ─── Color tokens (Tailwind classes referencing these hex values) ────────
  🟧 Orange  #F97316  →  bg-[#F97316] text-[#F97316]
  ⬛ Black   #111111  →  bg-[#111] text-[#111]
  ⬜ White   #FFFFFF  →  bg-white text-white
  ◻️ Grey    #F3F4F6  →  bg-[#F3F4F6]
  🟫 Beige   #FFF7ED  →  bg-[#FFF7ED]
──────────────────────────────────────────────────────────────────────── */

// ─── NAV ────────────────────────────────────────────────────────────────────
const navLinks = [
  { label: "Appeals", href: "#" },
  { label: "Zakat", href: "#" },
  { label: "Sadaqah", href: "#" },
  { label: "Orphans", href: "#" },
  { label: "Where We Work", href: "#" },
  { label: "About Us", href: "#" },
];

function Header() {
  const [mobileOpen, setMobileOpen] = useState(false);

  return (
    <header className="sticky top-0 z-50 bg-white shadow-sm">
      {/* Top bar */}
      <div className="bg-[#111] text-white text-xs">
        <div className="mx-auto flex max-w-7xl items-center justify-between px-4 py-1.5">
          <span className="hidden sm:inline">Serving humanity since 1984</span>
          <div className="flex items-center gap-4">
            <a href="#" className="hover:underline">Contact Us</a>
            <a href="#" className="hover:underline">Ways to Donate</a>
          </div>
        </div>
      </div>

      {/* Main nav */}
      <div className="mx-auto flex max-w-7xl items-center justify-between px-4 py-3">
        {/* Logo */}
        <a href="#" className="flex items-center gap-2">
          <div className="flex h-10 w-10 items-center justify-center rounded-full bg-[#F97316]">
            <Heart className="h-5 w-5 text-white" fill="white" />
          </div>
          <div className="leading-tight">
            <span className="block text-lg font-bold text-[#111]">Islamic Relief</span>
            <span className="block text-[10px] tracking-widest text-[#111]/60 uppercase">Worldwide</span>
          </div>
        </a>

        {/* Desktop links */}
        <nav className="hidden lg:flex items-center gap-6">
          {navLinks.map((l) => (
            <a key={l.label} href={l.href} className="text-sm font-medium text-[#111] hover:text-[#F97316] transition-colors">
              {l.label}
            </a>
          ))}
        </nav>

        <div className="flex items-center gap-3">
          <button className="hidden sm:flex items-center gap-1.5 text-sm text-[#111] hover:text-[#F97316] transition-colors">
            <Search className="h-4 w-4" />
          </button>
          <a
            href="#"
            className="rounded-full bg-[#F97316] px-6 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-[#ea6c10] transition-colors"
          >
            Donate
          </a>
          <button className="lg:hidden" onClick={() => setMobileOpen(!mobileOpen)}>
            {mobileOpen ? <X className="h-6 w-6" /> : <Menu className="h-6 w-6" />}
          </button>
        </div>
      </div>

      {/* Mobile nav */}
      {mobileOpen && (
        <nav className="lg:hidden border-t bg-white px-4 pb-4">
          {navLinks.map((l) => (
            <a key={l.label} href={l.href} className="block py-2.5 text-sm font-medium text-[#111] hover:text-[#F97316]">
              {l.label}
            </a>
          ))}
        </nav>
      )}
    </header>
  );
}

// ─── HERO ───────────────────────────────────────────────────────────────────
function HeroSection() {
  const [amount, setAmount] = useState<number | null>(150);
  const presets = [100, 150, 300];

  return (
    <section className="relative min-h-[520px] bg-[#111] overflow-hidden">
      {/* Background image placeholder */}
      <div className="absolute inset-0">
        <img
          src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=1600&q=80"
          alt="Emergency appeal"
          className="h-full w-full object-cover opacity-40"
        />
        <div className="absolute inset-0 bg-gradient-to-r from-[#111]/90 via-[#111]/60 to-transparent" />
      </div>

      <div className="relative mx-auto flex max-w-7xl flex-col md:flex-row items-center gap-10 px-4 py-16 md:py-24">
        {/* Left copy */}
        <div className="flex-1 text-white">
          <span className="mb-3 inline-block rounded-full bg-[#F97316] px-4 py-1 text-xs font-semibold uppercase tracking-wider">
            Emergency Appeal
          </span>
          <h1 className="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-4">
            Sudan Emergency<br />Appeal
          </h1>
          <p className="max-w-lg text-white/80 leading-relaxed">
            Millions of people across Sudan are facing unimaginable suffering. Families are being displaced, children left without food, and communities torn apart. Your donation can help provide life-saving aid.
          </p>
        </div>

        {/* Donate widget */}
        <div className="w-full max-w-sm rounded-2xl bg-white p-6 shadow-2xl">
          <h3 className="mb-4 text-center text-lg font-bold text-[#111]">Make a Donation</h3>
          <div className="mb-4 flex gap-2">
            {presets.map((p) => (
              <button
                key={p}
                onClick={() => setAmount(p)}
                className={`flex-1 rounded-lg border-2 py-2.5 text-sm font-semibold transition-colors ${
                  amount === p
                    ? "border-[#F97316] bg-[#FFF7ED] text-[#F97316]"
                    : "border-gray-200 text-[#111] hover:border-[#F97316]/50"
                }`}
              >
                £{p}
              </button>
            ))}
          </div>
          <div className="relative mb-4">
            <span className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-medium">£</span>
            <input
              type="number"
              value={amount ?? ""}
              onChange={(e) => setAmount(Number(e.target.value) || null)}
              className="w-full rounded-lg border-2 border-gray-200 py-2.5 pl-8 pr-4 text-sm focus:border-[#F97316] focus:outline-none"
              placeholder="Other amount"
            />
          </div>
          <button className="w-full rounded-full bg-[#F97316] py-3 text-base font-bold text-white shadow-lg hover:bg-[#ea6c10] transition-colors">
            DONATE
          </button>
        </div>
      </div>
    </section>
  );
}

// ─── CAMPAIGNS ──────────────────────────────────────────────────────────────
const campaigns = [
  { title: "Give an Orphan a Future", image: "https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=600&q=80" },
  { title: "Lebanon Emergency Appeal", image: "https://images.unsplash.com/photo-1542838132-92c53300491e?w=600&q=80" },
  { title: "Palestine Emergency Appeal", image: "https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=600&q=80" },
  { title: "Sudan Emergency Appeal", image: "https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=600&q=80" },
  { title: "Yemen Crisis", image: "https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=600&q=80" },
];

function CampaignsSection() {
  const [scroll, setScroll] = useState(0);

  return (
    <section className="bg-[#F3F4F6] py-16">
      <div className="mx-auto max-w-7xl px-4">
        <div className="mb-8 flex items-center justify-between">
          <h2 className="text-3xl font-bold text-[#111]">Current Campaigns</h2>
          <div className="flex gap-2">
            <button
              onClick={() => setScroll(Math.max(0, scroll - 1))}
              className="flex h-10 w-10 items-center justify-center rounded-full border-2 border-[#111]/20 text-[#111] hover:border-[#F97316] hover:text-[#F97316] transition-colors"
            >
              <ChevronLeft className="h-5 w-5" />
            </button>
            <button
              onClick={() => setScroll(Math.min(campaigns.length - 1, scroll + 1))}
              className="flex h-10 w-10 items-center justify-center rounded-full border-2 border-[#111]/20 text-[#111] hover:border-[#F97316] hover:text-[#F97316] transition-colors"
            >
              <ChevronRight className="h-5 w-5" />
            </button>
          </div>
        </div>

        <div className="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
          {campaigns.map((c) => (
            <div
              key={c.title}
              className="group overflow-hidden rounded-xl bg-white shadow-md hover:shadow-xl transition-shadow"
            >
              <div className="relative h-48 overflow-hidden">
                <img
                  src={c.image}
                  alt={c.title}
                  className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                />
              </div>
              <div className="p-4">
                <h4 className="mb-3 font-semibold text-[#111] leading-snug">{c.title}</h4>
                <a
                  href="#"
                  className="inline-block rounded-full bg-[#F97316] px-5 py-2 text-xs font-semibold text-white hover:bg-[#ea6c10] transition-colors"
                >
                  Donate
                </a>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

// ─── MAXIMISE YOUR REWARD ───────────────────────────────────────────────────
const rewards = [
  { icon: Calculator, title: "Calculate Zakat", desc: "See how much zakat you owe" },
  { icon: HandHeart, title: "Give Sadaqah", desc: "Earn ongoing rewards with a voluntary donation" },
  { icon: Users, title: "Sponsor an Orphan", desc: "Change a child's life with monthly support" },
  { icon: Droplets, title: "Water for Life", desc: "Provide clean water to communities in need" },
  { icon: Briefcase, title: "Livelihoods", desc: "Help families build sustainable futures" },
  { icon: Gift, title: "Sadaqah Jariyah", desc: "Give a gift that keeps on giving" },
];

function MaximiseRewardSection() {
  return (
    <section className="bg-[#FFF7ED] py-16">
      <div className="mx-auto max-w-7xl px-4">
        <h2 className="mb-10 text-center text-3xl font-bold text-[#111]">Maximise Your Reward</h2>
        <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
          {rewards.map((r) => (
            <a
              key={r.title}
              href="#"
              className="group flex items-center gap-4 rounded-xl bg-white p-5 shadow-sm hover:shadow-lg transition-all hover:-translate-y-0.5"
            >
              <div className="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#FFF7ED] text-[#F97316] transition-colors group-hover:bg-[#F97316] group-hover:text-white">
                <r.icon className="h-5 w-5" />
              </div>
              <div>
                <h4 className="font-semibold text-[#111]">{r.title}</h4>
                <p className="text-sm text-[#111]/60">{r.desc}</p>
              </div>
              <ArrowRight className="ml-auto h-4 w-4 text-[#111]/30 transition-colors group-hover:text-[#F97316]" />
            </a>
          ))}
        </div>
      </div>
    </section>
  );
}

// ─── NEWS ───────────────────────────────────────────────────────────────────
const news = [
  {
    tag: "Opinion",
    title: "Surviving Lebanon's deadliest hour",
    image: "https://images.unsplash.com/photo-1542838132-92c53300491e?w=600&q=80",
  },
  {
    tag: "Press Release",
    title: "Islamic Relief welcomes ceasefire between Lebanon and Israel with caution",
    image: "https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=600&q=80",
  },
  {
    tag: "Feature",
    title: "Three years on: 'We are still here, still resisting, still finding ways to live'",
    image: "https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=600&q=80",
  },
];

function NewsSection() {
  return (
    <section className="bg-white py-16">
      <div className="mx-auto max-w-7xl px-4">
        <div className="mb-8 flex items-center justify-between">
          <h2 className="text-3xl font-bold text-[#111]">Latest News and Updates</h2>
          <a href="#" className="hidden sm:flex items-center gap-1 text-sm font-semibold text-[#F97316] hover:underline">
            View All <ChevronRight className="h-4 w-4" />
          </a>
        </div>

        <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
          {news.map((n) => (
            <a key={n.title} href="#" className="group overflow-hidden rounded-xl bg-white shadow-md hover:shadow-xl transition-shadow">
              <div className="relative h-52 overflow-hidden">
                <img
                  src={n.image}
                  alt={n.title}
                  className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                />
                <span className="absolute left-3 top-3 rounded-full bg-[#F97316] px-3 py-1 text-[10px] font-semibold uppercase text-white">
                  {n.tag}
                </span>
              </div>
              <div className="p-5">
                <h4 className="font-semibold text-[#111] leading-snug line-clamp-2 group-hover:text-[#F97316] transition-colors">
                  {n.title}
                </h4>
              </div>
            </a>
          ))}
        </div>
      </div>
    </section>
  );
}

// ─── WHAT WOULD YOU LIKE TO DO TODAY ────────────────────────────────────────
const actions = [
  {
    title: "Give Zakat",
    desc: "We distribute Zakat donations in the most effective way possible. Our Zakat policy is verified by Scholars to ensure it is Shari'ah-compliant.",
    image: "https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=600&q=80",
  },
  {
    title: "Give Sadaqah",
    desc: "By giving Sadaqah you can help to save and transform the lives of vulnerable communities around the world.",
    image: "https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=600&q=80",
  },
  {
    title: "Sponsor an Orphan",
    desc: "We are supporting over 93,200 orphans around the world — help us to support even more.",
    image: "https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=600&q=80",
  },
  {
    title: "Provide Clean Water for Life",
    desc: "\"The best charity is giving water to drink.\" Save lives by providing clean water.",
    image: "https://images.unsplash.com/photo-1542838132-92c53300491e?w=600&q=80",
  },
  {
    title: "Give to Where Most Needed",
    desc: "We aim to be the first on the ground when disaster strikes and run longer-term projects to support vulnerable communities.",
    image: "https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=600&q=80",
  },
  {
    title: "Feed the Needy",
    desc: "We've assisted 5.4 million people across 13 countries through our food and nutrition projects.",
    image: "https://images.unsplash.com/photo-1593113598332-cd288d649433?w=600&q=80",
  },
];

function ActionsSection() {
  return (
    <section className="bg-[#F3F4F6] py-16">
      <div className="mx-auto max-w-7xl px-4">
        <h2 className="mb-10 text-center text-3xl font-bold text-[#111]">What Would You Like to Do Today?</h2>
        <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
          {actions.map((a) => (
            <a key={a.title} href="#" className="group overflow-hidden rounded-xl bg-white shadow-md hover:shadow-xl transition-all">
              <div className="relative h-44 overflow-hidden">
                <img
                  src={a.image}
                  alt={a.title}
                  className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                />
              </div>
              <div className="p-5">
                <h4 className="mb-2 text-lg font-bold text-[#111] group-hover:text-[#F97316] transition-colors">
                  {a.title}
                </h4>
                <p className="text-sm text-[#111]/60 leading-relaxed line-clamp-3">{a.desc}</p>
              </div>
            </a>
          ))}
        </div>
      </div>
    </section>
  );
}

// ─── IMPACT ─────────────────────────────────────────────────────────────────
const stats = [
  { value: "14.5 million", label: "People supported in 2024" },
  { value: "4.6 million", label: "Lives changed by 407 development projects" },
  { value: "7+ million", label: "People reached with 266 emergency projects" },
];

function ImpactSection() {
  return (
    <section className="bg-[#111] py-20">
      <div className="mx-auto max-w-7xl px-4 text-center">
        <h2 className="mb-4 text-3xl font-bold text-white">Our Impact</h2>
        <p className="mx-auto mb-12 max-w-2xl text-white/70">
          Across the globe, Islamic Relief is delivering life-saving support and long-term development programmes.
        </p>
        <div className="grid gap-8 sm:grid-cols-3">
          {stats.map((s) => (
            <div key={s.label} className="rounded-2xl bg-white/5 border border-white/10 p-8">
              <p className="mb-2 text-3xl md:text-4xl font-extrabold text-[#F97316]">{s.value}</p>
              <p className="text-sm text-white/70">{s.label}</p>
            </div>
          ))}
        </div>
        <a
          href="#"
          className="mt-10 inline-block rounded-full border-2 border-white/30 px-6 py-2.5 text-sm font-semibold text-white hover:bg-white hover:text-[#111] transition-colors"
        >
          See our latest Annual Report
        </a>
      </div>
    </section>
  );
}

// ─── STORIES ────────────────────────────────────────────────────────────────
const stories = [
  {
    title: "Srebrenica Genocide: 30 years on",
    image: "https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=600&q=80",
  },
  {
    title: "Surviving Lebanon's deadliest hour",
    image: "https://images.unsplash.com/photo-1542838132-92c53300491e?w=600&q=80",
  },
  {
    title: "Three years on: 'We are still here, still resisting, still finding ways to live'",
    image: "https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=600&q=80",
  },
];

function StoriesSection() {
  return (
    <section className="bg-white py-16">
      <div className="mx-auto max-w-7xl px-4">
        <h2 className="mb-10 text-center text-3xl font-bold text-[#111]">
          How Your Donations Are Changing People's Lives
        </h2>
        <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
          {stories.map((s) => (
            <a key={s.title} href="#" className="group relative block h-72 overflow-hidden rounded-xl">
              <img
                src={s.image}
                alt={s.title}
                className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-[#111]/90 via-[#111]/30 to-transparent" />
              <div className="absolute bottom-0 p-5">
                <div className="mb-2 flex h-10 w-10 items-center justify-center rounded-full bg-white/20 backdrop-blur-sm">
                  <Play className="h-4 w-4 text-white" fill="white" />
                </div>
                <h4 className="font-semibold text-white leading-snug line-clamp-2">{s.title}</h4>
              </div>
            </a>
          ))}
        </div>
      </div>
    </section>
  );
}

// ─── PARTNERS ───────────────────────────────────────────────────────────────
const partners = [
  "United Nations", "UNICEF", "UNHCR", "OCHA", "European Commission",
  "DFID", "World Food Programme", "WHO", "ECHO", "Start Network",
];

function PartnersSection() {
  return (
    <section className="bg-[#F3F4F6] py-14">
      <div className="mx-auto max-w-7xl px-4">
        <h2 className="mb-10 text-center text-3xl font-bold text-[#111]">Our Partners</h2>
        <div className="flex flex-wrap items-center justify-center gap-8">
          {partners.map((p) => (
            <div
              key={p}
              className="flex h-16 items-center justify-center rounded-lg bg-white px-6 shadow-sm"
            >
              <span className="text-sm font-medium text-[#111]/50">{p}</span>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

// ─── NEWSLETTER ─────────────────────────────────────────────────────────────
function NewsletterSection() {
  return (
    <section className="bg-[#FFF7ED] py-16">
      <div className="mx-auto max-w-2xl px-4 text-center">
        <Mail className="mx-auto mb-4 h-10 w-10 text-[#F97316]" />
        <h2 className="mb-2 text-3xl font-bold text-[#111]">Join Our Newsletter</h2>
        <p className="mb-8 text-[#111]/60">Stay updated with the latest news, appeals and ways you can make a difference.</p>
        <form onSubmit={(e) => e.preventDefault()} className="mx-auto flex max-w-md gap-3">
          <input
            type="email"
            placeholder="Your email address"
            className="flex-1 rounded-full border-2 border-gray-200 px-5 py-2.5 text-sm focus:border-[#F97316] focus:outline-none"
          />
          <button className="rounded-full bg-[#F97316] px-6 py-2.5 text-sm font-semibold text-white hover:bg-[#ea6c10] transition-colors">
            Submit
          </button>
        </form>
      </div>
    </section>
  );
}

// ─── FOOTER ─────────────────────────────────────────────────────────────────
const footerCols = [
  {
    heading: "Current Appeals",
    links: [
      "Give an Orphan a Future",
      "Sudan Emergency",
      "Palestine Emergency",
      "Lebanon Emergency",
      "Yemen Emergency",
      "Syria Appeal",
    ],
  },
  {
    heading: "Resources",
    links: ["Islamic Resources", "Knowledge Base", "Zakat Calculator", "Charity in Islam"],
  },
  {
    heading: "Useful Links",
    links: ["About Us", "Annual Reports", "Our History", "Ways to Donate", "Where We Work"],
  },
  {
    heading: "Giving",
    links: ["Qurbani", "Zakat", "Fidya", "Kaffarah", "Sadaqah", "Sadaqah Jariyah", "Aqiqah"],
  },
];

function Footer() {
  return (
    <footer className="bg-[#111] text-white">
      <div className="mx-auto max-w-7xl px-4 py-14">
        <div className="grid gap-10 sm:grid-cols-2 lg:grid-cols-5">
          {/* Brand col */}
          <div>
            <div className="mb-4 flex items-center gap-2">
              <div className="flex h-9 w-9 items-center justify-center rounded-full bg-[#F97316]">
                <Heart className="h-4 w-4 text-white" fill="white" />
              </div>
              <span className="text-lg font-bold">Islamic Relief</span>
            </div>
            <div className="space-y-2 text-sm text-white/60">
              <p className="flex items-start gap-2">
                <MapPin className="mt-0.5 h-4 w-4 shrink-0" />
                19 Rea St South, Digbeth, Birmingham, B5 6LB
              </p>
              <p className="flex items-center gap-2">
                <Phone className="h-4 w-4 shrink-0" />
                +44 (0)121 605 5555
              </p>
              <p className="flex items-center gap-2">
                <Globe className="h-4 w-4 shrink-0" />
                islamic-relief.org
              </p>
            </div>
          </div>

          {/* Link cols */}
          {footerCols.map((col) => (
            <div key={col.heading}>
              <h4 className="mb-4 text-sm font-semibold uppercase tracking-wider text-white/80">{col.heading}</h4>
              <ul className="space-y-2">
                {col.links.map((l) => (
                  <li key={l}>
                    <a href="#" className="text-sm text-white/50 hover:text-[#F97316] transition-colors">
                      {l}
                    </a>
                  </li>
                ))}
              </ul>
            </div>
          ))}
        </div>

        {/* Bottom bar */}
        <div className="mt-12 flex flex-col items-center gap-4 border-t border-white/10 pt-8 sm:flex-row sm:justify-between">
          <p className="text-xs text-white/40">
            © Copyright 2026 Islamic Relief Worldwide, Inc. All rights reserved. Registered Charity No. 328158
          </p>
          <div className="flex gap-4 text-white/40">
            <a href="#" className="hover:text-[#F97316] transition-colors text-sm">Privacy Policy</a>
            <a href="#" className="hover:text-[#F97316] transition-colors text-sm">Cookie Policy</a>
            <a href="#" className="hover:text-[#F97316] transition-colors text-sm">Modern Slavery</a>
          </div>
        </div>
      </div>
    </footer>
  );
}

// ─── PAGE ───────────────────────────────────────────────────────────────────
const Index = () => {
  return (
    <div className="min-h-screen bg-white">
      <Header />
      <HeroSection />
      <CampaignsSection />
      <MaximiseRewardSection />
      <NewsSection />
      <ActionsSection />
      <ImpactSection />
      <StoriesSection />
      <PartnersSection />
      <NewsletterSection />
      <Footer />
    </div>
  );
};

export default Index;
