<?php get_header(); ?>

<main>


    <div class="hero overflow-hidden m-0 p-0 relative">

        <h1>Maldive</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus magni doloremque incidunt excepturi provident commodi officiis deleniti molestiae, sequi in deserunt ipsum quae praesentium eius fugit similique adipisci, sed obcaecati dolores reiciendis nulla, exercitationem blanditiis. Facere eaque commodi ipsa id?</p>
        <div id="carouselHome" class="carousel slide" data-bs-ride="carousel">


            <?php
            global $wpdb;
            $table_name = $wpdb->prefix . 'immagini_carosello';

            $image1_url = urldecode($wpdb->get_var($wpdb->prepare("SELECT image_url FROM $table_name WHERE image_name = %s", 'image_1')));
            $image2_url = urldecode($wpdb->get_var($wpdb->prepare("SELECT image_url FROM $table_name WHERE image_name = %s", 'image_2')));
            $image3_url = urldecode($wpdb->get_var($wpdb->prepare("SELECT image_url FROM $table_name WHERE image_name = %s", 'image_3')));
            ?>

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="<?php echo esc_url($image1_url); ?>" class="d-block w-100" alt="Immagine 1">
                </div>
                <div class="carousel-item">
                    <img src="<?php echo esc_url($image2_url); ?>" class="d-block w-100" alt="Immagine 2">
                </div>
                <div class="carousel-item">
                    <img src="<?php echo esc_url($image3_url); ?>" class="d-block w-100" alt="Immagine 3">
                </div>
            </div>


            <button class="carousel-control-prev" type="button" data-bs-target="#carouselHome" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselHome" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>


    <section class="promozioni">

    </section>


    <div class="griglia">
        <section class="articoli d-flex row justify-content-evenly px-5">

            <?php
            $args = array(
                'posts_per_page' => 3, // Retrieve only 3 posts
                'order' => 'DESC', // Order posts in descending order (latest posts first)
            );

            $custom_query = new WP_Query($args);

            if ($custom_query->have_posts()) {
                $count = 0;
                while ($custom_query->have_posts()) {
                    $count++;
                    $custom_query->the_post(); ?>

                    <article class="single-article-home d-flex flex-column align-items-center align-items-lg-start col-12 col-lg-6 col-xxl-4 p-3 <?php ($count == 3) ? print("d-lg-none d-xxl-block") : "" ?>">
                        <div class="article-thumbnail-home">
                            <?php
                            the_post_thumbnail('custom-size-thumbnail');
                            ?>
                        </div>
                        <div class="p-2 article-info-home">
                            <h5 class="article-title-home">
                                <?php the_title(); ?>
                            </h5>
                            <p class="article-author-home">
                                <?php the_author(); ?>
                            </p>
                            <span class="ms-2"><a class="article-link-home" href="<?php the_permalink(); ?>">
                                    ...leggi</a></span>
                        </div>
                    </article>


            <?php }
            }
            ?>



        </section>
        <aside class="side text-center">
            <?php
            get_sidebar();
            ?>

        </aside>
        <section class="gallery text-center">
            gallery
        </section>

    </div>
    <h3>diodfvlòadfVB</h3>


</main>

<?php
get_footer();
?>