import { Link } from "react-router-dom";
import { ArrowRight, Heart, Gift, Repeat } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import { sadaqahFAQs } from "@/data/faqs";
import {
  Accordion,
  AccordionContent,
  AccordionItem,
  AccordionTrigger,
} from "@/components/ui/accordion";
import SEO from "@/components/SEO";

export function Sadaqah() {
  return (
    <div>
      <SEO title="Give Sadaqah - Voluntary Charity" description="Give Sadaqah through Daan Foundation. Your voluntary charity helps feed the hungry, support widows, and uplift vulnerable communities across India." canonical="/sadaqah" keywords="sadaqah donation, voluntary charity Islam, give sadaqah online, Islamic giving India" />
      <Breadcrumbs items={[{ label: "Sadaqah" }]} />

      {/* Hero */}
      <section className="relative py-16 md:py-24 bg-gradient-to-br from-rose-500 to-pink-600">
        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div>
              <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-6">
                Give Sadaqah
              </h1>
              <p className="text-xl text-white/90 leading-relaxed mb-8">
                Sadaqah is a voluntary act of charity that brings immense blessings. There is no minimum amount — every contribution makes a difference.
              </p>
              <Link
                to="/donate"
                className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-rose-600 hover:shadow-lg transition-shadow"
              >
                Give Sadaqah Now
                <ArrowRight className="h-5 w-5" />
              </Link>
            </div>
            <div className="hidden lg:block">
              <img
                src="/images/aid-distribution-elderly.jpg"
                alt="Sadaqah helping those in need"
                className="rounded-2xl shadow-2xl"
              />
            </div>
          </div>
        </div>
      </section>

      {/* Types of Sadaqah */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold text-slate-900 mb-4">Types of Sadaqah</h2>
            <p className="text-lg text-slate-600 max-w-2xl mx-auto">
              Choose the type of charity that resonates with you
            </p>
          </div>

          <div className="grid md:grid-cols-3 gap-8">
            <div className="bg-white rounded-2xl p-8 shadow-sm ring-1 ring-slate-200">
              <div className="h-14 w-14 rounded-xl bg-rose-100 flex items-center justify-center mb-6">
                <Heart className="h-7 w-7 text-rose-600" />
              </div>
              <h3 className="text-xl font-bold text-slate-900 mb-3">Sadaqah</h3>
              <p className="text-slate-600 mb-4">
                A one-time voluntary donation that provides immediate relief to those in need.
              </p>
              <Link
                to="/donate"
                className="text-rose-600 font-semibold hover:underline"
              >
                Give Sadaqah →
              </Link>
            </div>

            <div className="bg-white rounded-2xl p-8 shadow-sm ring-1 ring-slate-200">
              <div className="h-14 w-14 rounded-xl bg-cyan-100 flex items-center justify-center mb-6">
                <Gift className="h-7 w-7 text-cyan-600" />
              </div>
              <h3 className="text-xl font-bold text-slate-900 mb-3">Sadaqah Jariyah</h3>
              <p className="text-slate-600 mb-4">
                Ongoing charity that continues to benefit others long after the initial gift.
              </p>
              <Link
                to="/sadaqah-jariyah"
                className="text-cyan-600 font-semibold hover:underline"
              >
                Learn More →
              </Link>
            </div>

            <div className="bg-white rounded-2xl p-8 shadow-sm ring-1 ring-slate-200">
              <div className="h-14 w-14 rounded-xl bg-violet-100 flex items-center justify-center mb-6">
                <Repeat className="h-7 w-7 text-violet-600" />
              </div>
              <h3 className="text-xl font-bold text-slate-900 mb-3">Monthly Giving</h3>
              <p className="text-slate-600 mb-4">
                Set up a regular donation to provide consistent support for those in need.
              </p>
              <Link
                to="/donate"
                className="text-violet-600 font-semibold hover:underline"
              >
                Start Monthly →
              </Link>
            </div>
          </div>
        </div>
      </section>

      {/* FAQ */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl font-bold text-slate-900 mb-8 text-center">
            Frequently Asked Questions
          </h2>
          <Accordion type="single" collapsible className="space-y-4">
            {sadaqahFAQs.map((faq, index) => (
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
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="rounded-2xl bg-gradient-to-r from-rose-500 to-pink-600 p-8 md:p-12 text-center">
            <h2 className="text-3xl font-bold text-white mb-4">
              Every Act of Kindness Counts
            </h2>
            <p className="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
              The Prophet ﷺ said: "Every act of goodness is Sadaqah."
            </p>
            <Link
              to="/donate"
              className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-rose-600"
            >
              Give Sadaqah Today
              <ArrowRight className="h-5 w-5" />
            </Link>
          </div>
        </div>
      </section>
    </div>
  );
}

export default Sadaqah;
