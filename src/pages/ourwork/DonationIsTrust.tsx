import { Link } from "react-router-dom";
import { ArrowRight } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";

export function DonationIsTrust() {
  return (
    <div>
      <Breadcrumbs items={[{ label: "Our Work", href: "/our-work/impact" }, { label: "Your Donation Is a Trust" }]} />

      <section className="relative py-20 md:py-28 bg-gradient-to-br from-indigo-600 to-violet-700">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h1 className="text-4xl md:text-5xl font-extrabold text-white mb-6">Your Donation Is a Trust</h1>
          <p className="text-xl text-white/90 max-w-2xl mx-auto">
            Every donation is an amanah — a sacred trust that we are committed to honouring with integrity and transparency.
          </p>
        </div>
      </section>

      {/* Core Values */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Our Commitment to Your Trust</h2>
            <p className="text-lg text-slate-600 leading-relaxed mb-8">
              Daan Foundation believes every donation is an <span className="font-semibold text-slate-900">amanah</span> (trust). We are deeply committed to ensuring that every contribution is used ethically, transparently, and responsibly — reaching those who need it most.
            </p>
            <div className="grid sm:grid-cols-2 gap-6">
              {[
                { title: "Ethical Use", desc: "Every donation is used strictly for its intended charitable purpose." },
                { title: "Transparent Operations", desc: "Clear and honest reporting on how funds are allocated and distributed." },
                { title: "Responsible Distribution", desc: "Ensuring aid reaches the most deserving and vulnerable individuals." },
                { title: "Continuous Improvement", desc: "Constantly improving our processes to maximise the impact of every donation." },
              ].map((item) => (
                <div key={item.title} className="bg-indigo-50 rounded-xl p-6">
                  <h3 className="font-bold text-slate-900 mb-2">{item.title}</h3>
                  <p className="text-slate-600 text-sm">{item.desc}</p>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Important Notice */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Important Information</h2>
            <div className="bg-white rounded-2xl p-8 shadow-sm border-l-4 border-indigo-500">
              <p className="text-lg text-slate-600 leading-relaxed mb-4">
                Daan Foundation works only within India. We do not operate internationally and are not authorised to receive foreign donations.
              </p>
              <p className="text-lg text-slate-600 leading-relaxed">
                All charitable activities are focused exclusively on Indian communities. Your donations are utilised within India to serve those in need across local communities.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-slate-900 mb-4">Trust Us With Your Generosity</h2>
          <p className="text-lg text-slate-600 mb-8 max-w-2xl mx-auto">
            Your donation is a sacred trust. We promise to honour it with integrity and impact.
          </p>
          <Link
            to="/donate"
            className="inline-flex items-center gap-2 rounded-full bg-indigo-600 px-8 py-4 text-lg font-semibold text-white shadow-lg hover:bg-indigo-700 transition-colors"
          >
            Donate Now <ArrowRight className="h-5 w-5" />
          </Link>
        </div>
      </section>
    </div>
  );
}

export default DonationIsTrust;
