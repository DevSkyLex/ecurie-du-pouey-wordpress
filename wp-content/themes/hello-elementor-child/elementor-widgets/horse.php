<?php

namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; 

class Horse extends Widget_Base {

    public function get_name() {
        return 'horse'; 
    }

    public function get_title() {
        return 'Horse'; 
    }

    public function get_icon() {
        return 'eicon-featured-image';
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

        $horse_reference_options = $this->get_horse_references();

        $this->add_control(
            'horse_reference', 
            [
                'label' => __('Horse Reference', 'text-domain'),
                'type' => Controls_Manager::SELECT,
                'options' => $horse_reference_options, 
                'default' => '',
                'description' => __('Select a horse reference to display.', 'text-domain'),
            ]
        );

        $this->end_controls_section();
    }

    // Function to retrieve horse references from ACF
    protected function get_horse_references() {
        
        $args = [
            'post_type' => 'pouey_horse',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ];
        $horses_query = new \WP_Query($args);
        $references = [];

     
        if ($horses_query->have_posts()) {
            while ($horses_query->have_posts()) {
                $horses_query->the_post();
                $horse_reference = get_field('horse_reference');
                $horse_title = get_the_title();

                if ($horse_reference) {
                    $references[$horse_reference] = $horse_title . ' (' . $horse_reference . ')';
                }
            }
            wp_reset_postdata();
        }

        return $references; 
    }

    protected function render() {
        $settings = $this->get_settings_for_display(); 

        $ref_id = $settings['horse_reference'];

        $args = [
            'post_type' => 'pouey_horse',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'meta_query' => [
                [
                    'key'     => 'horse_reference',
                    'value'   => $ref_id,
                    'compare' => '='
                ],
            ],
        ];

        $horses = new \WP_Query($args);

        echo "<div class='horses-list'>";

        if ($horses->have_posts()) {
            while ($horses->have_posts()) {
                $horses->the_post();

                // Get ACF custom fields
                $horse_name = get_field('pouey-horse'); 
                $horse_image = get_field('image_du_cheval'); 
                $horse_race = get_field('race'); 
                $horse_sex = get_field('sexe'); 
                $button_text = get_field('texte_du_bouton');
                $horse_link = get_permalink(); 
                $star_number = get_field('nombre_etoiles');
            
                $horse_image = $horse_image ?: 'https://images.pexels.com/photos/635499/pexels-photo-635499.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1';
                $horse_name = $horse_name ?: get_the_title();
                $horse_race = $horse_race ?: '';
                $horse_sex = $horse_sex ?: '';
                $button_text = $button_text ?: 'Découvrir';

                // Create the HTML for each horse
                echo "<div class='card-wrapper'>";
                echo "  <div class='card-image'>";
                echo "    <img src='" . esc_url($horse_image) . "' alt='" . esc_attr($horse_name) . "' />";
                echo "  </div>";
                echo "  <div class='card-content'>";
                
                echo "    <div class='horse-caption'>";
                echo "      <div class='title-wrapper'>";
                echo "        <h2 class='title'>" . esc_html($horse_name) . "</h2>";
                echo "        <div class='stars'>";
               
                for ($i = 0; $i < $star_number; $i++) {
                    echo "<span>";
                    echo "<i class='fa-solid fa-star'></i>";
                    echo "</span>";
                }
        
                echo "        </div>";
                echo "      </div>";
                echo "      <div class='horse-favoris'>";
                echo "        <span><i class='fa-solid fa-heart'></i></span>";
                echo "      </div>";
                echo "    </div>";
                
                echo "    <hr class='separator'>";

                echo "    <div class='horse-criterias'>";
                echo "      <ul class='criterias-list'>";
                echo "        <li class='list-item'>Race: <span class='list-value'>" . esc_html($horse_race) . "</span></li>";
                echo "        <li class='list-item'>Sexe: <span class='list-value'>" . esc_html($horse_sex) . "</span></li>";
                echo "      </ul>";
                echo "    </div>";

                echo "    <div class='card-button'>";
                echo "      <a href='" . esc_url($horse_link) . "'>". esc_html($button_text) ."</a>";
                echo "    </div>";

                echo "  </div>"; // -- card-content --
                echo "</div>"; // -- card-wrapper --
            }
            wp_reset_postdata();
        } else {
            echo "<p>Aucun cheval trouvé.</p>";
        }
        // -- horses-list --
        echo "</div>"; 
    }

    protected function _content_template() {
        ?>
        <# 
        // Example static content for the editor view
        var horsesHtml = '<div class="horses-list">';
        horsesHtml += '<div class="card-wrapper">';
        horsesHtml += '  <div class="card-image"><img src="https://images.pexels.com/photos/635499/pexels-photo-635499.jpeg" alt="Horse Image" /></div>';
        horsesHtml += '  <div class="card-content">';
        horsesHtml += '    <div class="horse-caption">';
        horsesHtml += '      <div class="title-wrapper">';
        horsesHtml += '        <h2 class="title">Cheval - Exemple</h2>';
        horsesHtml += '        <div class="stars"><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span></div>';
        horsesHtml += '      </div>';
        horsesHtml += '      <div class="horse-favoris"><span>&#9829;</span></div>';
        horsesHtml += '    </div>';
        horsesHtml += '    <hr class="separator">';
        horsesHtml += '    <div class="horse-criterias">';
        horsesHtml += '      <ul class="criterias-list">';
        horsesHtml += '        <li class="list-item">Race: <span class="list-value">Anglo-Arabe</span></li>';
        horsesHtml += '        <li class="list-item">Sexe: <span class="list-value">Femelle</span></li>';
        horsesHtml += '      </ul>';
        horsesHtml += '    </div>';
        horsesHtml += '    <div class="card-button"><a href="#">Découvrir</a></div>';
        horsesHtml += '  </div>'; // Close card-content
        horsesHtml += '</div>'; // Close card-wrapper
        horsesHtml += '</div>'; // Close horses-list
        
        print(horsesHtml);
        #>
        <?php
    }
}
