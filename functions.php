<?php

/**
 * Enqueue scripts and styles.
 */
function civ_enqueue_scripts() {
    $theme_version = wp_get_theme()->get( 'Version' );
    $is_development = defined('WP_ENVIRONMENT_TYPE') && WP_ENVIRONMENT_TYPE === 'local';

    if ( $is_development && file_get_contents( 'http://localhost:3000/@vite/client' ) ) {
        // Vite Development Mode
        wp_enqueue_script( 'vite-client', 'http://localhost:3000/@vite/client', [], null, true );
        wp_enqueue_script( 'civ-main', 'http://localhost:3000/src/main.js', [], null, true );
        
        // Inject React Refresh or similar if needed, but for vanilla JS:
        add_filter('script_loader_tag', function($tag, $handle, $src) {
            if ($handle === 'civ-main' || $handle === 'vite-client') {
                return '<script type="module" src="' . esc_url($src) . '"></script>';
            }
            return $tag;
        }, 10, 3);

    } else {
        // Production Mode
        $manifest_path = get_theme_file_path( 'assets/.vite/manifest.json' );
        
        if ( file_exists( $manifest_path ) ) {
            $manifest = json_decode( file_get_contents( $manifest_path ), true );
            
            if ( isset( $manifest['src/main.js'] ) ) {
                $js_file = $manifest['src/main.js']['file'];
                $css_files = $manifest['src/main.js']['css'] ?? [];

                wp_enqueue_script( 'civ-main', get_theme_file_uri( 'assets/' . $js_file ), [], $theme_version, true );
                
                foreach ( $css_files as $css_file ) {
                    wp_enqueue_style( 'civ-style-' . md5($css_file), get_theme_file_uri( 'assets/' . $css_file ), [], $theme_version );
                }
            }
        }
    }
}
add_action( 'wp_enqueue_scripts', 'civ_enqueue_scripts' );

/**
 * Load AJAX Handlers.
 */
require get_theme_file_path( '/inc/ajax-handlers.php' );
