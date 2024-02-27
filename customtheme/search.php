<?php
    get_header();

    global $wp_query;
    echo "<pre>";
    print_r($wp_query);
    echo "</pre>";
    if (have_posts()) {
        while (have_posts()) {
            the_post();
?>
            <div style="position: relative;">
            
                    <img class="imgArticle" src="https://www.google.com/url?sa=i&url=https%3A%2F%2Fviaggi.corriere.it%2Feuropa%2Fislanda%2F&psig=AOvVaw02v5NBOA1SZcxhz0FseSjk&ust=1709117229220000&source=images&cd=vfe&opi=89978449&ved=0CBIQjRxqFwoTCIC8kvyry4QDFQAAAAAdAAAAABAE" alt="...">
             
                <div class="titoloArticolo text-center position-absolute bottom-0 start-0 w-100">
                    <h1><?php echo $wp_query->query->s; ?></h1>
                </div>
            </div>

            <div class="container">
                <div class="row p-5">
                    <div class="col-sm-8">
                        <div class="article-content">
                            <?php the_title(); ?>
                           
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
