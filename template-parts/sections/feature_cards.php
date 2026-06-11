<?php

/**
 * Section: Feature Cards
 */

include get_template_directory() . '/template-parts/global/section-settings.php';

// Generate stable ID if not set
if (!$section_id) {
  static $feature_cards_count = 0;
  $feature_cards_count++;
  $section_id = 'section-feature-cards-' . get_the_ID() . '-' . $feature_cards_count;
}

$section_id_attr = 'id="' . esc_attr($section_id) . '"';
$section_class = 'section-feature-cards-' . uniqid();

// Get ACF fields.
$feature_cards = get_sub_field('feature_cards'); // Group field.
$columns_settings = get_sub_field('columns_settings') ?? [];
$card_settings = get_sub_field('card_settings') ?? [];

// Bail early if no data.
if (empty($feature_cards)) {
  return;
}

// Content fields.
$headline = $feature_cards['headline'] ?? '';
$cards = $feature_cards['feature_cards'] ?? array(); // Repeater.

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
$grid_key = $columns_settings['grid_columns'] ?? 'three_columns';
$grid_class = $grid_columns_map[$grid_key] ?? $grid_columns_map['three_columns'];

// Don't render section if no content.
if (!$headline && !$cards) {
  return;
}
?>

<section <?php echo $section_id_attr; ?>
  class="civ-feature-cards-section section-wrapper relative overflow-x-hidden <?php echo esc_attr($section_class); ?>"
  style="<?php echo esc_attr($section_style); ?>">

  <?php echo $section_overlay_markup; ?>

  <div
    class="civ-section-container section-container relative z-10 mx-auto <?php echo esc_attr($section_container_class); ?>">
    <div class="container mx-auto px-4 md:px-6 lg:px-8 <?php echo esc_attr($mw_class); ?>">
      <div class="civ-feature-cards-intro text-left">

        <?php if (!empty($headline)): ?>
          <div class="mb-12">
            <?php get_template_part('template-parts/components/heading', null, ['field' => $headline]); ?>
          </div>
        <?php endif; ?>

      </div>

      <?php if ($cards): ?>
        <div class="civ-feature-cards-list grid <?php echo esc_attr($grid_class); ?> gap-6 lg:gap-8">
          <?php
          foreach ($cards as $card):
            // Card Link Details (fetched from image link component)
            $card_link_obj = $card['image']['image']['link'] ?? null;
            $has_link = !empty($card_link_obj) && !empty($card_link_obj['url']);

            $card_link = $has_link ? $card_link_obj['url'] : '';
            $card_target = ($has_link && !empty($card_link_obj['target'])) ? $card_link_obj['target'] : '_self';
            $card_title_attr = ($has_link && !empty($card_link_obj['title'])) ? $card_link_obj['title'] : '';

            // Extract Card Settings (fetched at root level)
            $padding_size = $card_settings['padding_size'] ?? 'default';
            $border = $card_settings['border'] ?? [];
            $border_style = $border['border_style'] ?? 'none';
            $border_color = $border['border_color'] ?? '';
            $box_shadow = $card_settings['box_shadow'] ?? 'none';
            $rounded_corners = $card_settings['rounded_corners'] ?? 'none';

            // Mapping padding
            $padding_map = [
              'tighter' => 'p-4 md:p-5',
              'tight' => 'p-5 md:p-6',
              'default' => 'p-6 md:p-8',
              'wide' => 'p-8 md:p-10',
              'wider' => 'p-10 md:p-12',
            ];
            $padding_class = $padding_map[$padding_size] ?? $padding_map['default'];

            // Mapping shadow
            $shadow_map = [
              'none' => 'shadow-none',
              'sm' => 'shadow-sm',
              'md' => 'shadow-md',
              'lg' => 'shadow-lg',
              'xl' => 'shadow-xl',
              '2xl' => 'shadow-2xl',
            ];
            $shadow_class = $shadow_map[$box_shadow] ?? 'shadow-none';

            // Mapping rounded corners
            $rounded_map = [
              'rounded_none' => 'rounded-none',
              'rounded_md' => 'rounded-md',
              'rounded_lg' => 'rounded-lg',
              'rounded_xl' => 'rounded-xl',
              'rounded_2xl' => 'rounded-2xl',
            ];
            $rounded_class = $rounded_map[$rounded_corners] ?? 'rounded-none';

            // Border styling
            $border_class = ($border_style === 'solid') ? 'border border-solid' : '';
            $card_inline_style = '';
            if ($border_style === 'solid' && $border_color) {
              $card_inline_style .= "border-color: {$border_color};";
            }

            // Gather all card classes
            $card_classes = array_filter([
              'civ-feature-cards-card group relative flex flex-col overflow-hidden transition-all duration-300',
              $padding_class,
              $shadow_class,
              $rounded_class,
              $border_class,
              empty($card_settings['background']['background']['background_color']) && empty($card_settings['background']['background']['background_image']['url']) ? 'bg-white' : ''
            ]);
            $final_card_class = implode(' ', $card_classes);

            $tag = $has_link ? 'a' : 'div';
            $tag_attrs = $has_link ? 'href="' . esc_url($card_link) . '" target="' . esc_attr($card_target) . '" title="' . esc_attr($card_title_attr) . '"' : '';
            ?>
            <<?php echo $tag; ?>     <?php echo $tag_attrs; ?> class="<?php echo esc_attr($final_card_class); ?>" style="<?php echo esc_attr($card_inline_style); ?>">

              <!-- Card Background component -->
              <?php get_template_part('template-parts/components/background', null, ['field' => $card_settings['background'] ?? []]); ?>

              <!-- Content wrapper (keeps elements on top of background) -->
              <div class="relative z-10 w-full h-full flex flex-col">

                <!-- Card Image -->
                <div class="civ-feature-cards-image-wrapper">
                  <?php get_template_part('template-parts/components/image', null, [
                    'field' => $card['image'] ?? [],
                    'disable_link' => true,
                  ]); ?>
                </div>

                <!-- Card Title -->
                <div class="civ-feature-cards-title-wrapper">
                  <?php get_template_part('template-parts/components/heading', null, ['field' => $card['title']]); ?>
                </div>

                <!-- Card Text -->
                <div class="civ-feature-cards-text-wrapper mb-4">
                  <?php get_template_part('template-parts/components/text', null, ['field' => $card['text']]); ?>
                </div>

              </div>

            </<?php echo $tag; ?>>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

</section>