<?php

/**
 * Section: Stats Slider
 */

include get_template_directory() . '/template-parts/global/section-settings.php';

$section_id_attr = $section_id ? 'id="' . esc_attr($section_id) . '"' : '';
$section_class = 'section-stats-slider-' . uniqid();

// Data Extraction
$stats_slider = get_sub_field('stats_slider') ?: get_sub_field('content'); // depending on flex logic mapping, try both
if (!$stats_slider) {
  if (get_row_layout() == 'stats_slider') {
    $stats_slider = get_sub_field('content');
  }
}
$slides = $stats_slider['stats_slide'] ?? [];
$style = $stats_slider['style'] ?? [];

$bg_color = $style['background_color'] ?? '#b86aab';
$text_color = $style['text_color'] ?? '#FFFFFF';

// Merge specific inline styles with universal section styles
$inline_style = esc_attr($section_style) . " background-color: " . esc_attr($bg_color) . "; color: " . esc_attr($text_color) . ";";

if (empty($slides)) {
  return;
}
?>

<section <?php echo $section_id_attr; ?> class="civ-stats-slider-section relative w-full overflow-hidden py-16 md:py-24 <?php echo esc_attr($section_class); ?>" style="<?php echo $inline_style; ?>">
  <?php echo $section_overlay_markup; ?>

  <div class="civ-section-container section-container relative z-10 <?php echo esc_attr($section_container_class); ?>">
    <div class="container mx-auto px-4 md:px-8 xl:px-12">
      <div class="stats-slider swiper w-full">
        <div class="swiper-wrapper">
          <?php foreach ($slides as $slide) :
            $icon = $slide['icon_image'] ?? [];
            $stats_group = $slide['stats'] ?? [];

            $numbers = $stats_group['numbers'] ?? [];
            $prefix = $numbers['prefix'] ?? '';
            $number = $numbers['number'] ?? 0;
            $suffix = $numbers['suffix'] ?? '';

            $text = $stats_group['text'] ?? '';
            $footer_text = $stats_group['footer_text'] ?? '';
          ?>
            <div class="swiper-slide px-4 md:px-6 flex flex-col items-center justify-start text-center">

              <div class="slide-icon mb-4 md:mb-6 flex justify-center h-16 md:h-20 lg:h-28 opacity-90">
                <?php if (!empty($icon)) : ?>
                  <?php echo wp_get_attachment_image($icon['ID'], 'medium', false, ['class' => 'h-full w-auto object-contain']); ?>
                <?php endif; ?>
              </div>

              <div class="slide-stats mb-4 flex items-baseline justify-center gap-1">
                <?php if ($prefix) : ?>
                  <span class="stats-prefix text-4xl lg:text-5xl font-bold"><?php echo esc_html($prefix); ?></span>
                <?php endif; ?>

                <span class="js-counter stats-number text-5xl lg:text-6xl font-extrabold tabular-nums tracking-tight" data-target="<?php echo esc_attr($number); ?>">0</span>

                <?php if ($suffix) : ?>
                  <span class="stats-suffix text-4xl lg:text-5xl font-bold"><?php echo esc_html($suffix); ?></span>
                <?php endif; ?>
              </div>

              <?php if ($text) : ?>
                <div class="slide-text text-base lg:text-xl font-semibold mb-6 opacity-90">
                  <?php echo wp_kses_post($text); ?>
                </div>
              <?php endif; ?>

              <?php if ($footer_text) : ?>
                <div class="slide-footer pt-4 text-sm">
                  <?php echo wp_kses_post($footer_text); ?>
                </div>
              <?php endif; ?>

            </div>
          <?php endforeach; ?>
        </div>

        <!-- Pagination & Navigation -->
        <div class="swiper-pagination -bottom-8! md:-bottom-12!"></div>
        <div class="swiper-button-prev h-8! w-8! md:w-10! md:h-10! p-2.5 bg-white hover:bg-civ-blue-500! text-civ-blue-600! hover:text-white! rounded-full after:text-sm shadow-md transition-colors opacity-90"></div>
        <div class="swiper-button-next h-8! w-8! md:w-10! md:h-10! p-2.5 bg-white hover:bg-civ-blue-500! text-civ-blue-600! hover:text-white! rounded-full after:text-sm shadow-md transition-colors opacity-90"></div>
      </div>
    </div>
  </div>
</section>