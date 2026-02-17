<?php

/**
 * Gallery Component
 * 
 * Supports Image and Video galleries from the 'gallery' CPT.
 * Styles: Card, Grid.
 */

$field = $args['field'] ?? '';
$class = $args['class'] ?? '';

// Getting component data from Page Builder
$gallery_comp = is_array($field) ? $field : get_sub_field($field ?: 'gallery');

if (!$gallery_comp) return;

// Component Settings
$gallery_group    = $gallery_comp['gallery'] ?? [];
$gallery_settings = $gallery_group['gallery_settings'] ?? [];
$style            = $gallery_settings['gallery_style'] ?? 'card';
$columns          = $gallery_settings['gallery_columns'] ?? 'three';
$posts            = $gallery_group['gallery_post'] ?? [];

if (empty($posts)) return;

// Grid Column Mapping
$cols_map = [
  'two'   => 'grid-cols-1 md:grid-cols-2',
  'three' => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
  'four'  => 'grid-cols-1 md:grid-cols-3 lg:grid-cols-4',
];
$grid_cols_class = $cols_map[$columns] ?? $cols_map['three'];

// Loop through selected Gallery posts
foreach ($posts as $post_obj) :
  $post_id = is_object($post_obj) ? $post_obj->ID : $post_obj;
  $settings = get_field('gallery_settings', $post_id);

  if (!$settings) continue;

  // Generate a stable ID
  static $gallery_item_count = 0;
  $gallery_item_count++;
  $item_id = 'gallery-item-' . get_the_ID() . '-' . $gallery_item_count;

  $type = $settings['gallery_type'] ?? 'image';

  // --- 1. Video Gallery ---
  if ($type === 'video') :
    $videos = $settings['video_gallery'] ?? [];
    if (empty($videos)) continue;

    // Card Style for Videos
    if ($style === 'card') : ?>
      <div id="<?php echo esc_attr($item_id); ?>" class="gallery-video-cards grid <?php echo esc_attr($grid_cols_class); ?> gap-4 lg:gap-8 mb-6 lg:mb-8 <?php echo esc_attr($class); ?>">
        <?php foreach ($videos as $v_item) :
          $v_data  = $v_item['video'] ?? [];
          $title   = $v_item['title'] ?? '';
          $desc    = $v_item['description'] ?? '';
          $link    = $v_item['button_link'] ?? [];
          $source  = $v_data['external_or_self_hosted'] ?? 'external';

          // Extract Video Data for Fancybox
          $video_url = '';
          $thumbnail_url = '';
          $fallback_url = '';

          if ($source === 'external') {
            $embed_code = $v_data['embed_external_video'] ?? '';
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
            preg_match('/src="([^"]+)"/', $v_data['self_hosted_video'] ?? '', $match);
            $video_url = $match[1] ?? '';
          }
        ?>
          <div class="flex flex-col">
            <a href="<?php echo esc_url($video_url); ?>"
              data-fancybox="gallery-video-<?php echo $post_id; ?>"
              data-caption="<?php echo esc_attr($title); ?>"
              class="aspect-video w-full rounded-xl overflow-hidden shadow-sm bg-gray-900 group relative block hover:shadow-xl transition-shadow duration-300">

              <!-- Play Button Overlay -->
              <div class="absolute inset-0 z-20 flex items-center justify-center pointer-events-none">
                <div class="w-20 h-20 rounded-full border-4 border-white flex items-center justify-center pl-1 group-hover:scale-110 transition-transform duration-300 backdrop-blur-sm bg-white/10">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M8 5v14l11-7z" />
                  </svg>
                </div>
              </div>

              <!-- Inset Overlay -->
              <div class="absolute inset-0 bg-black/20 group-hover:bg-black/30 transition-colors z-10"></div>

              <?php if ($thumbnail_url) : ?>
                <img src="<?php echo esc_url($thumbnail_url); ?>"
                  alt="<?php echo esc_attr($title); ?>"
                  class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                  <?php if ($fallback_url) echo 'onerror="this.src=\'' . esc_url($fallback_url) . '\'; this.onerror=null;"'; ?>>
              <?php else : ?>
                <div class="w-full h-full opacity-60 transition-opacity duration-500 group-hover:opacity-40 [&_iframe]:w-full [&_iframe]:h-full [&_video]:w-full [&_video]:h-full [&_video]:object-cover pointer-events-none">
                  <?php if ($source === 'external') echo $v_data['embed_external_video'] ?? '';
                  else echo do_shortcode($v_data['self_hosted_video'] ?? ''); ?>
                </div>
              <?php endif; ?>
            </a>

            <div class="mt-4 text-left">
              <?php if ($title) : ?>
                <h3 class="text-2xl font-bold mb-3"><?php echo esc_html($title); ?></h3>
              <?php endif; ?>

              <?php if ($desc) : ?>
                <div class="prose prose-sm max-w-none text-gray-800 mb-4 leading-relaxed">
                  <?php echo wp_kses_post($desc); ?>
                </div>
              <?php endif; ?>

              <?php if (!empty($link['url'])) : ?>
                <a href="<?php echo esc_url($link['url']); ?>"
                  target="<?php echo esc_attr($link['target'] ?: '_self'); ?>"
                  class="inline-block bg-civ-orange-500 hover:bg-civ-orange-600 text-white font-bold uppercase text-xs py-2.5 px-6 rounded-sm transition-colors shadow-sm">
                  <?php echo esc_html($link['title'] ?: 'View The Video'); ?>
                </a>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

    <?php else : // Grid Style for Videos 
    ?>
      <div id="<?php echo esc_attr($item_id); ?>" class="gallery-video-grid grid <?php echo esc_attr($grid_cols_class); ?> gap-4 lg:gap-8 mb-6 lg:mb-8 <?php echo esc_attr($class); ?>">
        <?php foreach ($videos as $v_item) :
          $v_data = $v_item['video'] ?? [];
          $source = $v_data['external_or_self_hosted'] ?? 'external';

          $video_url = '';
          $thumbnail_url = '';
          $fallback_url = '';

          if ($source === 'external') {
            $embed_code = $v_data['embed_external_video'] ?? '';
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
            preg_match('/src="([^"]+)"/', $v_data['self_hosted_video'] ?? '', $match);
            $video_url = $match[1] ?? '';
          }
        ?>
          <a href="<?php echo esc_url($video_url); ?>"
            data-fancybox="gallery-video-<?php echo $post_id; ?>"
            class="aspect-video w-full rounded-lg overflow-hidden shadow-sm bg-gray-900 group relative block hover:shadow-xl transition-shadow duration-300">

            <!-- Play Button Overlay -->
            <div class="absolute inset-0 z-20 flex items-center justify-center pointer-events-none">
              <div class="w-12 h-12 md:w-14 md:h-14 rounded-full border-2 border-white flex items-center justify-center pl-0.5 group-hover:scale-110 transition-transform duration-300 backdrop-blur-sm bg-white/10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 md:h-7 md:w-7 text-white" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M8 5v14l11-7z" />
                </svg>
              </div>
            </div>

            <!-- Inset Overlay -->
            <div class="absolute inset-0 bg-black/20 group-hover:bg-black/30 transition-colors z-10"></div>

            <?php if ($thumbnail_url) : ?>
              <img src="<?php echo esc_url($thumbnail_url); ?>"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                <?php if ($fallback_url) echo 'onerror="this.src=\'' . esc_url($fallback_url) . '\'; this.onerror=null;"'; ?>>
            <?php else : ?>
              <div class="w-full h-full opacity-60 transition-opacity duration-500 group-hover:opacity-40 pointer-events-none [&_iframe]:w-full [&_iframe]:h-full [&_video]:w-full [&_video]:h-full [&_video]:object-cover">
                <?php if ($source === 'external') echo $v_data['embed_external_video'] ?? '';
                else echo do_shortcode($v_data['self_hosted_video'] ?? ''); ?>
              </div>
            <?php endif; ?>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  <?php
  // --- 2. Image Gallery ---
  elseif ($type === 'image') :
    $images = $settings['image_gallery'] ?? [];
    if (empty($images)) continue;
  ?>
    <div id="<?php echo esc_attr($item_id); ?>" class="gallery-image-grid grid <?php echo esc_attr($grid_cols_class); ?> gap-4 mb-6 lg:mb-8 <?php echo esc_attr($class); ?>">
      <?php foreach ($images as $image) : ?>
        <a href="<?php echo esc_url($image['url']); ?>"
          data-fancybox="gallery-<?php echo $post_id; ?>"
          class="aspect-square block rounded-xl overflow-hidden shadow-sm group bg-gray-100">
          <?php echo wp_get_attachment_image($image['ID'], 'medium_large', false, [
            'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-110'
          ]); ?>
        </a>
      <?php endforeach; ?>
    </div>
<?php endif;

endforeach;
