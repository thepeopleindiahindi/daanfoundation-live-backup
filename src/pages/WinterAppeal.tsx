import { Link } from "react-router-dom";
import { ArrowRight } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";

export function WinterAppeal() {
  return (
    <div>
      <SEO title="Winter Appeal - Warm Clothing & Blankets" description="Support Daan Foundation's Winter Appeal. Donate warm clothing, blankets, and essential supplies to protect vulnerable families from harsh winter conditions in India." canonical="/winter" keywords="winter appeal charity, warm clothing donation India, blanket distribution, winter charity India" />
      <Breadcrumbs items={[{ label: "Seasonal Giving" }, { label: "Winter Appeal" }]} />

      {/* Hero */}
      <section className="relative py-20 md:py-28 bg-gradient-to-br from-sky-700 to-blue-800">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div>
              <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-6">
                Winter Appeal
              </h1>
              <p className="text-2xl text-white/95 font-semibold mb-4">
                Warmth for Every Needy — Protecting Lives During Harsh Winters
              </p>
              <p className="text-lg text-white/85 leading-relaxed mb-8">
                For many poor families, daily survival itself is a challenge — and during cold weather, the lack of warm clothes can become a serious risk to health and life.
              </p>
              <Link
                to="/donate"
                className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-sky-700 hover:shadow-lg transition-shadow"
              >
                Support Winter Appeal
                <ArrowRight className="h-5 w-5" />
              </Link>
            </div>
            <div className="hidden lg:block">
              <img
                src="/images/aid-distribution-elderly.jpg"
                alt="Winter support distribution"
                className="rounded-2xl shadow-2xl"
              />
            </div>
          </div>
        </div>
      </section>

      {/* What we provide */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid md:grid-cols-2 gap-12">
            <div>
              <h2 className="text-3xl font-bold text-slate-900 mb-6">Who We Help</h2>
              <ul className="space-y-3 text-lg text-slate-600">
                <li className="flex items-start gap-2"><span className="text-sky-500 mt-1">•</span>Poor and low-income families</li>
                <li className="flex items-start gap-2"><span className="text-sky-500 mt-1">•</span>Daily wage workers</li>
                <li className="flex items-start gap-2"><span className="text-sky-500 mt-1">•</span>Elderly individuals</li>
                <li className="flex items-start gap-2"><span className="text-sky-500 mt-1">•</span>Homeless people</li>
                <li className="flex items-start gap-2"><span className="text-sky-500 mt-1">•</span>Children living in difficult conditions</li>
              </ul>
            </div>
            <div>
              <h2 className="text-3xl font-bold text-slate-900 mb-6">What We Distribute</h2>
              <ul className="space-y-3 text-lg text-slate-600">
                <li className="flex items-start gap-2"><span className="text-sky-500 mt-1">•</span>Warm clothes (jackets, sweaters, shawls)</li>
                <li className="flex items-start gap-2"><span className="text-sky-500 mt-1">•</span>Blankets</li>
                <li className="flex items-start gap-2"><span className="text-sky-500 mt-1">•</span>Shoes and slippers</li>
                <li className="flex items-start gap-2"><span className="text-sky-500 mt-1">•</span>Socks and basic winter essentials</li>
              </ul>
            </div>
          </div>
        </div>
      </section>

      {/* Stories */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl font-bold text-slate-900 mb-10 text-center">Stories From the Ground</h2>
          <div className="grid md:grid-cols-3 gap-6">
            {[
              { title: "A Blanket That Saved the Night", story: "An elderly man living in difficult conditions shared that receiving a blanket helped him survive cold nights. For him, it was not just a blanket — it was protection." },
              { title: "Warm Clothes for My Children", story: "A mother of three said she could not afford winter clothing for her children. Through the winter drive, her children received sweaters and shoes, helping them stay warm and attend school." },
              { title: "Small Help, Big Relief", story: "Daily wage workers often spend long hours outdoors. Receiving warm clothes during winter reduces their hardship and helps them continue working." },
            ].map((s) => (
              <div key={s.title} className="bg-white rounded-2xl p-6 shadow-sm">
                <h3 className="font-bold text-slate-900 mb-3">{s.title}</h3>
                <p className="text-slate-600">{s.story}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 md:py-20 bg-sky-700">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-white mb-4">Together, Let's Share Warmth</h2>
          <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">
            This winter, let's come together to ensure that no one is left out in the cold. Because warmth is not a luxury — it is a necessity.
          </p>
          <Link
            to="/donate"
            className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-sky-700 hover:shadow-lg transition-shadow"
          >
            Donate Now
            <ArrowRight className="h-5 w-5" />
          </Link>
        </div>
      </section>
    </div>
  );
}

export default WinterAppeal;
