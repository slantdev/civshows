<?php

/**
 * Enqueue scripts and styles.
 */
function civ_enqueue_scripts()
{
  $theme_version = wp_get_theme()->get('Version');
  $hot_file = get_theme_file_path('hot');

  // Enqueue Google Fonts: Roboto
  wp_enqueue_style('civ-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap', [], null);

  if (file_exists($hot_file)) {
    // Vite Development Mode
    $vite_dev_server = file_get_contents($hot_file);
    $vite_dev_server = trim($vite_dev_server);

    wp_enqueue_script('vite-client', "$vite_dev_server/@vite/client", [], null, true);
    wp_enqueue_script('civ-main', "$vite_dev_server/src/main.js", [], null, true);

    // Inject module type
    add_filter('script_loader_tag', function ($tag, $handle, $src) {
      if ($handle === 'civ-main' || $handle === 'vite-client') {
        return '<script type="module" src="' . esc_url($src) . '"></script>';
      }
      return $tag;
    }, 10, 3);
  } else {
    // Production Mode
    $js_file = get_theme_file_uri('assets/js/main.js');
    $css_file = get_theme_file_uri('assets/css/main.css');

    // Enqueue CSS
    // Check if file exists via path for safety, though uri is used for enqueue
    if (file_exists(get_theme_file_path('assets/css/main.css'))) {
      wp_enqueue_style('civ-style', $css_file, [], $theme_version);
    }

    // Enqueue JS
    if (file_exists(get_theme_file_path('assets/js/main.js'))) {
      wp_enqueue_script('civ-main', $js_file, [], $theme_version, true);
    }
  }
}
add_action('wp_enqueue_scripts', 'civ_enqueue_scripts');

/**
 * Enqueue scripts and styles in WordPress admin.
 */
function civ_admin_styles()
{
  global $pagenow;
  $current_page = get_current_screen();
  $theme = wp_get_theme();
  wp_enqueue_style('admin_css', get_template_directory_uri() . '/assets/css/admin-style.css', false, filemtime(get_stylesheet_directory() . '/assets/css/admin-style.css'));
  wp_enqueue_style('admin_gfonts', 'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Poppins:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap', false, $theme->get('Version'));
  if (
    ($current_page->post_type === 'page' && ($pagenow === 'post-new.php' || $pagenow === 'post.php')) ||
    ($current_page->post_type === 'shows' && ($pagenow === 'post-new.php' || $pagenow === 'post.php'))
  ) {
    wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css', array(), '8.4.7');
    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js', array(), '8.4.7');
    wp_enqueue_style('acf_layouts', get_template_directory_uri() . '/assets/css/acf-layouts.css', false, filemtime(get_stylesheet_directory() . '/assets/css/acf-layouts.css'));
  }
}
add_action('admin_enqueue_scripts', 'civ_admin_styles');
