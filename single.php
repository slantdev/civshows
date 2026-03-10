<?php

/**
 * The template for displaying all single posts
 */

get_header();

// Setup Background properties from Featured Image
$bg_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
$has_bg = !empty($bg_url);
$bg_overlay = 'rgba(0,0,0,0.6)'; // Darken image for white text readability

// Setup typography and colors to match page-header.php
$title_color = '#ffffff';
$subtitle_color = '#cbd5e1'; // tailwind slate-300
$breadcrumbs_text_color = '#ffffff';
$separator_color = '#ffffff';

// Get Post Categories for breadcrumb linkage
$categories = get_the_category();

?>


<main id="primary" class="site-main">

  <!-- HERO HEADER SECTION -->
  <section class="w-full relative bg-cover bg-no-repeat <?php echo $has_bg ? '' : 'bg-civ-blue-900'; ?>">

    <?php if ($has_bg): ?>
      <!-- Background Image & Overlay -->
      <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-cover bg-no-repeat bg-center" style="background-image: url('<?php echo esc_url($bg_url); ?>');">
        </div>
        <!-- Overlay -->
        <div class="absolute inset-0" style="background-color: <?php echo esc_attr($bg_overlay); ?>;"></div>
      </div>
    <?php endif; ?>

    <div class="max-w-3xl mx-auto px-4 md:px-6 lg:px-8 pt-40 pb-6 md:pt-52 xl:pb-16 xl:px-8 xl:pt-72 relative z-10 w-full">

      <div class="flex flex-col items-start gap-6">
        <div class="w-full">

          <h1 class="text-4xl md:text-5xl 2xl:text-6xl font-semibold leading-tight mb-4" style="color: <?php echo esc_attr($title_color); ?>;">
            <?php the_title(); ?>
          </h1>

          <div class="text-lg md:text-xl 2xl:text-2xl font-medium" style="color: <?php echo esc_attr($subtitle_color); ?>;">
            <?php echo get_the_date(); ?>
          </div>

        </div>
      </div>

      <!-- BREADCRUMBS -->
      <div class="flex">
        <div class="w-full">
          <div class="h-0.5 w-full bg-white/40 my-6" style="background-color: <?php echo esc_attr($separator_color); ?>; opacity: 0.4;"></div>

          <nav class="text-sm md:text-base font-medium opacity-90" style="color: <?php echo esc_attr($breadcrumbs_text_color); ?>;">
            <ul class="flex items-center space-x-2 flex-wrap gap-y-2">
              <li><a href="<?php echo home_url(); ?>" class="hover:underline">Home</a></li>
              <li>/</li>
              <li><a href="<?php echo get_post_type_archive_link('post'); ?>" class="hover:underline">Blog</a></li>
              <li>/</li>

              <?php if (!empty($categories)): ?>
                <li><a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>" class="hover:underline"><?php echo esc_html($categories[0]->name); ?></a></li>
                <li>/</li>
              <?php endif; ?>

              <li><span class="font-bold"><?php echo get_the_title(); ?></span></li>
            </ul>
          </nav>
        </div>
      </div>

    </div>

  </section>

  <!-- CONTENT SECTION -->
  <section class="max-w-3xl mx-auto px-4 md:px-6 lg:px-8 py-6 md:py-12 xl:py-16">
    <?php
    while (have_posts()) :
      the_post();
    ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <!-- Post Content utilizing Tailwind Typography -->
        <div class="prose prose-lg md:prose-xl max-w-none text-gray-700 prose-a:text-civ-orange-500 hover:prose-a:text-civ-orange-600 prose-headings:text-civ-blue-900 prose-img:rounded-xl">
          <?php
          the_content();
          ?>
        </div>

        <!-- Post Tags (Optional) -->
        <?php
        $tags_list = get_the_tag_list('<span class="inline-flex gap-2">', ' ', '</span>');
        if ($tags_list) {
          printf('<div class="mt-12 pt-8 border-t border-gray-200">
                    <span class="font-bold text-civ-blue-900 mr-2">Tags:</span> %1$s
                  </div>', $tags_list); // WPCS: XSS OK.
        }
        ?>

      </article>
    <?php
    endwhile; // End of the loop.
    ?>
  </section>

</main>

<?php
get_footer();
