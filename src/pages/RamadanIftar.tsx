import { Link } from "react-router-dom";
import { ArrowRight } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";

export function RamadanIftar() {
  return (
    <div>
      <Breadcrumbs items={[{ label: "Seasonal Giving" }, { label: "Ramadan Iftar" }]} />

      {/* Hero */}
      <section className="relative py-20 md:py-28 bg-gradient-to-br from-violet-600 to-purple-700">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div>
              <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-6">
                Ramadan With Daan Foundation
              </h1>
              <p className="text-xl text-white/90 leading-relaxed mb-8">
                Daan Foundation was born during the blessed month of Ramadan in 2020 through a simple humanitarian effort: providing Iftar meals to people in need. What started as a temporary relief effort gradually became a continuous humanitarian mission.
              </p>
              <Link
                to="/donate"
                className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-violet-600 hover:shadow-lg transition-shadow"
              >
                Support Ramadan Iftar
                <ArrowRight className="h-5 w-5" />
              </Link>
            </div>
            <div className="hidden lg:block">
              <img
                src="/images/iftaar-distribution.jpg"
                alt="Iftar distribution"
                className="rounded-2xl shadow-2xl"
              />
            </div>
          </div>
        </div>
      </section>

      {/* Journey */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl font-bold text-slate-900 mb-6">A Journey Built on Compassion & Trust</h2>
            <div className="prose prose-lg text-slate-600">
              <p>
                In the early days, Daan Foundation had no official office, no formal structure, no website, and very limited resources. Yet many people trusted the mission and supported the effort simply by seeing the sincerity and humanitarian intention behind the work.
              </p>
              <p>
                What began with support for around 1,000 people during the early Ramadan efforts has gradually expanded over the years. By Ramadan 2025, the foundation was helping provide Iftar support and meals to thousands of people through its Community Kitchen and Ramadan initiatives.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* Iftar Distribution */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Iftar Distribution Since 2020</h2>
            <div className="prose prose-lg text-slate-600">
              <p>Since its beginning, Daan Foundation has continued organizing Iftar Meal Distribution during Ramadan for:</p>
              <ul>
                <li>Labourers and daily wage workers</li>
                <li>Poor families</li>
                <li>Travellers and elderly people</li>
                <li>Patients and widows</li>
                <li>Financially struggling individuals</li>
              </ul>
              <p>
                The Foundation prioritizes those who cannot afford to arrange proper iftar meals, ensuring that even those fasting under hardship can break their fast with dignity.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* Spirit of Charity */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl font-bold text-slate-900 mb-6">The Spirit of Charity in Ramadan</h2>
            <div className="prose prose-lg text-slate-600">
              <p>
                Ramadan is a month in which Muslims increase Zakat, Sadaqah, charity, compassion, and humanitarian support. Through community support, Daan Foundation tries to continue this spirit of compassion by helping vulnerable people with Iftar meals, food support, ration kits, and humanitarian assistance.
              </p>
              <p>
                Daan Foundation believes hunger has no religion, caste, or social status. Meals are provided respectfully to anyone in need without discrimination.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 md:py-20 bg-violet-600">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-white mb-4">A Journey That Continues</h2>
          <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">
            From a small Ramadan Iftar effort in 2020 to a continuing humanitarian mission serving communities daily, every meal served represents kindness, trust, humanity, and hope.
          </p>
          <Link
            to="/donate"
            className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-violet-600 hover:shadow-lg transition-shadow"
          >
            Support Ramadan Iftar
            <ArrowRight className="h-5 w-5" />
          </Link>
        </div>
      </section>
    </div>
  );
}

export default RamadanIftar;
