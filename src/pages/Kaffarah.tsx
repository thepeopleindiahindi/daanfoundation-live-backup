import { Link } from "react-router-dom";
import { ArrowRight, Utensils, Users, Clock, MapPin } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";
import ProjectPageLayout from "@/components/donation/ProjectPageLayout";

export function Kaffarah() {
  return (
    <div>
      <SEO title="Kaffarah - Expiation for Broken Fast" description="Pay Kaffarah through Daan Foundation. Kaffarah requires feeding 60 people for deliberately breaking a Ramadan fast. We distribute meals to those most in need." canonical="/kaffarah" keywords="kaffarah payment, broken fast compensation, kaffarah amount India, Islamic obligation" />
      <Breadcrumbs items={[{ label: "Kaffarah" }]} />

      <section className="relative bg-gradient-to-br from-red-600 to-rose-700">
        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 md:py-16">
          <div className="max-w-3xl">
            <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-4">Kaffarah</h1>
            <p className="text-xl text-white/90 leading-relaxed max-w-2xl">Feeding those in need through Daan Foundation &mdash; fulfil your Kaffarah with compassion.</p>
          </div>
        </div>
      </section>

      <ProjectPageLayout defaultCause="fidya-kaffarah">
        <div className="space-y-10">

          <div className="rounded-2xl overflow-hidden shadow-lg">
            <img src="/images/food-distribution-ramadan.jpg" alt="Kaffarah food distribution" className="w-full h-[300px] md:h-[400px] object-cover" />
          </div>

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">What is Kaffarah?</h2>
            <p className="text-slate-600 leading-relaxed">
              Kaffarah is a charitable compensation in Islam that becomes necessary when a person intentionally breaks a fast in Ramadan without a valid reason, or breaks an oath/promise. Islam teaches responsibility along with mercy, and Kaffarah is a way to seek forgiveness from Allah (SWT) while helping people who are struggling with hunger and poverty.
            </p>
            <p className="text-slate-600 leading-relaxed mt-4">
              At Daan Foundation, we help donors fulfil their Kaffarah by serving meals and food support to needy people across India. Since our foundation works only within India, all Kaffarah donations are used exclusively for humanitarian support inside Indian communities.
            </p>
          </section>

          <div className="border-t border-slate-200" />

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">How Daan Foundation Uses Kaffarah Donations</h2>
            <p className="text-slate-600 mb-6">
              Daan Foundation was born during Ramadan 2020 from a small iftar distribution effort that was initially planned for only 15 days. Today, Kaffarah donations help us:
            </p>
            <div className="grid sm:grid-cols-2 gap-4">
              {[
                "Serve freshly prepared evening meals through our Community Kitchen",
                "Provide iftar meals during Ramadan",
                "Distribute ration kits to struggling families",
                "Support widows, labourers, elderly people and homeless individuals",
                "Ensure no hungry person sleeps without food",
              ].map((item) => (
                <div key={item} className="flex items-start gap-3 bg-white rounded-xl p-4 shadow-sm border border-slate-100">
                  <div className="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <span className="text-red-600 font-bold text-sm">&check;</span>
                  </div>
                  <span className="text-slate-700">{item}</span>
                </div>
              ))}
            </div>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Community Kitchen &mdash; A Lifeline for Many</h2>
            <p className="text-slate-600">Every evening, Daan Foundation&rsquo;s Community Kitchen prepares and distributes fresh food to needy individuals. Different meals are served regularly, including rice dishes, dal and roti, vegetable curries, seasonal food items, and Ramadan iftar meals.</p>
            <p className="text-lg font-semibold text-red-700 bg-white rounded-xl p-4 mt-4">The estimated cost of one complete meal is approximately ₹59 per person.</p>
            <p className="text-slate-600 mt-4">For many people, this meal is not just food — it is relief, dignity and hope.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="grid md:grid-cols-2 gap-6">
            <div className="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
              <h3 className="text-xl font-bold text-slate-900 mb-4">Kaffarah for Broken Fast</h3>
              <p className="text-slate-600 mb-4">According to Islamic teachings, if someone intentionally breaks a Ramadan fast without a valid reason, they must either:</p>
              <ul className="space-y-2 text-slate-600">
                <li className="flex items-start gap-2"><span className="text-red-600 mt-1">•</span> Fast continuously for 60 days, or</li>
                <li className="flex items-start gap-2"><span className="text-red-600 mt-1">•</span> Feed 60 poor people if unable to fast</li>
              </ul>
              <div className="bg-red-50 rounded-xl p-4 mt-4">
                <span className="text-2xl font-bold text-red-600">₹{59 * 60}</span>
                <span className="text-sm text-slate-500 ml-2">(60 meals × ₹59 per meal)</span>
              </div>
              <p className="text-sm text-slate-500 mt-2">Daan Foundation helps donors fulfil this responsibility by arranging meals for needy individuals and families across India.</p>
            </div>
            <div className="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
              <h3 className="text-xl font-bold text-slate-900 mb-4">Kaffarah for Broken Oath</h3>
              <p className="text-slate-600 mb-4">If a person breaks an oath or promise, Islam requires feeding poor people as expiation.</p>
              <p className="text-slate-600">Daan Foundation facilitates this by distributing meals and food support to deserving families in India. Donors may contribute according to their requirement and intention.</p>
            </div>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-slate-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Transparency and Trust</h2>
            <p className="text-slate-600">Daan Foundation believes that charity is an amanah (trust). Every contribution is treated with responsibility and sincerity. We are committed to serving needy people with dignity, using donations carefully and honestly, maintaining transparency, and supporting vulnerable Indian communities only.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-blue-50 rounded-xl p-5 border border-blue-200">
            <div className="flex items-start gap-4">
              <MapPin className="h-6 w-6 text-blue-600 flex-shrink-0 mt-1" />
              <div>
                <h3 className="font-bold text-slate-900 text-lg">Working Only Within India</h3>
                <p className="text-slate-600 mt-1">Daan Foundation works only within India. We do not operate internationally, do not conduct activities outside India, and do not accept foreign donations without legal authorization.</p>
              </div>
            </div>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-gradient-to-r from-red-600 to-rose-700 rounded-2xl p-8 md:p-10 text-center">
            <h2 className="text-3xl font-bold text-white mb-4">Your Kaffarah Can Feed the Hungry</h2>
            <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">Your contribution directly supports people struggling with hunger and poverty across India.</p>
            <Link to="/donate" className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-red-600 hover:shadow-lg transition-shadow">
              Pay Kaffarah Now <ArrowRight className="h-5 w-5" />
            </Link>
          </section>

        </div>
      </ProjectPageLayout>
    </div>
  );
}

export default Kaffarah;
