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
  static $three_columns_count = 0;
  $three_columns_count++;
  $section_id = 'section-three-cols-' . get_the_ID() . '-' . $three_columns_count;
}

$section_id_attr = 'id="' . esc_attr($section_id) . '"';
$section_class_name = 'section-three-columns-' . uniqid();

// Data
$three_columns    = get_sub_field('three_columns');
$columns_settings = $three_columns['columns_settings'] ?? [];
$col_1_components = $three_columns['column_1_components_components'] ?? [];
$col_2_components = $three_columns['column_2_components_components'] ?? [];
$col_3_components = $three_columns['column_3_components_components'] ?? [];

// Column Settings & Width Mapping
$column_ratio  = $columns_settings['column_ratio'] ?? 'one_third';
$max_width_key = $columns_settings['max_width'] ?? 'default';
$column_style = $columns_settings['style'] ?? 'default';

$ratio_map = [
  'one_third'          => ['w-full lg:w-1/3', 'w-full lg:w-1/3', 'w-full lg:w-1/3'],
  'one_one_two_fourth' => ['w-full lg:w-1/4', 'w-full lg:w-1/4', 'w-full lg:w-2/4'],
  'one_two_one_fourth' => ['w-full lg:w-1/4', 'w-full lg:w-2/4', 'w-full lg:w-1/4'],
  'two_one_one_fourth' => ['w-full lg:w-2/4', 'w-full lg:w-1/4', 'w-full lg:w-1/4'],
];

[$col_1_width, $col_2_width, $col_3_width] = $ratio_map[$column_ratio] ?? $ratio_map['one_third'];

// Max Width Mapping
$max_width_map = [
  'none'    => 'max-w-none',
  'xs'      => 'max-w-screen-xs',
  'sm'      => 'max-w-screen-sm',
  'md'      => 'max-w-screen-md',
  'lg'      => 'max-w-screen-lg',
  'xl'      => 'max-w-screen-xl',
  '2xl'     => 'max-w-screen-2xl',
  'default' => '',
];
$mw_class = $max_width_map[$max_width_key] ?? '';

// Container Classes
$container_classes = array_filter([
  'container mx-auto px-4 sm:px-6 lg:px-8',
  $mw_class
]);
$final_container_class = implode(' ', $container_classes);

// Card Classes
$card_classes = ($column_style === 'card')
  ? 'p-4 rounded-lg bg-white shadow-md lg:p-6 lg:rounded-xl lg:shadow-lg xl:p-8 xl:rounded-2xl xl:shadow-xl'
  : '';

?>

<section <?php echo $section_id_attr; ?> class="section-three-columns section-wrapper relative overflow-x-hidden <?php echo esc_attr($section_class_name); ?>" style="<?php echo esc_attr($section_style); ?>">

  <?php echo $section_overlay_markup; ?>

  <div class="section-container relative z-10 <?php echo esc_attr($section_container_class); ?>">
    <div class="<?php echo esc_attr($final_container_class); ?>">

      <div class="section-content flex flex-col lg:flex-row gap-6 xl:gap-10">

        <div class="column-1 <?php echo esc_attr($col_1_width); ?> <?php echo esc_attr($card_classes); ?>">
          <?php get_template_part('template-parts/components/components', '', array('field' => $col_1_components)); ?>
        </div>

        <div class="column-2 <?php echo esc_attr($col_2_width); ?> <?php echo esc_attr($card_classes); ?>">
          <?php get_template_part('template-parts/components/components', '', array('field' => $col_2_components)); ?>
        </div>

        <div class="column-3 <?php echo esc_attr($col_3_width); ?> <?php echo esc_attr($card_classes); ?>">
          <?php get_template_part('template-parts/components/components', '', array('field' => $col_3_components)); ?>
        </div>

      </div>

    </div>
  </div>

</section>