// Mock data for appeals
export interface Appeal {
  id: string;
  slug: string;
  title: string;
  shortTitle: string;
  description: string;
  longDescription: string;
  image: string;
  raised: number;
  goal: number;
  category: "emergency" | "seasonal" | "ongoing";
  featured: boolean;
  urgent: boolean;
}

export const appeals: Appeal[] = [
  {
    id: "1",
    slug: "palestine",
    title: "Palestine Emergency Appeal",
    shortTitle: "Palestine",
    description: "Provide urgent aid to families affected by the ongoing crisis in Palestine.",
    longDescription: "Millions of people in Palestine are facing unimaginable hardship. Families have been displaced, children have lost access to education, and communities are struggling to survive. Your donation provides food, clean water, medical supplies, and shelter to those in desperate need.",
    image: "/images/campaign-1.jpg",
    raised: 2450000,
    goal: 5000000,
    category: "emergency",
    featured: true,
    urgent: true,
  },
  {
    id: "2",
    slug: "sudan",
    title: "Sudan Emergency Appeal",
    shortTitle: "Sudan",
    description: "Help families displaced by conflict and crisis across Sudan.",
    longDescription: "The humanitarian crisis in Sudan has left millions without food, water, or shelter. Families are being torn apart and children are going hungry. Your support enables us to deliver life-saving aid including food packages, clean water, and medical care.",
    image: "/images/campaign-2.jpg",
    raised: 1850000,
    goal: 3000000,
    category: "emergency",
    featured: true,
    urgent: true,
  },
  {
    id: "3",
    slug: "yemen",
    title: "Yemen Crisis Appeal",
    shortTitle: "Yemen",
    description: "Support communities facing one of the world's worst humanitarian crises.",
    longDescription: "Yemen remains one of the world's largest humanitarian crises. Millions face severe food insecurity and lack access to clean water and healthcare. Your donation helps us provide essential aid to families struggling to survive.",
    image: "/images/campaign-3.jpg",
    raised: 980000,
    goal: 2000000,
    category: "emergency",
    featured: true,
    urgent: false,
  },
  {
    id: "4",
    slug: "lebanon",
    title: "Lebanon Emergency Appeal",
    shortTitle: "Lebanon",
    description: "Provide relief to families affected by the devastating crisis in Lebanon.",
    longDescription: "Lebanon is facing multiple crises that have pushed millions into poverty. Economic collapse and conflict have left families struggling for basic necessities. Your support helps us deliver food, shelter, and medical aid.",
    image: "/images/hero-2.jpg",
    raised: 420000,
    goal: 1000000,
    category: "emergency",
    featured: false,
    urgent: true,
  },
  {
    id: "5",
    slug: "ramadan-food",
    title: "Ramadan Food Distribution",
    shortTitle: "Ramadan",
    description: "Provide Iftaar meals to families in need during the blessed month.",
    longDescription: "During the holy month of Ramadan, help us ensure that no family breaks their fast hungry. Your donation provides nutritious Iftaar meals and food packages to families across multiple countries.",
    image: "/images/food-distribution-ramadan.jpg",
    raised: 45000,
    goal: 75000,
    category: "seasonal",
    featured: false,
    urgent: false,
  },
  {
    id: "6",
    slug: "qurbani-2026",
    title: "Qurbani 2026",
    shortTitle: "Qurbani",
    description: "Share your Qurbani with families who rarely eat meat.",
    longDescription: "This Eid ul-Adha, your Qurbani sacrifice will bring joy to families who can rarely afford meat. We ensure your Qurbani reaches those most in need, distributed fresh to families across 30+ countries.",
    image: "/images/hero-1.jpg",
    raised: 125000,
    goal: 500000,
    category: "seasonal",
    featured: true,
    urgent: false,
  },
];

export const getAppealBySlug = (slug: string) => appeals.find((a) => a.slug === slug);
export const getFeaturedAppeals = () => appeals.filter((a) => a.featured);
export const getEmergencyAppeals = () => appeals.filter((a) => a.category === "emergency");
export const getSeasonalAppeals = () => appeals.filter((a) => a.category === "seasonal");
