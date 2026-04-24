import { Link } from "react-router-dom";
import { ArrowRight, Calendar } from "lucide-react";

const newsItems = [
  {
    id: 1,
    category: "Impact Story",
    title: "Ramadan 2026: Over 50,000 Iftaar Meals Distributed",
    excerpt: "This Ramadan, your generous donations helped us reach families across multiple regions with nutritious Iftaar meals.",
    image: "/images/news-1.jpg",
    date: "April 20, 2026",
    href: "/news/ramadan-2026-impact",
  },
  {
    id: 2,
    category: "Community",
    title: "Winter Aid Reaches Remote Villages",
    excerpt: "Blankets, warm clothing, and essential supplies delivered to elderly and vulnerable families.",
    image: "/images/news-2.jpg",
    date: "April 18, 2026",
    href: "/news/winter-aid-villages",
  },
  {
    id: 3,
    category: "Programs",
    title: "Food Security Initiative Expands",
    excerpt: "Our daily food distribution program now reaches 5 new locations, serving hundreds more families.",
    image: "/images/news-3.jpg",
    date: "April 15, 2026",
    href: "/news/food-security-expansion",
  },
];

export function NewsGrid() {
  return (
    <section className="py-16 md:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-10">
          <div>
            <h2 className="text-3xl md:text-4xl font-bold text-slate-900 mb-2">
              Latest News & Stories
            </h2>
            <p className="text-lg text-slate-600">
              See how your donations are making a difference
            </p>
          </div>
          <Link
            to="/news"
            className="inline-flex items-center gap-2 text-orange-600 font-semibold hover:text-orange-700 transition-colors"
          >
            View all news
            <ArrowRight className="h-4 w-4" />
          </Link>
        </div>

        {/* News grid */}
        <div className="grid md:grid-cols-3 gap-8">
          {newsItems.map((item, index) => (
            <article
              key={item.id}
              className={`group ${index === 0 ? "md:col-span-2 md:row-span-2" : ""}`}
            >
              <Link to={item.href} className="block">
                {/* Image */}
                <div className={`relative overflow-hidden rounded-2xl mb-4 ${
                  index === 0 ? "aspect-[16/10]" : "aspect-[16/9]"
                }`}>
                  <img
                    src={item.image}
                    alt={item.title}
                    className="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500"
                  />
                  <div className="absolute inset-0 bg-gradient-to-t from-slate-900/40 via-transparent to-transparent" />
                  
                  {/* Category badge */}
                  <span className="absolute top-4 left-4 rounded-full bg-white/90 backdrop-blur-sm px-3 py-1 text-xs font-semibold text-slate-700">
                    {item.category}
                  </span>
                </div>

                {/* Content */}
                <div className="flex items-center gap-2 text-sm text-slate-500 mb-2">
                  <Calendar className="h-4 w-4" />
                  {item.date}
                </div>

                <h3 className={`font-bold text-slate-900 mb-2 group-hover:text-orange-600 transition-colors ${
                  index === 0 ? "text-2xl md:text-3xl" : "text-lg"
                }`}>
                  {item.title}
                </h3>

                <p className={`text-slate-600 ${index === 0 ? "text-base" : "text-sm line-clamp-2"}`}>
                  {item.excerpt}
                </p>
              </Link>
            </article>
          ))}
        </div>
      </div>
    </section>
  );
}

export default NewsGrid;
