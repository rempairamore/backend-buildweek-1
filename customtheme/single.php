<?php get_header(); ?>

<?php
if (have_posts()) {
    while (have_posts()) {
        the_post();
?>
        <div style="position: relative;">
            <?php if (has_post_thumbnail()) { ?>
                <img class="imgArticle" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="...">
            <?php } ?>
            <div>
                <h1 class="articleTitle fw-bold text-light"><?php the_title(); ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <div class="article-content">
                    <?php
                    if (has_post_thumbnail()) {
                        $content = apply_filters('the_content', get_the_content());
                        $content = preg_replace('/<img[^>]+>/', '', $content, 1);
                        echo $content;
                    } else {
                        the_content();
                    }
                    ?>
                </div>
            </div>
            <div class="col-4">
                <?php get_sidebar(); ?>
            </div>
        </div>
<?php
    }
}
?>

<?php get_footer(); ?>