import { Link } from "react-router-dom";
import { ArrowRight, Shirt, Users, CalendarDays, HandHeart, CheckCircle2, Quote } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";
import { DonationSidebar } from "@/components/donation/DonationSidebar";

const stats = [
  { number: "2,000+", label: "Garments Distributed", icon: Shirt },
  { number: "500+", label: "Families Helped", icon: Users },
  { number: "Seasonal", label: "Drives Year-Round", icon: CalendarDays },
  { number: "All", label: "Communities Served", icon: HandHeart },
];

const testimonials = [
  {
    quote:
      "When winter arrived, my children had no warm clothes. Daan Foundation brought new sweaters and blankets for my whole family. My children could finally go to school without shivering.",
    name: "Nasreen Bi",
    role: "Mother of Three",
  },
  {
    quote:
      "I work as a rickshaw puller and cannot afford new clothes. During their drive, I received a proper set of clothes that I wore with pride. It felt like a festival for me.",
    name: "Shankar",
    role: "Daily Wage Worker",
  },
  {
    quote:
      "I was worried about my grandchildren's school uniforms. When the Foundation provided brand-new uniforms, the joy on their faces was something I will never forget.",
    name: "Zubaida Khatoon",
    role: "Grandmother & Guardian",
  },
];

const whoWeServe = [
  "Daily wage workers who cannot afford seasonal clothing",
  "Widows and single mothers with limited means",
  "Orphaned and underprivileged children",
  "Elderly individuals living alone without family support",
  "Families displaced or affected by crisis situations",
];

export function ClothingDistribution() {
  return (
    <div>
      <SEO title="Clothing Distribution - Dignified Support" description="Daan Foundation provides dignified clothing support to families in need. Seasonal drives for winter woolens, school uniforms, and festival clothing across India." canonical="/our-work/clothing-distribution" keywords="clothing distribution charity India, winter clothing donation, school uniform charity, clothing drive" />
      <Breadcrumbs
        items={[
          { label: "Our Work", href: "/our-work/charity-in-action" },
          { label: "Clothing Distribution" },
        ]}
      />

      {/* Hero */}
      <section className="relative py-20 md:py-28 bg-gradient-to-br from-teal-600 to-emerald-600">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div>
              <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-6">
                Clothing Distribution
              </h1>
              <p className="text-2xl text-white/95 font-semibold mb-4">
                Providing Dignified Clothing to Families in Need
              </p>
              <p className="text-lg text-white/85 leading-relaxed mb-8">
                Daan Foundation provides dignified clothing support to families who cannot afford proper clothing.
                Through seasonal drives and year-round initiatives, we ensure that every individual receives new or
                excellent-condition garments — because everyone deserves to dress with dignity.
              </p>
              <Link
                to="/donate"
                className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-teal-600 hover:shadow-lg transition-shadow"
              >
                Support This Cause
                <ArrowRight className="h-5 w-5" />
              </Link>
            </div>
            <div className="hidden lg:block">
              <img
                src="/images/extra-1.jpg"
                alt="Clothing distribution drive"
                className="rounded-2xl shadow-2xl"
              />
            </div>
          </div>
        </div>
      </section>

      {/* Stats */}
      <section className="py-12 bg-slate-900">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
            {stats.map(({ number, label, icon: Icon }) => (
              <div key={label} className="text-center">
                <Icon className="h-8 w-8 text-teal-400 mx-auto mb-2" />
                <div className="text-2xl md:text-3xl font-bold text-white">{number}</div>
                <div className="text-sm text-slate-400">{label}</div>
              </div>
            ))}
          </div>
        </div>
      </section>

      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <div className="lg:grid lg:grid-cols-3 lg:gap-10">
          <div className="lg:col-span-2 space-y-10">

            {/* About */}
            <section>
              <h2 className="text-3xl font-bold text-slate-900 mb-6">Dignity Through Clothing</h2>
              <div className="prose prose-lg text-slate-600">
                <p>
                  For many families living below the poverty line, purchasing proper clothing — especially during seasonal
                  changes — is a luxury they simply cannot afford. Children go to school in torn uniforms, elderly
                  individuals face harsh winters without warm garments, and daily wage workers endure extreme weather
                  without adequate protection.
                </p>
                <p>
                  Daan Foundation conducts regular clothing distribution drives throughout the year, with special focus
                  during winter and festival seasons. We distribute winter woolens, festival clothing, and school uniforms
                  for children from underprivileged backgrounds.
                </p>
                <p>
                  Maintaining dignity is central to our approach. All items distributed are either brand-new or in
                  excellent condition, properly packed and presented with respect. We believe that receiving clothing
                  support should never feel like charity — it should feel like community caring for community.
                </p>
              </div>
            </section>

            <div className="border-t border-slate-200" />

            {/* Who We Serve */}
            <section>
              <div className="grid lg:grid-cols-2 gap-12 items-start">
                <div>
                  <h2 className="text-3xl font-bold text-slate-900 mb-6">Who We Serve</h2>
                  <p className="text-lg text-slate-600 mb-8">
                    Our clothing distribution reaches the most vulnerable members of our communities — people who often go
                    unnoticed and unsupported.
                  </p>
                  <ul className="space-y-4">
                    {whoWeServe.map((item) => (
                      <li key={item} className="flex items-start gap-3">
                        <CheckCircle2 className="h-6 w-6 text-teal-600 flex-shrink-0 mt-0.5" />
                        <span className="text-slate-700">{item}</span>
                      </li>
                    ))}
                  </ul>
                </div>
                <div>
                  <h2 className="text-3xl font-bold text-slate-900 mb-6">Our Seasonal Drives</h2>
                  <div className="space-y-4">
                    <div className="bg-white rounded-xl p-6 shadow-sm">
                      <h3 className="font-bold text-slate-900 mb-2">Winter Warmth Drive</h3>
                      <p className="text-slate-600">
                        Distributing sweaters, shawls, blankets, and warm clothing to protect families from bitter cold
                        during winter months.
                      </p>
                    </div>
                    <div className="bg-white rounded-xl p-6 shadow-sm">
                      <h3 className="font-bold text-slate-900 mb-2">Festival Clothing</h3>
                      <p className="text-slate-600">
                        New clothes for children and families during Eid, Diwali, and other celebrations — because every
                        child deserves to celebrate in new clothes.
                      </p>
                    </div>
                    <div className="bg-white rounded-xl p-6 shadow-sm">
                      <h3 className="font-bold text-slate-900 mb-2">School Uniform Program</h3>
                      <p className="text-slate-600">
                        Providing school uniforms, shoes, and socks to children from poor families so they can attend school
                        with confidence.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </section>

            <div className="border-t border-slate-200" />

            {/* Testimonials */}
            <section>
              <h2 className="text-3xl font-bold text-slate-900 mb-10 text-center">Voices From the Community</h2>
              <div className="grid md:grid-cols-3 gap-6">
                {testimonials.map((t) => (
                  <div key={t.name} className="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                    <Quote className="h-8 w-8 text-teal-200 mb-3" />
                    <p className="text-slate-600 italic mb-4">"{t.quote}"</p>
                    <div className="border-t border-slate-100 pt-4">
                      <div className="font-bold text-slate-900">{t.name}</div>
                      <div className="text-sm text-slate-500">{t.role}</div>
                    </div>
                  </div>
                ))}
              </div>
            </section>

          </div>

          <aside className="lg:col-span-1 mt-8 lg:mt-0">
            <div className="lg:sticky lg:top-24">
              <DonationSidebar defaultCause="where-needed" />
            </div>
          </aside>

        </div>
      </div>

      {/* CTA */}
      <section className="py-16 md:py-20 bg-gradient-to-br from-teal-600 to-emerald-600">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-white mb-4">Help Us Clothe Those in Need</h2>
          <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">
            A warm sweater in winter, a new uniform for school, festival clothes for a child — your donation can bring
            comfort and dignity to someone who has very little. Join Daan Foundation in our mission to serve with respect.
          </p>
          <Link
            to="/donate"
            className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-teal-600 hover:shadow-lg transition-shadow"
          >
            Donate Now
            <ArrowRight className="h-5 w-5" />
          </Link>
        </div>
      </section>
    </div>
  );
}

export default ClothingDistribution;
