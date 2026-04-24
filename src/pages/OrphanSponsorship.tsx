import { Link } from "react-router-dom";
import { Users, Heart, GraduationCap, Utensils, ArrowRight } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";

export function OrphanSponsorship() {
  return (
    <div>
      <Breadcrumbs items={[{ label: "Orphan Sponsorship" }]} />

      {/* Hero */}
      <section className="relative min-h-[450px] overflow-hidden">
        <div className="absolute inset-0">
          <img
            src="/images/community-queue.jpg"
            alt="Children receiving aid"
            className="h-full w-full object-cover"
          />
          <div className="absolute inset-0 bg-gradient-to-r from-slate-900/80 via-slate-900/60 to-slate-900/40" />
        </div>

        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 md:py-28">
          <div className="max-w-2xl">
            <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-6">
              Sponsor an Orphan
            </h1>
            <p className="text-xl text-white/90 leading-relaxed mb-8">
              Change a child's life with your monthly support. Provide education, healthcare, and hope for a brighter future.
            </p>
            <Link
              to="/donate"
              className="inline-flex items-center gap-2 rounded-full bg-amber-500 px-8 py-4 font-bold text-white hover:bg-amber-600 transition-colors"
            >
              Start Sponsoring — £35/month
              <ArrowRight className="h-5 w-5" />
            </Link>
          </div>
        </div>
      </section>

      {/* What sponsorship provides */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold text-slate-900 mb-4">
              What Your Sponsorship Provides
            </h2>
            <p className="text-lg text-slate-600 max-w-2xl mx-auto">
              For just £35 a month, you can transform an orphan's life
            </p>
          </div>

          <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {[
              { icon: GraduationCap, title: "Education", description: "School fees, books, and uniforms" },
              { icon: Heart, title: "Healthcare", description: "Medical care and regular check-ups" },
              { icon: Utensils, title: "Nutrition", description: "Nutritious food and clean water" },
              { icon: Users, title: "Support", description: "Emotional care and guidance" },
            ].map(({ icon: Icon, title, description }) => (
              <div key={title} className="bg-slate-50 rounded-2xl p-6 text-center">
                <div className="h-14 w-14 rounded-xl bg-orange-100 flex items-center justify-center mx-auto mb-4">
                  <Icon className="h-7 w-7 text-orange-600" />
                </div>
                <h3 className="font-bold text-slate-900 mb-2">{title}</h3>
                <p className="text-sm text-slate-600">{description}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Impact */}
      <section className="py-16 md:py-24 bg-orange-600">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-white mb-12">Our Impact</h2>
          <div className="grid sm:grid-cols-3 gap-8">
            <div>
              <div className="text-5xl font-bold text-white mb-2">5,000+</div>
              <div className="text-orange-100">Orphans Currently Sponsored</div>
            </div>
            <div>
              <div className="text-5xl font-bold text-white mb-2">15</div>
              <div className="text-orange-100">Countries Reached</div>
            </div>
            <div>
              <div className="text-5xl font-bold text-white mb-2">98%</div>
              <div className="text-orange-100">School Attendance Rate</div>
            </div>
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="rounded-2xl bg-gradient-to-r from-amber-500 to-orange-600 p-8 md:p-12 text-center">
            <h2 className="text-3xl font-bold text-white mb-4">
              Be the Change in a Child's Life
            </h2>
            <p className="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
              The Prophet ﷺ said: "I and the one who sponsors an orphan will be like this in Paradise" — and he gestured with his two fingers.
            </p>
            <Link
              to="/donate"
              className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-amber-600"
            >
              Sponsor an Orphan — £35/month
            </Link>
          </div>
        </div>
      </section>
    </div>
  );
}

export default OrphanSponsorship;
