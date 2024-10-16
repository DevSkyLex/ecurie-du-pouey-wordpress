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

        // Control for the number of horses to display
        $this->add_control(
            'number_of_horses',
            [
                'label' => 'Number of Horses',
                'type' => Controls_Manager::NUMBER,
                'default' => -1, // Default to show all horses
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
        // Get the number of horses to display
        var numberOfHorses = settings.number_of_horses;
        var horsesHtml = '<div class="horses-list">';
        
        // Example data to display in the editor (replace with dynamic content if needed)
        for (var i = 0; i < numberOfHorses; i++) {
            horsesHtml += '<div class="card-wrapper">';
            horsesHtml += '  <div class="card-image"><img src="https://images.pexels.com/photos/635499/pexels-photo-635499.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Horse Image ' + (i + 1) + '" /></div>';
            horsesHtml += '  <div class="card-content">';
            horsesHtml += '    <div class="horse-caption">';
            horsesHtml += '      <div class="title-wrapper">';
            horsesHtml += '        <h2 class="title">Cheval - nom n° ' + (i + 1) + '</h2>';
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
        }

        horsesHtml += '</div>'; // Close horses-list
        
        // Render the HTML
        print(horsesHtml);
        #>
        <?php
    }
}
