import { Link } from "react-router-dom";
import { Mail, Phone, MapPin, Instagram, Youtube, Linkedin, Twitter, Landmark } from "lucide-react";

const footerLinks = {
  appeals: [
    { label: "Community Kitchen", href: "/community-kitchen" },
    { label: "Ramadan Iftar", href: "/ramadan" },
    { label: "Winter Appeal", href: "/winter" },
    { label: "Where Most Needed", href: "/where-most-needed" },
  ],
  giving: [
    { label: "Zakat", href: "/zakat" },
    { label: "Sadaqah", href: "/sadaqah" },
    { label: "Sadaqah Jariyah", href: "/sadaqah-jariyah" },
    { label: "Fidyah", href: "/fidya" },
    { label: "Kaffarah", href: "/kaffarah" },
  ],
  ourWork: [
    { label: "Our Impact", href: "/our-work/impact" },
    { label: "Your Charity in Action", href: "/our-work/charity-in-action" },
    { label: "Community Trust", href: "/our-work/community-trust" },
    { label: "History", href: "/our-work/history" },
    { label: "Annual Report", href: "/our-work/annual-report" },
  ],
  about: [
    { label: "About Us", href: "/about" },
    { label: "Contact Us", href: "/contact" },
    { label: "Bank Details", href: "/bank-details" },
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
              <img
                src="/images/daan-foundation-logo.png"
                alt="Daan Foundation"
                className="h-12 w-auto"
              />
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
              <a href="tel:+918899152910" className="flex items-center gap-2 hover:text-orange-400 transition-colors">
                <Phone className="h-4 w-4" />
                +91 88991 52910
              </a>
              <a href="mailto:daanfoundationindia@gmail.com" className="flex items-center gap-2 hover:text-orange-400 transition-colors">
                <Mail className="h-4 w-4" />
                daanfoundationindia@gmail.com
              </a>
              <div className="flex items-start gap-2">
                <MapPin className="h-4 w-4 mt-0.5 shrink-0" />
                <span>Katkoi Street, Near DiwanKhana,<br />Plot No. 141, District Amroha,<br />Uttar Pradesh - 244221, India</span>
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
            <h4 className="font-bold text-white mb-4">Our Work</h4>
            <ul className="space-y-2">
              {footerLinks.ourWork.map((link) => (
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

      {/* Bank Details section */}
      <div className="border-t border-slate-800">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
          <div className="grid md:grid-cols-2 gap-8 items-start">
            <div>
              <h4 className="font-bold text-white mb-4 flex items-center gap-2">
                <Landmark className="h-5 w-5 text-orange-400" />
                Bank Details
              </h4>
              <div className="grid grid-cols-2 gap-x-6 gap-y-2 text-sm text-slate-400">
                <span className="text-slate-500">Bank Name:</span>
                <span>State Bank of India</span>
                <span className="text-slate-500">Account Name:</span>
                <span>Daan Foundation</span>
                <span className="text-slate-500">Account No:</span>
                <span>42818355421</span>
                <span className="text-slate-500">IFSC Code:</span>
                <span>SBIN0003448</span>
                <span className="text-slate-500">Branch:</span>
                <span>Amroha, UP</span>
                <span className="text-slate-500">UPI ID:</span>
                <span>42818355421@sbi</span>
              </div>
            </div>
            <div className="flex flex-col items-center md:items-end">
              <p className="text-sm text-slate-500 mb-2">Scan to Pay via UPI</p>
              <div className="h-32 w-32 bg-white rounded-xl flex items-center justify-center text-slate-400 text-xs text-center p-2">
                UPI QR Code
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Bottom bar */}
      <div className="border-t border-slate-800">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
          <div className="flex flex-col md:flex-row items-center justify-between gap-4">
            <div className="flex flex-wrap items-center gap-4 text-sm text-slate-500">
              <span>© 2026 Daan Foundation. Registered Charity No. 124456</span>
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
