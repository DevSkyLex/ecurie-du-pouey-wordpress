<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header();

if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        // Get all necessary fields
        $horse_name = get_field('pouey-horse');
        $horse_image = get_field('image_du_cheval');
        $horse_race = get_field('race');
        $horse_sex = get_field('sexe');
        $horse_age = get_field('age_category');
        $horse_status = get_field('statut_du_cheval');
        $horse_results = get_field('resultats_aux_concours');
        $horse_hair = get_field('couleur_de_la_robe');
        $horse_price = get_field('prix');
        $star_number = get_field('nombre_etoiles');

        $horse_image = $horse_image ?: 'https://images.pexels.com/photos/635499/pexels-photo-635499.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1';
        $horse_name = $horse_name ?: get_the_title();
        ?>

        <main class="single-horse main-custom-content">
            <div class="horse-header">
                <img src="<?php echo esc_url($horse_image); ?>" alt="<?php echo esc_attr($horse_name); ?>">
                <h1><?php echo esc_html($horse_name); ?></h1>
                <div class="stars">
                    <?php for ($i = 0; $i < $star_number; $i++) : ?>
                        <span><i class="fa-solid fa-star"></i></span>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="horse-details">
                <ul>
                    <li>Race: <span><?php echo esc_html($horse_race); ?></span></li>
                    <li>Sex: <span><?php echo esc_html($horse_sex); ?></span></li>
                    <li>Age: <span><?php echo esc_html($horse_age); ?></span></li>
                    <li>Status: <span><?php echo esc_html($horse_status); ?></span></li>
                    <li>Color: <span><?php echo esc_html($horse_hair); ?></span></li>
                    <li>Price: <span><?php echo esc_html($horse_price); ?></span></li>
                    <li>Competition Results: <span><?php echo esc_html($horse_results); ?></span></li>
                </ul>
            </div>
        </main>

    <?php
    endwhile;
endif;

get_footer();
