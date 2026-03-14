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

    get_template_part('template-parts/global/page-header-shows');

    // Render the Page Builder
    civ_render_page_builder();

  endwhile; // End of the loop.
  ?>

</main><!-- #main -->

<?php
get_footer();
