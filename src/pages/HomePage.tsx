import { Link } from "react-router-dom";
import QurbaniHero from "@/components/sections/QurbaniHero";
import CampaignCards from "@/components/sections/CampaignCards";
import ImpactStats from "@/components/sections/ImpactStats";
import NewsGrid from "@/components/sections/NewsGrid";
import QuickActions from "@/components/sections/QuickActions";
import ImpactStories from "@/components/sections/ImpactStories";
import PartnerLogos from "@/components/sections/PartnerLogos";
import ZakatCalculator from "@/components/donation/ZakatCalculator";
import { ArrowRight, Heart, Calculator, HandHeart } from "lucide-react";

const islamicGivingItems = [
  {
    icon: Calculator,
    title: "Zakat Calculator",
    description: "Calculate and pay your Zakat accurately with our easy-to-use calculator.",
    href: "/zakat-calculator",
    iconBg: "bg-orange-100",
    iconColor: "text-orange-500",
  },
  {
    icon: Heart,
    title: "Sadaqah",
    description: "Give voluntary charity and earn continuous rewards for your good deeds.",
    href: "/sadaqah",
    iconBg: "bg-amber-100",
    iconColor: "text-amber-600",
  },
  {
    icon: HandHeart,
    title: "Qurbani",
    description: "Share the blessings of Eid with families in need through your sacrifice.",
    href: "/qurbani",
    iconBg: "bg-rose-100",
    iconColor: "text-rose-600",
  },
];

export function HomePage() {
  return (
    <div>
      {/* Hero */}
      <QurbaniHero />

      {/* Quick Actions */}
      <QuickActions />

      {/* Emergency Appeals */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="flex items-center justify-between mb-8">
            <div>
              <h2 className="text-3xl font-bold text-slate-900">Emergency Appeals</h2>
              <p className="text-slate-600 mt-2">Respond to crises where help is needed most</p>
            </div>
            <Link
              to="/appeals"
              className="hidden sm:inline-flex items-center gap-2 font-semibold text-orange-500 hover:text-orange-600"
            >
              View All Appeals
              <ArrowRight className="h-4 w-4" />
            </Link>
          </div>
          <CampaignCards />
          <div className="mt-6 text-center sm:hidden">
            <Link
              to="/appeals"
              className="inline-flex items-center gap-2 font-semibold text-orange-500"
            >
              View All Appeals
              <ArrowRight className="h-4 w-4" />
            </Link>
          </div>
        </div>
      </section>

      {/* Impact Stats */}
      <ImpactStats />

      {/* Islamic Giving Section */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold text-slate-900 mb-4">Islamic Giving</h2>
            <p className="text-lg text-slate-600 max-w-2xl mx-auto">
              Fulfill your religious obligations with ease and confidence
            </p>
          </div>

          <div className="grid md:grid-cols-3 gap-6">
            {islamicGivingItems.map(({ icon: Icon, title, description, href, iconBg, iconColor }) => (
              <Link
                key={title}
                to={href}
                className="group bg-[#F3F4F6] rounded-2xl p-6 hover:shadow-lg transition-all"
              >
                <div className={`h-14 w-14 rounded-xl ${iconBg} flex items-center justify-center mb-4 group-hover:scale-110 transition-transform`}>
                  <Icon className={`h-7 w-7 ${iconColor}`} />
                </div>
                <h3 className="text-xl font-bold text-slate-900 mb-2">{title}</h3>
                <p className="text-slate-600 mb-4">{description}</p>
                <span className="inline-flex items-center gap-1 font-semibold text-orange-500 group-hover:gap-2 transition-all">
                  Learn More
                  <ArrowRight className="h-4 w-4" />
                </span>
              </Link>
            ))}
          </div>
        </div>
      </section>

      {/* Zakat Calculator Preview — Soft Beige highlight section #FFF7ED */}
      <section className="py-16 md:py-24 bg-[#FFF7ED]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div>
              <h2 className="text-3xl md:text-4xl font-bold text-[#111111] mb-6">Calculate Your Zakat</h2>
              <p className="text-xl text-slate-600 mb-6">
                Use our simple Zakat calculator to determine your obligation. We'll help ensure
                your Zakat reaches those who need it most.
              </p>
              <ul className="space-y-3 text-slate-700">
                {["Easy-to-use calculator", "Updated Nisab values", "100% Zakat policy"].map((item) => (
                  <li key={item} className="flex items-center gap-2">
                    <span className="h-2 w-2 rounded-full bg-[#F97316]" />
                    {item}
                  </li>
                ))}
              </ul>
            </div>
            <div>
              <ZakatCalculator />
            </div>
          </div>
        </div>
      </section>

      {/* Impact Stories */}
      <ImpactStories />

      {/* Latest News */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="flex items-center justify-between mb-8">
            <div>
              <h2 className="text-3xl font-bold text-slate-900">Latest News</h2>
              <p className="text-slate-600 mt-2">Updates from our work around the world</p>
            </div>
            <Link
              to="/news"
              className="hidden sm:inline-flex items-center gap-2 font-semibold text-orange-500 hover:text-orange-600"
            >
              View All News
              <ArrowRight className="h-4 w-4" />
            </Link>
          </div>
          <NewsGrid />
        </div>
      </section>

      {/* Partners */}
      <PartnerLogos />

      {/* Final CTA */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="rounded-2xl bg-orange-500 p-8 md:p-12 text-center">
            <h2 className="text-3xl md:text-4xl font-bold text-white mb-4">
              Make a Difference Today
            </h2>
            <p className="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
              Your donation can provide food, water, healthcare, and hope to those in need.
              Every contribution matters.
            </p>
            <Link
              to="/donate"
              className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-orange-500 hover:shadow-lg transition-shadow"
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

export default HomePage;
