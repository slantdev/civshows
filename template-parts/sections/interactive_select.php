<?php
include get_template_directory() . '/template-parts/global/section-settings.php';
/*
 * Available section variables (from section-settings.php):
 * $section_id
 * $section_style
 * $section_container_class
 * $section_overlay_markup
 */

// Generate stable ID if not set
if (!$section_id) {
  static $interactive_select_count = 0;
  $interactive_select_count++;
  $section_id = 'section-interactive-select-' . get_the_ID() . '-' . $interactive_select_count;
}

$section_id_attr = 'id="' . esc_attr($section_id) . '"';

// Data
$interactive_group = get_sub_field('interactive_select');
$select_label      = $interactive_group['select_label'] ?? [];
$label_text        = $select_label['label_text'] ?? 'I want to';
$label_color       = $select_label['text_color'] ?? '#FFFFFF';

$options_repeater = $interactive_group['select_options_repeater'] ?? [];

if (empty($options_repeater)) return;

// Prepare data for JS
$interactive_data = [];
foreach ($options_repeater as $index => $option) {
  $option_label = $option['option_label'] ?? '';
  $option_slug  = sanitize_title($option_label) . '-' . $index;
  $cards        = $option['option_cards'] ?? [];
  
  $card_data = [];
  foreach ($cards as $card) {
    $btn_link = $card['button_link'] ?? [];
    $card_data[] = [
      'title'    => $card['title'] ?? '',
      'subtitle' => $card['subtitle'] ?? '',
      'category' => $card['category'] ?? '',
      'btn_text' => $btn_link['title'] ?? 'Learn More',
      'btn_url'  => $btn_link['url'] ?? '#',
      'btn_target' => $btn_link['target'] ?? '_self',
    ];
  }

  $interactive_data[$option_slug] = [
    'label' => $option_label,
    'cards' => $card_data
  ];
}
?>

<section <?php echo $section_id_attr; ?> 
  class="section-interactive-select w-full bg-civ-blue-500 relative transition-all duration-500 ease-in-out" 
  style="<?php echo esc_attr($section_style); ?>"
  data-interactive-content='<?php echo esc_attr(json_encode($interactive_data)); ?>'
>

  <?php echo $section_overlay_markup; ?>

  <div class="container mx-auto px-4 xl:px-8 py-16 relative z-20">

    <div class="flex flex-col md:flex-row items-center justify-center text-3xl md:text-4xl font-light gap-3" style="color: <?php echo esc_attr($label_color); ?>;">

      <span class="shrink-0"><?php echo esc_html($label_text); ?></span>

      <div class="relative group dropdown-container">

        <button class="dropdown-trigger flex items-center gap-4 border-b-2 border-white/50 pb-1 hover:border-white transition-colors cursor-pointer text-left min-w-[300px] justify-between">
          <span class="selected-text font-normal">Select an option</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7" />
          </svg>
        </button>

        <div class="dropdown-menu absolute top-full left-0 w-full bg-white text-civ-blue-900 shadow-xl rounded-b-lg overflow-hidden opacity-0 invisible transform -translate-y-2 transition-all duration-200 z-50">
          <ul class="py-2 text-lg">
            <?php foreach ($interactive_data as $slug => $data) : ?>
              <li>
                <button class="w-full text-left px-6 py-3 hover:bg-civ-blue-50 transition-colors option-btn" data-value="<?php echo esc_attr($slug); ?>">
                  <?php echo esc_html($data['label']); ?>
                </button>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

    </div>

    <div class="expanded-content max-h-0 opacity-0 overflow-hidden transition-all duration-700 ease-in-out mt-0">

      <div class="pt-16 pb-4">
        <div class="swiper card-slider relative pb-14!">
          <div class="swiper-wrapper">
            <!-- Populated via JS -->
          </div>

          <div class="swiper-pagination bottom-2!"></div>

          <div class="hidden md:flex absolute bottom-0 right-0 gap-2 z-10">
            <div class="swiper-button-prev static! w-10! h-10! mt-0! bg-white! hover:bg-gray-100! rounded-full p-3 flex items-center justify-center text-civ-blue-600! transition-colors after:text-sm!"></div>
            <div class="swiper-button-next static! w-10! h-10! mt-0! bg-white! hover:bg-gray-100! rounded-full p-3 flex items-center justify-center text-civ-blue-600! transition-colors after:text-sm!"></div>
          </div>

        </div>
      </div>

    </div>

  </div>

  <div class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-20 border-l-transparent border-r-20 border-r-transparent border-t-20 border-t-civ-blue-500 z-10"></div>

</section>
