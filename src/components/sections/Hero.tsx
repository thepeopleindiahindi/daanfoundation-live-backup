import { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import { ArrowRight } from "lucide-react";

const presetAmounts = [500, 1000, 2500, 5000];
const heroSlides = [
  "/images/hero-slide-1.jpg",
  "/images/hero-slide-2.jpg",
  "/images/hero-slide-3.jpg",
  "/images/hero-slide-4.jpg",
];

export function Hero() {
  const [selectedAmount, setSelectedAmount] = useState<number | null>(1000);
  const [customAmount, setCustomAmount] = useState("");
  const [currentSlide, setCurrentSlide] = useState(0);

  const currentAmount = customAmount ? Number(customAmount) : selectedAmount;

  useEffect(() => {
    const timer = setInterval(() => {
      setCurrentSlide((prev) => (prev + 1) % heroSlides.length);
    }, 3500);
    return () => clearInterval(timer);
  }, []);

  return (
      <section 
        className="relative min-h-[550px] sm:min-h-[650px] md:min-h-[700px] overflow-hidden"
      >
      {/* Slideshow backgrounds */}
      {heroSlides.map((src, index) => (
        <div
          key={src}
          className="hero-slide absolute inset-0 transition-opacity duration-1000 ease-in-out"
          style={{
            backgroundImage: `url(${src})`,
            backgroundSize: 'cover',
            backgroundPosition: 'center',
            opacity: index === currentSlide ? 1 : 0,
          }}
        />
      ))}
      {/* Gradient overlays */}
      <div className="absolute inset-0 bg-gradient-to-r from-slate-900/70 via-slate-900/40 to-transparent" />
      <div className="absolute inset-0 bg-gradient-to-t from-slate-900/50 via-transparent to-transparent" />

      {/* Content */}
      <div className="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        <div className="grid lg:grid-cols-2 gap-12 items-center min-h-[500px]">
          {/* Left: Text content */}
          <div className="text-white">
            <span className="inline-flex items-center gap-2 rounded-full bg-white/20 backdrop-blur-sm px-4 py-1.5 text-sm font-semibold text-white mb-6">
              <span className="h-2 w-2 rounded-full bg-amber-300 animate-pulse" />
              Serving Humanity Since 2020
            </span>

            <h1 className="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold leading-[1.1] tracking-tight mb-6">
              No One Should{" "}
              <span className="text-amber-300">Sleep Hungry</span>
            </h1>

            <p className="text-lg md:text-xl text-white/90 leading-relaxed mb-4 max-w-xl">
              By strengthening our community kitchen and outreach programs, we aim to
              serve 25,000 beneficiaries annually across vulnerable and underserved communities in India.
            </p>

            <p className="text-base text-white/75 leading-relaxed mb-8 max-w-xl">
              Daan Foundation delivers essential food support, community kitchen services,
              and humanitarian aid to families across India, bringing hope and dignity
              to communities in need.
            </p>

            <div className="grid grid-cols-3 gap-4 sm:flex sm:flex-wrap sm:gap-8 mb-8">
              <div>
                <div className="text-xl sm:text-3xl md:text-4xl font-bold text-white">500K+</div>
                <div className="text-[11px] sm:text-sm text-white/70">Meals Distributed</div>
              </div>
              <div>
                <div className="text-xl sm:text-3xl md:text-4xl font-bold text-white">600K+</div>
                <div className="text-[11px] sm:text-sm text-white/70">Beneficiaries Reached</div>
              </div>
              <div>
                <div className="text-xl sm:text-3xl md:text-4xl font-bold text-white">6+</div>
                <div className="text-[11px] sm:text-sm text-white/70">Years of Service</div>
              </div>
            </div>

            <div className="flex flex-wrap items-center gap-4">
              <Link
                to="/about"
                className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 text-base font-bold text-orange-500 shadow-xl hover:shadow-2xl hover:scale-105 transition-all"
              >
                Learn More
                <ArrowRight className="h-5 w-5" />
              </Link>
              <Link
                to="/community-kitchen"
                className="inline-flex items-center gap-2 rounded-full bg-white/20 backdrop-blur-sm px-6 py-3 text-sm font-semibold text-white hover:bg-white/30 transition-all"
              >
                Community Kitchen
                <ArrowRight className="h-4 w-4" />
              </Link>
            </div>
          </div>

          {/* Right: Donation widget */}
          <div className="lg:justify-self-end w-full max-w-md">
            <div className="rounded-2xl bg-white p-6 md:p-8 shadow-2xl">
              <h3 className="text-xl font-bold text-slate-900 text-center mb-2">
                Make a Donation
              </h3>
              <p className="text-sm text-slate-500 text-center mb-6">
                Every contribution makes a difference
              </p>

              {/* Amount selector */}
              <div className="grid grid-cols-2 sm:grid-cols-4 gap-2 mb-4">
                {presetAmounts.map((amount) => (
                  <button
                    key={amount}
                    onClick={() => {
                      setSelectedAmount(amount);
                      setCustomAmount("");
                    }}
                    className={`py-2.5 sm:py-3 rounded-xl text-sm font-bold transition-all ${
                      selectedAmount === amount && !customAmount
                        ? "bg-orange-500 text-white shadow-lg shadow-orange-500/30"
                        : "bg-slate-100 text-slate-700 hover:bg-slate-200"
                    }`}
                  >
                    ₹{amount}
                  </button>
                ))}
              </div>

              {/* Custom amount */}
              <div className="relative mb-6">
                <span className="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-medium">
                  ₹
                </span>
                <input
                  type="number"
                  placeholder="Other amount"
                  value={customAmount}
                  onChange={(e) => {
                    setCustomAmount(e.target.value);
                    setSelectedAmount(null);
                  }}
                  className="w-full rounded-xl border-2 border-slate-200 py-3 pl-8 pr-4 text-lg font-medium text-slate-900 placeholder:text-slate-400 focus:border-orange-400 focus:outline-none focus:ring-4 focus:ring-orange-400/10 transition-all"
                />
              </div>

              {/* Fund selector */}
              <div className="mb-6">
                <label className="block text-sm font-semibold text-slate-700 mb-2">
                  Select a Cause
                </label>
                <select className="w-full rounded-xl border-2 border-slate-200 py-3 px-4 text-slate-900 focus:border-orange-400 focus:outline-none focus:ring-4 focus:ring-orange-400/10">
                  <option>Where Most Needed</option>
                  <option>Community Kitchen</option>
                  <option>Ramadan Iftar</option>
                  <option>Zakat</option>
                  <option>Sadaqah</option>
                </select>
              </div>

              {/* Donate button */}
              <button className="w-full rounded-xl bg-amber-500 hover:bg-amber-600 py-4 text-lg font-bold text-white shadow-md hover:shadow-lg active:scale-[0.98] transition-all">
                Donate {currentAmount ? `₹${currentAmount}` : "Now"}
              </button>

              {/* Trust indicators */}
              <div className="mt-6 flex items-center justify-center gap-4 text-xs text-slate-500">
                <span className="flex items-center gap-1">
                  <svg className="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      fillRule="evenodd"
                      d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                      clipRule="evenodd"
                    />
                  </svg>
                  Secure
                </span>
                <span>•</span>
                <span>Registered Charity</span>
                <span>•</span>
                <span>100% Transparent</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}

export default Hero;
