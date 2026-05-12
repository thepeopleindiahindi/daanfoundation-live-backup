import {
  Heart,
  Users,
  Award,
  Target,
  AlertTriangle,
  Utensils,
  Clock,
  HandHeart,
  Eye,
  ShieldCheck,
  Sparkles,
  ChevronRight,
  MapPin,
  Shirt,
  Stethoscope,
  GraduationCap,
  Gem,
  Briefcase,
  ArrowRight,
  Star,
  Globe,
  Handshake,
} from "lucide-react";
import { Link } from "react-router-dom";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";

/* ─── Data ─────────────────────────────────────────────────────────────── */

const values = [
  {
    icon: Heart,
    title: "Compassion",
    description: "We believe every human life matters.",
  },
  {
    icon: Eye,
    title: "Transparency",
    description: "Every donation is treated as an Amanah (trust).",
  },
  {
    icon: HandHeart,
    title: "Dignity",
    description: "Every individual deserves respect.",
  },
  {
    icon: Sparkles,
    title: "Service",
    description: "Driven by a spirit of selfless service.",
  },
  {
    icon: ShieldCheck,
    title: "Responsibility",
    description: "Careful and honest use of resources.",
  },
];

const whatWeDo = [
  {
    label: "Daily cooked meal distribution",
    to: "/community-kitchen",
    icon: Utensils,
  },
  {
    label: "Ramadan Iftar programs",
    to: "/ramadan",
    icon: Star,
  },
  {
    label: "Ration kit distribution",
    to: "/where-most-needed",
    icon: MapPin,
  },
  {
    label: "Clothing support",
    to: "/winter",
    icon: Shirt,
  },
  {
    label: "Medical assistance",
    to: "/our-work/medical-assistance",
    icon: Stethoscope,
  },
  {
    label: "Educational support",
    to: "/our-work/educational-support",
    icon: GraduationCap,
  },
  {
    label: "Marriage assistance",
    to: "/our-work/marriage-assistance",
    icon: Gem,
  },
  {
    label: "Livelihood and self-employment support",
    to: "/our-work/empowering-livelihoods",
    icon: Briefcase,
  },
];

const trustees = [
  { name: "Mr. Ahmad Raza Khan", role: "Chairperson / Settler" },
  { name: "Mr. Anees Ahmad Siddiqui", role: "Vice Chairman / Trustee" },
  { name: "Mr. Farman Raza Khan", role: "General Secretary / Trustee" },
  { name: "Mr. Adnan Ahmad Khan", role: "Treasurer / Trustee" },
  { name: "Mr. Fareed Uddin Siddiqui", role: "Trustee / Member" },
];

const volunteers = [
  "Faizan Khan",
  "Mohammad Nadeem Siddiqui",
  "Mohd. Maroof",
  "Kamar Aalam",
  "Talib Siddiqui",
  "Asma Khan",
  "Rifaty Zia",
  "Shagu",
];

const achievements = [
  "Served 500,000+ meals",
  "Organized large-scale Ramadan Iftar programs",
  "Distributed food and ration kits",
  "Supported widows and elderly individuals",
  "Helped children and struggling families",
  "Delivered humanitarian assistance during difficult times",
  "Built a strong volunteer-driven community initiative",
];

const futureGoals = [
  { label: "Expand Community Kitchen services", icon: Utensils },
  { label: "Reach more underserved areas", icon: MapPin },
  { label: "Strengthen ration and food distribution", icon: Target },
  { label: "Increase education and healthcare support", icon: GraduationCap },
  { label: "Promote livelihood initiatives", icon: Briefcase },
  { label: "Build stronger community partnerships", icon: Handshake },
];

/* ─── About Page ───────────────────────────────────────────────────────── */

export function About() {
  return (
    <div>
      <SEO title="About Daan Foundation - Our Mission & Journey" description="Learn about Daan Foundation's 6-year journey serving humanity in India. Our mission, values, trustees, volunteers, and the impact we've made since 2020." canonical="/about" keywords="about Daan Foundation, charity mission India, humanitarian organization, community service India" />
      <Breadcrumbs items={[{ label: "About Us" }]} />

      {/* ── HERO ─────────────────────────────────────────────────────── */}
      <section className="relative py-20 md:py-28 overflow-hidden">
        <div className="absolute inset-0 bg-gradient-to-br from-orange-600 to-orange-700" />
        <div className="absolute inset-0 bg-[url('/images/pattern-dots.svg')] opacity-10" />

        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <span className="inline-block rounded-full bg-white/20 px-4 py-1.5 text-sm font-semibold text-white mb-6">
            Est. 2020 &middot; 6+ Years of Service
          </span>
          <h1 className="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
            Serving Humanity{" "}
            <span className="text-amber-300">With Compassion</span>
          </h1>
          <p className="text-xl text-white/90 max-w-3xl mx-auto leading-relaxed mb-4">
            Daan Foundation is an India-based charitable and humanitarian
            organization committed to supporting poor, needy, and vulnerable
            communities through food assistance, social welfare, and community
            support programs.
          </p>
          <p className="text-lg text-white/80 max-w-2xl mx-auto leading-relaxed">
            The foundation was established during the challenging period of the
            2020 pandemic, with a simple yet powerful mission:{" "}
            <strong className="text-amber-300">
              "No person should sleep hungry."
            </strong>
          </p>
        </div>
      </section>

      {/* ── IMPORTANT NOTICE ─────────────────────────────────────────── */}
      <section className="py-10">
        <div className="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
          <div className="rounded-2xl bg-amber-50 border border-amber-200 p-6 md:p-8 flex gap-4">
            <div className="shrink-0 mt-0.5">
              <div className="h-10 w-10 rounded-full bg-amber-200 flex items-center justify-center">
                <AlertTriangle className="h-5 w-5 text-amber-700" />
              </div>
            </div>
            <div>
              <h3 className="text-lg font-bold text-amber-900 mb-3">
                Important Notice
              </h3>
              <ul className="space-y-2 text-amber-800 text-[15px]">
                <li className="flex items-start gap-2">
                  <span className="mt-1.5 h-1.5 w-1.5 rounded-full bg-amber-600 shrink-0" />
                  Daan Foundation operates strictly within India
                </li>
                <li className="flex items-start gap-2">
                  <span className="mt-1.5 h-1.5 w-1.5 rounded-full bg-amber-600 shrink-0" />
                  We do not work outside India
                </li>
                <li className="flex items-start gap-2">
                  <span className="mt-1.5 h-1.5 w-1.5 rounded-full bg-amber-600 shrink-0" />
                  We do not run international projects
                </li>
                <li className="flex items-start gap-2">
                  <span className="mt-1.5 h-1.5 w-1.5 rounded-full bg-amber-600 shrink-0" />
                  We are not authorized to receive foreign donations
                </li>
                <li className="flex items-start gap-2">
                  <span className="mt-1.5 h-1.5 w-1.5 rounded-full bg-amber-600 shrink-0" />
                  All activities are focused entirely on Indian communities
                </li>
              </ul>
            </div>
          </div>
        </div>
      </section>

      {/* ── OUR JOURNEY ──────────────────────────────────────────────── */}
      <section className="py-16 md:py-24 bg-gray-50">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-slate-900 mb-4">
              Our Journey
            </h2>
            <p className="text-lg text-slate-600 max-w-2xl mx-auto">
              From humble beginnings to a continuous humanitarian effort
            </p>
          </div>

          <div className="max-w-3xl mx-auto">
            <div className="prose prose-lg text-slate-600 max-w-none mb-12">
              <p>
                During the nationwide lockdown in 2020, thousands of daily wage
                earners, labourers, and underprivileged families struggled to
                arrange even basic meals. Seeing this hardship, a small group of
                individuals came forward to distribute food and Iftar meals among
                those in need.
              </p>
              <p>
                At that time, there was no office, no structured system, no
                long-term planning — only sincerity, trust, and the intention to
                help.
              </p>
              <p>
                What began as a small Ramadan Iftar initiative planned for just
                15 days gradually evolved into a continuous humanitarian effort.
                With the help of Allah and the trust of kind-hearted supporters,
                this initiative expanded into a daily Community Kitchen, which
                continues to serve people every evening.
              </p>
              <p>
                With continuous public support and growing need, Daan Foundation
                gradually expanded its activities into daily cooked meal
                distribution, Ramadan Iftar programs, ration kit distribution,
                clothing support, medical assistance, educational support,
                marriage assistance, and livelihood and self-employment support.
              </p>
              <p className="font-medium text-slate-800">
                Today, the foundation continues to serve with the same original
                spirit of compassion and responsibility.
              </p>
            </div>

            {/* Timeline milestones */}
            <div className="space-y-0">
              {[
                {
                  year: "2020",
                  title: "Founded During Ramadan",
                  description:
                    "Started as a small Ramadan Iftar initiative for 15 days, transforming into a continuous humanitarian effort during the pandemic lockdown.",
                },
                {
                  year: "2021",
                  title: "Growth & Expansion",
                  description:
                    "Expanded food distribution, increased volunteer participation, and established regular Community Kitchen operations.",
                },
                {
                  year: "2023",
                  title: "Official Registration",
                  description:
                    "Formally registered as Daan Foundation, strengthening commitment to structured and transparent charitable work.",
                },
                {
                  year: "2026",
                  title: "Vision Forward",
                  description:
                    "Continuing to expand services across underserved communities in India with a focus on sustainability and self-reliance.",
                },
              ].map((item, index) => (
                <div key={item.year} className="flex gap-6 mb-8 last:mb-0">
                  <div className="flex flex-col items-center">
                    <div className="h-12 w-12 rounded-full bg-gradient-to-br from-orange-600 to-orange-700 flex items-center justify-center shrink-0 text-white text-sm font-bold">
                      {item.year}
                    </div>
                    {index < 3 && (
                      <div className="w-0.5 flex-1 bg-orange-200 mt-2" />
                    )}
                  </div>
                  <div className="pb-8">
                    <h3 className="text-xl font-bold text-slate-900 mt-1 mb-2">
                      {item.title}
                    </h3>
                    <p className="text-slate-600">{item.description}</p>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* ── COMMUNITY KITCHEN ────────────────────────────────────────── */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 lg:gap-20 items-start">
            {/* Left – content */}
            <div>
              <div className="inline-flex items-center gap-2 rounded-full bg-orange-100 px-4 py-1.5 text-sm font-semibold text-orange-700 mb-6">
                <Utensils className="h-4 w-4" />
                Our Core Mission
              </div>
              <h2 className="text-3xl md:text-4xl font-bold text-slate-900 mb-6">
                Community Kitchen
              </h2>
              <div className="prose prose-lg text-slate-600 max-w-none">
                <p>
                  The Community Kitchen is the heart of Daan Foundation. Every
                  evening, freshly prepared meals are provided free of cost to
                  those facing hunger and hardship.
                </p>

                <h4 className="text-base font-bold text-slate-900 mt-6 mb-3">
                  Who We Serve
                </h4>
                <div className="grid grid-cols-2 gap-2 not-prose mb-6">
                  {[
                    "Labourers",
                    "Elderly individuals",
                    "Widows",
                    "Orphans",
                    "Homeless persons",
                    "Poor families",
                    "Travellers",
                    "Anyone in need",
                  ].map((person) => (
                    <div
                      key={person}
                      className="flex items-center gap-2 text-sm text-slate-700"
                    >
                      <ChevronRight className="h-3.5 w-3.5 text-orange-500 shrink-0" />
                      {person}
                    </div>
                  ))}
                </div>

                <div className="not-prose rounded-xl bg-orange-50 border border-orange-100 p-4 mb-6">
                  <p className="text-orange-800 text-sm font-medium">
                    <strong>Equal Access for All</strong> — People from every
                    religion, caste, and background are welcomed without any
                    discrimination, with dignity and respect.
                  </p>
                </div>

                <h4 className="text-base font-bold text-slate-900 mt-6 mb-3">
                  Meals We Serve
                </h4>
                <ul className="not-prose space-y-1.5 mb-0">
                  {[
                    "Dal & roti",
                    "Rice-based meals",
                    "Vegetable curries",
                    "Seasonal food items",
                    "Special Ramadan Iftar meals",
                  ].map((meal) => (
                    <li
                      key={meal}
                      className="flex items-center gap-2 text-sm text-slate-700"
                    >
                      <ChevronRight className="h-3.5 w-3.5 text-orange-500 shrink-0" />
                      {meal}
                    </li>
                  ))}
                </ul>
              </div>
            </div>

            {/* Right – stats cards */}
            <div className="space-y-6">
              <div className="relative aspect-[4/3] rounded-3xl overflow-hidden">
                <img
                  src="/images/food-distribution-ramadan.jpg"
                  alt="Community Kitchen meal distribution"
                  className="h-full w-full object-cover"
                />
              </div>

              <div className="grid grid-cols-3 gap-4">
                <div className="bg-orange-50 border border-orange-100 rounded-2xl p-5 text-center">
                  <div className="text-2xl md:text-3xl font-bold text-orange-700 mb-1">
                    500K+
                  </div>
                  <div className="text-xs text-slate-600">
                    Meals served since 2020
                  </div>
                </div>
                <div className="bg-orange-50 border border-orange-100 rounded-2xl p-5 text-center">
                  <div className="text-2xl md:text-3xl font-bold text-orange-700 mb-1">
                    ₹59
                  </div>
                  <div className="text-xs text-slate-600">
                    Approx. cost per meal
                  </div>
                </div>
                <div className="bg-orange-50 border border-orange-100 rounded-2xl p-5 text-center">
                  <div className="text-2xl md:text-3xl font-bold text-orange-700 mb-1">
                    6+
                  </div>
                  <div className="text-xs text-slate-600">
                    Years of service
                  </div>
                </div>
              </div>

              <Link
                to="/community-kitchen"
                className="inline-flex items-center gap-2 text-orange-600 font-semibold hover:text-orange-700 transition-colors"
              >
                Learn more about Community Kitchen
                <ArrowRight className="h-4 w-4" />
              </Link>
            </div>
          </div>
        </div>
      </section>

      {/* ── OUR MISSION ──────────────────────────────────────────────── */}
      <section className="py-16 md:py-24 bg-gray-50">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-slate-900 mb-6">
              Our Mission
            </h2>
            <p className="text-2xl font-semibold text-orange-600 mb-6">
              "Ensuring that no one sleeps hungry."
            </p>
            <p className="text-lg text-slate-600 leading-relaxed">
              Food is one of the most basic human needs. Without it, a person
              cannot focus on health, education, or livelihood. Our primary
              mission is to feed the hungry every single day.
            </p>
          </div>

          <div className="max-w-4xl mx-auto">
            <p className="text-center text-slate-500 text-sm font-semibold uppercase tracking-wider mb-6">
              Alongside this, we also support communities through
            </p>
            <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
              {[
                { icon: Stethoscope, label: "Healthcare assistance" },
                { icon: GraduationCap, label: "Educational support" },
                { icon: Users, label: "Women support initiatives" },
                {
                  icon: Gem,
                  label: "Marriage support for underprivileged families",
                },
                { icon: AlertTriangle, label: "Emergency relief efforts" },
                {
                  icon: Briefcase,
                  label: "Livelihood opportunities for self-reliance",
                },
              ].map(({ icon: Icon, label }) => (
                <div
                  key={label}
                  className="flex items-center gap-3 p-4 rounded-xl bg-white border border-gray-100 shadow-sm"
                >
                  <div className="h-10 w-10 rounded-lg bg-orange-100 flex items-center justify-center shrink-0">
                    <Icon className="h-5 w-5 text-orange-600" />
                  </div>
                  <span className="font-medium text-slate-800 text-sm">
                    {label}
                  </span>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* ── OUR VALUES ───────────────────────────────────────────────── */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-slate-900 mb-4">
              Our Values
            </h2>
            <p className="text-lg text-slate-600 max-w-2xl mx-auto">
              The principles that guide every decision we make
            </p>
          </div>

          <div className="grid sm:grid-cols-2 lg:grid-cols-5 gap-6">
            {values.map(({ icon: Icon, title, description }) => (
              <div
                key={title}
                className="bg-white border border-gray-100 rounded-2xl p-6 text-center shadow-sm hover:shadow-md transition-shadow"
              >
                <div className="h-14 w-14 rounded-xl bg-gradient-to-br from-orange-600 to-orange-700 flex items-center justify-center mx-auto mb-4">
                  <Icon className="h-7 w-7 text-white" />
                </div>
                <h3 className="font-bold text-slate-900 mb-2">{title}</h3>
                <p className="text-sm text-slate-600">{description}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ── OUR ACHIEVEMENTS ─────────────────────────────────────────── */}
      <section className="py-16 md:py-24 bg-gray-50">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-slate-900 mb-4">
              Our Achievements
            </h2>
            <p className="text-lg text-slate-600 max-w-2xl mx-auto">
              Since 2020, Daan Foundation has served communities across India
            </p>
          </div>

          {/* Stat cards */}
          <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <div className="bg-white rounded-2xl p-6 text-center shadow-sm">
              <div className="h-14 w-14 rounded-xl bg-gradient-to-br from-orange-600 to-orange-700 flex items-center justify-center mx-auto mb-4">
                <Heart className="h-7 w-7 text-white" />
              </div>
              <div className="text-3xl md:text-4xl font-bold text-slate-900 mb-1">
                500,000+
              </div>
              <div className="text-sm text-slate-600">Meals Served</div>
            </div>
            <div className="bg-white rounded-2xl p-6 text-center shadow-sm">
              <div className="h-14 w-14 rounded-xl bg-gradient-to-br from-orange-600 to-orange-700 flex items-center justify-center mx-auto mb-4">
                <Utensils className="h-7 w-7 text-white" />
              </div>
              <div className="text-3xl md:text-4xl font-bold text-slate-900 mb-1">
                ₹59
              </div>
              <div className="text-sm text-slate-600">Cost Per Meal</div>
            </div>
            <div className="bg-white rounded-2xl p-6 text-center shadow-sm">
              <div className="h-14 w-14 rounded-xl bg-gradient-to-br from-orange-600 to-orange-700 flex items-center justify-center mx-auto mb-4">
                <Clock className="h-7 w-7 text-white" />
              </div>
              <div className="text-3xl md:text-4xl font-bold text-slate-900 mb-1">
                6+
              </div>
              <div className="text-sm text-slate-600">Years of Service</div>
            </div>
          </div>

          {/* Achievement list */}
          <div className="max-w-3xl mx-auto grid sm:grid-cols-2 gap-3">
            {achievements.map((item) => (
              <div
                key={item}
                className="flex items-start gap-3 bg-white rounded-xl p-4 shadow-sm"
              >
                <div className="mt-0.5 h-5 w-5 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                  <Award className="h-3 w-3 text-green-600" />
                </div>
                <span className="text-slate-700 text-sm font-medium">
                  {item}
                </span>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ── WHAT WE DO ───────────────────────────────────────────────── */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-slate-900 mb-4">
              What We Do
            </h2>
            <p className="text-lg text-slate-600 max-w-2xl mx-auto">
              Our programs address the most pressing needs of vulnerable
              communities
            </p>
          </div>

          <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            {whatWeDo.map(({ label, to, icon: Icon }) => (
              <Link
                key={label}
                to={to}
                className="group bg-white border border-gray-100 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-orange-200 transition-all"
              >
                <div className="h-12 w-12 rounded-xl bg-orange-100 flex items-center justify-center mb-4 group-hover:bg-orange-600 transition-colors">
                  <Icon className="h-6 w-6 text-orange-600 group-hover:text-white transition-colors" />
                </div>
                <h3 className="font-semibold text-slate-900 mb-2 group-hover:text-orange-700 transition-colors">
                  {label}
                </h3>
                <span className="inline-flex items-center gap-1 text-sm text-orange-600 font-medium">
                  Learn more
                  <ArrowRight className="h-3.5 w-3.5 group-hover:translate-x-1 transition-transform" />
                </span>
              </Link>
            ))}
          </div>
        </div>
      </section>

      {/* ── LEADERSHIP / TRUSTEES ────────────────────────────────────── */}
      <section className="py-16 md:py-24 bg-gray-50">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-slate-900 mb-4">
              Leadership &amp; Trustees
            </h2>
            <p className="text-lg text-slate-600 max-w-2xl mx-auto">
              Guided by integrity and a shared commitment to serve
            </p>
          </div>

          <div className="max-w-4xl mx-auto grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            {trustees.map(({ name, role }) => (
              <div
                key={name}
                className="bg-white rounded-2xl p-6 shadow-sm text-center"
              >
                <div className="h-16 w-16 rounded-full bg-gradient-to-br from-orange-600 to-orange-700 flex items-center justify-center mx-auto mb-4 text-white text-lg font-bold">
                  {name
                    .replace("Mr. ", "")
                    .split(" ")
                    .map((n) => n[0])
                    .slice(0, 2)
                    .join("")}
                </div>
                <h3 className="font-bold text-slate-900 mb-1">{name}</h3>
                <p className="text-sm text-orange-600 font-medium">{role}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ── VOLUNTEERS ───────────────────────────────────────────────── */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-slate-900 mb-4">
              Our Volunteers
            </h2>
            <p className="text-lg text-slate-600 max-w-2xl mx-auto">
              Daan Foundation is strengthened by dedicated volunteers who
              continuously support humanitarian activities.
            </p>
          </div>

          <div className="max-w-3xl mx-auto grid grid-cols-2 sm:grid-cols-4 gap-4">
            {volunteers.map((name) => (
              <div
                key={name}
                className="bg-white border border-gray-100 rounded-xl p-4 shadow-sm flex items-center gap-3"
              >
                <div className="h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 font-bold text-sm shrink-0">
                  {name
                    .split(" ")
                    .map((n) => n[0])
                    .slice(0, 2)
                    .join("")}
                </div>
                <span className="font-medium text-slate-900 text-sm">
                  {name}
                </span>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ── LOOKING AHEAD / FUTURE GOALS ─────────────────────────────── */}
      <section className="py-16 md:py-24 bg-gray-50">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-slate-900 mb-4">
              Looking Ahead
            </h2>
            <p className="text-lg text-slate-600 max-w-2xl mx-auto">
              Our vision for the future — expanding our reach and deepening our
              impact
            </p>
          </div>

          <div className="max-w-4xl mx-auto grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            {futureGoals.map(({ label, icon: Icon }) => (
              <div
                key={label}
                className="bg-white rounded-2xl p-6 shadow-sm flex items-start gap-4"
              >
                <div className="h-10 w-10 rounded-lg bg-orange-100 flex items-center justify-center shrink-0">
                  <Icon className="h-5 w-5 text-orange-600" />
                </div>
                <div>
                  <span className="font-semibold text-slate-900 text-sm">
                    {label}
                  </span>
                </div>
              </div>
            ))}
          </div>

          <div className="max-w-3xl mx-auto mt-12">
            <div className="rounded-2xl bg-white border border-orange-100 p-6 md:p-8 text-center">
              <Globe className="h-8 w-8 text-orange-600 mx-auto mb-4" />
              <p className="text-lg text-slate-700 leading-relaxed">
                Daan Foundation stands as a symbol of hope, compassion, and
                responsibility. From a small Ramadan initiative to a continuous
                humanitarian effort, the journey reflects the power of
                sincerity, trust, and collective kindness.
              </p>
              <p className="text-xl font-bold text-orange-600 mt-4">
                Together, we can build a hunger-free India.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* ── CTA ──────────────────────────────────────────────────────── */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="rounded-3xl bg-gradient-to-br from-orange-600 to-orange-700 p-8 md:p-12 text-center">
            <h2 className="text-3xl md:text-4xl font-bold text-white mb-4">
              Join Us in Making a Difference
            </h2>
            <p className="text-lg text-white/90 max-w-2xl mx-auto mb-8">
              Every contribution, volunteer effort, and act of kindness helps us
              move closer to a more compassionate society.
            </p>
            <div className="flex flex-wrap justify-center gap-4">
              <Link
                to="/donate"
                className="rounded-full bg-white px-8 py-4 text-base font-bold text-orange-600 shadow-xl hover:shadow-2xl hover:scale-105 transition-all"
              >
                Donate Now
              </Link>
              <Link
                to="/contact"
                className="rounded-full bg-white/20 px-8 py-4 text-base font-bold text-white hover:bg-white/30 transition-all"
              >
                Get in Touch
              </Link>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
}

export default About;
