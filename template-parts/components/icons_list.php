<?php

/**
 * Icons List Component
 * 
 * Optimized for Tailwind CSS v4 and adjusted to project standards.
 */

$field = $args['field'] ?? '';
$class = $args['class'] ?? '';

// Getting component data
$icons_list_comp = is_array($field) ? $field : get_sub_field($field ?: 'icons_list');

if (!$icons_list_comp) return;

// Generate a stable ID based on Post ID and a static counter
static $icons_list_count = 0;
$icons_list_count++;
$icons_list_id = 'icons-list-' . get_the_ID() . '-' . $icons_list_count;

// Extracting repeater and settings
$repeater      = $icons_list_comp['icons_list'] ?? [];
$more_settings = $icons_list_comp['settings']['more_settings'] ?? [];

$icon_settings = $more_settings['icon_settings'] ?? [];
$size_key   = $icon_settings['icon_size'] ?? 'default';
$style_key  = $icon_settings['icon_style'] ?? 'plain';
$icon_color = $icon_settings['icon_color'] ?? '#1068F0';
$icon_bg_color   = $icon_settings['icon_bg_color'] ?? 'rgba(255,255,255,0)';

$title_settings = $more_settings['title_settings'] ?? [];
$title_color = $title_settings['title_color'] ?? '#374151';
$title_font_style = $title_settings['title_font_style'] ?? '';
// Remove bold from $font_style_map
//
// Add Title Font Weight
$title_font_weight = $title_settings['title_font_weight'] ?? 'regular';

$description_settings = $more_settings['description_settings'] ?? [];
$description_color = $description_settings['description_color'] ?? '#374151';

// Add HR settings
$hr_settings = $more_settings['hr_settings'] ?? [];
$horizontal_line = $hr_settings['horizontal_line'] ?? false;
$hr_color = $hr_settings['hr_color'] ?? '#d1d5db';


// Icon Size Mapping (px)
$size_map = [
  'small'   => 24,
  'default' => 32,
  'medium'  => 48,
  'large'   => 64,
];
$icon_pixel_size = $size_map[$size_key] ?? $size_map['default'];

// Padding Mapping for circled style
$padding_map = [
  'small'   => 'p-1',
  'default' => 'p-2',
  'medium'  => 'p-2.5',
  'large'   => 'p-3',
];
$padding_class = $padding_map[$size_key] ?? $padding_map['default'];

// Font Style Mapping for title
$font_style_map = [
  'italic' => 'italic',
  'underline'  => 'underline',
];
$title_font_style_class = $font_style_map[$title_font_style] ?? '';

// Font Weight Mapping for title
$font_weight_map = [
  'regular'   => 'font-normal',
  'medium'    => 'font-medium',
  'semi-bold' => 'font-semibold',
  'bold'      => 'font-bold',
  'black'     => 'font-black',
];
$title_font_weight_class = $font_weight_map[$title_font_weight] ?? 'font-normal';

// CSS Variables
$list_vars = [];
if ($icon_color) $list_vars[] = "--icon-color: {$icon_color}";
if ($title_color) $list_vars[] = "--title-color: {$title_color}";
if ($icon_bg_color)   $list_vars[] = "--icon-bg: {$icon_bg_color}";
if ($description_color)   $list_vars[] = "--description-color: {$description_color}";
if ($horizontal_line && $hr_color) $list_vars[] = "--hr-color: {$hr_color}";

$inline_style = !empty($list_vars) ? 'style="' . esc_attr(implode('; ', $list_vars)) . '"' : '';

if ($repeater) : ?>
  <div id="<?php echo esc_attr($icons_list_id); ?>" class="civ-icons-list-component icons-list-component relative <?php echo esc_attr($class); ?>" <?php echo $inline_style; ?>>
    <div class="civ-icons-list-wrapper <?php echo $horizontal_line ? '' : 'space-y-4'; ?>">
      <?php foreach ($repeater as $index => $item) :
        $icon_data   = $item['icon'] ?? [];
        $icon_name   = $icon_data['value'] ?? '';
        $icon_group  = $icon_data['type'] ?? 'utility';
        $title       = $item['title'] ?? '';
        $description = $item['description'] ?? '';

        if (!$icon_name && !$title && !$description) continue;

        // Container classes for the icon
        $icon_container_classes = array_filter([
          'icon-wrapper shrink-0 flex items-center justify-center transition-all',
          $style_key === 'circled' ? 'rounded-full bg-(--icon-bg) ' . $padding_class : '',
        ]);
      ?>
        <div class="civ-icons-list-item flex items-start gap-3 lg:gap-4 group <?php echo $horizontal_line ? 'py-4' : ''; ?>">

          <?php if ($icon_name) : ?>
            <div class="<?php echo esc_attr(implode(' ', $icon_container_classes)); ?>">
              <?php echo civ_icon([
                'icon'  => $icon_name,
                'group' => $icon_group,
                'size'  => $icon_pixel_size,
                'class' => 'text-(--icon-color) w-auto h-auto'
              ]); ?>
            </div>
          <?php endif; ?>

          <?php if ($title || $description) : ?>
            <div class="civ-icons-list-content content-wrapper text-left">
              <?php if ($title) : ?>
                <div class="civ-icons-list-title prose max-w-none pt-0.5 text-(--title-color) <?php echo esc_attr($title_font_style_class . ' ' . $title_font_weight_class); ?>"><?php echo esc_html($title); ?></div>
              <?php endif; ?>
              <?php if ($description) : ?>
                <div class="civ-icons-list-description prose max-w-none mt-2 text-(--description-color)">
                  <?php echo wp_kses_post($description); ?>
                </div>
              <?php endif; ?>
            </div>
          <?php endif; ?>

        </div>

        <?php if ($horizontal_line && $index < count($repeater) - 1) : ?>
          <hr class="border-(--hr-color) m-0" />
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
<?php endif;
