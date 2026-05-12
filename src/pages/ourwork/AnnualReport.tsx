import { Link } from "react-router-dom";
import { ArrowRight } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";

export function AnnualReport() {
  return (
    <div>
      <SEO title="Annual Impact Report 2023-2026" description="Daan Foundation's annual impact report covering achievements, financial transparency, and humanitarian milestones from 2023 to 2026." canonical="/our-work/annual-report" keywords="annual report charity, impact report, financial transparency NGO, charity achievements India" />
      <Breadcrumbs items={[{ label: "Our Work", href: "/our-work/impact" }, { label: "Annual Impact Report (2023–2026)" }]} />

      <section className="relative py-20 md:py-28 bg-gradient-to-br from-orange-600 to-orange-700">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h1 className="text-4xl md:text-5xl font-extrabold text-white mb-6">Annual Impact Report (2023–2026)</h1>
          <p className="text-xl text-white/90 max-w-2xl mx-auto">
            A transparent look at our journey, impact, and the communities we have served since our founding.
          </p>
        </div>
      </section>

      {/* Overview */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Foundation Overview</h2>
            <p className="text-lg text-slate-600 leading-relaxed mb-6">
              Daan Foundation was founded in 2020 and officially registered in 2023. From humble beginnings as a small iftar initiative, we have grown into an organisation serving hundreds of thousands of people across communities in need.
            </p>
          </div>

          {/* Key Stats */}
          <div className="grid grid-cols-2 md:grid-cols-3 gap-6 max-w-4xl mx-auto mt-10">
            {[
              { number: "500,000+", label: "Meals Distributed" },
              { number: "1,000s", label: "Served Annually During Ramadan" },
              { number: "365", label: "Days of Daily Meals" },
            ].map((s) => (
              <div key={s.label} className="bg-orange-50 rounded-2xl p-6 text-center">
                <div className="text-3xl md:text-4xl font-bold text-orange-600 mb-2">{s.number}</div>
                <div className="text-sm text-slate-600">{s.label}</div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Core Mission */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Core Mission</h2>
            <ul className="space-y-4">
              {[
                "Daily meals through Community Kitchen — no individual remains hungry",
                "Serve all without discrimination, regardless of background",
                "Expand food access during Ramadan with large-scale iftar programmes",
                "Support vulnerable families with ration kits throughout the year",
              ].map((item) => (
                <li key={item} className="flex gap-3 text-slate-600">
                  <span className="h-2 w-2 rounded-full bg-orange-500 mt-2.5 shrink-0" />
                  {item}
                </li>
              ))}
            </ul>
          </div>
        </div>
      </section>

      {/* Community Kitchen */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Community Kitchen</h2>
            <p className="text-lg text-slate-600 leading-relaxed mb-4">
              The Community Kitchen is at the heart of everything we do. Every evening, freshly cooked meals are prepared and distributed to labourers, families, elderly individuals, and anyone in need.
            </p>
            <div className="bg-orange-50 rounded-xl p-6">
              <p className="text-slate-600">
                <span className="font-semibold text-slate-900">Approximate cost per meal:</span> ₹59
              </p>
              <p className="text-slate-600 mt-2">
                Operating daily since 2020, the Community Kitchen has served hundreds of thousands of meals — one plate at a time.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* Ramadan Programme */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Ramadan Programme</h2>
            <p className="text-lg text-slate-600 leading-relaxed">
              What began as a small iftar for a few families has grown into a large-scale Ramadan programme. Each year, we serve thousands of fasting individuals with iftar meals and distribute ration kits to struggling families throughout the holy month. Our volunteer-driven team works tirelessly to ensure every family is served.
            </p>
          </div>
        </div>
      </section>

      {/* Looking Ahead */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Looking Ahead</h2>
            <div className="grid sm:grid-cols-2 gap-6">
              {[
                { title: "Expand Community Kitchens", desc: "Open additional community kitchen locations to serve more areas." },
                { title: "Increase Daily Capacity", desc: "Grow the number of meals prepared and distributed every evening." },
                { title: "Strengthen Ramadan Outreach", desc: "Expand our Ramadan iftar and ration distribution programmes." },
                { title: "Support More Families", desc: "Reach more vulnerable families with food, livelihood, and welfare support." },
              ].map((item) => (
                <div key={item.title} className="bg-orange-50 rounded-xl p-5">
                  <h3 className="font-bold text-slate-900 mb-1">{item.title}</h3>
                  <p className="text-sm text-slate-600">{item.desc}</p>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-slate-900 mb-4">Help Us Grow Our Impact</h2>
          <p className="text-lg text-slate-600 mb-8 max-w-2xl mx-auto">
            Your donation fuels our mission to serve more meals, reach more families, and build a hunger-free future.
          </p>
          <Link
            to="/donate"
            className="inline-flex items-center gap-2 rounded-full bg-orange-600 px-8 py-4 text-lg font-semibold text-white shadow-lg hover:bg-orange-700 transition-colors"
          >
            Donate Now <ArrowRight className="h-5 w-5" />
          </Link>
        </div>
      </section>
    </div>
  );
}

export default AnnualReport;
