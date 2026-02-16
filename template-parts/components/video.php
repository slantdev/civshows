<?php

/**
 * Video Component
 * 
 * Optimized for Tailwind CSS v4.
 * Supports external embeds and self-hosted videos.
 */

$field = $args['field'] ?? '';
$class = $args['class'] ?? '';

// Getting component
$video_comp = is_array($field) ? $field : get_sub_field($field ?: 'video');

if (!$video_comp) return;

// Generate a stable ID based on Post ID and a static counter
static $video_count = 0;
$video_count++;
$video_id_attr = 'video-' . get_the_ID() . '-' . $video_count;

// Data Extraction
$video_group = $video_comp['video'] ?? [];
$source      = $video_group['external_or_self_hosted'] ?? 'external';

// Extract Video Data
$video_url = '';
$thumbnail_url = '';
$fallback_url = '';

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

?>

<div id="<?php echo esc_attr($video_id_attr); ?>" class="video-component-wrapper relative <?php echo esc_attr($class); ?>">
  <a href="<?php echo esc_url($video_url); ?>" 
     data-fancybox="video-<?php echo get_the_ID(); ?>" 
     class="aspect-video w-full rounded-xl overflow-hidden shadow-sm bg-gray-900 group relative block">
    
    <!-- Play Button Overlay -->
    <div class="absolute inset-0 z-20 flex items-center justify-center pointer-events-none">
      <div class="w-16 h-16 bg-civ-orange-500 rounded-full flex items-center justify-center text-white shadow-xl transition-transform duration-300 group-hover:scale-110">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
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
  </a>
</div>
