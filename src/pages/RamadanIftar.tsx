import { Link } from "react-router-dom";
import { ArrowRight, Utensils, Users, Heart, Clock, Star, MapPin } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";
import ProjectPageLayout from "@/components/donation/ProjectPageLayout";

export function RamadanIftar() {
  return (
    <div>
      <SEO title="Ramadan With Daan Foundation" description="Support Daan Foundation's Ramadan Iftar program. Since 2020, we've been providing iftar meals to fasting families. Your donation helps feed thousands during the holy month." canonical="/ramadan" keywords="ramadan iftar program, iftar meals India, ramadan charity, ramadan food distribution" />
      <Breadcrumbs items={[{ label: "Ramadan With Daan Foundation" }]} />

      <section className="relative bg-gradient-to-br from-violet-600 to-purple-700">
        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 md:py-16">
          <div className="max-w-3xl">
            <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-4">Ramadan With Daan Foundation</h1>
            <p className="text-xl text-white/90 leading-relaxed max-w-2xl">Daan Foundation was born during the blessed month of Ramadan in 2020 through a simple humanitarian effort: providing Iftar meals to people in need.</p>
          </div>
        </div>
      </section>

      <ProjectPageLayout defaultCause="ramadan-iftar">
        <div className="space-y-10">

          <div className="rounded-2xl overflow-hidden shadow-lg">
            <img src="/images/iftaar-distribution.jpg" alt="Ramadan iftar distribution" className="w-full h-[300px] md:h-[400px] object-cover" />
          </div>

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">A Journey Built on Compassion &amp; Trust</h2>
            <p className="text-slate-600 leading-relaxed">
              Daan Foundation was born during the blessed month of Ramadan in 2020 through a simple humanitarian effort: providing Iftar meals to people in need.
            </p>
            <p className="text-slate-600 leading-relaxed mt-4">
              At that time, the initiative was not planned as a large organization or long-term project. It began as a small community effort intended to run only from the 15th fast of Ramadan until Eid — approximately 15 days. A few people came together with the intention of helping needy individuals who struggled to arrange food for Iftar during Ramadan.
            </p>
            <p className="text-slate-600 leading-relaxed mt-4">
              What started as a temporary relief effort gradually became a continuous humanitarian mission that still continues today.
            </p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-violet-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Early Days</h2>
            <p className="text-slate-600">In the early days, Daan Foundation had no official office, no formal structure, no website, and very limited resources. Yet many people trusted the mission and supported the effort simply by seeing the sincerity and humanitarian intention behind the work. Local supporters, volunteers, and well-wishers encouraged the continuation of the project and believed that feeding hungry people was a noble and necessary effort.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Ramadan — A Month of Compassion</h2>
            <p className="text-slate-600">Ramadan is a sacred and deeply spiritual month for Muslims around the world. It is a month of fasting, prayer, patience, charity, compassion, and helping those in need. While many families break their fasts peacefully, countless vulnerable individuals struggle to arrange even a single meal for Iftar. This is where humanitarian support becomes important.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Iftar Distribution Since 2020</h2>
            <p className="text-slate-600 mb-4">Since its beginning, Daan Foundation has continued organizing Iftar Meal Distribution during Ramadan for:</p>
            <div className="grid grid-cols-2 md:grid-cols-5 gap-3 mb-6">
              {["Labourers", "Poor families", "Travellers", "Elderly people", "Patients", "Widows", "Financially struggling", "Orphans", "Daily wage workers", "Homeless"].map((item) => (
                <div key={item} className="bg-white rounded-xl px-3 py-2 shadow-sm text-center text-sm font-medium text-slate-700">
                  {item}
                </div>
              ))}
            </div>
            <p className="text-slate-600">What began with support for around 1,000 people during the early Ramadan efforts has gradually expanded over the years. By Ramadan 2025, the foundation was helping provide Iftar support and meals to thousands of people through its Community Kitchen and Ramadan initiatives.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Community Kitchen — Continuing Beyond Ramadan</h2>
            <p className="text-slate-600">One of the most remarkable parts of this journey is that the work did not stop after Ramadan ended. The original Iftar initiative gradually transformed into a Daily Community Kitchen that continues serving free evening meals throughout the year.</p>
            <p className="text-2xl font-bold text-violet-600 bg-violet-50 rounded-xl p-4 text-center mt-4">500,000+ Meals served since 2020</p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-emerald-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Food Without Discrimination</h2>
            <p className="text-slate-600">Daan Foundation believes hunger has no religion, caste, or social status. Meals are provided respectfully to anyone in need without discrimination based on religion, caste, language, or community background. The organization&rsquo;s goal is simple: that no needy person should sleep hungry.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">The Spirit of Charity in Ramadan</h2>
            <p className="text-slate-600">Ramadan is also a month in which Muslims increase Zakat, Sadaqah, charity, compassion, and humanitarian support. The Prophet Muhammad (Peace Be Upon Him) was known for increasing generosity during Ramadan and helping needy people abundantly. Through community support, Daan Foundation tries to continue this spirit of compassion by helping vulnerable people with Iftar meals, food support, ration kits, and humanitarian assistance.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-slate-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Transparency &amp; Responsibility</h2>
            <p className="text-slate-600">Daan Foundation believes every donation is an amanah — a trust. The organization remains committed to honesty, responsible use of donations, transparency, and humanitarian service with dignity.</p>
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

          <section className="bg-gradient-to-r from-violet-600 to-purple-700 rounded-2xl p-8 md:p-10 text-center">
            <h2 className="text-3xl font-bold text-white mb-4">A Journey That Continues</h2>
            <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">From a small Ramadan Iftar effort in 2020 to a continuing humanitarian mission serving communities daily, every meal served represents kindness, trust, humanity, and hope. The foundation continues its work with one belief: Serving humanity is among the greatest forms of compassion and worship.</p>
            <Link to="/donate" className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-violet-600 hover:shadow-lg transition-shadow">
              Support Ramadan Iftar <ArrowRight className="h-5 w-5" />
            </Link>
          </section>

        </div>
      </ProjectPageLayout>
    </div>
  );
}

export default RamadanIftar;
