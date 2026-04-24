import { Link } from "react-router-dom";
import { Calculator, Heart, Users, Droplets, Briefcase, Gift } from "lucide-react";

const quickActions = [
  {
    icon: Calculator,
    title: "Calculate Zakat",
    description: "See how much zakat you owe",
    href: "/zakat-calculator",
    gradient: "from-emerald-600 to-teal-700",
  },
  {
    icon: Heart,
    title: "Give Sadaqah",
    description: "Earn ongoing rewards with a voluntary donation",
    href: "/sadaqah",
    gradient: "from-rose-500 to-pink-600",
  },
  {
    icon: Users,
    title: "Sponsor an Orphan",
    description: "Change a child's life with monthly support",
    href: "/orphan-sponsorship",
    gradient: "from-amber-500 to-orange-600",
  },
  {
    icon: Droplets,
    title: "Water for Life",
    description: "Provide clean water to communities in need",
    href: "/water",
    gradient: "from-blue-500 to-indigo-600",
  },
  {
    icon: Briefcase,
    title: "Livelihoods",
    description: "Help families build sustainable futures",
    href: "/livelihoods",
    gradient: "from-violet-500 to-purple-600",
  },
  {
    icon: Gift,
    title: "Sadaqah Jariyah",
    description: "Give a gift that keeps on giving",
    href: "/sadaqah-jariyah",
    gradient: "from-cyan-500 to-teal-600",
  },
];

export function QuickActions() {
  return (
    <section className="py-16 md:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="text-center mb-12">
          <h2 className="text-3xl md:text-4xl font-bold text-slate-900 mb-4">
            Maximise Your Reward
          </h2>
          <p className="text-lg text-slate-600 max-w-2xl mx-auto">
            Choose how you'd like to make a difference today
          </p>
        </div>

        {/* Grid */}
        <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
          {quickActions.map(({ icon: Icon, title, description, href, gradient }) => (
            <Link
              key={title}
              to={href}
              className="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 hover:shadow-xl hover:ring-emerald-200 transition-all duration-300"
            >
              {/* Icon */}
              <div className={`inline-flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br ${gradient} mb-4`}>
                <Icon className="h-7 w-7 text-white" />
              </div>

              {/* Content */}
              <h3 className="text-lg font-bold text-slate-900 mb-2 group-hover:text-emerald-600 transition-colors">
                {title}
              </h3>
              <p className="text-sm text-slate-600">
                {description}
              </p>

              {/* Hover arrow */}
              <div className="absolute right-4 bottom-4 opacity-0 group-hover:opacity-100 transition-opacity">
                <svg className="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
              </div>
            </Link>
          ))}
        </div>
      </div>
    </section>
  );
}

export default QuickActions;
