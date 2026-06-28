export interface BlogPost {
  id: number;
  title: string;
  slug: string;
  excerpt: string;
  content: string;
  featured_image: string;
  category_id: number | null;
  category_name: string | null;
  category_slug: string | null;
  author: string;
  seo_title: string;
  seo_description: string;
  seo_keywords: string;
  status: "draft" | "published";
  featured: number;
  tags: string[];
  published_at: string;
  created_at: string;
  updated_at: string;
}

export interface PaginatedResponse<T> {
  success: boolean;
  data: T[];
  total: number;
  page: number;
  limit: number;
  totalPages: number;
}

export interface BlogCategory {
  id: number;
  name: string;
  slug: string;
  post_count: number;
}

const API_BASE = import.meta.env.PROD ? "/api" : "/api";

async function fetchApi<T>(url: string): Promise<T> {
  const res = await fetch(API_BASE + url);
  if (!res.ok) throw new Error(`API error: ${res.status}`);
  return res.json();
}

export async function getBlogPosts(params?: {
  page?: number;
  limit?: number;
  category?: string;
  tag?: string;
  search?: string;
}): Promise<PaginatedResponse<BlogPost>> {
  const searchParams = new URLSearchParams();
  if (params?.page) searchParams.set("page", String(params.page));
  if (params?.limit) searchParams.set("limit", String(params.limit));
  if (params?.category) searchParams.set("category", params.category);
  if (params?.tag) searchParams.set("tag", params.tag);
  if (params?.search) searchParams.set("search", params.search);
  const qs = searchParams.toString();
  return fetchApi(`/blog/posts.php${qs ? `?${qs}` : ""}`);
}

export async function getBlogPostBySlug(slug: string): Promise<BlogPost> {
  const res = await fetchApi<{ success: boolean; data: BlogPost }>(
    `/blog/posts.php?slug=${encodeURIComponent(slug)}`
  );
  return res.data;
}

export async function getBlogCategories(): Promise<BlogCategory[]> {
  const res = await fetchApi<{ success: boolean; data: BlogCategory[] }>(
    "/blog/categories.php"
  );
  return res.data;
}
