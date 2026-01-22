<?php get_header(); ?>

<main id="primary" class="site-main container mx-auto p-4">

    <?php
    if ( have_posts() ) :

        while ( have_posts() ) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( 'mb-8' ); ?>>
                <header class="entry-header mb-4">
                    <?php the_title( '<h2 class="entry-title text-2xl font-bold"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
                </header>

                <div class="entry-content prose">
                    <?php the_content(); ?>
                </div>
            </article>
            <?php
        endwhile;

        the_posts_navigation();

    else :
        ?>
        <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'civ-shows' ); ?></p>
        <?php
    endif;
    ?>

</main><!-- #main -->

<?php get_footer(); ?>
