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

// More Settings (Paddings, Borders, Shadows)
$more_settings = $columns_settings['more_settings'] ?? [];

// Paddings
$box_paddings = $more_settings['box_paddings'] ?? [];
$padding_size = $box_paddings['padding_size'] ?? 'default';

$padding_map = [
  'tighter' => 'p-4',
  'tight'   => 'p-6',
  'default' => 'p-8',
  'wide'    => 'p-10',
  'wider'   => 'p-12',
];
$padding_class = $padding_map[strtolower($padding_size)] ?? 'p-8';

// Shadows
$box_shadow_settings = $more_settings['box_shadow'] ?? [];
$box_shadow = $box_shadow_settings['box_shadow'] ?? 'none';

$shadow_map = [
  'none' => 'shadow-none',
  'sm'   => 'shadow-sm',
  'md'   => 'shadow-md',
  'lg'   => 'shadow-lg',
  'xl'   => 'shadow-xl',
  '2xl'  => 'shadow-2xl',
];
$shadow_class = $shadow_map[$box_shadow] ?? 'shadow-none';

// Borders
$border_settings = $more_settings['border'] ?? [];
$border_style = $border_settings['border_style'] ?? 'none';
$border_color = $border_settings['border_color'] ?? '#d1d5db';

$box_classes = [
  'group block relative w-full h-full min-h-[300px] flex flex-col overflow-hidden transition-all duration-300',
  $rounded_class,
  $shadow_class
];

$box_styles = [];
if ($border_style !== 'none') {
  $box_classes[] = 'border';
  if ($border_style === 'solid') {
    $box_classes[] = 'border-solid';
  }
  if (!empty($border_color)) {
    $box_styles[] = "border-color: {$border_color}";
  }
}

$final_box_class = implode(' ', $box_classes);
$final_box_style_attr = !empty($box_styles) ? 'style="' . esc_attr(implode('; ', $box_styles)) . '"' : '';

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

            $link_type  = $settings['link_type'] ?? 'none';
            $alignments = $settings['alignments'] ?? [];
            $text_align = $alignments['text_align'] ?? 'center';
            $vert_align = $alignments['vertical_align'] ?? 'top';

            // Text Alignment mapping
            $text_align_class = match ($text_align) {
              'left'  => 'text-left',
              'right' => 'text-right',
              'center' => 'text-center',
              default => 'text-left',
            };

            // Vertical Alignment mapping
            $vert_align_class = match ($vert_align) {
              'center', 'middle' => 'justify-center',
              'bottom'           => 'justify-end',
              default            => '', // top
            };

            $is_link = false;
            $wrapper_tag = 'div';
            $wrapper_attrs = '';

            if ($link_type === 'show-exhibitor') {
              $exhibitor_link = $settings['show_exhibitor_link'] ?? [];
              $show_page = $exhibitor_link['select_show_page'] ?? '';
              $cat_id = $exhibitor_link['exhibitor_category'] ?? '';

              if ($show_page) {
                $url = $show_page;
                if ($url && $cat_id) {
                  $term = get_term($cat_id, 'exhibitor-category');
                  if ($term && !is_wp_error($term)) {
                    $url = rtrim($url, '/') . '/?cat=' . esc_attr($term->slug);
                  }
                }
                if ($url) {
                  $is_link = true;
                  $wrapper_tag = 'a';
                  $wrapper_attrs = sprintf('href="%s"', esc_url($url));
                }
              }
            } elseif ($link_type === 'custom') {
              $custom_link = $settings['custom_link'] ?? '';
              if (is_array($custom_link) && !empty($custom_link['url'])) {
                $is_link = true;
                $wrapper_tag = 'a';
                $wrapper_attrs = sprintf('href="%s" target="%s"', esc_url($custom_link['url']), esc_attr($custom_link['target'] ?: '_self'));
              }
            }
          ?>
            <<?php echo $wrapper_tag; ?> <?php echo $wrapper_attrs; ?> class="<?php echo esc_attr($final_box_class); ?>" <?php echo $final_box_style_attr; ?>>

              <?php if (!empty(array_filter($bg_data))) : ?>
                <div class="absolute inset-0 z-0">
                  <?php get_template_part('template-parts/components/background', '', ['field' => $background]); ?>
                </div>
              <?php endif; ?>

              <div class="relative z-10 h-full <?php echo esc_attr($padding_class); ?> flex flex-col <?php echo esc_attr($vert_align_class); ?> <?php echo esc_attr($text_align_class); ?>">
                <?php get_template_part('template-parts/components/components', '', ['field' => $components]); ?>
              </div>

            </<?php echo $wrapper_tag; ?>>
          <?php endforeach; ?>

        </div>
      <?php endif; ?>

    </div>
  </div>

</section>