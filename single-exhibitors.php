<?php

/**
 * The template for displaying all single exhibitors
 */

get_header();

// Setup Background properties from Featured Image (Optional for Exhibitors, fallback to solid)
$bg_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
$has_bg = !empty($bg_url);
$bg_overlay = 'rgba(0,0,0,0.6)'; // Darken image for white text readability

// Setup typography and colors
$title_color = '#ffffff';

// Exhibitor ACF Fields
$exhibitor_contact = get_field('exhibitor_contact');
$phone = $exhibitor_contact['phone_number'] ?? '';
$website = $exhibitor_contact['website_link'] ?? '';
$instagram = $exhibitor_contact['instagram_link'] ?? '';
$facebook = $exhibitor_contact['facebook_link'] ?? '';

$exhibitor_identity = get_field('exhibitor_identity');
$logo_array = $exhibitor_identity['exhibitor_logo'] ?? [];

$exhibitor_description = get_field('exhibitor_description');
$headline = $exhibitor_description['exhibitor_headline'] ?? '';
$content = $exhibitor_description['exhibitor_bio'] ?? '';

$exhibitor_tags = get_field('exhibitor_tags');

$terms = get_the_terms(get_the_ID(), 'exhibitor-category');
$categories = '';
if ($terms && !is_wp_error($terms)) {
  $cat_names = wp_list_pluck($terms, 'name');
  $categories = implode(', ', $cat_names);
}

?>

<main id="primary" class="site-main">

  <!-- HERO HEADER SECTION -->
  <section class="w-full relative bg-cover bg-no-repeat bg-civ-blue-900">

    <?php if ($has_bg): ?>
      <!-- Background Image & Overlay -->
      <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-cover bg-no-repeat bg-center" style="background-image: url('<?php echo esc_url($bg_url); ?>');">
        </div>
        <!-- Overlay -->
        <div class="absolute inset-0" style="background-color: <?php echo esc_attr($bg_overlay); ?>;"></div>
      </div>
    <?php endif; ?>

    <div class="max-w-3xl mx-auto px-4 md:px-6 lg:px-8 pt-40 pb-12 md:pt-52 xl:pb-24 xl:px-8 xl:pt-72 relative z-10 w-full text-center">
      <div class="flex flex-col items-center justify-center gap-6">
        <h1 class="text-4xl md:text-5xl 2xl:text-6xl font-bold leading-tight" style="color: <?php echo esc_attr($title_color); ?>;">
          <?php the_title(); ?>
        </h1>
        <?php if ($categories) : ?>
          <p class="text-sm lg:text-lg text-white/80 font-semibold uppercase tracking-widest mt-2"><?php echo esc_html($categories); ?></p>
        <?php endif; ?>
      </div>
    </div>

  </section>

  <!-- CONTENT SECTION -->
  <section class="bg-gray-50">
    <div class="container max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-12 md:py-20 xl:py-24">

      <div class="flex flex-col md:flex-row gap-6 md:gap-8 lg:gap-10 xl:gap-16">

        <!-- Left Column (1/3 Width): Logo & Quick Contact -->
        <div class="w-full md:w-1/3 shrink-0 flex flex-col">

          <!-- Logo Container -->
          <div class="aspect-square bg-white border border-gray-200 rounded-xl flex items-center justify-center shadow-md overflow-clip">
            <?php if ($logo_array && !empty($logo_array['url'])) : ?>
              <img src="<?php echo esc_url($logo_array['url']); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="w-full h-full object-cover">
            <?php else : ?>
              <div class="w-full h-full bg-gray-400 flex items-center justify-center text-white/70">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              </div>
            <?php endif; ?>
          </div>

        </div>

        <!-- Right Column (2/3 Width): Details & Bio -->
        <div class="w-full md:w-2/3 lg:py-6">
          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <!-- Headline -->
            <?php if ($headline) : ?>
              <h2 class="text-2xl md:text-3xl text-gray-900 font-bold mb-8 leading-tight py-2">
                <?php echo esc_html($headline); ?>
              </h2>
            <?php endif; ?>

            <!-- Bio -->
            <div class="prose md:prose-lg lg:prose-xl max-w-none text-gray-700 prose-a:text-civ-orange-500 hover:prose-a:text-civ-orange-600 prose-headings:text-civ-blue-900">
              <?php if ($content) : ?>
                <?php echo wp_kses_post($content); ?>
              <?php else: ?>
                <p class="text-gray-500 italic">No description provided for this exhibitor.</p>
              <?php endif; ?>
            </div>

            <!-- Contact Block -->
            <div class="space-y-6 pt-6 lg:pt-8 xl:pt-12">
              <h3 class="text-lg font-bold text-civ-blue-900 border-b border-gray-200 pb-3 mb-4">Contact Information</h3>

              <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 xl:gap-16">
                <?php if ($phone) : ?>
                  <div>
                    <span class="block text-xs uppercase font-bold text-gray-400 tracking-wider mb-1">Phone</span>
                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>" class="text-base font-semibold text-civ-blue-900 hover:text-civ-orange-500 transition-colors"><?php echo esc_html($phone); ?></a>
                  </div>
                <?php endif; ?>

                <?php if ($website) : ?>
                  <div>
                    <span class="block text-xs uppercase font-bold text-gray-400 tracking-wider mb-1">Website</span>
                    <a href="<?php echo esc_url($website); ?>" target="_blank" rel="noopener noreferrer" class="text-base font-semibold text-civ-blue-900 hover:text-civ-orange-500 transition-colors break-all flex items-center">
                      <?php echo esc_html(parse_url($website, PHP_URL_HOST) ?: 'Visit Website'); ?>
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                      </svg>
                    </a>
                  </div>
                <?php endif; ?>

                <?php if ($instagram || $facebook) : ?>
                  <div>
                    <div class="flex gap-4">
                      <?php if ($facebook) : ?>
                        <a href="<?php echo esc_url($facebook); ?>" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-full bg-gray-50 border border-gray-200 flex items-center justify-center text-civ-blue-900 hover:bg-civ-orange-500 hover:border-civ-orange-500 hover:text-white transition-all shadow-sm">
                          <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                          </svg>
                        </a>
                      <?php endif; ?>
                      <?php if ($instagram) : ?>
                        <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-full bg-gray-50 border border-gray-200 flex items-center justify-center text-civ-blue-900 hover:bg-civ-orange-500 hover:border-civ-orange-500 hover:text-white transition-all shadow-sm">
                          <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                          </svg>
                        </a>
                      <?php endif; ?>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
            </div>

          </article>
        </div>

      </div>
    </div>

  </section>

  <!-- GALLERY SLIDER SECTION -->
  <?php
  $gallery_slider = get_field('gallery_slider');
  if (!empty($gallery_slider['media_slider']['media_slider_repeater'])) :
  ?>
    <section class="bg-civ-blue-500">
      <div class="container max-w-5xl mx-auto px-4 md:px-6 lg:px-8 py-12 md:py-20 xl:py-24">
        <?php get_template_part('template-parts/components/media_slider', null, ['field' => $gallery_slider]); ?>
      </div>
    </section>
  <?php endif; ?>

</main>

<?php
get_footer();
