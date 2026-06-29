import { Link } from "react-router-dom";
import Hero from "@/components/sections/Hero";
import CampaignCards from "@/components/sections/CampaignCards";
import ImpactStats from "@/components/sections/ImpactStats";
import NewsGrid from "@/components/sections/NewsGrid";
import QuickActions from "@/components/sections/QuickActions";
import ImpactStories from "@/components/sections/ImpactStories";
import PartnerLogos from "@/components/sections/PartnerLogos";
import ZakatCalculator from "@/components/donation/ZakatCalculator";
import { ArrowRight, Heart, Calculator, HandHeart, Utensils, Users, Moon, Gift } from "lucide-react";
import SEO from "@/components/SEO";

const islamicGivingItems = [
  {
    icon: Utensils,
    title: "Community Kitchen",
    description: "Support our daily free meal program for the needy.",
    href: "/community-kitchen",
    iconBg: "bg-orange-100",
    iconColor: "text-orange-500",
  },
  {
    icon: HandHeart,
    title: "Fidyah & Kaffarah",
    description: "Fulfil your Islamic obligation by feeding the needy.",
    href: "/fidya",
    iconBg: "bg-rose-100",
    iconColor: "text-rose-600",
  },
  {
    icon: Moon,
    title: "Ramadan Iftar Appeal",
    description: "Provide iftar meals to fasting families during Ramadan.",
    href: "/ramadan",
    iconBg: "bg-violet-100",
    iconColor: "text-violet-600",
  },
  {
    icon: Users,
    title: "Ration Kit Distribution",
    description: "Essential food rations for struggling families.",
    href: "/where-most-needed",
    iconBg: "bg-amber-100",
    iconColor: "text-amber-600",
  },
  {
    icon: Calculator,
    title: "Zakat",
    description: "Fulfil your 2.5% obligation and purify your wealth.",
    href: "/zakat",
    iconBg: "bg-emerald-100",
    iconColor: "text-emerald-600",
  },
  {
    icon: Gift,
    title: "Sadaqah",
    description: "Give voluntary charity and earn continuous rewards.",
    href: "/sadaqah",
    iconBg: "bg-cyan-100",
    iconColor: "text-cyan-600",
  },
];

export function HomePage() {
  return (
    <div>
      <SEO title="Daan Foundation - Serving Humanity With Compassion" description="Daan Foundation serves 500,000+ free meals through Community Kitchen, distributes ration kits, and channels your Zakat, Sadaqah, Fidya & Kaffarah to those in need across India." canonical="/" keywords="Daan Foundation, charity India, donate zakat, sadaqah, community kitchen, free meals, ration kit distribution" />
      <Hero />

      <QuickActions />

      {/* Current Campaigns */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="flex items-center justify-between mb-8">
            <div>
              <h2 className="text-3xl font-bold text-slate-900">Current Campaigns</h2>
              <p className="text-slate-600 mt-2">Support our ongoing humanitarian initiatives</p>
            </div>
            <Link
              to="/appeals"
              className="hidden sm:inline-flex items-center gap-2 font-semibold text-orange-500 hover:text-orange-600"
            >
              View All Campaigns
              <ArrowRight className="h-4 w-4" />
            </Link>
          </div>
          <CampaignCards />
          <div className="mt-6 text-center sm:hidden">
            <Link
              to="/appeals"
              className="inline-flex items-center gap-2 font-semibold text-orange-500"
            >
              View All Campaigns
              <ArrowRight className="h-4 w-4" />
            </Link>
          </div>
        </div>
      </section>

      {/* Impact Stats */}
      <ImpactStats />

      {/* Our Programs */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold text-slate-900 mb-4">Our Programs</h2>
            <p className="text-lg text-slate-600 max-w-2xl mx-auto">
              Supporting communities through sustainable development
            </p>
          </div>

          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            {/* Program 1 - Community Kitchen */}
            <Link to="/community-kitchen" className="group relative aspect-[4/5] rounded-2xl overflow-hidden">
              <img 
                src="/images/food-distribution-ramadan.jpg" 
                alt="Community Kitchen"
                className="absolute inset-0 h-full w-full object-cover group-hover:scale-105 transition-transform duration-500"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent" />
              <div className="absolute bottom-0 left-0 right-0 p-6">
                <span className="inline-block px-3 py-1 bg-orange-500 text-white text-sm font-semibold rounded-full mb-3">
                  ₹59/meal
                </span>
                <h3 className="text-2xl font-bold text-white mb-2">Community Kitchen</h3>
                <p className="text-white/80">Free daily meals served with dignity</p>
              </div>
            </Link>

            {/* Program 2 - Ration Kit Distribution */}
            <Link to="/where-most-needed" className="group relative aspect-[4/5] rounded-2xl overflow-hidden">
              <img 
                src="/images/extra-5.jpg" 
                alt="Ration Kit Distribution"
                className="absolute inset-0 h-full w-full object-cover group-hover:scale-105 transition-transform duration-500"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent" />
              <div className="absolute bottom-0 left-0 right-0 p-6">
                <span className="inline-block px-3 py-1 bg-amber-500 text-white text-sm font-semibold rounded-full mb-3">
                  Essential Aid
                </span>
                <h3 className="text-2xl font-bold text-white mb-2">Ration Kit Distribution</h3>
                <p className="text-white/80">Essential food rations for poor families</p>
              </div>
            </Link>

            {/* Program 3 - Fidyah & Kaffarah */}
            <Link to="/fidya" className="group relative aspect-[4/5] rounded-2xl overflow-hidden md:col-span-2 lg:col-span-1">
              <img 
                src="/images/iftaar-distribution.jpg" 
                alt="Fidyah & Kaffarah"
                className="absolute inset-0 h-full w-full object-cover group-hover:scale-105 transition-transform duration-500"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent" />
              <div className="absolute bottom-0 left-0 right-0 p-6">
                <span className="inline-block px-3 py-1 bg-violet-500 text-white text-sm font-semibold rounded-full mb-3">
                  Islamic Giving
                </span>
                <h3 className="text-2xl font-bold text-white mb-2">Fidyah & Kaffarah</h3>
                <p className="text-white/80">Fulfil your obligation by feeding the needy</p>
              </div>
            </Link>
          </div>
        </div>
      </section>

      {/* Mission Section */}
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
                <div className="text-4xl font-bold">6+</div>
                <div className="text-sm">Years of Service</div>
              </div>
            </div>
            <div>
              <h2 className="text-3xl md:text-4xl font-bold text-slate-900 mb-6">
                Serving Humanity With Compassion Since 2020
              </h2>
              <p className="text-lg text-slate-600 mb-6 leading-relaxed">
                Daan Foundation is an India-based charitable organisation committed to helping 
                poor, needy and vulnerable people through food support, community welfare and 
                social assistance programmes. By strengthening our community kitchen and outreach 
                programs, we aim to serve 25,000 beneficiaries annually.
              </p>
              <div className="grid grid-cols-2 gap-6 mb-8">
                <div>
                  <div className="text-3xl font-bold text-orange-500">500K+</div>
                  <div className="text-slate-600">Meals Distributed</div>
                </div>
                <div>
                  <div className="text-3xl font-bold text-orange-500">600K+</div>
                  <div className="text-slate-600">Beneficiaries Reached</div>
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

      {/* Maximize Your Reward - Islamic Giving */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold text-slate-900 mb-4">Maximise Your Reward</h2>
            <p className="text-lg text-slate-600 max-w-2xl mx-auto">
              Choose a cause and earn blessings through your generosity
            </p>
          </div>

          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
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

      {/* Zakat Calculator Preview */}
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
              <Link to="/zakat-calculator" className="inline-flex items-center gap-2 mt-6 font-semibold text-orange-500 hover:gap-3 transition-all">
                Calculate Now <ArrowRight className="h-4 w-4" />
              </Link>
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
              <p className="text-slate-600 mt-2">Updates from our work across India</p>
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
              See the impact of your donations across India
            </p>
          </div>

          <div className="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <div className="col-span-2 md:col-span-2 md:row-span-2">
              <img src="/images/hero-2.jpg" alt="Aid distribution" className="w-full h-full object-cover rounded-2xl" />
            </div>
            <div>
              <img src="/images/campaign-1.jpg" alt="Campaign" className="w-full h-full object-cover rounded-xl aspect-square" />
            </div>
            <div>
              <img src="/images/campaign-2.jpg" alt="Campaign" className="w-full h-full object-cover rounded-xl aspect-square" />
            </div>
            <div>
              <img src="/images/campaign-3.jpg" alt="Campaign" className="w-full h-full object-cover rounded-xl aspect-square" />
            </div>
            <div>
              <img src="/images/impact-1.jpg" alt="Impact" className="w-full h-full object-cover rounded-xl aspect-square" />
            </div>
          </div>

          <div className="grid grid-cols-3 md:grid-cols-6 gap-4 mt-4">
            <img src="/images/news-1.jpg" alt="News" className="w-full aspect-square object-cover rounded-xl" />
            <img src="/images/news-2.jpg" alt="News" className="w-full aspect-square object-cover rounded-xl" />
            <img src="/images/news-3.jpg" alt="News" className="w-full aspect-square object-cover rounded-xl" />
            <img src="/images/extra-6.jpg" alt="Community support" className="w-full aspect-square object-cover rounded-xl" />
            <img src="/images/ration-kit-front.jpg" alt="Ration Kit" className="w-full aspect-square object-cover rounded-xl" />
            <img src="/images/extra-7.jpg" alt="Charity work" className="w-full aspect-square object-cover rounded-xl" />
          </div>
        </div>
      </section>

      {/* Partners */}
      <PartnerLogos />

      {/* Final CTA */}
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
                Your donation can provide food, warmth, and hope to those in need across India.
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
