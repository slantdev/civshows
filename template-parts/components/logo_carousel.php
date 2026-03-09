<?php

/**
 * Logo Carousel Component
 */

$field = $args['field'] ?? '';
$class = $args['class'] ?? '';

// Getting component data
$logo_carousel_comp = is_array($field) ? $field : get_sub_field($field ?: 'logo_carousel');

if (!$logo_carousel_comp) return;

$logo_group = $logo_carousel_comp['logo_carousel'] ?? [];
$gallery_images = $logo_group['logo_carousel'] ?? [];

if (empty($gallery_images)) return;

// Generate a stable ID based on Post ID and a static counter
static $logo_carousel_count = 0;
$logo_carousel_count++;
$logo_carousel_id = 'logo-carousel-' . get_the_ID() . '-' . $logo_carousel_count;

?>

<div id="<?php echo esc_attr($logo_carousel_id); ?>" class="logo-carousel-component relative <?php echo esc_attr($class); ?>">
  <!-- Swiper -->
  <div class="logo-carousel-slider swiper overflow-hidden">
    <div class="swiper-wrapper items-center">
      <?php foreach ($gallery_images as $image) : ?>
        <div class="swiper-slide flex justify-center px-4 md:px-6">
          <?php echo wp_get_attachment_image($image['ID'], 'medium', false, ['class' => 'w-auto max-h-20 lg:max-h-24 hover:grayscale-0 transition-all duration-300 object-contain mx-auto']); ?>
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