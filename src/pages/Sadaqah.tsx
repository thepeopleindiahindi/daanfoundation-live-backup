import { Link } from "react-router-dom";
import { ArrowRight, Heart, Utensils, Users, Stethoscope, GraduationCap, Shirt, Smile, BookOpen, MapPin } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import { sadaqahFAQs } from "@/data/faqs";
import {
  Accordion,
  AccordionContent,
  AccordionItem,
  AccordionTrigger,
} from "@/components/ui/accordion";
import SEO from "@/components/SEO";
import ProjectPageLayout from "@/components/donation/ProjectPageLayout";
import { Button } from "@/components/ui/button";

export function Sadaqah() {
  return (
    <div>
      <SEO title="Give Sadaqah - Voluntary Charity" description="Give Sadaqah through Daan Foundation. Your voluntary charity helps feed the hungry, support widows, and uplift vulnerable communities across India." canonical="/sadaqah" keywords="sadaqah donation, voluntary charity Islam, give sadaqah online, Islamic giving India" />
      <Breadcrumbs items={[{ label: "Sadaqah" }]} />

      <section className="relative bg-gradient-to-br from-rose-500 to-pink-600">
        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 md:py-16">
          <div className="max-w-3xl">
            <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-4">
              Give Sadaqah
            </h1>
            <p className="text-xl text-white/90 leading-relaxed max-w-2xl">
              Voluntary charity given sincerely for the sake of Allah. Every contribution, no matter how small, makes a difference.
            </p>
          </div>
        </div>
      </section>

      <ProjectPageLayout defaultCause="sadaqah">
        <div className="space-y-10">

          <div className="rounded-2xl overflow-hidden shadow-lg">
            <img
              src="/images/aid-distribution-elderly.jpg"
              alt="Sadaqah helping those in need"
              className="w-full h-[300px] md:h-[400px] object-cover"
            />
          </div>

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">What is Sadaqah?</h2>
            <div className="prose prose-lg max-w-none text-slate-600">
              <p>
                Sadaqah is one of the most beautiful forms of compassion and humanity in Islam. Sadaqah means voluntary charity given sincerely for the sake of Allah (SWT). It can be financial support, feeding hungry people, helping poor families, supporting patients, providing clothes, helping someone in difficulty, or even simple acts of kindness such as a smile, respect, or helping hand.
              </p>
              <p>
                Unlike Zakat, Sadaqah is not compulsory. A person can give any amount at any time according to their ability and intention.
              </p>
            </div>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-rose-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">The Meaning of Sadaqah</h2>
            <p className="text-slate-600">
              The word Sadaqah comes from the Arabic word <strong>&ldquo;Sidq&rdquo;</strong> — meaning <strong>sincerity</strong>. This reflects that true charity comes from a sincere heart and genuine concern for others. In Islam, helping people with kindness and compassion is considered a noble and rewarding act.
            </p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-emerald-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Sadaqah in the Light of Islam</h2>
            <blockquote className="border-l-4 border-emerald-600 pl-4 italic text-slate-700 text-lg">
              &ldquo;Who is it that would loan Allah a goodly loan so He may multiply it for him many times over?&rdquo;
              <footer className="text-sm mt-2 not-italic text-slate-500">&mdash; Qur&rsquo;an 2:245</footer>
            </blockquote>
            <blockquote className="border-l-4 border-rose-500 pl-4 italic text-slate-700 text-lg mt-4">
              &ldquo;Sadaqah extinguishes sin as water extinguishes fire.&rdquo;
              <footer className="text-sm mt-2 not-italic text-slate-500">&mdash; Hadith, Tirmidhi</footer>
            </blockquote>
            <p className="mt-4 text-slate-600">
              The Prophet Muhammad (Peace Be Upon Him) was known for increasing charity during Ramadan and helping poor and needy people generously.
            </p>
          </section>

          <div className="border-t border-slate-200" />

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">How Daan Foundation Uses Sadaqah</h2>
            <div className="prose prose-lg max-w-none text-slate-600">
              <p>
                Since 2020, Daan Foundation has been utilizing Sadaqah, charity contributions, and community support to help vulnerable and needy people within India. The organization works only within India and focuses on humanitarian support for struggling communities.
              </p>
            </div>
            <div className="grid sm:grid-cols-2 gap-4 mt-6">
              {[
                { icon: Utensils, label: "Community Kitchen services & daily food distribution" },
                { icon: Heart, label: "Ramadan Iftar arrangements" },
                { icon: Users, label: "Ration kit support" },
                { icon: Shirt, label: "Clothing distribution" },
                { icon: Stethoscope, label: "Medical assistance" },
                { icon: GraduationCap, label: "Educational support" },
              ].map(({ icon: Icon, label }) => (
                <div key={label} className="flex items-start gap-3 bg-white rounded-xl p-4 shadow-sm border border-slate-100">
                  <div className="h-10 w-10 rounded-lg bg-rose-100 flex items-center justify-center flex-shrink-0">
                    <Icon className="h-5 w-5 text-rose-600" />
                  </div>
                  <span className="text-slate-700 font-medium">{label}</span>
                </div>
              ))}
            </div>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-gradient-to-br from-rose-50 to-pink-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Community Kitchen &amp; Daily Food Support</h2>
            <div className="prose prose-lg max-w-none text-slate-600">
              <p>
                One of the foundation&rsquo;s most important humanitarian initiatives is its Community Kitchen, where fresh cooked meals are distributed daily in the evening to people in need.
              </p>
              <p className="text-2xl font-bold text-rose-600 bg-white rounded-xl p-4 text-center">
                500,000+ Meals distributed since 2020
              </p>
              <p>
                Food is distributed without discrimination based on religion, caste, language, or social background. The organization believes hunger affects humanity equally, and support should be provided with dignity and compassion.
              </p>
            </div>
          </section>

          <div className="border-t border-slate-200" />

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Sadaqah Jariyah — Ongoing Charity</h2>
            <div className="prose prose-lg max-w-none text-slate-600">
              <p>
                Islam also teaches the concept of <strong>Sadaqah Jariyah</strong> (Continuous Charity). This refers to charity that continues benefiting people over time.
              </p>
              <p>Examples may include:</p>
              <ul>
                <li>Feeding people regularly</li>
                <li>Supporting education</li>
                <li>Helping someone become self-dependent</li>
                <li>Contributing toward long-term humanitarian work</li>
              </ul>
              <p>
                Daan Foundation believes that helping communities consistently creates long-term positive impact and hope for vulnerable families.
              </p>
              <Link to="/sadaqah-jariyah" className="inline-flex items-center gap-2 text-rose-600 font-semibold hover:underline mt-4">
                Learn more about Sadaqah Jariyah <ArrowRight className="h-4 w-4" />
              </Link>
            </div>
          </section>

          <div className="border-t border-slate-200" />

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">More Than Food Support</h2>
            <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
              {[
                { icon: GraduationCap, title: "Education", desc: "Helping poor children continue education" },
                { icon: Stethoscope, title: "Medical Aid", desc: "Supporting patients with medical assistance" },
                { icon: Shirt, title: "Clothing", desc: "Distributing clothes to needy individuals" },
                { icon: Heart, title: "Marriage Support", desc: "Helping poor families, especially girls from struggling households" },
                { icon: Users, title: "Livelihood", desc: "Encouraging small livelihood opportunities" },
              ].map(({ icon: Icon, title, desc }) => (
                <div key={title} className="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
                  <Icon className="h-6 w-6 text-rose-500 mb-3" />
                  <h3 className="font-bold text-slate-900 mb-1">{title}</h3>
                  <p className="text-sm text-slate-600">{desc}</p>
                </div>
              ))}
            </div>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-rose-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Why Sadaqah Matters</h2>
            <div className="prose prose-lg max-w-none text-slate-600">
              <p>
                Sadaqah not only helps poor and needy people — it also strengthens humanity, compassion, and unity within society.
              </p>
              <p>Even a small act of charity can:</p>
              <ul>
                <li>Reduce someone&rsquo;s suffering</li>
                <li>Provide hope</li>
                <li>Restore dignity</li>
                <li>Bring comfort during difficult times</li>
              </ul>
              <p>
                The foundation believes every contribution, whether large or small, has the power to make a meaningful difference in someone&rsquo;s life.
              </p>
            </div>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-slate-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Transparency &amp; Responsibility</h2>
            <p className="text-slate-600">
              Daan Foundation believes every donation is an amanah — a trust. The organization remains committed to honesty, responsible use of donations, transparency, and humanitarian service with dignity.
            </p>
          </section>

          <div className="border-t border-slate-200" />

          <section>
            <div className="flex items-start gap-4 p-5 bg-blue-50 rounded-xl border border-blue-200">
              <MapPin className="h-6 w-6 text-blue-600 flex-shrink-0 mt-1" />
              <div>
                <h3 className="font-bold text-slate-900 text-lg">Working Only Within India</h3>
                <p className="text-slate-600 mt-1">
                  Daan Foundation operates only within India and focuses entirely on helping communities within Indian geography. The organization does not operate internationally, does not conduct activities outside India, and is not authorized to receive donations from outside India.
                </p>
              </div>
            </div>
          </section>

          <div className="border-t border-slate-200" />

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-8 text-center">
              Frequently Asked Questions
            </h2>
            <Accordion type="single" collapsible className="space-y-4">
              {sadaqahFAQs.map((faq, index) => (
                <AccordionItem
                  key={index}
                  value={`item-${index}`}
                  className="bg-white rounded-xl px-6 shadow-sm border border-slate-100"
                >
                  <AccordionTrigger className="text-left font-semibold text-slate-900 hover:no-underline">
                    {faq.question}
                  </AccordionTrigger>
                  <AccordionContent className="text-slate-600">
                    {faq.answer}
                  </AccordionContent>
                </AccordionItem>
              ))}
            </Accordion>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-gradient-to-r from-rose-500 to-pink-600 rounded-2xl p-8 md:p-10 text-center">
            <h2 className="text-3xl font-bold text-white mb-4">
              Every Act of Kindness Counts
            </h2>
            <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">
              The Prophet ﷺ said: &ldquo;Every act of goodness is Sadaqah.&rdquo;
            </p>
            <Link
              to="/donate"
              className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-rose-600 hover:shadow-lg transition-shadow"
            >
              Give Sadaqah Today
              <ArrowRight className="h-5 w-5" />
            </Link>
          </section>

        </div>
      </ProjectPageLayout>
    </div>
  );
}

export default Sadaqah;
