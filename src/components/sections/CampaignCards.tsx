import { Link } from "react-router-dom";
import { ArrowRight } from "lucide-react";

const campaigns = [
  {
    id: "community-kitchen",
    title: "Community Kitchen",
    description: "Free daily meals for people in need — serving with dignity since 2020",
    image: "/images/food-distribution-ramadan.jpg",
    raised: 250000,
    goal: 500000,
    href: "/community-kitchen",
  },
  {
    id: "ration-kits",
    title: "Ration Kits Distribution",
    description: "Essential food ration kits for poor families and vulnerable communities",
    image: "/images/community-queue.jpg",
    raised: 120000,
    goal: 250000,
    href: "/where-most-needed",
  },
  {
    id: "education-support",
    title: "Education Support",
    description: "Helping poor children continue education and supporting families with school needs",
    image: "/images/aid-distribution-elderly.jpg",
    raised: 85000,
    goal: 200000,
    href: "/our-work/impact",
  },
  {
    id: "fidya-kaffarah",
    title: "Fidyah & Kaffarah",
    description: "Feed the needy through Fidyah and Kaffarah — fulfil your Islamic obligation",
    image: "/images/iftaar-distribution.jpg",
    raised: 180000,
    goal: 300000,
    href: "/fidya",
  },
];

export function CampaignCards() {
  return (
    <section className="py-16 md:py-24 bg-[#F3F4F6]">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-10">
          <div>
            <h2 className="text-3xl md:text-4xl font-bold text-slate-900 mb-2">
              Current Campaigns
            </h2>
            <p className="text-lg text-slate-600">
              Your donations are changing lives across India
            </p>
          </div>
          <Link
            to="/appeals"
            className="inline-flex items-center gap-2 text-orange-500 font-semibold hover:text-orange-600 transition-colors"
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
                <div className="relative aspect-[4/3] overflow-hidden bg-slate-200">
                  <img
                    src={campaign.image}
                    alt={campaign.title}
                    className="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500"
                  />
                  <div className="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent" />

                  {/* Progress badge */}
                  <div className="absolute bottom-3 left-3 right-3">
                    <div className="flex items-center justify-between text-white text-sm mb-1.5">
                      <span className="font-semibold">₹{campaign.raised.toLocaleString()}</span>
                      <span className="text-white/80">{progress}%</span>
                    </div>
                    <div className="h-1.5 bg-white/30 rounded-full overflow-hidden">
                      <div
                        className="h-full bg-orange-500 rounded-full transition-all duration-500"
                        style={{ width: `${progress}%` }}
                      />
                    </div>
                  </div>
                </div>

                {/* Content */}
                <div className="p-5">
                  <h3 className="font-bold text-slate-900 mb-2 group-hover:text-orange-500 transition-colors">
                    {campaign.title}
                  </h3>
                  <p className="text-sm text-slate-600 line-clamp-2 mb-4">
                    {campaign.description}
                  </p>
                  <span className="inline-flex items-center gap-1.5 text-sm font-semibold text-orange-500">
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
