import { Link } from "react-router-dom";
import { ArrowRight, Gift, Heart, Users, Baby, Smile, MapPin } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";
import ProjectPageLayout from "@/components/donation/ProjectPageLayout";

export function EidGifts() {
  return (
    <div>
      <SEO title="Eid Gifts - Support Children This Eid" description="Spread joy this Eid by supporting Daan Foundation's Eid Gift Initiative. Provide new clothes, gifts, and sweets to underprivileged children." canonical="/eid-gifts" />
      <Breadcrumbs items={[{ label: "Eid Gifts" }]} />

      <section className="relative bg-gradient-to-br from-amber-500 to-orange-600">
        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 md:py-16">
          <div className="max-w-3xl">
            <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-4">Spread Joy This Eid</h1>
            <p className="text-xl text-white/90 leading-relaxed max-w-2xl">Supporting Children with Love &amp; Dignity &mdash; Daan Foundation&rsquo;s Eid Gift Initiative</p>
          </div>
        </div>
      </section>

      <ProjectPageLayout defaultCause="where-needed">
        <div className="space-y-10">

          <div className="rounded-2xl overflow-hidden shadow-lg">
            <img src="/images/extra-5.jpg" alt="Eid gifts for children" className="w-full h-[300px] md:h-[400px] object-cover" />
          </div>

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Bringing Smiles This Eid</h2>
            <p className="text-slate-600 leading-relaxed">
              Eid is a time of happiness, gratitude, and sharing. One of the most beautiful traditions of Eid is giving gifts — known as Eidi. It brings smiles to children and strengthens bonds within families and communities.
            </p>
            <p className="text-slate-600 leading-relaxed mt-4">
              But for many children across India — especially orphans, children from poor families, and those living in difficult conditions — Eid can pass like any other day, without new clothes, sweets, or gifts.
            </p>
            <p className="text-slate-600 leading-relaxed mt-4">
              Daan Foundation is committed to changing that.
            </p>
          </section>

          <div className="border-t border-slate-200" />

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Our Eid Gifts Programme</h2>
            <p className="text-slate-600 mb-6">Every year, Daan Foundation runs an Eid support initiative within India to bring happiness to underprivileged children.</p>
            <div className="bg-amber-50 rounded-2xl p-6 md:p-8 text-center mb-6">
              <p className="text-2xl font-bold text-amber-700">Our aim is simple: No child should feel left out on Eid</p>
            </div>
            <p className="text-slate-600">We focus on reaching:</p>
            <div className="grid sm:grid-cols-2 gap-4 mt-4">
              {["Orphan children", "Children of widows", "Children from low-income families", "Vulnerable and needy households"].map((item) => (
                <div key={item} className="flex items-center gap-3 bg-white rounded-xl p-4 shadow-sm border border-slate-100">
                  <Baby className="h-5 w-5 text-amber-500 flex-shrink-0" />
                  <span className="text-slate-700 font-medium">{item}</span>
                </div>
              ))}
            </div>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-gradient-to-br from-amber-50 to-yellow-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">What We Provide</h2>
            <p className="text-slate-600 mb-4">Through this initiative, we try to provide children with meaningful and joyful Eid support:</p>
            <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
              {[
                { icon: Gift, label: "New clothes" },
                { icon: Gift, label: "School bags & educational items" },
                { icon: Smile, label: "Toys and small gifts" },
                { icon: Heart, label: "Sweets and festive treats" },
              ].map(({ icon: Icon, label }) => (
                <div key={label} className="bg-white rounded-xl p-4 shadow-sm border border-slate-100 text-center">
                  <Icon className="h-8 w-8 text-amber-500 mx-auto mb-2" />
                  <span className="text-sm font-semibold text-slate-700">{label}</span>
                </div>
              ))}
            </div>
            <p className="text-slate-600 mt-4 font-medium">These are not just items — they are moments of happiness that children remember.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Why Eid Gifts Matter</h2>
            <p className="text-slate-600">For many children, Eid is the most awaited day of the year. Seeing other children celebrate while they cannot often creates silent sadness.</p>
            <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
              {[
                { icon: Smile, label: "Bring a genuine smile" },
                { icon: Heart, label: "Boost confidence" },
                { icon: Users, label: "Help children feel included" },
                { icon: Heart, label: "Reduce emotional burden on parents" },
              ].map(({ icon: Icon, label }) => (
                <div key={label} className="bg-white rounded-xl p-5 shadow-sm border border-slate-100 text-center">
                  <Icon className="h-8 w-8 text-amber-500 mx-auto mb-2" />
                  <p className="text-sm text-slate-700 font-medium">{label}</p>
                </div>
              ))}
            </div>
            <p className="font-semibold text-amber-700 mt-4">Sometimes, a simple gift becomes a memory that stays for years.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-slate-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Our Responsibility Towards Children</h2>
            <p className="text-slate-600">Children are a trust (amanah) and caring for them is a shared responsibility. The teachings of Islam emphasize kindness, love, and care towards children, especially orphans and the vulnerable. Even a small act — like giving a gift — can build love, compassion, and unity in society.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-blue-50 rounded-xl p-5 border border-blue-200">
            <div className="flex items-start gap-4">
              <MapPin className="h-6 w-6 text-blue-600 flex-shrink-0 mt-1" />
              <div>
                <h3 className="font-bold text-slate-900 text-lg">Our Commitment</h3>
                <p className="text-slate-600 mt-1">Daan Foundation is committed to bringing joy to children during Eid, supporting vulnerable families within India, promoting dignity, inclusion, and compassion, and ensuring no child feels forgotten. We operate only within India.</p>
              </div>
            </div>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-gradient-to-r from-amber-500 to-orange-600 rounded-2xl p-8 md:p-10 text-center">
            <h2 className="text-3xl font-bold text-white mb-4">Be a Reason for Someone&rsquo;s Smile</h2>
            <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">Your support can make Eid special for a child who is waiting for happiness. When you contribute, you are not just giving a gift — you are giving joy, dignity, and hope. Because sometimes, a small gift can create the biggest smile.</p>
            <Link to="/donate" className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-amber-600 hover:shadow-lg transition-shadow">
              Support Eid Gifts <ArrowRight className="h-5 w-5" />
            </Link>
          </section>

        </div>
      </ProjectPageLayout>
    </div>
  );
}

export default EidGifts;
