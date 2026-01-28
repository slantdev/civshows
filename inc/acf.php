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
  $api_key = get_field('google_maps_api_key', 'option');

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
