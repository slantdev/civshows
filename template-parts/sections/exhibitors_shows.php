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
$section_class = 'section-exhibitors-shows-' . uniqid();

// Data Extraction
// $ex_comp    = get_sub_field('exhibitors_shows');
$exhibitors = get_sub_field('exhibitors');
$intro = $exhibitors['intro'] ?? [];
$ex_image = $intro['image'] ?? [];
$list_settings = $exhibitors['exhibitor_list_settings'] ?? [];
$selected_shows = $list_settings['exhibitor_shows'] ?? [];

//preint_r($exhibitors);

// Exhibitors Query (Initial Load)
$requested_cat = isset($_GET['cat']) ? sanitize_text_field($_GET['cat']) : '';

$args = array(
  'post_type' => 'exhibitors',
  'posts_per_page' => 40,
  'orderby' => 'title',
  'order' => 'ASC',
  'post_status' => 'publish',
);

if ($requested_cat) {
  $args['tax_query'] = array(
    array(
      'taxonomy' => 'exhibitor-category',
      'field'    => 'slug',
      'terms'    => $requested_cat,
    ),
  );
}

$shows_ids = [];
if (!empty($selected_shows)) {
  $meta_query = array('relation' => 'OR');
  foreach ($selected_shows as $show) {
    $shows_ids[] = $show->ID;
    // ACF relationship fields store data as serialized arrays, so we use LIKE
    $meta_query[] = array(
      'key' => 'exhibitor_shows',
      'value' => '"' . $show->ID . '"',
      'compare' => 'LIKE'
    );
  }
  $args['meta_query'] = $meta_query;
}
$shows_json = esc_attr(json_encode($shows_ids));

// Find active letters globally for this section
global $wpdb;
$active_letters = [];
$has_numbers = false;

$all_args = $args;
$all_args['posts_per_page'] = -1;
$all_args['fields'] = 'ids';
$all_ids = get_posts($all_args);

if (!empty($all_ids)) {
  $id_list = implode(',', array_map('intval', $all_ids));
  $sql = "SELECT DISTINCT UPPER(LEFT(post_title, 1)) as letter FROM {$wpdb->posts} WHERE ID IN ($id_list)";
  $letters_query = $wpdb->get_results($sql);
  foreach ($letters_query as $row) {
    if (is_numeric($row->letter)) {
      $has_numbers = true;
    } else {
      if (ctype_alpha($row->letter)) {
        $active_letters[] = $row->letter;
      }
    }
  }
}

$exhibitors_query = new WP_Query($args);

// Fetch Categories for Filter (Top Level Only)
$parent_terms = get_terms([
  'taxonomy' => 'exhibitor-category',
  'parent' => 0,
  'hide_empty' => true,
]);

?>

<section <?php echo $section_id_attr; ?> class="
  civ-exhibitors-shows-section <?php echo esc_attr($section_class); ?> section-wrapper relative overflow-x-hidden" style="
  <?php echo esc_attr($section_style); ?>" data-scroll-on-load="<?php echo $requested_cat ? 'true' : 'false'; ?>">

  <?php echo $section_overlay_markup; ?>

  <div class="civ-section-container section-container relative z-10 <?php echo esc_attr($section_container_class); ?>">
    <div class="container mx-auto px-4">

      <!-- Intro Area -->
      <div class="civ-exhibitors-intro flex flex-col lg:flex-row items-center justify-between gap-12 mb-16 lg:mb-24">

        <div class="civ-exhibitors-content w-full lg:w-1/2">
          <?php if (!empty($intro['title'])): ?>
            <div class="mb-6">
              <?php get_template_part('template-parts/components/heading', null, ['field' => $intro['title']]); ?>
            </div>
          <?php
          endif; ?>

          <?php if (!empty($intro['description'])): ?>
            <div class="mb-8">
              <?php get_template_part('template-parts/components/content_editor', null, ['field' => $intro['description']]); ?>
            </div>
          <?php
          endif; ?>

          <?php if (!empty($intro['buttons'])): ?>
            <div class="flex flex-wrap gap-4">
              <?php get_template_part('template-parts/components/buttons', null, ['field' => $intro['buttons']]); ?>
            </div>
          <?php
          endif; ?>
        </div>

        <?php
        $img_data = $ex_image['image'] ?? [];
        $img_id = $img_data['image_source']['id'] ?? '';
        if ($img_id):
        ?>
          <div class="civ-exhibitors-image w-full lg:w-5/12 flex justify-center lg:justify-end -mb-28 lg:-mb-32">
            <div
              class="w-full max-w-xl aspect-square rounded-full overflow-hidden relative shadow-xl border-8 border-white">
              <?php
              echo wp_get_attachment_image($img_id, 'large', false, [
                'class' => 'absolute inset-0 w-full h-full object-cover'
              ]);
              ?>
            </div>
          </div>
        <?php
        endif; ?>
      </div>

      <!-- Filter Controls -->
      <div class="civ-exhibitors-filters bg-gray-50 p-6 md:p-8 rounded-lg border border-gray-200 shadow-sm mb-12 z-30 relative">

        <div class="civ-filters-top flex flex-col lg:flex-row gap-6 items-end lg:items-center border-b border-gray-200 pb-8 mb-6">

          <div class="civ-filter-category w-full lg:w-5/12 space-y-2">
            <label class="font-bold text-sm uppercase text-black block mb-1">Find By Category</label>
            <div class="relative civ-custom-multiselect" id="filter-category-container">
              <div class="civ-multiselect-header w-full bg-white border border-gray-300 text-gray-700 text-sm rounded px-4 py-3 cursor-pointer flex justify-between items-center focus:border-civ-orange-500 focus:outline-none" tabindex="0">
                <span class="civ-multiselect-label truncate pr-4">All Categories</span>
                <svg class="civ-multiselect-icon fill-current h-4 w-4 text-gray-500 shrink-0 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                </svg>
              </div>
              <div class="civ-multiselect-dropdown absolute top-full left-0 w-full bg-white border border-gray-200 mt-2 rounded-md shadow-xl max-h-60 overflow-y-auto hidden z-40 transform origin-top transition-all">
                <div class="p-2 space-y-1">
                  <?php if (!is_wp_error($parent_terms)): ?>
                    <?php foreach ($parent_terms as $term): 
                      $is_checked = ($term->slug === $requested_cat) ? 'checked' : '';
                    ?>
                      <label class="flex items-center px-3 py-2.5 cursor-pointer hover:bg-gray-50 rounded-md select-none group transition-colors">
                        <input type="checkbox" value="<?php echo esc_attr($term->slug); ?>" <?php echo $is_checked; ?> class="civ-multiselect-checkbox w-4 h-4 text-civ-orange-500 border-gray-300 rounded cursor-pointer focus:ring-civ-orange-500 focus:ring-offset-0">
                        <span class="ml-3 text-sm text-gray-700 group-hover:text-black font-medium"><?php echo esc_html($term->name); ?></span>
                      </label>
                    <?php
                    endforeach; ?>
                  <?php
                  endif; ?>
                </div>
              </div>
            </div>
          </div>

          <div
            class="civ-filter-divider hidden lg:flex shrink-0 items-center justify-center font-bold text-gray-400 text-sm uppercase px-2 h-12 mt-6">
            &mdash; OR &mdash;
          </div>

          <div class="civ-filter-search w-full lg:w-7/12 space-y-2">
            <label class="font-bold text-sm uppercase text-black block mb-1">Find By Keyword</label>
            <div class="flex">
              <input type="text" id="filter-search" placeholder="Search by Exhibitor Name"
                class="civ-search-input w-full bg-white border border-gray-300 border-r-0 rounded-l px-4 py-3 text-sm focus:outline-none focus:border-civ-orange-500">
              <button id="btn-search"
                class="civ-search-btn bg-civ-orange-500 hover:bg-civ-orange-600 text-white font-bold uppercase text-sm px-6 rounded-r transition-colors">
                Search
              </button>
            </div>
          </div>

        </div>

        <div class="civ-filters-bottom flex flex-col sm:flex-row gap-6 md:gap-12">

          <label class="civ-filter-toggle flex items-center gap-3 cursor-pointer group">
            <div class="relative">
              <input type="checkbox" id="filter-new" class="sr-only peer">
              <div
                class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-civ-orange-500">
              </div>
            </div>
            <span class="text-sm font-semibold text-black group-hover:text-civ-orange-500 transition-colors">New to the
              show</span>
          </label>

          <label class="civ-filter-toggle flex items-center gap-3 cursor-pointer group">
            <div class="relative">
              <input type="checkbox" id="filter-special" class="sr-only peer">
              <div
                class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-civ-orange-500">
              </div>
            </div>
            <span class="text-sm font-semibold text-black group-hover:text-civ-orange-500 transition-colors">Has show
              specials!</span>
          </label>

          <label class="civ-filter-toggle flex items-center gap-3 cursor-pointer group">
            <div class="relative">
              <input type="checkbox" id="filter-product-release" class="sr-only peer">
              <div
                class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-civ-orange-500">
              </div>
            </div>
            <span class="text-sm font-semibold text-black group-hover:text-civ-orange-500 transition-colors">New product release at the show</span>
          </label>

          <button id="btn-reset-filters"
            class="civ-reset-filters-btn text-sm font-semibold text-gray-500 hover:text-civ-orange-500 transition-colors uppercase ml-auto cursor-pointer hidden">
            Reset Filters
          </button>

        </div>

        <!-- Alphabet Filter Ribbon -->
        <div class="civ-alphabet-filter mt-8 pt-6 border-t border-gray-200">
          <div class="relative flex items-center group w-full">

            <!-- Left Arrow -->
            <button type="button" class="civ-alpha-scroll-left hidden md:flex absolute left-0 md:left-1 z-20 w-6 h-6 md:w-8 md:h-8 items-center justify-center bg-white shadow-sm border border-gray-200 rounded-full text-gray-600 hover:text-white hover:bg-civ-orange-500 hover:border-civ-orange-500 hover:shadow-md transition-all duration-200 cursor-pointer disabled:opacity-40 disabled:pointer-events-none disabled:shadow-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
              </svg>
            </button>

            <!-- Scrollable Track -->
            <div id="civ-alpha-track" class="overflow-x-auto w-full mx-8 md:mx-12 civ-custom-scrollbar scroll-smooth flex-1 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
              <ul class="flex gap-1 md:gap-2 min-w-max items-center uppercase text-sm font-bold" id="filter-alphabet">
                <?php
                $is_disabled = !$has_numbers;
                $btn_classes = $is_disabled ? 'opacity-40 cursor-not-allowed bg-gray-100 text-gray-400' : 'cursor-pointer hover:bg-civ-orange-500 hover:text-white hover:border-civ-orange-500 transition-colors bg-white text-gray-600';
                ?>
                <li>
                  <button type="button" data-letter="#" class="civ-alpha-btn w-10 h-10 flex items-center justify-center rounded border border-gray-200 <?php echo esc_attr($btn_classes); ?>" <?php echo $is_disabled ? 'disabled' : ''; ?>>#</button>
                </li>
                <?php foreach (range('A', 'Z') as $letter):
                  $is_disabled = !in_array($letter, $active_letters);
                  $btn_classes = $is_disabled ? 'opacity-40 cursor-not-allowed bg-gray-100 text-gray-400' : 'cursor-pointer hover:bg-civ-orange-500 hover:text-white hover:border-civ-orange-500 transition-colors bg-white text-gray-600';
                ?>
                  <li>
                    <button type="button" data-letter="<?php echo esc_attr($letter); ?>" class="civ-alpha-btn w-10 h-10 flex items-center justify-center rounded border border-gray-200 <?php echo esc_attr($btn_classes); ?>" <?php echo $is_disabled ? 'disabled' : ''; ?>><?php echo esc_html($letter); ?></button>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>

            <!-- Right Arrow -->
            <button type="button" class="civ-alpha-scroll-right hidden md:flex absolute right-0 md:right-1 z-20 w-6 h-6 md:w-8 md:h-8 items-center justify-center bg-white shadow-sm border border-gray-200 rounded-full text-gray-600 hover:text-white hover:bg-civ-orange-500 hover:border-civ-orange-500 hover:shadow-md transition-all duration-200 cursor-pointer disabled:opacity-40 disabled:pointer-events-none disabled:shadow-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
              </svg>
            </button>

          </div>
        </div>

      </div>

      <!-- Results Grid -->
      <div id="exhibitors-grid" class="civ-exhibitors-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-16"
        data-shows="<?php echo $shows_json; ?>">
        <?php if ($exhibitors_query->have_posts()): ?>
          <?php while ($exhibitors_query->have_posts()):
            $exhibitors_query->the_post(); ?>
            <?php get_template_part('template-parts/shows/card', 'exhibitor'); ?>
          <?php
          endwhile; ?>
          <?php wp_reset_postdata(); ?>
        <?php
        else: ?>
          <div class="col-span-full text-center py-12 text-gray-500">
            <p class="text-xl">No exhibitors found.</p>
          </div>
        <?php
        endif; ?>
      </div>

      <!-- Load More -->
      <?php if ($exhibitors_query->max_num_pages > 1): ?>
        <div class="civ-load-more-wrapper flex justify-center">
          <button id="load-more-exhibitors" data-page="1"
            data-max-pages="<?php echo esc_attr($exhibitors_query->max_num_pages); ?>"
            class="civ-load-more-btn bg-civ-orange-500 hover:bg-civ-orange-600 text-white font-bold uppercase text-sm py-3 px-12 rounded-sm cursor-pointer transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
            Load More
          </button>
        </div>
      <?php
      endif; ?>

    </div>
  </div>
</section>