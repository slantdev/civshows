<?php
/**
 * The template for displaying all single posts of the 'shows' custom post type.
 *
 * @package CIV Shows
 */

get_header();
?>

<main id="primary" class="site-main">

  <?php
  while ( have_posts() ) :
    the_post();

    get_template_part( 'template-parts/shows/content', 'single' );

  endwhile; // End of the loop.
  ?>

</main><!-- #main -->

<?php
get_footer();
