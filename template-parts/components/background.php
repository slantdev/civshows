<?php

/**
 * Background Component
 * 
 * Optimized for Tailwind CSS v4.
 * Handles background image, color, position, and overlay.
 */

$field = $args['field'] ?? '';
$class = $args['class'] ?? '';

// Getting background component
$bg_comp = is_array($field) ? $field : get_sub_field($field ?: 'background');

if (!$bg_comp) return;

// Generate a stable ID based on Post ID and a static counter
static $bg_count = 0;
$bg_count++;
$bg_id_attr = 'bg-' . get_the_ID() . '-' . $bg_count;

// Data Extraction
$bg_data      = $bg_comp['background'] ?? [];
$bg_image     = $bg_data['background_image'] ?? [];
$bg_pos_key   = $bg_data['background_position'] ?? 'center';
$bg_color     = $bg_data['background_color'] ?? '';
$bg_overlay   = $bg_data['background_overlay'] ?? '';

// BG Position Mapping (Tailwind v4 object-position)
$pos_map = [
  'left-top'     => 'object-left-top',
  'top'          => 'object-top',
  'right-top'    => 'object-right-top',
  'left'         => 'object-left',
  'center'       => 'object-center',
  'right'        => 'object-right',
  'left-bottom'  => 'object-left-bottom',
  'bottom'       => 'object-bottom',
  'right-bottom' => 'object-right-bottom',
];
$pos_class = $pos_map[$bg_pos_key] ?? 'object-center';

// Inline Styles
$wrapper_style = $bg_color ? "background-color: {$bg_color};" : "";
$overlay_style = $bg_overlay ? "background-color: {$bg_overlay};" : "";

?>

<div id="<?php echo esc_attr($bg_id_attr); ?>" class="absolute inset-0 pointer-events-none z-0 overflow-hidden <?php echo esc_attr($class); ?>" style="<?php echo esc_attr($wrapper_style); ?>">
  
  <?php if (!empty($bg_image['url'])) : ?>
    <img 
      src="<?php echo esc_url($bg_image['url']); ?>" 
      alt="<?php echo esc_attr($bg_image['alt'] ?? ''); ?>" 
      class="w-full h-full object-cover <?php echo esc_attr($pos_class); ?>"
    >
  <?php endif; ?>

  <?php if ($bg_overlay) : ?>
    <div class="absolute inset-0 z-10" style="<?php echo esc_attr($overlay_style); ?>"></div>
  <?php endif; ?>

</div>
