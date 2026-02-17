<?php

/**
 * Section: What's On (Shows)
 * 
 * Modular section displaying event highlights.
 * Integrated with global section settings and dynamic intro content.
 */

// Section Settings (Background, Padding etc)
include get_template_directory() . '/template-parts/global/section-settings.php';

$section_id_attr = $section_id ? 'id="' . esc_attr($section_id) . '"' : '';
$section_class   = 'section-whats-on-shows-' . uniqid();

// Data Extraction
$wo_comp    = get_sub_field('whats_on_shows');
$whats_on   = $wo_comp['whats_on'] ?? [];
$intro      = $whats_on['intro'] ?? [];
$wo_image   = $intro['image'] ?? [];

?>

<section <?php echo $section_id_attr; ?> class="<?php echo esc_attr($section_class); ?> section-wrapper relative" style="<?php echo esc_attr($section_style); ?>">

  <?php echo $section_overlay_markup; ?>

  <div class="section-container relative z-10 <?php echo esc_attr($section_container_class); ?>">
    <div class="container mx-auto px-4">

      <!-- Intro Area -->
      <div class="flex flex-col lg:flex-row items-end justify-between gap-12 mb-12 lg:mb-24">

        <div class="w-full lg:w-1/2 relative z-10">
          <?php if (!empty($intro['title'])) : ?>
            <div class="mb-6">
              <?php get_template_part('template-parts/components/heading', null, ['field' => $intro['title']]); ?>
            </div>
          <?php endif; ?>

          <?php if (!empty($intro['description'])) : ?>
            <div class="mb-10">
              <?php get_template_part('template-parts/components/lead_text', null, ['field' => $intro['description']]); ?>
            </div>
          <?php endif; ?>

          <div class="flex items-center gap-4">
            <button class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center text-gray-400 hover:border-civ-orange-500 hover:text-civ-orange-500 transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
              </svg>
            </button>

            <button class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center text-civ-blue-500 hover:border-civ-orange-500 hover:text-civ-orange-500 transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
              </svg>
            </button>

            <div class="flex items-center gap-2 cursor-pointer group ml-4">
              <span class="font-bold text-black uppercase text-sm group-hover:text-civ-orange-500 transition-colors">Thursday 18th October</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-civ-blue-500 group-hover:text-civ-orange-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            </div>
          </div>
        </div>

        <div class="w-full lg:w-5/12 flex justify-center lg:justify-end -mb-28 lg:-mb-32">
          <div class="w-full max-w-xl aspect-square rounded-full overflow-hidden relative shadow-xl border-8 border-white bg-gray-100">
            <?php 
            $img_data = $wo_image['image'] ?? [];
            $img_id   = $img_data['image_source']['id'] ?? '';
            if ($img_id) {
              echo wp_get_attachment_image($img_id, 'large', false, [
                'class' => 'absolute inset-0 w-full h-full object-cover'
              ]);
            } else {
              echo '<img src="https://civshows.slantstaging.com.au/wp-content/uploads/2026/01/06.jpg" alt="Event Atmosphere" class="absolute inset-0 w-full h-full object-cover">';
            }
            ?>
          </div>
        </div>

      </div>

      <!-- Events List (Placeholder/Hardcoded for now as per design) -->
      <div class="space-y-6 relative z-30">

        <div class="bg-white border border-gray-200 rounded-lg p-4 md:p-6 flex flex-col md:flex-row gap-6 md:gap-8 shadow-sm hover:shadow-md transition-shadow">
          <div class="w-full md:w-1/3 shrink-0 relative rounded-md overflow-hidden aspect-video md:aspect-auto">
            <img src="https://civshows.slantstaging.com.au/wp-content/uploads/2026/01/04.jpg" alt="Event Image" class="w-full h-full object-cover">
            <div class="absolute bottom-0 left-4 bg-white text-civ-blue-600 font-bold text-[10px] sm:text-xs uppercase py-2 px-4 rounded-t-md">
              18 October 2025: 3:00 PM
            </div>
          </div>

          <div class="flex flex-col justify-center w-full">
            <h3 class="text-xl xl:text-3xl font-bold text-black mb-3 leading-tight">
              Lorem Ipsum is simply dummy text of the printing and typesetting industry.
            </h3>
            <p class="text-gray-600 text-sm leading-relaxed mb-6">
              Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            </p>

            <div class="flex flex-wrap gap-3">
              <button class="bg-civ-orange-500 hover:bg-civ-orange-600 text-white font-bold uppercase text-xs py-2 px-6 rounded-sm transition-colors shadow-sm">
                Register
              </button>
              <button class="bg-civ-orange-500 hover:bg-civ-orange-600 text-white font-bold uppercase text-xs py-2 px-6 rounded-sm transition-colors flex items-center gap-2 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Add iCal or Outlook
              </button>
            </div>
          </div>
        </div>

        <!-- Additional placeholder items... -->
        <div class="bg-white border border-gray-200 rounded-lg p-4 md:p-6 flex flex-col md:flex-row gap-6 md:gap-8 shadow-sm hover:shadow-md transition-shadow">
          <div class="w-full md:w-1/3 shrink-0 relative rounded-md overflow-hidden aspect-video md:aspect-auto">
            <img src="https://civshows.slantstaging.com.au/wp-content/uploads/2026/01/03-scaled.jpg" alt="Event Image" class="w-full h-full object-cover">
            <div class="absolute bottom-0 left-4 bg-white text-civ-blue-600 font-bold text-[10px] sm:text-xs uppercase py-2 px-4 rounded-t-md">
              18 October 2025: 5:00 PM
            </div>
          </div>

          <div class="flex flex-col justify-center w-full">
            <h3 class="text-xl xl:text-3xl font-bold text-black mb-3 leading-tight">
              Lorem Ipsum is simply dummy text of the printing and typesetting industry.
            </h3>
            <p class="text-gray-600 text-sm leading-relaxed mb-6">
              Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            </p>

            <div class="flex flex-wrap gap-3">
              <button class="bg-civ-orange-500 hover:bg-civ-orange-600 text-white font-bold uppercase text-xs py-2 px-6 rounded-sm transition-colors flex items-center gap-2 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Add iCal or Outlook
              </button>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>
</section>