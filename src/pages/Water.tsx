import { Link } from "react-router-dom";
import { Droplets, Users, Heart, ArrowRight } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";

const waterProjects = [
  { title: "Hand Pump Well", price: 300, description: "Provides clean water for up to 200 people" },
  { title: "Solar Well", price: 3000, description: "Sustainable water source for a village" },
  { title: "Water Tanker Distribution", price: 100, description: "Emergency water supply" },
];

export function Water() {
  return (
    <div>
      <Breadcrumbs items={[{ label: "Water" }]} />

      {/* Hero */}
      <section className="relative py-20 md:py-28 bg-gradient-to-br from-blue-600 to-indigo-700">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div>
              <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-6">
                Water for Life
              </h1>
              <p className="text-xl text-white/90 leading-relaxed mb-8">
                "The best charity is giving water to drink." Provide clean, safe water to communities in need and earn ongoing rewards.
              </p>
              <Link
                to="/donate"
                className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-blue-600 hover:shadow-lg transition-shadow"
              >
                Build a Well
                <ArrowRight className="h-5 w-5" />
              </Link>
            </div>
            <div className="hidden lg:block">
              <img
                src="/images/impact-2.jpg"
                alt="Water distribution"
                className="rounded-2xl shadow-2xl"
              />
            </div>
          </div>
        </div>
      </section>

      {/* Water crisis stats */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold text-slate-900 mb-4">The Water Crisis</h2>
            <p className="text-lg text-slate-600 max-w-2xl mx-auto">
              Millions of people around the world lack access to clean, safe water
            </p>
          </div>

          <div className="grid sm:grid-cols-3 gap-8">
            <div className="text-center">
              <div className="text-5xl font-bold text-blue-600 mb-2">785M</div>
              <div className="text-slate-600">People lack basic water access</div>
            </div>
            <div className="text-center">
              <div className="text-5xl font-bold text-blue-600 mb-2">2B</div>
              <div className="text-slate-600">Use contaminated water sources</div>
            </div>
            <div className="text-center">
              <div className="text-5xl font-bold text-blue-600 mb-2">1,000</div>
              <div className="text-slate-600">Children die daily from unsafe water</div>
            </div>
          </div>
        </div>
      </section>

      {/* Water projects */}
      <section className="py-16 md:py-24 bg-slate-50">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl font-bold text-slate-900 mb-8 text-center">
            Water Projects
          </h2>

          <div className="grid md:grid-cols-3 gap-6">
            {waterProjects.map((project) => (
              <div key={project.title} className="bg-white rounded-2xl p-6 shadow-sm">
                <div className="h-14 w-14 rounded-xl bg-blue-100 flex items-center justify-center mb-4">
                  <Droplets className="h-7 w-7 text-blue-600" />
                </div>
                <h3 className="text-xl font-bold text-slate-900 mb-2">{project.title}</h3>
                <p className="text-slate-600 mb-4">{project.description}</p>
                <div className="flex items-center justify-between">
                  <span className="text-2xl font-bold text-blue-600">£{project.price}</span>
                  <Link
                    to="/donate"
                    className="text-sm font-semibold text-blue-600 hover:underline"
                  >
                    Donate →
                  </Link>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Sadaqah Jariyah */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-700 p-8 md:p-12 text-center">
            <h2 className="text-3xl font-bold text-white mb-4">Sadaqah Jariyah</h2>
            <p className="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
              A water well is a form of Sadaqah Jariyah — ongoing charity that continues to benefit others and earn you rewards long after you give.
            </p>
            <Link
              to="/donate"
              className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-blue-600"
            >
              Build a Well Today
            </Link>
          </div>
        </div>
      </section>
    </div>
  );
}

export default Water;
