<?php
$post_type = get_post_type();

if ($post_type == 'page') {
    get_header();

    if (have_posts()) {
        while (have_posts()) {
            the_post();
?>
            <div style="position: relative;">
                <?php if (has_post_thumbnail()) { ?>
                    <img class="imgArticle" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="...">
                <?php } ?>
                <div class="titoloArticolo text-center position-absolute bottom-0 start-0 w-100">
                    <h1><?php the_title(); ?></h1>serach
                </div>
            </div>

            <div class="container">
                <div class="row p-5">
                    <div class="col-sm-8">
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
                    <div class="col-sm-4">
                        <?php dynamic_sidebar('right-sidebar'); ?>
                    </div>

                </div>
            </div>
    <?php
        }
    }
}