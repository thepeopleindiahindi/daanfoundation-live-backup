// Mock data for news articles
export interface NewsArticle {
  id: string;
  slug: string;
  title: string;
  excerpt: string;
  content: string;
  image: string;
  category: "news" | "stories" | "press" | "opinion";
  author: string;
  date: string;
  featured: boolean;
}

export const newsArticles: NewsArticle[] = [
  {
    id: "1",
    slug: "ramadan-2026-impact",
    title: "Ramadan 2026: Over 50,000 Iftaar Meals Distributed",
    excerpt: "This Ramadan, your generous donations helped us reach families across multiple regions with nutritious Iftaar meals.",
    content: "This Ramadan has been one of our most impactful yet. Thanks to your generous support, we were able to distribute over 50,000 Iftaar meals to families in need across 15 countries. From food packages to hot meals, your donations ensured that no family had to break their fast hungry.",
    image: "/images/news-1.jpg",
    category: "stories",
    author: "Qurbani Easy Team",
    date: "2026-04-20",
    featured: true,
  },
  {
    id: "2",
    slug: "winter-aid-villages",
    title: "Winter Aid Reaches Remote Villages",
    excerpt: "Blankets, warm clothing, and essential supplies delivered to elderly and vulnerable families.",
    content: "As temperatures dropped, our teams worked tirelessly to deliver winter aid packages to remote villages. Over 3,000 families received blankets, warm clothing, and heating supplies. The elderly and those with young children were prioritised in our distribution.",
    image: "/images/news-2.jpg",
    category: "news",
    author: "Field Team",
    date: "2026-04-18",
    featured: false,
  },
  {
    id: "3",
    slug: "food-security-expansion",
    title: "Food Security Initiative Expands to New Regions",
    excerpt: "Our daily food distribution program now reaches 5 new locations, serving hundreds more families.",
    content: "We are pleased to announce the expansion of our food security initiative to five new locations. This expansion means we can now serve an additional 500 families daily with nutritious meals and food packages. The program focuses on sustainable food security solutions.",
    image: "/images/news-3.jpg",
    category: "news",
    author: "Programs Team",
    date: "2026-04-15",
    featured: false,
  },
  {
    id: "4",
    slug: "elderly-care-program",
    title: "Elderly Care Program Launches in Three Countries",
    excerpt: "New initiative provides ongoing support to elderly individuals living alone or in difficult circumstances.",
    content: "Our new elderly care program has officially launched in three countries. This initiative provides monthly support packages, medical assistance, and regular check-ins for elderly individuals who have no family support. The program aims to ensure dignity and care for our elders.",
    image: "/images/aid-distribution-elderly.jpg",
    category: "news",
    author: "Qurbani Easy Team",
    date: "2026-04-10",
    featured: false,
  },
  {
    id: "5",
    slug: "community-iftar-success",
    title: "Community Iftaar Events Bring Hope",
    excerpt: "Thousands gather for community Iftaar events across multiple cities.",
    content: "Our community Iftaar events this Ramadan brought together thousands of people from all walks of life. These gatherings not only provided nutritious meals but also fostered a sense of community and solidarity among attendees.",
    image: "/images/iftaar-distribution.jpg",
    category: "stories",
    author: "Community Team",
    date: "2026-04-05",
    featured: false,
  },
];

export const getNewsArticleBySlug = (slug: string) => newsArticles.find((a) => a.slug === slug);
export const getFeaturedNews = () => newsArticles.filter((a) => a.featured);
export const getNewsByCategory = (category: NewsArticle["category"]) => 
  newsArticles.filter((a) => a.category === category);
