<?php

/**
 * Advanced Custom Fields (ACF) Configurations
 */

// Prevent direct access
if (!defined('ABSPATH')) {
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
    (function ($) {

      acf.add_filter('color_picker_args', function (args, $field) {

        args.palettes = ['#000000', '#FFFFFF', '<?php echo $primary_palette ?>', '<?php echo $additional_palette ?>']

        return args;

      });

    })(jQuery);
  </script>
  <?php
}
add_action('acf/input/admin_footer', 'civ_acf_input_admin_footer');

/**
 * Add Heroicons tab to ACF Icon Picker
 */
function civ_acf_icon_picker_tabs($tabs)
{
  $tabs['heroicons_solid'] = 'Heroicons Solid';

  return $tabs;
}
add_filter('acf/fields/icon_picker/tabs', 'civ_acf_icon_picker_tabs');

function civ_add_heroicons_icons(array $icons): array
{
  $icons_path = get_template_directory() . '/assets/icons/heroicons/solid/';
  $base_url = get_template_directory_uri() . '/assets/icons/heroicons/solid/';

  // Scan directory for SVG files
  $files = glob($icons_path . '*.svg');

  if ($files) {
    foreach ($files as $file) {
      $filename = basename($file);
      $key = str_replace('.svg', '', $filename);
      $label = ucwords(str_replace(['-', '_'], ' ', $key));

      $icons[] = [
        'url' => $base_url . $filename,
        'key' => $key,
        'label' => $label,
      ];
    }
  }

  return $icons;
}
add_filter('acf/fields/icon_picker/heroicons_solid/icons', 'civ_add_heroicons_icons');

/**
 * Activate ACFE modules
 */
add_action('acf/init', 'civ_acfe_modules');
function civ_acfe_modules()
{
  acfe_update_setting('dev', true);
  acfe_update_setting('modules/performance', array(
    'engine' => 'ultra',
    'ui' => true,
    'mode' => 'production',
  ));
}

/**
 * Set ACFE Flexible Content Dynamic Render Layout Template file path.
 * https://www.acf-extended.com/features/fields/flexible-content/dynamic-render
 */
add_filter('acfe/flexible/render/template', 'civ_acf_layout_template', 10, 4);
function civ_acf_layout_template($file, $field, $layout, $is_preview)
{
  if ($is_preview && isset($layout['name'])) {
    $layout_file = get_stylesheet_directory() . '/acf-layouts/' . $layout['name'] . '.php';
    if (file_exists($layout_file)) {
      return $layout_file;
    }
  }

  return $file;
}

/**
 * Dynamic migration of section_builder layout names from cards_grid to link_cards.
 */
function civ_migrate_section_builder_layout_names($value, $post_id, $field)
{
  if (is_array($value)) {
    foreach ($value as $index => $layout) {
      if ($layout === 'cards_grid') {
        $value[$index] = 'link_cards';
      }
    }
  }
  return $value;
}
add_filter('acf/load_value/name=section_builder', 'civ_migrate_section_builder_layout_names', 10, 3);

/**
 * Dynamic migration of link_cards fields from cards_grid.
 */
function civ_migrate_link_cards_fields($value, $post_id, $field)
{
  if (strpos($field['name'], '_link_cards') !== false) {
    // Only migrate if the layout hasn't been saved yet (i.e. 'section_builder' in DB still contains 'cards_grid')
    $raw_layouts = get_post_meta($post_id, 'section_builder', true);
    if (is_array($raw_layouts) && in_array('cards_grid', $raw_layouts, true)) {
      $old_meta_key = str_replace('_link_cards', '_cards_grid', $field['name']);
      $old_value = get_post_meta($post_id, $old_meta_key, true);

      if ($old_value !== '' && $old_value !== null) {
        return $old_value;
      }
    }
  }
  return $value;
}
add_filter('acf/load_value', 'civ_migrate_link_cards_fields', 10, 3);