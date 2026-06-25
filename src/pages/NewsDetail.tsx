import { Link, useParams } from "react-router-dom";
import { Calendar, User, ArrowLeft, Tag, Loader2 } from "lucide-react";
import { useQuery } from "@tanstack/react-query";
import { Helmet } from "react-helmet-async";
import { getBlogPostBySlug, getBlogPosts } from "@/lib/blog-api";
import Breadcrumbs from "@/components/layout/Breadcrumbs";

export function NewsDetail() {
  const { slug } = useParams<{ slug: string }>();

  const { data: article, isLoading } = useQuery({
    queryKey: ["blog-post", slug],
    queryFn: () => getBlogPostBySlug(slug!),
    enabled: !!slug,
  });

  const { data: relatedData } = useQuery({
    queryKey: ["blog-posts-related", article?.category_slug],
    queryFn: () => getBlogPosts({ limit: 3, category: article?.category_slug }),
    enabled: !!article?.category_slug,
  });
  const relatedArticles = (relatedData?.data || []).filter((a) => a.id !== article?.id).slice(0, 3);

  if (isLoading) {
    return (
      <div className="min-h-[60vh] flex items-center justify-center">
        <Loader2 className="h-8 w-8 animate-spin text-orange-600" />
      </div>
    );
  }

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

  const baseUrl = "https://daan.foundation";
  const seoTitle = article.seo_title || article.title;
  const seoDesc = article.seo_description || article.excerpt?.slice(0, 160);

  return (
    <div>
      <Helmet>
        <title>{seoTitle} | Daan Foundation</title>
        <meta name="description" content={seoDesc} />
        <meta name="keywords" content={article.seo_keywords || `Daan Foundation, ${article.category_name}, charity`} />
        <link rel="canonical" href={`${baseUrl}/news/${slug}`} />
        <meta property="og:title" content={seoTitle} />
        <meta property="og:description" content={seoDesc} />
        <meta property="og:url" content={`${baseUrl}/news/${slug}`} />
        <meta property="og:type" content="article" />
        {article.featured_image && <meta property="og:image" content={`${baseUrl}${article.featured_image}`} />}
        <meta property="article:published_time" content={article.published_at} />
        <meta property="article:author" content={article.author} />
        {article.category_name && <meta property="article:section" content={article.category_name} />}
        {article.tags?.map((t) => (
          <meta key={t} property="article:tag" content={t} />
        ))}
        <script type="application/ld+json">
          {JSON.stringify({
            "@context": "https://schema.org",
            "@type": "Article",
            headline: article.title,
            description: article.excerpt,
            image: article.featured_image ? `${baseUrl}${article.featured_image}` : undefined,
            datePublished: article.published_at,
            dateModified: article.updated_at,
            author: {
              "@type": "Organization",
              name: article.author,
            },
            publisher: {
              "@type": "Organization",
              name: "Daan Foundation",
              logo: {
                "@type": "ImageObject",
                url: `${baseUrl}/logo.png`,
              },
            },
            mainEntityOfPage: {
              "@type": "WebPage",
              "@id": `${baseUrl}/news/${slug}`,
            },
          })}
        </script>
      </Helmet>

      <Breadcrumbs
        items={[
          { label: "News", href: "/news" },
          { label: article.title.slice(0, 30) + "..." },
        ]}
      />

      <section className="py-8 md:py-12">
        <div className="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
          <Link
            to="/news"
            className="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-orange-600 mb-6"
          >
            <ArrowLeft className="h-4 w-4" />
            Back to News
          </Link>

          {article.category_name && (
            <span className="inline-block rounded-full bg-orange-100 px-3 py-1 text-xs font-semibold text-orange-700 mb-4">
              {article.category_name}
            </span>
          )}

          <h1 className="text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight mb-6">
            {article.title}
          </h1>

          <div className="flex flex-wrap items-center gap-4 text-sm text-slate-500 mb-8">
            <span className="flex items-center gap-1">
              <Calendar className="h-4 w-4" />
              {new Date(article.published_at || article.created_at).toLocaleDateString("en-GB", {
                day: "numeric",
                month: "long",
                year: "numeric",
              })}
            </span>
            <span className="flex items-center gap-1">
              <User className="h-4 w-4" />
              {article.author}
            </span>
            {article.tags?.length > 0 && (
              <span className="flex items-center gap-1">
                <Tag className="h-4 w-4" />
                {article.tags.join(", ")}
              </span>
            )}
          </div>

          {article.featured_image && (
            <div className="aspect-[16/9] rounded-2xl overflow-hidden mb-8">
              <img
                src={article.featured_image}
                alt={article.title}
                className="h-full w-full object-cover"
              />
            </div>
          )}
        </div>
      </section>

      <section className="pb-12 md:pb-16">
        <div className="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
          <div className="prose prose-lg max-w-none">
            {article.excerpt && (
              <p className="text-xl text-slate-600 leading-relaxed">{article.excerpt}</p>
            )}
            <div dangerouslySetInnerHTML={{ __html: article.content }} />
          </div>

          <div className="mt-8 pt-8 border-t border-slate-200">
            <div className="flex items-center justify-between">
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

      {relatedArticles.length > 0 && (
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
                      src={related.featured_image || "/images/placeholder.jpg"}
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
      )}
    </div>
  );
}

export default NewsDetail;
