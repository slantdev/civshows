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
  static $subscribe_count = 0;
  $subscribe_count++;
  $section_id = 'section-subscribe-' . get_the_ID() . '-' . $subscribe_count;
}

$section_id_attr = 'id="' . esc_attr($section_id) . '"';

// Data
$subscribe_group = get_sub_field('subscribe');
$intro           = $subscribe_group['intro'] ?? [];
$form_group      = $subscribe_group['form'] ?? [];

?>

<section <?php echo $section_id_attr; ?> class="section-subscribe flex flex-col md:flex-row w-full min-h-[500px] relative overflow-hidden" style="<?php echo esc_attr($section_style); ?>">

  <?php echo $section_overlay_markup; ?>

  <!-- Left Column: Intro -->
  <div class="intro-column w-full md:w-1/2 relative bg-gray-800">

    <?php if (!empty($intro['background'])) : ?>
      <?php get_template_part('template-parts/components/background', '', ['field' => $intro['background']]); ?>
    <?php endif; ?>

    <div class="relative z-10 h-full flex flex-col justify-center px-8 md:px-16 py-12 lg:py-24">
      <?php if (!empty($intro['intro_title'])) : ?>
        <div class="mb-6">
          <?php get_template_part('template-parts/components/heading', '', [
            'field' => $intro['intro_title'],
            'class' => ''
          ]); ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($intro['intro_description'])) : ?>
        <div class="max-w-lg">
          <?php get_template_part('template-parts/components/heading', '', [
            'field' => $intro['intro_description'],
            'class' => ''
          ]); ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Right Column: Form -->
  <div class="form-column w-full md:w-1/2 relative px-8 md:px-16 py-12 lg:py-24 flex flex-col justify-center bg-civ-green-500">

    <?php if (!empty($form_group['background'])) : ?>
      <?php get_template_part('template-parts/components/background', '', ['field' => $form_group['background']]); ?>
    <?php endif; ?>

    <div class="relative z-10">
      <?php if (!empty($form_group['form_title'])) : ?>
        <div class="mb-8">
          <?php get_template_part('template-parts/components/heading', '', [
            'field' => $form_group['form_title'],
            'class' => ''
          ]); ?>
        </div>
      <?php endif; ?>

      <div class="subscribe-form-wrapper w-full max-w-lg">
        <?php if (!empty($form_group['form_shortcode'])) : ?>
          <?php echo do_shortcode($form_group['form_shortcode']); ?>
        <?php else : ?>
          <!-- Fallback Static Form if no shortcode -->
          <form class="w-full max-w-lg">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">

              <div class="relative">
                <input type="text" placeholder="First Name" class="w-full bg-white rounded-md py-3 pl-4 pr-10 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-700 transition-shadow">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-300">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                  </svg>
                </div>
              </div>

              <div class="relative">
                <input type="text" placeholder="Last Name" class="w-full bg-white rounded-md py-3 pl-4 pr-10 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-700 transition-shadow">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-300">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                  </svg>
                </div>
              </div>

              <div class="relative">
                <input type="email" placeholder="Email" class="w-full bg-white rounded-md py-3 pl-4 pr-10 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-700 transition-shadow">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-300">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                  </svg>
                </div>
              </div>

              <div class="relative">
                <input type="text" placeholder="Postcode" class="w-full bg-white rounded-md py-3 pl-4 pr-10 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-700 transition-shadow">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-300">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                  </svg>
                </div>
              </div>

            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">

              <label class="flex items-center space-x-2 cursor-pointer group">
                <div class="relative flex items-center">
                  <input type="checkbox" class="peer h-5 w-5 cursor-pointer appearance-none rounded border border-white/50 bg-white/20 checked:bg-white checked:border-white transition-all" checked>
                  <svg class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-3.5 h-3.5 pointer-events-none opacity-0 peer-checked:opacity-100 text-civ-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                  </svg>
                </div>
                <span class="text-white text-sm font-medium select-none">I agree with all conditions</span>
              </label>

              <button type="button" class="bg-black hover:bg-gray-900 text-white font-bold py-3 px-12 rounded transition-colors w-full sm:w-auto text-center">
                Subscribe
              </button>
            </div>

          </form>
        <?php endif; ?>
      </div>
    </div>
  </div>

</section>