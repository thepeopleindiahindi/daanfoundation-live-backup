import { Link } from "react-router-dom";
import { ArrowRight, Sun, Users, Heart, Baby, MapPin } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";
import ProjectPageLayout from "@/components/donation/ProjectPageLayout";

export function WinterAppeal() {
  return (
    <div>
      <SEO title="Winter Appeal - Warmth for Every Needy" description="Support Daan Foundation's Winter Appeal. Provide warm clothes, blankets, and winter essentials to vulnerable people across India." canonical="/winter-appeal" />
      <Breadcrumbs items={[{ label: "Winter Appeal" }]} />

      <section className="relative bg-gradient-to-br from-blue-800 to-indigo-900">
        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 md:py-16">
          <div className="max-w-3xl">
            <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-4">Winter Appeal</h1>
            <p className="text-xl text-white/90 leading-relaxed max-w-2xl">Warmth for Every Needy &mdash; Protecting Lives During Harsh Winters in India</p>
          </div>
        </div>
      </section>

      <ProjectPageLayout defaultCause="where-needed">
        <div className="space-y-10">

          <div className="rounded-2xl overflow-hidden shadow-lg">
            <img src="/images/extra-4.jpg" alt="Winter appeal - providing warmth" className="w-full h-[300px] md:h-[400px] object-cover" />
          </div>

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Protecting Lives During Harsh Winters</h2>
            <p className="text-slate-600 leading-relaxed">
              Winter can be extremely difficult for people who do not have proper clothing or shelter. For many poor families, daily survival itself is a challenge — and during cold weather, the lack of warm clothes can become a serious risk to health and life.
            </p>
            <p className="text-slate-600 leading-relaxed mt-4">
              Daan Foundation is committed to supporting vulnerable individuals during winter by providing warmth, comfort, and dignity.
            </p>
          </section>

          <div className="border-t border-slate-200" />

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Our Winter Support Initiative</h2>
            <p className="text-slate-600 mb-6">Through our Winter Appeal, Daan Foundation works across communities in India to ensure that no one suffers due to lack of warm clothing. We focus on helping:</p>
            <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
              {[
                { icon: Users, label: "Poor and low-income families" },
                { icon: Users, label: "Daily wage workers" },
                { icon: Heart, label: "Elderly individuals" },
                { icon: Users, label: "Homeless people" },
                { icon: Baby, label: "Children living in difficult conditions" },
              ].map(({ icon: Icon, label }) => (
                <div key={label} className="flex items-center gap-3 bg-white rounded-xl p-4 shadow-sm border border-slate-100">
                  <Icon className="h-5 w-5 text-blue-500 flex-shrink-0" />
                  <span className="text-slate-700 font-medium">{label}</span>
                </div>
              ))}
            </div>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">What We Provide</h2>
            <p className="text-slate-600 mb-4">To protect people from cold weather, we distribute:</p>
            <div className="grid grid-cols-2 md:grid-cols-4 gap-3">
              {["Warm clothes (jackets, sweaters, shawls)", "Blankets", "Shoes and slippers", "Socks and basic winter essentials"].map((item) => (
                <div key={item} className="bg-white rounded-xl p-4 shadow-sm border border-slate-100 text-center font-semibold text-slate-700 text-sm">
                  {item}
                </div>
              ))}
            </div>
            <p className="text-sm text-slate-500 mt-4">These items are sourced through purchase of new materials, donations from supporters, and collection of reusable old clothes.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">New &amp; Old — Both Matter</h2>
            <p className="text-slate-600">We believe that both new and well-maintained used clothes can make a meaningful difference. New items are purchased and distributed where needed, while donated clothes are carefully sorted and shared respectfully. Only usable and appropriate items are given to beneficiaries. This approach allows us to reach more people and reduce waste while serving communities effectively.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-slate-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Why This Matters</h2>
            <p className="text-slate-600">Cold weather affects the poor the most. Without proper clothing, health risks increase, children fall sick, elderly people suffer the most, and daily life becomes more difficult. Providing winter support is not just charity — it is a basic humanitarian responsibility.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-blue-50 rounded-xl p-5 border border-blue-200">
            <div className="flex items-start gap-4">
              <MapPin className="h-6 w-6 text-blue-600 flex-shrink-0 mt-1" />
              <div>
                <h3 className="font-bold text-slate-900 text-lg">Our Commitment</h3>
                <p className="text-slate-600 mt-1">Daan Foundation is committed to reaching vulnerable people during winter, distributing warm clothing with dignity, using resources responsibly, and expanding support to more communities. All our work is carried out only within India.</p>
              </div>
            </div>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-gradient-to-r from-blue-800 to-indigo-900 rounded-2xl p-8 md:p-10 text-center">
            <h2 className="text-3xl font-bold text-white mb-4">A Simple Act of Warmth</h2>
            <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">A sweater, a blanket, or a pair of socks may seem small — but for someone facing cold nights, it can mean everything. Together, let&rsquo;s share warmth this winter.</p>
            <Link to="/donate" className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-blue-800 hover:shadow-lg transition-shadow">
              Support Winter Appeal <ArrowRight className="h-5 w-5" />
            </Link>
          </section>

        </div>
      </ProjectPageLayout>
    </div>
  );
}

export default WinterAppeal;
