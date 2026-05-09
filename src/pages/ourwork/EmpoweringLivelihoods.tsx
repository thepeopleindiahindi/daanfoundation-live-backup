import { Link } from "react-router-dom";
import { ArrowRight } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";

export function EmpoweringLivelihoods() {
  return (
    <div>
      <Breadcrumbs items={[{ label: "Our Work", href: "/our-work/impact" }, { label: "Empowering Lives Through Sustainable Livelihoods" }]} />

      <section className="relative py-20 md:py-28 bg-gradient-to-br from-green-600 to-emerald-700">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h1 className="text-4xl md:text-5xl font-extrabold text-white mb-6">Empowering Lives Through Sustainable Livelihoods</h1>
          <p className="text-xl text-white/90 max-w-2xl mx-auto">
            True charity goes beyond immediate relief — it helps people stand on their own feet.
          </p>
        </div>
      </section>

      {/* Approach */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Our Approach</h2>
            <p className="text-lg text-slate-600 leading-relaxed mb-8">
              We believe in empowering individuals to become self-reliant. Our approach is simple yet effective:
            </p>
            <div className="space-y-4">
              {[
                { step: "1", title: "Identify", desc: "Find willing individuals who want to improve their livelihoods." },
                { step: "2", title: "Understand", desc: "Learn their existing skills and identify opportunities." },
                { step: "3", title: "Support", desc: "Provide small, meaningful support tailored to their needs." },
                { step: "4", title: "Empower", desc: "Help them become self-reliant and independent." },
              ].map((item) => (
                <div key={item.step} className="flex gap-4 items-start">
                  <div className="h-10 w-10 rounded-full bg-green-600 text-white flex items-center justify-center text-sm font-bold shrink-0">{item.step}</div>
                  <div>
                    <h3 className="font-bold text-slate-900">{item.title}</h3>
                    <p className="text-slate-600">{item.desc}</p>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Types of Support */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl font-bold text-slate-900 mb-10 text-center">Types of Livelihood Support</h2>
          <div className="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto">
            {[
              { title: "Small Business Support", desc: "Helping individuals set up grocery stores, street vending, and other small businesses." },
              { title: "Food Cart Setup", desc: "Providing ice cream and food cart setups for street vendors to earn a steady income." },
              { title: "Sewing Machines for Women", desc: "Equipping women with sewing machines for home-based tailoring work." },
              { title: "Skill-Based Support", desc: "Identifying existing skills and providing targeted support to enhance them." },
            ].map((item) => (
              <div key={item.title} className="bg-white rounded-2xl p-6 shadow-sm">
                <h3 className="font-bold text-slate-900 mb-2">{item.title}</h3>
                <p className="text-slate-600 text-sm">{item.desc}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Stories */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl font-bold text-slate-900 mb-10 text-center">Stories of Empowerment</h2>
          <div className="grid md:grid-cols-3 gap-6 max-w-4xl mx-auto">
            {[
              { name: "Rafiq", story: "With support from Daan Foundation, Rafiq started a street cart business. Today, he earns a steady income and supports his family independently." },
              { name: "Shabana", story: "Shabana received a sewing machine and started stitching clothes from home. She now earns enough to support her children's education." },
              { name: "Imran", story: "Imran received help to improve his general store. With better stock and setup, his business grew and his family's livelihood improved significantly." },
            ].map((item) => (
              <div key={item.name} className="bg-green-50 rounded-2xl p-6">
                <h3 className="text-lg font-bold text-slate-900 mb-3">{item.name}</h3>
                <p className="text-slate-600 text-sm">{item.story}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-slate-900 mb-4">Help Someone Stand on Their Own Feet</h2>
          <p className="text-lg text-slate-600 mb-8 max-w-2xl mx-auto">
            Your donation can provide the tools and support someone needs to build a sustainable livelihood.
          </p>
          <Link
            to="/donate"
            className="inline-flex items-center gap-2 rounded-full bg-green-600 px-8 py-4 text-lg font-semibold text-white shadow-lg hover:bg-green-700 transition-colors"
          >
            Donate Now <ArrowRight className="h-5 w-5" />
          </Link>
        </div>
      </section>
    </div>
  );
}

export default EmpoweringLivelihoods;
