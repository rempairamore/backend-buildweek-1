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

<div class="container mt-5">
    <div class="row">
        
        <div class="col-md-9">
            <!-- Main Content Area -->
            <main id="main" class="site-main">
                <?php
                // Start the loop.
                while (have_posts()) :
                    the_post();
                    the_content();
                    // Include the page content template.
                    get_template_part('template-parts/content', 'page');
                // End of the loop.
                endwhile;
                ?>
            </main><!-- #main -->
        </div>
        <div class="col-md-3">
            <!-- Left Sidebar with Search Bar -->
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
