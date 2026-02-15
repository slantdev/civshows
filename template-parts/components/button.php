<?php

/**
 * Button Component (Single)
 * 
 * Optimized for Tailwind CSS v4 and adjusted to project standards.
 * Supports nested ACF groups for Presets, Custom Styles, and Icons.
 */

$field = $args['field'] ?? '';
$class = $args['class'] ?? '';
$attributes = $args['attributes'] ?? [];

// Getting button component
$button_comp = is_array($field) ? $field : get_sub_field($field ?: 'button');

if (!$button_comp) return;

// Generate a stable ID based on Post ID and a static counter
static $button_count = 0;
$button_count++;
$button_id_attr = 'button-' . get_the_ID() . '-' . $button_count;

// Prepare Attributes String
$attr_string = '';
if (!empty($attributes)) {
  foreach ($attributes as $key => $value) {
    $attr_string .= ' ' . esc_attr($key) . '="' . esc_attr($value) . '"';
  }
}

// Extracting button details
$button_link = $button_comp['button_link'] ?? [];
if (empty($button_link['url'])) return;

$title  = $button_link['title'] ?? '';
$url    = $button_link['url'] ?? '';
$target = $button_link['target'] ?? '_self';

$more_settings = $button_comp['settings']['more_settings'] ?? [];

// Preset Settings
$preset       = $more_settings['button_preset'] ?? [];
$style_key    = $preset['button_style'] ?? 'blue';
$size_key     = $preset['button_size'] ?? 'default';
$rounded_key  = $preset['button_rounded'] ?? 'default';

// Size Mapping
$size_map = [
  'xs'      => ['px' => 'px-3 py-1', 'text' => 'text-xs', 'icon' => 12],
  'sm'      => ['px' => 'px-4 py-1.5', 'text' => 'text-sm', 'icon' => 16],
  'md'      => ['px-6 py-2.5', 'text' => 'text-base', 'icon' => 20],
  'lg'      => ['px-8 py-3.5', 'text' => 'text-lg', 'icon' => 24],
  'default' => ['px-6 py-2.5', 'text' => 'text-base', 'icon' => 20],
];
// Ensure $size_key is a valid key, otherwise fallback to 'default'
if (!is_string($size_key) || !isset($size_map[$size_key])) {
  $size_key = 'default';
}
$size_data = $size_map[$size_key];

// Rounded Mapping
$rounded_map = [
  'none'    => 'rounded-none',
  'sm'      => 'rounded-sm',
  'md'      => 'rounded-md',
  'lg'      => 'rounded-lg',
  'full'    => 'rounded-full',
  'default' => 'rounded-md',
];
$rounded_class = $rounded_map[$rounded_key] ?? $rounded_map['default'];

// Style Mapping
$styles_map = [
  'blue'           => 'bg-civ-blue-500 border-civ-blue-500 text-white hover:bg-civ-blue-600 hover:border-civ-blue-600',
  'orange'         => 'bg-civ-orange-500 border-civ-orange-500 text-white hover:bg-civ-orange-600 hover:border-civ-orange-600',
  'green'          => 'bg-civ-green-500 border-civ-green-500 text-white hover:bg-civ-green-600 hover:border-civ-green-600',
  'yellow'         => 'bg-civ-yellow-500 border-civ-yellow-500 text-white hover:bg-civ-yellow-600 hover:border-civ-yellow-600',
  'purple'         => 'bg-civ-purple-500 border-civ-purple-500 text-white hover:bg-civ-purple-600 hover:border-civ-purple-600',
  'red'            => 'bg-civ-red-500 border-civ-red-500 text-white hover:bg-civ-red-600 hover:border-civ-red-600',
  'white'          => 'bg-white border-white text-civ-blue-500 hover:bg-gray-100 hover:border-gray-100',
  'black'          => 'bg-black border-black text-white hover:bg-gray-900 hover:border-gray-900',
  'blue-outline'   => 'bg-transparent border-civ-blue-500 text-civ-blue-500 hover:bg-civ-blue-500 hover:text-white',
  'orange-outline' => 'bg-transparent border-civ-orange-500 text-civ-orange-500 hover:bg-civ-orange-500 hover:text-white',
  'green-outline'  => 'bg-transparent border-civ-green-500 text-civ-green-500 hover:bg-civ-green-500 hover:text-white',
  'yellow-outline' => 'bg-transparent border-civ-yellow-500 text-civ-yellow-500 hover:bg-civ-yellow-500 hover:text-white',
  'purple-outline' => 'bg-transparent border-civ-purple-500 text-civ-purple-500 hover:bg-civ-purple-500 hover:text-white',
  'red-outline'    => 'bg-transparent border-civ-red-500 text-civ-red-500 hover:bg-civ-red-500 hover:text-white',
  'white-outline'  => 'bg-transparent border-white text-white hover:bg-white hover:text-civ-blue-500',
  'black-outline'  => 'bg-transparent border-black text-black hover:bg-black hover:text-white',
];

$button_style_class = $styles_map[$style_key] ?? $styles_map['blue'];
$btn_vars = [];

// Handle Custom Style Group
if ($style_key === 'custom') {
  $custom_style = $more_settings['custom_style'] ?? [];
  $default_state = $custom_style['default_state'] ?? [];
  $hover_state = $custom_style['hover_state'] ?? [];

  // Default State Vars
  if ($default_state['button_bg_color']) $btn_vars[] = "--btn-bg: {$default_state['button_bg_color']}";
  if ($default_state['button_border_color']) $btn_vars[] = "--btn-border: {$default_state['button_border_color']}";
  if ($default_state['button_text_color']) $btn_vars[] = "--btn-text: {$default_state['button_text_color']}";

  // Hover State Vars
  if ($hover_state['button_bg_color']) $btn_vars[] = "--btn-bg-hover: {$hover_state['button_bg_color']}";
  if ($hover_state['button_border_color']) $btn_vars[] = "--btn-border-hover: {$hover_state['button_border_color']}";
  if ($hover_state['button_text_color']) $btn_vars[] = "--btn-text-hover: {$hover_state['button_text_color']}";

  $button_style_class = 'bg-[var(--btn-bg)] border-[var(--btn-border)] text-[var(--btn-text)] hover:bg-[var(--btn-bg-hover)] hover:border-[var(--btn-border-hover)] hover:text-[var(--btn-text-hover)]';
}

// Handle Icon Group
$icon_markup = '';
$icon_settings = $more_settings['button_icon'] ?? [];
if (!empty($icon_settings['add_button_icon'])) {
  $icon_group    = $icon_settings['icon_group'] ?? [];
  $icon_data     = $icon_group['icon'] ?? [];
  $icon_name     = $icon_data['value'] ?? '';
  $icon_set      = $icon_data['type'] ?? 'utility';
  $icon_color    = $icon_group['icon_color'] ?? '';
  $icon_pos      = $icon_group['icon_position'] ?? 'left';

  if ($icon_name) {
    if ($icon_color) $btn_vars[] = "--btn-icon-color: {$icon_color}";
    $icon_markup = civ_icon([
      'icon'  => $icon_name,
      'group' => $icon_set,
      'size'  => $size_data['icon'],
      'class' => 'text-[var(--btn-icon-color,inherit)] transition-colors'
    ]);
  }
}

$inline_style = !empty($btn_vars) ? 'style="' . esc_attr(implode('; ', $btn_vars)) . '"' : '';

$final_button_classes = array_filter([
  'inline-flex items-center justify-center border-2 font-semibold transition-all duration-300 transform active:scale-95 hover:shadow-lg gap-2',
  $size_data['px'],
  $size_data['text'],
  $rounded_class,
  $button_style_class,
  $class
]);

?>

<a id="<?php echo esc_attr($button_id_attr); ?>"
  href="<?php echo esc_url($url); ?>"
  class="<?php echo esc_attr(implode(' ', $final_button_classes)); ?>"
  <?php echo $inline_style; ?>
  target="<?php echo esc_attr($target); ?>"
  title="<?php echo esc_attr($title); ?>"
  <?php echo $attr_string; ?>>

  <?php if ($icon_markup && $icon_pos === 'left') echo $icon_markup; ?>
  <span><?php echo esc_html($title); ?></span>
  <?php if ($icon_markup && $icon_pos === 'right') echo $icon_markup; ?>

</a>