<?php

/**
 * Component: Exhibitor Card
 * Used in exhibitors.php and AJAX load more handler.
 */

// Data Retrieval (expecting global $post or setup_postdata)
$exhibitor_contact = get_field('exhibitor_contact');
$phone = $exhibitor_contact['phone_number'] ?? '';
$website = $exhibitor_contact['website_link'] ?? '';

$exhibitor_identity = get_field('exhibitor_identity');
$logo_array = $exhibitor_identity['exhibitor_logo'] ?? [];

$terms = get_the_terms(get_the_ID(), 'exhibitor-category');
$categories = '';

if ($terms && !is_wp_error($terms)) {
  $cat_names = wp_list_pluck($terms, 'name');
  $categories = implode(', ', $cat_names);
}

// Truncate content for excerpt-like feel
$exhibitor_description = get_field('exhibitor_description');
$content = $exhibitor_description['exhibitor_bio'] ?? '';
$excerpt = wp_trim_words($content, 20, '...');
?>

<div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden flex flex-col h-full border border-gray-100 animate-fade-in-up">
  <div class="h-48 overflow-hidden bg-gray-200 flex items-center justify-center">
    <?php if ($logo_array && !empty($logo_array['url'])) : ?>
      <img src="<?php echo esc_url($logo_array['url']); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="w-full h-full object-contain transition-transform hover:scale-105 duration-500">
    <?php else : ?>
      <!-- Fallback Image -->
      <div class="w-full h-full bg-gray-500 flex items-center justify-center text-white/50">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
      </div>
    <?php endif; ?>
  </div>

  <div class="p-6 flex flex-col grow">
    <h3 class="font-bold text-lg leading-snug text-civ-blue-900 mb-1"><?php the_title(); ?></h3>
    <?php if ($categories) : ?>
      <p class="text-xs text-gray-500 italic mb-3"><?php echo esc_html($categories); ?></p>
    <?php endif; ?>

    <p class="text-xs text-gray-600 mb-6 leading-relaxed grow">
      <?php echo esc_html($excerpt); ?>
    </p>

    <div class="space-y-1 mt-auto">
      <?php if ($phone) : ?>
        <p class="text-xs font-bold text-black">Phone: <span class="font-normal text-gray-600"><?php echo esc_html($phone); ?></span></p>
      <?php endif; ?>

      <?php if ($website) : ?>
        <p class="text-xs font-bold text-black">
          Site:
          <a href="<?php echo esc_url($website); ?>" target="_blank" rel="noopener noreferrer" class="font-normal text-civ-orange-500 hover:underline break-all">
            <?php echo esc_html(parse_url($website, PHP_URL_HOST) ?: 'Visit Website'); ?>
          </a>
        </p>
      <?php endif; ?>
    </div>
  </div>
</div>