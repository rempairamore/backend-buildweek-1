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
            if (have_posts()) {
                while (have_posts()) {
                    the_post(); ?>
                    <article class="single-article-home d-flex col-12 col-lg-4">
                        <div class="article-thumbnail-home">
                            <?php the_post_thumbnail(); ?>
                        </div>
                        <div>
                            <h5><?php the_title(); ?></h5>
                            <p><?php the_excerpt(); ?></p>
                        </div>
                    </article>

            <?php

                }
            }
            ?>
            <article class="single-article-home d-flex col-12 col-lg-4">
                <div class="article-thumbnail-home">

                </div>
                <div>
                    <h5>titolo articolo</h5>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Magni dolore facere qui, optio ducimus fugiat similique quia iure nesciunt veritatis dolorum eligendi reprehenderit incidunt labore earum asperiores nemo eveniet ea.</p>
                </div>
            </article>
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