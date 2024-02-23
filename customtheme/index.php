<?php get_header(); ?>

<main>
   
<?php
// Recupera l'ID della pagina che contiene le immagini del carousel
$carousel_page_id = 129; // Sostituisci 123 con l'ID effettivo della pagina

// Recupera gli ID delle immagini caricate come allegati della pagina
$image1_id = get_post_meta($carousel_page_id, 'image1_id', true);
$image2_id = get_post_meta($carousel_page_id, 'image2_id', true);
$image3_id = get_post_meta($carousel_page_id, 'image3_id', true);

// Ottieni le URL delle immagini utilizzando gli ID degli allegati
$image1_url = wp_get_attachment_image_src($image1_id, 'full')[0];
$image2_url = wp_get_attachment_image_src($image2_id, 'full')[0];
$image3_url = wp_get_attachment_image_src($image3_id, 'full')[0];
?>
    <div class="container-fluid hero">
        <div id="carouselHome" class="carousel slide">

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
                'order'          => 'DESC', // Order posts in descending order (latest posts first)
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
                            <h5 class="article-title-home"><?php the_title(); ?></h5>
                            <p class="article-author-home"><?php the_author(); ?></p>
                            <span class="ms-2"><a class="article-link-home" href="<?php the_permalink(); ?>"> ...leggi</a></span>
                        </div>
                    </article>


            <?php   }
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