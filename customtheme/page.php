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

<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-9">
            <!-- Main Content Area -->
            <main id="main" class="site-main">
                <?php
                // Start the loop.
                while (have_posts()) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="featured-image">
                                    <?php the_post_thumbnail('full'); ?>
                                </div>
                            <?php endif; ?>
                        </header><!-- .entry-header -->

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
        <div class="col-md-3">
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
