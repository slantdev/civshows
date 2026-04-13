<?php

/**
 * The template for displaying search results pages
 */

get_header(); ?>

<main id="primary" class="site-main">

  <section class="civ-search-header civ-page-header bg-civ-blue-900 pt-40 pb-10 md:pt-52 xl:pb-16 xl:pt-72 relative overflow-hidden text-center text-white">
    <div class="absolute inset-0 bg-black/30 pointer-events-none"></div>
    <div class="container mx-auto px-4 relative z-10">
      <h1 class="text-4xl md:text-5xl font-bold mb-4">
        <?php
        /* translators: %s: search query. */
        printf(wp_kses_post(__('Search Results for: <span class="text-civ-orange-500">%s</span>', 'civ-shows')), get_search_query());
        ?>
      </h1>
      <p class="text-lg text-white/80">
        <?php
        global $wp_query;
        echo esc_html($wp_query->found_posts) . ' result' . ($wp_query->found_posts === 1 ? '' : 's') . ' found';
        ?>
      </p>
    </div>
  </section>

  <section class="civ-search-results py-16 lg:py-24 bg-gray-50">
    <div class="container mx-auto px-4 max-w-5xl">
      <?php if (have_posts()) : ?>
        <div class="civ-search-results-grid bg-white p-8 lg:p-12 shadow-sm rounded-lg border border-gray-100">
          <?php
          /* Start the Loop */
          while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('civ-search-result-item border-b border-gray-200 pb-8 mb-8 last:border-0 last:pb-0 last:mb-0'); ?>>
              <h2 class="civ-post-title text-2xl xl:text-3xl font-bold text-civ-blue-900 leading-tight mb-3">
                <a href="<?php the_permalink(); ?>" class="hover:text-civ-orange-500 transition-colors">
                  <?php the_title(); ?>
                </a>
              </h2>
              <div class="civ-post-excerpt text-gray-700 leading-relaxed text-base">
                <?php
                if (has_excerpt()) {
                  echo get_the_excerpt();
                } else {
                  echo wp_trim_words(get_the_content(), 40, '...');
                }
                ?>
              </div>
            </article>
            <?php
          endwhile;
          ?>
        </div>

        <div class="mt-16 civ-pagination-wrapper flex justify-center">
          <?php
          the_posts_pagination([
            'mid_size'  => 2,
            'prev_text' => __('&laquo; Previous', 'civ-shows'),
            'next_text' => __('Next &raquo;', 'civ-shows'),
            'class'     => 'posts-pagination'
          ]);
          ?>
        </div>

      <?php else : ?>
        <div class="text-center py-16 bg-white p-8 shadow-sm rounded-lg border border-gray-100">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-300 mx-auto mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <h2 class="text-3xl font-bold text-gray-800 mb-6"><?php esc_html_e('Nothing Found', 'civ-shows'); ?></h2>
          <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
            <?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'civ-shows'); ?>
          </p>
          <div class="max-w-md mx-auto">
            <?php get_search_form(); ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </section>

</main><!-- #main -->

<?php
get_footer();
