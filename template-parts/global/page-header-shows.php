<?php

/**
 * Component: Page Header
 */

// --- Dynamic Navigation Logic (Moved up to determine context for fields) ---
$current_id = get_the_ID();
$parent_id = wp_get_post_parent_id($current_id);

// If no parent, then THIS is the parent
if (!$parent_id) {
  $parent_id = $current_id;
}

// Get Parent Fields for consistent branding across children
// We use the current ID for the main header content (Backgrounds, Title, Subtitle)
// But we might want the "Show Name" in the nav bar to always be the Parent's name.
$enable_page_header = get_field('enable_page_header', $parent_id);

if (!$enable_page_header) return;

$page_header_settings = get_field('page_header_settings', $parent_id) ?? [];

// Extract Title Settings
$title_settings = $page_header_settings['title'] ?? [];
$show_title = $title_settings['show_title'] ?? false;
$title_text = !empty($title_settings['title']) ? $title_settings['title'] : get_the_title($parent_id);
$title_color = $title_settings['title_color'] ?? '#ffffff';

// Extract Subtitle Settings
$subtitle_settings = $page_header_settings['subtitle'] ?? [];
$show_subtitle = $subtitle_settings['show_subtitle'] ?? false;
$subtitle_text = $subtitle_settings['subtitle'] ?? '';
$subtitle_color = $subtitle_settings['subtitle_color'] ?? '#ffffff';

// Extract Logo Settings
$logo_settings = $page_header_settings['show_logo'] ?? [];
$show_logo = $logo_settings['show_logo'] ?? false;
$logo_image = $logo_settings['logo_image'] ?? [];
$logo_url = is_array($logo_image) ? $logo_image['url'] : '';

// Extract Breadcrumbs Settings
$breadcrumbs_settings = $page_header_settings['breadcrumbs'] ?? [];
$show_breadcrumbs = $breadcrumbs_settings['show_breadcrumbs'] ?? false;
$breadcrumbs_text_color = $breadcrumbs_settings['breadcrumbs_text_color'] ?? '#ffffff';
$separator_color = $breadcrumbs_settings['separator_color'] ?? '#ffffff';

// Extract Background Settings
$background_settings = $page_header_settings['background'] ?? [];
$background_images = $background_settings['background_image'] ?? [];
$background_colors = $background_settings['background_colors'] ?? [];

$bg_desktop = $background_images['background_desktop']['background_desktop'] ?? '';
$bg_desktop_pos = $background_images['background_desktop']['background_position'] ?? 'center';

$bg_mobile = $background_images['background_mobile']['background_mobile'] ?? '';
$bg_mobile_pos = $background_images['background_mobile']['background_position'] ?? 'center';

// Fallback to desktop image if mobile is missing, or vice versa
$bg_desktop_url = is_array($bg_desktop) ? $bg_desktop['url'] : ($bg_desktop ?: '');
$bg_mobile_url = is_array($bg_mobile) ? $bg_mobile['url'] : ($bg_mobile ?: $bg_desktop_url);

if (empty($bg_desktop_url) && !empty($bg_mobile_url)) {
  $bg_desktop_url = $bg_mobile_url;
}

$bg_color = $background_colors['background_color'] ?? '';
$bg_overlay = $background_colors['background_overlay'] ?? 'rgba(0,0,0,0.5)';

$child_navigation = $page_header_settings['child_navigation'] ?? [];
$show_child_navigation = $child_navigation['show_child_navigation'] ?? false;

// Generate Inline CSS for Backgrounds
$style_attr = '';
if ($bg_color) {
  $style_attr .= "background-color: {$bg_color};";
}

// --- Parent Data for Navigation Bar ---
$parent_permalink = get_permalink($parent_id);

// Use the determined title text (from ACF or Post Title) for the nav label
$parent_nav_label = $title_text;


// Fetch Children Posts (Custom Post Type 'shows')
$child_args = [
  'post_type'      => 'shows',
  'post_parent'    => $parent_id,
  'posts_per_page' => -1,
  'orderby'        => 'menu_order',
  'order'          => 'ASC',
  'post_status'    => 'publish'
];
$child_query = new WP_Query($child_args);

?>

<section class="civ-page-header w-full relative bg-cover bg-no-repeat" style="<?php echo esc_attr($style_attr); ?>">

  <!-- Background Images -->
  <div class="civ-page-header-bg absolute inset-0 z-0">
    <!-- Desktop Image -->
    <div class="hidden md:block absolute inset-0 bg-cover bg-no-repeat"
      style="background-image: url('<?php echo esc_url($bg_desktop_url); ?>'); background-position: <?php echo esc_attr($bg_desktop_pos); ?>;">
    </div>
    <!-- Mobile Image -->
    <div class="block md:hidden absolute inset-0 bg-cover bg-no-repeat"
      style="background-image: url('<?php echo esc_url($bg_mobile_url); ?>'); background-position: <?php echo esc_attr($bg_mobile_pos); ?>;">
    </div>
    <!-- Overlay -->
    <div class="absolute inset-0" style="background-color: <?php echo esc_attr($bg_overlay); ?>;"></div>
  </div>

  <div class="civ-page-header-content container mx-auto px-4 md:px-6 lg:px-8 pt-28 pb-6 md:pt-44 md:pb-8 lg:pb-10 xl:pb-12 xl:px-8 xl:pt-60 2xl:pt-62 relative z-10">

    <?php if ($show_breadcrumbs): ?>
      <div class="civ-page-header-breadcrumbs flex justify-center mb-6 md:hidden">
        <?php civ_breadcrumbs(['text_color' => $breadcrumbs_text_color, 'wrap' => true]); ?>
      </div>
    <?php endif; ?>

    <div class="flex flex-col md:flex-row items-end justify-between gap-6 lg:gap-10 2xl:gap-12">
      <div class="w-full md:w-3/5">
        <?php if ($show_logo && $logo_url): ?>
          <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($title_text); ?>" class="max-w-[86%] mx-auto h-auto mb-4 md:hidden">
        <?php endif; ?>

        <?php if ($show_title): ?>
          <h1 class="civ-page-header-title text-4xl lg:text-5xl 2xl:text-5xl font-semibold leading-tight hidden md:block" style="color: <?php echo esc_attr($title_color); ?>;">
            <?php echo wp_kses_post($title_text); ?>
          </h1>
        <?php endif; ?>

        <?php if ($show_subtitle && $subtitle_text): ?>
          <div class="civ-page-header-subtitle text-lg lg:text-xl 2xl:text-2xl text-center md:text-left" style="color: <?php echo esc_attr($subtitle_color); ?>;">
            <?php echo wp_kses_post($subtitle_text); ?>
          </div>
        <?php endif; ?>
      </div>

      <div class="w-full hidden md:flex md:w-2/5 items-start justify-start md:items-center md:justify-center">
        <?php if ($show_logo && $logo_url): ?>
          <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($title_text); ?>" class="max-w-full lg:max-w-96 h-auto">
        <?php endif; ?>
      </div>
    </div>

    <?php if ($show_breadcrumbs): ?>
      <div class="civ-page-header-breadcrumbs hidden md:flex">
        <div class="w-full lg:w-3/5">
          <div class="h-0.5 w-full bg-white/40 my-6" style="background-color: <?php echo esc_attr($separator_color); ?>; opacity: 0.4;"></div>

          <?php civ_breadcrumbs(['text_color' => $breadcrumbs_text_color, 'wrap' => true]); ?>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <?php if ($show_child_navigation): ?>
    <?php if ($child_query->have_posts()) : ?>
      <div class="civ-page-header-child-nav w-full relative z-10">
        <div class="container mx-auto xl:px-8">
          <div class="flex flex-col md:flex-row items-stretch md:items-center">

            <div class="hidden lg:flex text-white font-bold uppercase py-4 px-4 lg:pl-8 xl:pl-0 tracking-wide md:w-auto shrink-0 grow items-center justify-center md:justify-start">
              <a href="<?php echo esc_url($parent_permalink); ?>" class="civ-page-header-child-nav-parent-link hover:underline"><?php echo wp_kses_post($parent_nav_label); ?></a>
            </div>

            <div class="overflow-x-auto overflow-y-hidden bg-gray-100">
              <ul class="flex items-center whitespace-nowrap text-civ-blue-900 text-xs md:text-sm font-bold uppercase tracking-tight">


                <?php while ($child_query->have_posts()) : $child_query->the_post();
                  $is_active = get_the_ID() === $current_id;
                  $active_classes = $is_active ? 'bg-white text-civ-orange-500 border-b border-b-white border-r border-r-gray-300' : 'border-b border-r border-gray-300 hover:text-civ-orange-500 hover:bg-civ-orange-100';
                ?>
                  <li class="h-full">
                    <a href="<?php the_permalink(); ?>" class="civ-page-header-child-nav-link block py-4 xl:py-5 px-6 xl:px-8 2xl:px-10 transition-colors <?php echo $active_classes; ?>">
                      <?php the_title(); ?>
                    </a>
                  </li>
                <?php endwhile; ?>
              </ul>
            </div>

          </div>
        </div>
      </div>
      <?php
      wp_reset_postdata(); ?>
    <?php endif; ?>
  <?php endif; ?>
</section>