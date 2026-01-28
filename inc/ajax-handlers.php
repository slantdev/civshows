<?php
/**
 * AJAX Handlers
 */

/**
 * Filter to restrict search to Post Title only
 */
function civ_title_search_filter($search, $wp_query) {
    global $wpdb;
    if (empty($search)) return $search;
    
    $q = $wp_query->query_vars;
    $n = !empty($q['exact']) ? '' : '%';
    
    $search = array();
    
    foreach ((array) $q['search_terms'] as $term) {
        $term = esc_sql($wpdb->esc_like($term));
        $search[] = "($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
    }
    
    if (!is_user_logged_in()) {
        $search[] = "($wpdb->posts.post_password = '')";
    }
    
    return " AND " . implode(" AND ", $search) . " ";
}

// Load More Exhibitors
function civ_load_more_exhibitors() {
  check_ajax_referer('civ_exhibitors_nonce', 'nonce');

  $paged = isset($_POST['page']) ? intval($_POST['page']) + 1 : 1;
  $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
  $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
  $is_new = isset($_POST['is_new']) && $_POST['is_new'] === 'true';
  $has_special = isset($_POST['has_special']) && $_POST['has_special'] === 'true';

  $args = array(
    'post_type'      => 'exhibitors',
    'posts_per_page' => 12,
    'paged'          => $paged,
    'orderby'        => 'title',
    'order'          => 'ASC',
    'post_status'    => 'publish',
  );

  // Taxonomy Filter
  if (!empty($category)) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => 'exhibitor-category',
        'field'    => 'slug',
        'terms'    => $category,
      ),
    );
  }

  // Search Filter
  if (!empty($search)) {
    $args['s'] = $search;
    // Apply title-only filter
    add_filter('posts_search', 'civ_title_search_filter', 10, 2);
  }

  // Meta Query for Checkboxes (ACF field 'tags')
  $meta_query = array();
  
  if ($is_new) {
    $meta_query[] = array(
      'key'     => 'tags',
      'value'   => '"new"', // Serialized ACF checkbox value
      'compare' => 'LIKE'
    );
  }

  if ($has_special) {
    $meta_query[] = array(
      'key'     => 'tags',
      'value'   => '"specials"', // Serialized ACF checkbox value
      'compare' => 'LIKE'
    );
  }

  if (!empty($meta_query)) {
    $args['meta_query'] = $meta_query;
  }

  $query = new WP_Query($args);

  // Remove filter immediately after query
  if (!empty($search)) {
    remove_filter('posts_search', 'civ_title_search_filter', 10);
  }

  ob_start();

  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();
      get_template_part('template-parts/shows/components/card', 'exhibitor');
    }
    wp_reset_postdata();
  } else {
    // If filtering and no results, return a message (optional, handled by JS usually)
  }

  $html = ob_get_clean();

  wp_send_json_success(array(
    'html' => $html,
    'max_pages' => $query->max_num_pages,
    'found_posts' => $query->found_posts
  ));
}
add_action('wp_ajax_civ_load_more_exhibitors', 'civ_load_more_exhibitors');
add_action('wp_ajax_nopriv_civ_load_more_exhibitors', 'civ_load_more_exhibitors');
