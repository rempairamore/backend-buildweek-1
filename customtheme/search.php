<?php
    get_header();

    global $wp_query;
    // echo "<pre>";
    // print_r($wp_query);
    // echo "</pre>";
    if (have_posts()) {
        while (have_posts()) {
            the_post();
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
