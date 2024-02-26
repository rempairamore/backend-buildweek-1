<?php get_header(); ?>

<main>


    <div class="container-fluid hero">
        <div id="carouselHome" class="carousel slide">


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

                    <article
                        class="single-article-home d-flex flex-column align-items-center align-items-lg-start col-12 col-lg-6 col-xxl-4 p-3 <?php ($count == 3) ? print("d-lg-none d-xxl-block") : "" ?>">
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
            galleryddd
            <div class="container">
                <!-- <div class="row">

                    <div class="col-lg-4 col-md-12 mb-4 mb-lg-0">
                        <img
                        src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(73).webp"
                        class="w-100 shadow-1-strong rounded mb-4"
                        alt="Boat on Calm Water"
                        />

                        <img
                        src="https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain1.webp"
                        class="w-100 shadow-1-strong rounded mb-4"
                        alt="Wintry Mountain Landscape"
                        />
                        <img
                        src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(73).webp"
                        class="w-100 shadow-1-strong rounded mb-4"
                        alt="Boat on Calm Water"
                        />

                        <img
                        src="https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain1.webp"
                        class="w-100 shadow-1-strong rounded mb-4"
                        alt="Wintry Mountain Landscape"
                        />
                    </div>

                    <div class="col-lg-4 mb-4 mb-lg-0">
                        <img
                        src="https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain2.webp"
                        class="w-100 shadow-1-strong rounded mb-4"
                        alt="Mountains in the Clouds"
                        />

                        <img
                        src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(73).webp"
                        class="w-100 shadow-1-strong rounded mb-4"
                        alt="Boat on Calm Water"
                        />
                        <img
                        src="https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain2.webp"
                        class="w-100 shadow-1-strong rounded mb-4"
                        alt="Mountains in the Clouds"
                        />

                        <img
                        src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(73).webp"
                        class="w-100 shadow-1-strong rounded mb-4"
                        alt="Boat on Calm Water"
                        />
                    </div>

                    <div class="col-lg-4 mb-4 mb-lg-0">
                        <img
                        src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(18).webp"
                        class="w-100 shadow-1-strong rounded mb-4"
                        alt="Waves at Sea"
                        />

                        <img
                        src="https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain3.webp"
                        class="w-100 shadow-1-strong rounded mb-4"
                        alt="Yosemite National Park"
                        />
                        <img
                        src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(18).webp"
                        class="w-100 shadow-1-strong rounded mb-4"
                        alt="Waves at Sea"
                        />

                        <img
                        src="https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain3.webp"
                        class="w-100 shadow-1-strong rounded mb-4"
                        alt="Yosemite National Park"
                        />
                    </div>


                </div> -->
                    <div class="movie-gallery mx-md-5 mb-5 mt-4">
                    <h5 class="text-light mt-2 mb-2">Trending Now</h5>
                        <div id="trending-now" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item">
                                    <div class="movie-row">
                                        <div class="row g-1">
                                            <div class="col-md-2">
                                                <img class="img-fluid movie-cover" src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(73).webp">
                                            </div>
                                            <div class="col-md-2">
                                                <img class="img-fluid movie-cover" src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(73).webp">
                                            </div>
                                            <div class="col-md-2">
                                                <img class="img-fluid movie-cover" src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(73).webp">
                                            </div>
                                            <div class="col-md-2">
                                                <img class="img-fluid movie-cover" src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(73).webp">
                                            </div>
                                            <div class="col-md-2">
                                                <img class="img-fluid movie-cover" src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(73).webp">
                                            </div>
                                            <div class="col-md-2">
                                                <img class="img-fluid movie-cover" src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(73).webp">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item active">
                                    <div class="movie-row">
                                        <div class="row g-1">
                                            <div class="col-md-2">
                                                <img class="img-fluid movie-cover" src="./assets/media/media0.jpg">
                                            </div>
                                            <div class="col-md-2">
                                                <img class="img-fluid movie-cover" src="./assets/media/media1.jpg">
                                            </div>
                                            <div class="col-md-2">
                                                <img class="img-fluid movie-cover" src="./assets/media/media2.jpg">
                                            </div>
                                            <div class="col-md-2">
                                                <img class="img-fluid movie-cover" src="./assets/media/media3.jpg">
                                            </div>
                                            <div class="col-md-2">
                                                <img class="img-fluid movie-cover" src="./assets/media/media4.jpg">
                                            </div>
                                            <div class="col-md-2">
                                                <img class="img-fluid movie-cover" src="./assets/media/media5.jpg">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#trending-now" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#trending-now" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>

                </div>
            </div>
        </section>

    </div>
    <h3>diodfvlòadfVB</h3>


</main>

<?php
get_footer();
?>