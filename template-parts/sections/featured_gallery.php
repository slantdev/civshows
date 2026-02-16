<?php

/**
 * Section: Featured Gallery
 * 
 * Dynamically displays featured galleries selected in the Page Builder.
 * Each card opens a Fancybox lightbox containing all items in the gallery.
 */

$field = $args['field'] ?? '';
$class = $args['class'] ?? '';

// Getting group data
$featured_comp = is_array($field) ? $field : get_sub_field($field ?: 'featured_gallery');

if (!$featured_comp) return;

// Extracting intro and gallery relationship
$intro   = $featured_comp['intro'] ?? [];
$gallery = $featured_comp['gallery'] ?? [];

if (empty($gallery)) return;

// Generate stable IDs for separate galleries
static $section_gallery_count = 0;
$section_gallery_count++;
$gallery_id_prefix = 'featured-gallery-' . get_the_ID() . '-' . $section_gallery_count;

// Section Settings (Background, Padding etc)
include get_template_directory() . '/template-parts/global/section-settings.php';

$section_id_attr = $section_id ? 'id="' . esc_attr($section_id) . '"' : '';
$section_class = 'section-featured-gallery-' . uniqid();

?>
<section <?php echo $section_id_attr; ?> class="<?php echo esc_attr($section_class); ?> section-wrapper relative" style="<?php echo esc_attr($section_style); ?>">

  <?php echo $section_overlay_markup; ?>

  <div class="section-container relative z-10 <?php echo esc_attr($section_container_class); ?>">
    <div class="container mx-auto px-4 max-w-7xl">

      <?php if (!empty($intro['title'])) : ?>
        <div class="mb-10">
          <?php get_template_part('template-parts/components/heading', null, [
            'field' => $intro['title'],
            'class' => 'text-civ-blue-900'
          ]); ?>
        </div>
      <?php endif; ?>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-18">

      <?php foreach ($gallery as $index => $post_obj) :
        $post_id = $post_obj->ID;
        $settings = get_field('gallery_settings', $post_id);
        if (!$settings) continue;

        $type      = $settings['gallery_type'] ?? 'image';
        $is_feat   = $settings['is_featured'] ?? false;
        $feat_data = $settings['featured_content'] ?? [];
        $shows     = $settings['exhibitor_shows'] ?? [];

        // Card Labels
        $card_title = $is_feat && !empty($feat_data['featured_title']) ? $feat_data['featured_title'] : get_the_title($post_id);
        $card_desc  = $is_feat && !empty($feat_data['featured_description']) ? $feat_data['featured_description'] : '';
        $card_cta   = $is_feat ? ($feat_data['cta_button'] ?? []) : [];

        // Show Label
        $show_label = '';
        if (!empty($shows)) {
          $primary_show = is_array($shows) ? $shows[0] : $shows;
          $show_title = is_object($primary_show) ? $primary_show->post_title : get_the_title($primary_show);
          $show_label = 'Featured Next Show -<br>' . $show_title;
        }

        // Media Collection
        $media_items = [];
        if ($type === 'video') {
          $videos = $settings['video_gallery'] ?? [];
          foreach ($videos as $v) {
            $v_data = $v['video'] ?? [];
            $embed = $v_data['external_or_self_hosted'] === 'external' ? ($v_data['embed_external_video'] ?? '') : ($v_data['self_hosted_video'] ?? '');
            
            // Extract URL for Fancybox
            preg_match('/src="([^"]+)"/', $embed, $match);
            $v_url = $match[1] ?? '';
            
            $v_info = civ_get_video_data($v_url);
            $media_items[] = [
              'url'       => $v_url,
              'thumb'     => $v_info['thumbnail'] ?? '',
              'fallback'  => $v_info['fallback'] ?? '',
              'title'     => $v['title'] ?? '',
              'type'      => 'video'
            ];
          }
        } else {
          $images = $settings['image_gallery'] ?? [];
          foreach ($images as $img) {
            $media_items[] = [
              'url'   => $img['url'],
              'thumb' => $img['sizes']['large'],
              'title' => $img['title'],
              'type'  => 'image'
            ];
          }
        }

        if (empty($media_items)) continue;

        $main_item = $media_items[0];
        $fancy_group = $gallery_id_prefix . '-' . $index;
      ?>

        <div class="group flex flex-col">
          <!-- Main Card Trigger -->
          <a href="<?php echo esc_url($main_item['url']); ?>"
            data-fancybox="<?php echo esc_attr($fancy_group); ?>"
            data-caption="<?php echo esc_attr($main_item['title']); ?>"
            class="relative w-full aspect-4/5 rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 block cursor-zoom-in bg-gray-900">

            <!-- Background Image -->
            <img src="<?php echo esc_url($main_item['thumb']); ?>" 
                 alt="<?php echo esc_attr($card_title); ?>" 
                 class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 opacity-80"
                 <?php if (!empty($main_item['fallback'])) echo 'onerror="this.src=\'' . esc_url($main_item['fallback']) . '\'; this.onerror=null;"'; ?>>

            <div class="absolute inset-0 bg-linear-to-t from-black/80 via-black/20 to-transparent"></div>

            <?php if ($show_label) : ?>
              <div class="absolute top-8 left-8 z-10">
                <p class="text-white font-medium uppercase tracking-wide leading-tight drop-shadow-md">
                  <?php echo wp_kses_post($show_label); ?>
                </p>
              </div>
            <?php endif; ?>

            <div class="absolute bottom-8 left-8 right-8 z-10 xl:bottom-20 xl:left-10 xl:right-10">
              <h3 class="text-white text-3xl xl:text-4xl font-medium leading-tight drop-shadow-md w-3/4">
                <?php echo esc_html($card_title); ?>
              </h3>
            </div>

            <div class="absolute bottom-8 right-8 z-10">
              <div class="border-2 border-white rounded-md p-1 opacity-80 group-hover:opacity-100 group-hover:bg-white group-hover:text-civ-blue-900 text-white transition-all">
                <?php if ($main_item['type'] === 'video') : ?>
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                <?php else : ?>
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                  </svg>
                <?php endif; ?>
              </div>
            </div>
          </a>

          <!-- Hidden Gallery Items for Fancybox loop -->
          <div style="display: none;">
            <?php foreach ($media_items as $sub_index => $sub_item) : 
              if ($sub_index === 0) continue; // Skip the main item as it's already the trigger
            ?>
              <a href="<?php echo esc_url($sub_item['url']); ?>"
                data-fancybox="<?php echo esc_attr($fancy_group); ?>"
                data-caption="<?php echo esc_attr($sub_item['title']); ?>">
                <img src="<?php echo esc_url($sub_item['thumb']); ?>" alt="<?php echo esc_attr($sub_item['title']); ?>">
              </a>
            <?php endforeach; ?>
          </div>

          <!-- Card Footer -->
          <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mt-6 gap-4 xl:gap-6">
            <div class="text-civ-blue-900">
              <?php if ($card_desc) : ?>
                <p class="font-medium text-lg leading-tight xl:text-xl"><?php echo esc_html($card_desc); ?></p>
              <?php endif; ?>
            </div>
            
            <?php if (!empty($card_cta['url'])) : ?>
              <a href="<?php echo esc_url($card_cta['url']); ?>" 
                 target="<?php echo esc_attr($card_cta['target'] ?: '_self'); ?>"
                 class="w-full sm:w-auto bg-civ-blue-500 hover:bg-civ-blue-600 text-white font-semibold text-lg uppercase py-4 px-8 rounded transition-colors text-center cursor-pointer whitespace-nowrap">
                <?php echo esc_html($card_cta['title'] ?: 'Learn More'); ?>
              </a>
            <?php endif; ?>
          </div>
        </div>

      <?php endforeach; ?>

    </div>
  </div>
</section>
