import { Link } from "react-router-dom";
import { Globe, MapPin, Users, ArrowRight } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";

const regions = [
  {
    name: "Middle East",
    countries: ["Palestine", "Yemen", "Syria", "Lebanon", "Iraq", "Jordan"],
    color: "bg-red-100 text-red-700",
  },
  {
    name: "Africa",
    countries: ["Somalia", "Sudan", "Ethiopia", "Kenya", "Mali", "Niger", "Chad"],
    color: "bg-amber-100 text-amber-700",
  },
  {
    name: "South Asia",
    countries: ["Pakistan", "Bangladesh", "Afghanistan", "India", "Nepal"],
    color: "bg-blue-100 text-blue-700",
  },
  {
    name: "Southeast Asia",
    countries: ["Indonesia", "Myanmar", "Malaysia"],
    color: "bg-orange-100 text-orange-700",
  },
];

const impactStats = [
  { value: "30+", label: "Countries" },
  { value: "10M+", label: "People Helped" },
  { value: "25+", label: "Years Experience" },
  { value: "500+", label: "Active Projects" },
];

export function WhereWeWork() {
  return (
    <div>
      <Breadcrumbs items={[{ label: "Where We Work" }]} />

      {/* Hero */}
      <section className="relative py-20 md:py-28 bg-gradient-to-br from-slate-800 to-slate-900">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <Globe className="h-16 w-16 text-orange-400 mx-auto mb-6" />
          <h1 className="text-4xl md:text-5xl font-extrabold text-white mb-6">
            Where We Work
          </h1>
          <p className="text-xl text-slate-300 max-w-2xl mx-auto">
            We operate in some of the world's most challenging environments, delivering aid to those who need it most.
          </p>
        </div>
      </section>

      {/* Impact stats */}
      <section className="py-12 bg-orange-600">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
            {impactStats.map(({ value, label }) => (
              <div key={label} className="text-center">
                <div className="text-4xl font-bold text-white mb-1">{value}</div>
                <div className="text-orange-100">{label}</div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Regions */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl font-bold text-slate-900 mb-12 text-center">
            Our Regions
          </h2>

          <div className="grid md:grid-cols-2 gap-8">
            {regions.map((region) => (
              <div key={region.name} className="bg-[#F3F4F6] rounded-2xl p-6">
                <h3 className="text-xl font-bold text-slate-900 mb-4">{region.name}</h3>
                <div className="flex flex-wrap gap-2">
                  {region.countries.map((country) => (
                    <span
                      key={country}
                      className={`px-3 py-1 rounded-full text-sm font-medium ${region.color}`}
                    >
                      {country}
                    </span>
                  ))}
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Featured project */}
      <section className="py-16 md:py-24 bg-slate-100">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div>
              <img
                src="/images/aid-distribution-elderly.jpg"
                alt="Aid distribution"
                className="rounded-2xl shadow-lg"
              />
            </div>
            <div>
              <span className="inline-flex items-center gap-1 text-sm font-semibold text-red-600 mb-2">
                <MapPin className="h-4 w-4" /> Palestine
              </span>
              <h2 className="text-3xl font-bold text-slate-900 mb-4">
                Emergency Response in Gaza
              </h2>
              <p className="text-lg text-slate-600 mb-6">
                Our teams are on the ground providing emergency food, medical supplies, and shelter to families affected by the ongoing crisis. Your donations directly support life-saving aid.
              </p>
              <div className="flex items-center gap-4 mb-6">
                <div className="flex items-center gap-2">
                  <Users className="h-5 w-5 text-orange-600" />
                  <span className="text-slate-600">500,000+ people reached</span>
                </div>
              </div>
              <Link
                to="/appeals/palestine-emergency"
                className="inline-flex items-center gap-2 font-semibold text-orange-600 hover:text-orange-700"
              >
                Support Palestine Emergency
                <ArrowRight className="h-4 w-4" />
              </Link>
            </div>
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-slate-900 mb-4">
            Support Our Global Mission
          </h2>
          <p className="text-lg text-slate-600 mb-8 max-w-2xl mx-auto">
            Your donation helps us reach the most vulnerable communities around the world.
          </p>
          <Link
            to="/donate"
            className="inline-flex items-center gap-2 rounded-full bg-orange-600 px-8 py-4 font-bold text-white hover:bg-orange-700"
          >
            Donate Now
            <ArrowRight className="h-5 w-5" />
          </Link>
        </div>
      </section>
    </div>
  );
}

export default WhereWeWork;
