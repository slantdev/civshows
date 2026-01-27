<?php

/**
 * Component: Exhibitors
 */

// Exhibitors Query
$args = array(
  'post_type'      => 'exhibitors',
  'posts_per_page' => 12,
  'orderby'        => 'title',
  'order'          => 'ASC',
  'post_status'    => 'publish',
);

$exhibitors_query = new WP_Query($args);

// --- Fetch Categories for Filter ---
$parent_terms = get_terms([
  'taxonomy'   => 'exhibitor-category',
  'parent'     => 0,
  'hide_empty' => true,
]);

$categories_data = [];
if (!is_wp_error($parent_terms)) {
  foreach ($parent_terms as $parent) {
    $children = get_terms([
      'taxonomy'   => 'exhibitor-category',
      'parent'     => $parent->term_id,
      'hide_empty' => false, // Show children even if empty for navigation purposes
    ]);

    $child_data = [];
    if (!is_wp_error($children)) {
      foreach ($children as $child) {
        $child_data[] = [
          'id'   => $child->term_id,
          'name' => $child->name,
          'slug' => $child->slug
        ];
      }
    }

    $categories_data[$parent->slug] = [ // Use slug as key for cleaner JS
      'id'       => $parent->term_id,
      'name'     => $parent->name,
      'children' => $child_data
    ];
  }
}

// Pass data to JS via a global variable (quickest for this component context)
// In a larger app, wp_localize_script is better, but this works well for component-specific data.
?>
<script>
  window.exhibitorCategories = <?php echo json_encode($categories_data); ?>;
</script>

<section class="w-full bg-white py-16 md:py-24">
  <div class="container mx-auto px-4">

    <div class="flex flex-col lg:flex-row items-center justify-between gap-12">

      <div class="w-full lg:w-1/2">
        <h2 class="text-3xl md:text-5xl font-semibold text-black mb-6">Exhibitors</h2>
        <p class="text-gray-700 text-sm md:text-base leading-relaxed mb-8 max-w-2xl">
          Explore the biggest brands and the latest products on off at the Melbourne Caravan & Camping Leisurefest. Come along to see the latest in caravans, camper trailers, motorhomes, and 4x4, plus a plethora of camping equipment, gadgets, and accessories bound to excite even the most seasoned outdoor lover!
        </p>
        <button class="bg-civ-orange-500 hover:bg-civ-orange-600 text-white font-bold uppercase text-sm py-3 px-8 rounded-sm transition-colors shadow-sm">
          Download Map
        </button>
      </div>

      <div class="w-full lg:w-5/12 flex justify-center lg:justify-end -mb-28">
        <div class="w-full max-w-xl aspect-square rounded-full overflow-hidden relative">
          <img src="https://civshows.slantstaging.com.au/wp-content/uploads/2026/01/01.jpg" alt="Family at Exhibition" class="absolute inset-0 w-full h-full object-cover">
        </div>
      </div>
    </div>

    <div class="bg-gray-50 p-6 md:p-8 rounded-lg border border-gray-200 shadow-sm mb-12 z-30 relative">

      <div class="flex flex-col lg:flex-row gap-6 items-end lg:items-center border-b border-gray-200 pb-8 mb-6">

        <div class="w-full lg:w-5/12 space-y-2">
          <label class="font-extrabold text-sm uppercase text-black">Find By Category</label>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="relative">
              <select id="filter-category" class="w-full bg-white border border-gray-300 text-gray-700 text-sm rounded px-4 py-3 appearance-none focus:outline-none focus:border-civ-orange-500 cursor-pointer">
                <option value="">All Categories</option>
                <?php foreach ($categories_data as $slug => $cat) : ?>
                  <option value="<?php echo esc_attr($slug); ?>"><?php echo esc_html($cat['name']); ?></option>
                <?php endforeach; ?>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                </svg>
              </div>
            </div>
            <div class="relative">
              <select id="filter-subcategory" class="w-full bg-white border border-gray-300 text-gray-700 text-sm rounded px-4 py-3 appearance-none focus:outline-none focus:border-civ-orange-500 cursor-pointer disabled:opacity-50" disabled>
                <option value="">All Sub Categories</option>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                </svg>
              </div>
            </div>
          </div>
        </div>

        <div class="hidden lg:flex items-center justify-center font-bold text-gray-400 text-sm uppercase px-2 h-12 mt-6">
          &mdash; OR &mdash;
        </div>

        <div class="w-full lg:w-5/12 space-y-2">
          <label class="font-extrabold text-sm uppercase text-black">Find By Keyword</label>
          <div class="flex">
            <input type="text" placeholder="Search by Name, State, Postcode ..." class="w-full bg-white border border-gray-300 border-r-0 rounded-l px-4 py-3 text-sm focus:outline-none focus:border-civ-orange-500">
            <button class="bg-civ-orange-500 hover:bg-civ-orange-600 text-white font-bold uppercase text-sm px-6 rounded-r transition-colors">
              Search
            </button>
          </div>
        </div>

      </div>

      <div class="flex flex-col sm:flex-row gap-6 md:gap-12">

        <label class="flex items-center gap-3 cursor-pointer group">
          <div class="relative">
            <input type="checkbox" class="sr-only peer">
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-civ-orange-500"></div>
          </div>
          <span class="text-sm font-bold text-black group-hover:text-civ-orange-500 transition-colors">New To The Show</span>
        </label>

        <label class="flex items-center gap-3 cursor-pointer group">
          <div class="relative">
            <input type="checkbox" class="sr-only peer">
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-civ-orange-500"></div>
          </div>
          <span class="text-sm font-bold text-black group-hover:text-civ-orange-500 transition-colors">Has show specials!</span>
        </label>

      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">

      <?php if ($exhibitors_query->have_posts()) : ?>
        <?php while ($exhibitors_query->have_posts()) : $exhibitors_query->the_post(); ?>
          <?php
          // Data Retrieval
          $phone = get_field('phone_number');
          $website = get_field('website_link');
          $logo_array = get_field('exhibitor_logo');
          $terms = get_the_terms(get_the_ID(), 'exhibitor-category');
          $categories = '';

          if ($terms && !is_wp_error($terms)) {
            $cat_names = wp_list_pluck($terms, 'name');
            $categories = implode(', ', $cat_names);
          }

          // Truncate content for excerpt-like feel
          $content = get_the_content();
          $excerpt = wp_trim_words($content, 20, '...');
          ?>

          <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden flex flex-col h-full border border-gray-100">
            <div class="h-48 overflow-hidden bg-gray-200 flex items-center justify-center">
              <?php if ($logo_array && !empty($logo_array['url'])) : ?>
                <img src="<?php echo esc_url($logo_array['url']); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-contain transition-transform hover:scale-105 duration-500">
              <?php else : ?>
                <!-- Fallback Image -->
                <div class="w-full h-full bg-gray-500 flex items-center justify-center text-white/50">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
              <?php endif; ?>
            </div>

            <div class="p-6 flex flex-col grow">
              <h3 class="font-extrabold text-lg text-civ-blue-900 mb-1"><?php the_title(); ?></h3>
              <?php if ($categories) : ?>
                <p class="text-sm text-gray-500 italic mb-3"><?php echo esc_html($categories); ?></p>
              <?php endif; ?>

              <p class="text-sm text-gray-600 mb-6 leading-relaxed grow">
                <?php echo esc_html($excerpt); ?>
              </p>

              <div class="space-y-1 mt-auto">
                <?php if ($phone) : ?>
                  <p class="text-sm font-bold text-black">Phone: <span class="font-normal text-gray-600"><?php echo esc_html($phone); ?></span></p>
                <?php endif; ?>

                <?php if ($website) : ?>
                  <p class="text-sm font-bold text-black">
                    Site:
                    <a href="<?php echo esc_url($website); ?>" target="_blank" rel="noopener noreferrer" class="font-normal text-civ-orange-500 hover:underline break-all">
                      <?php echo esc_html(parse_url($website, PHP_URL_HOST) ?: 'Visit Website'); ?>
                    </a>
                  </p>
                <?php endif; ?>
              </div>
            </div>
          </div>

        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
      <?php else : ?>
        <div class="col-span-full text-center py-12 text-gray-500">
          <p class="text-xl">No exhibitors found.</p>
        </div>
      <?php endif; ?>

    </div>

    <div class="flex justify-center">
      <button class="bg-civ-orange-500 hover:bg-civ-orange-600 text-white font-bold uppercase text-sm py-3 px-12 rounded-sm transition-colors shadow-sm">
        Load More
      </button>
    </div>

  </div>
</section>