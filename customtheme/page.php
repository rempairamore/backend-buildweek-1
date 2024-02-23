<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php
        // Loop principale di WordPress
        while (have_posts()) :
            the_post();
            the_title();
            // Contenuto della pagina
            the_content();

        endwhile; // Fine del loop principale
        ?>
    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>