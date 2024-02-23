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
        <div class="article-content">
            <?php 
            
            if (has_post_thumbnail()) {
                $content = apply_filters('the_content', get_the_content());
                $content = preg_replace('/<img[^>]+>/', '', $content, 1);
                echo '<div class="row cols-2"> 
                        <div class="col-8">' . $content . '</div>
                        <div class="col-4">' . get_sidebar() . '</div>
                      </div>';
            } else {
                the_content();
            }
            ?>
        </div>
        <?php
    }
}
?>


<?php get_footer(); ?>