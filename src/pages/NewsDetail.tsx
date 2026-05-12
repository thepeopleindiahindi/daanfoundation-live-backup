import { Link, useParams } from "react-router-dom";
import { Calendar, User, ArrowLeft, Share2 } from "lucide-react";
import { getNewsArticleBySlug, newsArticles } from "@/data/news";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";

export function NewsDetail() {
  const { slug } = useParams<{ slug: string }>();
  const article = getNewsArticleBySlug(slug || "");

  if (!article) {
    return (
      <div className="min-h-[60vh] flex items-center justify-center">
        <div className="text-center">
          <h1 className="text-2xl font-bold text-slate-900 mb-2">Article Not Found</h1>
          <p className="text-slate-600 mb-4">The article you're looking for doesn't exist.</p>
          <Link to="/news" className="text-orange-600 font-semibold hover:underline">
            View all news
          </Link>
        </div>
      </div>
    );
  }

  const relatedArticles = newsArticles.filter((a) => a.id !== article.id).slice(0, 3);

  return (
    <div>
      <SEO title={article.title} description={article.excerpt.slice(0, 160)} canonical={`/news/${slug}`} keywords={`Daan Foundation news, ${article.category}, charity updates India`} />
      <Breadcrumbs
        items={[
          { label: "News", href: "/news" },
          { label: article.title.slice(0, 30) + "..." },
        ]}
      />

      {/* Article header */}
      <section className="py-8 md:py-12">
        <div className="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
          <Link
            to="/news"
            className="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-orange-600 mb-6"
          >
            <ArrowLeft className="h-4 w-4" />
            Back to News
          </Link>

          <span className="inline-block rounded-full bg-orange-100 px-3 py-1 text-xs font-semibold text-orange-700 mb-4">
            {article.category}
          </span>

          <h1 className="text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight mb-6">
            {article.title}
          </h1>

          <div className="flex flex-wrap items-center gap-4 text-sm text-slate-500 mb-8">
            <span className="flex items-center gap-1">
              <Calendar className="h-4 w-4" />
              {new Date(article.date).toLocaleDateString("en-GB", {
                day: "numeric",
                month: "long",
                year: "numeric",
              })}
            </span>
            <span className="flex items-center gap-1">
              <User className="h-4 w-4" />
              {article.author}
            </span>
          </div>

          {/* Featured image */}
          <div className="aspect-[16/9] rounded-2xl overflow-hidden mb-8">
            <img
              src={article.image}
              alt={article.title}
              className="h-full w-full object-cover"
            />
          </div>
        </div>
      </section>

      {/* Article content */}
      <section className="pb-12 md:pb-16">
        <div className="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
          <div className="prose prose-lg max-w-none">
            <p className="text-xl text-slate-600 leading-relaxed">{article.excerpt}</p>
            <p>{article.content}</p>
            <p>
              Our teams continue to work tirelessly to ensure aid reaches those who need it most. 
              With your support, we can expand our reach and help even more families.
            </p>
            <p>
              Every donation, no matter how small, makes a real difference. Together, we can 
              transform lives and bring hope to communities facing hardship.
            </p>
          </div>

          {/* Share */}
          <div className="mt-8 pt-8 border-t border-slate-200">
            <div className="flex items-center justify-between">
              <button className="flex items-center gap-2 text-slate-600 hover:text-orange-600">
                <Share2 className="h-5 w-5" />
                Share this article
              </button>

              <Link
                to="/donate"
                className="inline-flex items-center gap-2 rounded-full bg-orange-600 px-6 py-2.5 text-sm font-bold text-white hover:bg-orange-700"
              >
                Donate Now
              </Link>
            </div>
          </div>
        </div>
      </section>

      {/* Related articles */}
      <section className="py-12 md:py-16 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h2 className="text-2xl font-bold text-slate-900 mb-8">Related Articles</h2>

          <div className="grid sm:grid-cols-3 gap-6">
            {relatedArticles.map((related) => (
              <Link
                key={related.id}
                to={`/news/${related.slug}`}
                className="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow"
              >
                <div className="aspect-[16/10] overflow-hidden">
                  <img
                    src={related.image}
                    alt={related.title}
                    className="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500"
                  />
                </div>
                <div className="p-5">
                  <h3 className="font-bold text-slate-900 line-clamp-2 group-hover:text-orange-600 transition-colors">
                    {related.title}
                  </h3>
                </div>
              </Link>
            ))}
          </div>
        </div>
      </section>
    </div>
  );
}

export default NewsDetail;
