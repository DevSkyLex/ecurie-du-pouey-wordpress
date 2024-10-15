<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Horses_Widget extends Widget_Base {

    // Widget Name
    public function get_name() {
        return 'horses_widget';
    }

    // Widget Title
    public function get_title() {
        return __( 'Horses Widget', 'elementor-horses' );
    }

    // Widget Icon
    public function get_icon() {
        return 'eicon-post-list';
    }

    // Widget Categories
    public function get_categories() {
        return [ 'basic' ]; // or another category that you want
    }

    // Widget Controls/Settings
    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'elementor-horses' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Add controls here
        $this->end_controls_section();
    }

    // Widget Render Output
    protected function render() {
        echo '<div>This is the horses widget content.</div>';
    }

    // Widget Preview (for Elementor editor)
    protected function _content_template() {
        ?>
        <div>This is the horses widget content.</div>
        <?php
    }
}
