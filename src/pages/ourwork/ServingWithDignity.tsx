import { Link } from "react-router-dom";
import { ArrowRight } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";

export function ServingWithDignity() {
  return (
    <div>
      <SEO title="Serving Every Person With Dignity" description="At Daan Foundation, every person is served with dignity regardless of religion, caste, or background. Our commitment to respectful humanitarian service." canonical="/our-work/serving-with-dignity" keywords="serve with dignity, inclusive charity, humanitarian values, respectful service India" />
      <Breadcrumbs items={[{ label: "Our Work", href: "/our-work/impact" }, { label: "Serving Every Needy Person With Dignity" }]} />

      <section className="relative py-20 md:py-28 bg-gradient-to-br from-rose-600 to-pink-700">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h1 className="text-4xl md:text-5xl font-extrabold text-white mb-6">Serving Every Needy Person With Dignity</h1>
          <p className="text-xl text-white/90 max-w-2xl mx-auto">
            Humanitarian work should reach every deserving person — without discrimination, without conditions.
          </p>
        </div>
      </section>

      {/* Philosophy */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Our Belief</h2>
            <p className="text-lg text-slate-600 leading-relaxed mb-6">
              Daan Foundation believes humanitarian work should reach every deserving person without discrimination. Whether it is a hungry labourer, an elderly widow, a struggling mother, a child needing support, or a poor family during Ramadan — everyone deserves to be served with dignity and compassion.
            </p>
            <p className="text-lg text-slate-600 leading-relaxed">
              All communities are welcomed equally. Our doors are open to anyone in need, regardless of background.
            </p>
          </div>
        </div>
      </section>

      {/* Commitments */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl font-bold text-slate-900 mb-10 text-center">Our Commitments</h2>
          <div className="grid md:grid-cols-3 gap-6 max-w-4xl mx-auto">
            {[
              { title: "Meals During Ramadan", desc: "Ensuring poor families receive nutritious meals during the holy month of Ramadan." },
              { title: "Women & Children", desc: "Making sure women and children don't sleep hungry — providing daily meals and ration support." },
              { title: "Elderly & Vulnerable", desc: "Ensuring elderly and vulnerable individuals receive regular food support and care." },
            ].map((item) => (
              <div key={item.title} className="bg-white rounded-2xl p-8 shadow-sm text-center">
                <h3 className="text-lg font-bold text-slate-900 mb-3">{item.title}</h3>
                <p className="text-slate-600">{item.desc}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Who We Serve */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Who We Serve</h2>
            <ul className="space-y-4">
              {[
                "Hungry labourers who work all day and struggle to afford meals",
                "Elderly widows with no family support",
                "Struggling mothers trying to feed their children",
                "Children in need of food, clothing, and educational support",
                "Poor families during Ramadan and throughout the year",
                "Homeless individuals and travelers without access to food",
              ].map((item) => (
                <li key={item} className="flex gap-3 text-slate-600">
                  <span className="h-2 w-2 rounded-full bg-rose-500 mt-2.5 shrink-0" />
                  {item}
                </li>
              ))}
            </ul>
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-slate-900 mb-4">Help Us Serve With Dignity</h2>
          <p className="text-lg text-slate-600 mb-8 max-w-2xl mx-auto">
            Your donation ensures every person in need is treated with respect and compassion.
          </p>
          <Link
            to="/donate"
            className="inline-flex items-center gap-2 rounded-full bg-rose-600 px-8 py-4 text-lg font-semibold text-white shadow-lg hover:bg-rose-700 transition-colors"
          >
            Donate Now <ArrowRight className="h-5 w-5" />
          </Link>
        </div>
      </section>
    </div>
  );
}

export default ServingWithDignity;
