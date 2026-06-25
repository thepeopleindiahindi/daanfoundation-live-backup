import { Link } from "react-router-dom";
import { Calculator, ArrowRight, BookOpen, Users, Heart, Utensils, GraduationCap, Stethoscope, Shirt, Gem, Coins, ShieldCheck, MapPin } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import { zakatFAQs } from "@/data/faqs";
import {
  Accordion,
  AccordionContent,
  AccordionItem,
  AccordionTrigger,
} from "@/components/ui/accordion";
import { Alert, AlertDescription } from "@/components/ui/alert";
import SEO from "@/components/SEO";
import ProjectPageLayout from "@/components/donation/ProjectPageLayout";
import { Button } from "@/components/ui/button";

export function Zakat() {
  return (
    <div>
      <SEO title="Pay Your Zakat - Daan Foundation" description="Pay your Zakat through Daan Foundation. We ensure your Zakat reaches eligible recipients across India through food distribution, ration kits, and community support programs." canonical="/zakat" keywords="pay zakat online India, zakat donation, zakat eligible, Islamic charity India, zakat calculation" />
      <Breadcrumbs items={[{ label: "Zakat" }]} />

      {/* Hero Banner */}
      <section className="relative bg-gradient-to-br from-orange-600 to-orange-700 overflow-hidden">
        <div className="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNNTQuNjI3IDBsLjgzLjgyOC0xLjQxNSAxLjQxNUw1MS44IDBoMi44Mjd6TTUuMzczIDBsLS44My44MjhMNS45NiAyLjI0MyA4LjIgMEg1LjM3NHpNNDguOTcgMGwzLjY1NyAzLjY1Ny0xLjQxNCAxLjQxNEw0Ni4xNDMgMGgyLjgyOHpNMTEuMDMgMEw3LjM3MiAzLjY1NyA4Ljc4NyA1LjA3IDEzLjg1NyAwSDExLjAzem0zMi4yODQgMEw0OS44IDYuNDg1IDQ4LjM4NCA3LjkgNDAuNDg0IDBoMi44M3pNMTYuNjg2IDBMMTAuMiA2LjQ4NSAxMS42MTYgNy45bDcuOS03LjloLTIuODN6TTIyLjM0NCAwTDEzLjg1OCA4LjQ4NSAxNS4yNzIgOS45bDkuOS05LjloLTIuODI4ek0zMiAwbC0zLjQ4NiAzLjQ4NSAxLjQxNCAxLjQxNUwzNC45NyAwSDMyeiIgZmlsbD0iI2ZmZmZmZiIgZmlsbC1vcGFjaXR5PSIwLjA4IiBmaWxsLXJ1bGU9ImV2ZW5vZGQiLz48L3N2Zz4=')] opacity-70" />
        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 md:py-16">
          <div className="max-w-3xl">
            <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-4">
              Give Your Zakat
            </h1>
            <p className="text-xl text-white/90 leading-relaxed max-w-2xl">
              Fulfil your sacred obligation. Your Zakat purifies your wealth and transforms lives.
            </p>
          </div>
        </div>
      </section>

      <ProjectPageLayout defaultCause="zakat">
        {/* Main Content - Left Column */}
        <div className="space-y-10">

          {/* Hero Image */}
          <div className="rounded-2xl overflow-hidden shadow-lg">
            <img
              src="/images/community-queue.jpg"
              alt="Zakat distribution helping communities"
              className="w-full h-[300px] md:h-[400px] object-cover"
            />
          </div>

          {/* Quick Actions */}
          <div className="flex flex-wrap gap-3">
            <Link
              to="/zakat-calculator"
              className="inline-flex items-center gap-2 rounded-full bg-orange-600 text-white px-6 py-3 font-bold hover:bg-orange-700 transition-colors"
            >
              <Calculator className="h-5 w-5" />
              Calculate Your Zakat
            </Link>
            <Button asChild variant="outline" className="rounded-full border-orange-300 text-orange-700 hover:bg-orange-50">
              <Link to="#how-we-use">
                <BookOpen className="h-5 w-5" />
                How We Use Zakat
              </Link>
            </Button>
          </div>

          {/* What is Zakat */}
          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">What is Zakat?</h2>
            <div className="prose prose-lg max-w-none text-slate-600">
              <p>
                Zakat is one of the most important pillars of Islam and a powerful way to support people facing poverty, hunger, hardship, and financial struggles.
              </p>
              <p>
                Zakat is one of the 5 pillars of Islam and is obligatory for eligible Muslims who possess wealth above a certain amount, known as the <strong>Nisab</strong>.
              </p>
              <p className="text-lg font-semibold text-orange-700 bg-orange-50 rounded-xl p-4">
                Every eligible Muslim must give 2.5% of their eligible wealth as Zakat once every Islamic lunar year.
              </p>
              <p>
                Zakat is not simply charity — it is a responsibility and a right of the poor and needy upon those who have been blessed with wealth.
              </p>
            </div>
          </section>

          {/* Divider */}
          <div className="border-t border-slate-200" />

          {/* Zakat in the Light of Quran */}
          <section className="bg-emerald-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Zakat in the Light of the Qur&rsquo;an</h2>
            <blockquote className="border-l-4 border-emerald-600 pl-4 italic text-slate-700 text-lg">
              &ldquo;And those in whose wealth there is a recognised right for the needy and deprived.&rdquo;
              <footer className="text-sm mt-2 not-italic text-slate-500">&mdash; Qur&rsquo;an 70:24&ndash;25</footer>
            </blockquote>
            <p className="mt-4 text-slate-600">
              Zakat helps reduce hardship, supports vulnerable communities, and strengthens compassion and responsibility within society.
            </p>
          </section>

          {/* Divider */}
          <div className="border-t border-slate-200" />

          {/* How Daan Foundation Uses Zakat */}
          <section id="how-we-use">
            <h2 className="text-3xl font-bold text-slate-900 mb-6">How Daan Foundation Uses Zakat</h2>
            <div className="prose prose-lg max-w-none text-slate-600">
              <p>
                Daan Foundation works only within India and utilizes Zakat contributions carefully and responsibly for humanitarian and charitable activities focused on helping vulnerable communities.
              </p>
              <p>
                Since 2020, the foundation has used community support, Zakat, Sadaqah, and charity donations to help people through:
              </p>
            </div>

            <div className="grid sm:grid-cols-2 gap-4 mt-6">
              {[
                { icon: Utensils, label: "Community Kitchen services & daily food distribution" },
                { icon: Heart, label: "Ramadan Iftar arrangements" },
                { icon: Users, label: "Ration kit support" },
                { icon: Shirt, label: "Clothing assistance" },
                { icon: Stethoscope, label: "Medical support" },
                { icon: GraduationCap, label: "Educational assistance" },
              ].map(({ icon: Icon, label }) => (
                <div key={label} className="flex items-start gap-3 bg-white rounded-xl p-4 shadow-sm border border-slate-100">
                  <div className="h-10 w-10 rounded-lg bg-orange-100 flex items-center justify-center flex-shrink-0">
                    <Icon className="h-5 w-5 text-orange-600" />
                  </div>
                  <span className="text-slate-700 font-medium">{label}</span>
                </div>
              ))}
            </div>

            <div className="mt-6 bg-amber-50 rounded-xl p-5 border border-amber-200">
              <p className="text-slate-800 font-semibold text-lg">Our primary mission:</p>
              <p className="text-amber-800 text-xl font-bold mt-2">&ldquo;To help ensure that no needy person sleeps hungry.&rdquo;</p>
            </div>
          </section>

          {/* Divider */}
          <div className="border-t border-slate-200" />

          {/* Community Kitchen & Food Support */}
          <section className="bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Community Kitchen &amp; Food Support</h2>
            <div className="prose prose-lg max-w-none text-slate-600">
              <p>
                One of the foundation&rsquo;s most important humanitarian efforts is its Community Kitchen, which provides cooked evening meals daily to people in need without discrimination.
              </p>
              <p className="text-2xl font-bold text-orange-600 bg-white rounded-xl p-4 text-center">
                500,000+ Meals distributed since 2020
              </p>
              <p>Food assistance is provided to:</p>
            </div>
            <div className="grid grid-cols-2 md:grid-cols-4 gap-3 mt-4">
              {["Labourers", "Poor families", "Elderly individuals", "Patients", "Travellers", "Widows", "Financially struggling", "Homeless"].map((item) => (
                <div key={item} className="flex items-center gap-2 bg-white rounded-lg px-3 py-2 shadow-sm">
                  <Users className="h-4 w-4 text-orange-500 flex-shrink-0" />
                  <span className="text-sm text-slate-700">{item}</span>
                </div>
              ))}
            </div>
          </section>

          {/* Divider */}
          <div className="border-t border-slate-200" />

          {/* Nisab Section */}
          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">What is Nisab?</h2>
            <div className="prose prose-lg max-w-none text-slate-600">
              <p>
                The Nisab is the minimum amount of wealth a Muslim must possess before Zakat becomes obligatory. Traditionally, Nisab is calculated using the value of gold or silver.
              </p>
              <p>
                If a Muslim&rsquo;s savings and eligible wealth remain above the Nisab amount for one Islamic year, then Zakat becomes due.
              </p>
            </div>
            <div className="grid sm:grid-cols-2 gap-6 mt-6">
              <div className="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
                <div className="flex items-center gap-3 mb-3">
                  <Gem className="h-6 w-6 text-slate-400" />
                  <h3 className="font-bold text-slate-900">Silver Nisab</h3>
                </div>
                <div className="text-sm text-slate-500 mb-1">612.36g of silver</div>
                <div className="text-3xl font-bold text-slate-900">~₹45,000</div>
              </div>
              <div className="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
                <div className="flex items-center gap-3 mb-3">
                  <Coins className="h-6 w-6 text-amber-600" />
                  <h3 className="font-bold text-slate-900">Gold Nisab</h3>
                </div>
                <div className="text-sm text-slate-500 mb-1">87.48g of gold</div>
                <div className="text-3xl font-bold text-amber-600">~₹6,50,000</div>
              </div>
            </div>
            <p className="text-sm text-slate-500 mt-3">Values fluctuate daily. Use our calculator for accurate figures.</p>
          </section>

          {/* Divider */}
          <div className="border-t border-slate-200" />

          {/* What is Fitrana */}
          <section className="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">What is Fitrana (Zakat al-Fitr)?</h2>
            <div className="prose prose-lg max-w-none text-slate-600">
              <p>
                Fitrana, also called Zakat al-Fitr, is a charitable donation given before Eid prayer at the end of Ramadan. It is meant to help poor and needy people so they can also celebrate Eid with dignity and happiness.
              </p>
              <p>
                Through Ramadan food distribution and ration support activities, Daan Foundation tries to help vulnerable families during the holy month.
              </p>
              <Link to="/zakat-al-fitr" className="inline-flex items-center gap-2 text-blue-600 font-semibold hover:underline">
                Learn more about Fitrana <ArrowRight className="h-4 w-4" />
              </Link>
            </div>
          </section>

          {/* Divider */}
          <div className="border-t border-slate-200" />

          {/* Supporting Humanity Beyond Food */}
          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Supporting Humanity Beyond Food</h2>
            <div className="prose prose-lg max-w-none text-slate-600">
              <p>
                Although food support remains the foundation&rsquo;s central humanitarian mission, Daan Foundation also works within its capacity to support:
              </p>
            </div>
            <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
              {[
                { icon: GraduationCap, title: "Education", desc: "Supporting poor children&rsquo;s education" },
                { icon: Stethoscope, title: "Medical Aid", desc: "Medical assistance for needy patients" },
                { icon: Shirt, title: "Clothing", desc: "Clothing distribution for vulnerable families" },
                { icon: Heart, title: "Marriage Support", desc: "Marriage assistance for poor families, especially girls from struggling households" },
                { icon: Users, title: "Livelihood", desc: "Small livelihood support for self-reliance" },
              ].map(({ icon: Icon, title, desc }) => (
                <div key={title} className="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
                  <Icon className="h-6 w-6 text-orange-500 mb-3" />
                  <h3 className="font-bold text-slate-900 mb-1">{title}</h3>
                  <p className="text-sm text-slate-600">{desc}</p>
                </div>
              ))}
            </div>
          </section>

          {/* Divider */}
          <div className="border-t border-slate-200" />

          {/* Transparency */}
          <section className="bg-slate-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Transparency &amp; Responsibility</h2>
            <div className="prose prose-lg max-w-none text-slate-600">
              <p>
                Daan Foundation believes every donation is an <strong>amanah</strong> — a trust.
              </p>
              <p>The organization remains committed to:</p>
              <ul>
                <li>Using donations responsibly</li>
                <li>Maintaining honesty and transparency</li>
                <li>Ensuring humanitarian support reaches people respectfully</li>
              </ul>
              <p>
                Like every charitable organization involved in regular humanitarian work, certain operational costs are necessary to continue food preparation, transportation, volunteer coordination, and welfare activities effectively. The foundation believes responsible transparency builds stronger trust than unrealistic promises.
              </p>
            </div>
          </section>

          {/* Divider */}
          <div className="border-t border-slate-200" />

          {/* Working Only Within India */}
          <section>
            <div className="flex items-start gap-4 p-5 bg-blue-50 rounded-xl border border-blue-200">
              <MapPin className="h-6 w-6 text-blue-600 flex-shrink-0 mt-1" />
              <div>
                <h3 className="font-bold text-slate-900 text-lg">Working Only Within India</h3>
                <p className="text-slate-600 mt-1">
                  Daan Foundation operates only within India and focuses entirely on charitable and humanitarian activities for communities in need within the country. The organization does not operate internationally, does not conduct activities outside India, and is not authorized to receive donations from outside India.
                </p>
              </div>
            </div>
          </section>

          {/* Divider */}
          <div className="border-t border-slate-200" />

          {/* FAQ */}
          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-8 text-center">
              Frequently Asked Questions
            </h2>
            <Accordion type="single" collapsible className="space-y-4">
              {zakatFAQs.map((faq, index) => (
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

          {/* Divider */}
          <div className="border-t border-slate-200" />

          {/* CTA */}
          <section className="bg-gradient-to-br from-orange-600 to-orange-700 rounded-2xl p-8 md:p-10 text-center">
            <h2 className="text-3xl font-bold text-white mb-4">Ready to Pay Your Zakat?</h2>
            <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">
              Calculate your Zakat obligation and fulfill this sacred pillar of Islam. Your contribution can provide meals, support, and dignity to those in need.
            </p>
            <div className="flex flex-wrap justify-center gap-4">
              <Link
                to="/zakat-calculator"
                className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-orange-600 hover:shadow-lg transition-shadow"
              >
                <Calculator className="h-5 w-5" />
                Calculate Zakat
              </Link>
              <Link
                to="/donate"
                className="inline-flex items-center gap-2 rounded-full bg-amber-500 px-8 py-4 font-bold text-white hover:bg-amber-600 transition-colors"
              >
                Pay Zakat Now
                <ArrowRight className="h-5 w-5" />
              </Link>
            </div>
          </section>

        </div>
      </ProjectPageLayout>
    </div>
  );
}

export default Zakat;
