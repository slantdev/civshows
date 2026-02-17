<?php

/**
 * Table Component
 * 
 * Optimized for Tailwind CSS v4.
 * Supports dynamic columns (2-4), multiple styles, and modular cell content.
 */

$field = $args['field'] ?? '';
$class = $args['class'] ?? '';

// Getting table component data
$table_comp = is_array($field) ? $field : get_sub_field($field ?: 'table');

if (!$table_comp) return;

// Generate a stable ID based on Post ID and a static counter
static $table_count = 0;
$table_count++;
$table_id_attr = 'table-' . get_the_ID() . '-' . $table_count;

// Data Extraction
$table_data     = $table_comp['table'] ?? [];
$settings       = $table_data['table_settings'] ?? [];
$col_count_key  = $settings['table_columns'] ?? 'two';
$style_key      = $settings['table_style'] ?? 'plain';
$table_title    = $table_data['table_title'] ?? [];
$rows           = $table_data['table_row'] ?? [];

// Column Logic
$cols_map = [
  'two'   => 2,
  'three' => 3,
  'four'  => 4
];
$active_cols = $cols_map[$col_count_key] ?? 2;

// Style Logic
$style_map = [
  'plain'    => 'border-none [&_td]:px-0 [&_td]:py-1 [&_th]:px-0 [&_th]:py-1',
  'bordered' => 'border border-gray-200 [&_td]:border [&_td]:border-gray-200 [&_th]:border [&_th]:border-gray-200 [&_td]:px-3 [&_td]:py-2 [&_th]:px-3 [&_th]:py-2',
  'stripped' => 'border-t border-gray-200 [&_td]:border-b [&_td]:border-gray-200 [&_th]:border-b [&_th]:border-gray-200 [&_td]:px-3 [&_td]:py-2 [&_th]:px-3 [&_th]:py-2',
  'stripped-gray' => '[&_tr:nth-child(even)]:bg-gray-100 border-t border-gray-200 [&_td]:border-b [&_td]:border-gray-200 [&_th]:border-b [&_th]:border-gray-200 [&_td]:px-3 [&_td]:py-2 [&_th]:px-3 [&_th]:py-2',
  'gray-bg'     => 'bg-gray-100 border-t border-gray-200 [&_td]:border-b [&_td]:border-gray-200 [&_th]:border-b [&_th]:border-gray-200 [&_td]:px-3 [&_td]:py-2 [&_th]:px-3 [&_th]:py-2',
];
$style_class = $style_map[$style_key] ?? '';

?>

<div id="<?php echo esc_attr($table_id_attr); ?>" class="table-component-wrapper overflow-x-auto mb-6 lg:mb-8 <?php echo esc_attr($class); ?>">

  <?php if (!empty($table_title)) : ?>
    <div class="mb-4">
      <?php get_template_part('template-parts/components/text', '', ['field' => $table_title]); ?>
    </div>
  <?php endif; ?>

  <table class="w-full text-left border-collapse <?php echo esc_attr($style_class); ?>">
    <tbody>
      <?php foreach ($rows as $row) : ?>
        <tr class="transition-colors">

          <?php
          // Loop through the columns based on the setting
          for ($i = 1; $i <= $active_cols; $i++) :
            $col_name = match ($i) {
              1 => 'column_one',
              2 => 'column_two',
              3 => 'column_three',
              4 => 'column_four',
            };

            $col_data = $row[$col_name] ?? [];
            $comp_type = $col_data["column_{$i}_component"] ?? 'empty';
          ?>
            <td>
              <?php
              if ($comp_type === 'text') {
                get_template_part('template-parts/components/text', '', ['field' => $col_data["column_{$i}_text"]]);
              } elseif ($comp_type === 'button') {
                get_template_part('template-parts/components/button', '', ['field' => $col_data["column_{$i}_button"]]);
              }
              ?>
            </td>
          <?php endfor; ?>

        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</div>