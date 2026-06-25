import { Link } from "react-router-dom";
import { ArrowRight, Utensils, Users, Heart, Stethoscope, GraduationCap, Shirt, MapPin } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";
import ProjectPageLayout from "@/components/donation/ProjectPageLayout";

export function WhereMostNeeded() {
  return (
    <div>
      <SEO title="Where Help Is Needed Most" description="Support Daan Foundation's work where help is needed most. Your donation goes to the most urgent humanitarian needs across India." canonical="/where-most-needed" />
      <Breadcrumbs items={[{ label: "Where Help Is Needed Most" }]} />

      <section className="relative bg-gradient-to-br from-slate-700 to-slate-900">
        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 md:py-16">
          <div className="max-w-3xl">
            <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-4">Where Help Is Needed Most</h1>
            <p className="text-xl text-white/90 leading-relaxed max-w-2xl">Your donation reaches the most urgent humanitarian needs across India.</p>
          </div>
        </div>
      </section>

      <ProjectPageLayout defaultCause="where-needed">
        <div className="space-y-10">

          <div className="rounded-2xl overflow-hidden shadow-lg">
            <img src="/images/extra-3.jpg" alt="Where help is needed most" className="w-full h-[300px] md:h-[400px] object-cover" />
          </div>

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Responding Where Help Is Needed Most</h2>
            <p className="text-slate-600 leading-relaxed">
              Daan Foundation works with one core humanitarian mission: to help people facing hunger, hardship, and difficult situations with dignity and compassion.
            </p>
            <p className="text-slate-600 leading-relaxed mt-4">
              Since 2020, the foundation has continued serving vulnerable communities across India through food support, Community Kitchen services, Ramadan Iftar arrangements, ration kit distribution, clothing assistance, medical support, educational help, and welfare initiatives for struggling families.
            </p>
            <p className="text-slate-600 leading-relaxed mt-4">
              The organization works only within India and focuses entirely on helping communities in need within Indian geography.
            </p>
          </section>

          <div className="border-t border-slate-200" />

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Daan Foundation believes humanitarian support should reach people wherever hardship exists.</h2>
            <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
              {[
                { icon: Utensils, label: "Hunger" },
                { icon: Heart, label: "Financial Crisis" },
                { icon: Stethoscope, label: "Medical Emergencies" },
                { icon: Utensils, label: "Lack of Food" },
                { icon: Users, label: "Difficulties faced by poor families" },
              ].map(({ icon: Icon, label }) => (
                <div key={label} className="flex items-center gap-3 bg-white rounded-xl p-4 shadow-sm border border-slate-100">
                  <Icon className="h-5 w-5 text-orange-500 flex-shrink-0" />
                  <span className="text-slate-700 font-medium">{label}</span>
                </div>
              ))}
            </div>
            <p className="text-slate-600 mt-6">The foundation&rsquo;s humanitarian work focuses especially on vulnerable individuals such as labourers, widows, elderly people, patients, orphaned or needy children, financially struggling families, and people affected by poverty.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Community Kitchen — A Lifeline for Many</h2>
            <p className="text-slate-600">One of the foundation&rsquo;s most important humanitarian initiatives is its Community Kitchen. What started during Ramadan 2020 as a small 15-day food initiative gradually became a continuous humanitarian mission serving people every evening.</p>
            <p className="text-2xl font-bold text-orange-600 bg-white rounded-xl p-4 text-center mt-4">500,000+ Meals distributed since 2020</p>
            <p className="text-slate-600 mt-4">For many people, this meal becomes a daily source of relief and support during difficult times.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Supporting Communities Beyond Food</h2>
            <p className="text-slate-600 mb-6">While food support remains the foundation&rsquo;s central mission, Daan Foundation also works in other humanitarian areas whenever possible.</p>
            <div className="grid sm:grid-cols-2 gap-4">
              {[
                { icon: Users, label: "Ration kit distribution" },
                { icon: Shirt, label: "Clothing assistance" },
                { icon: Stethoscope, label: "Helping poor patients access treatment" },
                { icon: GraduationCap, label: "Educational support for needy children" },
                { icon: Heart, label: "Marriage assistance for poor families" },
                { icon: Users, label: "Small livelihood support for self-reliance" },
              ].map(({ icon: Icon, label }) => (
                <div key={label} className="flex items-start gap-3 bg-white rounded-xl p-4 shadow-sm border border-slate-100">
                  <div className="h-10 w-10 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0">
                    <Icon className="h-5 w-5 text-slate-700" />
                  </div>
                  <span className="text-slate-700 font-medium">{label}</span>
                </div>
              ))}
            </div>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-slate-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">A Mission Built on Compassion</h2>
            <p className="text-slate-600">The foundation believes helping humanity is not limited to one season or one occasion. Acts of compassion can include feeding hungry people, supporting poor families, helping patients, assisting children, or simply standing beside someone during difficult times. Every contribution and every effort aims to reduce suffering and bring relief to vulnerable people.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-blue-50 rounded-xl p-5 border border-blue-200">
            <div className="flex items-start gap-4">
              <MapPin className="h-6 w-6 text-blue-600 flex-shrink-0 mt-1" />
              <div>
                <h3 className="font-bold text-slate-900 text-lg">Working Only Within India</h3>
                <p className="text-slate-600 mt-1">Daan Foundation operates only within India and focuses entirely on charitable and humanitarian activities within Indian geography.</p>
              </div>
            </div>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-gradient-to-r from-slate-700 to-slate-900 rounded-2xl p-8 md:p-10 text-center">
            <h2 className="text-3xl font-bold text-white mb-4">Together We Can Help More People</h2>
            <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">Every meal served, every ration kit distributed, and every family supported becomes possible because of community support, volunteers, donors, and people who believe in helping humanity sincerely.</p>
            <Link to="/donate" className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-slate-800 hover:shadow-lg transition-shadow">
              Donate Where Most Needed <ArrowRight className="h-5 w-5" />
            </Link>
          </section>

        </div>
      </ProjectPageLayout>
    </div>
  );
}

export default WhereMostNeeded;
