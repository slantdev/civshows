<?php

/**
 * Media Slider Component (Video & Image)
 * 
 * Optimized for Tailwind CSS v4 and Swiper.js.
 * Supports external embeds, self-hosted videos, and images.
 */

$field = $args['field'] ?? '';
$class = $args['class'] ?? '';

// Getting component
$media_comp = is_array($field) ? $field : get_sub_field($field ?: 'media_slider');

if (!$media_comp) return;

// Generate a stable ID based on Post ID and a static counter
static $media_slider_count = 0;
$media_slider_count++;
$slider_id = 'media-slider-' . get_the_ID() . '-' . $media_slider_count;

// Data Extraction
$media_group = $media_comp['media_slider'] ?? [];
$repeater    = $media_group['media_slider_repeater'] ?? [];

if (empty($repeater)) return;

$item_count = count($repeater);
$is_slider  = $item_count > 1;

?>

<div id="<?php echo esc_attr($slider_id); ?>" class="media-slider-wrapper relative <?php echo esc_attr($class); ?>">

  <div class="swiper media-slider rounded-xl overflow-hidden shadow-sm bg-gray-200 <?php echo $is_slider ? '' : 'swiper-no-swiping'; ?>">
    <div class="swiper-wrapper">

      <?php foreach ($repeater as $item) :
        $type = $item['media_type'] ?? 'video';
        $video_url = '';
        $thumbnail_url = '';
        $fallback_url = '';
        $image_url = '';

        if ($type === 'video') {
          $video_group = $item['video_group'] ?? [];
          $source      = $video_group['external_or_self_hosted'] ?? 'external';

          if ($source === 'external') {
            $embed_code = $video_group['embed_external_video'] ?? '';
            preg_match('/src="([^"]+)"/', $embed_code, $match);
            $raw_url = $match[1] ?? '';

            $video_data = civ_get_video_data($raw_url);
            if ($video_data) {
              $video_url     = $video_data['url'];
              $thumbnail_url = $video_data['thumbnail'];
              $fallback_url  = $video_data['fallback'];
            } else {
              $video_url = $raw_url;
            }
          } else {
            preg_match('/src="([^"]+)"/', $video_group['self_hosted_video'] ?? '', $match);
            $video_url = $match[1] ?? '';
          }
        } else {
          $image_group = $item['image_group'] ?? [];
          $image_url   = $image_group['image']['url'] ?? '';
        }
      ?>
        <div class="swiper-slide relative aspect-video group cursor-pointer bg-gray-900 overflow-hidden">

          <a href="<?php echo esc_url($type === 'video' ? $video_url : $image_url); ?>" 
             data-fancybox="<?php echo esc_attr($slider_id); ?>" 
             class="w-full h-full block relative">

            <?php if ($type === 'video') : ?>
              <!-- Play Button -->
              <div class="absolute inset-0 z-20 flex items-center justify-center pointer-events-none">
                <div class="w-12 h-12 md:w-16 md:h-16 bg-civ-orange-500 rounded-full flex items-center justify-center text-white shadow-xl transition-transform duration-300 group-hover:scale-110">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 md:h-8 md:w-8 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                </div>
              </div>

              <?php if ($thumbnail_url) : ?>
                <img src="<?php echo esc_url($thumbnail_url); ?>" 
                     class="w-full h-full object-cover opacity-80 transition-all duration-500 group-hover:opacity-60 group-hover:scale-105"
                     <?php if ($fallback_url) echo 'onerror="this.src=\'' . esc_url($fallback_url) . '\'; this.onerror=null;"'; ?>>
              <?php else : ?>
                <div class="w-full h-full opacity-60 transition-opacity duration-500 group-hover:opacity-40 [&_iframe]:w-full [&_iframe]:h-full [&_video]:w-full [&_video]:h-full [&_video]:object-cover pointer-events-none">
                  <?php if ($source === 'external') echo $video_group['embed_external_video'] ?? ''; else echo do_shortcode($video_group['self_hosted_video'] ?? ''); ?>
                </div>
              <?php endif; ?>

            <?php else : ?>
              <?php if ($image_url) : ?>
                <img src="<?php echo esc_url($image_url); ?>" 
                     alt="<?php echo esc_attr($item['image_group']['image']['alt'] ?? ''); ?>" 
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
              <?php endif; ?>
            <?php endif; ?>

          </a>

        </div>
      <?php endforeach; ?>

    </div>
  </div>

  <?php if ($is_slider) : ?>
    <!-- Navigation -->
    <div class="media-prev absolute top-1/2 -left-4 md:-left-16 transform -translate-y-1/2 z-10 cursor-pointer">
      <div class="w-12 h-12 rounded-full bg-gray-300 hover:bg-gray-400 flex items-center justify-center transition-colors text-white shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
      </div>
    </div>

    <div class="media-next absolute top-1/2 -right-4 md:-right-16 transform -translate-y-1/2 z-10 cursor-pointer">
      <div class="w-12 h-12 rounded-full bg-civ-blue-500 hover:bg-civ-blue-600 flex items-center justify-center transition-colors text-white shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
      </div>
    </div>

    <!-- Pagination -->
    <div class="media-pagination flex justify-center mt-8 gap-2"></div>
  <?php endif; ?>

</div>

<style>
  /* Inactive Dot */
  .media-pagination .swiper-pagination-bullet {
    width: 12px;
    height: 12px;
    background: transparent;
    border: 2px solid #ccc;
    /* Outline style */
    opacity: 1;
    margin: 0 6px;
  }

  /* Active Dot */
  .media-pagination .swiper-pagination-bullet-active {
    background: #666;
    /* Solid Dark Gray */
    border-color: #666;
  }
</style>