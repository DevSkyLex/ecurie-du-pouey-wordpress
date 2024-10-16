<?php
/* Function to enqueue stylesheet from parent theme */

function child_enqueue__scripts() {

    wp_enqueue_style( 'parent', get_template_directory_uri().'/style.css' );
 	wp_enqueue_style( 'hello-elementor-child', get_stylesheet_directory_uri() . '/style.css');
    wp_enqueue_script(
        'hello-elementor-child-frontend',
        get_stylesheet_directory_uri() . '/assets/js/hello-filter.js',
        array(), // Load after parent theme script
        null,
        true // Load in footer
    );

}
add_action( 'wp_enqueue_scripts', 'child_enqueue__scripts' );

/**
 * Enqueue Dashicons for the front-end.
 */
function enqueue_dashicons() {
    wp_enqueue_style( 'dashicons' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_dashicons' );


require_once 'custom-elementor.php';

