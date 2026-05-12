import { Link } from "react-router-dom";
import { ArrowRight, Heart } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";

const examples = [
  "Feeding people regularly",
  "Helping educate a child",
  "Supporting medical care",
  "Helping someone become self-dependent",
  "Distributing useful knowledge",
  "Supporting community welfare initiatives",
  "Helping sustain humanitarian services",
];

export function SadaqahJariyah() {
  return (
    <div>
      <SEO title="Sadaqah Jariyah - Ongoing Charity" description="Give Sadaqah Jariyah through Daan Foundation. Invest in ongoing charity that continues to benefit communities — water wells, education, and sustainable programs." canonical="/sadaqah-jariyah" keywords="sadaqah jariyah, ongoing charity Islam, continuous reward, Islamic charity India" />
      <Breadcrumbs items={[{ label: "Islamic Giving", href: "/zakat" }, { label: "Sadaqah Jariyah" }]} />

      {/* Hero */}
      <section className="relative py-20 md:py-28 bg-gradient-to-br from-emerald-600 to-teal-700">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div>
              <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-6">
                Sadaqah Jariyah
              </h1>
              <p className="text-xl text-white/90 leading-relaxed mb-4">
                "Ongoing charity" — a charitable act that continues benefiting people over time, even after the donor has passed away.
              </p>
              <blockquote className="border-l-4 border-white/40 pl-4 text-white/80 italic mb-8">
                "When a person dies, all their deeds end except three: a continuing charity, beneficial knowledge, and a righteous child who prays for them."
                <span className="block text-sm mt-1 not-italic">— Sahih Muslim</span>
              </blockquote>
              <Link
                to="/donate"
                className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-emerald-600 hover:shadow-lg transition-shadow"
              >
                Give Sadaqah Jariyah
                <ArrowRight className="h-5 w-5" />
              </Link>
            </div>
            <div className="hidden lg:block">
              <img
                src="/images/community-queue.jpg"
                alt="Community support"
                className="rounded-2xl shadow-2xl"
              />
            </div>
          </div>
        </div>
      </section>

      {/* What is Sadaqah Jariyah */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Why Sadaqah Jariyah Is Important</h2>
            <div className="prose prose-lg text-slate-600">
              <p>
                Sadaqah Jariyah is not only about donating money. It is about creating lasting benefit for humanity. A small act done sincerely can continue helping poor families, hungry people, children, patients, travellers, and struggling communities for a long time.
              </p>
              <p>
                The reward of such charity continues as long as people continue benefiting from it. This is why Muslims often support long-term humanitarian and welfare initiatives that continue helping communities for years.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* Examples */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl font-bold text-slate-900 mb-8 text-center">Examples of Sadaqah Jariyah</h2>
          <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 max-w-4xl mx-auto">
            {examples.map((example) => (
              <div key={example} className="bg-white rounded-xl p-5 shadow-sm flex items-start gap-3">
                <Heart className="h-5 w-5 text-emerald-500 mt-0.5 shrink-0" />
                <span className="text-slate-700 font-medium">{example}</span>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Community Kitchen as ongoing charity */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Community Kitchen — An Ongoing Charity</h2>
            <div className="prose prose-lg text-slate-600">
              <p>
                What started during Ramadan 2020 as a small 15-day food initiative gradually became a continuous humanitarian effort serving people daily. Every evening, freshly prepared meals are distributed to labourers, poor families, elderly individuals, widows, travellers, patients, and financially struggling people.
              </p>
              <p>
                Since 2020, Daan Foundation has distributed <strong>500,000+ Meals</strong> through its Community Kitchen and food support programs.
              </p>
              <p>
                The organisation believes that feeding hungry people regularly is among the most impactful forms of Sadaqah Jariyah.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 md:py-20 bg-emerald-600">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-white mb-4">A Mission of Ongoing Compassion</h2>
          <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">
            Every meal served, every family supported, and every act of kindness reflects the spirit of Sadaqah Jariyah. Your contribution creates continuous reward and relief.
          </p>
          <Link
            to="/donate"
            className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-emerald-600 hover:shadow-lg transition-shadow"
          >
            Give Sadaqah Jariyah
            <ArrowRight className="h-5 w-5" />
          </Link>
        </div>
      </section>
    </div>
  );
}

export default SadaqahJariyah;
