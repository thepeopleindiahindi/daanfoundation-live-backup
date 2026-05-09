import { Link } from "react-router-dom";
import { ArrowRight, Gift } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";

export function EidGifts() {
  return (
    <div>
      <Breadcrumbs items={[{ label: "Programs" }, { label: "Eid Gifts" }]} />

      {/* Hero */}
      <section className="relative py-20 md:py-28 bg-gradient-to-br from-amber-500 to-orange-600">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div>
              <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-6">
                Spread Joy This Eid
              </h1>
              <p className="text-xl text-white/90 leading-relaxed mb-8">
                For many children across India — especially orphans, children from poor families, and those living in difficult conditions — Eid can pass like any other day, without new clothes, sweets, or gifts. Daan Foundation is committed to changing that.
              </p>
              <Link
                to="/donate"
                className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-amber-600 hover:shadow-lg transition-shadow"
              >
                Support Eid Gifts
                <ArrowRight className="h-5 w-5" />
              </Link>
            </div>
            <div className="hidden lg:block">
              <img
                src="/images/community-queue.jpg"
                alt="Eid gifts distribution"
                className="rounded-2xl shadow-2xl"
              />
            </div>
          </div>
        </div>
      </section>

      {/* What we provide */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto text-center mb-12">
            <h2 className="text-3xl font-bold text-slate-900 mb-4">No Child Should Feel Left Out on Eid</h2>
            <p className="text-lg text-slate-600">We focus on reaching orphan children, children of widows, children from low-income families, and vulnerable households.</p>
          </div>
          <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-4xl mx-auto">
            {[
              { item: "New Clothes", desc: "New outfits for children to celebrate Eid" },
              { item: "School Bags", desc: "Educational items and school supplies" },
              { item: "Toys & Gifts", desc: "Small gifts to bring joy and smiles" },
              { item: "Festive Treats", desc: "Sweets and treats for the celebration" },
            ].map((g) => (
              <div key={g.item} className="bg-amber-50 rounded-2xl p-6 text-center">
                <Gift className="h-8 w-8 text-amber-600 mx-auto mb-3" />
                <h3 className="font-bold text-slate-900 mb-2">{g.item}</h3>
                <p className="text-sm text-slate-600">{g.desc}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Stories */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl font-bold text-slate-900 mb-10 text-center">Stories That Inspire</h2>
          <div className="grid md:grid-cols-3 gap-6 max-w-4xl mx-auto">
            {[
              { title: "My Children Smiled This Eid", story: "Shabana, a widowed mother, shared that she could not afford new clothes for her children. Through Daan Foundation's support, her children received Eid gifts. She said, 'This Eid felt different. My children were happy like others.'" },
              { title: "First Time Receiving Eidi", story: "A young child from a low-income family received a small Eid gift pack. It was his first time receiving Eidi. His excitement reminded us why this effort matters." },
              { title: "Small Gifts, Big Happiness", story: "During one Eid distribution, volunteers saw children hugging their gift packs with joy. These moments reflect the real impact of simple acts of kindness." },
            ].map((s) => (
              <div key={s.title} className="bg-white rounded-2xl p-6 shadow-sm">
                <h3 className="font-bold text-slate-900 mb-3">{s.title}</h3>
                <p className="text-slate-600 text-sm">{s.story}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 md:py-20 bg-amber-500">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-white mb-4">Be a Reason for Someone's Smile</h2>
          <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">
            Your support can make Eid special for a child who is waiting for happiness. Sometimes, a small gift can create the biggest smile.
          </p>
          <Link
            to="/donate"
            className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-amber-600 hover:shadow-lg transition-shadow"
          >
            Donate for Eid Gifts
            <ArrowRight className="h-5 w-5" />
          </Link>
        </div>
      </section>
    </div>
  );
}

export default EidGifts;
