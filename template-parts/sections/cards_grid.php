<?php

/**
 * Section: Cards Grid
 *
 */

include get_template_directory() . '/template-parts/global/section-settings.php';

// Generate stable ID if not set
if (!$section_id) {
  static $cards_grid_count = 0;
  $cards_grid_count++;
  $section_id = 'section-cards-grid-' . get_the_ID() . '-' . $cards_grid_count;
}

$section_id_attr = 'id="' . esc_attr($section_id) . '"';

// Get ACF fields.
$cards_grid = get_sub_field('cards_grid'); // Group field.

// Bail early if no data.
if (empty($cards_grid)) {
  return;
}

// Content fields.
$headline    = $cards_grid['headline'] ?? '';
$cards       = $cards_grid['cards'] ?? array(); // Repeater.

// Don't render section if no content.
if (! $headline || ! $cards) {
  return;
}
?>

<section <?php echo $section_id_attr; ?> class="civ-cards-grid-section section-wrapper relative overflow-x-hidden <?php echo esc_attr($section_class); ?>" style="<?php echo esc_attr($section_style); ?>">

  <?php echo $section_overlay_markup; ?>

  <div class="civ-section-container section-container relative z-10 mx-auto max-w-5xl container px-4 py-12 md:py-16 lg:py-20 xl:px-0 <?php echo esc_attr($section_container_class); ?>">
    <div class="civ-cards-grid-intro text-left">

      <?php if (!empty($headline)): ?>
        <div class="mb-6">
          <?php get_template_part('template-parts/components/heading', null, ['field' => $headline]); ?>
        </div>
      <?php
      endif; ?>

    </div>

    <?php if ($cards) : ?>
      <div class="civ-cards-grid-list mt-12 grid grid-cols-1 gap-6 md:grid-cols-2 lg:gap-8">
        <?php
        foreach ($cards as $card) :
          // Card fields.
          $card_title    = $card['card_title'] ?? '';
          $card_link_obj = $card['card_link'] ?? array();
          $card_link     = $card_link_obj['url'] ?? '#';
          $card_target   = $card_link_obj['target'] ? $card_link_obj['target'] : '_self';
          $card_title_attr = $card_link_obj['title'] ?? $card_title;

          // Background Group.
          $card_background    = $card['card_background'] ?? array();
          $background_image   = $card_background['background_image'] ?? null;
          $background_overlay = $card_background['background_overlay'] ?? '';

          $background_image_url = $background_image['url'] ?? '';
          $background_image_alt = $background_image['alt'] ?? $card_title;
        ?>
          <a href="<?php echo esc_url($card_link); ?>" target="<?php echo esc_attr($card_target); ?>" title="<?php echo esc_attr($card_title_attr); ?>" class="civ-cards-grid-card group relative block overflow-hidden rounded-2xl aspect-5/3 no-underline hover:no-underline shadow-lg">
            <?php if ($background_image_url) : ?>
              <img src="<?php echo esc_url($background_image_url); ?>" alt="<?php echo esc_attr($background_image_alt); ?>" class="civ-cards-grid-image absolute inset-0 h-full! w-full object-cover transition-transform duration-300 group-hover:scale-105">
            <?php endif; ?>

            <?php if ($background_overlay) : ?>
              <div class="civ-cards-grid-overlay absolute inset-0" style="background-color: <?php echo esc_attr($background_overlay); ?>;"></div>
            <?php endif; ?>

            <div class="civ-cards-grid-content relative flex h-full items-end justify-between py-4 pl-4 pr-1 text-white md:py-6 md:pl-6">
              <h3 class="civ-cards-grid-title text-xl font-bold my-0 md:text-2xl lg:text-3xl leading-[1.1] md:leading-[1.1] lg:leading-[1.1]"><?php echo esc_html($card_title); ?></h3>
              <div class="civ-cards-grid-icon shrink-0 bg-white p-2 ml-4 opacity-75 transition-all duration-300 group-hover:scale-110 group-hover:opacity-100">
                <svg class="h-6 w-6 text-gray-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
              </div>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

</section>