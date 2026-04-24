import { Link } from "react-router-dom";
import { ArrowRight, Filter } from "lucide-react";
import { appeals } from "@/data/appeals";
import Breadcrumbs from "@/components/layout/Breadcrumbs";

export function Appeals() {
  const emergencyAppeals = appeals.filter((a) => a.category === "emergency");
  const seasonalAppeals = appeals.filter((a) => a.category === "seasonal");

  return (
    <div>
      <Breadcrumbs items={[{ label: "Appeals" }]} />

      {/* Hero */}
      <section className="relative py-16 md:py-20 bg-gradient-to-br from-emerald-600 to-teal-700">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h1 className="text-4xl md:text-5xl font-extrabold text-white mb-4">
            Emergency Appeals
          </h1>
          <p className="text-xl text-white/90 max-w-2xl mx-auto">
            Your donations provide life-saving aid to communities facing crisis around the world.
          </p>
        </div>
      </section>

      {/* Emergency Appeals */}
      <section className="py-12 md:py-16">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="flex items-center justify-between mb-8">
            <h2 className="text-2xl font-bold text-slate-900">Emergency Appeals</h2>
            <span className="text-sm text-slate-500">{emergencyAppeals.length} active</span>
          </div>

          <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {emergencyAppeals.map((appeal) => {
              const progress = Math.round((appeal.raised / appeal.goal) * 100);
              return (
                <Link
                  key={appeal.id}
                  to={`/appeals/${appeal.slug}`}
                  className="group bg-white rounded-2xl overflow-hidden shadow-sm ring-1 ring-slate-200 hover:shadow-xl hover:ring-emerald-200 transition-all"
                >
                  <div className="relative aspect-[16/10] overflow-hidden">
                    <img
                      src={appeal.image}
                      alt={appeal.title}
                      className="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500"
                    />
                    {appeal.urgent && (
                      <span className="absolute top-3 left-3 rounded-full bg-rose-500 px-3 py-1 text-xs font-semibold text-white">
                        Urgent
                      </span>
                    )}
                    <div className="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-slate-900/80 to-transparent">
                      <div className="h-1.5 bg-white/30 rounded-full overflow-hidden">
                        <div
                          className="h-full bg-emerald-400 rounded-full"
                          style={{ width: `${progress}%` }}
                        />
                      </div>
                      <div className="flex justify-between text-xs text-white mt-2">
                        <span>£{appeal.raised.toLocaleString()} raised</span>
                        <span>{progress}%</span>
                      </div>
                    </div>
                  </div>
                  <div className="p-5">
                    <h3 className="font-bold text-slate-900 mb-2 group-hover:text-emerald-600 transition-colors">
                      {appeal.title}
                    </h3>
                    <p className="text-sm text-slate-600 line-clamp-2 mb-4">
                      {appeal.description}
                    </p>
                    <span className="inline-flex items-center gap-1 text-sm font-semibold text-emerald-600">
                      Donate now
                      <ArrowRight className="h-4 w-4 group-hover:translate-x-1 transition-transform" />
                    </span>
                  </div>
                </Link>
              );
            })}
          </div>
        </div>
      </section>

      {/* Seasonal Appeals */}
      <section className="py-12 md:py-16 bg-slate-50">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h2 className="text-2xl font-bold text-slate-900 mb-8">Seasonal Campaigns</h2>

          <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {seasonalAppeals.map((appeal) => (
              <Link
                key={appeal.id}
                to={`/appeals/${appeal.slug}`}
                className="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow"
              >
                <div className="aspect-[16/10] overflow-hidden">
                  <img
                    src={appeal.image}
                    alt={appeal.title}
                    className="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500"
                  />
                </div>
                <div className="p-5">
                  <h3 className="font-bold text-slate-900 mb-2 group-hover:text-emerald-600 transition-colors">
                    {appeal.title}
                  </h3>
                  <p className="text-sm text-slate-600 line-clamp-2">{appeal.description}</p>
                </div>
              </Link>
            ))}
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-12 md:py-16">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="rounded-2xl bg-gradient-to-r from-amber-500 to-orange-600 p-8 md:p-12 text-center">
            <h2 className="text-2xl md:text-3xl font-bold text-white mb-4">
              Not Sure Where to Give?
            </h2>
            <p className="text-white/90 mb-6 max-w-xl mx-auto">
              Donate to where most needed and we'll ensure your gift reaches those in the greatest need.
            </p>
            <Link
              to="/where-most-needed"
              className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 text-base font-bold text-amber-600 hover:shadow-lg transition-shadow"
            >
              Give to Where Most Needed
              <ArrowRight className="h-5 w-5" />
            </Link>
          </div>
        </div>
      </section>
    </div>
  );
}

export default Appeals;
