import { Link } from "react-router-dom";
import { ArrowRight } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";

export function CommunityTrust() {
  return (
    <div>
      <SEO title="Community Trust & Feedback" description="Read community feedback and testimonials about Daan Foundation's work. Transparency and trust are at the core of everything we do." canonical="/our-work/community-trust" keywords="charity trust, community feedback, transparent charity India, donor testimonials" />
      <Breadcrumbs items={[{ label: "Our Work", href: "/our-work/impact" }, { label: "Community Trust & Feedback" }]} />

      <section className="relative py-20 md:py-28 bg-gradient-to-br from-teal-600 to-emerald-700">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h1 className="text-4xl md:text-5xl font-extrabold text-white mb-6">Community Trust & Feedback</h1>
          <p className="text-xl text-white/90 max-w-2xl mx-auto">
            The true strength of humanitarian work is reflected in the trust, prayers, and feedback of the people it serves.
          </p>
        </div>
      </section>

      {/* Introduction */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto text-center">
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Voices From Our Community</h2>
            <p className="text-lg text-slate-600 leading-relaxed">
              We measure our success not just in numbers, but in the trust and gratitude of the communities we serve. Here are some of the voices that inspire us to keep going.
            </p>
          </div>
        </div>
      </section>

      {/* Testimonials */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            {[
              {
                name: "Ramzan Begam",
                quote: "During difficult financial days, Daan Foundation regularly provided cooked meals and ration support. Their help came when we needed it most.",
              },
              {
                name: "Chhoti Aapa",
                quote: "I have personally seen how the Community Kitchen distributes food daily to labourers, poor families, and travelers. Their work is truly remarkable.",
              },
              {
                name: "Raja Bhai",
                quote: "During Ramadan, Daan Foundation arranged Iftar meals and ration kits for many struggling families like ours. We are deeply grateful.",
              },
              {
                name: "Faizan Khan",
                role: "Volunteer",
                quote: "From food distribution to helping needy families, every volunteer works with sincerity. Being part of this mission has been a deeply fulfilling experience.",
              },
            ].map((testimonial) => (
              <div key={testimonial.name} className="bg-white rounded-2xl p-8 shadow-sm">
                <div className="text-teal-500 text-4xl font-serif mb-4">"</div>
                <p className="text-slate-600 leading-relaxed mb-6 italic">{testimonial.quote}</p>
                <div>
                  <p className="font-bold text-slate-900">{testimonial.name}</p>
                  {"role" in testimonial && testimonial.role && (
                    <p className="text-sm text-slate-500">{testimonial.role}</p>
                  )}
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-slate-900 mb-4">Be Part of This Trust</h2>
          <p className="text-lg text-slate-600 mb-8 max-w-2xl mx-auto">
            Your support strengthens the bond of trust between us and the communities we serve. Every contribution matters.
          </p>
          <Link
            to="/donate"
            className="inline-flex items-center gap-2 rounded-full bg-teal-600 px-8 py-4 text-lg font-semibold text-white shadow-lg hover:bg-teal-700 transition-colors"
          >
            Donate Now <ArrowRight className="h-5 w-5" />
          </Link>
        </div>
      </section>
    </div>
  );
}

export default CommunityTrust;
