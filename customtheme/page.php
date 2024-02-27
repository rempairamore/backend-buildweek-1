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

<?php
$current_page_title = get_the_title();

if (strtolower($current_page_title) === 'blog') {


    // Define custom query parameters
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 5, // Number of posts per page
        'paged' => $paged // Current page number
    );

    // Instantiate custom query
    $query = new WP_Query($args);
    global $wp_query;
    // echo "<pre>";
    // print_r($wp_query);
    // echo "</pre>";
?>
    <div style="position: relative;">

        <img class="imgArticle" src="https://static2-viaggi.corriereobjects.it/wp-content/uploads/2015/06/kirkjufell-islanda-istock.jpg.webp?v=1689967365" alt="...">

        <div class="titoloArticolo text-center position-absolute bottom-0 start-0 w-100">
            <h1><?php echo $wp_query->query->s; ?></h1>
        </div>
    </div>


    <div class="container">
        <div class="row p-5">
            <div class="col-sm-8">
                <?php
                // Output posts
                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
                ?>
                        <div class="serach-article-content">
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p><?php echo '<div>Categoria: ' . get_the_category_list(', ') . '</div>'; ?></p>

                            <div class="mb-2">
                                <?php
                                $tags = get_the_tags();
                                if ($tags) {
                                    echo '<div>';
                                    foreach ($tags as $tag) {
                                        echo '<a class="article-tag" href="' . esc_url(get_tag_link($tag->term_id)) . '">'  . '<span class="badge text-bg-success">' . $tag->name . '</span>' . '</a> ';
                                    }
                                    echo '</div>';
                                }
                                ?>
                            </div>

                            <?php the_excerpt(); ?>

                            <div class="author d-flex justify-content-between">
                                <p>Autore: <?php the_author(); ?></p>
                                <p><i class="bi bi-calendar-week"></i> <?php the_date("d-m-o"); ?></p>
                            </div>
                        </div>
                <?php
                    endwhile;

                    // Custom pagination
                    echo '<div class="pagination">';
                    echo paginate_links(array(
                        'total' => $query->max_num_pages,
                        'current' => max(1, get_query_var('paged')),
                        'prev_text' => ('« Previous'),
                        'next_text' => ('Next »'),
                    ));
                    echo '</div>';

                    // Reset post data
                    wp_reset_postdata();
                else :
                    // No posts found
                    echo 'No posts found';
                endif;
                ?>


            </div>
            <div class="col-sm-4">
                <?php dynamic_sidebar('right-sidebar'); ?>
            </div>

        </div>
    </div>
<?php


} else { ?>
    <div style="position: relative;">

        <img class="imgArticle" src="https://static2-viaggi.corriereobjects.it/wp-content/uploads/2015/06/kirkjufell-islanda-istock.jpg.webp?v=1689967365" alt="...">

        <div class="titoloArticolo text-center position-absolute bottom-0 start-0 w-100">
            <h1><?php echo $wp_query->query->s; ?></h1>
        </div>
    </div>


    <div class="container">
        <div class="row p-5">
            <div class="col-sm-8">
                <?php the_content();  ?>
            </div>
            <div class="col-sm-4">
                <?php dynamic_sidebar('right-sidebar'); ?>
            </div>

        </div>
    </div>
<?php
}
?>
<?php get_footer(); ?>