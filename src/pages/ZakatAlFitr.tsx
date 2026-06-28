import { Link } from "react-router-dom";
import { ArrowRight, Utensils, Users, Heart, Calendar, MapPin } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";
import ProjectPageLayout from "@/components/donation/ProjectPageLayout";

export function ZakatAlFitr() {
  return (
    <div>
      <SEO title="Fitrana - Zakat al-Fitr" description="Pay Fitrana (Zakat al-Fitr) through Daan Foundation. Help poor families celebrate Eid with dignity. Your donation provides food and relief." canonical="/zakat-al-fitr" />
      <Breadcrumbs items={[{ label: "Fitrana (Zakat al-Fitr)" }]} />

      <section className="relative bg-gradient-to-br from-indigo-600 to-purple-700">
        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 md:py-16">
          <div className="max-w-3xl">
            <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-4">Fitrana (Zakat al-Fitr)</h1>
            <p className="text-xl text-white/90 leading-relaxed max-w-2xl">A compulsory charitable donation given before Eid prayer at the end of Ramadan to help poor families celebrate with dignity.</p>
          </div>
        </div>
      </section>

      <ProjectPageLayout defaultCause="ramadan-iftar">
        <div className="space-y-10">

          <div className="rounded-2xl overflow-hidden shadow-lg">
            <img src="/images/iftaar-distribution.jpg" alt="Fitrana - helping families celebrate Eid" className="w-full h-[300px] md:h-[400px] object-cover" />
          </div>

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">What is Zakat al-Fitr (Fitrana)?</h2>
            <p className="text-slate-600 leading-relaxed">
              Zakat al-Fitr, also known as Fitrana or Sadaqatul Fitr, is a compulsory charitable donation given before the Eid-ul-Fitr prayer at the end of Ramadan. It is paid to help poor and needy people celebrate Eid with dignity and happiness.
            </p>
            <p className="text-slate-600 leading-relaxed mt-4">
              At Daan Foundation, Fitrana donations are used to provide food, iftar meals, ration kits and meal support to struggling families and hungry individuals across India.
            </p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-indigo-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Why is Fitrana Important?</h2>
            <p className="text-slate-600">Fitrana purifies the fasting person from mistakes and shortcomings during Ramadan while also ensuring that poor families have food on the day of Eid.</p>
            <blockquote className="border-l-4 border-indigo-600 pl-4 italic text-slate-700 text-lg mt-4">
              &ldquo;The Messenger of Allah ordained Zakat al-Fitr to purify the fasting person from indecent words or actions and to provide food for the needy.&rdquo;
              <footer className="text-sm mt-2 not-italic text-slate-500">&mdash; Abu Dawud &amp; Ibn Majah</footer>
            </blockquote>
          </section>

          <div className="border-t border-slate-200" />

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">How Daan Foundation Uses Fitrana Donations</h2>
            <p className="text-slate-600 mb-6">Daan Foundation was born during Ramadan 2020 through a small iftar distribution initiative. Today, Fitrana donations help us:</p>
            <div className="grid sm:grid-cols-2 gap-4">
              {[
                "Arrange iftar meals during Ramadan",
                "Provide cooked food through our Community Kitchen",
                "Distribute ration kits to needy families",
                "Support widows, labourers and elderly people",
                "Ensure poor families can celebrate Eid with dignity",
              ].map((item) => (
                <div key={item} className="flex items-start gap-3 bg-white rounded-xl p-4 shadow-sm border border-slate-100">
                  <span className="text-indigo-600 font-bold text-lg flex-shrink-0">&check;</span>
                  <span className="text-slate-700">{item}</span>
                </div>
              ))}
            </div>
            <p className="text-sm text-slate-500 mt-3">All donations are used only within India because Daan Foundation operates exclusively in Indian communities.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Community Kitchen &mdash; Feeding People Every Evening</h2>
            <p className="text-slate-600">Since 2020, Daan Foundation&rsquo;s Community Kitchen has continued to serve free meals daily to hungry and needy individuals. Every evening, people from all religions, castes and communities can receive food without discrimination.</p>
            <p className="text-lg font-semibold text-indigo-700 bg-white rounded-xl p-4 mt-4">With the help of Zakat, Sadaqah, Fitrana, Kaffarah and general donations, Daan Foundation has distributed more than 500,000 meals since its establishment.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="grid md:grid-cols-2 gap-6">
            <div className="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
              <h3 className="text-xl font-bold text-slate-900 mb-4">Who Should Pay Fitrana?</h3>
              <p className="text-slate-600 mb-4">Fitrana is generally compulsory upon every self-supporting Muslim who has food or wealth beyond their basic daily needs.</p>
              <ul className="space-y-2 text-slate-600">
                <li className="flex items-start gap-2"><span className="text-indigo-600 mt-1">•</span> On behalf of oneself</li>
                <li className="flex items-start gap-2"><span className="text-indigo-600 mt-1">•</span> On behalf of children and dependents</li>
                <li className="flex items-start gap-2"><span className="text-indigo-600 mt-1">•</span> Before Eid prayer</li>
              </ul>
              <p className="text-sm text-slate-500 mt-4">The purpose is to ensure that poor people can also enjoy Eid without worrying about hunger.</p>
            </div>
            <div className="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
              <h3 className="text-xl font-bold text-slate-900 mb-4">Difference Between Zakat and Fitrana</h3>
              <div className="space-y-4">
                <div className="bg-orange-50 rounded-xl p-4">
                  <p className="font-bold text-orange-800">Zakat</p>
                  <p className="text-sm text-slate-600">Paid once yearly. Usually 2.5% of eligible wealth. Amount differs from person to person.</p>
                </div>
                <div className="bg-indigo-50 rounded-xl p-4">
                  <p className="font-bold text-indigo-800">Fitrana</p>
                  <p className="text-sm text-slate-600">Paid during Ramadan before Eid prayer. Fixed charity amount per person. Given mainly to provide food for the needy.</p>
                </div>
              </div>
            </div>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-slate-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Transparency and Responsibility</h2>
            <p className="text-slate-600">At Daan Foundation, every donation is treated as an amanah (trust). We strive to ensure that charity reaches deserving people honestly and respectfully.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-blue-50 rounded-xl p-5 border border-blue-200">
            <div className="flex items-start gap-4">
              <MapPin className="h-6 w-6 text-blue-600 flex-shrink-0 mt-1" />
              <div>
                <h3 className="font-bold text-slate-900 text-lg">Working Only Within India</h3>
                <p className="text-slate-600 mt-1">Daan Foundation works only in India. We do not operate internationally and are not authorised to receive foreign donations. All humanitarian support is focused on Indian communities only.</p>
              </div>
            </div>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl p-8 md:p-10 text-center">
            <h2 className="text-3xl font-bold text-white mb-4">Your Fitrana Can Feed the Hungry</h2>
            <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">Even a small contribution can help ensure that no family sleeps hungry during Ramadan and Eid.</p>
            <Link to="/donate" className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-indigo-600 hover:shadow-lg transition-shadow">
              Pay Fitrana Now <ArrowRight className="h-5 w-5" />
            </Link>
          </section>

        </div>
      </ProjectPageLayout>
    </div>
  );
}

export default ZakatAlFitr;
