<?php
/*
 * Section Settings Variables
 * 
 * Extracted from the 'section_settings' clone field in ACF.
 * usage: include get_template_directory() . '/template-parts/global/section-settings.php';
 */

$section_settings = get_sub_field('section_settings') ?: [];

// Variables
$section_style = '';
$section_container_class = '';
$section_overlay_markup = '';

// Spacings - Paddings
$spacing_top = $section_settings['section_spacing']['spacing']['spacing_top'] ?? 'default';
$spacing_bottom = $section_settings['section_spacing']['spacing']['spacing_bottom'] ?? 'default';

$spacing_top_map = [
  'none' => 'pt-0',
  'xs' => 'pt-4 lg:pt-8 xl:pt-8',
  'sm' => 'pt-4 lg:pt-6 xl:pt-14',
  'md' => 'pt-8 lg:pt-12 xl:pt-20',
  'lg' => 'pt-10 lg:pt-16 xl:pt-28',
  'xl' => 'pt-12 lg:pt-20 xl:pt-36',
  '2xl' => 'pt-12 lg:pt-24 xl:pt-40',
  'default' => 'pt-12 lg:pt-20 xl:pt-36'
];
$spacing_bottom_map = [
  'none' => 'pb-0',
  'xs' => 'pb-4 lg:pb-8 xl:pb-8',
  'sm' => 'pb-4 lg:pb-6 xl:pb-14',
  'md' => 'pb-8 lg:pb-12 xl:pb-20',
  'lg' => 'pb-10 lg:pb-16 xl:pb-28',
  'xl' => 'pb-12 lg:pb-20 xl:pb-36',
  '2xl' => 'pb-12 lg:pb-24 xl:pb-40',
  'default' => 'pb-12 lg:pb-20 xl:pb-36'
];

$section_padding_top = $spacing_top_map[$spacing_top] ?? $spacing_top_map['default'];
$section_padding_bottom = $spacing_bottom_map[$spacing_bottom] ?? $spacing_bottom_map['default'];
$section_container_class = $section_padding_top . ' ' . $section_padding_bottom  . ' ';

// Background - Color/Image
$background_settings = $section_settings['background'] ?? [];
$section_background_image = $background_settings['background_image']['url'] ?? '';
$section_background_color = $background_settings['background_color'] ?? '';
$section_background_overlay = $background_settings['background_overlay'] ?? '';

if ($section_background_color) {
  $section_style .= "background-color: " . esc_attr($section_background_color) . ";";
}

if ($section_background_image) {
  $section_style .= "background-image: url(" . esc_url($section_background_image) . "); background-size: cover; background-repeat: no-repeat; background-position: center;";
}

// Background Overlay (generated as a separate div to sit on top of image)
if ($section_background_overlay) {
  $section_overlay_markup = '<div class="absolute inset-0 pointer-events-none z-0" style="background-color: ' . esc_attr($section_background_overlay) . ';"></div>';
}

// Text & Link
$text_link_settings = $section_settings['text_link'] ?? [];
$section_text_color = $text_link_settings['text_color'] ?? '';
$section_link_color = $text_link_settings['link_color'] ?? '';

if ($section_text_color && $section_text_color !== 'default') {
  $section_style .= "color: " . esc_attr($section_text_color) . "; --section-text-color: " . esc_attr($section_text_color) . ";";
}
if ($section_link_color) {
  $section_style .= "--section-link-color: " . esc_attr($section_link_color) . ";";
}

// Extras - Anchor
$section_id = '';
if (!empty($section_settings['extra_settings']['section_anchor']['add_section_anchor'])) {
  $section_id = $section_settings['extra_settings']['section_anchor']['section_id'] ?? '';
}
