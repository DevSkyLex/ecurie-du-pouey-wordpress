<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; 

class Horses extends Widget_Base {

    public function get_name() {
        return 'horses'; 
    }

    public function get_title() {
        return 'Horses'; 
    }

    public function get_icon() {
        return 'fa fa-horse'; 
    }

    public function get_categories() {
        return ['general']; 
    }

    protected function _register_controls() {
        
        $this->start_controls_section(
            'section_content',
            [
                'label' => 'Settings',
            ]
        );

      
        $this->add_control(
            'number_of_horses',
            [
                'label' => 'Number of Horses',
                'type' => Controls_Manager::NUMBER,
                'default' => -1, 
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();
        $number_of_horses = $settings['number_of_horses'];

        $args = [
            'post_type' => 'pouey_horse',
            'posts_per_page' => $number_of_horses,
            'post_status' => 'publish'
        ];

        $horses = new \WP_Query($args);

        $html = "<div class='horses-list'>";

        if ($horses->have_posts()) {
            while ($horses->have_posts()) {
                $horses->the_post();

                $horse_name = get_field('pouey-horse');
                $horse_image = get_field('image_du_cheval');

                $html .= "<div class='horse-item'>";
                $html .= "<h2>" . get_the_title() . "</h2>";

                if ($horse_name) {
                    $html .= "<p>Nom du cheval: " . esc_html($horse_name) . "</p>";
                }

                if ($horse_image) {
                    $html .= "<div class='horse-image'><img src='" . esc_url($horse_image) . "' alt='" . esc_attr($horse_name) . "' /></div>";
                }

                $html .= "</div>"; 
            }
            wp_reset_postdata();
        } else {
            $html .= "<p>Aucun cheval trouvé.</p>";
        }

        $html .= "</div>"; 

        echo $html; 
    }

    protected function _content_template() {
        ?>
        <# 
        // Get the number of horses to display
        var numberOfHorses = settings.number_of_horses;
        var horsesHtml = '<div class="horses-list">';
        
        // Example data to display in the editor (replace with dynamic content if needed)
        for (var i = 0; i < numberOfHorses; i++) {
            horsesHtml += '<div class="horse-item">';
            horsesHtml += '<h2>Horse Title ' + (i + 1) + '</h2>';
            horsesHtml += '<p>Nom du cheval: Horse Name ' + (i + 1) + '</p>';
            horsesHtml += '<div class="horse-image"><img src="https://via.placeholder.com/150" alt="Horse Image ' + (i + 1) + '" /></div>';
            horsesHtml += '</div>'; // Close horse-item
        }

        horsesHtml += '</div>'; // Close horses-list
        
        // Render the HTML
        print(horsesHtml);
        #>
        <?php
    }
}
