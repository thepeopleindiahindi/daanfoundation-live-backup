import { Link } from "react-router-dom";
import { ArrowRight } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";

export function OurImpact() {
  return (
    <div>
      <Breadcrumbs items={[{ label: "Our Work", href: "/our-work/impact" }, { label: "Our Impact" }]} />

      <section className="relative py-20 md:py-28 bg-gradient-to-br from-orange-600 to-orange-700">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h1 className="text-4xl md:text-5xl font-extrabold text-white mb-6">Our Impact</h1>
          <p className="text-xl text-white/90 max-w-2xl mx-auto">
            Together, we are making a meaningful difference in the lives of those who need it most.
          </p>
        </div>
      </section>

      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          {/* Stats */}
          <div className="grid grid-cols-2 md:grid-cols-4 gap-6 mb-16">
            {[
              { number: "500,000+", label: "Food Packets Distributed" },
              { number: "100,000+", label: "Food & Iftar Kits Distributed" },
              { number: "14+", label: "Years of Experience" },
              { number: "600,000+", label: "Total Beneficiaries Reached" },
            ].map((s) => (
              <div key={s.label} className="bg-orange-50 rounded-2xl p-6 text-center">
                <div className="text-3xl md:text-4xl font-bold text-orange-600 mb-2">{s.number}</div>
                <div className="text-sm text-slate-600">{s.label}</div>
              </div>
            ))}
          </div>

          {/* Growth Journey */}
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl font-bold text-slate-900 mb-8">Growth Journey (2020–2026)</h2>
            <div className="space-y-6">
              {[
                { year: "2020", title: "The Beginning", desc: "Foundation began as a small local iftar initiative during Ramadan with limited resources and strong community trust." },
                { year: "2021–2022", title: "Expansion", desc: "Expansion of food distribution and increase in volunteer participation." },
                { year: "2023", title: "Official Registration", desc: "Official legal registration of Daan Foundation and strengthening of operational systems." },
                { year: "2024–2026", title: "Significant Growth", desc: "Significant growth in outreach, thousands of beneficiaries during Ramadan, continuous daily food distribution, and expansion of community kitchen efforts." },
              ].map((t) => (
                <div key={t.year} className="flex gap-6">
                  <div className="flex flex-col items-center">
                    <div className="h-10 w-10 rounded-full bg-orange-500 text-white flex items-center justify-center text-xs font-bold shrink-0">{t.year.slice(0,4)}</div>
                    <div className="w-px flex-1 bg-orange-200" />
                  </div>
                  <div className="pb-6">
                    <h3 className="font-bold text-slate-900">{t.title}</h3>
                    <p className="text-slate-600">{t.desc}</p>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Programs */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl font-bold text-slate-900 mb-4 text-center">Our Programs</h2>
          <p className="text-lg text-slate-600 text-center mb-10 max-w-2xl mx-auto">Supporting communities through sustainable development.</p>
          <div className="grid md:grid-cols-3 gap-6 max-w-4xl mx-auto">
            {[
              { title: "Community Kitchen", desc: "Daily free meal distribution to people in need, serving freshly cooked food every evening.", href: "/community-kitchen" },
              { title: "Iftar Distribution", desc: "Large-scale Ramadan iftar programme serving thousands of fasting individuals.", href: "/ramadan" },
              { title: "Education Support", desc: "Helping poor children continue education and supporting families with school needs.", href: "/our-work/impact" },
            ].map((p) => (
              <Link key={p.title} to={p.href} className="bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg transition-shadow group">
                <h3 className="font-bold text-slate-900 mb-2 group-hover:text-orange-600 transition-colors">{p.title}</h3>
                <p className="text-slate-600 text-sm mb-4">{p.desc}</p>
                <span className="text-orange-500 text-sm font-semibold flex items-center gap-1">
                  Learn more <ArrowRight className="h-4 w-4" />
                </span>
              </Link>
            ))}
          </div>
        </div>
      </section>

      <section className="py-16 md:py-20 bg-orange-600">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-white mb-4">Every Meal Is More Than Food</h2>
          <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">
            It is dignity, hope, and humanity. Together, we can build a future where no one sleeps hungry.
          </p>
          <Link to="/donate" className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-orange-600 hover:shadow-lg transition-shadow">
            Donate Now <ArrowRight className="h-5 w-5" />
          </Link>
        </div>
      </section>
    </div>
  );
}

export default OurImpact;
