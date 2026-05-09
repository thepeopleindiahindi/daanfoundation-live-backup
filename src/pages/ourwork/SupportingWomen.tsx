import { Link } from "react-router-dom";
import { ArrowRight } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";

export function SupportingWomen() {
  return (
    <div>
      <Breadcrumbs items={[{ label: "Our Work", href: "/our-work/impact" }, { label: "Supporting Women With Dignity" }]} />

      <section className="relative py-20 md:py-28 bg-gradient-to-br from-pink-600 to-rose-700">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h1 className="text-4xl md:text-5xl font-extrabold text-white mb-6">Supporting Women With Dignity</h1>
          <p className="text-xl text-white/90 max-w-2xl mx-auto">
            Empowering women through food assistance, livelihood support, and dignified care for a better future.
          </p>
        </div>
      </section>

      {/* Core Support */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl font-bold text-slate-900 mb-6">How We Support Women</h2>
            <p className="text-lg text-slate-600 leading-relaxed mb-8">
              Daan Foundation is committed to supporting women through food assistance, ration kits, and livelihood opportunities. We provide sewing machines for home-based tailoring work, helping widows and struggling women maintain their dignity and independence.
            </p>
            <div className="grid sm:grid-cols-2 gap-6">
              {[
                { title: "Food Assistance", desc: "Regular meals and ration kits for women and their families." },
                { title: "Sewing Machines", desc: "Providing sewing machines for home-based tailoring work and income." },
                { title: "Clothing Support", desc: "Dignified clothing distribution for women and children." },
                { title: "Medical Help", desc: "Supporting medical needs and health expenses for vulnerable women." },
                { title: "Marriage Assistance", desc: "Helping poor families, especially girls from financially struggling households, with marriage expenses." },
                { title: "Independence", desc: "Helping widows maintain dignity and achieve financial independence." },
              ].map((item) => (
                <div key={item.title} className="bg-pink-50 rounded-xl p-5">
                  <h3 className="font-bold text-slate-900 mb-1">{item.title}</h3>
                  <p className="text-sm text-slate-600">{item.desc}</p>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Story */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Shabana's Story</h2>
            <div className="bg-white rounded-2xl p-8 shadow-sm">
              <p className="text-lg text-slate-600 leading-relaxed mb-4">
                Shabana, a widow struggling to provide for her children, received a sewing machine from Daan Foundation. With determination and skill, she started stitching clothes from home.
              </p>
              <p className="text-lg text-slate-600 leading-relaxed">
                Today, she earns enough to support her children's education and maintain her family's dignity. Her story is a testament to how a small act of support can transform an entire family's future.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-slate-900 mb-4">Empower a Woman Today</h2>
          <p className="text-lg text-slate-600 mb-8 max-w-2xl mx-auto">
            Your donation can provide a sewing machine, ration support, or medical help to a woman in need.
          </p>
          <Link
            to="/donate"
            className="inline-flex items-center gap-2 rounded-full bg-pink-600 px-8 py-4 text-lg font-semibold text-white shadow-lg hover:bg-pink-700 transition-colors"
          >
            Donate Now <ArrowRight className="h-5 w-5" />
          </Link>
        </div>
      </section>
    </div>
  );
}

export default SupportingWomen;
