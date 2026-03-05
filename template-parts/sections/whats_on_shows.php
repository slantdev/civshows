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
$whats_on   = get_sub_field('whats_on');
$intro      = $whats_on['intro'] ?? [];
$wo_image   = $intro['image'] ?? [];

//preint_r($whats_on);

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
              <?php get_template_part('template-parts/components/content_editor', null, ['field' => $intro['description']]); ?>
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

        <?php
        $img_data = $wo_image['image'] ?? [];
        $img_id   = $img_data['image_source']['id'] ?? '';
        if ($img_id) :
        ?>
          <div class="w-full lg:w-5/12 flex justify-center lg:justify-end -mb-28 lg:-mb-32">
            <div class="w-full max-w-xl aspect-square rounded-full overflow-hidden relative shadow-xl border-8 border-white">
              <?php
              echo wp_get_attachment_image($img_id, 'large', false, [
                'class' => 'absolute inset-0 w-full h-full object-cover'
              ]);
              ?>
            </div>
          </div>
        <?php endif; ?>

      </div>

      <!-- Events List -->
      <div class="events-list-wrapper mt-8 relative z-30">
        <?php
        $shows_settings = $whats_on['shows_settings'] ?? [];
        $event_category = $shows_settings['event_category'] ?? '';

        $category_slug = '';
        if (!empty($event_category)) {
            if (is_object($event_category)) {
                $category_slug = $event_category->slug ?? '';
            } elseif (is_array($event_category) && !empty($event_category['slug'])) {
                $category_slug = $event_category['slug'];
            } elseif (is_numeric($event_category)) {
                $term = get_term($event_category);
                if ($term && !is_wp_error($term)) {
                    $category_slug = $term->slug;
                }
            } elseif (is_string($event_category)) {
                $category_slug = $event_category;
            }
        }

        if (!empty($category_slug)) {
            // Replaced [civ_shows] with [civ_events] since that was the built shortcode. Let me know if you strictly meant "shows"!
            echo do_shortcode('[civ_events category="' . esc_attr($category_slug) . '"]');
        } else {
            // Fallback shortcode if no category is picked
            echo do_shortcode('[civ_events]');
        }
        ?>
      </div>

    </div>
  </div>
</section>