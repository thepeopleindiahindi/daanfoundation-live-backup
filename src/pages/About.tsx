import { Heart, Users, Globe, Award, Target, Clock } from "lucide-react";
import Header from "../components/layout/Header";

/* ─── About Page Structure ─────────────────────────────────────────────── */
export function About() {
  return (
    <div className="min-h-screen bg-white">
      <Header />

      {/* SECTION: Hero */}
      <section className="relative py-20 md:py-28 overflow-hidden">
        <div className="absolute inset-0 bg-gradient-to-br from-orange-600 to-orange-700" />
        <div className="absolute inset-0 opacity-10" style={{
          backgroundImage: `url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M20 20.5V18H0v-2h20v-2H0v-2h20V9.5a2.5 2.5 0 015 0V12h15v2H25v2h15v2H25v2.5a2.5 2.5 0 11-5 0z' fill='%23ffffff' fill-opacity='1' fill-rule='evenodd'/%3E%3C/svg%3E")`,
        }} />
        
        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <span className="inline-block rounded-full bg-white/20 px-4 py-1.5 text-sm font-semibold text-white mb-6">
            Est. 2020
          </span>
          <h1 className="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
            Serving Humanity{" "}
            <span className="text-amber-300">With Compassion</span>
          </h1>
          <p className="text-xl text-white/90 max-w-2xl mx-auto leading-relaxed">
            Daan Foundation connects your generosity with communities in need, 
            ensuring every donation reaches those who need it most.
          </p>
        </div>
      </section>

      {/* SECTION: Mission & Values */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            {/* Left: Image */}
            <div className="relative">
              <div className="aspect-[4/3] rounded-3xl overflow-hidden">
                <img 
                  src="/images/food-distribution-ramadan.jpg" 
                  alt="Food distribution during Ramadan" 
                  className="h-full w-full object-cover"
                />
              </div>
              {/* Floating stat card */}
              <div className="absolute -bottom-6 -right-6 bg-white rounded-2xl shadow-xl p-6 hidden md:block">
                <div className="text-4xl font-bold text-orange-600 mb-1">2.5M+</div>
                <div className="text-sm text-slate-600">People helped</div>
              </div>
            </div>

            {/* Right: Content */}
            <div>
              <h2 className="text-3xl md:text-4xl font-bold text-slate-900 mb-6">
                Our Mission
              </h2>
              <p className="text-lg text-slate-600 leading-relaxed mb-6">
                We believe that fulfilling your religious obligations should be simple, 
                transparent, and impactful. Our mission is to bridge the gap between 
                donors and those in need, ensuring every act of giving creates 
                meaningful change.
              </p>
              <p className="text-lg text-slate-600 leading-relaxed mb-8">
                From Zakat and Sadaqah to emergency relief, we work with trusted 
                partners in over 30 countries to deliver aid where it's needed most.
              </p>

              {/* Values grid */}
              <div className="grid grid-cols-2 gap-4">
                {[
                  { icon: Heart, label: "Compassion" },
                  { icon: Target, label: "Transparency" },
                  { icon: Users, label: "Community" },
                  { icon: Award, label: "Excellence" },
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
              Our Impact
            </h2>
            <p className="text-lg text-slate-600 max-w-2xl mx-auto">
              Your generosity transforms lives around the world
            </p>
          </div>

          <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {[
              { number: "30+", label: "Countries Reached", icon: Globe },
              { number: "2.5M", label: "People Helped", icon: Users },
              { number: "500K", label: "Aid Packages Delivered", icon: Heart },
              { number: "£15M", label: "Raised in 2025", icon: Award },
            ].map(({ number, label, icon: Icon }) => (
              <div key={label} className="bg-white rounded-2xl p-6 text-center shadow-sm">
                <div className="h-14 w-14 rounded-xl bg-gradient-to-br from-orange-600 to-orange-700 flex items-center justify-center mx-auto mb-4">
                  <Icon className="h-7 w-7 text-white" />
                </div>
                <div className="text-3xl md:text-4xl font-bold text-slate-900 mb-1">
                  {number}
                </div>
                <div className="text-sm text-slate-600">{label}</div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* SECTION: Timeline / History */}
      <section className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-slate-900 mb-4">
              Our Journey
            </h2>
            <p className="text-lg text-slate-600 max-w-2xl mx-auto">
              From humble beginnings to global impact
            </p>
          </div>

          <div className="max-w-3xl mx-auto">
            {[
              { year: "2020", title: "Founded", description: "Started with a vision to make charitable giving accessible to everyone." },
              { year: "2021", title: "First Major Campaign", description: "Delivered aid packages to families across 5 countries." },
              { year: "2022", title: "Expanded Operations", description: "Grew to 15 countries and launched our Zakat distribution program." },
              { year: "2023", title: "1 Million Milestone", description: "Reached 1 million people through our various programs." },
              { year: "2024", title: "Emergency Response", description: "Provided critical aid during multiple humanitarian crises." },
              { year: "2025", title: "Stronger Together", description: "Expanded to 30+ countries with £15M raised for those in need." },
            ].map((item, index) => (
              <div key={item.year} className="flex gap-6 mb-8 last:mb-0">
                {/* Timeline line */}
                <div className="flex flex-col items-center">
                  <div className="h-12 w-12 rounded-full bg-gradient-to-br from-orange-600 to-orange-700 flex items-center justify-center shrink-0">
                    <Clock className="h-5 w-5 text-white" />
                  </div>
                  {index < 5 && <div className="w-0.5 flex-1 bg-orange-200 mt-2" />}
                </div>
                {/* Content */}
                <div className="pb-8">
                  <span className="text-sm font-bold text-orange-600">{item.year}</span>
                  <h3 className="text-xl font-bold text-slate-900 mt-1 mb-2">{item.title}</h3>
                  <p className="text-slate-600">{item.description}</p>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* SECTION: Team (Placeholder) */}
      <section className="py-16 md:py-24 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-12">
            <h2 className="text-3xl md:text-4xl font-bold text-slate-900 mb-4">
              Our Leadership
            </h2>
            <p className="text-lg text-slate-600 max-w-2xl mx-auto">
              Dedicated professionals committed to making a difference
            </p>
          </div>

          <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {[
              { name: "Dr. Ahmed Khan", role: "Chief Executive", image: "/images/iftaar-distribution.jpg" },
              { name: "Sarah Johnson", role: "Operations Director", image: "/images/community-queue.jpg" },
              { name: "Mohammed Ali", role: "Programs Lead", image: "/images/aid-distribution-elderly.jpg" },
              { name: "Fatima Hassan", role: "Finance Director", image: "/images/impact-1.jpg" },
            ].map((person) => (
              <div key={person.name} className="bg-white rounded-2xl p-6 text-center shadow-sm">
                {/* Team member image */}
                <div className="h-24 w-24 rounded-full mx-auto mb-4 overflow-hidden">
                  <img src={person.image} alt={person.name} className="h-full w-full object-cover" />
                </div>
                <h3 className="font-bold text-slate-900 mb-1">{person.name}</h3>
                <p className="text-sm text-slate-600">{person.role}</p>
              </div>
            ))}
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
              Whether through donations, volunteering, or spreading awareness, 
              there are many ways to be part of our mission.
            </p>
            <div className="flex flex-wrap justify-center gap-4">
              <a
                href="/donate"
                className="rounded-full bg-white px-8 py-4 text-base font-bold text-orange-600 shadow-xl hover:shadow-2xl hover:scale-105 transition-all"
              >
                Donate Now
              </a>
              <a
                href="/volunteer"
                className="rounded-full bg-white/20 px-8 py-4 text-base font-bold text-white hover:bg-white/30 transition-all"
              >
                Volunteer With Us
              </a>
            </div>
          </div>
        </div>
      </section>

      {/* CONTENT: Footer would go here - use @navigation agent */}
    </div>
  );
}

export default About;
