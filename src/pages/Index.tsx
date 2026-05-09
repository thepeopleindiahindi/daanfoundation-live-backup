import { useState, useEffect, useCallback } from "react";
import useEmblaCarousel from "embla-carousel-react";
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
  Instagram,
  Youtube,
  Linkedin,
  Twitter,
  CheckSquare,
} from "lucide-react";

/* ─── Color tokens ───────────────────────────────────────────────────────
  🟧 Orange  #F97316   ⬛ Black  #111111   ⬜ White  #FFFFFF
  ◻️ Grey    #F3F4F6   🟫 Beige  #FFF7ED
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
  const [scrolled, setScrolled] = useState(false);

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 10);
    window.addEventListener("scroll", onScroll, { passive: true });
    return () => window.removeEventListener("scroll", onScroll);
  }, []);

  return (
    <header className={`sticky top-0 z-50 bg-white transition-shadow ${scrolled ? "shadow-md" : ""}`}>
      <div className="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 lg:py-4">
        {/* Logo */}
        <a href="#" className="flex items-center gap-2.5 shrink-0">
          <svg viewBox="0 0 40 40" className="h-10 w-10" fill="none">
            <circle cx="20" cy="20" r="20" fill="#F97316" />
            <path d="M20 12c-1.5 0-6 4-6 9s4.5 7 6 7 6-2 6-7-4.5-9-6-9z" fill="white" />
            <path d="M14 21c0 3.5 2.5 6.5 6 7-3.5-.5-6-3.5-6-7z" fill="white" fillOpacity=".5" />
          </svg>
          <div className="leading-tight">
            <span className="block text-lg font-bold text-[#111] tracking-tight">Islamic Relief</span>
            <span className="block text-[10px] font-medium tracking-[0.2em] text-[#111]/50 uppercase">Worldwide</span>
          </div>
        </a>

        {/* Desktop nav links */}
        <nav className="hidden lg:flex items-center gap-7">
          {navLinks.map((l) => (
            <a
              key={l.label}
              href={l.href}
              className="text-[15px] font-medium text-[#111] hover:text-[#F97316] transition-colors"
            >
              {l.label}
            </a>
          ))}
        </nav>

        {/* Right side */}
        <div className="flex items-center gap-3">
          <button className="hidden sm:flex h-9 w-9 items-center justify-center rounded-full text-[#111] hover:bg-[#F3F4F6] transition-colors">
            <Search className="h-[18px] w-[18px]" />
          </button>
          <a
            href="#"
            className="rounded-full bg-[#F97316] px-7 py-2.5 text-sm font-bold text-white uppercase tracking-wide shadow hover:bg-[#ea6c10] transition-colors"
          >
            Donate
          </a>
          <button className="lg:hidden ml-1" onClick={() => setMobileOpen(!mobileOpen)} aria-label="Toggle menu">
            {mobileOpen ? <X className="h-6 w-6 text-[#111]" /> : <Menu className="h-6 w-6 text-[#111]" />}
          </button>
        </div>
      </div>

      {/* Mobile nav */}
      {mobileOpen && (
        <nav className="lg:hidden border-t border-[#F3F4F6] bg-white px-4 pb-4 pt-2">
          {navLinks.map((l) => (
            <a
              key={l.label}
              href={l.href}
              className="block py-3 text-[15px] font-medium text-[#111] hover:text-[#F97316] border-b border-[#F3F4F6] last:border-0"
            >
              {l.label}
            </a>
          ))}
        </nav>
      )}
    </header>
  );
}

// ─── HERO SLIDER ────────────────────────────────────────────────────────────
const heroSlides = [
  {
    tag: "Emergency Appeal",
    title: "Sudan Emergency Appeal",
    desc: "Millions of people across Sudan are facing unimaginable suffering. Families are being displaced, children left without food, and communities torn apart.",
    image: "https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=1600&q=80",
  },
  {
    tag: "Ramadan",
    title: "Ramadan — Give Generously",
    desc: "This Ramadan, multiply your blessings by transforming the lives of those most in need. Every donation brings hope to families around the world.",
    image: "https://images.unsplash.com/photo-1564769625905-50e93615e769?w=1600&q=80",
  },
];

function HeroSection() {
  const [amount, setAmount] = useState<number | null>(150);
  const presets = [100, 150, 300];
  const [emblaRef, emblaApi] = useEmblaCarousel({ loop: true });
  const [activeSlide, setActiveSlide] = useState(0);

  const onSelect = useCallback(() => {
    if (!emblaApi) return;
    setActiveSlide(emblaApi.selectedScrollSnap());
  }, [emblaApi]);

  useEffect(() => {
    if (!emblaApi) return;
    emblaApi.on("select", onSelect);
    onSelect();

    // Auto-play
    const interval = setInterval(() => {
      if (emblaApi.canScrollNext()) emblaApi.scrollNext();
      else emblaApi.scrollTo(0);
    }, 6000);
    return () => clearInterval(interval);
  }, [emblaApi, onSelect]);

  return (
    <section className="relative bg-[#111]">
      {/* Carousel */}
      <div className="overflow-hidden" ref={emblaRef}>
        <div className="flex">
          {heroSlides.map((slide, i) => (
            <div key={i} className="relative min-w-full">
              <div className="relative min-h-[560px] md:min-h-[620px]">
                <img
                  src={slide.image}
                  alt={slide.title}
                  className="absolute inset-0 h-full w-full object-cover"
                />
                <div className="absolute inset-0 bg-gradient-to-r from-[#111]/85 via-[#111]/50 to-[#111]/20" />

                <div className="relative mx-auto flex max-w-7xl flex-col justify-center px-4 py-20 md:py-28 min-h-[560px] md:min-h-[620px]">
                  <div className="max-w-xl">
                    <span className="mb-4 inline-block rounded-full bg-[#F97316] px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-white">
                      {slide.tag}
                    </span>
                    <h1 className="text-4xl md:text-5xl lg:text-[56px] font-extrabold leading-[1.1] text-white mb-5">
                      {slide.title}
                    </h1>
                    <p className="text-lg text-white/80 leading-relaxed max-w-lg">
                      {slide.desc}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>

      {/* Donate widget — floating over hero */}
      <div className="absolute right-4 bottom-8 md:right-12 md:bottom-12 w-full max-w-[340px] z-10 hidden md:block">
        <div className="rounded-2xl bg-white p-5 shadow-2xl">
          <h3 className="mb-3 text-center text-base font-bold text-[#111]">Make a Donation</h3>
          <div className="mb-3 flex gap-2">
            {presets.map((p) => (
              <button
                key={p}
                onClick={() => setAmount(p)}
                className={`flex-1 rounded-lg border-2 py-2 text-sm font-bold transition-colors ${
                  amount === p
                    ? "border-[#F97316] bg-[#FFF7ED] text-[#F97316]"
                    : "border-gray-200 text-[#111] hover:border-[#F97316]/40"
                }`}
              >
                ₹{p}
              </button>
            ))}
          </div>
          <div className="relative mb-3">
            <span className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-semibold text-sm">₹</span>
            <input
              type="number"
              value={amount ?? ""}
              onChange={(e) => setAmount(Number(e.target.value) || null)}
              className="w-full rounded-lg border-2 border-gray-200 py-2 pl-7 pr-4 text-sm focus:border-[#F97316] focus:outline-none"
              placeholder="Other amount"
            />
          </div>
          <button className="w-full rounded-full bg-[#F97316] py-3 text-sm font-bold text-white uppercase tracking-wide shadow-lg hover:bg-[#ea6c10] transition-colors">
            Donate
          </button>
        </div>
      </div>

      {/* Mobile donate widget (below carousel on small screens) */}
      <div className="md:hidden bg-[#111] px-4 pb-6 -mt-2">
        <div className="rounded-2xl bg-white p-5 shadow-2xl">
          <h3 className="mb-3 text-center text-base font-bold text-[#111]">Make a Donation</h3>
          <div className="mb-3 flex gap-2">
            {presets.map((p) => (
              <button
                key={p}
                onClick={() => setAmount(p)}
                className={`flex-1 rounded-lg border-2 py-2 text-sm font-bold transition-colors ${
                  amount === p
                    ? "border-[#F97316] bg-[#FFF7ED] text-[#F97316]"
                    : "border-gray-200 text-[#111] hover:border-[#F97316]/40"
                }`}
              >
                ₹{p}
              </button>
            ))}
          </div>
          <div className="relative mb-3">
            <span className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-semibold text-sm">₹</span>
            <input
              type="number"
              value={amount ?? ""}
              onChange={(e) => setAmount(Number(e.target.value) || null)}
              className="w-full rounded-lg border-2 border-gray-200 py-2 pl-7 pr-4 text-sm focus:border-[#F97316] focus:outline-none"
              placeholder="Other amount"
            />
          </div>
          <button className="w-full rounded-full bg-[#F97316] py-3 text-sm font-bold text-white uppercase tracking-wide shadow-lg hover:bg-[#ea6c10] transition-colors">
            Donate
          </button>
        </div>
      </div>

      {/* Slide indicators */}
      <div className="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10 md:left-12 md:translate-x-0 md:bottom-14">
        {heroSlides.map((_, i) => (
          <button
            key={i}
            onClick={() => emblaApi?.scrollTo(i)}
            className={`h-2.5 rounded-full transition-all ${
              activeSlide === i ? "w-8 bg-[#F97316]" : "w-2.5 bg-white/50 hover:bg-white/70"
            }`}
            aria-label={`Go to slide ${i + 1}`}
          />
        ))}
      </div>
    </section>
  );
}

// ─── CAMPAIGNS CAROUSEL ─────────────────────────────────────────────────────
const campaigns = [
  { title: "Give an Orphan a Future", image: "https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=600&q=80", href: "#" },
  { title: "Lebanon Emergency Appeal", image: "https://images.unsplash.com/photo-1542838132-92c53300491e?w=600&q=80", href: "#" },
  { title: "Palestine Emergency Appeal", image: "https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=600&q=80", href: "#" },
  { title: "Sudan Emergency Appeal", image: "https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=600&q=80", href: "#" },
  { title: "Yemen Crisis", image: "https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=600&q=80", href: "#" },
];

function CampaignsSection() {
  const [emblaRef, emblaApi] = useEmblaCarousel({
    loop: false,
    align: "start",
    slidesToScroll: 1,
    containScroll: "trimSnaps",
  });
  const [canPrev, setCanPrev] = useState(false);
  const [canNext, setCanNext] = useState(true);

  const updateButtons = useCallback(() => {
    if (!emblaApi) return;
    setCanPrev(emblaApi.canScrollPrev());
    setCanNext(emblaApi.canScrollNext());
  }, [emblaApi]);

  useEffect(() => {
    if (!emblaApi) return;
    emblaApi.on("select", updateButtons);
    emblaApi.on("reInit", updateButtons);
    updateButtons();
  }, [emblaApi, updateButtons]);

  return (
    <section className="bg-[#F3F4F6] py-14 md:py-20">
      <div className="mx-auto max-w-7xl px-4">
        <div className="mb-8 flex items-end justify-between">
          <h2 className="text-2xl md:text-3xl font-bold text-[#111]">Current campaigns</h2>
          <div className="flex gap-2">
            <button
              onClick={() => emblaApi?.scrollPrev()}
              disabled={!canPrev}
              className="flex h-10 w-10 items-center justify-center rounded-full border-2 border-[#111]/20 text-[#111] hover:border-[#F97316] hover:text-[#F97316] transition-colors disabled:opacity-30 disabled:hover:border-[#111]/20 disabled:hover:text-[#111]"
            >
              <ChevronLeft className="h-5 w-5" />
            </button>
            <button
              onClick={() => emblaApi?.scrollNext()}
              disabled={!canNext}
              className="flex h-10 w-10 items-center justify-center rounded-full border-2 border-[#111]/20 text-[#111] hover:border-[#F97316] hover:text-[#F97316] transition-colors disabled:opacity-30 disabled:hover:border-[#111]/20 disabled:hover:text-[#111]"
            >
              <ChevronRight className="h-5 w-5" />
            </button>
          </div>
        </div>

        <div className="overflow-hidden" ref={emblaRef}>
          <div className="flex gap-5">
            {campaigns.map((c) => (
              <div
                key={c.title}
                className="min-w-[260px] max-w-[260px] sm:min-w-[280px] sm:max-w-[280px] flex-shrink-0"
              >
                <a href={c.href} className="group block overflow-hidden rounded-xl bg-white shadow-md hover:shadow-xl transition-shadow">
                  <div className="relative h-52 overflow-hidden">
                    <img
                      src={c.image}
                      alt={c.title}
                      className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                    />
                  </div>
                  <div className="p-4">
                    <h4 className="mb-3 text-[15px] font-semibold text-[#111] leading-snug">{c.title}</h4>
                    <span className="inline-block rounded-full bg-[#F97316] px-5 py-2 text-xs font-bold text-white uppercase tracking-wide hover:bg-[#ea6c10] transition-colors">
                      Donate
                    </span>
                  </div>
                </a>
              </div>
            ))}
          </div>
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
    <section className="bg-[#FFF7ED] py-14 md:py-20">
      <div className="mx-auto max-w-7xl px-4">
        <h2 className="mb-10 text-center text-2xl md:text-3xl font-bold text-[#111]">Maximise Your Reward</h2>
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
              <div className="flex-1 min-w-0">
                <h4 className="font-semibold text-[#111] text-[15px]">{r.title}</h4>
                <p className="text-sm text-[#111]/55 leading-snug">{r.desc}</p>
              </div>
              <ArrowRight className="ml-auto h-4 w-4 shrink-0 text-[#111]/20 transition-colors group-hover:text-[#F97316]" />
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
    tag: "Press Releases",
    title: "Islamic Relief welcomes ceasefire between Lebanon and Israel with caution",
    image: "https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=600&q=80",
  },
];

function NewsSection() {
  return (
    <section className="bg-white py-14 md:py-20">
      <div className="mx-auto max-w-7xl px-4">
        <div className="mb-8 flex items-end justify-between">
          <h2 className="text-2xl md:text-3xl font-bold text-[#111]">Latest news and updates</h2>
          <a href="#" className="hidden sm:flex items-center gap-1 text-sm font-semibold text-[#F97316] hover:underline">
            View All <ChevronRight className="h-4 w-4" />
          </a>
        </div>

        <div className="grid gap-6 sm:grid-cols-2">
          {news.map((n) => (
            <a key={n.title} href="#" className="group overflow-hidden rounded-xl bg-white shadow-md hover:shadow-xl transition-shadow">
              <div className="relative h-56 sm:h-64 overflow-hidden">
                <img
                  src={n.image}
                  alt={n.title}
                  className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                />
                <span className="absolute left-4 top-4 rounded-full bg-[#F97316] px-3.5 py-1 text-[11px] font-bold uppercase tracking-wide text-white">
                  {n.tag}
                </span>
              </div>
              <div className="p-5">
                <h4 className="text-[15px] font-semibold text-[#111] leading-snug line-clamp-2 group-hover:text-[#F97316] transition-colors">
                  {n.title}
                </h4>
              </div>
            </a>
          ))}
        </div>

        <a href="#" className="mt-6 flex sm:hidden items-center gap-1 text-sm font-semibold text-[#F97316]">
          View All <ChevronRight className="h-4 w-4" />
        </a>
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
    <section className="bg-[#F3F4F6] py-14 md:py-20">
      <div className="mx-auto max-w-7xl px-4">
        <h2 className="mb-10 text-center text-2xl md:text-3xl font-bold text-[#111]">What would you like to do today?</h2>
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
                <p className="text-sm text-[#111]/55 leading-relaxed line-clamp-3">{a.desc}</p>
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
  {
    value: "14.5 million people",
    label: "Supported in 2024",
    icon: (
      <svg viewBox="0 0 80 80" className="h-20 w-20" fill="none">
        <circle cx="40" cy="28" r="12" stroke="#F97316" strokeWidth="3" />
        <path d="M20 62c0-11 9-20 20-20s20 9 20 20" stroke="#F97316" strokeWidth="3" strokeLinecap="round" />
        <circle cx="58" cy="32" r="8" stroke="#F97316" strokeWidth="2" opacity=".5" />
        <path d="M48 56c0-7 4.5-13 10-13s10 6 10 13" stroke="#F97316" strokeWidth="2" strokeLinecap="round" opacity=".5" />
      </svg>
    ),
  },
  {
    value: "More than 4.6 million",
    label: "lives changed by 407 development projects",
    icon: (
      <svg viewBox="0 0 80 80" className="h-20 w-20" fill="none">
        <circle cx="40" cy="40" r="28" stroke="#F97316" strokeWidth="3" />
        <path d="M28 40h24M40 28v24" stroke="#F97316" strokeWidth="3" strokeLinecap="round" />
        <circle cx="40" cy="40" r="8" fill="#F97316" fillOpacity=".15" />
      </svg>
    ),
  },
  {
    value: "Over 7 million people",
    label: "reached with 266 emergency projects",
    icon: (
      <svg viewBox="0 0 80 80" className="h-20 w-20" fill="none">
        <path d="M40 12L10 65h60L40 12z" stroke="#F97316" strokeWidth="3" strokeLinejoin="round" />
        <path d="M40 35v15M40 55v2" stroke="#F97316" strokeWidth="3" strokeLinecap="round" />
      </svg>
    ),
  },
];

function ImpactSection() {
  return (
    <section className="bg-white py-14 md:py-20">
      <div className="mx-auto max-w-7xl px-4">
        <h2 className="mb-12 text-center text-2xl md:text-3xl font-bold text-[#111]">Our Impact</h2>
        <div className="grid gap-8 sm:grid-cols-3">
          {stats.map((s) => (
            <div key={s.label} className="flex flex-col items-center text-center">
              <div className="mb-4">{s.icon}</div>
              <h3 className="text-xl md:text-2xl font-extrabold text-[#111] mb-1">{s.value}</h3>
              <p className="text-sm text-[#111]/55">{s.label}</p>
            </div>
          ))}
        </div>
        <div className="mt-10 text-center">
          <a
            href="#"
            className="inline-block rounded-full bg-[#F97316] px-7 py-3 text-sm font-bold text-white uppercase tracking-wide hover:bg-[#ea6c10] transition-colors"
          >
            See our latest Annual Report
          </a>
        </div>
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
    <section className="bg-[#F3F4F6] py-14 md:py-20">
      <div className="mx-auto max-w-7xl px-4">
        <h2 className="mb-10 text-center text-2xl md:text-3xl font-bold text-[#111]">
          How your donations are changing people's lives?
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

// ─── PARTNERS CAROUSEL ──────────────────────────────────────────────────────
const partners = [
  "United Nations", "UNICEF", "UNHCR", "OCHA", "European Commission",
  "DFID", "World Food Programme", "WHO", "ECHO", "Start Network",
  "Islamic Development Bank", "Global Fund", "USAID", "SIDA", "CIDA", "AusAID",
];

function PartnersSection() {
  const [emblaRef] = useEmblaCarousel({
    loop: true,
    align: "start",
    slidesToScroll: 1,
    containScroll: false,
    dragFree: true,
  });

  return (
    <section className="bg-white py-14 md:py-20">
      <div className="mx-auto max-w-7xl px-4">
        <h2 className="mb-10 text-center text-2xl md:text-3xl font-bold text-[#111]">Our Partners</h2>
        <div className="overflow-hidden" ref={emblaRef}>
          <div className="flex gap-6">
            {partners.map((p) => (
              <div
                key={p}
                className="flex h-20 min-w-[160px] max-w-[160px] flex-shrink-0 items-center justify-center rounded-lg border border-[#F3F4F6] bg-[#F3F4F6]/50 px-4"
              >
                <span className="text-sm font-semibold text-[#111]/40 text-center leading-tight">{p}</span>
              </div>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}

// ─── NEWSLETTER ─────────────────────────────────────────────────────────────
function NewsletterSection() {
  const [consent, setConsent] = useState(false);

  return (
    <section className="bg-[#FFF7ED] py-14 md:py-20">
      <div className="mx-auto max-w-2xl px-4">
        <h2 className="mb-6 text-center text-2xl md:text-3xl font-bold text-[#111]">Join Our Newsletter</h2>
        <form onSubmit={(e) => e.preventDefault()} className="space-y-4">
          <div className="flex flex-col sm:flex-row gap-3">
            <input
              type="email"
              placeholder="Your email address"
              className="flex-1 rounded-lg border-2 border-gray-200 bg-white px-4 py-3 text-sm focus:border-[#F97316] focus:outline-none"
            />
            <button className="rounded-lg bg-[#F97316] px-8 py-3 text-sm font-bold text-white uppercase tracking-wide hover:bg-[#ea6c10] transition-colors">
              Submit
            </button>
          </div>

          <label className="flex items-start gap-3 cursor-pointer">
            <input
              type="checkbox"
              checked={consent}
              onChange={(e) => setConsent(e.target.checked)}
              className="mt-1 h-4 w-4 rounded border-gray-300 text-[#F97316] focus:ring-[#F97316] accent-[#F97316]"
            />
            <span className="text-xs text-[#111]/60 leading-relaxed">
              I am happy to receive updates from Islamic Relief by email (inc. via social media) and SMS.
            </span>
          </label>

          <p className="text-xs text-[#111]/45 leading-relaxed">
            We will always treat your personal information with the utmost care and will keep it private
            (read our <a href="#" className="underline hover:text-[#F97316]">privacy policy</a>).
            You can opt out at any time by contacting us via email at{" "}
            <a href="mailto:IslamicReliefWorldwide@irworldwide.org" className="underline hover:text-[#F97316]">
              IslamicReliefWorldwide@irworldwide.org
            </a>{" "}
            or by clicking the unsubscribe button on one of the emails you receive from us.
          </p>
        </form>
      </div>
    </section>
  );
}

// ─── FOOTER ─────────────────────────────────────────────────────────────────
const footerCols = [
  {
    heading: "Current appeals",
    links: [
      { label: "Give an orphan a future", href: "#" },
      { label: "Sudan emergency", href: "#" },
      { label: "Palestine emergency", href: "#" },
      { label: "Lebanon emergency", href: "#" },
      { label: "Afghanistan earthquake appeal", href: "#" },
      { label: "Pakistan floods appeal", href: "#" },
      { label: "Yemen emergency", href: "#" },
      { label: "Syria appeal", href: "#" },
      { label: "Global emergency response", href: "#" },
    ],
  },
  {
    heading: "Resources",
    links: [
      { label: "Islamic resources", href: "#" },
      { label: "Knowledge base", href: "#" },
      { label: "Zakat Calculator", href: "#" },
      { label: "Charity in Islam", href: "#" },
    ],
  },
  {
    heading: "Useful links",
    links: [
      { label: "About us", href: "#" },
      { label: "Annual reports", href: "#" },
      { label: "Our history", href: "#" },
      { label: "Ways to donate", href: "#" },
      { label: "Where we work", href: "#" },
      { label: "Scams and fraud", href: "#" },
    ],
  },
  {
    heading: "Policies",
    links: [
      { label: "Privacy Policy", href: "#" },
      { label: "Cookie Policy", href: "#" },
      { label: "Modern Slavery statement", href: "#" },
      { label: "'Do no harm' commitment", href: "#" },
      { label: "Our supporter promise", href: "#" },
    ],
  },
  {
    heading: "Giving",
    links: [
      { label: "Zakat", href: "#" },
      { label: "Fidya", href: "#" },
      { label: "Kaffarah", href: "#" },
      { label: "Sadaqah", href: "#" },
      { label: "Sadaqah Jariyah", href: "#" },
      { label: "Where most needed", href: "#" },
      { label: "Interest (Riba)", href: "#" },
      { label: "Aqiqah", href: "#" },
      { label: "Waqf", href: "#" },
    ],
  },
];

const socialLinks = [
  { icon: Twitter, label: "X / Twitter", href: "https://x.com/irworldwide" },
  { icon: Instagram, label: "Instagram", href: "https://www.instagram.com/irworldwide/" },
  { icon: Youtube, label: "YouTube", href: "https://www.youtube.com/user/IRWorldwide" },
  { icon: Linkedin, label: "LinkedIn", href: "https://www.linkedin.com/company/islamic-relief-worldwide" },
];

function Footer() {
  return (
    <footer className="bg-[#111] text-white">
      <div className="mx-auto max-w-7xl px-4 py-14">
        {/* Top: Logo + Donate */}
        <div className="mb-10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
          <a href="#" className="flex items-center gap-2.5">
            <svg viewBox="0 0 36 36" className="h-9 w-9" fill="none">
              <circle cx="18" cy="18" r="18" fill="#F97316" />
              <path d="M18 10c-1.3 0-5.4 3.6-5.4 8.1s4 6.3 5.4 6.3 5.4-1.8 5.4-6.3S19.3 10 18 10z" fill="white" />
            </svg>
            <span className="text-lg font-bold tracking-tight">Islamic Relief</span>
          </a>
          <a
            href="#"
            className="rounded-full bg-[#F97316] px-7 py-2.5 text-sm font-bold text-white uppercase tracking-wide hover:bg-[#ea6c10] transition-colors"
          >
            Donate
          </a>
        </div>

        {/* Accreditation badges */}
        <div className="mb-10 flex flex-wrap items-center gap-6">
          <div className="rounded border border-white/10 px-4 py-2 text-[11px] text-white/40 font-medium">
            Registered with Fundraising Regulator
          </div>
          <div className="rounded border border-white/10 px-4 py-2 text-[11px] text-white/40 font-medium">
            DEC Member
          </div>
          <div className="rounded border border-white/10 px-4 py-2 text-[11px] text-white/40 font-medium">
            HQAI Certified Partner
          </div>
        </div>

        {/* Footer columns */}
        <div className="grid gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
          {footerCols.map((col) => (
            <div key={col.heading}>
              <h4 className="mb-4 text-sm font-semibold text-white/80">{col.heading}</h4>
              <ul className="space-y-2">
                {col.links.map((l) => (
                  <li key={l.label}>
                    <a href={l.href} className="text-[13px] text-white/45 hover:text-[#F97316] transition-colors">
                      {l.label}
                    </a>
                  </li>
                ))}
              </ul>
            </div>
          ))}
        </div>

        {/* Contact us */}
        <div className="mt-10 border-t border-white/10 pt-8">
          <h4 className="mb-4 text-sm font-semibold text-white/80">Contact us</h4>
          <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 text-sm text-white/45">
            <div className="flex items-start gap-2">
              <MapPin className="mt-0.5 h-4 w-4 shrink-0 text-white/30" />
              <span>Islamic Relief Worldwide<br />19 Rea St South, Digbeth<br />Birmingham, B5 6LB</span>
            </div>
            <div className="flex items-center gap-2">
              <Phone className="h-4 w-4 shrink-0 text-white/30" />
              <span>+44 (0)121 605 5555</span>
            </div>
            <div className="space-y-1">
              <a href="#" className="block hover:text-[#F97316] transition-colors">General enquiries</a>
              <a href="#" className="block hover:text-[#F97316] transition-colors">Complaints and concerns</a>
              <a href="#" className="block hover:text-[#F97316] transition-colors">Media enquiries</a>
            </div>
          </div>
        </div>

        {/* Social + Copyright */}
        <div className="mt-10 flex flex-col items-center gap-6 border-t border-white/10 pt-8 sm:flex-row sm:justify-between">
          <p className="text-xs text-white/35">
            © Copyright 2026 Islamic Relief Worldwide, Inc. All rights reserved. Registered Charity No. 328158
          </p>
          <div className="flex items-center gap-1">
            <span className="text-xs text-white/35 mr-3">Follow us on Social</span>
            {socialLinks.map((s) => (
              <a
                key={s.label}
                href={s.href}
                target="_blank"
                rel="noopener noreferrer"
                className="flex h-9 w-9 items-center justify-center rounded-full text-white/40 hover:bg-white/10 hover:text-[#F97316] transition-colors"
                aria-label={s.label}
              >
                <s.icon className="h-4 w-4" />
              </a>
            ))}
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
