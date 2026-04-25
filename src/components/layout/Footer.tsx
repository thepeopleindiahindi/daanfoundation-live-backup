import { Link } from "react-router-dom";
import { Heart, Mail, Phone, MapPin, Instagram, Youtube, Linkedin, Twitter } from "lucide-react";

const footerLinks = {
  appeals: [
    { label: "Palestine Emergency", href: "/appeals/palestine" },
    { label: "Sudan Crisis", href: "/appeals/sudan" },
    { label: "Yemen Emergency", href: "/appeals/yemen" },
    { label: "Where Most Needed", href: "/where-most-needed" },
  ],
  giving: [
    { label: "Zakat", href: "/zakat" },
    { label: "Sadaqah", href: "/sadaqah" },
    { label: "Fidya & Kaffarah", href: "/fidya" },
    { label: "Sponsor an Orphan", href: "/orphan-sponsorship" },
    { label: "Water for Life", href: "/water" },
  ],
  resources: [
    { label: "Zakat Calculator", href: "/zakat-calculator" },
    { label: "Islamic Resources", href: "/islamic-resources" },
    { label: "Knowledge Base", href: "/knowledge-base" },
    { label: "Annual Reports", href: "/reports" },
  ],
  about: [
    { label: "Our Story", href: "/about" },
    { label: "Where We Work", href: "/where-we-work" },
    { label: "Our Impact", href: "/impact" },
    { label: "News", href: "/news" },
    { label: "Contact Us", href: "/contact" },
  ],
};

const socialLinks = [
  { icon: Twitter, href: "https://twitter.com", label: "Twitter" },
  { icon: Instagram, href: "https://instagram.com", label: "Instagram" },
  { icon: Youtube, href: "https://youtube.com", label: "YouTube" },
  { icon: Linkedin, href: "https://linkedin.com", label: "LinkedIn" },
];

export function Footer() {
  return (
    <footer className="bg-slate-900 text-white">
      {/* Newsletter section */}
      <div className="border-b border-slate-800">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
          <div className="grid lg:grid-cols-2 gap-8 items-center">
            <div>
              <h3 className="text-2xl font-bold mb-2">Join Our Newsletter</h3>
              <p className="text-slate-400">
                Stay updated on our campaigns, impact stories, and Islamic giving opportunities.
              </p>
            </div>
            <form className="flex gap-3" onSubmit={(e) => e.preventDefault()}>
              <input
                type="email"
                placeholder="Enter your email"
                className="flex-1 rounded-xl bg-slate-800 border border-slate-700 px-4 py-3 text-white placeholder:text-slate-500 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-400/20"
              />
              <button
                type="submit"
                className="rounded-xl bg-orange-500 hover:bg-orange-600 px-6 py-3 font-semibold text-white transition-colors"
              >
                Subscribe
              </button>
            </form>
          </div>
        </div>
      </div>

      {/* Main footer content */}
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8">
          {/* Logo & contact */}
          <div className="col-span-2">
            <Link to="/" className="flex items-center gap-3 mb-6">
              <div className="h-11 w-11 rounded-xl bg-orange-500 flex items-center justify-center">
                <Heart className="h-6 w-6 text-white" fill="white" />
              </div>
              <div className="leading-tight">
                <span className="block text-xl font-bold text-white tracking-tight">
                  Daan Foundation
                </span>
                <span className="block text-[10px] font-semibold tracking-widest text-slate-500 uppercase">
                  Serving humanity with compassion
                </span>
              </div>
            </Link>
            <div className="space-y-3 text-sm text-slate-400">
              <a href="tel:+441211234567" className="flex items-center gap-2 hover:text-orange-400 transition-colors">
                <Phone className="h-4 w-4" />
                +44 121 123 4567
              </a>
              <a href="mailto:info@daanfoundation.org" className="flex items-center gap-2 hover:text-orange-400 transition-colors">
                <Mail className="h-4 w-4" />
                info@daanfoundation.org
              </a>
              <div className="flex items-start gap-2">
                <MapPin className="h-4 w-4 mt-0.5 shrink-0" />
                <span>123 Charity Lane<br />Birmingham, B1 1AA</span>
              </div>
            </div>
          </div>

          {/* Link columns */}
          <div>
            <h4 className="font-bold text-white mb-4">Appeals</h4>
            <ul className="space-y-2">
              {footerLinks.appeals.map((link) => (
                <li key={link.href}>
                  <Link to={link.href} className="text-sm text-slate-400 hover:text-orange-400 transition-colors">
                    {link.label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          <div>
            <h4 className="font-bold text-white mb-4">Ways to Give</h4>
            <ul className="space-y-2">
              {footerLinks.giving.map((link) => (
                <li key={link.href}>
                  <Link to={link.href} className="text-sm text-slate-400 hover:text-orange-400 transition-colors">
                    {link.label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          <div>
            <h4 className="font-bold text-white mb-4">Resources</h4>
            <ul className="space-y-2">
              {footerLinks.resources.map((link) => (
                <li key={link.href}>
                  <Link to={link.href} className="text-sm text-slate-400 hover:text-orange-400 transition-colors">
                    {link.label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          <div>
            <h4 className="font-bold text-white mb-4">About</h4>
            <ul className="space-y-2">
              {footerLinks.about.map((link) => (
                <li key={link.href}>
                  <Link to={link.href} className="text-sm text-slate-400 hover:text-orange-400 transition-colors">
                    {link.label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>
        </div>
      </div>

      {/* Bottom bar */}
      <div className="border-t border-slate-800">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
          <div className="flex flex-col md:flex-row items-center justify-between gap-4">
            <div className="flex flex-wrap items-center gap-4 text-sm text-slate-500">
              <span>© 2026 Daan Foundation. Registered Charity No. 123456</span>
              <span className="hidden md:inline">•</span>
              <Link to="/privacy" className="hover:text-slate-300">Privacy Policy</Link>
              <Link to="/terms" className="hover:text-slate-300">Terms of Use</Link>
            </div>
            <div className="flex items-center gap-4">
              {socialLinks.map(({ icon: Icon, href, label }) => (
                <a
                  key={label}
                  href={href}
                  target="_blank"
                  rel="noopener noreferrer"
                  aria-label={label}
                  className="h-10 w-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-orange-500 hover:text-white transition-colors"
                >
                  <Icon className="h-5 w-5" />
                </a>
              ))}
            </div>
          </div>
        </div>
      </div>
    </footer>
  );
}

export default Footer;
