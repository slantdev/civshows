<?php

/**
 * Section: Product Cards
 */

include get_template_directory() . '/template-parts/global/section-settings.php';

// Generate stable ID if not set
if (!$section_id) {
  static $product_cards_count = 0;
  $product_cards_count++;
  $section_id = 'section-product-cards-' . get_the_ID() . '-' . $product_cards_count;
}

$section_id_attr = 'id="' . esc_attr($section_id) . '"';
$section_class = 'section-product-cards-' . uniqid();

// Get ACF fields.
$product_cards = get_sub_field('product_cards'); // Group field.
$columns_settings = get_sub_field('columns_settings') ?? [];

// Bail early if no data.
if (empty($product_cards)) {
  return;
}

// Content fields.
$headline = $product_cards['headline'] ?? '';
$cards = $product_cards['product_cards'] ?? array(); // Repeater.

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
$grid_key = $columns_settings['grid_columns'] ?? 'two_columns';
$grid_class = $grid_columns_map[$grid_key] ?? $grid_columns_map['two_columns'];

// Don't render section if no content.
if (!$headline || !$cards) {
  return;
}
?>

<section <?php echo $section_id_attr; ?>
  class="civ-product-cards-section section-wrapper relative overflow-x-hidden <?php echo esc_attr($section_class); ?>"
  style="<?php echo esc_attr($section_style); ?>">

  <?php echo $section_overlay_markup; ?>

  <div
    class="civ-section-container section-container relative z-10 mx-auto <?php echo esc_attr($section_container_class); ?>">
    <div class="container mx-auto px-4 md:px-6 lg:px-8 <?php echo esc_attr($mw_class); ?>">
      <div class="civ-product-cards-intro text-left">

        <?php if (!empty($headline)): ?>
          <div class="mb-6">
            <?php get_template_part('template-parts/components/heading', null, ['field' => $headline]); ?>
          </div>
          <?php
        endif; ?>

      </div>

      <?php if ($cards): ?>
        <div class="civ-product-cards-list mt-12 grid <?php echo esc_attr($grid_class); ?> gap-6 lg:gap-8">
          <?php
          foreach ($cards as $card):
            // Card fields.
            $product_title = $card['product_title'] ?? '';
            $product_link_obj = $card['product_link'] ?? null;
            $has_link = !empty($product_link_obj) && !empty($product_link_obj['url']);

            $product_link = $has_link ? $product_link_obj['url'] : '';
            $product_target = ($has_link && !empty($product_link_obj['target'])) ? $product_link_obj['target'] : '_self';
            $product_title_attr = ($has_link && !empty($product_link_obj['title'])) ? $product_link_obj['title'] : $product_title;

            // Product Image
            $product_image = $card['product_image_group']['product_image'] ?? null;
            $product_image_url = $product_image['url'] ?? '';
            $product_image_alt = $product_image['alt'] ?? $product_title;

            // Background Group.
            $card_background = $card['card_background'] ?? array();
            $bg_color = $card_background['bg_color'] ?? '';
            $rounded_corners = $card_background['rounded_corners'] ?? 'rounded-xl';
            $rounded_map = [
              'rounded_none' => 'rounded-none',
              'rounded_md' => 'rounded-md',
              'rounded_lg' => 'rounded-lg',
              'rounded_xl' => 'rounded-xl',
              'rounded_2xl' => 'rounded-2xl',
            ];
            $rounded_class = $rounded_map[$rounded_corners] ?? 'rounded-xl';

            $tag = $has_link ? 'a' : 'div';
            $tag_attrs = $has_link ? 'href="' . esc_url($product_link) . '" target="' . esc_attr($product_target) . '" title="' . esc_attr($product_title_attr) . '"' : '';

            $tag_classes = [
              'civ-product-cards-card group relative flex flex-col
              items-center overflow-hidden
              no-underline hover:no-underline p-4 md:p-6 xl:p-8',
              $rounded_class,
            ];
            $final_tag_class = implode(' ', $tag_classes);

            $tag_style = $bg_color ? 'style="background-color: ' . esc_attr($bg_color) . '"' : '';

            ?>
            <<?php echo $tag; ?>     <?php echo $tag_attrs; ?> class="<?php echo esc_attr($final_tag_class); ?>" <?php echo $tag_style; ?>>
              <?php if ($product_image_url): ?>
                <img src="<?php echo esc_url($product_image_url); ?>" alt="<?php echo esc_attr($product_image_alt); ?>"
                  class="civ-product-cards-image">
              <?php endif; ?>

              <h3
                class="civ-product-cards-title text-xl md:text-2xl lg:text-3xl leading-tight text-white text-center font-semibold my-0">
                <?php echo esc_html($product_title); ?>
              </h3>
            </<?php echo $tag; ?>>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

</section>