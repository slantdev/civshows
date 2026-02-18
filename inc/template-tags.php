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
  static $icon_cache = [];

  $atts = shortcode_atts(array(
    'icon'  => '',
    'group' => 'utility',
    'size'  => false,
    'class' => '',
    'label' => '',
  ), $atts);

  if (empty($atts['icon'])) return '';

  // Map ACF Icon Picker tab keys to folder paths
  $group_map = [
    'heroicons_solid'   => 'heroicons/solid',
    'heroicons_outline' => 'heroicons/outline',
  ];

  $group_path = $group_map[$atts['group']] ?? str_replace('_', '/', $atts['group']);
  $icon_path  = get_template_directory() . '/assets/icons/' . $group_path . '/' . $atts['icon'] . '.svg';

  // Return cached version if available (without instance-specific attributes)
  $cache_key = $group_path . ':' . $atts['icon'];
  if (!isset($icon_cache[$cache_key])) {
    if (!file_exists($icon_path)) {
      $icon_cache[$cache_key] = false;
      return '';
    }
    $svg = file_get_contents($icon_path);
    // Basic cleanup
    $svg = preg_replace("/([\n\t]+)/", ' ', $svg);
    $svg = preg_replace('/>\s*</', '><', $svg);
    $icon_cache[$cache_key] = $svg;
  }

  if (!$icon_cache[$cache_key]) return '';

  $svg = $icon_cache[$cache_key];

  // Prepare instance-specific attributes
  $classes = trim('svg-icon ' . $atts['class']);
  $attrs   = sprintf(' class="%s" role="img" focusable="false"', esc_attr($classes));

  if ($atts['size']) {
    $attrs .= sprintf(' width="%d" height="%d"', $atts['size'], $atts['size']);
  }

  if ($atts['label']) {
    $attrs .= sprintf(' aria-label="%s"', esc_attr($atts['label']));
  } else {
    $attrs .= ' aria-hidden="true"';
  }

  // Inject attributes into the opening <svg> tag
  return preg_replace('/<svg/', '<svg' . $attrs, $svg, 1);
}

/**
 * Get Video Metadata (YouTube/Vimeo)
 * 
 * @param string $url The video or embed URL.
 * @return array|false Array of metadata or false if not supported.
 */
function civ_get_video_data($url)
{
  if (empty($url)) return false;

  $data = [
    'id'        => '',
    'platform'  => '',
    'thumbnail' => '',
    'fallback'  => '',
    'url'       => $url
  ];

  // YouTube
  if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $url, $match)) {
    $data['id']        = $match[1];
    $data['platform']  = 'youtube';
    $data['thumbnail'] = "https://img.youtube.com/vi/{$data['id']}/maxresdefault.jpg";
    $data['fallback']  = "https://img.youtube.com/vi/{$data['id']}/hqdefault.jpg";
    return $data;
  }

  // Vimeo
  if (preg_match('/vimeo\.com\/(?:video\/)?([0-9]+)/i', $url, $match)) {
    $data['id']       = $match[1];
    $data['platform'] = 'vimeo';

    // Check transient cache first
    $cache_key = 'vimeo_thumb_' . $data['id'];
    $cached_thumb = get_transient($cache_key);

    if ($cached_thumb) {
      $data['thumbnail'] = $cached_thumb;
    } else {
      // Fetch from Vimeo API
      $response = wp_remote_get("https://vimeo.com/api/v2/video/{$data['id']}.json");
      if (!is_wp_error($response)) {
        $body = json_decode(wp_remote_retrieve_body($response), true);
        if (!empty($body[0]['thumbnail_large'])) {
          $data['thumbnail'] = $body[0]['thumbnail_large'];
          set_transient($cache_key, $data['thumbnail'], DAY_IN_SECONDS);
        }
      }
    }
    return $data;
  }

  return false;
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

/**
 * Get Social Media Icon SVG
 * 
 * @param string $platform Platform slug (facebook, youtube, instagram, tiktok, x).
 * @param string $class Additional CSS classes.
 * @return string SVG markup.
 */
function civ_get_social_icon($platform, $class = 'w-6 h-6')
{
  $icons = [
    'facebook' => '<svg class="' . esc_attr($class) . '" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>',
    'instagram' => '<svg class="' . esc_attr($class) . '" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.468 2.373c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>',
    'youtube' => '<svg class="' . esc_attr($class) . '" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" /></svg>',
    'tiktok' => '<svg class="' . esc_attr($class) . '" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12.525.02c1.31 0 2.591.214 3.751.63V4.65c-1.16-.416-2.441-.63-3.751-.63-1.31 0-2.591.214-3.751.63v4.032c1.16-.416 2.441-.63 3.751-.63 1.31 0 2.591.214 3.751.63v4.032c-1.16-.416-2.441-.63-3.751-.63-1.31 0-2.591.214-3.751.63v4.032c1.16-.416 2.441-.63 3.751-.63 1.31 0 2.591.214 3.751.63v4.032c-1.16-.416-2.441-.63-3.751-.63-1.31 0-2.591.214-3.751.63V.02h3.751z"/></svg>', // Simple placeholder for tiktok
    'x' => '<svg class="' . esc_attr($class) . '" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" /></svg>',
  ];

  return $icons[$platform] ?? '';
}
