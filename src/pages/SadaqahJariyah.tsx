import { Link } from "react-router-dom";
import { ArrowRight, Heart, Utensils, Users, Stethoscope, GraduationCap, Shirt, TreePine, BookOpen, MapPin, Infinity } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";
import ProjectPageLayout from "@/components/donation/ProjectPageLayout";

export function SadaqahJariyah() {
  return (
    <div>
      <SEO title="Sadaqah Jariyah - Ongoing Charity" description="Give Sadaqah Jariyah - ongoing charity that continues benefiting people. Support Daan Foundation's Community Kitchen and create lasting impact." canonical="/sadaqah-jariyah" />
      <Breadcrumbs items={[{ label: "Sadaqah Jariyah" }]} />

      <section className="relative bg-gradient-to-br from-cyan-600 to-teal-700">
        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 md:py-16">
          <div className="max-w-3xl">
            <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-4">Sadaqah Jariyah</h1>
            <p className="text-xl text-white/90 leading-relaxed max-w-2xl">Ongoing charity that continues benefiting people, even after the donor has passed away.</p>
          </div>
        </div>
      </section>

      <ProjectPageLayout defaultCause="community-kitchen">
        <div className="space-y-10">

          <div className="rounded-2xl overflow-hidden shadow-lg">
            <img src="/images/extra-1.jpg" alt="Sadaqah Jariyah" className="w-full h-[300px] md:h-[400px] object-cover" />
          </div>

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">What is Sadaqah Jariyah?</h2>
            <div className="prose prose-lg max-w-none text-slate-600">
              <p>Sadaqah Jariyah means <strong>&ldquo;ongoing charity.&rdquo;</strong> It refers to any charitable act that continues benefiting people over time, even after the donor has passed away.</p>
              <p>In Islam, this form of charity is considered extremely valuable because its reward continues as long as people continue benefiting from it.</p>
            </div>
            <blockquote className="border-l-4 border-teal-500 pl-4 italic text-slate-700 text-lg mt-6 bg-teal-50 rounded-r-xl p-4">
              &ldquo;When a person dies, all their deeds end except three: a continuing charity, beneficial knowledge, and a righteous child who prays for them.&rdquo;
              <footer className="text-sm mt-2 not-italic text-slate-500">&mdash; Hadith, Sahih Muslim</footer>
            </blockquote>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-gradient-to-br from-teal-50 to-cyan-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Why Sadaqah Jariyah Is Important</h2>
            <p className="text-slate-600">Sadaqah Jariyah is not only about donating money. It is about creating lasting benefit for humanity. A small act done sincerely can continue helping poor families, hungry people, children, patients, travellers, and struggling communities for a long time. The reward of such charity continues as long as people continue benefiting from it.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Sadaqah Jariyah at Daan Foundation</h2>
            <p className="text-slate-600">Since 2020, Daan Foundation has been working within India to help vulnerable communities through continuous humanitarian efforts. The organization works only within India and focuses entirely on local charitable and welfare activities. The foundation believes that regular food support and community welfare initiatives are among the most meaningful forms of ongoing charity because they continuously help people facing hardship.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Community Kitchen — An Ongoing Charity</h2>
            <p className="text-slate-600">One of the foundation&rsquo;s most important humanitarian initiatives is its Community Kitchen. What started during Ramadan 2020 as a small 15-day food initiative gradually became a continuous humanitarian effort serving people daily.</p>
            <p className="text-2xl font-bold text-teal-600 bg-white rounded-xl p-4 text-center my-4">500,000+ Meals distributed since 2020</p>
            <p className="text-slate-600">The organization believes that feeding hungry people regularly is among the most impactful forms of Sadaqah Jariyah.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Examples of Sadaqah Jariyah</h2>
            <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
              {[
                { icon: Utensils, title: "Feeding People", desc: "Regular food support for the needy" },
                { icon: GraduationCap, title: "Education", desc: "Helping educate a child" },
                { icon: Stethoscope, title: "Medical Care", desc: "Supporting medical treatment" },
                { icon: Users, title: "Self-Reliance", desc: "Helping someone become self-dependent" },
                { icon: BookOpen, title: "Knowledge", desc: "Distributing useful knowledge" },
                { icon: TreePine, title: "Environment", desc: "Planting trees for future" },
              ].map(({ icon: Icon, title, desc }) => (
                <div key={title} className="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
                  <Icon className="h-6 w-6 text-teal-500 mb-3" />
                  <h3 className="font-bold text-slate-900 mb-1">{title}</h3>
                  <p className="text-sm text-slate-600">{desc}</p>
                </div>
              ))}
            </div>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-slate-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Transparency &amp; Responsibility</h2>
            <p className="text-slate-600">The foundation considers every donation an amanah — a trust. Daan Foundation remains committed to honesty, responsible use of donations, transparency, and humanitarian service with dignity.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-blue-50 rounded-xl p-5 border border-blue-200">
            <div className="flex items-start gap-4">
              <MapPin className="h-6 w-6 text-blue-600 flex-shrink-0 mt-1" />
              <div>
                <h3 className="font-bold text-slate-900 text-lg">Working Only Within India</h3>
                <p className="text-slate-600 mt-1">Daan Foundation operates only within India and focuses entirely on charitable and humanitarian activities within Indian geography.</p>
              </div>
            </div>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-gradient-to-r from-cyan-600 to-teal-700 rounded-2xl p-8 md:p-10 text-center">
            <h2 className="text-3xl font-bold text-white mb-4">Give a Gift That Keeps on Giving</h2>
            <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">Your Sadaqah Jariyah can create lasting impact and continuous rewards.</p>
            <Link to="/donate" className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-teal-600 hover:shadow-lg transition-shadow">
              Give Sadaqah Jariyah Now <ArrowRight className="h-5 w-5" />
            </Link>
          </section>

        </div>
      </ProjectPageLayout>
    </div>
  );
}

export default SadaqahJariyah;
