import { Link } from "react-router-dom";
import { ArrowRight } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";

export function Kaffarah() {
  return (
    <div>
      <SEO title="Kaffarah - Expiation for Broken Fast" description="Pay Kaffarah through Daan Foundation. Kaffarah requires feeding 60 people for deliberately breaking a Ramadan fast. We distribute meals to those most in need." canonical="/kaffarah" keywords="kaffarah payment, broken fast compensation, kaffarah amount India, Islamic obligation" />
      <Breadcrumbs items={[{ label: "Islamic Giving", href: "/zakat" }, { label: "Kaffarah" }]} />

      {/* Hero */}
      <section className="relative py-20 md:py-28 bg-gradient-to-br from-red-600 to-rose-700">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div>
              <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-6">
                Kaffarah
              </h1>
              <p className="text-xl text-white/90 leading-relaxed mb-8">
                Kaffarah is a charitable compensation in Islam that becomes necessary when a person intentionally breaks a fast in Ramadan without a valid reason, or breaks an oath or promise.
              </p>
              <Link
                to="/donate"
                className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-red-600 hover:shadow-lg transition-shadow"
              >
                Pay Kaffarah Now
                <ArrowRight className="h-5 w-5" />
              </Link>
            </div>
            <div className="hidden lg:block">
              <img
                src="/images/food-distribution-ramadan.jpg"
                alt="Food distribution"
                className="rounded-2xl shadow-2xl"
              />
            </div>
          </div>
        </div>
      </section>

      {/* What is Kaffarah */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl font-bold text-slate-900 mb-6">What is Kaffarah?</h2>
            <div className="prose prose-lg text-slate-600">
              <p>
                Islam teaches responsibility along with mercy, and kaffarah is a way to seek forgiveness from Allah (SWT) while helping people who are struggling with hunger and poverty.
              </p>
              <p>
                According to Islamic teachings, if someone intentionally breaks a Ramadan fast without a valid reason, they must either:
              </p>
              <ul>
                <li>Fast continuously for 60 days, or</li>
                <li>Feed 60 poor people if unable to fast</li>
              </ul>
              <p>
                At Daan Foundation, we help donors fulfil their kaffarah by serving meals and food support to needy people across India. Since our foundation works only within India, all kaffarah donations are used exclusively for humanitarian support inside Indian communities.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* Kaffarah for Broken Oath */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid md:grid-cols-2 gap-8">
            <div className="bg-white rounded-2xl p-8 shadow-sm">
              <h3 className="text-xl font-bold text-slate-900 mb-4">Kaffarah for Broken Fast</h3>
              <p className="text-slate-600 mb-4">
                If someone intentionally breaks a Ramadan fast without a valid reason, they must either fast continuously for 60 days or feed 60 poor people.
              </p>
              <div className="bg-red-50 rounded-xl p-4">
                <span className="text-2xl font-bold text-red-600">₹{59 * 60}</span>
                <span className="text-sm text-slate-500 ml-2">(60 meals × ₹59 per meal)</span>
              </div>
            </div>
            <div className="bg-white rounded-2xl p-8 shadow-sm">
              <h3 className="text-xl font-bold text-slate-900 mb-4">Kaffarah for Broken Oath</h3>
              <p className="text-slate-600 mb-4">
                If a person breaks an oath or promise, Islam requires feeding poor people as expiation. Daan Foundation facilitates this by distributing meals to deserving families in India.
              </p>
              <p className="text-sm text-slate-500">
                Donors may contribute according to their requirement and intention.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* How we use donations */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl font-bold text-slate-900 mb-6">How Daan Foundation Uses Kaffarah Donations</h2>
            <div className="prose prose-lg text-slate-600">
              <p>Today, kaffarah donations help us:</p>
              <ul>
                <li>Serve freshly prepared evening meals through our Community Kitchen</li>
                <li>Provide iftar meals during Ramadan</li>
                <li>Distribute ration kits to struggling families</li>
                <li>Support widows, labourers, elderly people and homeless individuals</li>
                <li>Ensure no hungry person sleeps without food</li>
              </ul>
              <p>
                Every meal served through Daan Foundation is prepared with care, dignity and sincerity. People from every religion, caste and background are welcomed without discrimination.
              </p>
              <p>
                With Allah's mercy and public support, Daan Foundation has distributed more than 500,000 meals since 2020.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 md:py-20 bg-red-600">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-white mb-4">Your Kaffarah Can Feed the Hungry</h2>
          <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">
            Your contribution directly supports people struggling with hunger and poverty across India.
          </p>
          <Link
            to="/donate"
            className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-red-600 hover:shadow-lg transition-shadow"
          >
            Pay Kaffarah Now
            <ArrowRight className="h-5 w-5" />
          </Link>
        </div>
      </section>
    </div>
  );
}

export default Kaffarah;
