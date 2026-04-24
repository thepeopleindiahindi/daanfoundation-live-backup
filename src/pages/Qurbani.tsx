import { useState } from "react";
import { Link } from "react-router-dom";
import { ArrowRight, Check } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import { qurbaniFAQs } from "@/data/faqs";
import {
  Accordion,
  AccordionContent,
  AccordionItem,
  AccordionTrigger,
} from "@/components/ui/accordion";

const qurbaniOptions = [
  { id: "small", name: "Small Animal", shares: 1, price: 39, description: "Goat or Sheep" },
  { id: "large-share", name: "Large Animal Share", shares: 1, price: 70, description: "1/7 of Cow" },
  { id: "cow", name: "Whole Cow", shares: 7, price: 490, description: "7 shares" },
];

export function Qurbani() {
  const [selectedOption, setSelectedOption] = useState("small");
  const [quantity, setQuantity] = useState(1);

  const selected = qurbaniOptions.find((o) => o.id === selectedOption);
  const total = selected ? selected.price * quantity : 0;

  return (
    <div>
      <Breadcrumbs items={[{ label: "Qurbani" }]} />

      {/* Hero */}
      <section className="relative min-h-[500px] overflow-hidden">
        <div className="absolute inset-0">
          <img
            src="/images/hero-1.jpg"
            alt="Qurbani distribution"
            className="h-full w-full object-cover"
          />
          <div className="absolute inset-0 bg-gradient-to-r from-amber-900/80 via-amber-800/60 to-amber-700/40" />
        </div>

        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 md:py-28">
          <div className="max-w-2xl">
            <span className="inline-block rounded-full bg-white/20 px-4 py-1.5 text-sm font-semibold text-white mb-4">
              Dhul Hijjah 1447
            </span>
            <h1 className="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
              Qurbani 2026
            </h1>
            <p className="text-xl text-white/90 leading-relaxed mb-8">
              Share your sacrifice with families who rarely eat meat. We deliver fresh Qurbani to those most in need across 30+ countries.
            </p>
          </div>
        </div>
      </section>

      {/* Qurbani selector */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12">
            {/* Options */}
            <div>
              <h2 className="text-3xl font-bold text-slate-900 mb-6">Choose Your Qurbani</h2>
              <p className="text-slate-600 mb-8">
                All our Qurbani is Shariah-compliant and distributed fresh to families in need.
              </p>

              <div className="space-y-4">
                {qurbaniOptions.map((option) => (
                  <button
                    key={option.id}
                    onClick={() => setSelectedOption(option.id)}
                    className={`w-full flex items-center justify-between p-5 rounded-xl border-2 transition-all text-left ${
                      selectedOption === option.id
                        ? "border-amber-500 bg-amber-50"
                        : "border-slate-200 hover:border-slate-300"
                    }`}
                  >
                    <div className="flex items-center gap-4">
                      <div className={`h-6 w-6 rounded-full border-2 flex items-center justify-center ${
                        selectedOption === option.id
                          ? "border-amber-500 bg-amber-500"
                          : "border-slate-300"
                      }`}>
                        {selectedOption === option.id && (
                          <Check className="h-4 w-4 text-white" />
                        )}
                      </div>
                      <div>
                        <div className="font-semibold text-slate-900">{option.name}</div>
                        <div className="text-sm text-slate-500">{option.description}</div>
                      </div>
                    </div>
                    <div className="text-xl font-bold text-slate-900">£{option.price}</div>
                  </button>
                ))}
              </div>

              {/* Quantity */}
              <div className="mt-6">
                <label className="block text-sm font-medium text-slate-700 mb-2">
                  Quantity (Number of Qurbanis)
                </label>
                <div className="flex items-center gap-3">
                  <button
                    onClick={() => setQuantity(Math.max(1, quantity - 1))}
                    className="h-12 w-12 rounded-xl bg-slate-100 text-slate-700 font-bold hover:bg-slate-200"
                  >
                    −
                  </button>
                  <input
                    type="number"
                    min="1"
                    value={quantity}
                    onChange={(e) => setQuantity(Math.max(1, parseInt(e.target.value) || 1))}
                    className="h-12 w-20 rounded-xl border-2 border-slate-200 text-center text-lg font-semibold"
                  />
                  <button
                    onClick={() => setQuantity(quantity + 1)}
                    className="h-12 w-12 rounded-xl bg-slate-100 text-slate-700 font-bold hover:bg-slate-200"
                  >
                    +
                  </button>
                </div>
              </div>
            </div>

            {/* Summary */}
            <div>
              <div className="sticky top-24 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 p-8 text-white">
                <h3 className="text-xl font-bold mb-6">Your Qurbani</h3>
                
                <div className="space-y-4 mb-6">
                  <div className="flex justify-between">
                    <span className="text-white/80">{selected?.name}</span>
                    <span className="font-semibold">£{selected?.price}</span>
                  </div>
                  <div className="flex justify-between">
                    <span className="text-white/80">Quantity</span>
                    <span className="font-semibold">×{quantity}</span>
                  </div>
                  <div className="border-t border-white/20 pt-4">
                    <div className="flex justify-between">
                      <span className="text-lg font-semibold">Total</span>
                      <span className="text-2xl font-bold">£{total}</span>
                    </div>
                  </div>
                </div>

                <button className="w-full rounded-xl bg-white py-4 text-lg font-bold text-amber-600 hover:bg-amber-50 transition-colors">
                  Give Qurbani — £{total}
                </button>

                <div className="mt-6 space-y-2 text-sm text-white/80">
                  <div className="flex items-center gap-2">
                    <Check className="h-4 w-4" />
                    100% Shariah Compliant
                  </div>
                  <div className="flex items-center gap-2">
                    <Check className="h-4 w-4" />
                    Distributed Fresh
                  </div>
                  <div className="flex items-center gap-2">
                    <Check className="h-4 w-4" />
                    30+ Countries
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* FAQ */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl font-bold text-slate-900 mb-8 text-center">
            Qurbani FAQs
          </h2>
          <Accordion type="single" collapsible className="space-y-4">
            {qurbaniFAQs.map((faq, index) => (
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
    </div>
  );
}

export default Qurbani;
