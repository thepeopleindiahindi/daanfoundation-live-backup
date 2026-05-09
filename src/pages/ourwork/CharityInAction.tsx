import { Link } from "react-router-dom";
import { ArrowRight } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";

export function CharityInAction() {
  return (
    <div>
      <Breadcrumbs items={[{ label: "Our Work", href: "/our-work/impact" }, { label: "Your Charity in Action" }]} />

      <section className="relative py-20 md:py-28 bg-gradient-to-br from-orange-600 to-amber-600">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h1 className="text-4xl md:text-5xl font-extrabold text-white mb-6">Your Charity in Action</h1>
          <p className="text-xl text-white/90 max-w-2xl mx-auto">
            See how your generous donations are transformed into real impact — meals served, families supported, and lives changed.
          </p>
        </div>
      </section>

      {/* Core Work */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl font-bold text-slate-900 mb-6">How Your Donations Are Used</h2>
            <p className="text-lg text-slate-600 leading-relaxed mb-6">
              Daan Foundation uses donations to serve freshly prepared evening meals through the Community Kitchen, provide iftar meals during Ramadan, and distribute ration kits to struggling families. We support widows, labourers, elderly individuals, and homeless people — ensuring no one is left behind.
            </p>
            <div className="bg-orange-50 border-l-4 border-orange-500 rounded-r-xl p-6 mb-8">
              <p className="text-xl font-semibold text-orange-700 italic">"No person should sleep hungry."</p>
            </div>
            <p className="text-lg text-slate-600 leading-relaxed">
              Since 2020, over <span className="font-bold text-slate-900">500,000+ meals</span> have been distributed to communities in need — a testament to the power of collective generosity.
            </p>
          </div>
        </div>
      </section>

      {/* Additional Services */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl font-bold text-slate-900 mb-10 text-center">Beyond Meals</h2>
          <div className="grid md:grid-cols-3 gap-6 max-w-4xl mx-auto">
            {[
              { title: "Clothing Distribution", desc: "Providing dignified clothing to families and individuals who cannot afford it." },
              { title: "Medical Assistance", desc: "Supporting medical needs and health-related expenses for vulnerable families." },
              { title: "Educational Support", desc: "Helping children from poor families continue their education." },
              { title: "Marriage Assistance", desc: "Supporting poor families with marriage-related expenses for their children." },
              { title: "Livelihood Support", desc: "Providing small livelihood support to help families become self-reliant." },
              { title: "Ration Kits", desc: "Distributing essential food ration kits to struggling families throughout the year." },
            ].map((item) => (
              <div key={item.title} className="bg-white rounded-2xl p-6 shadow-sm">
                <h3 className="font-bold text-slate-900 mb-2">{item.title}</h3>
                <p className="text-slate-600 text-sm">{item.desc}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-slate-900 mb-4">Put Your Charity Into Action</h2>
          <p className="text-lg text-slate-600 mb-8 max-w-2xl mx-auto">
            Every donation you make is used to serve those who need it most. Join us in making a real difference.
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

export default CharityInAction;
