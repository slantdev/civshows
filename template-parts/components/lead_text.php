<?php

/**
 * Lead Text Component
 * 
 * Optimized for Tailwind CSS v4 and adjusted to project standards.
 */

// Extracting field and class from args with null coalescing operator
$field   = $args['field'] ?? '';
$class   = $args['class'] ?? '';
$align   = $args['align'] ?? '';
$size    = $args['size'] ?? '';
$weight  = $args['weight'] ?? '';
$leading = $args['leading'] ?? '';

// Getting lead text component
$lead_text_comp = is_array($field) ? $field : get_sub_field($field ?: 'lead_text');

if (!$lead_text_comp) return;

// Generate a stable ID based on Post ID and a static counter
static $lead_text_count = 0;
$lead_text_count++;
$lead_text_id = 'lead-text-' . get_the_ID() . '-' . $lead_text_count;

// Extracting lead text and text color
$lead_text_data = $lead_text_comp['lead_text'] ?? [];
$lead_text      = $lead_text_data['lead_text'] ?? '';
$text_color     = $lead_text_data['settings']['text_color'] ?? '';

// Setting lead text style
$inline_style = $text_color ? sprintf('color: %1$s; --tw-prose-lead: %1$s;', esc_attr($text_color)) : '';

// Assigning default classes
$text_size_class    = $size ?: 'text-base';
$text_align_class   = $align ?: '';
$text_leading_class = $leading ?: 'leading-relaxed';
$text_weight_class  = $weight ?: 'font-normal';

// Combining classes
$final_classes = array_filter([
  'lead-text-wrapper mb-6 max-w-none prose',
  $text_size_class,
  $text_align_class,
  $text_leading_class,
  $text_weight_class,
  $class
]);

// Outputting lead text if exists
if ($lead_text) {
  echo sprintf(
    '<div id="%1$s" class="%2$s" style="%3$s">',
    esc_attr($lead_text_id),
    esc_attr(implode(' ', $final_classes)),
    $inline_style
  );
  echo '<p class="lead">' . wp_kses_post($lead_text) . '</p>';
  echo '</div>';
}
