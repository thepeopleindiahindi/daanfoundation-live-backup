import { Link } from "react-router-dom";
import {
  ArrowRight,
  GraduationCap,
  BookOpen,
  Users,
  PenTool,
  CheckCircle2,
  Target,
  TrendingUp,
  Search,
} from "lucide-react";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";
import { DonationSidebar } from "@/components/donation/DonationSidebar";

const stats = [
  { number: "200+", label: "Students Supported", icon: GraduationCap },
  { number: "Regular", label: "School Supplies", icon: PenTool },
  { number: "Ongoing", label: "Fee Assistance", icon: BookOpen },
  { number: "Complete", label: "Books & Uniforms", icon: Users },
];

const whatWeProvide = [
  { item: "School Fees", description: "Covering tuition and examination fees for deserving students from low-income families." },
  { item: "Textbooks", description: "Providing all required textbooks and reference materials for the academic year." },
  { item: "Stationery", description: "Notebooks, pens, pencils, geometry sets, and other essential school supplies." },
  { item: "School Uniforms", description: "Complete uniform sets including shoes and socks so children can attend school with confidence." },
  { item: "Exam Preparation Support", description: "Additional resources and guidance for board exam preparation and competitive tests." },
];

const ourApproach = [
  {
    icon: Search,
    title: "Identify Deserving Students",
    description:
      "We work with schools, community leaders, and local organizations to identify children whose education is at risk due to financial constraints.",
  },
  {
    icon: Target,
    title: "Assess Family Condition",
    description:
      "Our team conducts a thorough but sensitive assessment of each family's financial situation to ensure support reaches those who need it most.",
  },
  {
    icon: BookOpen,
    title: "Provide Targeted Support",
    description:
      "Based on individual needs, we provide customized support — some families need fee assistance, others need uniforms, many need comprehensive support.",
  },
  {
    icon: TrendingUp,
    title: "Monitor Academic Progress",
    description:
      "We stay connected with students and their schools to track academic performance and ensure that our support is making a real difference.",
  },
];

export function EducationalSupport() {
  return (
    <div>
      <SEO title="Educational Support - Empowering Through Education" description="Daan Foundation helps children from poor families continue education with school supplies, books, uniforms, fee support, and mentorship programs across India." canonical="/our-work/educational-support" keywords="education charity India, school fee support, books uniform donation, children education help" />
      <Breadcrumbs
        items={[
          { label: "Our Work", href: "/our-work/charity-in-action" },
          { label: "Educational Support" },
        ]}
      />

      {/* Hero */}
      <section className="relative py-20 md:py-28 bg-gradient-to-br from-indigo-600 to-violet-600">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            <div>
              <h1 className="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-6">
                Educational Support
              </h1>
              <p className="text-2xl text-white/95 font-semibold mb-4">
                Helping Children Continue Their Education
              </p>
              <p className="text-lg text-white/85 leading-relaxed mb-8">
                Education is the most powerful tool to break the cycle of poverty. Daan Foundation helps children from
                poor families continue their education by providing school supplies, books, uniforms, fee support, and
                mentorship — bridging the gap between poverty and opportunity.
              </p>
              <Link
                to="/donate"
                className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-indigo-600 hover:shadow-lg transition-shadow"
              >
                Support Education
                <ArrowRight className="h-5 w-5" />
              </Link>
            </div>
            <div className="hidden lg:block">
              <img
                src="/images/extra-3.jpg"
                alt="Educational support program"
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
                <Icon className="h-8 w-8 text-indigo-400 mx-auto mb-2" />
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

            {/* Breaking the Cycle */}
            <section>
              <h2 className="text-3xl font-bold text-slate-900 mb-6">Breaking the Cycle of Poverty</h2>
              <div className="prose prose-lg text-slate-600">
                <p>
                  In many communities, children are forced to drop out of school not because they lack ability or desire,
                  but because their families simply cannot afford it. The cost of school fees, books, uniforms, and
                  supplies creates an insurmountable barrier for families already struggling to put food on the table.
                </p>
                <p>
                  When a child drops out, the cycle of poverty deepens. Without education, they face the same limited
                  opportunities as their parents — the same daily wage work, the same financial struggles, the same
                  inability to provide for the next generation.
                </p>
                <p>
                  Daan Foundation believes that every child deserves the chance to learn, grow, and build a better future.
                  Our Educational Support program identifies children at risk of dropping out and provides the resources
                  they need to stay in school and succeed.
                </p>
              </div>
            </section>

            <div className="border-t border-slate-200" />

            {/* What We Provide */}
            <section>
              <h2 className="text-3xl font-bold text-slate-900 mb-4">What We Provide</h2>
              <p className="text-lg text-slate-600 mb-8">
                Our support is comprehensive — we address every barrier that stands between a child and their education.
              </p>
              <div className="grid md:grid-cols-2 gap-4">
                {whatWeProvide.map((item) => (
                  <div key={item.item} className="bg-white rounded-xl p-5 shadow-sm border border-slate-100">
                    <div className="flex items-start gap-3">
                      <CheckCircle2 className="h-6 w-6 text-indigo-600 flex-shrink-0 mt-0.5" />
                      <div>
                        <h3 className="font-bold text-slate-900 mb-1">{item.item}</h3>
                        <p className="text-sm text-slate-600">{item.description}</p>
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
                We follow a structured process to ensure our support reaches the right students and makes a lasting impact.
              </p>
              <div className="grid md:grid-cols-2 gap-6">
                {ourApproach.map((step, index) => (
                  <div key={step.title} className="text-center p-6 rounded-2xl border border-slate-200 bg-white">
                    <div className="inline-flex items-center justify-center w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 font-bold text-lg mb-4">
                      {index + 1}
                    </div>
                    <step.icon className="h-8 w-8 text-indigo-600 mx-auto mb-3" />
                    <h3 className="text-lg font-bold text-slate-900 mb-2">{step.title}</h3>
                    <p className="text-sm text-slate-600">{step.description}</p>
                  </div>
                ))}
              </div>
            </section>

            <div className="border-t border-slate-200" />

            {/* Mentorship */}
            <section className="bg-[#F3F4F6] rounded-2xl p-6 md:p-8">
              <div className="text-center">
                <GraduationCap className="h-12 w-12 text-indigo-600 mx-auto mb-6" />
                <h2 className="text-3xl font-bold text-slate-900 mb-6">Mentorship & Guidance</h2>
                <p className="text-lg text-slate-600 mb-4">
                  Beyond material support, we believe in nurturing potential. Our mentorship program connects students from
                  underprivileged backgrounds with volunteers and professionals who guide them through academic challenges,
                  career choices, and personal development.
                </p>
                <p className="text-slate-600">
                  Many first-generation learners lack the guidance that comes naturally in educated families. Our mentors
                  fill that gap — helping students set goals, prepare for exams, and dream bigger than their circumstances
                  might suggest.
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
      <section className="py-16 md:py-20 bg-gradient-to-br from-indigo-600 to-violet-600">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-3xl font-bold text-white mb-4">Invest in a Child's Future</h2>
          <p className="text-lg text-white/90 mb-8 max-w-2xl mx-auto">
            Your donation can keep a child in school, provide them with books and supplies, and open doors that poverty
            would otherwise keep shut. Education changes everything — one student at a time.
          </p>
          <Link
            to="/donate"
            className="inline-flex items-center gap-2 rounded-full bg-white px-8 py-4 font-bold text-indigo-600 hover:shadow-lg transition-shadow"
          >
            Donate Now
            <ArrowRight className="h-5 w-5" />
          </Link>
        </div>
      </section>
    </div>
  );
}

export default EducationalSupport;
