<?php

/**
 * Buttons Component
 * 
 * Optimized for Tailwind CSS v4 and adjusted to project standards.
 * Supports nested ACF groups for Presets and Custom Styles.
 */

$field = $args['field'] ?? '';
$class = $args['class'] ?? '';

// Getting buttons component
$buttons_comp = is_array($field) ? $field : get_sub_field($field ?: 'buttons');

if (!$buttons_comp) return;

// Generate a stable ID based on Post ID and a static counter
static $buttons_count = 0;
$buttons_count++;
$buttons_id = 'buttons-' . get_the_ID() . '-' . $buttons_count;

// Settings
$alignment = $buttons_comp['settings']['buttons_alignment'] ?? 'left';

// Mapping alignment values
$alignment_map = [
  'left'   => 'justify-start text-left',
  'center' => 'justify-center text-center',
  'right'  => 'justify-end text-right',
];
$alignment_class = $alignment_map[$alignment] ?? $alignment_map['left'];

// Getting buttons repeater
$buttons_repeater = $buttons_comp['buttons_repeater'] ?? [];

if ($buttons_repeater) {
  // Container class
  $container_classes = array_filter([
    'flex flex-wrap gap-4 mb-6 items-center',
    $alignment_class,
    $class
  ]);

  echo '<div id="' . esc_attr($buttons_id) . '" class="' . esc_attr(implode(' ', $container_classes)) . '">';

  foreach ($buttons_repeater as $button) {
    $button_link = $button['button_link'] ?? [];
    if (empty($button_link['url'])) continue;

    $title  = $button_link['title'] ?? '';
    $url    = $button_link['url'] ?? '';
    $target = $button_link['target'] ?? '_self';

    $more_settings = $button['settings']['more_settings'] ?? [];

    // Preset Settings
    $preset       = $more_settings['button_preset'] ?? [];
    $style_key    = $preset['button_style'] ?? 'blue';
    $size_key     = $preset['button_size'] ?? 'default';
    $rounded_key  = $preset['button_rounded'] ?? 'default';

    // Size Mapping
    $size_map = [
      'xs'      => 'px-3 py-1 text-xs',
      'sm'      => 'px-4 py-1.5 text-sm',
      'md'      => 'px-6 py-2.5 text-base',
      'lg'      => 'px-8 py-3.5 text-lg',
      'default' => 'px-6 py-2.5 text-base',
    ];
    $size_class = $size_map[$size_key] ?? $size_map['default'];

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
    $inline_style = '';

    // Handle Custom Style Group
    if ($style_key === 'custom') {
      $custom_style = $more_settings['custom_style'] ?? [];
      $default_state = $custom_style['default_state'] ?? [];
      $hover_state = $custom_style['hover_state'] ?? [];

      $btn_vars = [];
      // Default State Vars
      if ($default_state['button_bg_color']) $btn_vars[] = "--btn-bg: {$default_state['button_bg_color']}";
      if ($default_state['button_border_color']) $btn_vars[] = "--btn-border: {$default_state['button_border_color']}";
      if ($default_state['button_text_color']) $btn_vars[] = "--btn-text: {$default_state['button_text_color']}";

      // Hover State Vars
      if ($hover_state['button_bg_color']) $btn_vars[] = "--btn-bg-hover: {$hover_state['button_bg_color']}";
      if ($hover_state['button_border_color']) $btn_vars[] = "--btn-border-hover: {$hover_state['button_border_color']}";
      if ($hover_state['button_text_color']) $btn_vars[] = "--btn-text-hover: {$hover_state['button_text_color']}";

      if (!empty($btn_vars)) {
        $inline_style = implode('; ', $btn_vars);
        $button_style_class = 'bg-[var(--btn-bg)] border-[var(--btn-border)] text-[var(--btn-text)] hover:bg-[var(--btn-bg-hover)] hover:border-[var(--btn-border-hover)] hover:text-[var(--btn-text-hover)]';
      }
    }

    $final_button_classes = array_filter([
      'inline-flex items-center justify-center border-2 font-semibold transition-all duration-300 transform active:scale-95 hover:shadow-lg',
      $size_class,
      $rounded_class,
      $button_style_class
    ]);

    echo sprintf(
      '<a href="%1$s" class="%2$s" style="%3$s" target="%4$s" title="%5$s"><span>%6$s</span></a>',
      esc_url($url),
      esc_attr(implode(' ', $final_button_classes)),
      esc_attr($inline_style),
      esc_attr($target),
      esc_attr($title),
      esc_html($title)
    );
  }

  echo '</div>';
}
