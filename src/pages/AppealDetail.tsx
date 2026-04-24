import { Link, useParams } from "react-router-dom";
import { ArrowRight, Share2, Heart } from "lucide-react";
import { getAppealBySlug, appeals } from "@/data/appeals";
import Breadcrumbs from "@/components/layout/Breadcrumbs";

const presetAmounts = [50, 100, 250, 500];

export function AppealDetail() {
  const { slug } = useParams<{ slug: string }>();
  const appeal = getAppealBySlug(slug || "");

  if (!appeal) {
    return (
      <div className="min-h-[60vh] flex items-center justify-center">
        <div className="text-center">
          <h1 className="text-2xl font-bold text-slate-900 mb-2">Appeal Not Found</h1>
          <p className="text-slate-600 mb-4">The appeal you're looking for doesn't exist.</p>
          <Link to="/appeals" className="text-orange-600 font-semibold hover:underline">
            View all appeals
          </Link>
        </div>
      </div>
    );
  }

  const progress = Math.round((appeal.raised / appeal.goal) * 100);
  const relatedAppeals = appeals.filter((a) => a.id !== appeal.id).slice(0, 3);

  return (
    <div>
      <Breadcrumbs
        items={[
          { label: "Appeals", href: "/appeals" },
          { label: appeal.shortTitle },
        ]}
      />

      {/* Hero */}
      <section className="relative min-h-[400px] md:min-h-[500px]">
        <div className="absolute inset-0">
          <img
            src={appeal.image}
            alt={appeal.title}
            className="h-full w-full object-cover"
          />
          <div className="absolute inset-0 bg-gradient-to-r from-slate-900/80 via-slate-900/60 to-slate-900/40" />
        </div>

        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 md:py-24">
          <div className="max-w-2xl">
            {appeal.urgent && (
              <span className="inline-flex items-center gap-2 rounded-full bg-rose-500 px-4 py-1.5 text-sm font-semibold text-white mb-4">
                <span className="h-2 w-2 rounded-full bg-white animate-pulse" />
                Urgent Appeal
              </span>
            )}
            <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-4">
              {appeal.title}
            </h1>
            <p className="text-xl text-white/90 leading-relaxed">
              {appeal.description}
            </p>
          </div>
        </div>
      </section>

      {/* Main content */}
      <section className="py-12 md:py-16">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-3 gap-12">
            {/* Content */}
            <div className="lg:col-span-2">
              <div className="prose prose-lg max-w-none">
                <h2>About This Appeal</h2>
                <p>{appeal.longDescription}</p>

                <h3>How Your Donation Helps</h3>
                <ul>
                  <li><strong>£50</strong> can provide emergency food for a family for one month</li>
                  <li><strong>£100</strong> can supply clean water to a community for a week</li>
                  <li><strong>£250</strong> can provide medical supplies for a clinic</li>
                  <li><strong>£500</strong> can help rebuild a family's shelter</li>
                </ul>

                <h3>The Situation</h3>
                <p>
                  Communities are facing unprecedented challenges. Families have been displaced,
                  children have lost access to education, and basic necessities are scarce.
                  Your support enables us to provide immediate relief and long-term assistance.
                </p>
              </div>

              {/* Share buttons */}
              <div className="mt-8 pt-8 border-t border-slate-200">
                <h4 className="font-semibold text-slate-900 mb-4">Share This Appeal</h4>
                <div className="flex gap-3">
                  <button className="flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
                    <Share2 className="h-4 w-4" />
                    Share
                  </button>
                </div>
              </div>
            </div>

            {/* Donation sidebar */}
            <div className="lg:col-span-1">
              <div className="sticky top-24 rounded-2xl bg-white shadow-xl ring-1 ring-slate-200 p-6">
                {/* Progress */}
                <div className="mb-6">
                  <div className="flex justify-between text-sm mb-2">
                    <span className="font-semibold text-slate-900">
                      £{appeal.raised.toLocaleString()} raised
                    </span>
                    <span className="text-slate-500">
                      of £{appeal.goal.toLocaleString()}
                    </span>
                  </div>
                  <div className="h-3 bg-slate-100 rounded-full overflow-hidden">
                    <div
                      className="h-full bg-gradient-to-r from-orange-500 to-orange-600 rounded-full transition-all duration-500"
                      style={{ width: `${Math.min(progress, 100)}%` }}
                    />
                  </div>
                  <p className="text-sm text-slate-500 mt-2">{progress}% of goal reached</p>
                </div>

                <h3 className="text-lg font-bold text-slate-900 mb-4">Make a Donation</h3>

                {/* Amount selector */}
                <div className="grid grid-cols-2 gap-2 mb-4">
                  {presetAmounts.map((amount) => (
                    <button
                      key={amount}
                      className="py-3 rounded-xl text-sm font-bold bg-slate-100 text-slate-700 hover:bg-orange-100 hover:text-orange-700 transition-colors"
                    >
                      £{amount}
                    </button>
                  ))}
                </div>

                {/* Custom amount */}
                <div className="relative mb-6">
                  <span className="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">£</span>
                  <input
                    type="number"
                    placeholder="Other amount"
                    className="w-full rounded-xl border-2 border-slate-200 py-3 pl-8 pr-4 focus:border-orange-500 focus:outline-none focus:ring-4 focus:ring-orange-500/10"
                  />
                </div>

                {/* Donate button */}
                <button className="w-full rounded-xl bg-gradient-to-r from-amber-500 to-orange-600 py-4 text-lg font-bold text-white shadow-lg hover:shadow-xl hover:scale-[1.02] active:scale-[0.98] transition-all">
                  Donate Now
                </button>

                {/* Trust */}
                <p className="text-xs text-slate-500 text-center mt-4">
                  100% Donation Policy • Secure Payment • Tax Deductible
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Related appeals */}
      <section className="py-12 md:py-16 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h2 className="text-2xl font-bold text-slate-900 mb-8">Other Ways to Help</h2>
          <div className="grid sm:grid-cols-3 gap-6">
            {relatedAppeals.map((related) => (
              <Link
                key={related.id}
                to={`/appeals/${related.slug}`}
                className="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow"
              >
                <div className="aspect-[16/9] overflow-hidden">
                  <img
                    src={related.image}
                    alt={related.title}
                    className="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500"
                  />
                </div>
                <div className="p-5">
                  <h3 className="font-bold text-slate-900 group-hover:text-orange-600 transition-colors">
                    {related.title}
                  </h3>
                  <p className="text-sm text-slate-600 mt-1 line-clamp-2">{related.description}</p>
                </div>
              </Link>
            ))}
          </div>
        </div>
      </section>
    </div>
  );
}

export default AppealDetail;
