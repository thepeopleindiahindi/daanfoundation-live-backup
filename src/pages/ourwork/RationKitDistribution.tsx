import { Link } from "react-router-dom";
import {
  ArrowRight,
  Package,
  Users,
  CalendarDays,
  HandHeart,
  CheckCircle2,
  Wheat,
  Droplets,
  CookingPot,
  Truck,
  ClipboardList,
  Heart,
} from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";
import { DonationSidebar } from "@/components/donation/DonationSidebar";

const stats = [
  { number: "5,000+", label: "Kits Distributed", icon: Package },
  { number: "Essential", label: "Daily Items", icon: CookingPot },
  { number: "Year-Round", label: "Distribution", icon: CalendarDays },
  { number: "All", label: "Communities Served", icon: Users },
];

const rationItems = [
  { item: "Rice", quantity: "5 kg", icon: Wheat },
  { item: "Dal / Lentils", quantity: "2 kg", icon: CookingPot },
  { item: "Cooking Oil", quantity: "1 Litre", icon: Droplets },
  { item: "Wheat Flour (Atta)", quantity: "5 kg", icon: Wheat },
  { item: "Sugar", quantity: "1 kg", icon: Package },
  { item: "Tea", quantity: "250 g", icon: CookingPot },
  { item: "Salt", quantity: "1 kg", icon: Package },
  { item: "Spices", quantity: "Assorted", icon: CookingPot },
  { item: "Soap", quantity: "2 bars", icon: Droplets },
];

const recipients = [
  {
    title: "Daily Wage Workers Without Income",
    description: "Labourers and workers who face days without work and have no savings to fall back on for food.",
  },
  {
    title: "Widows With No Financial Support",
    description: "Women who have lost their husbands and have no steady income or family support to sustain themselves.",
  },
  {
    title: "Elderly Living Alone",
    description: "Senior citizens who live without family support and struggle to arrange even basic meals.",
  },
  {
    title: "Families Facing Temporary Hardship",
    description: "Households going through job loss, illness, or other crises that have disrupted their ability to buy food.",
  },
  {
    title: "Disabled Individuals",
    description: "People with disabilities who are unable to work and depend on others for their daily needs.",
  },
];

const distributionProcess = [
  {
    icon: ClipboardList,
    title: "Identify Communities in Need",
    description:
      "We work with local leaders, mosque committees, and community organizations to identify areas and families most in need of food support.",
  },
  {
    icon: Package,
    title: "Prepare Standardized Kits",
    description:
      "Each ration kit is carefully assembled with quality-checked items in standardized quantities to ensure consistency and fairness.",
  },
  {
    icon: Truck,
    title: "Door-to-Door Distribution",
    description:
      "Our volunteers deliver ration kits directly to homes, especially for elderly and disabled beneficiaries who cannot travel to collection points.",
  },
  {
    icon: Heart,
    title: "Maintain Dignity & Respect",
    description:
      "Every distribution is conducted with care and respect. We ensure privacy, avoid public queuing, and treat every recipient with compassion.",
  },
];

export function RationKitDistribution() {
  return (
    <div>
      <SEO title="Ration Kit Distribution - Essential Food Support" description="Daan Foundation distributes essential food ration kits containing rice, dal, oil, flour, and more to struggling families year-round across India. 5,000+ kits distributed." canonical="/our-work/ration-kit-distribution" keywords="ration kit distribution India, food kit charity, essential supplies donation, food support poor families" />
      <Breadcrumbs
        items={[
          { label: "Our Work", href: "/our-work/charity-in-action" },
          { label: "Ration Kit Distribution" },
        ]}
      />

      {/* Hero */}
      <section className="relative py-20 md:py-28 bg-gradient-to-br from-amber-600 to-orange-600">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div>
              <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-6">
                Ration Kit Distribution
              </h1>
              <p className="text-2xl text-white/95 font-semibold mb-4">
                Essential Food Supplies for Struggling Families
              </p>
              <p className="text-lg text-white/85 leading-relaxed mb-8">
                Hunger doesn't wait for convenient times. Daan Foundation distributes essential food ration kits
                year-round to families who struggle to afford basic groceries. Each kit contains staple items that
                sustain a family for approximately 2–3 weeks.
              </p>
              <Link
                to="/donate"
                className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-amber-600 hover:shadow-lg transition-shadow"
              >
                Feed a Family
                <ArrowRight className="h-5 w-5" />
              </Link>
            </div>
            <div className="hidden lg:block">
              <img
                src="/images/hero-slide-4.jpg"
                alt="Ration kit distribution"
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
                <Icon className="h-8 w-8 text-amber-400 mx-auto mb-2" />
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

            {/* About */}
            <section>
              <div className="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                  <h2 className="text-3xl font-bold text-slate-900 mb-6">Fighting Hunger, One Kit at a Time</h2>
                  <div className="prose prose-lg text-slate-600">
                    <p>
                      For millions of families living on the edge, the simple act of putting food on the table is a daily
                      struggle. Daily wage workers who lose even a few days of work, widows without financial support, and
                      elderly individuals living alone — all face the constant threat of hunger.
                    </p>
                    <p>
                      Daan Foundation's Ration Kit Distribution program provides carefully assembled food kits containing
                      essential staples — rice, dal, oil, flour, sugar, tea, spices, and soap. Each kit is designed to
                      sustain a family of 4–5 members for approximately 2–3 weeks.
                    </p>
                    <p>
                      Our distribution runs year-round, with special expanded drives during Ramadan and winter months when
                      needs are greatest. We reach communities across the region, serving people of all backgrounds without
                      discrimination.
                    </p>
                  </div>
                </div>
                <div>
                  <img
                    src="/images/ration-kit-front.jpg"
                    alt="Ration kit contents"
                    className="rounded-2xl shadow-lg"
                  />
                </div>
              </div>
            </section>

            <div className="border-t border-slate-200" />

            {/* What's In a Ration Kit */}
            <section>
              <h2 className="text-3xl font-bold text-slate-900 mb-4 text-center">What's In a Ration Kit</h2>
              <p className="text-lg text-slate-600 text-center mb-8 max-w-2xl mx-auto">
                Each kit is carefully assembled with quality-checked essential items to sustain a family for 2–3 weeks.
              </p>
              <div className="grid grid-cols-2 md:grid-cols-3 gap-4 max-w-3xl mx-auto">
                {rationItems.map(({ item, quantity, icon: Icon }) => (
                  <div key={item} className="bg-white rounded-xl p-4 shadow-sm flex items-center gap-3">
                    <Icon className="h-6 w-6 text-amber-600 flex-shrink-0" />
                    <div>
                      <div className="font-bold text-slate-900 text-sm">{item}</div>
                      <div className="text-xs text-slate-500">{quantity}</div>
                    </div>
                  </div>
                ))}
              </div>
            </section>

            <div className="border-t border-slate-200" />

            {/* Who Receives */}
            <section>
              <div className="grid lg:grid-cols-2 gap-12 items-start">
                <div>
                  <h2 className="text-3xl font-bold text-slate-900 mb-6">Who Receives Ration Kits</h2>
                  <p className="text-lg text-slate-600 mb-8">
                    Our ration kits reach those who face the greatest food insecurity — individuals and families for whom
                    even a single meal is uncertain.
                  </p>
                  <div className="space-y-4">
                    {recipients.map((r) => (
                      <div key={r.title} className="flex items-start gap-3">
                        <CheckCircle2 className="h-6 w-6 text-amber-600 flex-shrink-0 mt-0.5" />
                        <div>
                          <div className="font-bold text-slate-900">{r.title}</div>
                          <p className="text-sm text-slate-600">{r.description}</p>
                        </div>
                      </div>
                    ))}
                  </div>
                </div>
                <div>
                  <img
                    src="/images/extra-5.jpg"
                    alt="Ration kit distribution to families"
                    className="rounded-2xl shadow-lg"
                  />
                </div>
              </div>
            </section>

            <div className="border-t border-slate-200" />

            {/* Distribution Process */}
            <section>
              <h2 className="text-3xl font-bold text-slate-900 mb-4 text-center">Our Distribution Process</h2>
              <p className="text-lg text-slate-600 text-center mb-8 max-w-2xl mx-auto">
                Every step of our process is designed to ensure efficiency, fairness, and above all — dignity.
              </p>
              <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                {distributionProcess.map((step, index) => (
                  <div key={step.title} className="text-center p-6 rounded-2xl bg-white shadow-sm border border-slate-100">
                    <div className="inline-flex items-center justify-center w-10 h-10 rounded-full bg-amber-100 text-amber-700 font-bold text-lg mb-4">
                      {index + 1}
                    </div>
                    <step.icon className="h-8 w-8 text-amber-600 mx-auto mb-3" />
                    <h3 className="text-lg font-bold text-slate-900 mb-2">{step.title}</h3>
                    <p className="text-sm text-slate-600">{step.description}</p>
                  </div>
                ))}
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
      <section className="py-16 md:py-20 bg-gradient-to-br from-amber-600 to-orange-600">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-white mb-4">No Family Should Go Hungry</h2>
          <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">
            A single ration kit can feed a family for weeks. Your donation ensures that struggling families have access
            to basic food essentials. Join us in our mission to fight hunger with dignity.
          </p>
          <Link
            to="/donate"
            className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-amber-600 hover:shadow-lg transition-shadow"
          >
            Donate Now
            <ArrowRight className="h-5 w-5" />
          </Link>
        </div>
      </section>
    </div>
  );
}

export default RationKitDistribution;
