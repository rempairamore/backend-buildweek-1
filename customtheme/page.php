<?php
/**
 * The template for displaying individual pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-page
 *
 * @package YourTheme
 */

get_header();
?>

<header class="entry-header w-100">
    <?php if (has_post_thumbnail()): ?>
        <div class="featured-image w-100">
            <?php the_post_thumbnail('full'); ?>
        </div>
    <?php else: ?>
        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
    <?php endif; ?>
</header><!-- .entry-header -->


<div class="container  m-5 mx-auto pt-5">
    <!-- Main Content Area -->
    <main id="main" class="site-main">
        <?php
        // Start the loop.
        while (have_posts()):
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


                <div class="entry-content">
                    <?php the_content(); ?>
                </div><!-- .entry-content -->
            </article><!-- #post-<?php the_ID(); ?> -->

            <?php
            // End of the loop.
        endwhile;
        ?>
    </main><!-- #main -->

</div><!-- .container -->

<?php
get_footer();
?>
