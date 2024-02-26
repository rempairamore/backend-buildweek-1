<?php
$post_type = get_post_type();

if ($post_type != 'servizi') {
    get_header();

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
            <div class="row mt-5">
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
}

if ($post_type == "servizi") {

    $service_title = get_post_meta(get_the_ID(), 'service_title', true);
    
    $cosaVedereTitolo1 = get_post_meta(get_the_ID(), 'cosa_vedere_titolo_1', true);
    $cosaVedereTitolo2 = get_post_meta(get_the_ID(), 'cosa_vedere_titolo_2', true);
    $cosaVedereTitolo3 = get_post_meta(get_the_ID(), 'cosa_vedere_titolo_3', true);
    $cosaVedereTitolo4 = get_post_meta(get_the_ID(), 'cosa_vedere_titolo_4', true);
    
    $cosaVedereDescrizione1 = get_post_meta(get_the_ID(), 'cosa_vedere_descrizione_1', true);
    $cosaVedereDescrizione2 = get_post_meta(get_the_ID(), 'cosa_vedere_descrizione_2', true);
    $cosaVedereDescrizione3 = get_post_meta(get_the_ID(), 'cosa_vedere_descrizione_3', true);
    $cosaVedereDescrizione4 = get_post_meta(get_the_ID(), 'cosa_vedere_descrizione_4', true);
    
    $cosaVedereImmagine1_id = get_post_meta(get_the_ID(), 'cosa_vedere_image_1', true);
    $cosaVedereImmagine2_id = get_post_meta(get_the_ID(), 'cosa_vedere_image_2', true);
    $cosaVedereImmagine3_id = get_post_meta(get_the_ID(), 'cosa_vedere_image_3', true);
    $cosaVedereImmagine4_id = get_post_meta(get_the_ID(), 'cosa_vedere_image_4', true);

    $cosaVedereImmagine1_url = wp_get_attachment_image_url($cosaVedereImmagine1_id, 'full');
    $cosaVedereImmagine2_url = wp_get_attachment_image_url($cosaVedereImmagine2_id, 'full');
    $cosaVedereImmagine3_url = wp_get_attachment_image_url($cosaVedereImmagine3_id, 'full');
    $cosaVedereImmagine4_url = wp_get_attachment_image_url($cosaVedereImmagine4_id, 'full');






    ?>



    <?php get_header(); ?>
    <div style="position: relative;">
        <img class="imgArticle" src="https://www.ilturista.info/repo/images/no/isole-canarie.jpg" class="card-img" alt="...">
        <div>
            <h1 class="articleTitle fw-bold text-light"><?php echo esc_html($service_title); ?></h1>

        </div>
    </div>
    <nav class="navbar navbar-expand-lg bg-body-light navbarArticle">
        <div class="container-fluid text-center">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link pageLink" aria-current="page" href="#vedere">Cosa vedere</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ms-sm-0 ms-md-0 ms-lg-5 pageLink" aria-current="page" href="#mangiare">Cosa mangiare</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-sm-0 mx-md-0 mx-lg-5 pageLink" href="#localita">Località</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pageLink" href="#info">Info</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container text-center mt-5">
        <h1 id="vedere">Cosa vedere</h1>
        <h5 class="text-muted">Qui trovi una selezione delle migliori attrazioni culturali da visitare</h5>
    </div>

    <div class="container d-flex justify-content-center mt-5">
        <div class="row rowVedere row-sm-cols-1 row-md-cols-2 row-lg-cols-2 g-5 justify-content-center">
            <div class="col">
                <div class="card shadow-sm h-100" style="width: 18rem;">
                   
                
                <img src=" <?= esc_url($cosaVedereImmagine1_url) ?> " class="card-img-top h-100" alt="..."> 
                
                <div class="card-body">
                        <h5><?php echo esc_html($cosaVedereTitolo1); ?></h5>
                        <p class="card-text text-muted"><?php echo esc_html($cosaVedereDescrizione1); ?></p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-sm h-100" style="width: 18rem;">
                <img src=" <?= esc_url($cosaVedereImmagine2_url) ?> " class="card-img-top h-100" alt="..."> 
                    <div class="card-body">
                        <h5><?php echo esc_html($cosaVedereTitolo2); ?></h5>
                        <p class="card-text text-muted"><?php echo esc_html($cosaVedereDescrizione2); ?></p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-sm h-100" style="width: 18rem;">
                <img src=" <?= esc_url($cosaVedereImmagine3_url) ?> " class="card-img-top h-100" alt="..."> 
                    <div class="card-body">
                        <h5><?php echo esc_html($cosaVedereTitolo3); ?></h5>
                        <p class="card-text text-muted"><?php echo esc_html($cosaVedereDescrizione3); ?></p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-sm h-100" style="width: 18rem;">
                <img src=" <?= esc_url($cosaVedereImmagine4_url) ?> " class="card-img-top h-100" alt="..."> 
                    <div class="card-body">
                        <h5><?php echo esc_html($cosaVedereTitolo4); ?></h5>
                        <p class="card-text text-muted"><?php echo esc_html($cosaVedereDescrizione4); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="carouselExampleControls" class="carousel slide mt-5" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item itemCibo active">
                <div id="mangiare" class="container-fluid ciboContainer text-light mt-5">
                    <div class="row rowCibo d-flex" id="cibo">
                        <div class="col">
                            <img src="https://static2-viaggi.corriereobjects.it/wp-content/uploads/2023/05/canarie-cosa-vedere-cosa-fare.jpg?v=1683531579" class="rounded-3 imgCibo" alt="...">
                        </div>
                        <div class="col colP">
                            <h5>Cosa mangiare</h5>
                            <h3 class="pt-3">Qualcosa</h3>
                            <p class="text-justify mt-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam laborum magnam nobis cupiditate ea natus nisi iusto, illo quam earum laboriosam. Quis illo nemo nobis officia ut debitis officiis consectetur? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore dolores nobis eligendi dolorum, corrupti vel excepturi repellendus laudantium maxime laborum itaque quia quae velit facilis quas quasi deleniti quibusdam accusamus!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item itemCibo">
                <div id="mangiare" class="container-fluid ciboContainer text-light mt-5">
                    <div class="row rowCibo d-flex" id="cibo">
                        <div class="col">
                            <img src="https://www.viggiviaggi.com/wp-content/uploads/2021/06/IMG_20200811_131449-scaled.jpg" class="rounded-3 imgCibo" alt="...">
                        </div>
                        <div class="col colP">
                            <h5>Cosa mangiare</h5>
                            <h3 class="pt-3">Qualcosina</h3>
                            <p class="text-justify mt-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore dolores nobis eligendi dolorum, corrupti vel excepturi repellendus laudantium maxime laborum itaque quia quae velit facilis quas quasi deleniti quibusdam accusamus!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div id="mangiare" class="container-fluid ciboContainer text-light mt-5">
                    <div class="row rowCibo d-flex" id="cibo">
                        <div class="col">
                            <img src="https://images.placesonline.com/photos/424012810201124_Jameos_1763008766.jpg?quality=80&w=700" class="rounded-3 imgCibo" alt="...">
                        </div>
                        <div class="col colP">
                            <h5>Cosa mangiare</h5>
                            <h3 class="pt-3">Nulla</h3>
                            <p class="text-justify mt-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore dolores nobis eligendi dolorum, corrupti vel excepturi repellendus laudantium maxime laborum itaque quia quae velit facilis quas quasi deleniti quibusdam accusamus!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>



    <div class="container text-center mt-5">
        <h1 id="localita">Località</h1>
        <h5 class="text-muted">Qui trovi una selezione delle migliori mete da visitare</h5>
    </div>

    <div class="container d-flex justify-content-center mt-5">
        <div class="row row-sm-cols-1 row-md-cols-2 row-lg-cols-2 g-5 align-items-">
            <div class="col">
                <div class="card shadow-sm h-100" style="width: 18rem;">
                    <img src="https://static2-viaggi.corriereobjects.it/wp-content/uploads/2023/05/canarie-cosa-vedere-cosa-fare.jpg?v=1683531579" class="card-img-top h-100" alt="...">
                    <div class="card-body">
                        <h5>Gran canaria</h5>
                        <p class="card-text text-muted">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-sm h-100" style="width: 18rem;">
                    <img src="https://images.placesonline.com/photos/424012810201124_Jameos_1763008766.jpg?quality=80&w=700" class="card-img-top h-100" alt="...">
                    <div class="card-body">
                        <h5>Tenerife</h5>
                        <p class="card-text text-muted">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-sm h-100" style="width: 18rem;">
                    <img src="https://allecanarie.it/wp-content/uploads/2023/01/cosa-vedere-a-gran-canaria-in-7-giorni.jpg" class="card-img-top h-100" alt="...">
                    <div class="card-body">
                        <h5>Lanzarote</h5>
                        <p class="card-text text-muted">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-sm h-100" style="width: 18rem;">
                    <img src="https://allecanarie.it/wp-content/uploads/2023/01/cosa-vedere-a-gran-canaria-in-7-giorni.jpg" class="card-img-top h-100" alt="...">
                    <div class="card-body">
                        <h5>Fuerteventura</h5>
                        <p class="card-text text-muted">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container text-center mt-5">
        <h1 id="info">Info utili</h1>
        <h5 class="text-muted">Prepara al meglio il tuo viaggio!</h5>
    </div>

    <div class="container d-flex justify-content-center mt-5 text-center">
        <div class="row row-sm-cols-1 row-md-cols-2 row-lg-cols-2 g-5 align-items-stretch justify-content-between text-center">
            <div class="col">
                <img src="https://www.iconbunny.com/icons/media/catalog/product/1/5/1552.9-identity-card-icon-iconbunny.jpg" style="width: 5rem;">
                <h5 class="mt-2">Documenti</h5>
                <p style="white-space: nowrap;">Carta di identità</p>
            </div>
            <div class="col mx-sm-0 mx-md-0 mx-lg-5">
                <img src="https://static.vecteezy.com/ti/vettori-gratis/p1/8907246-fuso-orario-linea-cerchio-sfondo-icona-vettoriale.jpg" style="width: 5rem; white-space: nowrap;">
                <h5 class="mt-2">Orario</h5>
                <p style="white-space: nowrap;">-1 ora</p>
            </div>
            <div class="col me-sm-0 me-md-0 me-lg-5">
                <img src="https://icon-library.com/images/languages-icon/languages-icon-3.jpg" style="width: 5rem;">
                <h5 class="mt-2">Lingua</h5>
                <p style="white-space: nowrap;">Spagnolo</p>
            </div>
            <div class="col">
                <img src="https://png.pngtree.com/png-vector/20190507/ourmid/pngtree-vector-wallet-icon-png-image_1025642.jpg" style="width: 5rem;">
                <h5 class="mt-2">Valuta</h5>
                <p style="white-space: nowrap;">Dollaro ($)</p>
            </div>
        </div>
    </div>
<?php
}
?>
<?php get_footer(); ?>