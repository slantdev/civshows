<?php

/**
 * Spacer Component
 * 
 * Optimized for Tailwind CSS v4.
 * Supports preset sizes, custom pixel sizes, and optional horizontal lines.
 */

$field = $args['field'] ?? '';
$class = $args['class'] ?? '';

// Getting spacer component data
$spacer_comp = is_array($field) ? $field : get_sub_field($field ?: 'spacer');

if (!$spacer_comp) return;

// Generate a stable ID based on Post ID and a static counter
static $spacer_count = 0;
$spacer_count++;
$spacer_id_attr = 'spacer-' . get_the_ID() . '-' . $spacer_count;

// Data Extraction
$spacer_data    = $spacer_comp['spacer'] ?? [];
$option_type    = $spacer_data['spacer_options'] ?? 'preset';
$size_preset    = $spacer_data['spacer_size_preset'] ?? 'default';
$size_custom    = $spacer_data['spacer_size_custom'] ?? '';
$add_line       = $spacer_data['add_horizontal_line'] ?? false;

$line_settings  = $spacer_comp['settings']['more_settings']['horizontal_line_settings'] ?? [];
$line_color     = $line_settings['line_color'] ?? '#ebe6e7';

// Mapping preset sizes to margins (rem/px equivalents in Tailwind v4)
$preset_map = [
  'sm'      => 'my-4',
  'md'      => 'my-8',
  'lg'      => 'my-12',
  'xl'      => 'my-16',
  '2xl'     => 'my-24',
  '3xl'     => 'my-32',
  'default' => 'my-12',
];

$inline_style = '';
$spacer_class = '';

if ($option_type === 'preset') {
  $spacer_class = $preset_map[$size_preset] ?? $preset_map['default'];
} else {
  // Custom size: we apply half of the custom px value to top and bottom margins
  if ($size_custom) {
    $half_size = $size_custom / 2;
    $inline_style .= "margin-top: {$half_size}px; margin-bottom: {$half_size}px;";
  }
}

// Line Styling
$line_class = '';
if ($add_line) {
  $line_class = 'border-t';
  $inline_style .= " border-color: {$line_color};";
}

?>

<div
  id="<?php echo esc_attr($spacer_id_attr); ?>"
  class="spacer-component w-full block transition-all <?php echo esc_attr($spacer_class); ?> <?php echo esc_attr($line_class); ?> <?php echo esc_attr($class); ?>"
  style="<?php echo esc_attr($inline_style); ?>"
  aria-hidden="true">
</div>