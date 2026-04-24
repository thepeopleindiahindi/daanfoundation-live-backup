import { Link } from "react-router-dom";
import { Calendar, ArrowRight } from "lucide-react";
import { newsArticles } from "@/data/news";
import Breadcrumbs from "@/components/layout/Breadcrumbs";

export function News() {
  const featuredArticle = newsArticles[0];
  const otherArticles = newsArticles.slice(1);

  return (
    <div>
      <Breadcrumbs items={[{ label: "News" }]} />

      {/* Hero */}
      <section className="py-12 md:py-16 bg-slate-50">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h1 className="text-4xl md:text-5xl font-extrabold text-slate-900 mb-4">
            News & Stories
          </h1>
          <p className="text-xl text-slate-600 max-w-2xl">
            Updates from our projects, impact stories, and the latest news from around the world.
          </p>
        </div>
      </section>

      {/* Featured article */}
      <section className="py-12 md:py-16">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <Link
            to={`/news/${featuredArticle.slug}`}
            className="group grid md:grid-cols-2 gap-8 items-center"
          >
            <div className="aspect-[16/10] rounded-2xl overflow-hidden">
              <img
                src={featuredArticle.image}
                alt={featuredArticle.title}
                className="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500"
              />
            </div>
            <div>
              <span className="inline-block rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 mb-4">
                {featuredArticle.category}
              </span>
              <h2 className="text-3xl font-bold text-slate-900 mb-4 group-hover:text-emerald-600 transition-colors">
                {featuredArticle.title}
              </h2>
              <p className="text-lg text-slate-600 mb-4">{featuredArticle.excerpt}</p>
              <div className="flex items-center gap-4 text-sm text-slate-500">
                <span className="flex items-center gap-1">
                  <Calendar className="h-4 w-4" />
                  {new Date(featuredArticle.date).toLocaleDateString("en-GB", {
                    day: "numeric",
                    month: "long",
                    year: "numeric",
                  })}
                </span>
                <span>By {featuredArticle.author}</span>
              </div>
            </div>
          </Link>
        </div>
      </section>

      {/* Article grid */}
      <section className="py-12 md:py-16 bg-slate-50">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h2 className="text-2xl font-bold text-slate-900 mb-8">Latest Articles</h2>

          <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            {otherArticles.map((article) => (
              <Link
                key={article.id}
                to={`/news/${article.slug}`}
                className="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow"
              >
                <div className="aspect-[16/10] overflow-hidden">
                  <img
                    src={article.image}
                    alt={article.title}
                    className="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500"
                  />
                </div>
                <div className="p-6">
                  <span className="inline-block rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 mb-3">
                    {article.category}
                  </span>
                  <h3 className="font-bold text-slate-900 mb-2 group-hover:text-emerald-600 transition-colors line-clamp-2">
                    {article.title}
                  </h3>
                  <p className="text-sm text-slate-600 line-clamp-2 mb-4">{article.excerpt}</p>
                  <div className="flex items-center gap-2 text-sm text-slate-500">
                    <Calendar className="h-4 w-4" />
                    {new Date(article.date).toLocaleDateString("en-GB", {
                      day: "numeric",
                      month: "short",
                      year: "numeric",
                    })}
                  </div>
                </div>
              </Link>
            ))}
          </div>
        </div>
      </section>
    </div>
  );
}

export default News;
