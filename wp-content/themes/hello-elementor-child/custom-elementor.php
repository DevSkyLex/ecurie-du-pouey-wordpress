<?php
namespace WPC;

class Widget_Loader{

  private static $_instance = null;

  public static function instance()
  {
    if (is_null(self::$_instance)) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }


  private function include_widgets_files(){
    require_once(__DIR__ . '/elementor-widgets/advertisement.php');
    require_once(__DIR__ . '/elementor-widgets/horses.php');
  }

  public function register_widgets(){

    $this->include_widgets_files();

    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Advertisement() );
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Horses()); 
  }

  public function __construct(){
    add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets'], 99);
  }
}

// Instantiate Plugin Class
Widget_Loader::instance();

// function register_horses_widget( $widgets_manager ) {
//     if ( class_exists( 'Elementor\Horses_Widget' ) ) {
//         require_once( __DIR__ . '/elementor-widgets/horses-widget.php' );
//         $widgets_manager->register( new Horses_Widget() );
//     } else {
//         error_log( 'Elementor\Horses_Widget class does not exist' );
//     }
// }

// add_action( 'elementor/widgets/register', 'register_horses_widget' );