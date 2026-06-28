import { Users, Globe, Heart, Utensils } from "lucide-react";

const stats = [
  {
    number: "500K+",
    label: "Food Packets Distributed",
    description: "Meals and food packets served since 2020",
    icon: Utensils,
    image: "/images/food-distribution-ramadan.jpg",
  },
  {
    number: "100K+",
    label: "Iftar Kits Distributed",
    description: "Food and Iftar kits provided during Ramadan",
    icon: Heart,
    image: "/images/iftaar-distribution.jpg",
  },
  {
    number: "6+",
    label: "Years of Experience",
    description: "Serving communities with compassion since 2020",
    icon: Users,
    image: "/images/community-queue.jpg",
  },
  {
    number: "600K+",
    label: "Beneficiaries Reached",
    description: "Total lives touched across India",
    icon: Globe,
    image: "/images/aid-distribution-elderly.jpg",
  },
];

export function ImpactStats() {
  return (
    <section className="py-16 md:py-24 bg-slate-900 text-white overflow-hidden">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="text-center mb-12">
          <h2 className="text-3xl md:text-4xl font-bold mb-4">Our Impact</h2>
          <p className="text-lg text-slate-400 max-w-2xl mx-auto">
            Together, we are making a meaningful difference in the lives of those who need it most.
          </p>
        </div>

        {/* Stats grid */}
        <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
          {stats.map(({ number, label, description, icon: Icon, image }) => (
            <div key={label} className="group relative rounded-2xl overflow-hidden">
              {/* Background image */}
              <div className="absolute inset-0">
                <img
                  src={image}
                  alt={label}
                  className="h-full w-full object-cover opacity-30 group-hover:opacity-40 group-hover:scale-105 transition-all duration-500"
                />
                <div className="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/80 to-slate-900/60" />
              </div>

              {/* Content */}
              <div className="relative p-6 text-center">
                <div className="h-14 w-14 rounded-xl bg-orange-500/20 flex items-center justify-center mx-auto mb-4">
                  <Icon className="h-7 w-7 text-orange-400" />
                </div>
                <div className="text-4xl md:text-5xl font-bold text-white mb-2">{number}</div>
                <div className="text-lg font-semibold text-orange-400 mb-2">{label}</div>
                <p className="text-sm text-slate-400">{description}</p>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

export default ImpactStats;
