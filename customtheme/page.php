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

<header class="entry-header position-relative">
    <?php if (has_post_thumbnail()): ?>
        <div class="featured-image position-relative">
            <?php the_post_thumbnail('full'); ?>
            <div class="overlay d-flex justify-content-center align-items-center">
                <?php the_title('<h1 class="entry-title text-center">', '</h1>'); ?>
            </div>
        </div>
    <?php else: ?>
        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
    <?php endif; ?>
</header><!-- .entry-header -->


<div class="container mt-5 pt-5">

    <div class="row">
        <div class="col-md-7">
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
        </div>
        <div class="col-md-5">
            <!-- Right Sidebar -->
            <div id="sidebar">
                <div id="sidebar-widget">
                    <?php
                    if (is_active_sidebar('right-sidebar')) {
                        dynamic_sidebar('right-sidebar');
                    }
                    ?>
                </div>
            </div>
        </div>
    </div><!-- .row -->
</div><!-- .container -->

<?php
get_footer();
?>