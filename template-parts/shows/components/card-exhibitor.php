<?php

/**
 * Component: Exhibitor Card
 * Used in exhibitors.php and AJAX load more handler.
 */

// Data Retrieval (expecting global $post or setup_postdata)
$exhibitor_contact = get_field('exhibitor_contact');
$phone = $exhibitor_contact['phone_number'] ?? '';
$website = $exhibitor_contact['website_link'] ?? '';
$instagram = $exhibitor_contact['instagram_link'] ?? '';
$facebook = $exhibitor_contact['facebook_link'] ?? '';

$exhibitor_identity = get_field('exhibitor_identity');
$logo_array = $exhibitor_identity['exhibitor_logo'] ?? [];
$exhibitor_id_val = $exhibitor_identity['exhibitor_id'] ?? '';

$exhibitor_description = get_field('exhibitor_description');
$headline = $exhibitor_description['exhibitor_headline'] ?? '';
$content = $exhibitor_description['exhibitor_bio'] ?? '';

$exhibitor_tags = get_field('exhibitor_tags');

$terms = get_the_terms(get_the_ID(), 'exhibitor-category');
$categories = '';

if ($terms && !is_wp_error($terms)) {
  $cat_names = wp_list_pluck($terms, 'name');
  $categories = implode(', ', $cat_names);
}

// Truncate content for excerpt-like feel
$excerpt = wp_trim_words($content, 20, '...');
?>

<div data-fancybox data-src="#modal-exhibitor-<?php the_ID(); ?>" class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden flex flex-col h-full border border-gray-100 animate-fade-in-up cursor-pointer group">
  <div class="h-48 overflow-hidden bg-gray-200 flex items-center justify-center relative">
    <?php if ($logo_array && !empty($logo_array['url'])) : ?>
      <img src="<?php echo esc_url($logo_array['url']); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="w-full h-full object-contain transition-transform group-hover:scale-105 duration-500 bg-white">
    <?php else : ?>
      <!-- Fallback Image -->
      <div class="w-full h-full bg-gray-500 flex items-center justify-center text-white/50">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
      </div>
    <?php endif; ?>

    <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
  </div>

  <div class="p-6 flex flex-col grow">
    <h3 class="font-bold text-lg leading-snug text-civ-blue-900 mb-1 group-hover:text-civ-orange-500 transition-colors"><?php the_title(); ?></h3>
    <?php if ($categories) : ?>
      <p class="text-xs text-gray-500 italic mb-3"><?php echo esc_html($categories); ?></p>
    <?php endif; ?>

    <p class="text-xs text-gray-600 mb-6 leading-relaxed grow">
      <?php echo esc_html($excerpt); ?>
    </p>

    <div class="space-y-1 mt-auto pb-4 relative z-10">
      <?php if ($phone) : ?>
        <p class="text-xs font-bold text-black">Phone: <span class="font-normal text-gray-600"><?php echo esc_html($phone); ?></span></p>
      <?php endif; ?>

      <?php if ($website) : ?>
        <p class="text-xs font-bold text-black">
          Site:
          <a href="<?php echo esc_url($website); ?>" target="_blank" rel="noopener noreferrer" onclick="event.stopPropagation()" class="font-normal text-civ-orange-500 hover:underline break-all">
            <?php echo esc_html(parse_url($website, PHP_URL_HOST) ?: 'Visit Website'); ?>
          </a>
        </p>
      <?php endif; ?>
    </div>

    <div class="flex items-center text-civ-orange-500 text-xs font-bold uppercase pt-4 border-t border-gray-100">
      <span>View Details</span>
      <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
      </svg>
    </div>
  </div>
</div>

<!-- Hidden Modal Content -->
<div id="modal-exhibitor-<?php the_ID(); ?>" class="hidden w-full max-w-4xl bg-white rounded-lg p-0! overflow-hidden relative">
  <button data-fancybox-close class="absolute top-4 right-4 z-50 w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 transition-colors cursor-pointer">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
      <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
    </svg>
  </button>
  <div class="flex flex-col md:flex-row h-full overflow-y-auto">

    <!-- Left Column (Logo & Contact Info) -->
    <div class="w-full md:w-2/5 bg-gray-50 p-8 lg:p-10 flex flex-col border-r border-gray-100">

      <!-- Logo Container -->
      <div class="aspect-square bg-white border border-gray-200 rounded-lg flex items-center justify-center p-6 mb-8 shadow-sm">
        <?php if ($logo_array && !empty($logo_array['url'])) : ?>
          <img src="<?php echo esc_url($logo_array['url']); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="w-full h-full object-contain">
        <?php else : ?>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
        <?php endif; ?>
      </div>

      <!-- Quick Contact / Stats -->
      <div class="space-y-4">
        <?php if ($phone) : ?>
          <div>
            <span class="block text-[10px] uppercase font-bold text-gray-400 tracking-wider mb-1">Phone</span>
            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>" class="text-sm font-semibold text-civ-blue-900 hover:text-civ-orange-500 transition-colors"><?php echo esc_html($phone); ?></a>
          </div>
        <?php endif; ?>

        <?php if ($website) : ?>
          <div>
            <span class="block text-[10px] uppercase font-bold text-gray-400 tracking-wider mb-1">Website</span>
            <a href="<?php echo esc_url($website); ?>" target="_blank" rel="noopener noreferrer" class="text-sm font-semibold text-civ-blue-900 hover:text-civ-orange-500 transition-colors break-all">
              <?php echo esc_html(parse_url($website, PHP_URL_HOST) ?: 'Visit Website'); ?>
            </a>
          </div>
        <?php endif; ?>

        <?php if ($instagram || $facebook) : ?>
          <div class="pt-4 mt-4 border-t border-gray-200">
            <span class="block text-[10px] uppercase font-bold text-gray-400 tracking-wider mb-3">Social</span>
            <div class="flex gap-4">
              <?php if ($facebook) : ?>
                <a href="<?php echo esc_url($facebook); ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-civ-blue-900 hover:border-civ-orange-500 hover:text-civ-orange-500 transition-colors shadow-sm">
                  <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                  </svg>
                </a>
              <?php endif; ?>
              <?php if ($instagram) : ?>
                <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-civ-blue-900 hover:border-civ-orange-500 hover:text-civ-orange-500 transition-colors shadow-sm">
                  <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                  </svg>
                </a>
              <?php endif; ?>
            </div>
          </div>
        <?php endif; ?>

      </div>
    </div>

    <!-- Right Column (Details & Bio) -->
    <div class="w-full md:w-3/5 p-8 lg:p-12 pl-8 lg:pl-12 flex flex-col items-start bg-white">

      <!-- Tags -->
      <?php if (!empty($exhibitor_tags)) : ?>
        <div class="flex flex-wrap gap-2 mb-4">
          <?php foreach ((array) $exhibitor_tags as $tag) : ?>
            <?php
            $tag_label = '';
            $tag_color = '';
            if ($tag === 'new') {
              $tag_label = 'New to the Show';
              $tag_color = 'bg-civ-green-500 text-white';
            } elseif ($tag === 'specials') {
              $tag_label = 'Offers Show Specials';
              $tag_color = 'bg-civ-orange-500 text-white';
            }
            ?>
            <?php if ($tag_label): ?>
              <span class="inline-block text-[10px] font-bold uppercase py-1 px-3 rounded-full tracking-wider <?php echo esc_attr($tag_color); ?>">
                <?php echo esc_html($tag_label); ?>
              </span>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <!-- Title / Categories -->
      <h2 class="text-3xl font-bold text-civ-blue-900 mb-2 leading-tight"><?php the_title(); ?></h2>
      <?php if ($categories) : ?>
        <p class="text-sm text-gray-400 font-semibold uppercase tracking-wider mb-6"><?php echo esc_html($categories); ?></p>
      <?php endif; ?>

      <!-- Headline -->
      <?php if ($headline) : ?>
        <p class="text-lg md:text-xl text-gray-800 font-medium mb-6 leading-relaxed border-l-4 border-civ-orange-500 pl-4 py-1">
          <?php echo esc_html($headline); ?>
        </p>
      <?php endif; ?>

      <!-- Bio -->
      <?php if ($content) : ?>
        <div class="prose prose-sm md:prose-base prose-gray max-w-none prose-a:text-civ-orange-500 hover:prose-a:text-civ-orange-600">
          <?php echo wp_kses_post($content); ?>
        </div>
      <?php else: ?>
        <p class="text-gray-500 italic">No description provided.</p>
      <?php endif; ?>

    </div>
  </div>
</div>