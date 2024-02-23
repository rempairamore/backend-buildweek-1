<?php get_header(); ?>

<main>



    <div class="container-fluid hero">
        <div id="carouselHome" class="carousel slide">

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <h3>Titolo 1 trenta</h3>
                    <img src="..." class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <h3>Titolo 2</h3>
                    <img src="..." class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <h3>Titolo 3</h3>
                    <img src="..." class="d-block w-100" alt="...">
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
        <section class="articoli d-flex container row">

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
                    $custom_query->the_post();?>
                    <article class="single-article-home col-12 col-lg-6 col-xxl-4 p-3 <?php ($count == 3) ? print("d-lg-none d-xxl-block") : ""?>">
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