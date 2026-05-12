import { Link } from "react-router-dom";
import { Heart, Users, UtensilsCrossed, Gift } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";

export function ZakatAlFitr() {
  return (
    <div>
      <SEO title="Zakat al-Fitr (Fitrana) - Eid Charity" description="Pay Zakat al-Fitr (Fitrana) through Daan Foundation before Eid prayer. Ensure every family can celebrate Eid with dignity through food support." canonical="/zakat-al-fitr" keywords="zakat al fitr, fitrana, eid charity, zakat al fitr amount India, Ramadan obligation" />
      <Breadcrumbs items={[{ label: "Islamic Giving", href: "/zakat" }, { label: "Zakat al-Fitr (Fitrana)" }]} />

      {/* Hero */}
      <section className="py-16 md:py-20 bg-gradient-to-br from-orange-600 to-orange-700">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h1 className="text-4xl md:text-5xl font-extrabold text-white mb-4">
            What is Zakat al-Fitr (Fitrana)?
          </h1>
          <p className="text-xl text-white/90 max-w-3xl mx-auto">
            A compulsory charitable donation given before Eid-ul-Fitr prayer to help
            poor and needy people celebrate Eid with dignity and happiness.
          </p>
        </div>
      </section>

      {/* Main content */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
          <div className="prose prose-lg text-slate-600 max-w-none">
            <p>
              Zakat al-Fitr, also known as <strong>Fitrana</strong> or <strong>Sadaqatul Fitr</strong>, 
              is a compulsory charitable donation given before the Eid-ul-Fitr prayer at the end of 
              Ramadan. It is paid to help poor and needy people celebrate Eid with dignity and happiness.
            </p>
            <p>
              At Daan Foundation, fitrana donations are used to provide food, iftar meals, ration kits 
              and meal support to struggling families and hungry individuals across India.
            </p>

            <h2 className="text-2xl font-bold text-slate-900 mt-12 mb-4">Why is Fitrana Important?</h2>
            <p>
              Fitrana purifies the fasting person from mistakes and shortcomings during Ramadan while 
              also ensuring that poor families have food on the day of Eid.
            </p>
            <blockquote className="border-l-4 border-orange-500 pl-4 italic text-slate-700 my-6">
              "The Messenger of Allah ordained Zakat al-Fitr to purify the fasting person from 
              indecent words or actions and to provide food for the needy." — Abu Dawud & Ibn Majah
            </blockquote>

            <h2 className="text-2xl font-bold text-slate-900 mt-12 mb-4">
              How Daan Foundation Uses Fitrana Donations
            </h2>
            <p>
              Daan Foundation was born during Ramadan 2020 through a small iftar distribution initiative 
              that was originally planned for only 15 days. By the mercy of Allah and the support of 
              compassionate people, that effort continued and gradually expanded into a daily humanitarian mission.
            </p>
            <p>Today, fitrana donations help us:</p>
            <ul>
              <li>Arrange iftar meals during Ramadan</li>
              <li>Provide cooked food through our Community Kitchen</li>
              <li>Distribute ration kits to needy families</li>
              <li>Support widows, labourers and elderly people</li>
              <li>Ensure poor families can celebrate Eid with dignity</li>
            </ul>

            <h2 className="text-2xl font-bold text-slate-900 mt-12 mb-4">Who Should Pay Fitrana?</h2>
            <p>
              Fitrana is generally compulsory upon every self-supporting Muslim who has food or wealth 
              beyond their basic daily needs. It is usually paid:
            </p>
            <ul>
              <li>On behalf of oneself</li>
              <li>On behalf of children and dependents</li>
              <li>Before Eid prayer</li>
            </ul>
          </div>
        </div>
      </section>

      {/* Zakat vs Fitrana comparison */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl font-bold text-slate-900 mb-8 text-center">
            Difference Between Zakat and Fitrana
          </h2>
          <div className="grid md:grid-cols-2 gap-6">
            <div className="bg-white rounded-2xl p-6 shadow-sm">
              <h3 className="text-xl font-bold text-slate-900 mb-4">Zakat</h3>
              <ul className="space-y-2 text-slate-600">
                <li className="flex items-start gap-2">
                  <span className="h-2 w-2 rounded-full bg-orange-500 mt-2 shrink-0" />
                  Paid once yearly
                </li>
                <li className="flex items-start gap-2">
                  <span className="h-2 w-2 rounded-full bg-orange-500 mt-2 shrink-0" />
                  Usually 2.5% of eligible wealth
                </li>
                <li className="flex items-start gap-2">
                  <span className="h-2 w-2 rounded-full bg-orange-500 mt-2 shrink-0" />
                  Amount differs from person to person
                </li>
              </ul>
            </div>
            <div className="bg-white rounded-2xl p-6 shadow-sm">
              <h3 className="text-xl font-bold text-slate-900 mb-4">Fitrana</h3>
              <ul className="space-y-2 text-slate-600">
                <li className="flex items-start gap-2">
                  <span className="h-2 w-2 rounded-full bg-amber-500 mt-2 shrink-0" />
                  Paid during Ramadan before Eid prayer
                </li>
                <li className="flex items-start gap-2">
                  <span className="h-2 w-2 rounded-full bg-amber-500 mt-2 shrink-0" />
                  Fixed charity amount per person
                </li>
                <li className="flex items-start gap-2">
                  <span className="h-2 w-2 rounded-full bg-amber-500 mt-2 shrink-0" />
                  Given mainly to provide food for the needy
                </li>
              </ul>
            </div>
          </div>
        </div>
      </section>

      {/* How fitrana helps */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl font-bold text-slate-900 mb-8 text-center">
            Your Fitrana Can Feed the Hungry
          </h2>
          <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {[
              { icon: UtensilsCrossed, title: "Daily Meals", desc: "Continue daily meal distribution through our Community Kitchen" },
              { icon: Heart, title: "Ramadan Iftar", desc: "Arrange iftar programmes for those fasting in need" },
              { icon: Gift, title: "Ration Kits", desc: "Provide ration kits to poor families during Eid" },
              { icon: Users, title: "Eid Support", desc: "Ensure poor families can celebrate Eid with dignity" },
            ].map(({ icon: Icon, title, desc }) => (
              <div key={title} className="text-center p-6 bg-[#F3F4F6] rounded-2xl">
                <div className="h-14 w-14 rounded-xl bg-orange-100 flex items-center justify-center mx-auto mb-4">
                  <Icon className="h-7 w-7 text-orange-600" />
                </div>
                <h3 className="font-bold text-slate-900 mb-2">{title}</h3>
                <p className="text-sm text-slate-600">{desc}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Important notice */}
      <section className="py-12">
        <div className="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
          <div className="rounded-2xl bg-amber-50 border border-amber-200 p-6">
            <h3 className="font-bold text-amber-900 mb-3">Important Notice</h3>
            <ul className="space-y-2 text-amber-800 text-sm">
              <li>• Daan Foundation works only in India</li>
              <li>• We do not operate internationally</li>
              <li>• We are not authorised to receive foreign donations</li>
              <li>• All humanitarian support is focused on Indian communities only</li>
            </ul>
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="rounded-3xl bg-gradient-to-br from-orange-600 to-orange-700 p-8 md:p-12 text-center">
            <h2 className="text-3xl font-bold text-white mb-4">Pay Your Fitrana Today</h2>
            <p className="text-lg text-white/90 max-w-2xl mx-auto mb-8">
              Even a small contribution can help ensure that no family sleeps hungry during Ramadan and Eid.
            </p>
            <Link
              to="/donate"
              className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-orange-600 hover:shadow-lg transition-shadow"
            >
              <Heart className="h-5 w-5" />
              Donate Now
            </Link>
          </div>
        </div>
      </section>
    </div>
  );
}

export default ZakatAlFitr;
