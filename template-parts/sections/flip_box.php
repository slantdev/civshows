<?php
include get_template_directory() . '/template-parts/global/section-settings.php';

// Generate stable ID
if (!$section_id) {
  static $flip_box_count = 0;
  $flip_box_count++;
  $section_id = 'section-flip-box-' . get_the_ID() . '-' . $flip_box_count;
}

$section_id_attr = 'id="' . esc_attr($section_id) . '"';
$section_class_name = 'section-flip-box-' . uniqid();

// Data
$flip_box         = get_sub_field('flip_box');
$columns_settings = $flip_box['columns_settings'] ?? [];
$headline         = $flip_box['headline'] ?? [];
$boxes            = $flip_box['boxes'] ?? [];

// Layout & Animations
$column_ratio   = $columns_settings['column_ratio'] ?? 'three_columns';
$max_width_key  = $columns_settings['max_width'] ?? 'default';
$flip_direction = $columns_settings['flip_direction'] ?? 'horizontal';
$rounded_key    = $columns_settings['rounded'] ?? 'rounded_xl';

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

if ($flip_direction === 'vertical') {
  $hover_rotate_class = 'group-hover:[transform:rotateX(180deg)]';
  $back_rotate_class  = '[transform:rotateX(180deg)]';
} else {
  $hover_rotate_class = 'group-hover:[transform:rotateY(180deg)]';
  $back_rotate_class  = '[transform:rotateY(180deg)]';
}

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

<section <?php echo $section_id_attr; ?> class="civ-flip-box-section relative overflow-x-hidden <?php echo esc_attr($section_class_name); ?>" style="<?php echo esc_attr($section_style); ?>">

  <?php echo $section_overlay_markup; ?>

  <div class="relative z-10 <?php echo esc_attr($section_container_class); ?>">
    <div class="<?php echo esc_attr($final_container_class); ?>">

      <?php if (!empty($headline)) : ?>
        <div class="civ-flip-box-headline mb-12">
          <?php get_template_part('template-parts/components/heading', '', ['field' => $headline]); ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($boxes)) : ?>
        <div class="civ-flip-boxes grid gap-6 xl:gap-8 <?php echo esc_attr($grid_class); ?>">

          <?php foreach ($boxes as $box) :
            $initial = $box['initial_state'] ?? [];
            $hovered = $box['hovered_state'] ?? [];
            $link    = $box['link'] ?? '';

            // Handle ACF clone prefixing quirks
            $initial_components = $initial['components_components'] ?? ($initial['components'] ?? []);
            
            // Wrap the background data so background.php can find it under the 'background' key
            $initial_bg_data = $initial['background_background'] ?? ($initial['background'] ?? []);
            $initial_bg = ['background' => $initial_bg_data];

            $hovered_components = $hovered['components_components'] ?? ($hovered['components'] ?? []);
            
            $hovered_bg_data = $hovered['background_background'] ?? ($hovered['background'] ?? []);
            $hovered_bg = ['background' => $hovered_bg_data];

            $is_link = is_array($link) && !empty($link['url']);
            $wrapper_tag = $is_link ? 'a' : 'div';
            $wrapper_attrs = $is_link
              ? sprintf('href="%s" target="%s"', esc_url($link['url']), esc_attr($link['target'] ?: '_self'))
              : '';
          ?>
            <<?php echo $wrapper_tag; ?> <?php echo $wrapper_attrs; ?> class="group block perspective-[1000px] h-full">
              <div class="relative w-full h-full transition-transform duration-700 transform-3d shadow-md group-hover:shadow-xl <?php echo esc_attr($rounded_class); ?> <?php echo esc_attr($hover_rotate_class); ?>">

                <!-- Front Side -->
                <div class="relative w-full h-full min-h-[300px] flex flex-col backface-hidden <?php echo esc_attr($rounded_class); ?> overflow-hidden bg-white">
                  <?php if (!empty(array_filter($initial_bg_data))) : ?>
                    <div class="absolute inset-0 z-0">
                      <?php get_template_part('template-parts/components/background', '', ['field' => $initial_bg]); ?>
                    </div>
                  <?php endif; ?>
                  <div class="relative z-10 h-full p-8 flex flex-col justify-center">
                    <?php get_template_part('template-parts/components/components', '', ['field' => $initial_components]); ?>
                  </div>
                </div>

                <!-- Back Side -->
                <div class="absolute inset-0 w-full h-full flex flex-col backface-hidden <?php echo esc_attr($rounded_class); ?> overflow-hidden bg-civ-orange-500 <?php echo esc_attr($back_rotate_class); ?>">
                  <?php if (!empty(array_filter($hovered_bg_data))) : ?>
                    <div class="absolute inset-0 z-0">
                      <?php get_template_part('template-parts/components/background', '', ['field' => $hovered_bg]); ?>
                    </div>
                  <?php endif; ?>
                  <div class="relative z-10 h-full p-8 flex flex-col justify-center text-white">
                    <?php get_template_part('template-parts/components/components', '', ['field' => $hovered_components]); ?>
                  </div>
                </div>

              </div>
            </<?php echo $wrapper_tag; ?>>
          <?php endforeach; ?>

        </div>
      <?php endif; ?>

    </div>
  </div>

</section>