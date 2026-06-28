import { Link } from "react-router-dom";
import { ArrowRight, Utensils, Users, Heart, Clock, MapPin } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";
import ProjectPageLayout from "@/components/donation/ProjectPageLayout";

const testimonials = [
  {
    quote: "Some days work is available, and some days it is not. During difficult times, the Community Kitchen helps people like us by ensuring we can eat properly in the evening. This support means a lot to poor workers.",
    name: "Rafiq",
    role: "Daily Wage Labourer",
  },
  {
    quote: "Here, nobody asks who you are or where you come from. Everyone is treated respectfully. The food helps many poor families and elderly people like me.",
    name: "Shanti Devi",
    role: "Beneficiary",
  },
  {
    quote: "I have seen laborers, travelers, poor patients, and many needy people receiving food here daily. This kitchen has become a support system for many people in the community.",
    name: "Salman Khan",
    role: "Community Member",
  },
  {
    quote: "We try our best to make sure every person receives food respectfully. Seeing people leave with satisfaction motivates us to continue this work every day.",
    name: "Faizan Khan",
    role: "Volunteer",
  },
  {
    quote: "The food is freshly prepared daily, and different meals are served regularly. For many poor families, this kitchen provides comfort and relief.",
    name: "Chhoti Aapa",
    role: "Beneficiary",
  },
];

export function CommunityKitchen() {
  return (
    <div>
      <SEO title="Community Kitchen - Free Daily Meals" description="Daan Foundation's Community Kitchen serves 500,000+ free meals since 2020. Daily evening meals for labourers, elderly, widows, and struggling families. ₹59 per meal." canonical="/community-kitchen" keywords="community kitchen India, free meals charity, food distribution, daily meal program, feed the hungry India" />
      <Breadcrumbs items={[{ label: "Community Kitchen" }]} />

      <section className="relative bg-gradient-to-br from-orange-600 to-amber-600">
        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 md:py-16">
          <div className="max-w-3xl">
            <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-4">Community Kitchen</h1>
            <p className="text-2xl text-white/95 font-semibold mb-2">Serving Free Meals With Dignity &amp; Compassion</p>
            <p className="text-lg text-white/85 leading-relaxed">Since 2020, Daan Foundation has been operating its Community Kitchen continuously with one simple mission: to ensure that no needy person sleeps hungry.</p>
          </div>
        </div>
      </section>

      <ProjectPageLayout defaultCause="community-kitchen">
        <div className="space-y-10">

          <div className="rounded-2xl overflow-hidden shadow-lg">
            <img src="/images/food-distribution-ramadan.jpg" alt="Community Kitchen serving free meals" className="w-full h-[300px] md:h-[400px] object-cover" />
          </div>

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">A Daily Mission Against Hunger</h2>
            <p className="text-slate-600 leading-relaxed">
              Daan Foundation has been operating its Community Kitchen continuously since 2020 with one simple mission: to ensure that no needy person sleeps hungry.
            </p>
            <p className="text-slate-600 leading-relaxed mt-4">
              What started during Ramadan in 2020 as a small food distribution effort for only 15 days gradually transformed into a regular humanitarian initiative that now serves free meals daily to people in need.
            </p>
            <p className="text-slate-600 leading-relaxed mt-4">
              Every evening, the Community Kitchen prepares and distributes fresh cooked food to vulnerable individuals and families without discrimination based on religion, caste, background, or social status. Anyone in need can come and receive food with dignity and respect.
            </p>
          </section>

          <div className="border-t border-slate-200" />

          {/* Stats */}
          <div className="bg-slate-900 rounded-2xl p-6 md:p-8">
            <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
              {[
                { number: "500,000+", label: "Free Meals Served", icon: Utensils },
                { number: "₹59", label: "Cost Per Meal", icon: Heart },
                { number: "Daily", label: "Evening Distribution", icon: Clock },
                { number: "All", label: "Communities Welcome", icon: Users },
              ].map(({ number, label, icon: Icon }) => (
                <div key={label} className="text-center">
                  <Icon className="h-8 w-8 text-orange-400 mx-auto mb-2" />
                  <div className="text-2xl md:text-3xl font-bold text-white">{number}</div>
                  <div className="text-sm text-slate-400">{label}</div>
                </div>
              ))}
            </div>
          </div>

          <div className="border-t border-slate-200" />

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Hunger Is a Daily Struggle</h2>
            <p className="text-slate-600 leading-relaxed">
              Hunger is one of the most painful realities faced by poor and struggling communities. For many daily wage workers, laborers, elderly individuals, patients, travelers, widows, and financially struggling families, arranging even one proper meal can become difficult.
            </p>
            <p className="text-slate-600 leading-relaxed mt-4">
              Daan Foundation&rsquo;s Community Kitchen works every day to reduce this hardship by providing nutritious evening meals to those who need support.
            </p>
            <p className="text-2xl font-bold text-orange-600 bg-orange-50 rounded-xl p-4 text-center mt-6">
              500,000+ Free Meals served since 2020
            </p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Food Served With Respect</h2>
            <p className="text-slate-600">One of the most important principles of the Community Kitchen is dignity. Every person who comes for food is treated respectfully, regardless of religion, caste, community, language, or financial background.</p>
            <p className="font-semibold text-orange-700 mt-4">The foundation believes hunger does not discriminate between people — and humanitarian support should not discriminate either.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Fresh Meals Prepared Daily</h2>
            <p className="text-slate-600">The Community Kitchen provides different types of freshly prepared meals regularly so that people receive nutritious and satisfying food.</p>
            <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
              {["Rice", "Dal", "Vegetables", "Roti", "Khichdi", "Seasonal food items"].map((item) => (
                <div key={item} className="bg-white rounded-xl p-4 shadow-sm border border-slate-100 text-center font-semibold text-slate-700">
                  {item}
                </div>
              ))}
            </div>
            <p className="text-lg font-bold text-orange-700 bg-orange-50 rounded-xl p-4 mt-6 text-center">
              Estimated cost: ₹59 Per Person &mdash; Even a small contribution can help feed someone who may otherwise sleep hungry.
            </p>
          </section>

          <div className="border-t border-slate-200" />

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-8 text-center">Stories From the Community</h2>
            <div className="grid md:grid-cols-2 gap-6">
              {testimonials.map((t) => (
                <div key={t.name} className="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                  <p className="text-slate-600 italic mb-4">&ldquo;{t.quote}&rdquo;</p>
                  <div className="border-t border-slate-100 pt-4">
                    <div className="font-bold text-slate-900">{t.name}</div>
                    <div className="text-sm text-slate-500">{t.role}</div>
                  </div>
                </div>
              ))}
            </div>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">More Than Just Food</h2>
            <p className="text-slate-600">The Community Kitchen is not only about distributing meals. It is also about restoring dignity, reducing hunger, creating compassion within communities, and ensuring vulnerable people feel supported and respected. For many individuals, this evening meal becomes a source of emotional relief during difficult times.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-slate-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">A Vision for the Future</h2>
            <p className="text-slate-600">Daan Foundation hopes to expand the Community Kitchen initiative further and reach more people across different regions within India. The long-term vision is to establish more community-based food support systems so that vulnerable individuals in more areas can access free meals with dignity.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-blue-50 rounded-xl p-5 border border-blue-200">
            <div className="flex items-start gap-4">
              <MapPin className="h-6 w-6 text-blue-600 flex-shrink-0 mt-1" />
              <div>
                <h3 className="font-bold text-slate-900 text-lg">Serving Humanity Since 2020</h3>
                <p className="text-slate-600 mt-1">Since its beginning, Daan Foundation&rsquo;s Community Kitchen has remained committed to serving people with compassion, dignity, equality, and responsibility. The foundation continues its mission every evening with the belief that no person should sleep hungry.</p>
              </div>
            </div>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-gradient-to-r from-orange-600 to-amber-600 rounded-2xl p-8 md:p-10 text-center">
            <h2 className="text-3xl font-bold text-white mb-4">Join This Mission of Humanity</h2>
            <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">The Community Kitchen continues running through the generosity of donors, volunteers, Zakat contributions, Sadaqah, charity support, and local community participation. Every contribution helps provide meals to someone in need. A single meal may appear small — but for a hungry person, it can mean hope, comfort, and survival.</p>
            <Link to="/donate" className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-orange-600 hover:shadow-lg transition-shadow">
              Support the Kitchen <ArrowRight className="h-5 w-5" />
            </Link>
          </section>

        </div>
      </ProjectPageLayout>
    </div>
  );
}

export default CommunityKitchen;
