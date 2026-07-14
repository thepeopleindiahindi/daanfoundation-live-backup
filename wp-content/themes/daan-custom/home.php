<?php
get_header();

$current_cat = get_queried_object();
$cat_slug = '';
if ($current_cat instanceof WP_Term) {
    $cat_slug = $current_cat->slug;
}
?>
<!-- Breadcrumbs -->
<div class="bg-slate-50 border-b border-slate-200">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-3">
    <nav class="flex items-center gap-2 text-sm text-slate-500">
      <a href="/" class="hover:text-orange-600 transition-colors">Home</a>
      <span>/</span>
      <span class="text-slate-900 font-medium">News & Updates</span>
    </nav>
  </div>
</div>

<!-- Hero -->
<section class="relative bg-gradient-to-br from-orange-600 to-orange-700">
  <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 md:py-16 text-center">
    <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-4">News & Updates</h1>
    <p class="text-xl text-white/90 max-w-2xl mx-auto">Stay informed about Daan Foundation's latest activities, campaigns, and impact stories.</p>
    <!-- Search -->
    <div class="max-w-md mx-auto mt-6">
      <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="relative">
        <input type="search" name="s" placeholder="Search news..." value="<?php echo get_search_query(); ?>" class="w-full px-4 py-3 pl-10 rounded-xl border-0 focus:ring-2 focus:ring-orange-300 text-slate-900" />
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
      </form>
    </div>
  </div>
</section>

<!-- Category Tabs + Content -->
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 md:py-12">
  <div class="lg:grid lg:grid-cols-3 lg:gap-10">
    <div class="lg:col-span-2">
      <!-- Category filter tabs -->
      <div class="flex flex-wrap gap-2 mb-8">
        <a href="<?php echo get_post_type_archive_link('post'); ?>" class="px-4 py-2 rounded-full text-sm font-semibold transition-colors <?php echo !$cat_slug ? 'bg-orange-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'; ?>">All</a>
        <?php
        $categories = get_categories(['hide_empty' => true]);
        foreach ($categories as $cat): ?>
          <a href="<?php echo get_category_link($cat->term_id); ?>" class="px-4 py-2 rounded-full text-sm font-semibold transition-colors <?php echo $cat_slug === $cat->slug ? 'bg-orange-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'; ?>"><?php echo esc_html($cat->name); ?></a>
        <?php endforeach; ?>
      </div>

      <?php if (have_posts()):
        $show_featured = ! is_search() && ! $cat_slug && ! is_paged();
      ?>
        <?php if ( $show_featured ) : the_post(); ?>
          <a href="<?php the_permalink(); ?>" style="display:block;margin-bottom:2.5rem;">
            <style>@media (min-width:768px){.featured-post-grid{grid-template-columns:1fr 1fr!important;}}</style>
            <div class="featured-post-grid" style="display:grid;grid-template-columns:1fr;gap:2rem;align-items:center;">
              <div style="border-radius:16px;overflow:hidden;aspect-ratio:16/10;background:#F1F5F9;">
                <?php if (has_post_thumbnail()): ?>
                  <?php the_post_thumbnail('large', ['style' => 'width:100%;height:100%;object-fit:cover;']); ?>
                <?php else: ?>
                  <div style="width:100%;height:100%;background:linear-gradient(135deg,#EA580C,#F97316);"></div>
                <?php endif; ?>
              </div>
              <div>
                <?php $featured_cats = get_the_category(); if ($featured_cats): ?>
                  <span style="display:inline-block;background:#FFEDD5;color:#C2410C;border-radius:9999px;padding:4px 12px;font-size:0.75rem;font-weight:700;margin-bottom:16px;"><?php echo esc_html($featured_cats[0]->name); ?></span>
                <?php endif; ?>
                <h2 style="font-size:1.875rem;font-weight:700;color:#111827;margin:0 0 16px;"><?php the_title(); ?></h2>
                <p style="font-size:1.125rem;color:#475569;margin:0 0 16px;"><?php echo wp_trim_words(get_the_excerpt(), 25); ?></p>
                <div style="display:flex;align-items:center;gap:16px;font-size:0.875rem;color:#64748B;">
                  <span><?php echo get_the_date('F j, Y'); ?></span>
                  <span>By <?php the_author(); ?></span>
                </div>
              </div>
            </div>
          </a>
        <?php endif; ?>
        <div class="grid sm:grid-cols-2 gap-6">
          <?php while (have_posts()): the_post(); 
            $post_categories = get_the_category();
          ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden transition-shadow hover:shadow-xl group'); ?>>
              <?php if (has_post_thumbnail()): ?>
                <a href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300']); ?>
                </a>
              <?php else: ?>
                <div class="w-full h-48 bg-gradient-to-br from-orange-600 to-orange-700 flex items-center justify-center">
                  <span class="text-white/50 text-lg font-bold">Daan Foundation</span>
                </div>
              <?php endif; ?>
              <div class="p-5">
                <?php if ($post_categories): ?>
                  <span class="inline-block bg-orange-100 text-orange-700 text-xs font-semibold px-2 py-1 rounded-full mb-3"><?php echo esc_html($post_categories[0]->name); ?></span>
                <?php endif; ?>
                <h2 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-orange-600 transition-colors">
                  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>
                <span class="text-sm text-slate-500 block mb-2"><?php echo get_the_date('F j, Y'); ?></span>
                <p class="text-sm text-slate-600 line-clamp-2 mb-4"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-1 text-orange-600 font-semibold text-sm hover:text-orange-700 transition-colors">
                  Read More
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
              </div>
            </article>
          <?php endwhile; ?>
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
          <?php the_posts_pagination([
            'mid_size' => 2,
            'prev_text' => '← Previous',
            'next_text' => 'Next →',
            'class' => 'flex gap-2',
          ]); ?>
        </div>
      <?php else: ?>
        <div class="text-center py-16">
          <h2 class="text-2xl font-bold text-slate-900 mb-4">No Posts Found</h2>
          <p class="text-slate-600">Check back soon for updates from Daan Foundation.</p>
        </div>
      <?php endif; ?>
    </div>

    <!-- Sidebar -->
    <aside class="lg:col-span-1 mt-8 lg:mt-0">
      <div class="lg:sticky lg:top-24 space-y-6">
        <?php get_template_part('template-parts/donation-sidebar'); ?>
        
        <!-- Categories Widget -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-5">
          <h3 class="font-bold text-slate-900 mb-4">Categories</h3>
          <ul class="space-y-2">
            <?php
            $categories = get_categories(['hide_empty' => true]);
            foreach ($categories as $cat): ?>
              <li>
                <a href="<?php echo get_category_link($cat->term_id); ?>" class="flex justify-between items-center text-slate-600 hover:text-orange-600 transition-colors">
                  <span><?php echo esc_html($cat->name); ?></span>
                  <span class="bg-slate-100 text-xs px-2 py-1 rounded-full"><?php echo $cat->count; ?></span>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </aside>
  </div>
</div>

<?php get_footer(); ?>
