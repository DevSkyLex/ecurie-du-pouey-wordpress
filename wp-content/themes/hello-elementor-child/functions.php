<?php
/* Function to enqueue stylesheet from parent theme */

function child_enqueue__parent_scripts() {

    wp_enqueue_style( 'parent', get_template_directory_uri().'/style.css' );

}
add_action( 'wp_enqueue_scripts', 'child_enqueue__parent_scripts' );

// Include the widget class from the child theme
require_once get_stylesheet_directory() . '/elementor-widgets/horses-widget.php';

// Register the horses widget function
function register_horses_widget( $widgets_manager ) {
    // Check if the class exists before registering
    if ( class_exists( 'Elementor\Horses_Widget' ) ) {
        $widgets_manager->register( new \Elementor\Horses_Widget() );
    } else {
        // Output a helpful message for debugging
        error_log( 'Elementor\Horses_Widget class does not exist' );
    }
}

// Hook into Elementor to register the widget
add_action( 'elementor/widgets/register', 'register_horses_widget' );