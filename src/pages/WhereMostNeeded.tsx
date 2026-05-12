import { Link } from "react-router-dom";
import { ArrowRight, Heart, Globe } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";

export function WhereMostNeeded() {
  return (
    <div>
      <SEO title="Where Most Needed - Flexible Donations" description="Donate where help is needed most. Daan Foundation directs your flexible donation to the most urgent humanitarian needs — food, ration kits, medical aid, and more." canonical="/where-most-needed" keywords="donate where most needed, flexible charity donation, urgent humanitarian aid India" />
      <Breadcrumbs items={[{ label: "Where Most Needed" }]} />

      {/* Hero */}
      <section className="relative min-h-[450px] overflow-hidden">
        <div className="absolute inset-0">
          <img
            src="/images/hero-slide-4.jpg"
            alt="Ration Kit Distribution"
            className="h-full w-full object-cover"
          />
          <div className="absolute inset-0 bg-gradient-to-r from-orange-900/80 via-orange-800/60 to-orange-700/40" />
        </div>

        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 md:py-28">
          <div className="max-w-2xl">
            <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-6">
              Give to Where Most Needed
            </h1>
            <p className="text-xl text-white/90 leading-relaxed mb-8">
              Not sure where to give? Donate to our general fund and we'll ensure your gift reaches those in greatest need, wherever they are.
            </p>
            <Link
              to="/donate"
              className="inline-flex items-center gap-2 rounded-full bg-amber-500 px-8 py-4 font-bold text-white hover:bg-amber-600 transition-colors"
            >
              Donate Now
              <ArrowRight className="h-5 w-5" />
            </Link>
          </div>
        </div>
      </section>

      {/* How it works */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold text-slate-900 mb-4">How It Works</h2>
            <p className="text-lg text-slate-600 max-w-2xl mx-auto">
              Your unrestricted donation gives us flexibility to respond where needs are greatest
            </p>
          </div>

          <div className="grid md:grid-cols-3 gap-8">
            <div className="text-center">
              <div className="h-16 w-16 rounded-full bg-orange-100 flex items-center justify-center mx-auto mb-4">
                <Heart className="h-8 w-8 text-orange-600" />
              </div>
              <h3 className="text-xl font-bold text-slate-900 mb-2">You Donate</h3>
              <p className="text-slate-600">
                Give any amount to our Where Most Needed fund
              </p>
            </div>
            <div className="text-center">
              <div className="h-16 w-16 rounded-full bg-orange-100 flex items-center justify-center mx-auto mb-4">
                <Globe className="h-8 w-8 text-orange-600" />
              </div>
              <h3 className="text-xl font-bold text-slate-900 mb-2">We Assess</h3>
              <p className="text-slate-600">
                Our teams identify the most urgent needs globally
              </p>
            </div>
            <div className="text-center">
              <div className="h-16 w-16 rounded-full bg-orange-100 flex items-center justify-center mx-auto mb-4">
                <ArrowRight className="h-8 w-8 text-orange-600" />
              </div>
              <h3 className="text-xl font-bold text-slate-900 mb-2">Aid Reaches</h3>
              <p className="text-slate-600">
                Your donation helps those who need it most
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* Areas of support */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl font-bold text-slate-900 mb-8 text-center">
            Your Donation May Support
          </h2>

          <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {[
              { title: "Emergency Response", description: "Rapid relief when disaster strikes" },
              { title: "Food Security", description: "Fighting hunger and malnutrition" },
              { title: "Clean Water", description: "Access to safe drinking water" },
              { title: "Healthcare", description: "Medical care for vulnerable communities" },
              { title: "Education", description: "Schooling for children in need" },
              { title: "Shelter", description: "Safe housing for displaced families" },
              { title: "Orphan Care", description: "Support for orphaned children" },
              { title: "Livelihoods", description: "Skills training and income support" },
            ].map((item) => (
              <div key={item.title} className="bg-white rounded-xl p-5 shadow-sm">
                <h3 className="font-bold text-slate-900 mb-1">{item.title}</h3>
                <p className="text-sm text-slate-600">{item.description}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-slate-900 mb-4">
            Make a Difference Today
          </h2>
          <p className="text-lg text-slate-600 mb-8 max-w-2xl mx-auto">
            100% of your donation goes directly to those in need.
          </p>
          <Link
            to="/donate"
            className="inline-flex items-center gap-2 rounded-full bg-orange-600 px-8 py-4 font-bold text-white hover:bg-orange-700"
          >
            Donate to Where Most Needed
            <ArrowRight className="h-5 w-5" />
          </Link>
        </div>
      </section>
    </div>
  );
}

export default WhereMostNeeded;
