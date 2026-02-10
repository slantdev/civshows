<?php
include get_template_directory() . '/template-parts/global/section-settings.php';
/*
 * Available section variables (from section-settings.php):
 * $section_id
 * $section_style
 * $section_container_class
 * $section_overlay_markup
 */

// Generate stable ID if not set in section-settings.php
if (!$section_id) {
  static $two_columns_count = 0;
  $two_columns_count++;
  $section_id = 'section-two-cols-' . get_the_ID() . '-' . $two_columns_count;
}

$section_id_attr = 'id="' . esc_attr($section_id) . '"';
$section_class_name = 'section-two-columns-' . uniqid();

// Data
$two_columns = get_sub_field('two_columns');
$left_components = $two_columns['left_column_components_components'] ?? [];
$right_components = $two_columns['right_column_components_components'] ?? [];

// Column Settings & Width Mapping
$column_ratio = $two_columns['column_settings'] ?? 'half';

$ratio_map = [
  'half'             => ['w-full lg:w-1/2', 'w-full lg:w-1/2'],
  'one_two_third'    => ['w-full lg:w-1/3', 'w-full lg:w-2/3'],
  'two_one_third'    => ['w-full lg:w-2/3', 'w-full lg:w-1/3'],
  'one_three_fourth' => ['w-full lg:w-1/4', 'w-full lg:w-3/4'],
  'three_one_fourth' => ['w-full lg:w-3/4', 'w-full lg:w-1/4'],
  'two_three_five'   => ['w-full lg:w-2/5', 'w-full lg:w-3/5'],
  'three_two_five'   => ['w-full lg:w-3/5', 'w-full lg:w-2/5'],
];

[$col_left_width, $col_right_width] = $ratio_map[$column_ratio] ?? $ratio_map['half'];

// Container Classes
$container_classes = array_filter([
  'container mx-auto px-4 sm:px-6 lg:px-8',
]);
$final_container_class = implode(' ', $container_classes);

?>

<section <?php echo $section_id_attr; ?> class="section-two-columns section-wrapper relative <?php echo esc_attr($section_class_name); ?>" style="<?php echo esc_attr($section_style); ?>">

  <?php echo $section_overlay_markup; ?>

  <div class="section-container relative z-10 <?php echo esc_attr($section_container_class); ?>">
    <div class="<?php echo esc_attr($final_container_class); ?>">
      <div class="section-content flex flex-col lg:flex-row gap-8 xl:gap-20">
        
        <div class="column-left <?php echo esc_attr($col_left_width); ?>">
          <?php get_template_part('template-parts/components/components', '', array('field' => $left_components)); ?>
        </div>

        <div class="column-right <?php echo esc_attr($col_right_width); ?>">
          <?php get_template_part('template-parts/components/components', '', array('field' => $right_components)); ?>
        </div>

      </div>
    </div>
  </div>

</section>
