<?php

/**
 * Template Name: Homepage
 *
 * @package CIV Shows
 */

get_header();

get_template_part('template-parts/pages/home/home-hero-slider');
get_template_part('template-parts/pages/home/interactive-select');
get_template_part('template-parts/pages/home/shows-cards-grid');
get_template_part('template-parts/pages/global/subscribe');
get_template_part('template-parts/pages/global/featured-gallery');
get_template_part('template-parts/pages/global/cta-promo');

get_footer();
