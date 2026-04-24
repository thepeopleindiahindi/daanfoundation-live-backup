// Route constants for the Qurbani Easy website
export const ROUTES = {
  // Core
  HOME: "/",
  DONATE: "/donate",

  // Appeals
  APPEALS: "/appeals",
  APPEAL_DETAIL: "/appeals/:slug",
  QURBANI: "/qurbani",
  RAMADAN: "/ramadan",
  WINTER: "/winter",

  // Islamic Giving
  ZAKAT: "/zakat",
  ZAKAT_CALCULATOR: "/zakat-calculator",
  SADAQAH: "/sadaqah",
  SADAQAH_JARIYAH: "/sadaqah-jariyah",
  FIDYA: "/fidya",
  KAFFARAH: "/kaffarah",
  WHERE_MOST_NEEDED: "/where-most-needed",
  AQIQAH: "/aqiqah",

  // Programs
  ORPHAN_SPONSORSHIP: "/orphan-sponsorship",
  WATER: "/water",
  FOOD: "/food",
  LIVELIHOODS: "/livelihoods",
  EDUCATION: "/education",
  EMERGENCY_RESPONSE: "/emergency-response",

  // About & Content
  ABOUT: "/about",
  WHERE_WE_WORK: "/where-we-work",
  IMPACT: "/impact",
  REPORTS: "/reports",
  OUR_HISTORY: "/our-history",

  // News
  NEWS: "/news",
  NEWS_DETAIL: "/news/:slug",

  // Utility
  CONTACT: "/contact",
  PRIVACY: "/privacy",
  TERMS: "/terms",
  VOLUNTEER: "/volunteer",

  // Resources
  ISLAMIC_RESOURCES: "/islamic-resources",
  KNOWLEDGE_BASE: "/knowledge-base",
} as const;

// Helper to generate dynamic routes
export const getAppealUrl = (slug: string) => `/appeals/${slug}`;
export const getNewsUrl = (slug: string) => `/news/${slug}`;
