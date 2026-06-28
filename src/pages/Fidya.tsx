import { Link } from "react-router-dom";
import { ArrowRight, Utensils, Users, Heart, MapPin } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";
import ProjectPageLayout from "@/components/donation/ProjectPageLayout";

export function Fidya() {
  return (
    <div>
      <SEO title="Fidya - Compensation for Missed Fasts" description="Pay Fidya through Daan Foundation. Fidya is for those unable to fast due to valid long-term reasons. Your donation feeds needy people." canonical="/fidya" />
      <Breadcrumbs items={[{ label: "Fidya" }]} />

      <section className="relative bg-gradient-to-br from-emerald-600 to-teal-700">
        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 md:py-16">
          <div className="max-w-3xl">
            <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-4">Fidya</h1>
            <p className="text-xl text-white/90 leading-relaxed max-w-2xl">A charitable compensation for those unable to fast during Ramadan due to valid long-term reasons.</p>
          </div>
        </div>
      </section>

      <ProjectPageLayout defaultCause="fidya-kaffarah">
        <div className="space-y-10">

          <div className="rounded-2xl overflow-hidden shadow-lg">
            <img src="/images/extra-2.jpg" alt="Fidya food distribution" className="w-full h-[300px] md:h-[400px] object-cover" />
          </div>

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">What is Fidya?</h2>
            <p className="text-slate-600 leading-relaxed">
              Fidya is a charitable compensation in Islam given by those who are unable to fast during Ramadan due to valid long-term reasons such as old age, chronic illness, or a medical condition that makes fasting permanently difficult. When a person cannot fast and is also unable to make up the missed fasts later, Islam allows them to feed a needy person instead.
            </p>
            <p className="text-slate-600 leading-relaxed mt-4">
              At Daan Foundation, Fidya donations are used to provide meals and food support to poor and needy people across India through our Community Kitchen and food assistance programmes.
            </p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-emerald-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Why is Fidya Important in Islam?</h2>
            <p className="text-slate-600">Fasting in Ramadan is one of the important pillars of Islam. However, Islam is also a religion of mercy and ease. Those who genuinely cannot fast are not burdened beyond their ability.</p>
            <blockquote className="border-l-4 border-emerald-600 pl-4 italic text-slate-700 text-lg mt-4">
              &ldquo;And for those who are able to fast with difficulty, there is a ransom: feeding a needy person.&rdquo;
              <footer className="text-sm mt-2 not-italic text-slate-500">&mdash; Qur&rsquo;an 2:184</footer>
            </blockquote>
            <p className="text-slate-600 mt-4">Fidya allows elderly people, chronically ill individuals, and others who cannot fast permanently to still participate in the blessings of Ramadan by helping those who are hungry and in need.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">How Daan Foundation Uses Fidya Donations</h2>
            <p className="text-slate-600 mb-6">Daan Foundation works only within India and uses Fidya donations to support poor and vulnerable communities through:</p>
            <div className="grid sm:grid-cols-2 gap-4">
              {[
                "Daily cooked meal distribution",
                "Ramadan iftar support",
                "Ration kit distribution",
                "Assistance to elderly and sick individuals",
                "Food support for widows and struggling families",
              ].map((item) => (
                <div key={item} className="flex items-start gap-3 bg-white rounded-xl p-4 shadow-sm border border-slate-100">
                  <span className="text-emerald-600 font-bold text-lg flex-shrink-0">&check;</span>
                  <span className="text-slate-700">{item}</span>
                </div>
              ))}
            </div>
            <p className="text-slate-600 mt-4">Our Community Kitchen, started in 2020, continues to serve free evening meals every day without discrimination of religion, caste or background. With the help of Zakat, Sadaqah, Fidya, Kaffarah and general charity contributions, Daan Foundation has already distributed more than 500,000 meals since its beginning.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Community Kitchen &mdash; Feeding the Hungry Daily</h2>
            <p className="text-slate-600">What began as a small Ramadan iftar effort planned for only 15 days gradually became a continuous humanitarian mission. Today, every evening, Daan Foundation prepares fresh meals for needy people including labourers, elderly persons, homeless individuals, widows, orphans, and poor families.</p>
            <p className="text-lg font-semibold text-emerald-700 bg-white rounded-xl p-4 mt-4">The approximate cost of one meal is around ₹59 per person.</p>
            <p className="text-slate-600 mt-4">For many people, this meal becomes the only proper food they receive during the day.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="grid md:grid-cols-2 gap-6">
            <div className="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
              <h3 className="text-xl font-bold text-slate-900 mb-4">Who Should Pay Fidya?</h3>
              <ul className="space-y-2 text-slate-600">
                <li className="flex items-start gap-2"><span className="text-emerald-600 mt-1">•</span> Elderly and physically weak</li>
                <li className="flex items-start gap-2"><span className="text-emerald-600 mt-1">•</span> Those with chronic illness</li>
                <li className="flex items-start gap-2"><span className="text-emerald-600 mt-1">•</span> Long-term medical conditions</li>
                <li className="flex items-start gap-2"><span className="text-emerald-600 mt-1">•</span> Permanently unable to fast</li>
                <li className="flex items-start gap-2"><span className="text-emerald-600 mt-1">•</span> Cannot make up missed fasts later</li>
              </ul>
              <p className="text-sm text-slate-500 mt-4">In such situations, feeding needy people becomes a source of mercy and reward.</p>
            </div>
            <div className="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
              <h3 className="text-xl font-bold text-slate-900 mb-4">Difference Between Fidya and Kaffarah</h3>
              <div className="space-y-4">
                <div className="bg-emerald-50 rounded-xl p-4">
                  <p className="font-bold text-emerald-800">Fidya</p>
                  <p className="text-sm text-slate-600">Paid when a person genuinely cannot fast. Usually equivalent to feeding one needy person for each missed fast.</p>
                </div>
                <div className="bg-red-50 rounded-xl p-4">
                  <p className="font-bold text-red-800">Kaffarah</p>
                  <p className="text-sm text-slate-600">Paid when someone intentionally breaks a fast without a valid reason. Requires feeding many poor people or fasting continuously.</p>
                </div>
              </div>
            </div>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-slate-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Transparency and Responsibility</h2>
            <p className="text-slate-600">Daan Foundation treats every donation as an amanah (trust). We strive to use every contribution honestly and responsibly for humanitarian work inside India.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-blue-50 rounded-xl p-5 border border-blue-200">
            <div className="flex items-start gap-4">
              <MapPin className="h-6 w-6 text-blue-600 flex-shrink-0 mt-1" />
              <div>
                <h3 className="font-bold text-slate-900 text-lg">Working Only Within India</h3>
                <p className="text-slate-600 mt-1">Daan Foundation works only in India. We do not operate internationally and are not authorised to receive foreign donations. All support is used for Indian communities and humanitarian activities within India.</p>
              </div>
            </div>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-gradient-to-r from-emerald-600 to-teal-700 rounded-2xl p-8 md:p-10 text-center">
            <h2 className="text-3xl font-bold text-white mb-4">Your Fidya Can Feed the Hungry</h2>
            <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">Your contribution directly supports people struggling with hunger and poverty. Even a single meal can become a reason for relief, dignity and hope for someone in need.</p>
            <Link to="/donate" className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-emerald-600 hover:shadow-lg transition-shadow">
              Pay Fidya Now <ArrowRight className="h-5 w-5" />
            </Link>
          </section>

        </div>
      </ProjectPageLayout>
    </div>
  );
}

export default Fidya;
