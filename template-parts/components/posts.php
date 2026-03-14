<?php

/**
 * Posts List Component (AJAX Paginated)
 */

$field = $args['field'] ?? '';
$class = $args['class'] ?? '';

// Getting component data
$posts_comp = is_array($field) ? $field : get_sub_field($field ?: 'posts');

if (!$posts_comp) return;

// Extract fields natively based on group config
$posts_data = $posts_comp['posts'] ?? [];
$categories = $posts_data['post_categories'] ?? []; // Array of IDs
$posts_per_page = !empty($posts_data['posts_per_page']) ? intval($posts_data['posts_per_page']) : 10;

// Generate specific ID for binding clicks
static $posts_list_count = 0;
$posts_list_count++;
$component_id = 'posts-list-' . get_the_ID() . '-' . $posts_list_count;

// Prepare initial query arguments
$query_args = [
  'post_type'      => 'post',
  'post_status'    => 'publish',
  'posts_per_page' => $posts_per_page,
  'paged'          => 1,
];

if (!empty($categories)) {
  $query_args['category__in'] = $categories;
}

$posts_query = new WP_Query($query_args);

?>

<div id="<?php echo esc_attr($component_id); ?>" class="civ-posts-list-component posts-list-component relative <?php echo esc_attr($class); ?>">

  <div class="civ-posts-grid posts-grid flex flex-col gap-8 lg:gap-12" data-categories="<?php echo esc_attr(json_encode($categories)); ?>" data-ppp="<?php echo esc_attr($posts_per_page); ?>">
    <?php
    if ($posts_query->have_posts()) :
      while ($posts_query->have_posts()) : $posts_query->the_post();
        get_template_part('template-parts/components/card-post-row');
      endwhile;
      wp_reset_postdata();
    else :
      echo '<p class="text-gray-500 italic">No posts found matching the criteria.</p>';
    endif;
    ?>
  </div>

  <!-- AJAX Numbered Pagination -->
  <?php if ($posts_query->max_num_pages > 1) : ?>
    <div class="civ-posts-pagination posts-pagination mt-8 pt-8 border-t border-gray-200 flex justify-center gap-1.5 items-center text-civ-blue-900 font-medium text-sm [&_.page-numbers]:px-3 [&_.page-numbers]:py-1.5 [&_.page-numbers]:border [&_.page-numbers]:border-gray-200 [&_.page-numbers]:rounded-md [&_.page-numbers]:transition-colors [&_a.page-numbers:hover]:bg-gray-100 [&_.current]:bg-civ-blue-600 [&_.current]:text-white [&_.current]:border-civ-blue-600"
      data-target="#<?php echo esc_attr($component_id); ?> .posts-grid"
      data-max-pages="<?php echo esc_attr($posts_query->max_num_pages); ?>">
      <?php
      echo paginate_links([
        'total'     => $posts_query->max_num_pages,
        'current'   => 1,
        'format'    => '?paged=%#%',
        'prev_text' => '&laquo; Prev',
        'next_text' => 'Next &raquo;',
      ]);
      ?>
    </div>
  <?php endif; ?>

</div>