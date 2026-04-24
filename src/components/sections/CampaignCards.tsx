import { Link } from "react-router-dom";
import { ArrowRight } from "lucide-react";

const campaigns = [
  {
    id: "ramadan-food",
    title: "Ramadan Food Distribution",
    description: "Provide Iftaar meals to families in need during the blessed month",
    image: "/images/food-distribution-ramadan.jpg",
    raised: 45000,
    goal: 75000,
    href: "/appeals/ramadan",
  },
  {
    id: "community-aid",
    title: "Community Aid Program",
    description: "Essential supplies and support for underserved communities",
    image: "/images/community-queue.jpg",
    raised: 28000,
    goal: 50000,
    href: "/appeals/community-aid",
  },
  {
    id: "elderly-support",
    title: "Elderly Care Initiative",
    description: "Blankets, food parcels, and medical aid for elderly in need",
    image: "/images/aid-distribution-elderly.jpg",
    raised: 18500,
    goal: 30000,
    href: "/appeals/elderly-care",
  },
  {
    id: "iftaar-program",
    title: "Daily Iftaar Program",
    description: "Hot meals served daily throughout Ramadan to those fasting",
    image: "/images/iftaar-distribution.jpg",
    raised: 62000,
    goal: 80000,
    href: "/appeals/iftaar",
  },
];

export function CampaignCards() {
  return (
    <section className="py-16 md:py-24 bg-slate-50">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-10">
          <div>
            <h2 className="text-3xl md:text-4xl font-bold text-slate-900 mb-2">
              Current Campaigns
            </h2>
            <p className="text-lg text-slate-600">
              Your donations are changing lives around the world
            </p>
          </div>
          <Link
            to="/appeals"
            className="inline-flex items-center gap-2 text-emerald-600 font-semibold hover:text-emerald-700 transition-colors"
          >
            View all appeals
            <ArrowRight className="h-4 w-4" />
          </Link>
        </div>

        {/* Campaign grid */}
        <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
          {campaigns.map((campaign) => {
            const progress = Math.round((campaign.raised / campaign.goal) * 100);
            
            return (
              <Link
                key={campaign.id}
                to={campaign.href}
                className="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300"
              >
                {/* Image */}
                <div className="relative aspect-[4/3] overflow-hidden">
                  <img
                    src={campaign.image}
                    alt={campaign.title}
                    className="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500"
                  />
                  <div className="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent" />
                  
                  {/* Progress badge */}
                  <div className="absolute bottom-3 left-3 right-3">
                    <div className="flex items-center justify-between text-white text-sm mb-1.5">
                      <span className="font-semibold">£{campaign.raised.toLocaleString()}</span>
                      <span className="text-white/80">{progress}%</span>
                    </div>
                    <div className="h-1.5 bg-white/30 rounded-full overflow-hidden">
                      <div
                        className="h-full bg-emerald-400 rounded-full transition-all duration-500"
                        style={{ width: `${progress}%` }}
                      />
                    </div>
                  </div>
                </div>

                {/* Content */}
                <div className="p-5">
                  <h3 className="font-bold text-slate-900 mb-2 group-hover:text-emerald-600 transition-colors">
                    {campaign.title}
                  </h3>
                  <p className="text-sm text-slate-600 line-clamp-2 mb-4">
                    {campaign.description}
                  </p>
                  <span className="inline-flex items-center gap-1.5 text-sm font-semibold text-emerald-600">
                    Donate now
                    <ArrowRight className="h-4 w-4 group-hover:translate-x-1 transition-transform" />
                  </span>
                </div>
              </Link>
            );
          })}
        </div>
      </div>
    </section>
  );
}

export default CampaignCards;
