import { Heart, Users, Award, Target } from "lucide-react";
import { Link } from "react-router-dom";
import Breadcrumbs from "@/components/layout/Breadcrumbs";

/* ─── About Page Structure ─────────────────────────────────────────────── */
export function About() {
  return (
    <div>
      <Breadcrumbs items={[{ label: "About Us" }]} />

      {/* SECTION: Hero */}
      <section className="relative py-20 md:py-28 overflow-hidden">
        <div className="absolute inset-0 bg-gradient-to-br from-orange-600 to-orange-700" />
        
        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <span className="inline-block rounded-full bg-white/20 px-4 py-1.5 text-sm font-semibold text-white mb-6">
            Est. 2020
          </span>
          <h1 className="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
            Serving Humanity{" "}
            <span className="text-amber-300">With Compassion</span>
          </h1>
          <p className="text-xl text-white/90 max-w-2xl mx-auto leading-relaxed">
            Daan Foundation is an India-based charitable and humanitarian organisation committed to 
            helping poor, needy and vulnerable people through food support, community welfare and 
            social assistance programmes.
          </p>
        </div>
      </section>

      {/* SECTION: Mission & Values */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <div className="relative">
              <div className="aspect-[4/3] rounded-3xl overflow-hidden">
                <img 
                  src="/images/food-distribution-ramadan.jpg" 
                  alt="Food distribution during Ramadan" 
                  className="h-full w-full object-cover"
                />
              </div>
              <div className="absolute -bottom-6 -right-6 bg-white rounded-2xl shadow-xl p-6 hidden md:block">
                <div className="text-4xl font-bold text-orange-600 mb-1">500K+</div>
                <div className="text-sm text-slate-600">Meals distributed</div>
              </div>
            </div>

            <div>
              <h2 className="text-3xl md:text-4xl font-bold text-slate-900 mb-6">
                Our Mission
              </h2>
              <p className="text-lg text-slate-600 leading-relaxed mb-6">
                "No person should sleep hungry." This simple but powerful goal remains at the 
                centre of all our humanitarian efforts. Daan Foundation believes that food is one 
                of the most basic human needs.
              </p>
              <p className="text-lg text-slate-600 leading-relaxed mb-8">
                Established during the difficult period of the 2020 pandemic, the foundation began 
                with a simple mission: ensuring that no person sleeps hungry. What started as a small 
                Ramadan iftar initiative planned for only 15 days gradually transformed into a 
                continuous humanitarian effort.
              </p>

              <div className="grid grid-cols-2 gap-4">
                {[
                  { icon: Heart, label: "Compassion" },
                  { icon: Target, label: "Transparency" },
                  { icon: Users, label: "Dignity" },
                  { icon: Award, label: "Service" },
                ].map(({ icon: Icon, label }) => (
                  <div key={label} className="flex items-center gap-3 p-3 rounded-xl bg-[#F3F4F6]">
                    <div className="h-10 w-10 rounded-lg bg-orange-100 flex items-center justify-center">
                      <Icon className="h-5 w-5 text-orange-600" />
                    </div>
                    <span className="font-medium text-slate-900">{label}</span>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* SECTION: Impact Statistics */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-slate-900 mb-4">
              Our Achievements
            </h2>
            <p className="text-lg text-slate-600 max-w-2xl mx-auto">
              Since 2020, Daan Foundation has served communities across India
            </p>
          </div>

          <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {[
              { number: "500K+", label: "Meals Distributed", icon: Heart },
              { number: "600K+", label: "Beneficiaries Reached", icon: Users },
              { number: "14+", label: "Years of Experience", icon: Award },
              { number: "100K+", label: "Iftar Kits Distributed", icon: Target },
            ].map(({ number, label, icon: Icon }) => (
              <div key={label} className="bg-white rounded-2xl p-6 text-center shadow-sm">
                <div className="h-14 w-14 rounded-xl bg-gradient-to-br from-orange-600 to-orange-700 flex items-center justify-center mx-auto mb-4">
                  <Icon className="h-7 w-7 text-white" />
                </div>
                <div className="text-3xl md:text-4xl font-bold text-slate-900 mb-1">{number}</div>
                <div className="text-sm text-slate-600">{label}</div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* SECTION: Community Kitchen */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="max-w-3xl mx-auto">
            <h2 className="text-3xl md:text-4xl font-bold text-slate-900 mb-6">
              Community Kitchen — Our Core Mission
            </h2>
            <div className="prose prose-lg text-slate-600">
              <p>
                The heart of Daan Foundation is its Community Kitchen. Every evening, freshly prepared 
                meals are distributed free of cost to people facing hunger and hardship. The kitchen 
                serves labourers, elderly citizens, widows, orphans, homeless individuals, poor families, 
                and travellers.
              </p>
              <p>
                People from every religion, caste and background are welcomed equally and treated with 
                dignity and respect. Different meals are prepared regularly, including dal and roti, 
                rice dishes, vegetable curries, seasonal meals, and Ramadan iftar arrangements.
              </p>
              <p>
                The estimated cost of one complete meal is approximately <strong>₹59 per person</strong>.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* SECTION: Our Work Areas */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h2 className="text-3xl font-bold text-slate-900 mb-8 text-center">What We Do</h2>
          <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {[
              "Daily cooked meal distribution",
              "Ramadan iftar programmes",
              "Ration kit distribution",
              "Clothing support",
              "Medical assistance",
              "Educational support",
              "Marriage assistance for poor families",
              "Small livelihood support",
            ].map((item) => (
              <div key={item} className="bg-white rounded-xl p-4 shadow-sm">
                <span className="text-slate-700 font-medium">{item}</span>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* SECTION: Timeline */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-slate-900 mb-4">Our Journey</h2>
            <p className="text-lg text-slate-600">From humble beginnings to serving communities across India</p>
          </div>

          <div className="max-w-3xl mx-auto">
            {[
              { year: "2020", title: "Founded During Ramadan", description: "Started as a small Ramadan iftar initiative for 15 days, transforming into a continuous humanitarian effort." },
              { year: "2021", title: "Growth & Expansion", description: "Expanded food distribution, increased volunteer participation, and established regular Community Kitchen operations." },
              { year: "2023", title: "Official Registration", description: "Formally registered as Daan Foundation, strengthening commitment to structured and transparent charitable work." },
              { year: "2026", title: "Vision Forward", description: "Aiming to provide food to one lakh beneficiaries every day across different vulnerable situations in India." },
            ].map((item, index) => (
              <div key={item.year} className="flex gap-6 mb-8 last:mb-0">
                <div className="flex flex-col items-center">
                  <div className="h-12 w-12 rounded-full bg-gradient-to-br from-orange-600 to-orange-700 flex items-center justify-center shrink-0 text-white text-sm font-bold">
                    {item.year}
                  </div>
                  {index < 3 && <div className="w-0.5 flex-1 bg-orange-200 mt-2" />}
                </div>
                <div className="pb-8">
                  <h3 className="text-xl font-bold text-slate-900 mt-1 mb-2">{item.title}</h3>
                  <p className="text-slate-600">{item.description}</p>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* SECTION: Team & Volunteers */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-slate-900 mb-4">Our Team & Volunteers</h2>
            <p className="text-lg text-slate-600 max-w-2xl mx-auto">
              Daan Foundation is strengthened by dedicated volunteers who continuously support humanitarian activities.
            </p>
          </div>

          <div className="max-w-3xl mx-auto grid sm:grid-cols-2 gap-4">
            {["Faizan Khan", "Mohammad Nadeem Siddiqui", "Maroof", "Shagufta", "Fatima", "Farman Raja", "Adnan Ahmed Khan"].map((name) => (
              <div key={name} className="bg-white rounded-xl p-4 shadow-sm flex items-center gap-3">
                <div className="h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 font-bold text-sm">
                  {name.split(" ").map(n => n[0]).join("")}
                </div>
                <span className="font-medium text-slate-900">{name}</span>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* SECTION: Important Notice */}
      <section className="py-12">
        <div className="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
          <div className="rounded-2xl bg-amber-50 border border-amber-200 p-6">
            <h3 className="font-bold text-amber-900 mb-3">Important Notice</h3>
            <ul className="space-y-2 text-amber-800 text-sm">
              <li>• Daan Foundation works exclusively within India</li>
              <li>• We do not operate outside India</li>
              <li>• We do not conduct international projects</li>
              <li>• We are not authorised to receive foreign donations</li>
              <li>• All charitable activities are focused on Indian communities only</li>
            </ul>
          </div>
        </div>
      </section>

      {/* SECTION: CTA */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="rounded-3xl bg-gradient-to-br from-orange-600 to-orange-700 p-8 md:p-12 text-center">
            <h2 className="text-3xl md:text-4xl font-bold text-white mb-4">
              Join Us in Making a Difference
            </h2>
            <p className="text-lg text-white/90 max-w-2xl mx-auto mb-8">
              Every contribution, volunteer effort and act of kindness helps us move 
              closer to a more compassionate society.
            </p>
            <div className="flex flex-wrap justify-center gap-4">
              <Link
                to="/donate"
                className="rounded-full bg-white px-8 py-4 text-base font-bold text-orange-600 shadow-xl hover:shadow-2xl hover:scale-105 transition-all"
              >
                Donate Now
              </Link>
              <Link
                to="/contact"
                className="rounded-full bg-white/20 px-8 py-4 text-base font-bold text-white hover:bg-white/30 transition-all"
              >
                Get in Touch
              </Link>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
}

export default About;
