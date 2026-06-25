import { Link } from "react-router-dom";
import { ArrowRight, Utensils, Heart, Users, BookOpen, ShieldCheck, Eye, Target, Award, UserCheck } from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";
import ProjectPageLayout from "@/components/donation/ProjectPageLayout";

const trustees = [
  { name: "Mr. Ahmad Raza Khan", role: "Chairperson / Settler" },
  { name: "Mr. Anees Ahmad Siddiqui", role: "Vice Chairman / Trustee" },
  { name: "Mr. Farman Raza Khan", role: "General Secretary / Trustee" },
  { name: "Mr. Adnan Ahmad Khan", role: "Treasurer / Trustee" },
  { name: "Mr. Fareed Uddin Siddiqui", role: "Trustee / Member" },
];

const values = [
  { icon: Heart, title: "Compassion", desc: "We believe every human life matters and strive to reduce suffering wherever possible." },
  { icon: Eye, title: "Transparency", desc: "Every donation is treated as an Amanah (trust) and used responsibly." },
  { icon: UserCheck, title: "Dignity", desc: "Every individual deserves respect, regardless of their background." },
  { icon: Target, title: "Service", desc: "We are driven by a spirit of selfless service and humanity." },
  { icon: ShieldCheck, title: "Responsibility", desc: "We ensure careful and honest use of resources for maximum impact." },
];

export function About() {
  return (
    <div>
      <SEO title="About Us - Daan Foundation" description="Daan Foundation is an India-based charitable organisation serving humanity with compassion since 2020. Learn about our mission, values, and impact." canonical="/about" />
      <Breadcrumbs items={[{ label: "About Us" }]} />

      <section className="relative bg-gradient-to-br from-orange-600 to-orange-700">
        <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 md:py-16">
          <div className="max-w-3xl">
            <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-4">About Us</h1>
            <p className="text-xl text-white/90 leading-relaxed max-w-2xl">Daan Foundation &ndash; Serving Humanity With Compassion Since 2020</p>
          </div>
        </div>
      </section>

      <ProjectPageLayout defaultCause="where-needed">
        <div className="space-y-10">

          <div className="rounded-2xl overflow-hidden shadow-lg">
            <img src="/images/about-hero.jpg" alt="About Daan Foundation" className="w-full h-[300px] md:h-[400px] object-cover" />
          </div>

          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Our Story</h2>
            <p className="text-slate-600 leading-relaxed">
              Daan Foundation is an India-based charitable and humanitarian organization committed to supporting poor, needy, and vulnerable communities through food assistance, social welfare, and community support programs.
            </p>
            <p className="text-slate-600 leading-relaxed mt-4">
              The foundation was established during the challenging period of the 2020 pandemic, with a simple yet powerful mission:
            </p>
            <div className="bg-orange-50 rounded-2xl p-6 text-center mt-4">
              <p className="text-2xl font-bold text-orange-700">&ldquo;No person should sleep hungry.&rdquo;</p>
            </div>
            <p className="text-slate-600 leading-relaxed mt-4">
              What began as a small Ramadan Iftar initiative planned for just 15 days gradually evolved into a continuous humanitarian effort. With the help of Allah and the trust of kind-hearted supporters, this initiative expanded into a daily Community Kitchen, which continues to serve people every evening.
            </p>
          </section>

          <div className="border-t border-slate-200" />

          {/* Important Notice */}
          <section className="bg-amber-50 rounded-2xl p-6 md:p-8 border border-amber-200">
            <div className="flex items-start gap-4">
              <BookOpen className="h-6 w-6 text-amber-600 flex-shrink-0 mt-1" />
              <div>
                <h3 className="font-bold text-slate-900 text-lg">Important Notice</h3>
                <ul className="mt-2 space-y-1 text-slate-600">
                  <li>Daan Foundation operates strictly within India.</li>
                  <li>We do not work outside India.</li>
                  <li>We do not run international projects.</li>
                  <li>We are not authorized to receive foreign donations.</li>
                  <li>All activities are focused entirely on Indian communities.</li>
                </ul>
              </div>
            </div>
          </section>

          <div className="border-t border-slate-200" />

          {/* Our Journey */}
          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Our Journey</h2>
            <p className="text-slate-600 leading-relaxed">
              During the nationwide lockdown in 2020, thousands of daily wage earners, labourers, and underprivileged families struggled to arrange even basic meals. Seeing this hardship, a small group of individuals came forward to distribute food and Iftar meals among those in need.
            </p>
            <p className="text-slate-600 leading-relaxed mt-4">
              At that time, there was no office, no structured system, no long-term planning — only sincerity, trust, and the intention to help.
            </p>
            <p className="text-slate-600 leading-relaxed mt-4">
              With continuous public support and growing need, Daan Foundation gradually expanded its activities into:
            </p>
            <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
              {[
                { icon: Utensils, label: "Daily cooked meal distribution" },
                { icon: Heart, label: "Ramadan Iftar programs" },
                { icon: Users, label: "Ration kit distribution" },
                { icon: UserCheck, label: "Clothing support" },
                { icon: ShieldCheck, label: "Medical assistance" },
                { icon: Award, label: "Educational support" },
              ].map(({ icon: Icon, label }) => (
                <div key={label} className="flex items-center gap-3 bg-white rounded-xl p-4 shadow-sm border border-slate-100">
                  <Icon className="h-5 w-5 text-orange-500 flex-shrink-0" />
                  <span className="text-slate-700 font-medium">{label}</span>
                </div>
              ))}
            </div>
          </section>

          <div className="border-t border-slate-200" />

          {/* Community Kitchen */}
          <section className="bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Community Kitchen &mdash; Our Core Mission</h2>
            <p className="text-slate-600">The Community Kitchen is the heart of Daan Foundation. Every evening, freshly prepared meals are provided free of cost to those facing hunger and hardship.</p>
            <div className="grid grid-cols-2 md:grid-cols-4 gap-3 mt-4">
              {["Labourers", "Elderly individuals", "Widows", "Orphans", "Homeless persons", "Poor families", "Travellers", "Anyone in need"].map((item) => (
                <div key={item} className="bg-white rounded-xl px-3 py-2 shadow-sm text-center text-sm font-medium text-slate-700">
                  {item}
                </div>
              ))}
            </div>
            <p className="text-slate-600 mt-4">People from every religion, caste, and background are welcomed without any discrimination, with dignity and respect. Meals include dal &amp; roti, rice-based meals, vegetable curries, seasonal food items, and special Ramadan Iftar meals.</p>
            <p className="text-2xl font-bold text-orange-600 bg-white rounded-xl p-4 text-center mt-4">500,000+ meals served since 2020 &mdash; ₹59 per meal</p>
          </section>

          <div className="border-t border-slate-200" />

          {/* Our Mission */}
          <section className="bg-slate-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Our Mission</h2>
            <p className="text-xl font-bold text-slate-800 mb-4">&ldquo;Ensuring that no one sleeps hungry.&rdquo;</p>
            <p className="text-slate-600">Food is one of the most basic human needs. Without it, a person cannot focus on health, education, or livelihood. Our primary mission is to feed the hungry every single day.</p>
            <p className="text-slate-600 mt-4">Alongside this, we also support communities through healthcare assistance, educational support, women support initiatives, marriage support for underprivileged families, emergency relief efforts, and livelihood opportunities for self-reliance. Our aim is not only to provide temporary relief but also to help people regain stability, dignity, and hope.</p>
          </section>

          <div className="border-t border-slate-200" />

          {/* Our Values */}
          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Our Values</h2>
            <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
              {values.map(({ icon: Icon, title, desc }) => (
                <div key={title} className="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
                  <Icon className="h-6 w-6 text-orange-500 mb-3" />
                  <h3 className="font-bold text-slate-900 mb-1">{title}</h3>
                  <p className="text-sm text-slate-600">{desc}</p>
                </div>
              ))}
            </div>
          </section>

          <div className="border-t border-slate-200" />

          {/* Achievements */}
          <section className="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Our Achievements</h2>
            <p className="text-slate-600 mb-4">Since 2020, Daan Foundation has:</p>
            <div className="grid sm:grid-cols-2 gap-3">
              {[
                "Served 500,000+ meals",
                "Organized large-scale Ramadan Iftar programs",
                "Distributed food and ration kits",
                "Supported widows and elderly individuals",
                "Helped children and struggling families",
                "Built a strong volunteer-driven community initiative",
              ].map((item) => (
                <div key={item} className="flex items-center gap-2 bg-white rounded-xl px-4 py-3 shadow-sm">
                  <span className="text-emerald-600 font-bold">&check;</span>
                  <span className="text-sm text-slate-700">{item}</span>
                </div>
              ))}
            </div>
            <p className="text-slate-600 mt-4">What started as a small effort has now become a trusted and growing humanitarian movement.</p>
          </section>

          <div className="border-t border-slate-200" />

          {/* Trustees */}
          <section>
            <h2 className="text-3xl font-bold text-slate-900 mb-6">Our Leadership (Trustees)</h2>
            <p className="text-slate-600 mb-6">Daan Foundation is guided by a committed leadership team dedicated to transparency, accountability, and service.</p>
            <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
              {trustees.map(({ name, role }) => (
                <div key={name} className="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
                  <div className="h-12 w-12 rounded-full bg-orange-100 flex items-center justify-center mb-3">
                    <span className="text-orange-600 font-bold text-lg">{name.charAt(0)}</span>
                  </div>
                  <h3 className="font-bold text-slate-900">{name}</h3>
                  <p className="text-sm text-slate-500">{role}</p>
                </div>
              ))}
            </div>
          </section>

          <div className="border-t border-slate-200" />

          {/* Volunteers */}
          <section className="bg-slate-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Our Volunteers</h2>
            <p className="text-slate-600">Daan Foundation is powered by dedicated volunteers who selflessly contribute their time and effort. Volunteers such as Faizan Khan, Mohammad Nadeem Siddiqui, Mohd. Maroof, Kamar Aalam, Talib Siddiqui, Asma Khan, Rifaty Zia, Shagu, and many others continue to support our mission. Their efforts reflect the true spirit of humanity, unity, and collective responsibility.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-blue-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Serving With Dignity</h2>
            <p className="text-slate-600">We believe that help should always be given with respect and care. Whether it is a hungry labourer, an elderly widow, a struggling mother, a child in need, or a poor family during Ramadan — our goal is to ensure that no one feels neglected, and everyone receives support with dignity.</p>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl p-6 md:p-8">
            <h2 className="text-2xl font-bold text-slate-900 mb-4">Looking Ahead</h2>
            <p className="text-slate-600 mb-4">Daan Foundation aims to expand its reach across India while staying focused on its core mission:</p>
            <div className="grid sm:grid-cols-2 gap-3">
              {[
                "Expand Community Kitchen services",
                "Reach more underserved areas",
                "Strengthen ration and food distribution",
                "Increase education and healthcare support",
                "Promote livelihood initiatives",
                "Build stronger community partnerships",
              ].map((item) => (
                <div key={item} className="flex items-center gap-2 bg-white rounded-xl px-4 py-3 shadow-sm">
                  <Target className="h-4 w-4 text-emerald-600 flex-shrink-0" />
                  <span className="text-sm text-slate-700">{item}</span>
                </div>
              ))}
            </div>
          </section>

          <div className="border-t border-slate-200" />

          <section className="bg-gradient-to-r from-orange-600 to-orange-700 rounded-2xl p-8 md:p-10 text-center">
            <h2 className="text-3xl font-bold text-white mb-4">Together, We Can Build a Hunger-Free India</h2>
            <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">Daan Foundation stands as a symbol of hope, compassion, and responsibility. From a small Ramadan initiative to a continuous humanitarian effort, the journey reflects the power of sincerity, trust, and collective kindness.</p>
            <Link to="/donate" className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-orange-600 hover:shadow-lg transition-shadow">
              Support Our Mission <ArrowRight className="h-5 w-5" />
            </Link>
          </section>

        </div>
      </ProjectPageLayout>
    </div>
  );
}

export default About;
