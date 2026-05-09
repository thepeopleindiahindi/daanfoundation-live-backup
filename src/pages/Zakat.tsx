import { Link } from "react-router-dom";
import { ArrowRight, BookOpen, Calculator } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import { zakatFAQs } from "@/data/faqs";
import {
  Accordion,
  AccordionContent,
  AccordionItem,
  AccordionTrigger,
} from "@/components/ui/accordion";

export function Zakat() {
  return (
    <div>
      <Breadcrumbs items={[{ label: "Zakat" }]} />

      {/* Hero */}
      <section className="relative py-16 md:py-24 bg-gradient-to-br from-orange-600 to-orange-700 overflow-hidden">
        <div className="absolute inset-0 opacity-10" style={{
          backgroundImage: `url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M54.627 0l.83.828-1.415 1.415L51.8 0h2.827zM5.373 0l-.83.828L5.96 2.243 8.2 0H5.374zM48.97 0l3.657 3.657-1.414 1.414L46.143 0h2.828zM11.03 0L7.372 3.657 8.787 5.07 13.857 0H11.03zm32.284 0L49.8 6.485 48.384 7.9l-7.9-7.9h2.83zM16.686 0L10.2 6.485 11.616 7.9l7.9-7.9h-2.83zM22.344 0L13.858 8.485 15.272 9.9l9.9-9.9h-2.828zM32 0l-3.486 3.485 1.414 1.415L searching34.97 0H32z' fill='%23ffffff' fill-opacity='1' fill-rule='evenodd'/%3E%3C/svg%3E")`,
        }} />
        
        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div>
              <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-6">
                Give Your Zakat
              </h1>
              <p className="text-xl text-white/90 leading-relaxed mb-8">
                Zakat is one of the five pillars of Islam. Fulfill your obligation and transform lives with your 2.5%.
              </p>
              <div className="flex flex-wrap gap-4">
                <Link
                  to="/zakat-calculator"
                  className="inline-flex items-center gap-2 rounded-full bg-white px-6 py-3 font-bold text-orange-600 hover:shadow-lg transition-shadow"
                >
                  <Calculator className="h-5 w-5" />
                  Calculate Your Zakat
                </Link>
                <Link
                  to="/donate"
                  className="inline-flex items-center gap-2 rounded-full bg-amber-500 px-6 py-3 font-bold text-white hover:bg-amber-600 transition-colors"
                >
                  Pay Zakat Now
                </Link>
              </div>
            </div>
            <div className="hidden lg:block">
              <img
                src="/images/community-queue.jpg"
                alt="Zakat distribution"
                className="rounded-2xl shadow-2xl"
              />
            </div>
          </div>
        </div>
      </section>

      {/* What is Zakat */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div>
              <h2 className="text-3xl font-bold text-slate-900 mb-6">What is Zakat?</h2>
              <div className="prose prose-lg">
                <p>
                  Zakat is one of the five pillars of Islam and is obligatory for every sane, adult Muslim who owns wealth above a certain threshold (known as the Nisab).
                </p>
                <p>
                  The word "Zakat" means purification and growth. By giving 2.5% of your wealth to those in need, you purify your remaining wealth and help it grow in blessings.
                </p>
                <blockquote className="border-l-4 border-orange-500 pl-4 italic text-slate-600">
                  "And establish prayer and give Zakat, and whatever good you put forward for yourselves – you will find it with Allah."
                  <footer className="text-sm mt-2">— Quran 2:110</footer>
                </blockquote>
              </div>
            </div>
            <div className="bg-[#F3F4F6] rounded-2xl p-8">
              <h3 className="text-xl font-bold text-slate-900 mb-6">Nisab Threshold</h3>
              <div className="space-y-4">
                <div className="bg-white rounded-xl p-4 shadow-sm">
                  <div className="text-sm text-slate-500 mb-1">Silver Nisab (612.36g)</div>
                  <div className="text-2xl font-bold text-slate-900">~₹45,000</div>
                </div>
                <div className="bg-white rounded-xl p-4 shadow-sm">
                  <div className="text-sm text-slate-500 mb-1">Gold Nisab (87.48g)</div>
                  <div className="text-2xl font-bold text-slate-900">~₹6,50,000</div>
                </div>
                <p className="text-sm text-slate-500">
                  Values fluctuate daily. Use our calculator for accurate figures.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* How we use Zakat */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold text-slate-900 mb-4">How We Use Your Zakat</h2>
            <p className="text-lg text-slate-600 max-w-2xl mx-auto">
              Your Zakat is distributed to those most in need, following Shariah guidelines.
            </p>
          </div>

          <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {[
              { title: "The Poor (Faqir)", description: "Those with little wealth below the Nisab" },
              { title: "The Needy (Miskeen)", description: "Those with no wealth or means of income" },
              { title: "Refugees", description: "Displaced persons who have lost everything" },
              { title: "Those in Debt", description: "People struggling with unmanageable debt" },
            ].map((item) => (
              <div key={item.title} className="bg-white rounded-xl p-6 shadow-sm">
                <h3 className="font-bold text-slate-900 mb-2">{item.title}</h3>
                <p className="text-sm text-slate-600">{item.description}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* FAQ */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl font-bold text-slate-900 mb-8 text-center">
            Frequently Asked Questions
          </h2>
          <Accordion type="single" collapsible className="space-y-4">
            {zakatFAQs.map((faq, index) => (
              <AccordionItem
                key={index}
                value={`item-${index}`}
                className="bg-white rounded-xl px-6 shadow-sm border-0"
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
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 md:py-24 bg-gradient-to-br from-orange-600 to-orange-700">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-white mb-4">Ready to Pay Your Zakat?</h2>
          <p className="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
            Calculate your Zakat obligation and fulfill this sacred pillar of Islam.
          </p>
          <div className="flex flex-wrap justify-center gap-4">
            <Link
              to="/zakat-calculator"
              className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-orange-600"
            >
              <Calculator className="h-5 w-5" />
              Calculate Zakat
            </Link>
            <Link
              to="/donate"
              className="inline-flex items-center gap-2 rounded-full bg-amber-500 px-8 py-4 font-bold text-white"
            >
              Pay Zakat Now
              <ArrowRight className="h-5 w-5" />
            </Link>
          </div>
        </div>
      </section>
    </div>
  );
}

export default Zakat;
