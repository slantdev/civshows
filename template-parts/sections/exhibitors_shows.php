<?php

/**
 * Section: Exhibitors (Shows)
 * 
 * Modular section displaying an exhibitor grid with advanced filtering.
 * Integrated with global section settings and dynamic intro content.
 */

// Section Settings (Background, Padding etc)
include get_template_directory() . '/template-parts/global/section-settings.php';

$section_id_attr = $section_id ? 'id="' . esc_attr($section_id) . '"' : '';
$section_class   = 'section-exhibitors-shows-' . uniqid();

// Data Extraction
// $ex_comp    = get_sub_field('exhibitors_shows');
$exhibitors = get_sub_field('exhibitors');
$intro      = $exhibitors['intro'] ?? [];
$ex_image   = $intro['image'] ?? [];

//preint_r($exhibitors);

// Exhibitors Query (Initial Load)
$args = array(
  'post_type'      => 'exhibitors',
  'posts_per_page' => 12,
  'orderby'        => 'title',
  'order'          => 'ASC',
  'post_status'    => 'publish',
);
$exhibitors_query = new WP_Query($args);

// Fetch Categories for Filter (Top Level Only)
$parent_terms = get_terms([
  'taxonomy'   => 'exhibitor-category',
  'parent'     => 0,
  'hide_empty' => true,
]);

?>
<script>
  window.civAjax = {
    url: "<?php echo admin_url('admin-ajax.php'); ?>",
    nonce: "<?php echo wp_create_nonce('civ_exhibitors_nonce'); ?>"
  };
</script>

<section <?php echo $section_id_attr; ?> class="<?php echo esc_attr($section_class); ?> section-wrapper relative" style="<?php echo esc_attr($section_style); ?>">

  <?php echo $section_overlay_markup; ?>

  <div class="section-container relative z-10 <?php echo esc_attr($section_container_class); ?>">
    <div class="container mx-auto px-4">

      <!-- Intro Area -->
      <div class="flex flex-col lg:flex-row items-center justify-between gap-12 mb-16 lg:mb-24">

        <div class="w-full lg:w-1/2">
          <?php if (!empty($intro['title'])) : ?>
            <div class="mb-6">
              <?php get_template_part('template-parts/components/heading', null, ['field' => $intro['title']]); ?>
            </div>
          <?php endif; ?>

          <?php if (!empty($intro['description'])) : ?>
            <div class="mb-8">
              <?php get_template_part('template-parts/components/content_editor', null, ['field' => $intro['description']]); ?>
            </div>
          <?php endif; ?>

          <?php if (!empty($intro['buttons'])) : ?>
            <div class="flex flex-wrap gap-4">
              <?php get_template_part('template-parts/components/buttons', null, ['field' => $intro['buttons']]); ?>
            </div>
          <?php endif; ?>
        </div>

        <?php
        $img_data = $ex_image['image'] ?? [];
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

      <!-- Filter Controls -->
      <div class="bg-gray-50 p-6 md:p-8 rounded-lg border border-gray-200 shadow-sm mb-12 z-30 relative">

        <div class="flex flex-col lg:flex-row gap-6 items-end lg:items-center border-b border-gray-200 pb-8 mb-6">

          <div class="w-full lg:w-5/12 space-y-2">
            <label class="font-bold text-sm uppercase text-black block mb-1">Find By Category</label>
            <div class="relative">
              <select id="filter-category" class="w-full bg-white border border-gray-300 text-gray-700 text-sm rounded px-4 py-3 appearance-none focus:outline-none focus:border-civ-orange-500 cursor-pointer">
                <option value="">All Categories</option>
                <?php if (!is_wp_error($parent_terms)) : ?>
                  <?php foreach ($parent_terms as $term) : ?>
                    <option value="<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                </svg>
              </div>
            </div>
          </div>

          <div class="hidden lg:flex shrink-0 items-center justify-center font-bold text-gray-400 text-sm uppercase px-2 h-12 mt-6">
            &mdash; OR &mdash;
          </div>

          <div class="w-full lg:w-7/12 space-y-2">
            <label class="font-bold text-sm uppercase text-black block mb-1">Find By Keyword</label>
            <div class="flex">
              <input type="text" id="filter-search" placeholder="Search by Exhibitor Name" class="w-full bg-white border border-gray-300 border-r-0 rounded-l px-4 py-3 text-sm focus:outline-none focus:border-civ-orange-500">
              <button id="btn-search" class="bg-civ-orange-500 hover:bg-civ-orange-600 text-white font-bold uppercase text-sm px-6 rounded-r transition-colors">
                Search
              </button>
            </div>
          </div>

        </div>

        <div class="flex flex-col sm:flex-row gap-6 md:gap-12">

          <label class="flex items-center gap-3 cursor-pointer group">
            <div class="relative">
              <input type="checkbox" id="filter-new" class="sr-only peer">
              <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-civ-orange-500"></div>
            </div>
            <span class="text-sm font-semibold text-black group-hover:text-civ-orange-500 transition-colors">New To The Show</span>
          </label>

          <label class="flex items-center gap-3 cursor-pointer group">
            <div class="relative">
              <input type="checkbox" id="filter-special" class="sr-only peer">
              <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-civ-orange-500"></div>
            </div>
            <span class="text-sm font-semibold text-black group-hover:text-civ-orange-500 transition-colors">Has show specials!</span>
          </label>

          <button id="btn-reset-filters" class="text-sm font-semibold text-gray-500 hover:text-civ-orange-500 transition-colors uppercase ml-auto cursor-pointer hidden">
            Reset Filters
          </button>

        </div>
      </div>

      <!-- Results Grid -->
      <div id="exhibitors-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
        <?php if ($exhibitors_query->have_posts()) : ?>
          <?php while ($exhibitors_query->have_posts()) : $exhibitors_query->the_post(); ?>
            <?php get_template_part('template-parts/shows/components/card', 'exhibitor'); ?>
          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
        <?php else : ?>
          <div class="col-span-full text-center py-12 text-gray-500">
            <p class="text-xl">No exhibitors found.</p>
          </div>
        <?php endif; ?>
      </div>

      <!-- Load More -->
      <?php if ($exhibitors_query->max_num_pages > 1) : ?>
        <div class="flex justify-center">
          <button id="load-more-exhibitors"
            data-page="1"
            data-max-pages="<?php echo esc_attr($exhibitors_query->max_num_pages); ?>"
            class="bg-civ-orange-500 hover:bg-civ-orange-600 text-white font-bold uppercase text-sm py-3 px-12 rounded-sm cursor-pointer transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
            Load More
          </button>
        </div>
      <?php endif; ?>

    </div>
  </div>
</section>