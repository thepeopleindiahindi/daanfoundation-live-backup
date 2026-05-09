import { Link } from "react-router-dom";
import { ArrowRight } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";

export function History() {
  return (
    <div>
      <Breadcrumbs items={[{ label: "Our Work", href: "/our-work/impact" }, { label: "The History of Daan Foundation" }]} />

      <section className="relative py-20 md:py-28 bg-gradient-to-br from-slate-700 to-slate-900">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h1 className="text-4xl md:text-5xl font-extrabold text-white mb-6">The History of Daan Foundation</h1>
          <p className="text-xl text-white/90 max-w-2xl mx-auto">
            From a small iftar initiative to a movement serving hundreds of thousands — our journey of service and compassion.
          </p>
        </div>
      </section>

      {/* Origins */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl font-bold text-slate-900 mb-6">How It All Began</h2>
            <p className="text-lg text-slate-600 leading-relaxed mb-6">
              Daan Foundation was founded in 2020 during Ramadan with a small iftar initiative that lasted 15 days. There was no official office, no formal structure — just a few volunteers driven by the desire to serve those in need.
            </p>
            <p className="text-lg text-slate-600 leading-relaxed">
              What started as a humble effort to feed a few hungry people during the holy month quickly grew into something much larger. The Community Kitchen became the core mission, operating daily since 2020 — serving freshly cooked meals every evening.
            </p>
          </div>
        </div>
      </section>

      {/* Timeline */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl font-bold text-slate-900 mb-10 text-center">Our Growth Journey</h2>
          <div className="max-w-3xl mx-auto space-y-6">
            {[
              { year: "2020", title: "The Beginning", desc: "Started as a small local iftar initiative during Ramadan. Community Kitchen launched, serving daily evening meals with limited resources and strong community trust." },
              { year: "2021–2022", title: "Expansion", desc: "Expansion of food distribution across more communities. Increase in volunteer participation and growing trust from local families." },
              { year: "2023", title: "Official Registration", desc: "Official legal registration of Daan Foundation. Strengthening of operational systems and accountability measures." },
              { year: "2024–2026", title: "Significant Growth", desc: "Significant growth in outreach to 600,000+ beneficiaries. Large-scale Ramadan programmes, continuous daily food distribution, and expansion of community kitchen efforts." },
            ].map((t) => (
              <div key={t.year} className="flex gap-6">
                <div className="flex flex-col items-center">
                  <div className="h-12 w-12 rounded-full bg-slate-800 text-white flex items-center justify-center text-xs font-bold shrink-0">{t.year.slice(0, 4)}</div>
                  <div className="w-px flex-1 bg-slate-300" />
                </div>
                <div className="pb-6">
                  <h3 className="text-lg font-bold text-slate-900">{t.title}</h3>
                  <p className="text-slate-600">{t.desc}</p>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-slate-900 mb-4">Be Part of Our Story</h2>
          <p className="text-lg text-slate-600 mb-8 max-w-2xl mx-auto">
            Our history is still being written. Join us in building a future where no one goes hungry.
          </p>
          <Link
            to="/donate"
            className="inline-flex items-center gap-2 rounded-full bg-slate-800 px-8 py-4 text-lg font-semibold text-white shadow-lg hover:bg-slate-900 transition-colors"
          >
            Donate Now <ArrowRight className="h-5 w-5" />
          </Link>
        </div>
      </section>
    </div>
  );
}

export default History;
