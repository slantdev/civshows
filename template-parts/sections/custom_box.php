<?php
include get_template_directory() . '/template-parts/global/section-settings.php';

// Generate stable ID
if (!$section_id) {
  static $custom_box_count = 0;
  $custom_box_count++;
  $section_id = 'section-custom-box-' . get_the_ID() . '-' . $custom_box_count;
}

$section_id_attr = 'id="' . esc_attr($section_id) . '"';
$section_class_name = 'section-custom-box-' . uniqid();

// Data
$custom_box       = get_sub_field('custom_box');
$columns_settings = $custom_box['custom_box_settings'] ?? [];
$headline         = $custom_box['headline'] ?? [];
$boxes            = $custom_box['boxes'] ?? [];

// Layout
$column_ratio  = $columns_settings['column_ratio'] ?? 'three_columns';
$max_width_key = $columns_settings['max_width'] ?? 'default';
$rounded_key   = $columns_settings['rounded'] ?? 'rounded_xl';

$rounded_map = [
  'rounded_none' => 'rounded-none',
  'rounded_md'   => 'rounded-md',
  'rounded_lg'   => 'rounded-lg',
  'rounded_xl'   => 'rounded-xl',
  'rounded_2xl'  => 'rounded-2xl',
];
$rounded_class = $rounded_map[$rounded_key] ?? 'rounded-xl';

$grid_class = match ($column_ratio) {
  'two_columns'   => 'grid-cols-1 md:grid-cols-2',
  'four_columns'  => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',
  default         => 'grid-cols-1 md:grid-cols-3', // three_columns
};

// Max Width
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

$container_classes = array_filter([
  'container mx-auto px-4 sm:px-6 lg:px-8',
  $mw_class
]);
$final_container_class = implode(' ', $container_classes);

?>

<section <?php echo $section_id_attr; ?> class="civ-custom-box-section relative overflow-x-hidden <?php echo esc_attr($section_class_name); ?>" style="<?php echo esc_attr($section_style); ?>">

  <?php echo $section_overlay_markup; ?>

  <div class="relative z-10 <?php echo esc_attr($section_container_class); ?>">
    <div class="<?php echo esc_attr($final_container_class); ?>">

      <?php if (!empty($headline)) : ?>
        <div class="civ-custom-box-headline mb-12">
          <?php get_template_part('template-parts/components/heading', '', ['field' => $headline]); ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($boxes)) : ?>
        <div class="civ-custom-boxes grid gap-6 xl:gap-8 <?php echo esc_attr($grid_class); ?>">

          <?php foreach ($boxes as $box) :
            $box_content = $box['box_content'] ?? [];
            $settings    = $box['settings'] ?? [];

            // Handle clone prefixing
            $components = $box_content['components_components'] ?? ($box_content['components'] ?? []);

            // Wrap background for background.php
            $bg_data    = $settings['background_background'] ?? ($settings['background'] ?? []);
            $background = ['background' => $bg_data];

            $link      = $settings['link'] ?? '';
            $alignment = $settings['alignment'] ?? '';

            // Alignment mapping
            $align_class = match ($alignment) {
              'center' => 'items-center text-center',
              'right'  => 'items-end text-right',
              default  => 'items-start text-left', // left
            };

            $is_link = is_array($link) && !empty($link['url']);
            $wrapper_tag = $is_link ? 'a' : 'div';
            $wrapper_attrs = $is_link
              ? sprintf('href="%s" target="%s"', esc_url($link['url']), esc_attr($link['target'] ?: '_self'))
              : '';
          ?>
            <<?php echo $wrapper_tag; ?> <?php echo $wrapper_attrs; ?> class="group relative w-full h-full min-h-[300px] flex flex-col overflow-hidden <?php echo esc_attr($rounded_class); ?>">

              <?php if (!empty(array_filter($bg_data))) : ?>
                <div class="absolute inset-0 z-0">
                  <?php get_template_part('template-parts/components/background', '', ['field' => $background]); ?>
                </div>
              <?php endif; ?>

              <div class="relative z-10 h-full p-8 flex flex-col justify-center <?php echo esc_attr($align_class); ?>">
                <?php get_template_part('template-parts/components/components', '', ['field' => $components]); ?>
              </div>

            </<?php echo $wrapper_tag; ?>>
          <?php endforeach; ?>

        </div>
      <?php endif; ?>

    </div>
  </div>

</section>