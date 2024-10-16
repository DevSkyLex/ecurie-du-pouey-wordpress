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
    require_once(__DIR__ . '/elementor-widgets/horse_filter.php');
    require_once(__DIR__ . '/elementor-widgets/horses.php');
    require_once(__DIR__ . '/elementor-widgets/horse.php');
  }

  public function register_widgets(){

    $this->include_widgets_files();
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Horse_Filter());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Horses());
    \Elementor\Plugin::instance()->widgets_manager->register(new Widgets\Horse()); 
  }

  public function __construct(){
    add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets'], 99);
  }
}

// Instantiate Plugin Class
Widget_Loader::instance();
