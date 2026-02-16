<?php

/**
 * Gallery Post Type Logic
 * 
 * Handles Admin Columns, Filters, and Query logic for the Gallery CPT.
 */

// Prevent direct access
if (! defined('ABSPATH')) {
  exit;
}

// --- 1. Hooks & Filters ---

// Admin Columns
add_filter('manage_edit-gallery_columns', 'civ_gallery_admin_columns_head');
add_action('manage_gallery_posts_custom_column', 'civ_gallery_admin_columns_content', 10, 2);

// Admin Filtering Logic
add_action('pre_get_posts', 'civ_gallery_admin_query_logic');
add_action('restrict_manage_posts', 'civ_gallery_admin_list_filters');


// --- 2. Functions ---

/**
 * Define Admin Columns for Gallery
 */
function civ_gallery_admin_columns_head($columns)
{
  $new_columns = [];
  $new_columns['cb'] = $columns['cb'];
  $new_columns['title'] = $columns['title'];
  $new_columns['exhibitor_shows'] = 'Shows';
  $new_columns['taxonomy-gallery-category'] = 'Category';
  $new_columns['date'] = $columns['date'];

  return $new_columns;
}

/**
 * Populate Admin Columns for Gallery
 */
function civ_gallery_admin_columns_content($column, $post_id)
{
  if ($column === 'exhibitor_shows') {
    $gallery_settings = get_field('gallery_settings', $post_id);
    $shows = $gallery_settings['exhibitor_shows'] ?? [];
    if ($shows) {
      $show_links = [];
      foreach ($shows as $show) {
        $show_id    = is_object($show) ? $show->ID : $show;
        $show_title = is_object($show) ? $show->post_title : get_the_title($show);
        $filter_url = add_query_arg(['post_type' => 'gallery', 'admin_filter_show' => $show_id], admin_url('edit.php'));
        $show_links[] = '<a href="' . esc_url($filter_url) . '">' . esc_html($show_title) . '</a>';
      }
      echo implode(', ', $show_links);
    } else {
      echo '—';
    }
  }
}

/**
 * Handle Admin Query Logic (Filtering by Show)
 */
function civ_gallery_admin_query_logic($query)
{
  if (!is_admin() || !$query->is_main_query() || $query->get('post_type') !== 'gallery') {
    return;
  }

  // Filtering by Show (Relationship Field - LIKE search for serialized ID)
  if (!empty($_GET['admin_filter_show'])) {
    $show_id = sanitize_text_field($_GET['admin_filter_show']);
    $query->set('meta_query', [[
      'key'     => 'gallery_settings_exhibitor_shows',
      'value'   => '"' . $show_id . '"',
      'compare' => 'LIKE'
    ]]);
  }
}

/**
 * Add Category & Show Filters to Gallery Admin List
 */
function civ_gallery_admin_list_filters()
{
  global $typenow;
  if ($typenow !== 'gallery') return;

  // 1. Category Filter
  $taxonomy = 'gallery-category';
  wp_dropdown_categories([
    'show_option_all' => 'All Categories',
    'taxonomy'        => $taxonomy,
    'name'            => $taxonomy,
    'orderby'         => 'name',
    'selected'        => $_GET[$taxonomy] ?? '',
    'show_count'      => true,
    'hide_empty'      => false,
    'value_field'     => 'slug',
    'hierarchical'    => true,
    'depth'           => 3,
  ]);

  // 2. Shows Filter (Relationship field link)
  $shows = get_posts(['post_type' => 'shows', 'post_parent' => 0, 'posts_per_page' => -1, 'post_status' => 'publish']);
  if ($shows) {
    $selected = $_GET['admin_filter_show'] ?? '';
    echo '<select name="admin_filter_show">';
    echo '<option value="">All Shows</option>';
    foreach ($shows as $show) {
      printf('<option value="%s" %s>%s</option>', $show->ID, selected($selected, $show->ID, false), esc_html($show->post_title));
    }
    echo '</select>';
  }
}
