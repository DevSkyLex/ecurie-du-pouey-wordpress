<?php
namespace WPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

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
        $this->start_controls_section('filter_settings', ['label' => 'Filter Settings']);

        $this->add_control('filter_title_race', [
            'label' => 'Race Filter Title',
            'type' => Controls_Manager::TEXT,
            'default' => 'Filter by Race',
            'label_block' => true,
        ]);

        $this->add_control('filter_title_age', [
            'label' => 'Age Filter Title',
            'type' => Controls_Manager::TEXT,
            'default' => 'Filter by Age',
            'label_block' => true,
        ]);

        $this->add_control('filter_title_sex', [
            'label' => 'Sex Filter Title',
            'type' => Controls_Manager::TEXT,
            'default' => 'Filter by Sex',
            'label_block' => true,
        ]);

        $this->add_control('show_race_filter', [
            'label' => 'Show Race Filter',
            'type' => Controls_Manager::SWITCHER,
            'label_on' => 'Yes',
            'label_off' => 'No',
            'return_value' => 'yes',
            'default' => 'yes',
        ]);

        $this->add_control('show_age_filter', [
            'label' => 'Show Age Filter',
            'type' => Controls_Manager::SWITCHER,
            'label_on' => 'Yes',
            'label_off' => 'No',
            'return_value' => 'yes',
            'default' => 'no',
        ]);

        $this->add_control('show_sex_filter', [
            'label' => 'Show Sex Filter',
            'type' => Controls_Manager::SWITCHER,
            'label_on' => 'Yes',
            'label_off' => 'No',
            'return_value' => 'yes',
            'default' => 'no',
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $races = get_terms(['taxonomy' => 'race_taxonomy', 'hide_empty' => true]);
        $genres = get_terms(['taxonomy' => 'genre_taxonomy', 'hide_empty' => true]);
        $ages = get_terms(['taxonomy' => 'age_taxonomy', 'hide_empty' => true]);

        echo '<div class="horse-filter-widget">';

        if ('yes' === $settings['show_race_filter']) {
            echo '<h4>' . esc_html($settings['filter_title_race']) . '</h4>';
            echo '<div class="filter-options">';
            foreach ($races as $race) {
                echo '<label>';
                echo '<input type="checkbox" class="filter-checkbox" value="' . esc_attr($race->name) . '" checked> ' . esc_html($race->name);
                echo '</label><br>';
            }
            echo '</div>';
        }

        if ('yes' === $settings['show_age_filter']) {
            echo '<h4>' . esc_html($settings['filter_title_age']) . '</h4>';
            echo '<div class="filter-options">';
            foreach ($ages as $age) {
                echo '<label>';
                echo '<input type="checkbox" class="filter-checkbox" value="' . esc_attr($age->name) . '" checked> ' . esc_html($race->name);
                echo '</label><br>';
            }
            echo '</div>';
        }

        if ('yes' === $settings['show_sex_filter']) {
            echo '<h4>' . esc_html($settings['filter_title_sex']) . '</h4>';
            echo '<div class="filter-options">';
            foreach ($genres as $genre) {
                echo '<label>';
                echo '<input type="checkbox" class="filter-checkbox" value="' . esc_attr($genre->name) . '" checked> ' . esc_html($race->name);
                echo '</label><br>';
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
        #>
        <div class="horse-filter-widget">
            <# if (showRaceFilter) { #>
            <h4>{{{ settings.filter_title_race }}}</h4>
            <div class="filter-options">
                <label>
                    <input type="checkbox" class="filter-checkbox" value="Race A" checked> Race A
                </label><br>
                <label>
                    <input type="checkbox" class="filter-checkbox" value="Race B" checked> Race B
                </label><br>
            </div>
            <# } #>
            <# if (showAgeFilter) { #>
            <h4>{{{ settings.filter_title_age }}}</h4>
            <div class="filter-options">
                <label>
                    <input type="checkbox" class="filter-checkbox" value="Age 1" checked> Age 1
                </label><br>
                <label>
                    <input type="checkbox" class="filter-checkbox" value="Age 2" checked> Age 2
                </label><br>
            </div>
            <# } #>
            <# if (showSexFilter) { #>
            <h4>{{{ settings.filter_title_sex }}}</h4>
            <div class="filter-options">
                <label>
                    <input type="checkbox" class="filter-checkbox" value="Male" checked> Male
                </label><br>
                <label>
                    <input type="checkbox" class="filter-checkbox" value="Female" checked> Female
                </label><br>
            </div>
            <# } #>
        </div>
        <?php
    }
}
