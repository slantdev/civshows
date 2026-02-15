<?php

/**
 * Buttons Component (Repeater)
 * 
 * Optimized for Tailwind CSS v4 and adjusted to project standards.
 * Supports nested ACF groups for Presets, Custom Styles, and Icons.
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
    // We delegate the individual button rendering to the single button component
    get_template_part('template-parts/components/button', '', [
      'field' => $button,
      'class' => '' // We can pass additional classes if needed
    ]);
  }

  echo '</div>';
}