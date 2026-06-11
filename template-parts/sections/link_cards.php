<?php

/**
 * Section: Link Cards
 */

include get_template_directory() . '/template-parts/global/section-settings.php';

// Generate stable ID if not set
if (!$section_id) {
  static $link_cards_count = 0;
  $link_cards_count++;
  $section_id = 'section-link-cards-' . get_the_ID() . '-' . $link_cards_count;
}

$section_id_attr = 'id="' . esc_attr($section_id) . '"';
$section_class = 'section-link-cards-' . uniqid();

// Get ACF fields.
$link_cards = get_sub_field('link_cards'); // Group field.
$columns_settings = get_sub_field('columns_settings') ?? [];

// Bail early if no data.
if (empty($link_cards)) {
  return;
}

// Content fields.
$headline = $link_cards['headline'] ?? '';
$cards = $link_cards['cards'] ?? array(); // Repeater.

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
  class="civ-link-cards-section section-wrapper relative overflow-x-hidden <?php echo esc_attr($section_class); ?>"
  style="<?php echo esc_attr($section_style); ?>">

  <?php echo $section_overlay_markup; ?>

  <div
    class="civ-section-container section-container relative z-10 mx-auto <?php echo esc_attr($section_container_class); ?>">
    <div class="container mx-auto px-4 md:px-6 lg:px-8 <?php echo esc_attr($mw_class); ?>">
      <div class="civ-link-cards-intro text-left">

        <?php if (!empty($headline)): ?>
          <div class="mb-6">
            <?php get_template_part('template-parts/components/heading', null, ['field' => $headline]); ?>
          </div>
          <?php
        endif; ?>

      </div>

      <?php if ($cards): ?>
        <div class="civ-link-cards-list mt-12 grid <?php echo esc_attr($grid_class); ?> gap-6 lg:gap-8">
          <?php
          foreach ($cards as $card):
            // Card fields.
            $card_title = $card['card_title'] ?? '';
            $card_link_obj = $card['card_link'] ?? null;
            $has_link = !empty($card_link_obj) && !empty($card_link_obj['url']);

            $card_link = $has_link ? $card_link_obj['url'] : '';
            $card_target = ($has_link && !empty($card_link_obj['target'])) ? $card_link_obj['target'] : '_self';
            $card_title_attr = ($has_link && !empty($card_link_obj['title'])) ? $card_link_obj['title'] : $card_title;

            // Background Group.
            $card_background = $card['card_background'] ?? array();
            $background_image = $card_background['background_image'] ?? null;
            $background_overlay = $card_background['background_overlay'] ?? '';

            $background_image_url = $background_image['url'] ?? '';
            $background_image_alt = $background_image['alt'] ?? $card_title;

            $tag = $has_link ? 'a' : 'div';
            $tag_attrs = $has_link ? 'href="' . esc_url($card_link) . '" target="' . esc_attr($card_target) . '" title="' . esc_attr($card_title_attr) . '"' : '';
            ?>
            <<?php echo $tag; ?>     <?php echo $tag_attrs; ?>
              class="civ-link-cards-card group relative block overflow-hidden rounded-2xl aspect-5/3 no-underline
              hover:no-underline shadow-lg">
              <?php if ($background_image_url): ?>
                <img src="<?php echo esc_url($background_image_url); ?>" alt="<?php echo esc_attr($background_image_alt); ?>"
                  class="civ-link-cards-image absolute inset-0 h-full! w-full object-cover transition-transform duration-300 group-hover:scale-105">
              <?php endif; ?>

              <?php if ($background_overlay): ?>
                <div class="civ-link-cards-overlay absolute inset-0"
                  style="background-color: <?php echo esc_attr($background_overlay); ?>;"></div>
              <?php endif; ?>

              <div
                class="civ-link-cards-content relative flex h-full items-end justify-between py-4 pl-4 pr-1 text-white md:py-6 md:pl-6">
                <h3
                  class="civ-link-cards-title text-xl text-white font-bold my-0 md:text-2xl lg:text-3xl leading-[1.1] md:leading-[1.1] lg:leading-[1.1]">
                  <?php echo esc_html($card_title); ?>
                </h3>
                <?php if ($has_link): ?>
                  <div
                    class="civ-link-cards-icon shrink-0 bg-white p-2 ml-4 opacity-75 transition-all duration-300 group-hover:scale-110 group-hover:opacity-100">
                    <svg class="h-6 w-6 text-gray-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                      stroke-width="2.5" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                  </div>
                <?php endif; ?>
              </div>
            </<?php echo $tag; ?>>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

</section>