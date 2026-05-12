import { Link } from "react-router-dom";
import { ArrowRight } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";

export function WhyTransparency() {
  return (
    <div>
      <SEO title="Why Transparency Matters" description="Daan Foundation's commitment to 100% transparency. Learn why we believe every donor deserves to know exactly how their charity is used." canonical="/our-work/why-transparency" keywords="charity transparency, transparent NGO India, donation accountability, how donations used" />
      <Breadcrumbs items={[{ label: "Our Work", href: "/our-work/impact" }, { label: "Why Transparency Matters" }]} />

      <section className="relative py-20 md:py-28 bg-gradient-to-br from-cyan-600 to-blue-700">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h1 className="text-4xl md:text-5xl font-extrabold text-white mb-6">Why Transparency Matters</h1>
          <p className="text-xl text-white/90 max-w-2xl mx-auto">
            Honest, accountable, and community-driven — transparency is the foundation of everything we do.
          </p>
        </div>
      </section>

      {/* Our Model */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Our Approach to Transparency</h2>
            <p className="text-lg text-slate-600 leading-relaxed mb-6">
              Daan Foundation does not follow a traditional large organisational model. We work directly among communities, staying close to the people we serve. This direct involvement ensures that every donation is used exactly where it is needed most.
            </p>
            <p className="text-lg text-slate-600 leading-relaxed">
              Every donation is treated as an <span className="font-semibold text-slate-900">amanah</span> (trust) — and we take that responsibility seriously.
            </p>
          </div>
        </div>
      </section>

      {/* Pillars */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl font-bold text-slate-900 mb-10 text-center">Pillars of Transparency</h2>
          <div className="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto">
            {[
              { title: "Direct Community Involvement", desc: "Working on the ground, directly with the families and individuals we serve." },
              { title: "Honest Use of Donations", desc: "Every rupee is accounted for and used for its intended charitable purpose." },
              { title: "Regular Updates", desc: "Providing regular updates to donors on how their contributions are making an impact." },
              { title: "Accountability", desc: "Annual reporting system to ensure accountability and build donor confidence." },
            ].map((item) => (
              <div key={item.title} className="bg-white rounded-2xl p-6 shadow-sm">
                <h3 className="font-bold text-slate-900 mb-2">{item.title}</h3>
                <p className="text-slate-600 text-sm">{item.desc}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Important Note */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto">
            <div className="bg-cyan-50 border-l-4 border-cyan-500 rounded-r-xl p-6">
              <h3 className="font-bold text-slate-900 mb-2">India-Focused Operations</h3>
              <p className="text-slate-600">
                Daan Foundation works only within India. All our charitable activities are focused on serving Indian communities, and we maintain full transparency in our local operations.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-slate-900 mb-4">Support Transparent Giving</h2>
          <p className="text-lg text-slate-600 mb-8 max-w-2xl mx-auto">
            When you donate to Daan Foundation, you can trust that your contribution is used with integrity and purpose.
          </p>
          <Link
            to="/donate"
            className="inline-flex items-center gap-2 rounded-full bg-cyan-600 px-8 py-4 text-lg font-semibold text-white shadow-lg hover:bg-cyan-700 transition-colors"
          >
            Donate Now <ArrowRight className="h-5 w-5" />
          </Link>
        </div>
      </section>
    </div>
  );
}

export default WhyTransparency;
