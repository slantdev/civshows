<?php
// Extracting field from args
$field = $args['field'] ?? '';

// Getting icon component
$icon_comp = is_array($field) ? $field : get_sub_field($field ?: 'icon_group');

if (!$icon_comp) return;

// Generate stable ID
static $icon_count = 0;
$icon_count++;
$icon_id = 'icon-' . get_the_ID() . '-' . $icon_count;

// Extracting icon data
$icon_group = $icon_comp['icon_group'] ?? [];
$icon_data  = $icon_group['icon'] ?? [];
$icon_name  = $icon_data['value'] ?? '';
$icon_set   = $icon_data['type'] ?? 'heroicons_solid';

$icon_color = $icon_group['settings']['icon_color'] ?? '';
$settings   = $icon_group['settings']['settings'] ?? [];

$icon_size     = $settings['icon_size'] ?? 'default';
$alignment     = $settings['alignment'] ?? '';
$margin_top    = $settings['margins']['margin_top'] ?? 'none';
$margin_bottom = $settings['margins']['margin_bottom'] ?? 'none';

if (!$icon_name) return;

// Setting Styles
$style = $icon_color ? "color: {$icon_color}; fill: currentColor;" : "";

// Map Sizes (Width & Height)
$size_map = [
  'default' => 'w-16 h-16',
  'xs'      => 'w-6 h-6',
  'sm'      => 'w-8 h-8',
  'md'      => 'w-10 h-10',
  'lg'      => 'w-12 h-12',
  'xl'      => 'w-16 h-16',
  '2xl'     => 'w-20 h-20',
  '3xl'     => 'w-24 h-24',
  '4xl'     => 'w-32 h-32',
  '5xl'     => 'w-40 h-40',
];
$size_class = $size_map[$icon_size] ?? 'w-10 h-10';

// Map Alignments
$align_map = [
  'left'   => 'flex justify-start text-left',
  'center' => 'flex justify-center text-center',
  'right'  => 'flex justify-end text-right',
];
$align_class = $align_map[$alignment] ?? 'flex justify-start text-left';

// Map Margins
$margin_top_map = [
  'none' => 'mt-0',
  'xs'   => 'mt-2',
  'sm'   => 'mt-4',
  'md'   => 'mt-6',
  'lg'   => 'mt-8',
  'xl'   => 'mt-10',
  '2xl'  => 'mt-12'
];
$margin_top_class = $margin_top_map[$margin_top] ?? 'mt-0';

$margin_bottom_map = [
  'none' => 'mb-0',
  'xs'   => 'mb-2',
  'sm'   => 'mb-4',
  'md'   => 'mb-6',
  'lg'   => 'mb-8',
  'xl'   => 'mb-10',
  '2xl'  => 'mb-12'
];
$margin_bottom_class = $margin_bottom_map[$margin_bottom] ?? 'mb-0';

$classes = implode(' ', array_filter([
  'civ-icon-component w-full',
  $align_class,
  $margin_top_class,
  $margin_bottom_class
]));

$icon_markup = civ_icon([
  'icon'  => $icon_name,
  'group' => $icon_set,
  'size'  => false,
  'class' => $size_class
]);

?>

<div id="<?php echo esc_attr($icon_id); ?>" class="<?php echo esc_attr($classes); ?>" style="<?php echo esc_attr($style); ?>">
  <div class="inline-flex items-center justify-center">
    <?php echo $icon_markup; ?>
  </div>
</div>