<?php

/**
 * Page Builder Logic
 * 
 * Handles the rendering of ACF Flexible Content layouts.
 */

// Prevent direct access
if (! defined('ABSPATH')) {
  exit;
}

/**
 * Render Page Builder
 * 
 * Loops through the 'content_management' flexible content field
 * and loads the corresponding template part.
 * 
 * @param int $post_id Optional. Post ID to get fields from. Defaults to current post.
 */
function civ_render_page_builder($post_id = null)
{

  // Check if Flexible Content field exists
  if (have_rows('section_builder', $post_id)) {

    while (have_rows('section_builder', $post_id)) {
      the_row();

      // Get the layout name (e.g., 'one_column')
      $layout = get_row_layout();

      /**
       * Load the template part
       * 
       * Looks for files in: template-parts/sections/{layout_name}.php
       */
      get_template_part('template-parts/sections/' . $layout);
    }
  }
}
