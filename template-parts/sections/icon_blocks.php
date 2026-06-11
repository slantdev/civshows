<?php

/**
 * Section: Icon Blocks
 */

include get_template_directory() . '/template-parts/global/section-settings.php';

// Generate stable ID if not set
if (!$section_id) {
  static $icon_blocks_count = 0;
  $icon_blocks_count++;
  $section_id = 'section-icon-blocks-' . get_the_ID() . '-' . $icon_blocks_count;
}

$section_id_attr = 'id="' . esc_attr($section_id) . '"';
$section_class = 'section-icon-blocks-' . uniqid();

// Get ACF fields.
$icon_blocks = get_sub_field('icon_blocks'); // Group field.
$columns_settings = get_sub_field('columns_settings') ?? [];

// Bail early if no data.
if (empty($icon_blocks)) {
  return;
}

// Content fields.
$headline = $icon_blocks['headline'] ?? '';
$cards = $icon_blocks['icon_blocks'] ?? array(); // Repeater.

// Max Width Mapping
$max_width_map = [
  'none' => 'max-w-none',
  'xs' => 'max-w-screen-xs',
  'sm' => 'max-w-screen-sm',
  'md' => 'max-w-5xl',
  'lg' => 'max-w-screen-lg',
  'xl' => 'max-w-screen-xl',
  '2xl' => 'max-w-screen-2xl',
  'default' => '',
];
$mw_key = $columns_settings['max_width'] ?? 'default';
$mw_class = $max_width_map[$mw_key] ?? $max_width_map['default'];

// Grid Columns Mapping
$grid_columns_map = [
  'one_column' => 'grid-cols-1',
  'two_columns' => 'grid-cols-1 md:grid-cols-2',
  'three_columns' => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
  'four_columns' => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4',
];
$grid_key = $columns_settings['grid_columns'] ?? 'four_columns';
$grid_class = $grid_columns_map[$grid_key] ?? $grid_columns_map['four_columns'];

// Don't render section if no content.
if (!$headline && !$cards) {
  return;
}
?>

<section <?php echo $section_id_attr; ?>
  class="civ-icon-blocks-section section-wrapper relative overflow-x-hidden <?php echo esc_attr($section_class); ?>"
  style="<?php echo esc_attr($section_style); ?>">

  <?php echo $section_overlay_markup; ?>

  <div
    class="civ-section-container section-container relative z-10 mx-auto <?php echo esc_attr($section_container_class); ?>">
    <div class="container mx-auto px-4 md:px-6 lg:px-8 <?php echo esc_attr($mw_class); ?>">
      <div class="civ-icon-blocks-intro text-left">

        <?php if (!empty($headline)): ?>
          <div class="mb-12">
            <?php get_template_part('template-parts/components/heading', null, ['field' => $headline]); ?>
          </div>
        <?php endif; ?>

      </div>

      <?php if ($cards): ?>
        <div class="civ-icon-blocks-list grid <?php echo esc_attr($grid_class); ?> gap-6 lg:gap-8">
          <?php
          foreach ($cards as $card):
            ?>
            <div class="civ-icon-blocks-card">

              <div class="civ-icon-blocks-icon-wrapper mb-4">
                <?php get_template_part('template-parts/components/icon', null, ['field' => $card]); ?>
              </div>

              <div class="civ-icon-blocks-title-wrapper mb-2">
                <?php get_template_part('template-parts/components/heading', null, ['field' => $card]); ?>
              </div>

              <div class="civ-icon-blocks-text-wrapper">
                <?php get_template_part('template-parts/components/text', null, ['field' => $card]); ?>
              </div>

            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

</section>