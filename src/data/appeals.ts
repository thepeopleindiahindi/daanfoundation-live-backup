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
    slug: "community-kitchen",
    title: "Community Kitchen",
    shortTitle: "Community Kitchen",
    description: "Free daily meals for people in need — serving with dignity since 2020.",
    longDescription: "The Community Kitchen is the heart of Daan Foundation. Every evening, freshly prepared meals are distributed free of cost to labourers, elderly citizens, widows, orphans, homeless individuals, poor families, and travellers. People from every religion, caste and background are welcomed equally. The estimated cost of one complete meal is approximately ₹59 per person.",
    image: "/images/food-distribution-ramadan.jpg",
    raised: 250000,
    goal: 500000,
    category: "emergency",
    featured: true,
    urgent: true,
  },
  {
    id: "2",
    slug: "ramadan-iftar",
    title: "Ramadan Iftar Programme",
    shortTitle: "Ramadan Iftar",
    description: "Provide nutritious iftar meals to those fasting during the blessed month of Ramadan.",
    longDescription: "Daan Foundation's Ramadan iftar programme has been running since 2020. Every evening during Ramadan, hundreds of iftar meals are prepared and distributed to fasting individuals, families, travellers, and anyone in need. The programme is open to all and ensures that no person breaks their fast hungry.",
    image: "/images/iftaar-distribution.jpg",
    raised: 180000,
    goal: 300000,
    category: "seasonal",
    featured: true,
    urgent: false,
  },
  {
    id: "3",
    slug: "winter-appeal",
    title: "Winter Appeal",
    shortTitle: "Winter Appeal",
    description: "Provide blankets, warm clothing, and shoes to vulnerable families during harsh winters.",
    longDescription: "During harsh winter months, many families struggle to stay warm. Daan Foundation distributes blankets, warm clothing, and shoes to those who need them most — including homeless individuals, daily-wage labourers, elderly citizens, and children from poor families.",
    image: "/images/community-queue.jpg",
    raised: 95000,
    goal: 200000,
    category: "seasonal",
    featured: true,
    urgent: false,
  },
  {
    id: "4",
    slug: "ration-kits",
    title: "Ration Kits Distribution",
    shortTitle: "Ration Kits",
    description: "Essential food ration kits for poor families and vulnerable communities across India.",
    longDescription: "Daan Foundation distributes ration kits containing essential food supplies to families living in poverty. Each kit includes rice, flour, dal, cooking oil, sugar, tea, and other essentials sufficient for a family for one month. The kits are distributed to widows, elderly, disabled individuals, and families who cannot afford basic food.",
    image: "/images/aid-distribution-elderly.jpg",
    raised: 120000,
    goal: 250000,
    category: "ongoing",
    featured: false,
    urgent: false,
  },
  {
    id: "5",
    slug: "where-most-needed",
    title: "Where Most Needed",
    shortTitle: "Most Needed",
    description: "Your donation goes where it is needed most — supporting the most urgent programmes.",
    longDescription: "When you donate to 'Where Most Needed', your contribution is directed to the programme or community that requires the most urgent support. This gives Daan Foundation the flexibility to respond quickly to emerging needs, whether it's expanding the Community Kitchen, distributing ration kits, or supporting families in crisis.",
    image: "/images/hero-2.jpg",
    raised: 200000,
    goal: 400000,
    category: "ongoing",
    featured: false,
    urgent: false,
  },
];

export const getAppealBySlug = (slug: string) => appeals.find((a) => a.slug === slug);
export const getFeaturedAppeals = () => appeals.filter((a) => a.featured);
export const getEmergencyAppeals = () => appeals.filter((a) => a.category === "emergency");
export const getSeasonalAppeals = () => appeals.filter((a) => a.category === "seasonal");
