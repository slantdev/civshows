<?php

/**
 * Image Component
 * 
 * Optimized for Tailwind CSS v4 and adjusted to project standards.
 */

$field = $args['field'] ?? '';
$class = $args['class'] ?? '';

// Getting image component
$image_comp = is_array($field) ? $field : get_sub_field($field ?: 'image');

if (!$image_comp) return;

// Generate a stable ID based on Post ID and a static counter
static $image_count = 0;
$image_count++;
$image_id_attr = 'image-' . get_the_ID() . '-' . $image_count;

// Extracting image details
$image_data   = $image_comp['image'] ?? [];
$image_source = $image_data['image_source'] ?? [];
$image_link   = $image_data['link'] ?? [];

$image_url    = $image_source['url'] ?? '';
$image_alt    = $image_source['alt'] ?? '';
$image_attach_id = $image_source['ID'] ?? '';

$link_url     = $image_link['url'] ?? '';
$link_target  = $image_link['target'] ?? '_self';

// Settings
$image_alignment = $image_comp['settings']['image_alignment'] ?? 'left';
$more_settings = $image_comp['settings']['more_settings'] ?? [];
$aspect_ratio  = $more_settings['aspect_ratio'] ?? 'default';
$corner_key    = $more_settings['image_corners'] ?? 'default';
$max_width_key = $more_settings['image_max_width'] ?? 'default';

// Alignment Mapping
$alignment_map = [
  'left'   => 'mr-auto',
  'center' => 'mx-auto',
  'right'  => 'ml-auto',
];
$alignment_class = $alignment_map[$image_alignment] ?? $alignment_map['left'];

// Aspect Ratio Mapping (Tailwind v4 native)
$aspect_map = [
  'default' => '',
  'none'    => 'aspect-auto',
  '1_1'     => 'aspect-1/1',
  '3_2'     => 'aspect-3/2',
  '4_3'     => 'aspect-4/3',
  '5_4'     => 'aspect-5/4',
  '16_9'    => 'aspect-16/9',
  '2_3'     => 'aspect-2/3',
  '3_4'     => 'aspect-4/3',
  '4_5'     => 'aspect-5/4',
  '9_16'     => 'aspect-9/16',
];
$aspect_class = $aspect_map[$aspect_ratio] ?? $aspect_map['default'];

// Corner Mapping
$corner_class = ($corner_key === 'default') ? 'rounded-xl' : $corner_key;

// Max Width Mapping
$max_width_map = [
  'default' => 'max-w-full',
  'none'    => 'max-w-none',
  'xs'      => 'max-w-xs',
  'sm'      => 'max-w-sm',
  'md'      => 'max-w-md',
  'lg'      => 'max-w-lg',
  'xl'      => 'max-w-xl',
  '2xl'     => 'max-w-2xl',
  'full'    => 'max-w-full',
];
$max_width_class = $max_width_map[$max_width_key] ?? $max_width_map['default'];

// Outputting image if URL exists
if ($image_url) {
  $wrapper_classes = array_filter([
    'image-component-wrapper mb-6',
    $max_width_class,
    $alignment_class,
    $class
  ]);

  $inner_classes = array_filter([
    'relative overflow-hidden w-full h-full',
    $aspect_class,
    $corner_class
  ]);
?>

  <div id="<?php echo esc_attr($image_id_attr); ?>" class="<?php echo esc_attr(implode(' ', $wrapper_classes)); ?>">
    <div class="<?php echo esc_attr(implode(' ', $inner_classes)); ?>">

      <?php if ($link_url) : ?>
        <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>" class="block w-full h-full">
        <?php endif; ?>

        <?php if ($image_attach_id) : ?>
          <?php echo wp_get_attachment_image($image_attach_id, 'full', false, [
            'class' => 'object-cover w-full h-full block'
          ]); ?>
        <?php else : ?>
          <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" class="object-cover w-full h-full block">
        <?php endif; ?>

        <?php if ($link_url) : ?>
        </a>
      <?php endif; ?>

    </div>
  </div>

<?php
}
