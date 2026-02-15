<?php

/**
 * Custom template tags and helper functions for the theme.
 */

// Prevent direct access
if (! defined('ABSPATH')) {
  exit;
}

/**
 * Generate slug from string (Helper)
 */
function civ_slugify($text)
{
  // Replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);
  // Transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  // Remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);
  // Trim
  $text = trim($text, '-');
  // Lowercase
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }
  return $text;
}

/**
 * Get Section ID Attribute
 * 
 * Returns the ID attribute if 'section_id' subfield exists.
 */
function civ_get_section_id()
{
  $id = get_sub_field('section_id');
  if ($id) {
    return 'id="' . esc_attr(civ_slugify($id)) . '"';
  }
  return '';
}

/**
 * Get Background Image Style
 */
function civ_get_bg_image_style()
{
  $bg_img = get_sub_field('background_image');
  if ($bg_img && is_array($bg_img)) {
    return 'background-image: url(' . esc_url($bg_img['url']) . '); background-repeat: no-repeat; background-size: cover; background-position: center center;';
  }
  return '';
}

/**
 * Get Block Classes (Background Color, Text Color, Spacing)
 */
function civ_get_block_classes($extra_classes = '')
{

  // 1. Colors
  $block_color = get_sub_field('block_colour') ?: 'white';

  // Map colors to Tailwind classes (Update these based on your Tailwind config)
  $bg_map = [
    'purple'     => 'bg-purple',
    'red'        => 'bg-red',
    'black'      => 'bg-off-black',
    'white'      => 'bg-white',
    'light_grey' => 'bg-light-grey',
    'off_white'  => 'bg-off-white',
  ];

  $text_map = [
    'purple'     => 'text-white',
    'red'        => 'text-white',
    'black'      => 'text-white',
    'white'      => 'text-default',
    'light_grey' => 'text-default',
    'off_white'  => 'text-default',
  ];

  // Default fallback
  $bg_class   = $bg_map[$block_color] ?? 'bg-transparent';
  $text_class = $text_map[$block_color] ?? 'text-gray-900';

  // 2. Spacing (Map old values to Tailwind v4)
  // Assuming 'pt-12' etc are standard Tailwind.
  $spacing_top    = get_sub_field('spacing_top') ?: 'pt-12';
  $spacing_bottom = get_sub_field('spacing_bottom') ?: 'pb-12';

  return implode(' ', [$bg_class, $text_class, $spacing_top, $spacing_bottom, $extra_classes]);
}

/**
 * Get Icon
 * 
 * Retrieves an SVG icon from the assets/icons directory.
 * 
 * @param array $atts {
 *     @type string $icon   Icon filename (without extension).
 *     @type string $group  Subdirectory name or tab key (default: 'utility').
 *     @type int    $size   Width/Height in pixels.
 *     @type string $class  Additional CSS classes.
 *     @type string $label  Aria label for accessibility.
 * }
 * @return string SVG markup or empty string if not found.
 */
function civ_icon($atts = array())
{
  $atts = shortcode_atts(array(
    'icon'  => '',
    'group' => 'utility',
    'size'  => false,
    'class' => '',
    'label' => '',
  ), $atts);

  if (empty($atts['icon'])) {
    return '';
  }

  // Map ACF Icon Picker tab keys to folder paths
  $group_map = [
    'heroicons_solid' => 'heroicons/solid',
    'heroicons_outline' => 'heroicons/outline',
  ];

  $group_path = $group_map[$atts['group']] ?? str_replace('_', '/', $atts['group']);
  $icon_path  = get_template_directory() . '/assets/icons/' . $group_path . '/' . $atts['icon'] . '.svg';

  if (!file_exists($icon_path)) {
    return '';
  }

  $svg = file_get_contents($icon_path);

  // Clean up whitespace
  $svg = preg_replace("/([\n\t]+)/", ' ', $svg);
  $svg = preg_replace('/>\s*</', '><', $svg);

  // Prepare attributes
  $classes = 'svg-icon ' . $atts['class'];
  $attrs = sprintf(' class="%s" role="img" focusable="false"', esc_attr(trim($classes)));

  if ($atts['size']) {
    $attrs .= sprintf(' width="%d" height="%d"', $atts['size'], $atts['size']);
  }

  if ($atts['label']) {
    $attrs .= sprintf(' aria-label="%s"', esc_attr($atts['label']));
  } else {
    $attrs .= ' aria-hidden="true"';
  }

  // Inject attributes into the opening <svg> tag
  $svg = preg_replace('/<svg/', '<svg' . $attrs, $svg, 1);

  return $svg;
}

/**
 * Map Color Name to Tailwind Classes
 * 
 * @param string $color_name The ACF color value (e.g., 'purple', 'red').
 * @return string Tailwind classes.
 */
function civ_map_color_class($color_name)
{
  $colors = [
    'purple'     => 'bg-purple text-white',
    'red'        => 'bg-red text-white',
    'black'      => 'bg-off-black text-white',
    'white'      => 'bg-white text-default',
    'light_grey' => 'bg-light-grey text-default',
    'off_white'  => 'bg-off-white text-default',
  ];

  return $colors[$color_name] ?? 'bg-white text-default';
}

/**
 * Debug Helper: Preformatted print_r
 * 
 * @param mixed $data Data to debug
 */
function preint_r($data)
{
  //if ( current_user_can( 'manage_options' ) ) {
  echo '<pre style="background: #fff; color: #000; padding: 10px; z-index: 9999; position: relative; border: 1px solid red; text-align: left;" class="text-xs leading-none">';
  print_r($data);
  echo '</pre>';
  //}
}

/**
 * Display Breadcrumbs
 */
function civ_breadcrumbs()
{
  $home = '<a href="' . home_url() . '" class="no-underline text-body inline-block hover:text-red transition-colors">' . __('Home', 'goodshep-theme') . '</a>';
  $separator = '<span class="inline-block mx-2 text-gray-400">/</span>';
  $parent = '';
  $current_page = '<span class="inline-block font-medium text-body">' . get_the_title() . '</span>';

  if (is_tax(['service_category', 'service_tag'])) {
    $term = get_queried_object();
    $term_name =  $term->name;
    $parent = '<span class="inline-block">' . __('Our Services', 'goodshep-theme') . '</span>';
    $current_page = '<span class="inline-block text-red">' . $term_name . '</span>';
  } else if (is_singular('services')) {
    $parent = '<span class="inline-block">' . __('Our Services', 'goodshep-theme') . '</span>';
  } else if (is_singular('jobs')) {
    $parent = '<span class="inline-block">' . __('Get Involved', 'goodshep-theme') . '</span>' . $separator . '<span class="inline-block"><a class="text-body no-underline hover:text-red transition-colors" href="/careers-with-us/">' . __('Careers with Us', 'goodshep-theme') . '</a></span>';
  } else if (is_page_template('page-templates/media-coverage.php')) {
    $parent = '<span class="inline-block">' . __('News and Events', 'goodshep-theme') . '</span>';
  } else if (is_singular('publications')) {
    $current_page = '<span class="inline-block">' . __('Our Research', 'goodshep-theme') . '</span>';
  } else if (is_singular('events')) {
    $parent = '<span class="inline-block">' . __('Events', 'goodshep-theme') . '</span>';
  } else if (is_singular('media_coverage')) {
    $parent = '<span class="inline-block">' . __('Media Releases', 'goodshep-theme') . '</span>';
  }

  $output = '<nav aria-label="Breadcrumb" class="breadcrumbs text-lg">';
  $output .= $home;
  $output .= $separator;

  if ($parent) {
    $output .= $parent;
    $output .= $separator;
  }

  $output .= $current_page;
  $output .= '</nav>';

  echo $output;
}
