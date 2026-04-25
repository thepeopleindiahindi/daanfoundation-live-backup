import { Link } from "react-router-dom";
import Hero from "@/components/sections/Hero";
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
    title: "Orphan Sponsorship",
    description: "Support vulnerable children with food, shelter, and education.",
    href: "/orphan-sponsorship",
    iconBg: "bg-rose-100",
    iconColor: "text-rose-600",
  },
];

export function HomePage() {
  return (
    <div>
      {/* Hero */}
      <Hero />

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

      {/* Featured Programs with Images */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold text-slate-900 mb-4">Our Programs</h2>
            <p className="text-lg text-slate-600 max-w-2xl mx-auto">
              Supporting communities through sustainable development
            </p>
          </div>

          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            {/* Program 1 - Orphan Care */}
            <Link to="/orphan-sponsorship" className="group relative aspect-[4/5] rounded-2xl overflow-hidden">
              <img 
                src="/images/community-queue.jpg" 
                alt="Orphan sponsorship program"
                className="absolute inset-0 h-full w-full object-cover group-hover:scale-105 transition-transform duration-500"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent" />
              <div className="absolute bottom-0 left-0 right-0 p-6">
                <span className="inline-block px-3 py-1 bg-orange-500 text-white text-sm font-semibold rounded-full mb-3">
                  £35/month
                </span>
                <h3 className="text-2xl font-bold text-white mb-2">Orphan Sponsorship</h3>
                <p className="text-white/80">Provide education, healthcare, and hope</p>
              </div>
            </Link>

            {/* Program 2 - Water */}
            <Link to="/water" className="group relative aspect-[4/5] rounded-2xl overflow-hidden">
              <img 
                src="/images/impact-2.jpg" 
                alt="Water projects"
                className="absolute inset-0 h-full w-full object-cover group-hover:scale-105 transition-transform duration-500"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent" />
              <div className="absolute bottom-0 left-0 right-0 p-6">
                <span className="inline-block px-3 py-1 bg-blue-500 text-white text-sm font-semibold rounded-full mb-3">
                  From £300
                </span>
                <h3 className="text-2xl font-bold text-white mb-2">Water for Life</h3>
                <p className="text-white/80">Build wells and provide clean water</p>
              </div>
            </Link>

            {/* Program 3 - Food */}
            <Link to="/appeals" className="group relative aspect-[4/5] rounded-2xl overflow-hidden md:col-span-2 lg:col-span-1">
              <img 
                src="/images/food-distribution-ramadan.jpg" 
                alt="Food distribution"
                className="absolute inset-0 h-full w-full object-cover group-hover:scale-105 transition-transform duration-500"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent" />
              <div className="absolute bottom-0 left-0 right-0 p-6">
                <span className="inline-block px-3 py-1 bg-amber-500 text-white text-sm font-semibold rounded-full mb-3">
                  From £50
                </span>
                <h3 className="text-2xl font-bold text-white mb-2">Food Security</h3>
                <p className="text-white/80">Feed families in need around the world</p>
              </div>
            </Link>
          </div>
        </div>
      </section>

      {/* Mission Section with Large Image */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div className="relative">
              <img 
                src="/images/about-hero.jpg" 
                alt="Our mission"
                className="rounded-2xl shadow-xl w-full"
              />
              <div className="absolute -bottom-6 -right-6 bg-orange-500 text-white p-6 rounded-xl shadow-lg hidden md:block">
                <div className="text-4xl font-bold">10+</div>
                <div className="text-sm">Years of Impact</div>
              </div>
            </div>
            <div>
              <h2 className="text-3xl md:text-4xl font-bold text-slate-900 mb-6">
                Serving Humanity With Compassion
              </h2>
              <p className="text-lg text-slate-600 mb-6 leading-relaxed">
                Daan Foundation is dedicated to simplifying charitable giving while maximizing 
                impact for those in need around the world. We work in over 30 countries, delivering 
                aid to the most vulnerable communities.
              </p>
              <div className="grid grid-cols-2 gap-6 mb-8">
                <div>
                  <div className="text-3xl font-bold text-orange-500">30+</div>
                  <div className="text-slate-600">Countries</div>
                </div>
                <div>
                  <div className="text-3xl font-bold text-orange-500">2.5M</div>
                  <div className="text-slate-600">People Helped</div>
                </div>
              </div>
              <Link 
                to="/about" 
                className="inline-flex items-center gap-2 font-semibold text-orange-500 hover:gap-3 transition-all"
              >
                Learn About Our Story
                <ArrowRight className="h-4 w-4" />
              </Link>
            </div>
          </div>
        </div>
      </section>

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

      {/* Photo Gallery */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold text-slate-900 mb-4">Our Work in Action</h2>
            <p className="text-lg text-slate-600 max-w-2xl mx-auto">
              See the impact of your donations around the world
            </p>
          </div>

          <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div className="col-span-2 row-span-2">
              <img 
                src="/images/hero-2.jpg" 
                alt="Aid distribution"
                className="w-full h-full object-cover rounded-2xl"
              />
            </div>
            <div>
              <img 
                src="/images/campaign-1.jpg" 
                alt="Campaign 1"
                className="w-full h-full object-cover rounded-xl aspect-square"
              />
            </div>
            <div>
              <img 
                src="/images/campaign-2.jpg" 
                alt="Campaign 2"
                className="w-full h-full object-cover rounded-xl aspect-square"
              />
            </div>
            <div>
              <img 
                src="/images/campaign-3.jpg" 
                alt="Campaign 3"
                className="w-full h-full object-cover rounded-xl aspect-square"
              />
            </div>
            <div>
              <img 
                src="/images/impact-1.jpg" 
                alt="Impact"
                className="w-full h-full object-cover rounded-xl aspect-square"
              />
            </div>
          </div>

          <div className="grid grid-cols-3 md:grid-cols-6 gap-4 mt-4">
            <img src="/images/news-1.jpg" alt="News 1" className="w-full aspect-square object-cover rounded-xl" />
            <img src="/images/news-2.jpg" alt="News 2" className="w-full aspect-square object-cover rounded-xl" />
            <img src="/images/news-3.jpg" alt="News 3" className="w-full aspect-square object-cover rounded-xl" />
            <img src="/images/iftaar-distribution.jpg" alt="Iftaar" className="w-full aspect-square object-cover rounded-xl" />
            <img src="/images/aid-distribution-elderly.jpg" alt="Aid" className="w-full aspect-square object-cover rounded-xl" />
            <img src="/images/team.jpg" alt="Team" className="w-full aspect-square object-cover rounded-xl" />
          </div>
        </div>
      </section>

      {/* Partners */}
      <PartnerLogos />

      {/* Final CTA with Background Image */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div 
            className="relative rounded-2xl overflow-hidden p-8 md:p-16 text-center"
            style={{ backgroundImage: 'url(/images/hero-1.jpg)', backgroundSize: 'cover', backgroundPosition: 'center' }}
          >
            <div className="absolute inset-0 bg-orange-500/90" />
            <div className="relative z-10">
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
        </div>
      </section>
    </div>
  );
}

export default HomePage;
