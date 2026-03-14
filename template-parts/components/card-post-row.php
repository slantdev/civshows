<?php

/**
 * Post Row Card Component
 * 
 * Used dynamically by both the initial page load in `posts_list.php`
 * and the AJAX "Load More" handler in `inc/ajax-handlers.php`.
 */
?>
<div class="civ-post-row-card post-row-card flex flex-col lg:flex-row gap-6 lg:gap-8 items-start border-b border-gray-200 pb-8 last:border-0 last:pb-0">

  <!-- Col 1: Content (2/3 width) -->
  <div class="civ-post-content post-content w-full lg:w-2/3 order-2 lg:order-1 flex flex-col gap-3 text-left">
    <h3 class="civ-post-title text-2xl font-bold text-civ-blue-900 leading-tight xl:text-4xl">
      <a href="<?php the_permalink(); ?>" class="civ-post-title-link hover:text-civ-orange-500 transition-colors">
        <?php the_title(); ?>
      </a>
    </h3>

    <div class="civ-post-meta post-meta text-sm text-gray-500 uppercase font-semibold tracking-wider">
      <time class="civ-post-date" datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
    </div>

    <div class="civ-post-excerpt post-excerpt text-gray-700 leading-relaxed text-base pt-1">
      <?php if (has_excerpt()) : ?>
        <p><?php echo get_the_excerpt(); ?></p>
      <?php else : ?>
        <p><?php echo wp_trim_words(get_the_content(), 30, '...'); ?></p>
      <?php endif; ?>
    </div>

    <div class="civ-read-more-wrapper read-more mt-2">
      <a href="<?php echo esc_url(get_permalink()); ?>" class="civ-read-more-link inline-flex items-center text-civ-orange-500 font-bold hover:text-civ-orange-600 transition-colors group">
        Read more
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
        </svg>
      </a>
    </div>
  </div>

  <!-- Col 2: Image (1/3 width) -->
  <div class="civ-post-image-wrapper post-image-wrapper w-full lg:w-1/3 order-1 lg:order-2 shrink-0">
    <a href="<?php the_permalink(); ?>" class="civ-post-image-link block rounded-lg overflow-hidden group aspect-4/3 lg:aspect-auto">
      <?php if (has_post_thumbnail()) : ?>
        <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500']); ?>
      <?php else : ?>
        <!-- Fallback block if no image -->
        <div class="w-full h-full min-h-[200px] bg-gray-100 flex items-center justify-center group-hover:scale-105 transition-transform duration-500">
          <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
          </svg>
        </div>
      <?php endif; ?>
    </a>
  </div>

</div>