<?php

/**
 * Advanced Custom Fields (ACF) Configurations
 */

// Prevent direct access
if (! defined('ABSPATH')) {
  exit;
}

/**
 * 1. Customize ACF Settings
 */

/**
 * ACF Google Maps API Key
 * 
 * Sets the API key for ACF Google Map field.
 * Fallbacks to a default key if 'google_maps_api_key' is not found in options.
 */
function civ_acf_google_map_api($api)
{
  // Get API key from Theme Settings
  $api_key = get_field('other_settings', 'option')['google_maps']['google_maps_api_key'] ?? '';

  // Fallback Key (Must be defined in wp-config.php for security)
  if (empty($api_key) && defined('GOOGLE_MAPS_API_KEY')) {
    $api_key = constant('GOOGLE_MAPS_API_KEY');
  }

  if ($api_key) {
    $api['key'] = $api_key;
  }

  return $api;
}
add_filter('acf/fields/google_map/api', 'civ_acf_google_map_api');


/**
 * Register Local JSON for Syncing
 * 
 * This saves ACF field groups as JSON files in your theme,
 * allowing you to version control them.
 */
function civ_acf_json_save_point($path)
{
  // Update path to the /acf-json folder in the theme
  return get_template_directory() . '/acf-json';
}
add_filter('acf/settings/save_json', 'civ_acf_json_save_point');

function civ_acf_json_load_point($paths)
{
  // Remove original path (optional)
  unset($paths[0]);

  // Append our new path
  $paths[] = get_template_directory() . '/acf-json';

  return $paths;
}
add_filter('acf/settings/load_json', 'civ_acf_json_load_point');

/*
 * Add color picker pallete on admin
 */
function civ_acf_input_admin_footer()
{
  $palette_fields = [
    'primary_color',
    'secondary_color',
    'tertiary_color',
    'fourth_color',
    'fifth_color',
    'body_text_color',
  ];

  $additional_color = get_field('additional_color', 'option');

  $primary_palette_array = [];
  foreach ($palette_fields as $field) {
    $color = get_field($field, 'option');
    if ($color) {
      $primary_palette_array[] = $color;
    }
  }

  $additional_color_array = [];
  if ($additional_color) {
    foreach ($additional_color as $color) {
      $additional_color_array[] = $color['color'];
    }
  }

  $primary_palette = implode("', '", $primary_palette_array);
  $additional_palette = implode("', '", $additional_color_array);

?>
  <script type="text/javascript">
    (function($) {

      acf.add_filter('color_picker_args', function(args, $field) {

        args.palettes = ['#000000', '#FFFFFF', '<?php echo $primary_palette ?>', '<?php echo $additional_palette ?>']

        return args;

      });

    })(jQuery);
  </script>
<?php
}
add_action('acf/input/admin_footer', 'civ_acf_input_admin_footer');

/**
 * Filter ACF Relationship field to show only Top Level posts of 'shows' custom post type
 */
add_filter('acf/fields/relationship/query/name=exhibitor_shows', function ($args, $field, $post_id) {

  // Set post_parent to 0. 
  // This strictly retrieves posts that do not have a parent.
  $args['post_parent'] = 0;

  return $args;
}, 10, 3);

/**
 * Add Exhibitor ID to Admin Columns
 */

// 1. Add & Reorder Column Headers
add_filter('manage_edit-exhibitors_columns', function ($columns) {
  $new_columns = [];

  // Standard WP columns we want to keep/reposition
  $cb = $columns['cb'];
  $title = $columns['title'];
  $categories = $columns['taxonomy-exhibitor-category'];
  $date = $columns['date'];

  $new_columns['cb'] = $cb;
  $new_columns['exhibitor_id'] = 'ID';
  $new_columns['title'] = $title;
  $new_columns['exhibitor_shows'] = 'Shows';
  $new_columns['taxonomy-exhibitor-category'] = $categories;
  $new_columns['date'] = $date;

  return $new_columns;
});

// 2. Populate Column Content
add_action('manage_exhibitors_posts_custom_column', function ($column, $post_id) {
  if ($column === 'exhibitor_id') {
    $identity = get_field('exhibitor_identity', $post_id);
    $exhibitor_id = $identity['exhibitor_id'] ?? '';
    echo $exhibitor_id ? esc_html($exhibitor_id) : '—';
  }

  if ($column === 'exhibitor_shows') {
    $shows = get_field('exhibitor_shows', $post_id);
    if ($shows) {
      $show_links = [];
      foreach ($shows as $show) {
        // Handle both Post Object and ID return formats
        $show_id = is_object($show) ? $show->ID : $show;
        $show_title = is_object($show) ? $show->post_title : get_the_title($show);

        $url = add_query_arg([
          'post_type' => 'exhibitors',
          'admin_filter_show' => $show_id
        ], admin_url('edit.php'));

        $show_links[] = '<a href="' . esc_url($url) . '">' . esc_html($show_title) . '</a>';
      }
      echo implode(', ', $show_links);
    } else {
      echo '—';
    }
  }
}, 10, 2);

// 3. Make Column Sortable
add_filter('manage_edit-exhibitors_sortable_columns', function ($columns) {
  $columns['exhibitor_id'] = 'exhibitor_id';
  return $columns;
});

// 4. Handle Sorting & Filtering Logic
add_action('pre_get_posts', function ($query) {
  if (!is_admin() || !$query->is_main_query()) {
    return;
  }

  if ($query->get('post_type') === 'exhibitors') {
    // Sorting by ID
    if ($query->get('orderby') === 'exhibitor_id') {
      $query->set('meta_key', 'exhibitor_id');
      $query->set('orderby', 'meta_value');
    }

    // Filtering by Show (Relationship Field)
    if (!empty($_GET['admin_filter_show'])) {
      $show_id = sanitize_text_field($_GET['admin_filter_show']);
      $query->set('meta_query', [
        [
          'key'     => 'exhibitor_shows',
          'value'   => '"' . $show_id . '"', // Search for serialized ID
          'compare' => 'LIKE'
        ]
      ]);
    }
  }
});

/**
 * Add Category & Show Filters to Admin List
 */
add_action('restrict_manage_posts', function () {
  global $typenow;

  if ($typenow === 'exhibitors') {
    // 1. Category Filter
    $taxonomy = 'exhibitor-category';
    $term = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';

    wp_dropdown_categories(array(
      'show_option_all' => 'All Categories',
      'taxonomy'        => $taxonomy,
      'name'            => $taxonomy,
      'orderby'         => 'name',
      'selected'        => $term,
      'show_count'      => true,
      'hide_empty'      => false,
      'value_field'     => 'slug',
      'hierarchical'    => true,
      'depth'           => 3,
    ));

    // 2. Shows Filter (Relationship)
    $selected_show = isset($_GET['admin_filter_show']) ? $_GET['admin_filter_show'] : '';
    $shows = get_posts([
      'post_type'      => 'shows',
      'posts_per_page' => -1,
      'post_status'    => 'publish',
      'post_parent'    => 0, // Only top-level shows
      'orderby'        => 'title',
      'order'          => 'ASC'
    ]);

    if ($shows) {
      echo '<select name="admin_filter_show">';
      echo '<option value="">All Shows</option>';
      foreach ($shows as $show) {
        $selected = ($selected_show == $show->ID) ? 'selected="selected"' : '';
        echo '<option value="' . esc_attr($show->ID) . '" ' . $selected . '>' . esc_html($show->post_title) . '</option>';
      }
      echo '</select>';
    }
  }
});
