<?php

/**
 * The template for displaying all single posts of the 'shows' custom post type.
 *
 * @package CIV Shows
 */

get_header();
?>

<main id="primary" class="site-main grow">

  <?php
  while (have_posts()) :
    the_post();

    get_template_part('template-parts/shows/components/page-header');

    // Render the Page Builder
    civ_render_page_builder();

    //get_template_part('template-parts/shows/content', 'single');

    // Fallback for default content editor
    // Only show if Page Builder is empty (optional logic, but good for safety)
    if (! have_rows('section_builder') && get_the_content()) {
      get_template_part('template-parts/shows/content', 'single');
    }

  endwhile; // End of the loop.
  ?>

</main><!-- #main -->

<?php
get_footer();
