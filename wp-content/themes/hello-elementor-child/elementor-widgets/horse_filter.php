<?php
namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit;

class Horse_Filter extends Widget_Base {

    public function get_name() {
        return 'horse_filter';
    }

    public function get_title() {
        return 'Horse Filter';
    }

    public function get_icon() {
        return 'eicon-filter';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_typography',
            [
                'label' => __( 'Typography', 'horse-filter' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => __( 'Typography', 'horse-filter' ),
                'selector' => '{{WRAPPER}} .font-family-filter',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('filter_settings', ['label' => 'Filter Settings']);

        $this->add_control('filter_title_race', [
            'label' => 'Titre pour le filtre des races',
            'type' => Controls_Manager::TEXT,
            'default' => 'Races',
            'label_block' => true,
        ]);

        $this->add_control('filter_title_age', [
            'label' => 'Titre pour le filtre des âges',
            'type' => Controls_Manager::TEXT,
            'default' => 'Âges',
            'label_block' => true,
        ]);

        $this->add_control('filter_title_sex', [
            'label' => 'Titre pour les filtres par sexe',
            'type' => Controls_Manager::TEXT,
            'default' => 'Sexes',
            'label_block' => true,
        ]);

        $this->add_control('filter_title_hair', [
            'label' => 'Titre pour les filtres par couleur de robe',
            'type' => Controls_Manager::TEXT,
            'default' => 'Couleurs de la robe',
            'label_block' => true,
        ]);

        $this->add_control('filter_title_results', [
            'label' => 'Titre pour les filtres de résultat aux concours',
            'type' => Controls_Manager::TEXT,
            'default' => 'Résultats aux concours',
            'label_block' => true,
        ]);

        $this->add_control('filter_title_price', [
            'label' => 'Titre pour le filtre de prix',
            'type' => Controls_Manager::TEXT,
            'default' => 'Prix',
            'label_block' => true,
        ]);

        $this->add_control('show_race_filter', [
            'label' => 'Filtrer par race',
            'type' => Controls_Manager::SWITCHER,
            'label_on' => 'Yes',
            'label_off' => 'No',
            'return_value' => 'yes',
            'default' => 'yes',
        ]);

        $this->add_control('show_age_filter', [
            'label' => "Filtrer par âge",
            'type' => Controls_Manager::SWITCHER,
            'label_on' => 'Yes',
            'label_off' => 'No',
            'return_value' => 'yes',
            'default' => 'no',
        ]);

        $this->add_control('show_sex_filter', [
            'label' => 'Filtrer par sexe',
            'type' => Controls_Manager::SWITCHER,
            'label_on' => 'Yes',
            'label_off' => 'No',
            'return_value' => 'yes',
            'default' => 'no',
        ]);

        $this->add_control('show_hair_filter', [
            'label' => 'Couleur de la robe',
            'type' => Controls_Manager::SWITCHER,
            'label_on' => 'Yes',
            'label_off' => 'No',
            'return_value' => 'yes',
            'default' => 'no',
        ]);

        $this->add_control('show_results_filter', [
            'label' => 'Résultats aux concours',
            'type' => Controls_Manager::SWITCHER,
            'label_on' => 'Yes',
            'label_off' => 'No',
            'return_value' => 'yes',
            'default' => 'no',
        ]);

        $this->add_control('show_price_filter', [
            'label' => 'Filtrer par prix',
            'type' => Controls_Manager::SWITCHER,
            'label_on' => 'Yes',
            'label_off' => 'No',
            'return_value' => 'yes',
            'default' => 'no',
        ]);

        $this->add_control(
            'currency_symbol',
            [
                'label' => __('Monnaie', 'horse-filter'),
                'type' => Controls_Manager::TEXT,
                'default' => '€',
                'description' => __('Ecrire le symbole pour le prix (e.g., €, $, £, euros...).', 'horse-filter'),
                'label_block' => false,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        // Retrieve all horses to create the filter options
        $args = [
            'post_type' => 'pouey_horse',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ];

        $horses = new \WP_Query($args);

        $races = [];
        $ages = [];
        $sexes = [];
        $prices = [];
        $colors = [];
        $results = [];
        $isSell = false;
        $min_price = 0;
        $max_price = 10000;

        if ($horses->have_posts()) {
            while ($horses->have_posts()) {
                $horses->the_post();

                $horse_race = get_field('race');
                $horse_age = get_field('age_category');
                $horse_sex = get_field('sexe');
                $horse_status = get_field('statut_du_cheval');
                $horse_results = get_field('resultats_aux_concours');
                $horse_hair = get_field('couleur_de_la_robe');
                $horse_price = get_field('prix');

                if($horse_status) {
                    $isSell = true;
                }

                if ($horse_race) {
                    $races[] = $horse_race;
                }
                if ($horse_age) {
                    $ages[] = $horse_age['label'] ?: $horse_age;
                }
                if ($horse_sex) {
                    $sexes[] = $horse_sex;
                }
                if ($horse_results) {
                    $results[] = $horse_results;
                }
                if ($horse_hair) {
                    $colors[] = $horse_hair;
                }
                if ($horse_price) {
                    $prices[] = $horse_price;
                    $min_price = !empty($prices) ? min($prices) : 0;
                    $max_price = !empty($prices) ? max($prices) : 10000;
                }
            }
            wp_reset_postdata();
        }

        $races = array_unique($races);
        $ages = array_unique($ages);
        $sexes = array_unique($sexes);
        $results = array_unique($results);
        $colors = array_unique($colors);
//        $prices = array_unique($prices);

        echo '<div class="horse-filter-widget horse-filters font-family-filter">';

        if ('yes' === $settings['show_race_filter']) {
            echo '<h4>' . esc_html($settings['filter_title_race']) . '</h4>';
            echo '<div class="filter-options">';
            foreach ($races as $race) {
                echo "<label><input type='checkbox' class='race-filter' value='" . esc_attr($race) . "'> " . esc_html($race) . "</label><br>";
            }
            echo '</div>';
        }

        if ('yes' === $settings['show_age_filter']) {
            echo '<h4>' . esc_html($settings['filter_title_age']) . '</h4>';
            echo '<div class="filter-options">';
            foreach ($ages as $age) {
                echo "<label><input type='checkbox' class='age-filter' value='" . esc_attr($age) . "'> " . esc_html($age) . "</label><br>";
            }
            echo '</div>';
        }

        if ('yes' === $settings['show_sex_filter']) {
            echo '<h4>' . esc_html($settings['filter_title_sex']) . '</h4>';
            echo '<div class="filter-options">';
            foreach ($sexes as $sex) {
                echo "<label><input type='checkbox' class='sex-filter' value='" . esc_attr($sex) . "'> " . esc_html($sex) . "</label><br>";
            }
            echo '</div>';
        }

        if ('yes' === $settings['show_hair_filter']) {
            echo '<h4>' . esc_html($settings['filter_title_hair']) . '</h4>';
            echo '<div class="filter-options">';
            foreach ($colors as $color) {
                echo "<label><input type='checkbox' class='hair-filter' value='" . esc_attr($color) . "'> " . esc_html($color) . "</label><br>";
            }
            echo '</div>';
        }

        if ('yes' === $settings['show_price_filter']) {

            $currency_symbol = !empty($settings['currency_symbol']) ? $settings['currency_symbol'] : '€';

            echo '<div class="filter-options filter-price-wrapper">';
            echo '<fieldset class="filter-price">';

            echo '<div class="price-wrap">';

            // Minimum price input with dynamic currency symbol
            echo '<div class="price-wrap-1">';
            echo '<input id="one" value="' . esc_attr($min_price) . '">';
            echo '<label for="one">' . esc_html($currency_symbol) . '</label>';
            echo '</div>';

            // Maximum price input with dynamic currency symbol
            echo '<div class="price-wrap-2">';
            echo '<input id="two" value="' . esc_attr($max_price) . '">';
            echo '<label for="two">' . esc_html($currency_symbol) . '</label>';
            echo '</div>';

            echo '</div>';

            // slider
            echo '<div class="price-field">';
            echo '<input type="range" min="' . esc_attr($min_price) . '" max="' . esc_attr($max_price) . '" value="' . esc_attr($min_price) . '" id="lower">';
            echo '<input type="range" min="' . esc_attr($min_price) . '" max="' . esc_attr($max_price) . '" value="' . esc_attr($max_price) . '" id="upper">';
            echo '</div>';
            echo '</fieldset>';
            echo '</div>';
        }



        if ('yes' === $settings['show_results_filter']) {
            echo '<h4>' . esc_html($settings['filter_title_results']) . '</h4>';
            echo '<div class="filter-options">';
            foreach ($results as $result) {
                echo "<label><input type='checkbox' class='sex-filter' value='" . esc_attr($result) . "'> " . esc_html($result) . "</label><br>";
            }
            echo '</div>';
        }

        echo '</div>';
    }

    protected function _content_template() {
        ?>
        <#
        var showRaceFilter = settings.show_race_filter === 'yes';
        var showAgeFilter = settings.show_age_filter === 'yes';
        var showSexFilter = settings.show_sex_filter === 'yes';

        // Simulate fetching horse data
        var horses = [
        { race: 'Race A', age: 'Age 1', sexe: 'Male' },
        { race: 'Race B', age: 'Age 2', sexe: 'Female' },
        { race: 'Race A', age: 'Age 1', sexe: 'Female' }
        ];

        var races = [];
        var ages = [];
        var sexes = [];

        for (var i = 0; i < horses.length; i++) {
        var horse = horses[i];
        if (horse.race && races.indexOf(horse.race) === -1) {
        races.push(horse.race);
        }
        if (horse.age && ages.indexOf(horse.age) === -1) {
        ages.push(horse.age);
        }
        if (horse.sexe && sexes.indexOf(horse.sexe) === -1) {
        sexes.push(horse.sexe);
        }
        }

        #>
        <div class="horse-filter-widget horse-filters">
            <# if (showRaceFilter) { #>
            <h4>{{{ settings.filter_title_race }}}</h4>
            <div class="filter-options">
                <# for (var i = 0; i < races.length; i++) { #>
                <label>
                    <input type="checkbox" class="race-filter" value="{{ races[i] }}" checked> {{{ races[i] }}}
                </label><br>
                <# } #>
            </div>
            <# } #>

            <# if (showAgeFilter) { #>
            <h4>{{{ settings.filter_title_age }}}</h4>
            <div class="filter-options">
                <# for (var i = 0; i < ages.length; i++) { #>
                <label>
                    <input type="checkbox" class="age-filter" value="{{ ages[i] }}" checked> {{{ ages[i] }}}
                </label><br>
                <# } #>
            </div>
            <# } #>

            <# if (showSexFilter) { #>
            <h4>{{{ settings.filter_title_sex }}}</h4>
            <div class="filter-options">
                <# for (var i = 0; i < sexes.length; i++) { #>
                <label>
                    <input type="checkbox" class="sex-filter" value="{{ sexes[i] }}" checked> {{{ sexes[i] }}}
                </label><br>
                <# } #>
            </div>
            <# } #>
        </div>
        <?php
    }

}
