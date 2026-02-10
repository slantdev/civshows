<?php

/**
 * Content Editor Component
 * 
 * Optimized for Tailwind CSS v4 Typography (prose).
 */

// Extracting field and class from args with null coalescing operator
$field = $args['field'] ?? '';
$class = $args['class'] ?? '';

// Getting content editor component
$content_editor_comp = is_array($field) ? $field : get_sub_field($field ?: 'content_editor');

if (!$content_editor_comp) return;

// Generate a stable ID based on Post ID and a static counter
static $content_editor_count = 0;
$content_editor_count++;
$content_editor_id = 'content-editor-' . get_the_ID() . '-' . $content_editor_count;

// Extracting content editor and text color from content editor component
$content_html = $content_editor_comp['content_editor']['content_editor'] ?? '';
$text_color   = $content_editor_comp['content_editor']['settings']['text_color'] ?? '';

$inline_style = '';

// Assigning text color and prose variables if available
if ($text_color) {
  $inline_style = sprintf(
    'color: %1$s; --tw-prose-body: %1$s; --tw-prose-headings: %1$s; --tw-prose-counters: %1$s; --tw-prose-bullets: %1$s;',
    esc_attr($text_color)
  );
}

// Outputting content editor if available
if ($content_html) {
  $final_classes = array_filter([
    'prose max-w-none mb-6',
    $class
  ]);

  echo sprintf(
    '<div id="%1$s" class="%2$s" style="%3$s">%4$s</div>',
    esc_attr($content_editor_id),
    esc_attr(implode(' ', $final_classes)),
    $inline_style,
    $content_html // WYSIWYG content should not be double-escaped if it contains trusted layout HTML
  );
}
