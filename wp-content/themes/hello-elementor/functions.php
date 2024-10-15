<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_VERSION', '3.1.1' );

if ( ! isset( $content_width ) ) {
	$content_width = 800; // Pixels.
}

if ( ! function_exists( 'hello_elementor_setup' ) ) {
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function hello_elementor_setup() {
		if ( is_admin() ) {
			hello_maybe_update_theme_version_in_db();
		}

		if ( apply_filters( 'hello_elementor_register_menus', true ) ) {
			register_nav_menus( [ 'menu-1' => esc_html__( 'Header', 'hello-elementor' ) ] );
			register_nav_menus( [ 'menu-2' => esc_html__( 'Footer', 'hello-elementor' ) ] );
		}

		if ( apply_filters( 'hello_elementor_post_type_support', true ) ) {
			add_post_type_support( 'page', 'excerpt' );
		}

		if ( apply_filters( 'hello_elementor_add_theme_support', true ) ) {
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support(
				'html5',
				[
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
					'script',
					'style',
				]
			);
			add_theme_support(
				'custom-logo',
				[
					'height'      => 100,
					'width'       => 350,
					'flex-height' => true,
					'flex-width'  => true,
				]
			);

			/*
			 * Editor Style.
			 */
			add_editor_style( 'classic-editor.css' );

			/*
			 * Gutenberg wide images.
			 */
			add_theme_support( 'align-wide' );

			/*
			 * WooCommerce.
			 */
			if ( apply_filters( 'hello_elementor_add_woocommerce_support', true ) ) {
				// WooCommerce in general.
				add_theme_support( 'woocommerce' );
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support( 'wc-product-gallery-zoom' );
				// lightbox.
				add_theme_support( 'wc-product-gallery-lightbox' );
				// swipe.
				add_theme_support( 'wc-product-gallery-slider' );
			}
		}
	}
}
add_action( 'after_setup_theme', 'hello_elementor_setup' );

function hello_maybe_update_theme_version_in_db() {
	$theme_version_option_name = 'hello_theme_version';
	// The theme version saved in the database.
	$hello_theme_db_version = get_option( $theme_version_option_name );

	// If the 'hello_theme_version' option does not exist in the DB, or the version needs to be updated, do the update.
	if ( ! $hello_theme_db_version || version_compare( $hello_theme_db_version, HELLO_ELEMENTOR_VERSION, '<' ) ) {
		update_option( $theme_version_option_name, HELLO_ELEMENTOR_VERSION );
	}
}

if ( ! function_exists( 'hello_elementor_display_header_footer' ) ) {
	/**
	 * Check whether to display header footer.
	 *
	 * @return bool
	 */
	function hello_elementor_display_header_footer() {
		$hello_elementor_header_footer = true;

		return apply_filters( 'hello_elementor_header_footer', $hello_elementor_header_footer );
	}
}

if ( ! function_exists( 'hello_elementor_scripts_styles' ) ) {
	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	function hello_elementor_scripts_styles() {
		$min_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		if ( apply_filters( 'hello_elementor_enqueue_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor',
				get_template_directory_uri() . '/style' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( apply_filters( 'hello_elementor_enqueue_theme_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor-theme-style',
				get_template_directory_uri() . '/theme' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if ( hello_elementor_display_header_footer() ) {
			wp_enqueue_style(
				'hello-elementor-header-footer',
				get_template_directory_uri() . '/header-footer' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_scripts_styles' );

if ( ! function_exists( 'hello_elementor_register_elementor_locations' ) ) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function hello_elementor_register_elementor_locations( $elementor_theme_manager ) {
		if ( apply_filters( 'hello_elementor_register_elementor_locations', true ) ) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action( 'elementor/theme/register_locations', 'hello_elementor_register_elementor_locations' );

if ( ! function_exists( 'hello_elementor_content_width' ) ) {
	/**
	 * Set default content width.
	 *
	 * @return void
	 */
	function hello_elementor_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'hello_elementor_content_width', 800 );
	}
}
add_action( 'after_setup_theme', 'hello_elementor_content_width', 0 );

if ( ! function_exists( 'hello_elementor_add_description_meta_tag' ) ) {
	/**
	 * Add description meta tag with excerpt text.
	 *
	 * @return void
	 */
	function hello_elementor_add_description_meta_tag() {
		if ( ! apply_filters( 'hello_elementor_description_meta_tag', true ) ) {
			return;
		}

		if ( ! is_singular() ) {
			return;
		}

		$post = get_queried_object();
		if ( empty( $post->post_excerpt ) ) {
			return;
		}

		echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $post->post_excerpt ) ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'hello_elementor_add_description_meta_tag' );

// Admin notice
if ( is_admin() ) {
	require get_template_directory() . '/includes/admin-functions.php';
}

// Settings page
require get_template_directory() . '/includes/settings-functions.php';

// Header & footer styling option, inside Elementor
require get_template_directory() . '/includes/elementor-functions.php';

if ( ! function_exists( 'hello_elementor_customizer' ) ) {
	// Customizer controls
	function hello_elementor_customizer() {
		if ( ! is_customize_preview() ) {
			return;
		}

		if ( ! hello_elementor_display_header_footer() ) {
			return;
		}

		require get_template_directory() . '/includes/customizer-functions.php';
	}
}
add_action( 'init', 'hello_elementor_customizer' );

if ( ! function_exists( 'hello_elementor_check_hide_title' ) ) {
	/**
	 * Check whether to display the page title.
	 *
	 * @param bool $val default value.
	 *
	 * @return bool
	 */
	function hello_elementor_check_hide_title( $val ) {
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			$current_doc = Elementor\Plugin::instance()->documents->get( get_the_ID() );
			if ( $current_doc && 'yes' === $current_doc->get_settings( 'hide_title' ) ) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter( 'hello_elementor_page_title', 'hello_elementor_check_hide_title' );

/**
 * BC:
 * In v2.7.0 the theme removed the `hello_elementor_body_open()` from `header.php` replacing it with `wp_body_open()`.
 * The following code prevents fatal errors in child themes that still use this function.
 */
if ( ! function_exists( 'hello_elementor_body_open' ) ) {
	function hello_elementor_body_open() {
		wp_body_open();
	}
}

/** Custom */

/** Shortcodes */
add_shortcode( 'mes_chevaux', 'mes_chevaux_func' );

/**
 * Fonction qui permet d'afficher les chevaux 
 * @param $atts - référence du cheval 
 * @return false|string 
 */
function mes_chevaux_func( $atts ) {
    
    // Get ACF field from options page (if needed, based on your comment)
    $locations = get_field('your_options_field', 'option');  // Example for options page ACF

    // Define query parameters
    $args = array(
        'post_type'      => 'pouey_horse',
        'posts_per_page' => -1,  // You can change this to limit the number of horses displayed
        'post_status'    => 'publish'
    );

    // Query the horses
    $horses = new WP_Query($args);

    // Start HTML output
    $html = "<div class='horses-list'>";

    // Check if there are any posts
    if( $horses->have_posts() ) {

        // Loop through each horse post
        while( $horses->have_posts() ) {
            $horses->the_post();

            // Get ACF custom fields
            $horse_name = get_field('pouey-horse');  // Custom text field for horse name
            $horse_image = get_field('image_du_cheval');  // Image field returning a URL

            // Create the HTML for each horse
            $html .= "<div class='horse-item'>";
            
            // Horse title (from WP post title)
            $html .= "<h2>" . get_the_title() . "</h2>";
            
            // Custom ACF field (horse name)
            if( $horse_name ) {
                $html .= "<p>Nom du cheval: " . esc_html($horse_name) . "</p>";
            }

            // Horse image
            if( $horse_image ) {
                $html .= "<div class='horse-image'><img src='" . esc_url($horse_image) . "' alt='" . esc_attr($horse_name) . "' /></div>";
            }

            // Optional: Add more fields or metadata here if needed

            $html .= "</div>";  // Close horse-item
        }
        // Reset post data
        wp_reset_postdata();
    } else {
        // No horses found
        $html .= "<p>Aucun cheval trouvé.</p>";
    }

    $html .= "</div>";  // Close horses-list

    return $html;
}



/**
 * Fonction qui permet d'afficher la propriété "à l'affiche" via le shortcode avec la référence de la propriété
 * @param $atts - référence de la propriété (se trouve dans le CPT des propriétés en backoffice > "réf")
 * @return false|string - A noter : retourne aussi un template html si le path du template est trouvé
 */
function display_horses($atts) {

    $attributes = shortcode_atts([
        'ref' => '',
    ], $atts);

    $ref_id = $attributes['ref'];
    //$selectedPropertyImg = $atts['image'];

        $args = array(
            'post_type'      => 'pouey_horse',
            'posts_per_page' => 1,
            'post_status'    => 'publish'
        );

    $property_query = new WP_Query($args);
    $html = '';

    if( $property_query->have_posts() ) :
        while( $property_query->have_posts() ) : $property_query->the_post();
            $property_images_urls = [];
            $link = get_permalink(get_the_ID());
            $image_url = wp_get_attachment_image_url( get_post_thumbnail_id( get_the_ID() ), 'full' );
           
            if (!empty($property_images_infos)) {
                foreach ($property_images_infos as $image) {
                    if(!empty($image->ID)){
                        $property_images_urls[] = ['id' => $image->ID, 'guid' => $image->guid];
                    }
                }
            }

            if (!empty($property_images_urls)){
                $image_url = wp_get_attachment_image_url(pathinfo(basename($property_images_urls[0]['id']), PATHINFO_FILENAME), 'full' );
            }

            var_dump( wp_get_attachment_image_url($property_images_urls[0]['id'], PATHINFO_FILENAME));

            $html .= '<div class="star-property-template-wrapper" style="display: flex;">';
            $html .= '<div class="star-property-template elementor-container">';

            if (!empty($image_url)) {
                $html .= '<div class="star-property-template__image-wrapper">';
                $html .= '<img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( get_the_title() ) . '" />';
                $html .= '</div>';
            }

            $html .= '<div class="star-property-template__description-wrapper">';

            $html .= '<div class="property-label">';
            $html .= '<h2 class="title hyphens">' . the_title('', '', false) . '</h2>';
            $html .=  '<div class="read-more">';
            $html .= '<a href="' . esc_url($link) . '">';
            $html .= esc_html__('discover more', 'wpresidence');
            $html .= '<i class="fas fa-angle-right"></i>';
            $html .= '</a>';
            $html .= '</div>';

            $html .= '</div>';

            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';

        endwhile;
        wp_reset_postdata();
    endif;

    return $html ?? "";

}

add_shortcode('display_star_property', 'display_star_property_function');