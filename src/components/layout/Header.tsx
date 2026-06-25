import { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import { Menu, X, ChevronDown, Search } from "lucide-react";

/* ─── Navigation Structure ─────────────────────────────────────────────── */
const navItems = [
  {
    label: "Appeals",
    href: "/appeals",
    megaMenu: {
      featured: {
        title: "Community Kitchen",
        description: "Free food for everyone, every day",
        href: "/community-kitchen",
        gradient: "from-amber-500 to-orange-600",
      },
      columns: [
        {
          heading: "Emergency Appeal",
          links: [
            { label: "Community Kitchen", href: "/community-kitchen" },
          ],
        },
        {
          heading: "Seasonal Giving",
          links: [
            { label: "Ramadan Iftar", href: "/ramadan" },
            { label: "Winter Appeal", href: "/winter" },
          ],
        },
      ],
    },
  },
  {
    label: "Ways to Give",
    href: "/zakat",
    megaMenu: {
      featured: {
        title: "Zakat Calculator",
        description: "Calculate your Zakat obligation",
        href: "/zakat-calculator",
        gradient: "from-orange-500 to-orange-600",
      },
      columns: [
        {
          heading: "Islamic Giving",
          links: [
            { label: "Zakat", href: "/zakat" },
            { label: "Sadaqah", href: "/sadaqah" },
            { label: "Sadaqah Jariyah", href: "/sadaqah-jariyah" },
            { label: "Fidyah", href: "/fidya" },
            { label: "Kaffarah", href: "/kaffarah" },
          ],
        },
        {
          heading: "Programs",
          links: [
            { label: "Community Kitchen", href: "/community-kitchen" },
            { label: "Ramadan Iftar Program", href: "/ramadan" },
            { label: "Winter Relief", href: "/winter" },
            { label: "Eid Gifts", href: "/eid-gifts" },
            { label: "Where Most Needed", href: "/where-most-needed" },
            { label: "Orphan Sponsorship", href: "/orphan-sponsorship" },
            { label: "Water for Life", href: "/water" },
          ],
        },
      ],
    },
  },
  {
    label: "Our Work",
    href: "/our-work/impact",
    megaMenu: {
      columns: [
        {
          heading: "Impact for Good",
          links: [
            { label: "Our Impact", href: "/our-work/impact" },
            { label: "Your Charity in Action", href: "/our-work/charity-in-action" },
            { label: "Community Trust & Feedback", href: "/our-work/community-trust" },
            { label: "The History of Daan Foundation", href: "/our-work/history" },
            { label: "Annual Impact Report", href: "/our-work/annual-report" },
          ],
        },
        {
          heading: "Stories & Values",
          links: [
            { label: "Serving With Dignity", href: "/our-work/serving-with-dignity" },
            { label: "Supporting Women With Dignity", href: "/our-work/supporting-women" },
            { label: "Your Donation Is a Trust", href: "/our-work/donation-is-trust" },
            { label: "Empowering Livelihoods", href: "/our-work/empowering-livelihoods" },
            { label: "Why Transparency Matters", href: "/our-work/why-transparency" },
          { label: "Where We Work", href: "/where-we-work" },
          ],
        },
      ],
    },
  },
  { label: "About", href: "/about" },
  { label: "Contact", href: "/contact" },
  { label: "Bank Details", href: "/bank-details" },
];

/* ─── Header Component ─────────────────────────────────────────────────── */
export function Header() {
  const [mobileOpen, setMobileOpen] = useState(false);
  const [scrolled, setScrolled] = useState(false);
  const [activeMenu, setActiveMenu] = useState<string | null>(null);

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 10);
    window.addEventListener("scroll", onScroll, { passive: true });
    return () => window.removeEventListener("scroll", onScroll);
  }, []);

  useEffect(() => {
    const handleClick = () => setActiveMenu(null);
    if (activeMenu) {
      document.addEventListener("click", handleClick);
      return () => document.removeEventListener("click", handleClick);
    }
  }, [activeMenu]);

  return (
    <header
      className={`sticky top-0 z-50 transition-all duration-300 ${
        scrolled ? "shadow-lg" : ""
      }`}
    >
      {/* Main header */}
      <div className="bg-white border-b border-slate-100">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="flex items-center justify-between py-4">
            {/* Logo */}
            <Link to="/" className="flex items-center gap-3 shrink-0">
              <img
                src="/images/daan-foundation-logo.png"
                alt="Daan Foundation"
                className="h-20 w-auto"
              />
              <div className="leading-tight">
                <span className="block text-xl font-bold text-slate-900 tracking-tight">
                  Daan Foundation
                </span>
                <span className="block text-[10px] font-semibold tracking-widest text-slate-500 uppercase">
                  Serving humanity with compassion
                </span>
              </div>
            </Link>

            {/* Desktop navigation */}
            <nav className="hidden lg:flex items-center gap-1">
              {navItems.map((item) => (
                <div
                  key={item.label}
                  className="relative"
                  onMouseEnter={() => item.megaMenu && setActiveMenu(item.label)}
                  onMouseLeave={() => setActiveMenu(null)}
                >
                  <Link
                    to={item.href}
                    className={`flex items-center gap-1 px-4 py-2 text-sm font-semibold rounded-lg transition-colors ${
                      activeMenu === item.label
                        ? "text-orange-500 bg-orange-50"
                        : "text-slate-700 hover:text-orange-500 hover:bg-[#F3F4F6]"
                    }`}
                  >
                    {item.label}
                    {item.megaMenu && (
                      <ChevronDown
                        className={`h-4 w-4 transition-transform ${
                          activeMenu === item.label ? "rotate-180" : ""
                        }`}
                      />
                    )}
                  </Link>

                  {/* Mega Menu Dropdown */}
                  {item.megaMenu && activeMenu === item.label && (
                    <div
                      className="absolute left-0 top-full pt-2 z-50"
                      onClick={(e) => e.stopPropagation()}
                    >
                      <div className="w-[600px] rounded-2xl bg-white shadow-2xl ring-1 ring-slate-200 overflow-hidden">
                        <div className="grid grid-cols-3 gap-0">
                          {/* Featured section */}
                          {item.megaMenu.featured && (
                            <Link
                              to={item.megaMenu.featured.href}
                              className={`col-span-1 p-6 bg-gradient-to-br ${item.megaMenu.featured.gradient} text-white flex flex-col justify-end min-h-[200px]`}
                            >
                              <span className="text-xs font-semibold uppercase tracking-wider text-white/80 mb-1">
                                Featured
                              </span>
                              <span className="text-lg font-bold mb-1">
                                {item.megaMenu.featured.title}
                              </span>
                              <span className="text-sm text-white/90">
                                {item.megaMenu.featured.description}
                              </span>
                            </Link>
                          )}

                          {/* Link columns */}
                          <div className={`${item.megaMenu.featured ? "col-span-2" : "col-span-3"} p-6 grid grid-cols-2 gap-6`}>
                            {item.megaMenu.columns.map((col, idx) => (
                              <div key={idx}>
                                <h4 className="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">
                                  {col.heading}
                                </h4>
                                <ul className="space-y-2">
                                  {col.links.map((link) => (
                                    <li key={link.href}>
                                      <Link
                                        to={link.href}
                                        className="text-sm font-medium text-slate-700 hover:text-orange-500 transition-colors"
                                      >
                                        {link.label}
                                      </Link>
                                    </li>
                                  ))}
                                </ul>
                              </div>
                            ))}
                          </div>
                        </div>
                      </div>
                    </div>
                  )}
                </div>
              ))}
            </nav>

            {/* Right side actions */}
            <div className="flex items-center gap-3">
              <button
                className="hidden sm:flex h-10 w-10 items-center justify-center rounded-full text-slate-600 hover:bg-slate-100 transition-colors"
                aria-label="Search"
              >
                <Search className="h-5 w-5" />
              </button>

              <Link
                to="/donate"
                className="rounded-full bg-[#F97316] hover:bg-orange-600 px-6 py-2.5 text-sm font-bold text-white shadow-md hover:shadow-lg transition-all"
              >
                Donate Now
              </Link>

              <button
                className="lg:hidden ml-1 h-10 w-10 flex items-center justify-center rounded-lg hover:bg-slate-100"
                onClick={() => setMobileOpen(!mobileOpen)}
                aria-label="Toggle menu"
              >
                {mobileOpen ? (
                  <X className="h-6 w-6 text-slate-700" />
                ) : (
                  <Menu className="h-6 w-6 text-slate-700" />
                )}
              </button>
            </div>
          </div>
        </div>
      </div>

      {/* Mobile navigation */}
      {mobileOpen && (
        <div className="lg:hidden fixed inset-0 top-[113px] z-40 bg-white overflow-y-auto">
          <nav className="px-4 py-6 space-y-1">
            {navItems.map((item) => (
              <MobileNavItem key={item.label} item={item} />
            ))}
          </nav>
          <div className="px-4 py-6 border-t border-slate-100">
            <Link
              to="/donate"
              className="block w-full rounded-xl bg-[#F97316] hover:bg-orange-600 py-4 text-center text-lg font-bold text-white shadow-md"
            >
              Donate Now
            </Link>
          </div>
        </div>
      )}
    </header>
  );
}

/* ─── Mobile Nav Item with Accordion ───────────────────────────────────── */
function MobileNavItem({ item }: { item: typeof navItems[0] }) {
  const [expanded, setExpanded] = useState(false);
  const hasChildren = item.megaMenu || item.links;

  if (!hasChildren) {
    return (
      <Link
        to={item.href}
        className="block py-3 px-4 text-lg font-semibold text-slate-800 hover:bg-[#F3F4F6] rounded-xl"
      >
        {item.label}
      </Link>
    );
  }

  const allLinks = item.megaMenu
    ? item.megaMenu.columns.flatMap((col) => col.links)
    : item.links || [];

  return (
    <div>
      <button
        onClick={() => setExpanded(!expanded)}
        className="w-full flex items-center justify-between py-3 px-4 text-lg font-semibold text-slate-800 hover:bg-[#F3F4F6] rounded-xl"
      >
        {item.label}
        <ChevronDown
          className={`h-5 w-5 text-slate-400 transition-transform ${
            expanded ? "rotate-180" : ""
          }`}
        />
      </button>
      {expanded && (
        <div className="ml-4 pl-4 border-l-2 border-orange-200 space-y-1 py-2">
          {allLinks.map((link) => (
            <Link
              key={link.href}
              to={link.href}
              className="block py-2 px-4 text-base text-slate-600 hover:text-orange-500 rounded-lg"
            >
              {link.label}
            </Link>
          ))}
        </div>
      )}
    </div>
  );
}

export default Header;
