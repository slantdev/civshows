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

?>

<div id="<?php echo esc_attr($video_id_attr); ?>" class="video-component-wrapper relative <?php echo esc_attr($class); ?>">
  <div class="aspect-video w-full rounded-xl overflow-hidden shadow-sm bg-gray-200 [&_iframe]:w-full [&_iframe]:h-full [&_video]:w-full [&_video]:h-full [&_video]:object-cover">
    
    <?php if ($source === 'external') : ?>
      <?php echo $video_group['embed_external_video'] ?? ''; ?>
    <?php else : ?>
      <?php echo do_shortcode($video_group['self_hosted_video'] ?? ''); ?>
    <?php endif; ?>

  </div>
</div>
