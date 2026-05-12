import { Link } from "react-router-dom";
import {
  ArrowRight,
  Stethoscope,
  HeartPulse,
  Pill,
  Building2,
  CheckCircle2,
  ShieldCheck,
  Users,
  Clock,
} from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";

const stats = [
  { number: "300+", label: "Patients Helped", icon: HeartPulse },
  { number: "24/7", label: "Emergency Support", icon: Clock },
  { number: "Regular", label: "Medicine Distribution", icon: Pill },
  { number: "Multiple", label: "Hospital Referrals", icon: Building2 },
];

const whoWeHelp = [
  {
    title: "Chronic Illness Patients",
    description: "Individuals suffering from long-term conditions who need ongoing medication and treatment they cannot afford.",
  },
  {
    title: "Accident Victims",
    description: "People injured in accidents whose families face sudden, overwhelming hospital bills with no savings to fall back on.",
  },
  {
    title: "Families Unable to Afford Treatment",
    description: "Low-income households where a single medical emergency can push the entire family deeper into poverty.",
  },
  {
    title: "Elderly Needing Regular Medication",
    description: "Senior citizens living alone or with limited support who require regular medicines for blood pressure, diabetes, and other conditions.",
  },
];

const howWeHelp = [
  {
    icon: ShieldCheck,
    title: "Direct Financial Assistance",
    description:
      "We provide direct financial support to cover hospital bills, surgery costs, and diagnostic tests for verified patients in genuine need.",
  },
  {
    icon: Pill,
    title: "Medicine Procurement",
    description:
      "Regular procurement and distribution of essential medicines for chronic patients who cannot afford to buy them on their own.",
  },
  {
    icon: Building2,
    title: "Hospital Coordination",
    description:
      "We connect patients with hospitals, doctors, and specialists, coordinating treatment plans and negotiating costs on behalf of families.",
  },
  {
    icon: Users,
    title: "Post-Treatment Support",
    description:
      "Support doesn't end at discharge. We assist with follow-up medicines, rehabilitation needs, and ongoing care coordination.",
  },
];

export function MedicalAssistance() {
  return (
    <div>
      <SEO title="Medical Assistance - Healthcare for the Vulnerable" description="Daan Foundation supports medical needs of vulnerable families — hospital bills, medicines, emergency medical aid, and connecting patients with healthcare in India." canonical="/our-work/medical-assistance" keywords="medical assistance charity India, healthcare donation, medicine support poor, hospital bill charity" />
      <Breadcrumbs
        items={[
          { label: "Our Work", href: "/our-work/charity-in-action" },
          { label: "Medical Assistance" },
        ]}
      />

      {/* Hero */}
      <section className="relative py-20 md:py-28 bg-gradient-to-br from-blue-600 to-cyan-600">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div>
              <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-6">
                Medical Assistance
              </h1>
              <p className="text-2xl text-white/95 font-semibold mb-4">
                Supporting Vulnerable Families Through Health Crises
              </p>
              <p className="text-lg text-white/85 leading-relaxed mb-8">
                When illness strikes a poor family, the burden goes far beyond health — it threatens their entire
                livelihood. Daan Foundation steps in to help with hospital bills, medicines, medical equipment, and
                emergency support so that no one is denied treatment due to poverty.
              </p>
              <Link
                to="/donate"
                className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-blue-600 hover:shadow-lg transition-shadow"
              >
                Support Medical Aid
                <ArrowRight className="h-5 w-5" />
              </Link>
            </div>
            <div className="hidden lg:block">
              <img
                src="/images/extra-2.jpg"
                alt="Medical assistance program"
                className="rounded-2xl shadow-2xl"
              />
            </div>
          </div>
        </div>
      </section>

      {/* Stats */}
      <section className="py-12 bg-slate-900">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
            {stats.map(({ number, label, icon: Icon }) => (
              <div key={label} className="text-center">
                <Icon className="h-8 w-8 text-blue-400 mx-auto mb-2" />
                <div className="text-2xl md:text-3xl font-bold text-white">{number}</div>
                <div className="text-sm text-slate-400">{label}</div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* About */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Healthcare Should Not Be a Privilege</h2>
            <div className="prose prose-lg text-slate-600">
              <p>
                In our communities, countless families face impossible choices when illness strikes — between food and
                medicine, between rent and hospital bills. Many delay treatment until conditions become critical, simply
                because they cannot afford to see a doctor.
              </p>
              <p>
                Daan Foundation's Medical Assistance program works to bridge this gap. We provide direct financial
                support for medical emergencies, ensure chronic patients receive regular medication, and connect families
                with hospitals and healthcare providers who can help.
              </p>
              <p>
                Our approach is holistic: we don't just cover a single bill and move on. We work with patients and their
                families from diagnosis through recovery, ensuring they have the support they need at every stage of
                treatment.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* Who We Help */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl font-bold text-slate-900 mb-4 text-center">Who We Help</h2>
          <p className="text-lg text-slate-600 text-center mb-12 max-w-2xl mx-auto">
            Our medical assistance reaches those who have nowhere else to turn — people for whom a single illness can
            mean financial ruin.
          </p>
          <div className="grid md:grid-cols-2 gap-6">
            {whoWeHelp.map((item) => (
              <div key={item.title} className="bg-white rounded-2xl p-6 shadow-sm">
                <div className="flex items-start gap-4">
                  <Stethoscope className="h-7 w-7 text-blue-600 flex-shrink-0 mt-1" />
                  <div>
                    <h3 className="text-lg font-bold text-slate-900 mb-2">{item.title}</h3>
                    <p className="text-slate-600">{item.description}</p>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* How We Help */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl font-bold text-slate-900 mb-4 text-center">How We Help</h2>
          <p className="text-lg text-slate-600 text-center mb-12 max-w-2xl mx-auto">
            From emergency response to long-term care, our medical assistance covers every step of the journey.
          </p>
          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            {howWeHelp.map((item) => (
              <div key={item.title} className="text-center p-6 rounded-2xl border border-slate-200 bg-white">
                <item.icon className="h-10 w-10 text-blue-600 mx-auto mb-4" />
                <h3 className="text-lg font-bold text-slate-900 mb-2">{item.title}</h3>
                <p className="text-sm text-slate-600">{item.description}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Emergency Fund */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto text-center">
            <HeartPulse className="h-12 w-12 text-blue-600 mx-auto mb-6" />
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Emergency Medical Support Fund</h2>
            <p className="text-lg text-slate-600 mb-4">
              Medical emergencies don't wait — and neither do we. Our Emergency Medical Support Fund ensures that
              verified patients receive immediate assistance when time is critical.
            </p>
            <p className="text-slate-600">
              Whether it's a sudden accident, a critical surgery, or an urgent need for life-saving medication, the
              emergency fund provides rapid response support so treatment is never delayed due to lack of money.
            </p>
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 md:py-20 bg-gradient-to-br from-blue-600 to-cyan-600">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-white mb-4">Your Support Can Save a Life</h2>
          <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">
            For a struggling family, your donation can mean the difference between suffering and recovery, between
            despair and hope. Help us ensure that poverty never becomes a death sentence.
          </p>
          <Link
            to="/donate"
            className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-blue-600 hover:shadow-lg transition-shadow"
          >
            Donate Now
            <ArrowRight className="h-5 w-5" />
          </Link>
        </div>
      </section>
    </div>
  );
}

export default MedicalAssistance;
