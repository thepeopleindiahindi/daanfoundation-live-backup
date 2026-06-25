import { Link } from "react-router-dom";
import {
  ArrowRight,
  Heart,
  Users,
  HandHeart,
  ShieldCheck,
  CheckCircle2,
  Gem,
  AlertTriangle,
  Handshake,
} from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";
import { DonationSidebar } from "@/components/donation/DonationSidebar";

const stats = [
  { number: "100+", label: "Families Supported", icon: Heart },
  { number: "Always", label: "Dignity Preserved", icon: ShieldCheck },
  { number: "Regular", label: "Community Weddings", icon: Users },
  { number: "Real", label: "Financial Relief", icon: HandHeart },
];

const challenges = [
  "Many families accumulate massive debts to fund marriage ceremonies, borrowing from money lenders at exploitative interest rates.",
  "Young women's marriages are delayed for years because families cannot save enough for even basic wedding arrangements.",
  "The social pressure for lavish ceremonies pushes vulnerable families further into poverty, affecting their financial stability for years.",
  "In some cases, families are forced to sell assets or take children out of school to fund wedding expenses.",
];

const howWeHelp = [
  {
    icon: Gem,
    title: "Basic Wedding Essentials",
    description:
      "We provide essential items needed for a dignified wedding — from basic household items for the new couple to simple ceremony necessities.",
  },
  {
    icon: HandHeart,
    title: "Financial Support",
    description:
      "Direct financial assistance to cover the core expenses of a simple, dignified wedding ceremony without pushing the family into debt.",
  },
  {
    icon: Users,
    title: "Community Wedding Arrangements",
    description:
      "We organize community wedding ceremonies where multiple families can celebrate together, significantly reducing individual costs while maintaining joy.",
  },
  {
    icon: Handshake,
    title: "Counseling & Support",
    description:
      "Pre-wedding counseling and family support to encourage simple ceremonies and help families resist social pressure for extravagant spending.",
  },
];

const approachSteps = [
  "Verify genuine need through community references and family assessment",
  "Understand specific requirements and provide tailored essential items",
  "Arrange community ceremonies when possible to reduce costs",
  "Ensure the family maintains dignity throughout the process",
  "Follow up post-wedding to ensure the family is not in financial distress",
];

export function MarriageAssistance() {
  return (
    <div>
      <SEO title="Marriage Assistance - Supporting Families" description="Daan Foundation helps poor families with marriage expenses so they don't fall into debt. Simple, dignified wedding support and community ceremonies across India." canonical="/our-work/marriage-assistance" keywords="marriage assistance charity India, wedding support poor families, nikah help, marriage charity" />
      <Breadcrumbs
        items={[
          { label: "Our Work", href: "/our-work/charity-in-action" },
          { label: "Marriage Assistance" },
        ]}
      />

      {/* Hero */}
      <section className="relative py-20 md:py-28 bg-gradient-to-br from-rose-600 to-pink-600">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div>
              <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-6">
                Marriage Assistance
              </h1>
              <p className="text-2xl text-white/95 font-semibold mb-4">
                Dignified Weddings Without the Burden of Debt
              </p>
              <p className="text-lg text-white/85 leading-relaxed mb-8">
                Marriage is a joyful milestone, but for many poor families it brings immense financial pressure. Daan
                Foundation helps with basic wedding arrangements, essential items, and financial support so families can
                celebrate without falling into crippling debt.
              </p>
              <Link
                to="/donate"
                className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-rose-600 hover:shadow-lg transition-shadow"
              >
                Support a Wedding
                <ArrowRight className="h-5 w-5" />
              </Link>
            </div>
            <div className="hidden lg:block">
              <img
                src="/images/extra-4.jpg"
                alt="Marriage assistance program"
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
                <Icon className="h-8 w-8 text-rose-400 mx-auto mb-2" />
                <div className="text-2xl md:text-3xl font-bold text-white">{number}</div>
                <div className="text-sm text-slate-400">{label}</div>
              </div>
            ))}
          </div>
        </div>
      </section>

      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <div className="lg:grid lg:grid-cols-3 lg:gap-10">
          <div className="lg:col-span-2 space-y-10">

            {/* The Challenge */}
            <section>
              <div className="max-w-3xl">
                <div className="flex items-center gap-3 mb-6">
                  <AlertTriangle className="h-8 w-8 text-rose-600" />
                  <h2 className="text-3xl font-bold text-slate-900">The Challenge</h2>
                </div>
                <div className="prose prose-lg text-slate-600 mb-8">
                  <p>
                    In many communities, marriage expenses create one of the biggest financial burdens a family will ever
                    face. Social expectations, cultural norms, and community pressure push families to spend far beyond
                    their means — often with devastating consequences.
                  </p>
                </div>
                <div className="space-y-4">
                  {challenges.map((challenge) => (
                    <div key={challenge} className="flex items-start gap-3 bg-rose-50 rounded-xl p-4">
                      <AlertTriangle className="h-5 w-5 text-rose-500 flex-shrink-0 mt-0.5" />
                      <p className="text-slate-700">{challenge}</p>
                    </div>
                  ))}
                </div>
              </div>
            </section>

            <div className="border-t border-slate-200" />

            {/* How We Help */}
            <section>
              <h2 className="text-3xl font-bold text-slate-900 mb-4">How We Help</h2>
              <p className="text-lg text-slate-600 mb-8">
                Our marriage assistance program focuses on enabling simple, dignified ceremonies that bring joy without
                financial ruin.
              </p>
              <div className="grid md:grid-cols-2 gap-6">
                {howWeHelp.map((item) => (
                  <div key={item.title} className="bg-white rounded-2xl p-6 shadow-sm">
                    <div className="flex items-start gap-4">
                      <item.icon className="h-8 w-8 text-rose-600 flex-shrink-0 mt-1" />
                      <div>
                        <h3 className="text-lg font-bold text-slate-900 mb-2">{item.title}</h3>
                        <p className="text-slate-600">{item.description}</p>
                      </div>
                    </div>
                  </div>
                ))}
              </div>
            </section>

            <div className="border-t border-slate-200" />

            {/* Our Approach */}
            <section>
              <h2 className="text-3xl font-bold text-slate-900 mb-4">Our Approach</h2>
              <p className="text-lg text-slate-600 mb-8">
                Every family we support goes through a thoughtful, respectful process designed to preserve dignity at
                every step.
              </p>
              <div className="space-y-4">
                {approachSteps.map((step, index) => (
                  <div key={step} className="flex items-start gap-4 bg-white rounded-xl p-5 shadow-sm border border-slate-100">
                    <div className="flex-shrink-0 w-8 h-8 rounded-full bg-rose-100 text-rose-700 flex items-center justify-center font-bold text-sm">
                      {index + 1}
                    </div>
                    <p className="text-slate-700 pt-1">{step}</p>
                  </div>
                ))}
              </div>
            </section>

            <div className="border-t border-slate-200" />

            {/* Simple Weddings */}
            <section className="bg-[#F3F4F6] rounded-2xl p-6 md:p-8">
              <div className="text-center">
                <Heart className="h-12 w-12 text-rose-600 mx-auto mb-6" />
                <h2 className="text-3xl font-bold text-slate-900 mb-6">The Beauty of Simple Weddings</h2>
                <p className="text-lg text-slate-600 mb-4">
                  We believe that a wedding's beauty lies in the love shared between families and communities — not in
                  extravagant displays that leave families in debt. Our community wedding programs bring multiple families
                  together to celebrate joyfully while sharing costs.
                </p>
                <p className="text-slate-600">
                  These collective celebrations create a sense of solidarity and prove that happiness doesn't require a
                  price tag. Families leave with joy, not debt — and the community grows stronger together.
                </p>
              </div>
            </section>

          </div>

          <aside className="lg:col-span-1 mt-8 lg:mt-0">
            <div className="lg:sticky lg:top-24">
              <DonationSidebar defaultCause="where-needed" />
            </div>
          </aside>

        </div>
      </div>

      {/* CTA */}
      <section className="py-16 md:py-20 bg-gradient-to-br from-rose-600 to-pink-600">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-white mb-4">Help a Family Celebrate With Dignity</h2>
          <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">
            Your contribution can help a deserving family celebrate one of life's most important moments without the
            shadow of debt. Give the gift of joy, dignity, and a fresh start.
          </p>
          <Link
            to="/donate"
            className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-rose-600 hover:shadow-lg transition-shadow"
          >
            Donate Now
            <ArrowRight className="h-5 w-5" />
          </Link>
        </div>
      </section>
    </div>
  );
}

export default MarriageAssistance;
