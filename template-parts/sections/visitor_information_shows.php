<?php
include get_template_directory() . '/template-parts/global/section-settings.php';
/*
 * Available section variables (from section-settings.php):
 * $section_id
 * $section_style
 * $section_container_class
 * $section_overlay_markup
 */

// Generate stable ID if not set
if (!$section_id) {
  static $visitor_info_count = 0;
  $visitor_info_count++;
  $section_id = 'section-visitor-info-' . get_the_ID() . '-' . $visitor_info_count;
}

$section_id_attr = 'id="' . esc_attr($section_id) . '"';

// Data
$visitor_info = get_sub_field('visitor_information');
$left_column  = $visitor_info['left_column'] ?? [];
$right_column = $visitor_info['right_column'] ?? [];

$google_map = $left_column['google_map'] ?? [];
$components = $right_column['components'] ?? [];

?>

<section <?php echo $section_id_attr; ?> class="section-visitor-information w-full flex flex-col lg:flex-row relative overflow-hidden" style="<?php echo esc_attr($section_style); ?>">

  <?php echo $section_overlay_markup; ?>

  <!-- Left Column: Google Map -->
  <div class="w-full lg:w-5/12 relative min-h-[400px] lg:min-h-auto bg-gray-100">
    <?php if (!empty($google_map['lat']) && !empty($google_map['lng'])) : ?>
      <div class="acf-map absolute inset-0 w-full h-full" data-zoom="<?php echo esc_attr($google_map['zoom'] ?? 14); ?>">
        <div class="marker" data-lat="<?php echo esc_attr($google_map['lat']); ?>" data-lng="<?php echo esc_attr($google_map['lng']); ?>"></div>
      </div>
    <?php else : ?>
      <div class="flex items-center justify-center h-full text-gray-400 italic">
        <?php _e('Map coordinates not set.', 'civ-shows'); ?>
      </div>
    <?php endif; ?>
  </div>

  <!-- Right Column: Components -->
  <div class="w-full lg:w-7/12 relative">

    <div class="section-container relative z-10 px-6 md:px-12 lg:px-20 <?php echo esc_attr($section_container_class); ?>">
      <div class="section-content">
        <?php get_template_part('template-parts/components/components', '', array('field' => $components)); ?>
      </div>
    </div>

  </div>

</section>