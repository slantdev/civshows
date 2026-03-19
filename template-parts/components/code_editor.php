<?php

/**
 * Code Editor Component
 * 
 * Optimized for Tailwind CSS v4 Typography (prose).
 */

// Extracting field and class from args
$field = $args['field'] ?? '';
$class = $args['class'] ?? '';

// Getting code editor content
$code_content = is_array($field) ? ($field['code_editor'] ?? '') : get_sub_field($field ?: 'code_editor');

// Fallback if $field was passed as the content itself
if (!$code_content && is_string($field) && !empty($field)) {
  $code_content = $field;
}

if (!$code_content) return;

// Generate a stable ID based on Post ID and a static counter
static $code_editor_count = 0;
$code_editor_count++;
$code_editor_id = 'code-editor-' . get_the_ID() . '-' . $code_editor_count;

// Combining classes
$final_classes = array_filter([
  'prose max-w-none mb-6',
  $class
]);

// Outputting code editor content
echo sprintf(
  '<div id="%1$s" class="%2$s">%3$s</div>',
  esc_attr($code_editor_id),
  esc_attr(implode(' ', $final_classes)),
  $code_content
);
