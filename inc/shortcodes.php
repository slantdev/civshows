<?php

/**
 * Custom Shortcodes for CIV Shows Theme.
 */

// Force The Events Calendar to load its assets on pages that contain the [civ_events] shortcode.
add_filter('tribe_events_views_v2_assets_should_enqueue_frontend', function($should_enqueue) {
    global $post, $wpdb;
    
    if ( is_a( $post, 'WP_Post' ) ) {
        // 1. Check standard WordPress content
        if ( has_shortcode( $post->post_content, 'civ_events') ) {
            return true;
        }
        
        // 2. Check ACF/Meta fields (since pages use the Page Builder)
        $has_shortcode_in_meta = $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_value LIKE %s",
            $post->ID,
            '%[civ_events%'
        ) );

        if ( $has_shortcode_in_meta > 0 ) {
            return true;
        }
    }
    
    return $should_enqueue;
});

add_shortcode('civ_events', function($atts) {
    // Check if The Events Calendar is active
    if (!class_exists('\Tribe\Events\Views\V2\Template_Bootstrap')) {
        return '';
    }

    $atts = shortcode_atts([
        'category' => '',
    ], $atts, 'civ_events');

    // Temporarily inject category into request to trick TEC V2 Context
    $original_request = $_REQUEST;
    if ( ! empty( $atts['category'] ) ) {
        $_REQUEST['tribe_events_cat'] = sanitize_title( $atts['category'] );
        // Also add to query vars so tribe_get_global_query_object() or context picks it up
        set_query_var( 'tribe_events_cat', sanitize_title( $atts['category'] ) );
    }

    ob_start();
    // Programmatically render the "list" view
    echo tribe( \Tribe\Events\Views\V2\Template_Bootstrap::class )->get_view_html( [
        'view' => 'list'
    ] );
    $html = ob_get_clean();

    // Restore original request state
    $_REQUEST = $original_request;
    if ( ! empty( $atts['category'] ) ) {
        set_query_var( 'tribe_events_cat', null );
    }

    return $html;
});
