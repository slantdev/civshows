<?php

/**
 * Template part for displaying single show content
 */

if (is_single('melbourne-leisurefest')) {
  get_template_part('template-parts/shows/components/page-header');
  get_template_part('template-parts/shows/components/video-slider');
  get_template_part('template-parts/shows/components/image-text');
  get_template_part('template-parts/components/subscribe');
  get_template_part('template-parts/components/cta-promo');
}

if (is_single('border-leisurefest')) {
  get_template_part('template-parts/shows/components/page-header');
  get_template_part('template-parts/shows/components/video-slider');
  get_template_part('template-parts/shows/components/image-text');
  get_template_part('template-parts/components/subscribe');
  get_template_part('template-parts/components/cta-promo');
}

if (is_single('tickets')) {
  get_template_part('template-parts/shows/components/page-header');
  get_template_part('template-parts/shows/components/two-columns-1');
  get_template_part('template-parts/components/subscribe');
  get_template_part('template-parts/components/cta-promo');
}

if (is_single('visitor-information')) {
  get_template_part('template-parts/shows/components/page-header');
  get_template_part('template-parts/shows/components/visitor-information');
  get_template_part('template-parts/components/subscribe');
  get_template_part('template-parts/components/cta-promo');
}

if (is_single('exhibitors')) {
  get_template_part('template-parts/shows/components/page-header');
  get_template_part('template-parts/shows/components/exhibitors');
  get_template_part('template-parts/components/subscribe');
  get_template_part('template-parts/components/cta-promo');
}

if (is_single('exhibitor-detail')) {
  get_template_part('template-parts/shows/components/page-header');
  get_template_part('template-parts/shows/components/exhibitor-detail');
  get_template_part('template-parts/shows/components/exhibitor-special');
  get_template_part('template-parts/components/subscribe');
  get_template_part('template-parts/components/cta-promo');
}

if (is_single('gallery')) {
  get_template_part('template-parts/shows/components/page-header');
  get_template_part('template-parts/shows/components/gallery');
  get_template_part('template-parts/components/subscribe');
  get_template_part('template-parts/components/cta-promo');
}

if (is_single('win')) {
  get_template_part('template-parts/shows/components/page-header');
  get_template_part('template-parts/shows/components/win');
  get_template_part('template-parts/components/subscribe');
  get_template_part('template-parts/components/cta-promo');
}

if (is_single('map-guide')) {
  get_template_part('template-parts/shows/components/page-header');
  get_template_part('template-parts/shows/components/map-guide');
  get_template_part('template-parts/components/subscribe');
  get_template_part('template-parts/components/cta-promo');
}

if (is_single('whats-on')) {
  get_template_part('template-parts/shows/components/page-header');
  get_template_part('template-parts/shows/components/whats-on');
  get_template_part('template-parts/components/subscribe');
  get_template_part('template-parts/components/cta-promo');
}
