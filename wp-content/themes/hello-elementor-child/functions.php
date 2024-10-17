<?php

function child_enqueue__scripts()
{
  wp_enqueue_style('parent', get_template_directory_uri() . '/style.css');
  wp_enqueue_style('hello-elementor-child', get_stylesheet_directory_uri() . '/style.css');
  wp_enqueue_style('hello-elementor-child-form', get_stylesheet_directory_uri() . '/form-style.css');
  wp_enqueue_script(
    'hello-elementor-child-frontend',
    get_stylesheet_directory_uri() . '/assets/js/hello-filter.js',
    array(),
    null,
    true
  );
}

function custom_wpcf7_form_class_attr($class): string {
  $class .= ' custom-form';
  return $class;
}

add_filter('wpcf7_form_class_attr', 'custom_wpcf7_form_class_attr');
add_filter('wpcf7_autop_or_not', '__return_false');
add_action('wp_enqueue_scripts', 'child_enqueue__scripts');

/**
 * Enqueue Dashicons for the front-end.
 */
function enqueue_dashicons()
{
  wp_enqueue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'enqueue_dashicons');


require_once 'custom-elementor.php';

