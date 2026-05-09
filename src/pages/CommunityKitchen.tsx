import { Link } from "react-router-dom";
import { ArrowRight, Utensils, Users, Heart, Clock } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";

const stats = [
  { number: "500,000+", label: "Free Meals Served", icon: Utensils },
  { number: "₹59", label: "Cost Per Meal", icon: Heart },
  { number: "Daily", label: "Evening Distribution", icon: Clock },
  { number: "All", label: "Communities Welcome", icon: Users },
];

const testimonials = [
  {
    quote: "Some days work is available, and some days it is not. During difficult times, the Community Kitchen helps people like us by ensuring we can eat properly in the evening.",
    name: "Rafiq",
    role: "Daily Wage Labourer",
  },
  {
    quote: "Here, nobody asks who you are or where you come from. Everyone is treated respectfully. The food helps many poor families and elderly people like me.",
    name: "Shanti Devi",
    role: "Beneficiary",
  },
  {
    quote: "We try our best to make sure every person receives food respectfully. Seeing people leave with satisfaction motivates us to continue this work every day.",
    name: "Faizan Khan",
    role: "Volunteer",
  },
];

export function CommunityKitchen() {
  return (
    <div>
      <Breadcrumbs items={[{ label: "Programs", href: "/community-kitchen" }, { label: "Community Kitchen" }]} />

      {/* Hero */}
      <section className="relative py-20 md:py-28 bg-gradient-to-br from-orange-600 to-amber-600">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div>
              <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-6">
                Community Kitchen
              </h1>
              <p className="text-2xl text-white/95 font-semibold mb-4">
                Serving Free Meals With Dignity & Compassion
              </p>
              <p className="text-lg text-white/85 leading-relaxed mb-8">
                Since 2020, Daan Foundation has been operating its Community Kitchen continuously with one simple mission: to ensure that no needy person sleeps hungry.
              </p>
              <Link
                to="/donate"
                className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-orange-600 hover:shadow-lg transition-shadow"
              >
                Support the Kitchen
                <ArrowRight className="h-5 w-5" />
              </Link>
            </div>
            <div className="hidden lg:block">
              <img
                src="/images/food-distribution-ramadan.jpg"
                alt="Community Kitchen"
                className="rounded-2xl shadow-2xl"
              />
            </div>
          </div>
        </div>
      </section>

      {/* Stats */}
      <section className="py-12 bg-slate-900">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
            {stats.map(({ number, label, icon: Icon }) => (
              <div key={label} className="text-center">
                <Icon className="h-8 w-8 text-orange-400 mx-auto mb-2" />
                <div className="text-2xl md:text-3xl font-bold text-white">{number}</div>
                <div className="text-sm text-slate-400">{label}</div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* About the kitchen */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl font-bold text-slate-900 mb-6">A Daily Mission Against Hunger</h2>
            <div className="prose prose-lg text-slate-600">
              <p>
                Hunger is one of the most painful realities faced by poor and struggling communities. For many daily wage workers, labourers, elderly individuals, patients, travellers, widows, and financially struggling families, arranging even one proper meal can become difficult.
              </p>
              <p>
                Every evening, the Community Kitchen prepares and distributes fresh cooked food to vulnerable individuals and families without discrimination based on religion, caste, background, or social status.
              </p>
              <p>Depending on available resources and support, meals may include:</p>
              <ul>
                <li>Rice and dal</li>
                <li>Roti with vegetable curries</li>
                <li>Khichdi</li>
                <li>Seasonal food items</li>
                <li>Special Ramadan iftar arrangements</li>
              </ul>
              <p>
                The estimated cost of providing one meal is approximately <strong>₹59 per person</strong>. Even a small contribution can help feed someone who may otherwise sleep hungry.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* Testimonials */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl font-bold text-slate-900 mb-10 text-center">Stories From the Community</h2>
          <div className="grid md:grid-cols-3 gap-6">
            {testimonials.map((t) => (
              <div key={t.name} className="bg-white rounded-2xl p-6 shadow-sm">
                <p className="text-slate-600 italic mb-4">"{t.quote}"</p>
                <div className="border-t border-slate-100 pt-4">
                  <div className="font-bold text-slate-900">{t.name}</div>
                  <div className="text-sm text-slate-500">{t.role}</div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 md:py-20 bg-orange-600">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-white mb-4">Join This Mission of Humanity</h2>
          <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">
            A single meal may appear small — but for a hungry person, it can mean hope, comfort, and survival. The Community Kitchen continues running through the generosity of donors, volunteers, and local community participation.
          </p>
          <Link
            to="/donate"
            className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-orange-600 hover:shadow-lg transition-shadow"
          >
            Donate Now
            <ArrowRight className="h-5 w-5" />
          </Link>
        </div>
      </section>
    </div>
  );
}

export default CommunityKitchen;
