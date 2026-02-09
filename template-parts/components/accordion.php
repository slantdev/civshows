<?php

// Extracting field and class from args with null coalescing operator
$field = $args['field'] ?? '';
$class = $args['class'] ?? '';

// Getting accordion component
// Handles both passed data array (nested) or direct sub field (top level)
$accordion_comp = is_array($field) ? $field : get_sub_field($field ?: 'accordion');

if (!$accordion_comp) return;

// Extracting accordion details
$accordion_repeater = $accordion_comp['accordion'] ?? [];
$accordion_header = $accordion_comp['settings']['more_settings']['accordion_header'] ?? [];
$header_default_text_color = $accordion_header['default_state']['text_color'] ?? '';
$header_default_background_color = $accordion_header['default_state']['background_color'] ?? '';
$header_default_border_color = $accordion_header['default_state']['border_color'] ?? '';
$header_default_icon_color = $accordion_header['default_state']['icon_color'] ?? '';
$header_opened_text_color = $accordion_header['opened_state']['text_color'] ?? '';
$header_opened_background_color = $accordion_header['opened_state']['background_color'] ?? '';
$header_opened_border_color = $accordion_header['opened_state']['border_color'] ?? '';
$header_opened_icon_color = $accordion_header['opened_state']['icon_color'] ?? '';
$accordion_content = $accordion_comp['settings']['more_settings']['accordion_content'] ?? [];
$content_text_color = $accordion_content['default_state']['text_color'] ?? '';
$content_background_color = $accordion_content['default_state']['background_color'] ?? '';
$content_border_color = $accordion_content['default_state']['border_color'] ?? '';

// Prepare CSS Variables for dynamic colors
$acc_vars = [];
if ($header_default_text_color) $acc_vars[] = "--acc-header-text: {$header_default_text_color}";
if ($header_default_background_color) $acc_vars[] = "--acc-header-bg: {$header_default_background_color}";
if ($header_default_border_color) $acc_vars[] = "--acc-header-border: {$header_default_border_color}";
if ($header_default_icon_color) $acc_vars[] = "--acc-icon: {$header_default_icon_color}";

if ($header_opened_text_color) $acc_vars[] = "--acc-header-text-open: {$header_opened_text_color}";
if ($header_opened_background_color) $acc_vars[] = "--acc-header-bg-open: {$header_opened_background_color}";
if ($header_opened_border_color) $acc_vars[] = "--acc-header-border-open: {$header_opened_border_color}";
if ($header_opened_icon_color) $acc_vars[] = "--acc-icon-open: {$header_opened_icon_color}";

if ($content_text_color) $acc_vars[] = "--acc-content-text: {$content_text_color}";
if ($content_background_color) $acc_vars[] = "--acc-content-bg: {$content_background_color}";
if ($content_border_color) $acc_vars[] = "--acc-content-border: {$content_border_color}";

$style_attr = !empty($acc_vars) ? 'style="' . esc_attr(implode('; ', $acc_vars)) . '"' : '';



// Generate a stable ID based on Post ID and a static counter
static $accordion_count = 0;
$accordion_count++;
$stable_id = get_the_ID() . '-' . $accordion_count;
$accordion_id = 'accordion-' . $stable_id;

// Outputting accordion if repeater exists
if ($accordion_repeater) { ?>
  <div id="<?php echo $accordion_id ?>" class="relative space-y-2" <?php echo $style_attr; ?>>
    <?php
    foreach ($accordion_repeater as $accordion) :
      $title = $accordion['title'] ?? '';
      $content = $accordion['content'] ?? '';
    ?>
      <details
        class="group rounded-lg transition-all duration-400 border
          bg-(--acc-header-bg,var(--color-gray-100)) 
          border-(--acc-header-border,var(--color-gray-300)) 
          open:bg-(--acc-header-bg-open,var(--color-white)) 
          open:border-(--acc-header-border-open,var(--color-gray-200)) 
          open:ring-1 open:ring-(--acc-header-border-open,var(--color-gray-200))"
        name="<?php echo esc_attr($accordion_id); ?>">

        <!-- Summary (Title) -->
        <summary class="flex items-center justify-between cursor-pointer py-4 px-5 lg:py-5 lg:pl-8 lg:pr-8 text-xl font-semibold list-none marker:hidden focus:outline-none
          text-(--acc-header-text,var(--color-gray-900))
          group-open:text-(--acc-header-text-open,var(--color-gray-900))">
          <span><?php echo esc_html($title); ?></span>

          <!-- Icon (+ / -) -->
          <span class="relative ml-4 h-6 w-6 shrink-0">
            <svg class="absolute inset-0 w-6 h-6 transition-transform duration-200 ease-out group-open:rotate-180 group-open:opacity-0
              text-(--acc-icon,var(--color-gray-900))" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            <svg class="absolute inset-0 w-6 h-6 transition-transform duration-200 ease-out opacity-0 rotate-90 group-open:rotate-0 group-open:opacity-100
              text-(--acc-icon-open,var(--color-gray-900))" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
            </svg>
          </span>
        </summary>

        <!-- Content -->
        <div class="px-5 pb-6 lg:px-8 lg:pb-8 prose max-w-none border-t mt-2 pt-4
          text-(--acc-content-text,inherit)
          bg-(--acc-content-bg,transparent)
          border-(--acc-content-border,var(--color-gray-200))">
          <?php echo wp_kses_post($content); ?>
        </div>

      </details>

    <?php endforeach ?>
  </div>
<?php }
