<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header();

if ( have_posts() ) :
    while ( have_posts() ) : the_post();

        $post_id = get_the_ID();
        $post_data = get_post($post_id);

        $horse_content = $post_data->post_content;

        // ACF fields
        $horse_name = get_field('nom_du_cheval', $post_id);
        $horse_race = get_field('race', $post_id);
        $horse_sex = get_field('sexe', $post_id);
        $horse_category_age = get_field('age_category', $post_id);
        $horse_age = get_field('age_du_cheval', $post_id);
        $horse_status = get_field('statut_du_cheval', $post_id);
        $horse_results = get_field('resultats_aux_concours', $post_id);
        $horse_hair = get_field('couleur_de_la_robe', $post_id);
        $horse_price = get_field('prix', $post_id);

        $star_number = get_field('nombre_etoiles', $post_id);
        $horse_video = get_field('video_du_cheval', $post_id);
        $horse_description = get_field('horse_description', $post_id);
        $horse_features = get_field('horse_features', $post_id);
        $horse_reference = get_field('horse_reference', $post_id);

        $horse_thumbnail = get_field('image_du_cheval', $post_id);
        $first_image = get_field('horse_image_1', $post_id);
        $second_image = get_field('horse_image_2', $post_id);
        $third_image = get_field('horse_image_3', $post_id);
        $fourth_image = get_field('horse_image_4', $post_id);

        $horse_form = get_field('relation_to_form', $post_id);

        $horse_thumbnail = $horse_thumbnail ?: 'https://images.pexels.com/photos/635499/pexels-photo-635499.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1';
        $horse_name = $horse_name ?: get_the_title();

        ?>

        <main class="single-horse main-custom-content text-elementor-font">
            <section class="horse-story">
                <div class="story-images">
                    <div class="thumbnail-image-block">
                        <img src="<?php echo esc_url($horse_thumbnail); ?>" alt="<?php echo esc_attr($horse_name); ?>">
                    </div>
                    <?php if ($first_image && $second_image && $third_image): ?>
                    <div class="three-img-block">
                        <img  src="<?php echo esc_url($first_image['url']); ?>" alt="<?php echo esc_attr($horse_name); ?>"/>
                        <img  src="<?php echo esc_url($second_image['url']); ?>" alt="<?php echo esc_attr($horse_name); ?>"/>
                        <img  src="<?php echo esc_url($third_image['url']); ?>" alt=""/>
                    </div>
                    <?php endif; ?>

                    <?php if ($horse_video): ?>
                    <div class="video-block">
                        <?php echo $horse_video; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="horse-details-story">
                    <div class="horse-title-wrapper">
                        <h1 class="horse-title global-elementor-font"><?php echo esc_html($horse_name) ?></h1>
                        <div class="stars">
                            <?php for ($i = 0; $i < $star_number; $i++) : ?>
                                <span><i class="fa-solid fa-star"></i></span>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <?php if($horse_age && $horse_sex && $horse_race): ?>
                    <ul class="horse-main-feature">
                        <li>Race&nbsp;: <span><?php echo esc_html($horse_race); ?></span></li>
                        <li>Sex&nbsp;: <span><?php echo esc_html($horse_sex); ?></span></li>
                        <li>Age&nbsp;: <span><?php echo esc_html($horse_age); ?>&nbsp;an<?php echo $horse_age > 1 ? "s" : ""; ?> </span></li>
                    </ul>
                    <?php endif; ?>
                    <div class="horse-description-wrapper">
                        <h2 class="horse-sub-title global-elementor-font">Description</h2>
                        <?php echo $horse_description; ?>
                    </div>
                    <div class="horse-description-wrapper">
                        <h2 class="horse-sub-title global-elementor-font">Caractéristiques</h2>
                        <?php echo $horse_features; ?>
                    </div>
                    <div class="horse-description-wrapper price-wrapper">
                        <h2 class="horse-sub-title global-elementor-font">Prix</h2>
                        <div class="price"><span><?php echo $horse_price; ?></span>&nbsp;&euro;</div>
                    </div>
                </div>
            </section>
            <section class="horse-results">
                <div class="results-title">
                    <h1 class="title horse-section-title global-elementor-font">Classement top 100</h1>
                </div>

                <div class="accordeon-wrapper">
                    <div class="collapsible-accordion">
                        <div class="collapsible-item">
                            <input type="radio" id="rad1" name="radio">
                            <label class="collapsible-item-label" for="rad1">Classement Cheval - 2016 - CSO - Cycle Classique Chevaux - 6 ans SF/AA</label>
                            <div class="collapsible-item-content">
                                Total des gains 1 295,51 € -  Nombre de Sans Faute :7- Nombre d'épreuves :14- Finale :Qualifié ✅
                            </div>
                        </div>
                    </div>

                    <div class="collapsible-accordion">
                        <div class="collapsible-item">
                            <input type="radio" id="rad2" name="radio">
                            <label class="collapsible-item-label" for="rad2">Classement Cheval - 2015 - CSO - Cycle Classique Chevaux - 5 ans SF/AA</label>
                            <div class="collapsible-item-content">
                                Total des gains 1 295,51 € -  Nombre de Sans Faute :7- Nombre d'épreuves :14- Finale :Qualifié ✅
                            </div>
                        </div>
                    </div>

                    <div class="collapsible-accordion">
                        <div class="collapsible-item">
                            <input type="radio" id="rad3" name="radio">
                            <label class="collapsible-item-label" for="rad3">Classement Cheval - 2014 - CSO - Cycle Classique Chevaux - 4 ans SF/AA</label>
                            <div class="collapsible-item-content">
                                Total des gains 1 295,51 € -  Nombre de Sans Faute :7- Nombre d'épreuves :14- Finale :Qualifié ✅
                            </div>
                        </div>
                    </div>

                </div>
            </section>
            <section class="horse-contact">
                <div class="horse-contact-title">
                    <h2 class="title  horse-section-title global-elementor-font">Vous souhaitez plus d'information ?</h2>
                </div>
              <?php
                if ( $horse_form ) {
                $form_post = $horse_form[0];
                $form_id = $form_post->ID;
                $form_shortcode = '[contact-form-7 id="' . $form_id . '" title="' . esc_attr( $form_post->post_title ) . '"]';
                echo do_shortcode( $form_shortcode );
                } else {
                echo do_shortcode('[contact-form-7 id="c4cb2f6" title="Demande d\'information"]');;
                } ?>
            </section>
        </main>

    <?php
    endwhile;
endif;

get_footer();
