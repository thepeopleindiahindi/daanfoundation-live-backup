// Route constants for the Daan Foundation website
export const ROUTES = {
  // Core
  HOME: "/",
  DONATE: "/donate",

  // Appeals
  APPEALS: "/appeals",
  APPEAL_DETAIL: "/appeals/:slug",
  COMMUNITY_KITCHEN: "/community-kitchen",
  RAMADAN: "/ramadan",
  WINTER: "/winter",
  EID_GIFTS: "/eid-gifts",

  // Islamic Giving
  ZAKAT: "/zakat",
  ZAKAT_CALCULATOR: "/zakat-calculator",
  ZAKAT_AL_FITR: "/zakat-al-fitr",
  SADAQAH: "/sadaqah",
  SADAQAH_JARIYAH: "/sadaqah-jariyah",
  FIDYA: "/fidya",
  KAFFARAH: "/kaffarah",
  WHERE_MOST_NEEDED: "/where-most-needed",

  // Our Work
  OUR_IMPACT: "/our-work/impact",
  CHARITY_IN_ACTION: "/our-work/charity-in-action",
  COMMUNITY_TRUST: "/our-work/community-trust",
  HISTORY: "/our-work/history",
  SERVING_WITH_DIGNITY: "/our-work/serving-with-dignity",
  SUPPORTING_WOMEN: "/our-work/supporting-women",
  DONATION_IS_TRUST: "/our-work/donation-is-trust",
  EMPOWERING_LIVELIHOODS: "/our-work/empowering-livelihoods",
  WHY_TRANSPARENCY: "/our-work/why-transparency",
  ANNUAL_REPORT: "/our-work/annual-report",
  CLOTHING_DISTRIBUTION: "/our-work/clothing-distribution",
  MEDICAL_ASSISTANCE: "/our-work/medical-assistance",
  EDUCATIONAL_SUPPORT: "/our-work/educational-support",
  MARRIAGE_ASSISTANCE: "/our-work/marriage-assistance",
  RATION_KIT_DISTRIBUTION: "/our-work/ration-kit-distribution",

  // About & Content
  ABOUT: "/about",
  BANK_DETAILS: "/bank-details",

  // News
  NEWS: "/news",
  NEWS_DETAIL: "/news/:slug",

  // Utility
  CONTACT: "/contact",
} as const;

// Helper to generate dynamic routes
export const getAppealUrl = (slug: string) => `/appeals/${slug}`;
export const getNewsUrl = (slug: string) => `/news/${slug}`;
