import { Link } from "react-router-dom";
import { ArrowRight, Utensils, Heart, Users, BookOpen, Shirt, Stethoscope, Gift, HandHeart, Target, MapPin } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";
import { DonationSidebar } from "@/components/donation/DonationSidebar";

const timeline = [
  {
    year: "2020",
    title: "The Beginning — A Ramadan Initiative",
    icon: Heart,
    achievements: [
      "Started as a small 15-day Ramadan Iftar food distribution initiative by a group of volunteers",
      "Provided cooked meals and Iftar support to stranded labourers and struggling families during the nationwide lockdown",
      "What began as a temporary relief effort continued beyond Ramadan due to ongoing community need",
      "First community kitchen concept was born — serving free evening meals to anyone in need",
      "No formal structure, office, or website — purely volunteer-driven humanitarian work",
    ],
  },
  {
    year: "2021",
    title: "Building Momentum — Daily Operations Begin",
    icon: Utensils,
    achievements: [
      "Community Kitchen expanded from occasional to daily evening meal service",
      "Volunteer base grew significantly as more community members joined the mission",
      "Regular food distribution became a trusted community initiative",
      "First ration kit distributions organized for struggling families",
      "Foundation began receiving consistent support from local donors and well-wishers",
      "Relationship building with local communities, understanding their needs better",
    ],
  },
  {
    year: "2022",
    title: "Expanding Services & Outreach",
    icon: Users,
    achievements: [
      "Community Kitchen operations stabilised with daily meal preparation and distribution",
      "Began ration kit distribution as a regular program, not just during Ramadan",
      "Clothing support initiative launched — distributing winter clothes and essential garments",
      "Outreach extended to neighbouring areas beyond the initial location",
      "Increased support to widows, elderly individuals, and orphaned children",
      "More volunteers and local supporters joined, strengthening the foundation's capacity",
    ],
  },
  {
    year: "2023",
    title: "Official Registration & Structured Growth",
    icon: Target,
    achievements: [
      "Daan Foundation formally registered as a charitable trust — a major milestone",
      "Strengthened operational structure, financial transparency, and accountability systems",
      "Regular impact reporting and documentation processes established",
      "Education support program launched — helping poor children continue schooling",
      "Medical assistance program started — supporting patients who cannot afford treatment",
      "Winter relief drives organised with blankets and warm clothing distribution",
      "Community Kitchen continued daily operations uninterrupted throughout the year",
    ],
  },
  {
    year: "2024",
    title: "Scaling Impact Across Programs",
    icon: Shirt,
    achievements: [
      "Large-scale Ramadan Iftar programme serving thousands of fasting individuals",
      "Winter relief drives expanded significantly with more blankets, warm clothes, and shoes distributed",
      "Educational support program grew — more children sponsored with school supplies and fees",
      "Medical assistance program expanded — more patients supported with treatment and medicines",
      "Marriage assistance initiative launched — helping poor families with wedding expenses",
      "Crossed significant milestones in meals served and beneficiaries reached",
      "Stronger volunteer and donor networks established across the region",
    ],
  },
  {
    year: "2025",
    title: "Rapid Growth & New Initiatives",
    icon: Gift,
    achievements: [
      "Surpassed 500,000+ meals distributed through the Community Kitchen since inception",
      "Eid Gift Programme launched — bringing joy to children and families during Eid celebrations",
      "Livelihood support initiatives introduced — helping families become self-reliant",
      "Marriage assistance and clothing distribution programs expanded further",
      "Qurbani/community welfare initiatives organised successfully",
      "Regular ration kit distribution continued year-round to struggling families",
      "Stronger digital presence and donor communication systems established",
      "Community Trust and feedback mechanisms formalised",
    ],
  },
  {
    year: "2026",
    title: "Vision Forward — The Next Chapter",
    icon: HandHeart,
    achievements: [
      "Aiming to provide food to one lakh (100,000) beneficiaries every day",
      "Expanding Community Kitchen to multiple locations across the region",
      "Strengthening ration kit distribution network to reach more families",
      "Building sustainable livelihood programmes for long-term community empowerment",
      "Enhancing medical and educational support programmes",
      "Developing robust transparency and reporting systems",
      "Continued commitment to serving humanity with compassion, dignity, and responsibility",
    ],
  },
];

export function OurImpact() {
  return (
    <div>
      <SEO title="Our Impact - 6 Years of Service" description="Explore Daan Foundation's 6-year impact journey from 2020 to 2026. Timeline of achievements, milestones, and growth in serving communities across India." canonical="/our-work/impact" keywords="Daan Foundation impact, charity impact India, humanitarian achievements, 6 years service" />
      <Breadcrumbs items={[{ label: "Our Work", href: "/our-work/impact" }, { label: "Our Impact" }]} />

      <section className="relative py-20 md:py-28 bg-gradient-to-br from-orange-600 to-orange-700">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h1 className="text-4xl md:text-5xl font-extrabold text-white mb-6">Our Impact</h1>
          <p className="text-xl text-white/90 max-w-2xl mx-auto">
            A 6-Year Journey of Compassion, Growth &amp; Service — from a small Ramadan Iftar initiative to a trusted humanitarian mission serving communities across India.
          </p>
        </div>
      </section>

      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <div className="lg:grid lg:grid-cols-3 lg:gap-10">
          <div className="lg:col-span-2 space-y-10">

            <div className="rounded-2xl overflow-hidden shadow-lg">
              <img src="/images/community-queue.jpg" alt="Daan Foundation impact" className="w-full h-[300px] md:h-[400px] object-cover" />
            </div>

            {/* Overview Stats */}
            <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
              {[
                { number: "500,000+", label: "Meals Distributed", icon: Utensils },
                { number: "100K+", label: "Iftar Kits Distributed", icon: Heart },
                { number: "6+", label: "Years of Service", icon: Users },
                { number: "600K+", label: "Beneficiaries Reached", icon: HandHeart },
              ].map((s) => (
                <div key={s.label} className="bg-orange-50 rounded-2xl p-5 text-center">
                  <s.icon className="h-6 w-6 text-orange-500 mx-auto mb-2" />
                  <div className="text-2xl md:text-3xl font-bold text-orange-600 mb-1">{s.number}</div>
                  <div className="text-xs text-slate-600">{s.label}</div>
                </div>
              ))}
            </div>

            <div className="border-t border-slate-200" />

            <section className="text-center max-w-3xl mx-auto">
              <h2 className="text-3xl font-bold text-slate-900 mb-6">Our Journey of Humanity (2020–2026)</h2>
              <p className="text-lg text-slate-600">Daan Foundation was born during the blessed month of Ramadan in 2020 through a simple humanitarian effort: providing Iftar meals to people in need. What started as a temporary 15-day relief effort has grown into a continuous humanitarian mission serving thousands of people daily.</p>
            </section>

            <div className="border-t border-slate-200" />

            {/* Timeline */}
            <div className="relative">
              {timeline.map((t, index) => {
                const Icon = t.icon;
                return (
                  <div key={t.year} className="relative pl-12 pb-12 last:pb-0">
                    {/* Timeline line */}
                    {index < timeline.length - 1 && (
                      <div className="absolute left-[21px] top-12 bottom-0 w-0.5 bg-gradient-to-b from-orange-400 to-orange-200" />
                    )}
                    {/* Year circle */}
                    <div className="absolute left-0 top-0 h-11 w-11 rounded-full bg-orange-500 text-white flex items-center justify-center text-xs font-bold shadow-md z-10">
                      {t.year}
                    </div>
                    {/* Content card */}
                    <div className="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow ml-4">
                      <div className="flex items-center gap-3 mb-4">
                        <div className="h-10 w-10 rounded-xl bg-orange-100 flex items-center justify-center">
                          <Icon className="h-5 w-5 text-orange-600" />
                        </div>
                        <h3 className="text-xl font-bold text-slate-900">{t.title}</h3>
                      </div>
                      <ul className="space-y-2">
                        {t.achievements.map((item) => (
                          <li key={item} className="flex items-start gap-3">
                            <span className="h-2 w-2 rounded-full bg-orange-400 mt-2 flex-shrink-0" />
                            <span className="text-slate-600">{item}</span>
                          </li>
                        ))}
                      </ul>
                    </div>
                  </div>
                );
              })}
            </div>

            <div className="border-t border-slate-200" />

            {/* Programs */}
            <section className="bg-[#F3F4F6] rounded-2xl p-6 md:p-8">
              <h2 className="text-3xl font-bold text-slate-900 mb-4 text-center">Our Programs</h2>
              <p className="text-lg text-slate-600 text-center mb-8 max-w-2xl mx-auto">Supporting communities through sustainable development.</p>
              <div className="grid md:grid-cols-3 gap-4">
                {[
                  { title: "Community Kitchen", desc: "Daily free meal distribution serving freshly cooked food every evening.", href: "/community-kitchen" },
                  { title: "Ration Kit Distribution", desc: "Essential food supplies for struggling families year-round.", href: "/our-work/ration-kit-distribution" },
                  { title: "Fidyah & Kaffarah", desc: "Fulfil your Islamic obligation by feeding the needy.", href: "/fidya" },
                ].map((p) => (
                  <Link key={p.title} to={p.href} className="bg-white rounded-xl p-5 shadow-sm hover:shadow-lg transition-shadow group">
                    <h3 className="font-bold text-slate-900 mb-2 group-hover:text-orange-600 transition-colors">{p.title}</h3>
                    <p className="text-slate-600 text-sm mb-3">{p.desc}</p>
                    <span className="text-orange-500 text-sm font-semibold flex items-center gap-1">
                      Learn more <ArrowRight className="h-4 w-4" />
                    </span>
                  </Link>
                ))}
              </div>
            </section>

            <div className="border-t border-slate-200" />

            <section className="bg-blue-50 rounded-xl p-5 border border-blue-200">
              <div className="flex items-start gap-4">
                <MapPin className="h-6 w-6 text-blue-600 flex-shrink-0 mt-1" />
                <div>
                  <h3 className="font-bold text-slate-900 text-lg">Working Only Within India</h3>
                  <p className="text-slate-600 mt-1">Daan Foundation operates only within India and focuses entirely on charitable and humanitarian activities within Indian geography.</p>
                </div>
              </div>
            </section>

            <div className="border-t border-slate-200" />

            <section className="bg-gradient-to-r from-orange-600 to-orange-700 rounded-2xl p-8 md:p-10 text-center">
              <h2 className="text-3xl font-bold text-white mb-4">Every Meal Is More Than Food</h2>
              <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">
                It is dignity, hope, and humanity. Together, we can build a future where no one sleeps hungry.
              </p>
              <Link to="/donate" className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-orange-600 hover:shadow-lg transition-shadow">
                Donate Now <ArrowRight className="h-5 w-5" />
              </Link>
            </section>

          </div>

          <aside className="lg:col-span-1 mt-8 lg:mt-0">
            <div className="lg:sticky lg:top-24">
              <DonationSidebar defaultCause="where-needed" />
            </div>
          </aside>

        </div>
      </div>
    </div>
  );
}

export default OurImpact;