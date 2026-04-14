<?php

/**
 * Logo Carousel Component
 */

$field = $args['field'] ?? '';
$class = $args['class'] ?? '';

// Getting component data
$logo_carousel_comp = is_array($field) ? $field : get_sub_field($field ?: 'logo_carousel');

if (!$logo_carousel_comp) return;

// We now use logo_carousel_repeater under the logo_carousel group wrapper
$logo_group = $logo_carousel_comp['logo_carousel'] ?? $logo_carousel_comp;
$gallery_items = $logo_group['logo_carousel_repeater'] ?? [];
$settings = $logo_group['carousel_settings'] ?? [];
$logo_per_view = $settings['logo_per_view'] ?? [];
$autoplay_settings = $settings['autoplay'] ?? [];

$sp2xl = $logo_per_view['screen_2xl'] ?? 5;
$spxl = $logo_per_view['screen_xl'] ?? 4;
$splg = $logo_per_view['screen_lg'] ?? 4;
$spmd = $logo_per_view['screen_md'] ?? 3;
$spdefault = $logo_per_view['screen_default'] ?? 2;

$enable_autoplay = isset($autoplay_settings['enable_autoplay']) ? $autoplay_settings['enable_autoplay'] : true;
$autoplay_timer = $autoplay_settings['autoplay_timer'] ?? 6;

if (empty($gallery_items)) return;

// Generate a stable ID based on Post ID and a static counter
static $logo_carousel_count = 0;
$logo_carousel_count++;
$logo_carousel_id = 'logo-carousel-' . get_the_ID() . '-' . $logo_carousel_count;

$config_array = [
  'spdefault' => (int)$spdefault,
  'spmd'      => (int)$spmd,
  'splg'      => (int)$splg,
  'spxl'      => (int)$spxl,
  'sp2xl'     => (int)$sp2xl,
  'autoplay'  => (bool)$enable_autoplay,
  'delay'     => (int)$autoplay_timer * 1000
];

?>

<div id="<?php echo esc_attr($logo_carousel_id); ?>" class="civ-logo-carousel-component logo-carousel-component relative <?php echo esc_attr($class); ?>">
  <!-- Swiper -->
  <div class="logo-carousel-slider swiper overflow-hidden" data-config="<?php echo esc_attr(wp_json_encode($config_array)); ?>">
    <div class="swiper-wrapper items-center">
      <?php foreach ($gallery_items as $item) :
        $image = $item['logo_image'] ?? [];
        $link = $item['link'] ?? [];
        if (empty($image)) continue;
      ?>
        <div class="swiper-slide flex justify-center px-4 md:px-6 lg:px-8 xl:px-10">
          <?php if (!empty($link)): ?>
            <a href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr($link['target'] ?: '_self'); ?>" class="block hover:opacity-75 transition-opacity" title="<?php echo esc_attr($link['title']); ?>">
            <?php endif; ?>

            <?php echo wp_get_attachment_image($image['ID'], 'medium', false, ['class' => 'w-auto hover:grayscale-0 transition-all duration-300 object-contain mx-auto']); ?>

            <?php if (!empty($link)): ?>
            </a>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Swiper Pagination -->
    <div class="logo-carousel-pagination static! mt-6"></div>
  </div>
</div>



<style>
  /* Inactive Dot */
  .logo-carousel-pagination .swiper-pagination-bullet {
    width: 8px;
    height: 8px;
    background: transparent;
    border: 1px solid #ccc;
    /* Outline style */
    opacity: 1;
    margin: 0 6px;
  }

  /* Active Dot */
  .logo-carousel-pagination .swiper-pagination-bullet-active {
    background: #666;
    /* Solid Dark Gray */
    border-color: #666;
  }
</style>