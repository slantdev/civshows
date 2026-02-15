<?php

/**
 * Text Component
 * 
 * Optimized for Tailwind CSS v4.
 * Default to paragraph text with flexible HTML tags and styling.
 */

// Extracting field and class from args with null coalescing operator
$field = $args['field'] ?? '';
$class = $args['class'] ?? '';

// Getting text component
$text_comp = is_array($field) ? $field : get_sub_field($field ?: 'text');

if (!$text_comp) return;

// Generate a stable ID based on Post ID and a static counter
static $text_count = 0;
$text_count++;
$text_id = 'text-' . get_the_ID() . '-' . $text_count;

// Extracting details
$text_area  = $text_comp['text']['text_area'] ?? '';
$text_color = $text_comp['text']['settings']['text_color'] ?? '';
$settings   = $text_comp['text']['settings']['settings'] ?? [];

// Extracting advanced settings
$html_tag = $settings['html_tag'] ?? 'p';
// Validate tag
$allowed_tags = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'div', 'span'];
if (!in_array($html_tag, $allowed_tags)) {
  $html_tag = 'p';
}

$text_size     = $settings['text_size'] ?? 'default';
$font_weight   = $settings['font_weight'] ?? 'normal';
$alignment     = $settings['alignment'] ?? '';
$margin_top    = $settings['margins']['margin_top'] ?? 'none';
$margin_bottom = $settings['margins']['margin_bottom'] ?? 'md';

// Applying style if color exists
$text_style = $text_color ? 'color:' . $text_color . ';' : '';

// Size Mapping
$text_size_classes = [
  "default" => '',
  "xs"      => 'text-xs',
  "sm"      => 'text-sm',
  "md"      => 'text-md',
  "lg"      => 'text-lg',
  "xl"      => 'text-xl',
  "2xl"     => 'text-2xl',
  "3xl"     => 'text-3xl',
  "4xl"     => 'text-4xl',
  "5xl"     => 'text-5xl'
];
$text_size_class = $text_size_classes[$text_size] ?? $text_size_classes['default'];

// Weight Mapping
$text_weight_classes = [
  "thin"      => 'font-thin',
  "normal"    => 'font-normal',
  "medium"    => 'font-medium',
  "semibold"  => 'font-semibold',
  "bold"      => 'font-bold',
  "black"     => 'font-black',
  "default"   => 'font-normal'
];
$text_weight_class = $text_weight_classes[$font_weight] ?? 'font-normal';

$text_align_class = $alignment ? 'text-' . $alignment : '';

// Margin Mapping
$margin_top_classes = [
  "none" => 'mt-0',
  "xs"   => 'mt-2 lg:mt-3',
  "sm"   => 'mt-3 lg:mt-4',
  "md"   => 'mt-4 lg:mt-6',
  "lg"   => 'mt-8 lg:mt-10',
  "xl"   => 'mt-10 lg:mt-12',
  "2xl"  => 'mt-12 lg:mt-14'
];
$margin_top_class = $margin_top_classes[$margin_top] ?? 'mt-0';

$margin_bottom_classes = [
  "none" => 'mb-0',
  "xs"   => 'mb-2 lg:mb-3',
  "sm"   => 'mb-3 lg:mb-4',
  "md"   => 'mb-4 lg:mb-6',
  "lg"   => 'mb-8 lg:mb-10',
  "xl"   => 'mb-10 lg:mb-12',
  "2xl"  => 'mb-12 lg:mb-14'
];
$margin_bottom_class = $margin_bottom_classes[$margin_bottom] ?? 'mb-4 lg:mb-6';

// Combining classes
$final_classes = array_filter([
  'text-component',
  $text_size_class,
  $text_align_class,
  $text_weight_class,
  $margin_top_class,
  $margin_bottom_class,
  $class
]);

// Outputting text if it exists
if ($text_area) {
  echo sprintf(
    '<%1$s id="%2$s" class="%3$s" style="%4$s">%5$s</%1$s>',
    esc_attr($html_tag),
    esc_attr($text_id),
    esc_attr(implode(' ', $final_classes)),
    esc_attr($text_style),
    wp_kses_post($text_area)
  );
}
