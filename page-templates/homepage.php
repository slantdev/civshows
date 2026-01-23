<?php

/**
 * Template Name: Homepage
 *
 * @package CIV Shows
 */

get_header();

get_template_part('template-parts/components/home-hero-slider');
get_template_part('template-parts/components/interactive-select');
get_template_part('template-parts/components/shows-cards-grid');
get_template_part('template-parts/components/subscribe');
get_template_part('template-parts/components/featured-gallery');
get_template_part('template-parts/components/cta-promo');

get_footer();
