import { useState } from "react";
import { Link } from "react-router-dom";
import { ArrowRight, Play } from "lucide-react";

const presetAmounts = [50, 100, 200, 500];

export function QurbaniHero() {
  const [selectedAmount, setSelectedAmount] = useState<number | null>(100);
  const [customAmount, setCustomAmount] = useState("");

  const currentAmount = customAmount ? Number(customAmount) : selectedAmount;

  return (
    <section className="relative min-h-[650px] md:min-h-[700px] overflow-hidden">
      {/* Background with image */}
      <div className="absolute inset-0">
        {/* Hero background image */}
        <img 
          src="/images/hero-1.jpg" 
          alt="Community receiving aid" 
          className="absolute inset-0 h-full w-full object-cover"
        />

        {/* Gradient overlays for depth */}
        <div className="absolute inset-0 bg-gradient-to-r from-slate-900/70 via-slate-900/40 to-transparent" />
        <div className="absolute inset-0 bg-gradient-to-t from-slate-900/50 via-transparent to-transparent" />
      </div>

      {/* Content */}
      <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        <div className="grid lg:grid-cols-2 gap-12 items-center min-h-[500px]">
          {/* Left: Text content */}
          <div className="text-white">
            {/* Badge */}
            <span className="inline-flex items-center gap-2 rounded-full bg-white/20 backdrop-blur-sm px-4 py-1.5 text-sm font-semibold text-white mb-6">
              <span className="h-2 w-2 rounded-full bg-amber-300 animate-pulse" />
              Dhul Hijjah 1447 • Limited Time
            </span>

            {/* Headline */}
            <h1 className="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-[1.1] tracking-tight mb-6">
              Share Your{" "}
              <span className="text-amber-300">Qurbani</span>{" "}
              This Eid ul-Adha
            </h1>

            {/* Description */}
            <p className="text-lg md:text-xl text-white/90 leading-relaxed mb-8 max-w-xl">
              Your sacrifice reaches those who need it most. We deliver fresh, 
              nutritious Qurbani meat to families across 30+ countries, ensuring 
              your act of worship brings joy to those in need.
            </p>

            {/* Stats row */}
            <div className="flex flex-wrap gap-8 mb-8">
              <div>
                <div className="text-3xl md:text-4xl font-bold text-white">30+</div>
                <div className="text-sm text-white/70">Countries Reached</div>
              </div>
              <div>
                <div className="text-3xl md:text-4xl font-bold text-white">2.5M</div>
                <div className="text-sm text-white/70">People Fed Last Year</div>
              </div>
              <div>
                <div className="text-3xl md:text-4xl font-bold text-white">100%</div>
                <div className="text-sm text-white/70">Shariah Compliant</div>
              </div>
            </div>

            {/* CTA buttons */}
            <div className="flex flex-wrap items-center gap-4">
              <Link
                to="/qurbani"
                className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 text-base font-bold text-amber-600 shadow-xl hover:shadow-2xl hover:scale-105 transition-all"
              >
                Learn More
                <ArrowRight className="h-5 w-5" />
              </Link>
              <button className="inline-flex items-center gap-2 text-white/90 hover:text-white font-medium transition-colors">
                <span className="flex h-12 w-12 items-center justify-center rounded-full bg-white/20 backdrop-blur-sm">
                  <Play className="h-5 w-5 fill-white text-white ml-0.5" />
                </span>
                Watch Our Story
              </button>
            </div>
          </div>

          {/* Right: Donation widget */}
          <div className="lg:justify-self-end w-full max-w-md">
            <div className="rounded-3xl bg-white p-6 md:p-8 shadow-2xl">
              <h3 className="text-xl font-bold text-slate-900 text-center mb-2">
                Give Your Qurbani
              </h3>
              <p className="text-sm text-slate-500 text-center mb-6">
                Prices from £39 per share
              </p>

              {/* Amount selector */}
              <div className="grid grid-cols-4 gap-2 mb-4">
                {presetAmounts.map((amount) => (
                  <button
                    key={amount}
                    onClick={() => {
                      setSelectedAmount(amount);
                      setCustomAmount("");
                    }}
                    className={`py-3 rounded-xl text-sm font-bold transition-all ${
                      selectedAmount === amount && !customAmount
                        ? "bg-orange-600 text-white shadow-lg shadow-orange-600/30"
                        : "bg-slate-100 text-slate-700 hover:bg-slate-200"
                    }`}
                  >
                    £{amount}
                  </button>
                ))}
              </div>

              {/* Custom amount */}
              <div className="relative mb-6">
                <span className="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-medium">
                  £
                </span>
                <input
                  type="number"
                  placeholder="Other amount"
                  value={customAmount}
                  onChange={(e) => {
                    setCustomAmount(e.target.value);
                    setSelectedAmount(null);
                  }}
                  className="w-full rounded-xl border-2 border-slate-200 py-3 pl-8 pr-4 text-lg font-medium text-slate-900 placeholder:text-slate-400 focus:border-orange-500 focus:outline-none focus:ring-4 focus:ring-orange-500/10 transition-all"
                />
              </div>

              {/* Fund selector */}
              <div className="mb-6">
                <label className="block text-sm font-medium text-slate-700 mb-2">
                  Select Qurbani Type
                </label>
                <select className="w-full rounded-xl border-2 border-slate-200 py-3 px-4 text-slate-900 focus:border-orange-500 focus:outline-none focus:ring-4 focus:ring-orange-500/10">
                  <option>Small Animal (1 share) - £39</option>
                  <option>Large Animal (1/7 share) - £70</option>
                  <option>Whole Cow (7 shares) - £490</option>
                  <option>Where Most Needed</option>
                </select>
              </div>

              {/* Donate button */}
              <button
                className="w-full rounded-xl bg-gradient-to-r from-amber-500 to-orange-600 py-4 text-lg font-bold text-white shadow-lg shadow-amber-500/30 hover:shadow-amber-500/50 hover:scale-[1.02] active:scale-[0.98] transition-all"
              >
                Donate {currentAmount ? `£${currentAmount}` : "Now"}
              </button>

              {/* Trust indicators */}
              <div className="mt-6 flex items-center justify-center gap-4 text-xs text-slate-500">
                <span className="flex items-center gap-1">
                  <svg className="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fillRule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clipRule="evenodd" />
                  </svg>
                  Secure
                </span>
                <span>•</span>
                <span>100% Donation Policy</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Scroll indicator */}
      <div className="absolute bottom-8 left-1/2 -translate-x-1/2 hidden md:flex flex-col items-center gap-2 text-white/60">
        <span className="text-xs font-medium uppercase tracking-wider">Scroll</span>
        <div className="h-12 w-6 rounded-full border-2 border-white/30 flex items-start justify-center p-1.5">
          <div className="h-2 w-1 rounded-full bg-white/60 animate-bounce" />
        </div>
      </div>
    </section>
  );
}

export default QurbaniHero;
