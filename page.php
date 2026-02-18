<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 */

get_header();
?>

<main id="primary" class="site-main grow">

  <?php
  while (have_posts()) :
    the_post();

    get_template_part('template-parts/global/page-header');

    // Render the Page Builder
    civ_render_page_builder();

    // Fallback for default content editor
    // Only show if Page Builder is empty (optional logic, but good for safety)
    if (! have_rows('section_builder') && get_the_content()) {
  ?>
      <div class="container mx-auto px-4 py-12 prose lg:prose-xl">
        <h1><?php the_title(); ?></h1>
        <?php the_content(); ?>
      </div>
  <?php
    }

  endwhile; // End of the loop.
  ?>

</main><!-- #main -->

<?php
get_footer();
