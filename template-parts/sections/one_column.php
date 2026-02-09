<?php
include get_template_directory() . '/template-parts/global/section-settings.php';
/*
 * Available section variables:
 * $section_id
 * $section_style
 * $section_container_class
 * $section_overlay_markup
 */

$section_id_attr = $section_id ? 'id="' . esc_attr($section_id) . '"' : '';
$section_class = 'section-onecolumn-' . uniqid();

// Components
$one_column = get_sub_field('one_column');
$components = $one_column['components'] ?? [];

// Column Settings
$column_settings = get_sub_field('column_settings') ?? [];

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
$mw_key = $column_settings['max_width'] ?? 'default';
$mw_class = $max_width_map[$mw_key] ?? $max_width_map['default'];

// Alignment Mapping
$alignment_map = [
  'left'   => 'text-left',
  'center' => 'text-center',
  'right'  => 'text-right',
];
$align_key = $column_settings['alignment'] ?? 'center';
$align_class = $alignment_map[$align_key] ?? $alignment_map['center'];

// Consolidate classes for the inner container
$container_classes = array_filter([
  'container mx-auto',
  'px-4 sm:px-6 lg:px-8',
  $mw_class,
  $align_class
]);
$final_container_class = implode(' ', $container_classes);

?>

<section <?php echo $section_id_attr; ?> class="<?php echo esc_attr($section_class); ?> section-wrapper relative" style="<?php echo esc_attr($section_style); ?>">

  <?php echo $section_overlay_markup; ?>

  <div class="section-container relative z-10 <?php echo esc_attr($section_container_class); ?>">
    <div class="<?php echo esc_attr($final_container_class); ?>">
      <div class="section-content">
        <?php get_template_part('template-parts/components/components', '', array('field' => $components)); ?>
      </div>
    </div>
  </div>

</section>