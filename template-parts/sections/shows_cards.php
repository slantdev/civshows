<?php
include get_template_directory() . '/template-parts/global/section-settings.php';
/*
 * Available section variables (from section-settings.php):
 * $section_id
 * $section_style
 * $section_container_class
 * $section_overlay_markup
 */

// Generate stable ID if not set
if (!$section_id) {
  static $shows_cards_count = 0;
  $shows_cards_count++;
  $section_id = 'section-shows-cards-' . get_the_ID() . '-' . $shows_cards_count;
}

$section_id_attr = 'id="' . esc_attr($section_id) . '"';

// Data
$shows_cards_group = get_sub_field('shows_cards');
$intro             = $shows_cards_group['intro'] ?? [];
$cards_repeater    = $shows_cards_group['cards_repeater'] ?? [];

?>

<section <?php echo $section_id_attr; ?> class="section-shows-cards py-30 bg-white relative" style="<?php echo esc_attr($section_style); ?>">

  <?php echo $section_overlay_markup; ?>

  <div class="container mx-auto px-4 relative z-10">

    <?php if (!empty($intro['title'])) : ?>
      <div class="mb-12 max-w-3xl">
        <?php get_template_part('template-parts/components/heading', '', [
          'field' => $intro['title'],
          'class' => 'text-3xl md:text-4xl font-bold text-civ-blue-900'
        ]); ?>
      </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

      <?php foreach ($cards_repeater as $card) :
        $card_title_group = $card['title'] ?? [];
        $card_date        = $card_title_group['date'] ?? '';
        $card_title       = $card_title_group['title'] ?? '';
        $card_style       = $card_title_group['style'] ?? [];
        $text_color       = $card_style['text_color'] ?? '#FFFFFF';
        $bg_color         = $card_style['background_color'] ?? '#E6853B';

        $card_bg_group    = $card['background'] ?? [];
        $logo_image       = $card_bg_group['logo_image']['url'] ?? '';
        $bg_image         = $card_bg_group['background_image']['url'] ?? '';
        $bg_overlay       = $card_bg_group['background_overlay'] ?? 'rgba(0,0,0,0.4)';

        $link             = $card['link'] ?? [];
        $link_url         = $link['url'] ?? '#';
        $link_target      = $link['target'] ?? '_self';
      ?>

        <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" class="group relative aspect-5/4 rounded-2xl overflow-hidden block shadow-md hover:shadow-xl transition-shadow">
          <div class="absolute inset-0 w-full h-full">
            <?php if ($bg_image) : ?>
              <img src="<?php echo esc_url($bg_image); ?>" alt="<?php echo esc_attr($card_title); ?> Background" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
            <?php endif; ?>
            <div class="absolute inset-0" style="background-color: <?php echo esc_attr($bg_overlay); ?>;"></div>
          </div>

          <div class="relative h-full flex flex-col justify-end">
            <div class="p-6 grow flex items-end justify-start">
              <?php if ($logo_image) : ?>
                <img src="<?php echo esc_url($logo_image); ?>" alt="<?php echo esc_attr($card_title); ?> Logo" class="w-2/3 h-auto drop-shadow-lg">
              <?php endif; ?>
            </div>

            <div class="px-6 py-4 flex justify-between items-center relative z-10" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">
              <div>
                <p class="font-semibold uppercase leading-tight"><?php echo esc_html($card_date); ?></p>
                <p class="font-semibold uppercase opacity-90"><?php echo esc_html($card_title); ?></p>
              </div>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
              </svg>
            </div>
          </div>
        </a>

      <?php endforeach; ?>

      <!-- Hardcoded Last Card -->
      <div class="relative aspect-5/4 rounded-2xl overflow-hidden shadow-md flex items-center justify-center p-6 text-center">
        <div class="absolute inset-0 bg-[linear-gradient(135deg,var(--color-civ-green-500)_50%,var(--color-civ-blue-600)_50%)]"></div>

        <div class="relative z-10 text-white">
          <h3 class="text-3xl md:text-4xl font-semibold uppercase leading-none drop-shadow-md">
            New Show<br>Coming Soon
          </h3>
        </div>
      </div>

    </div>
  </div>
</section>
