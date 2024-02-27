<?php
    get_header();

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
                        if (have_posts()) {
                            while (have_posts()) {
                                the_post();
                    ?>
                        <div class="serach-article-content mb-5">
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p><?php echo '<div>Category: ' . get_the_category_list( ', ' ) . '</div>'; ?></p>
                            <p class="author">Autore: <?php the_author(); ?> <span><i class="bi bi-calendar-week"></i> <?php the_date("d-m-o"); ?></span></p>
                            <?php the_excerpt(); ?>
                            <?php
                            $tags = get_the_tags();
                            if ($tags) {
                                echo '<div>';
                                foreach ($tags as $tag) {
                                    echo '<a class="article-tag" href="' . esc_url(get_tag_link($tag->term_id)) . '">' . $tag->name . '</a> ';
                                }
                                echo '</div>';
                            }
                            ?>
                        </div>
                        <!-- Se i commenti sono abilitati o se ci sono almeno un commento, visualizzali -->
                    <?php
                        }
                    ?>
                    </div>
                    <div class="col-sm-4">
                        <?php dynamic_sidebar('right-sidebar'); ?>
                    </div>

                </div>
            </div> 
    <?php
        
    }
