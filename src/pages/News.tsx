import { Link, useSearchParams } from "react-router-dom";
import { Calendar, ArrowRight, Loader2, Search, Tag } from "lucide-react";
import { useQuery } from "@tanstack/react-query";
import { useState } from "react";
import { getBlogPosts, getBlogCategories, BlogPost } from "@/lib/blog-api";
import Breadcrumbs from "@/components/layout/Breadcrumbs";
import SEO from "@/components/SEO";

export function News() {
  const [searchParams, setSearchParams] = useSearchParams();
  const currentPage = Number(searchParams.get("page")) || 1;
  const currentCategory = searchParams.get("category") || "";
  const [search, setSearch] = useState(searchParams.get("search") || "");
  const [searchInput, setSearchInput] = useState(searchParams.get("search") || "");

  const { data: postsData, isLoading: postsLoading } = useQuery({
    queryKey: ["blog-posts", currentPage, currentCategory, search],
    queryFn: () => getBlogPosts({ page: currentPage, limit: 12, category: currentCategory || undefined, search: search || undefined }),
  });

  const { data: categories } = useQuery({
    queryKey: ["blog-categories"],
    queryFn: getBlogCategories,
  });

  const updateParams = (updates: Record<string, string>) => {
    const params = new URLSearchParams(searchParams);
    Object.entries(updates).forEach(([key, val]) => {
      if (val) params.set(key, val);
      else params.delete(key);
    });
    setSearchParams(params);
  };

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    setSearch(searchInput);
    updateParams({ search: searchInput, page: "" });
  };

  const posts = postsData?.data || [];
  const totalPages = postsData?.totalPages || 1;
  const featured = posts.find((p) => p.featured) || posts[0];
  const others = posts.filter((p) => p.id !== featured?.id);

  return (
    <div>
      <SEO
        title="News & Updates"
        description="Latest news, updates, and stories from Daan Foundation. Read about our community kitchen, ration kit distributions, and humanitarian programs across India."
        canonical="/news"
        keywords="Daan Foundation news, charity updates India, community kitchen updates, donation impact stories"
      />
      <Breadcrumbs items={[{ label: "News" }]} />

      <section className="py-12 md:py-16 bg-[#F3F4F6]">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <h1 className="text-4xl md:text-5xl font-extrabold text-slate-900 mb-4">
            News & Stories
          </h1>
          <p className="text-xl text-slate-600 max-w-2xl mb-6">
            Updates from our projects, impact stories, and the latest news from across India.
          </p>

          {/* Search */}
          <form onSubmit={handleSearch} className="flex gap-2 max-w-md">
            <div className="relative flex-1">
              <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" />
              <input
                type="text"
                value={searchInput}
                onChange={(e) => setSearchInput(e.target.value)}
                placeholder="Search articles..."
                className="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-sm"
              />
            </div>
            <button type="submit" className="bg-orange-600 text-white px-4 py-2.5 rounded-lg text-sm font-semibold hover:bg-orange-700">
              Search
            </button>
          </form>
        </div>
      </section>

      {postsLoading ? (
        <div className="py-20 flex justify-center">
          <Loader2 className="h-8 w-8 animate-spin text-orange-600" />
        </div>
      ) : !posts.length ? (
        <div className="py-20 text-center">
          <p className="text-slate-500 text-lg">No articles found.</p>
          {(search || currentCategory) && (
            <button onClick={() => { setSearch(""); setSearchInput(""); setSearchParams({}); }} className="text-orange-600 font-medium mt-2 hover:underline">
              Clear filters
            </button>
          )}
        </div>
      ) : (
        <>
          {featured && !search && !currentCategory && (
            <section className="py-12 md:py-16">
              <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <Link
                  to={`/news/${featured.slug}`}
                  className="group grid md:grid-cols-2 gap-8 items-center"
                >
                  <div className="aspect-[16/10] rounded-2xl overflow-hidden">
                    <img
                      src={featured.featured_image || "/images/placeholder.jpg"}
                      alt={featured.title}
                      className="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500"
                    />
                  </div>
                  <div>
                    {featured.category_name && (
                      <span className="inline-block rounded-full bg-orange-100 px-3 py-1 text-xs font-semibold text-orange-700 mb-4">
                        {featured.category_name}
                      </span>
                    )}
                    <h2 className="text-3xl font-bold text-slate-900 mb-4 group-hover:text-orange-600 transition-colors">
                      {featured.title}
                    </h2>
                    <p className="text-lg text-slate-600 mb-4">{featured.excerpt}</p>
                    <div className="flex items-center gap-4 text-sm text-slate-500">
                      <span className="flex items-center gap-1">
                        <Calendar className="h-4 w-4" />
                        {new Date(featured.published_at || featured.created_at).toLocaleDateString("en-GB", {
                          day: "numeric",
                          month: "long",
                          year: "numeric",
                        })}
                      </span>
                      <span>By {featured.author}</span>
                    </div>
                  </div>
                </Link>
              </div>
            </section>
          )}

          {/* Category tabs */}
          {categories && categories.length > 0 && (
            <section className="pb-4">
              <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div className="flex flex-wrap gap-2">
                  <button
                    onClick={() => updateParams({ category: "", page: "" })}
                    className={`px-4 py-2 rounded-full text-sm font-medium transition-colors ${
                      !currentCategory ? "bg-orange-600 text-white" : "bg-slate-100 text-slate-600 hover:bg-slate-200"
                    }`}
                  >
                    All
                  </button>
                  {categories.map((cat) => (
                    <button
                      key={cat.id}
                      onClick={() => updateParams({ category: cat.slug, page: "" })}
                      className={`px-4 py-2 rounded-full text-sm font-medium transition-colors ${
                        currentCategory === cat.slug ? "bg-orange-600 text-white" : "bg-slate-100 text-slate-600 hover:bg-slate-200"
                      }`}
                    >
                      {cat.name}
                    </button>
                  ))}
                </div>
              </div>
            </section>
          )}

          <section className="py-12 md:py-16 bg-[#F3F4F6]">
            <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
              <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                {others.map((article) => (
                  <ArticleCard key={article.id} article={article} />
                ))}
              </div>

              {/* Pagination */}
              {totalPages > 1 && (
                <div className="flex justify-center gap-1 sm:gap-2 mt-12 flex-wrap">
                  <button
                    onClick={() => updateParams({ page: String(currentPage - 1) })}
                    disabled={currentPage <= 1}
                    className="px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-medium bg-white border border-slate-200 disabled:opacity-40 hover:bg-slate-50"
                  >
                    Previous
                  </button>
                  {Array.from({ length: totalPages }, (_, i) => i + 1).map((p) => (
                    <button
                      key={p}
                      onClick={() => updateParams({ page: String(p) })}
                      className={`px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-medium ${
                        p === currentPage ? "bg-orange-600 text-white" : "bg-white border border-slate-200 hover:bg-slate-50"
                      }`}
                    >
                      {p}
                    </button>
                  ))}
                  <button
                    onClick={() => updateParams({ page: String(currentPage + 1) })}
                    disabled={currentPage >= totalPages}
                    className="px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-medium bg-white border border-slate-200 disabled:opacity-40 hover:bg-slate-50"
                  >
                    Next
                  </button>
                </div>
              )}
            </div>
          </section>
        </>
      )}
    </div>
  );
}

function ArticleCard({ article }: { article: BlogPost }) {
  return (
    <Link
      to={`/news/${article.slug}`}
      className="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow"
    >
      <div className="aspect-[16/10] overflow-hidden">
        <img
          src={article.featured_image || "/images/placeholder.jpg"}
          alt={article.title}
          className="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500"
        />
      </div>
      <div className="p-6">
        <div className="flex items-center gap-2 mb-3">
          {article.category_name && (
            <span className="inline-block rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
              {article.category_name}
            </span>
          )}
          {article.tags?.slice(0, 1).map((t) => (
            <span key={t} className="inline-flex items-center gap-1 rounded-full bg-orange-50 px-2 py-1 text-xs text-orange-600">
              <Tag className="h-3 w-3" /> {t}
            </span>
          ))}
        </div>
        <h3 className="font-bold text-slate-900 mb-2 group-hover:text-orange-600 transition-colors line-clamp-2">
          {article.title}
        </h3>
        <p className="text-sm text-slate-600 line-clamp-2 mb-4">{article.excerpt}</p>
        <div className="flex items-center gap-2 text-sm text-slate-500">
          <Calendar className="h-4 w-4" />
          {new Date(article.published_at || article.created_at).toLocaleDateString("en-GB", {
            day: "numeric",
            month: "short",
            year: "numeric",
          })}
        </div>
      </div>
    </Link>
  );
}

export default News;
