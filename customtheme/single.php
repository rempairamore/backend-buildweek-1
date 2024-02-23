<?php get_header(); ?>

<?php
if (have_posts()) {
    while (have_posts()) {
        the_post();
        ?>
        <div style="position: relative;">
        <img class="imgArticle" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="...">
        <div>
        <h1 class="articleTitle fw-bold text-light"><?php the_title(); ?></h1>
            </div>
        </div>
        <div class="article-content">
            <?php the_content(); ?>
        </div>
        <?php
    }
}
?>

<?php get_footer(); ?>