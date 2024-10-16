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
        $this->start_controls_section('section_content', [
            'label' => 'Settings',
        ]);

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

    public function get_script_depends() {
        // Enqueue custom JavaScript for this widget
        return ['hello-filter'];
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $number_of_horses = $settings['number_of_horses'];

        $args = [
            'post_type' => 'pouey_horse',
            'posts_per_page' => $number_of_horses,
            'post_status' => 'publish',
        ];

        $horses = new \WP_Query($args);

        // Get all races for checkbox filters (this is basic, you can adjust it based on how race data is stored)
        $all_races = get_posts([
            'post_type' => 'pouey_horse',
            'posts_per_page' => -1,
            'fields' => 'ids'
        ]);

        $race_filters = array_unique(array_map(function ($post_id) {
            return get_field('race', $post_id);
        }, $all_races));

        echo "<div class='horse-filters'>";
        foreach ($race_filters as $race) {
            echo "<label><input type='checkbox' class='race-filter' value='" . esc_attr($race) . "'> " . esc_html($race) . "</label>";
        }
        echo "</div>";

        echo "<div class='horses-list'>";

        if ($horses->have_posts()) {
            while ($horses->have_posts()) {
                $horses->the_post();

                $horse_name = get_field('pouey-horse');
                $horse_image = get_field('image_du_cheval');
                $horse_race = get_field('race');
                $horse_sex = get_field('sexe');
                $button_text = get_field('texte_du_bouton');
                $horse_link = get_permalink();
                $star_number = get_field('nombre_etoiles');

                $horse_image = $horse_image ?: 'https://images.pexels.com/photos/635499/pexels-photo-635499.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1';
                $horse_name = $horse_name ?: get_the_title();
                $button_text = $button_text ?: 'Découvrir';

                echo "<div class='card-wrapper' data-race='" . esc_attr($horse_race) . "'>";
                echo "  <div class='card-image'>";
                echo "    <img src='" . esc_url($horse_image) . "' alt='" . esc_attr($horse_name) . "' />";
                echo "  </div>";
                echo "  <div class='card-content'>";
                echo "    <div class='horse-caption'>";
                echo "      <div class='title-wrapper'>";
                echo "        <h2 class='title'>" . esc_html($horse_name) . "</h2>";
                echo "        <div class='stars'>";
                for ($i = 0; $i < $star_number; $i++) {
                    echo "<span><i class='fa-solid fa-star'></i></span>";
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
                echo "      <a href='" . esc_url($horse_link) . "'>" . esc_html($button_text) . "</a>";
                echo "    </div>";
                echo "  </div>";
                echo "</div>";
            }
            wp_reset_postdata();
        } else {
            echo "<p>Aucun cheval trouvé.</p>";
        }

        echo "</div>";
    }

    protected function _content_template() {
        ?>
        <# var numberOfHorses = settings.number_of_horses; #>
        <div class="horses-list">
            <#
            for (var i = 0; i < numberOfHorses; i++) {
            var horseImage = 'https://images.pexels.com/photos/635499/pexels-photo-635499.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'; // Sample placeholder
            var horseName = 'Horse Name ' + (i + 1);
            var race = 'Sample Race';
            var sexe = 'Sample Sex';
            var stars = 5;
            #>
            <div class="card-wrapper" data-race="{{ race }}">
                <div class="card-image">
                    <img src="{{ horseImage }}" alt="{{ horseName }}" />
                </div>
                <div class="card-content">
                    <div class="horse-caption">
                        <div class="title-wrapper">
                            <h2 class="title">{{ horseName }}</h2>
                            <div class="stars">
                                <# for (var s = 0; s < stars; s++) { #>
                                <span><i class="fa-solid fa-star"></i></span>
                                <# } #>
                            </div>
                        </div>
                        <div class="horse-favoris">
                            <span><i class="fa-solid fa-heart"></i></span>
                        </div>
                    </div>
                    <hr class="separator">
                    <div class="horse-criterias">
                        <ul class="criterias-list">
                            <li class="list-item">Race: <span class="list-value">{{ race }}</span></li>
                            <li class="list-item">Sexe: <span class="list-value">{{ sexe }}</span></li>
                        </ul>
                    </div>
                    <div class="card-button">
                        <a href="#">Découvrir</a>
                    </div>
                </div>
            </div>
            <# } #>
        </div>
        <?php
    }
}
