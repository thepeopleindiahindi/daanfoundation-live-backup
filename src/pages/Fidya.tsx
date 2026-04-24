import { Link } from "react-router-dom";
import { Calculator, HelpCircle, ArrowRight } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from "@/components/ui/accordion";
import { fidyaFAQs } from "@/data/faqs";

const fidyaAmount = 5; // per day

export function Fidya() {
  const ramadanDays = 30;
  const fullFidya = fidyaAmount * ramadanDays;

  return (
    <div>
      <Breadcrumbs items={[{ label: "Islamic Giving", href: "/zakat" }, { label: "Fidya & Kaffarah" }]} />

      {/* Hero */}
      <section className="relative py-20 md:py-28 bg-gradient-to-br from-purple-600 to-indigo-700">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div>
              <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-6">
                Fidya & Kaffarah
              </h1>
              <p className="text-xl text-white/90 leading-relaxed mb-8">
                For those unable to fast during Ramadan, Fidya allows you to feed a person in need for each day missed. Kaffarah is the compensation for deliberately breaking a fast.
              </p>
              <Link
                to="/donate"
                className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-purple-600 hover:shadow-lg transition-shadow"
              >
                Pay Fidya Now
                <ArrowRight className="h-5 w-5" />
              </Link>
            </div>
            <div className="hidden lg:block">
              <img
                src="/images/food-distribution.jpg"
                alt="Food distribution"
                className="rounded-2xl shadow-2xl"
              />
            </div>
          </div>
        </div>
      </section>

      {/* Fidya vs Kaffarah */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid md:grid-cols-2 gap-8">
            {/* Fidya */}
            <div className="bg-purple-50 rounded-2xl p-8">
              <h2 className="text-2xl font-bold text-slate-900 mb-4">What is Fidya?</h2>
              <p className="text-slate-600 mb-6">
                Fidya is a religious donation paid by those who cannot fast during Ramadan due to:
              </p>
              <ul className="space-y-2 mb-6">
                {[
                  "Chronic illness or medical condition",
                  "Pregnancy or breastfeeding",
                  "Elderly age affecting ability to fast",
                  "Long-term medication requirements",
                ].map((item) => (
                  <li key={item} className="flex items-start gap-2">
                    <span className="text-purple-600 mt-1">•</span>
                    <span className="text-slate-600">{item}</span>
                  </li>
                ))}
              </ul>
              <div className="bg-white rounded-xl p-4">
                <div className="flex items-center justify-between">
                  <span className="text-slate-600">Fidya per day</span>
                  <span className="text-2xl font-bold text-purple-600">£{fidyaAmount}</span>
                </div>
              </div>
            </div>

            {/* Kaffarah */}
            <div className="bg-red-50 rounded-2xl p-8">
              <h2 className="text-2xl font-bold text-slate-900 mb-4">What is Kaffarah?</h2>
              <p className="text-slate-600 mb-6">
                Kaffarah is the compensation for deliberately breaking a fast without a valid reason. It requires:
              </p>
              <ul className="space-y-2 mb-6">
                {[
                  "Freeing a slave (if not possible, then:)",
                  "Fasting for 60 consecutive days",
                  "Or feeding 60 poor people",
                ].map((item) => (
                  <li key={item} className="flex items-start gap-2">
                    <span className="text-red-600 mt-1">•</span>
                    <span className="text-slate-600">{item}</span>
                  </li>
                ))}
              </ul>
              <div className="bg-white rounded-xl p-4">
                <div className="flex items-center justify-between">
                  <span className="text-slate-600">Kaffarah (60 meals)</span>
                  <span className="text-2xl font-bold text-red-600">£{fidyaAmount * 60}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Calculator */}
      <section className="py-16 md:py-24 bg-slate-50">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-lg mx-auto text-center">
            <div className="h-14 w-14 rounded-xl bg-purple-100 flex items-center justify-center mx-auto mb-4">
              <Calculator className="h-7 w-7 text-purple-600" />
            </div>
            <h2 className="text-3xl font-bold text-slate-900 mb-4">Fidya Calculator</h2>
            <p className="text-slate-600 mb-8">
              Calculate how much Fidya you need to pay based on missed fasting days.
            </p>

            <div className="bg-white rounded-2xl p-6 shadow-sm">
              <div className="grid grid-cols-2 gap-4 mb-6">
                {[
                  { label: "1 day", value: fidyaAmount },
                  { label: "1 week", value: fidyaAmount * 7 },
                  { label: "2 weeks", value: fidyaAmount * 14 },
                  { label: "Full Ramadan", value: fullFidya },
                ].map(({ label, value }) => (
                  <Link
                    key={label}
                    to="/donate"
                    className="p-4 rounded-xl border-2 border-slate-200 hover:border-purple-600 transition-colors"
                  >
                    <div className="text-sm text-slate-600">{label}</div>
                    <div className="text-xl font-bold text-purple-600">£{value}</div>
                  </Link>
                ))}
              </div>

              <Link
                to="/donate"
                className="inline-flex items-center gap-2 rounded-full bg-purple-600 px-6 py-3 font-bold text-white hover:bg-purple-700 w-full justify-center"
              >
                Pay Fidya
                <ArrowRight className="h-5 w-5" />
              </Link>
            </div>
          </div>
        </div>
      </section>

      {/* FAQs */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-8">
            <HelpCircle className="h-10 w-10 text-purple-600 mx-auto mb-4" />
            <h2 className="text-3xl font-bold text-slate-900">Frequently Asked Questions</h2>
          </div>

          <Accordion type="single" collapsible className="space-y-3">
            {fidyaFAQs.map((faq, index) => (
              <AccordionItem key={index} value={`item-${index}`} className="bg-slate-50 rounded-xl px-6">
                <AccordionTrigger className="text-left font-semibold hover:no-underline">
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
      <section className="py-16 md:py-24 bg-gradient-to-r from-purple-600 to-indigo-700">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-white mb-4">
            Fulfill Your Obligation
          </h2>
          <p className="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
            Pay your Fidya or Kaffarah today and provide meals to those in need.
          </p>
          <Link
            to="/donate"
            className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-purple-600"
          >
            Pay Now
            <ArrowRight className="h-5 w-5" />
          </Link>
        </div>
      </section>
    </div>
  );
}

export default Fidya;
