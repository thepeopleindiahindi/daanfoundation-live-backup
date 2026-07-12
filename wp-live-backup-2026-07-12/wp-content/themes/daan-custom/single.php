<?php
/**
 * Single News/Blog Post Template
 */
get_header();

while ( have_posts() ) :
    the_post();
    $categories = get_the_category();
    $tags = get_the_tags();
    $author_id = get_the_author_meta('ID');
    $author_avatar = get_avatar_url($author_id, ['size' => 48]);
    ?>
    <!-- Breadcrumbs -->
    <div class="bg-slate-50 border-b border-slate-200">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-3">
        <nav class="flex items-center gap-2 text-sm text-slate-500">
          <a href="/" class="hover:text-orange-600 transition-colors">Home</a>
          <span>/</span>
          <a href="/news" class="hover:text-orange-600 transition-colors">News</a>
          <span>/</span>
          <span class="text-slate-900 font-medium"><?php the_title(); ?></span>
        </nav>
      </div>
    </div>

    <!-- Hero -->
    <section class="relative bg-gradient-to-br from-orange-600 to-orange-700">
      <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        <div class="max-w-3xl">
          <?php if ($categories): ?>
            <span class="inline-block bg-white/20 text-white text-sm font-semibold px-3 py-1 rounded-full mb-4">
              <?php echo esc_html($categories[0]->name); ?>
            </span>
          <?php endif; ?>
          <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-4"><?php the_title(); ?></h1>
          <div class="flex flex-wrap items-center gap-4 text-white/80 text-sm">
            <span class="flex items-center gap-1">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"/></svg>
              <?php echo get_the_date('F j, Y'); ?>
            </span>
            <span class="flex items-center gap-1">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/></svg>
              <?php the_author(); ?>
            </span>
          </div>
        </div>
      </div>
    </section>

    <!-- Content + Sidebar -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 md:py-12">
      <div class="lg:grid lg:grid-cols-3 lg:gap-10">
        <article id="post-<?php the_ID(); ?>" class="lg:col-span-2 post-article" <?php post_class(); ?>>
          <?php if (has_post_thumbnail()): ?>
            <div class="rounded-2xl overflow-hidden shadow-lg mb-8">
              <?php the_post_thumbnail('full', ['class' => 'w-full h-[300px] md:h-[400px] object-cover']); ?>
            </div>
          <?php endif; ?>

          <div class="prose prose-lg max-w-none prose-headings:text-slate-900 prose-p:text-slate-600 prose-a:text-orange-600">
            <?php the_content(); ?>
          </div>

          <?php if ($tags): ?>
            <div class="flex flex-wrap gap-2 mt-8 pt-8 border-t border-slate-200">
              <?php foreach ($tags as $tag): ?>
                <a href="<?php echo get_tag_link($tag->term_id); ?>" class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-sm hover:bg-orange-100 hover:text-orange-600 transition-colors">
                  #<?php echo esc_html($tag->name); ?>
                </a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

          <!-- Share buttons -->
          <div class="flex items-center gap-4 mt-8 pt-8 border-t border-slate-200">
            <span class="text-sm font-semibold text-slate-700">Share this post:</span>
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="text-slate-400 hover:text-orange-600 transition-colors" aria-label="Share on Facebook">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
            <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode(get_the_title()); ?>&url=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="text-slate-400 hover:text-orange-600 transition-colors" aria-label="Share on Twitter">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
            </a>
            <a href="https://api.whatsapp.com/send?text=<?php echo urlencode(get_the_title() . ' ' . get_permalink()); ?>" target="_blank" class="text-slate-400 hover:text-orange-600 transition-colors" aria-label="Share on WhatsApp">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            </a>
          </div>

          <!-- Post navigation -->
          <div class="flex justify-between mt-8 pt-8 border-t border-slate-200">
            <div class="text-left">
              <?php previous_post_link('%link', '<span class="text-sm text-slate-500">← Previous</span><br><span class="font-semibold text-slate-900 hover:text-orange-600">%title</span>'); ?>
            </div>
            <div class="text-right">
              <?php next_post_link('%link', '<span class="text-sm text-slate-500">Next →</span><br><span class="font-semibold text-slate-900 hover:text-orange-600">%title</span>'); ?>
            </div>
          </div>
        </article>

        <!-- Sidebar -->
        <aside class="lg:col-span-1 mt-8 lg:mt-0">
          <div class="lg:sticky lg:top-24 space-y-6">
            <?php get_template_part('template-parts/donation-sidebar'); ?>
            
            <!-- Recent Posts Widget -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-5">
              <h3 class="font-bold text-slate-900 mb-4">Recent Posts</h3>
              <?php
              $recent = new WP_Query(['posts_per_page' => 5, 'post__not_in' => [get_the_ID()]]);
              if ($recent->have_posts()):
                while ($recent->have_posts()): $recent->the_post(); ?>
                  <a href="<?php the_permalink(); ?>" class="flex gap-3 py-2 group">
                    <?php if (has_post_thumbnail()): ?>
                      <div class="w-14 h-14 rounded-lg overflow-hidden flex-shrink-0">
                        <?php the_post_thumbnail('thumbnail', ['class' => 'w-full h-full object-cover']); ?>
                      </div>
                    <?php endif; ?>
                    <div>
                      <h4 class="text-sm font-semibold text-slate-900 group-hover:text-orange-600 transition-colors line-clamp-2"><?php the_title(); ?></h4>
                      <span class="text-xs text-slate-500"><?php echo get_the_date('M j, Y'); ?></span>
                    </div>
                  </a>
                <?php endwhile; wp_reset_postdata();
              endif; ?>
            </div>
          </div>
        </aside>
      </div>
    </div>
    <?php
endwhile;

get_footer();
