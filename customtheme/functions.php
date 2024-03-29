<?php
// STYLE E SCRIPTS
function load_bootstrap()
{
    // carica lo stile css di bootstrap
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css');
    wp_enqueue_style('custom-style', get_template_directory_uri() . '/assets/css/custom-style.css'); // vado a leggere un eventuale file CSS custom
}
function load_bootstrap_scripts()
{
    // carica lo script js di bootstrap
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js');
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/assets/js/custom-script.js'); // vado a leggere un eventuale file CSS custom
}

add_action('wp_enqueue_scripts', 'load_bootstrap');
add_action('wp_enqueue_scripts', 'load_bootstrap_scripts');


// end style e scripts

// ADD FEATURES

function ale_theme_support()
{
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
}

add_action('after_setup_theme', 'ale_theme_support');

add_image_size('custom-size-thumbnail', 280, 180);

//end add features



// Immagini per carosello
// Aggiungi campi personalizzati nel pannello amministratore per selezionare le immagini dalla libreria multimediale
add_action('add_meta_boxes', 'custom_image_meta_box');
function custom_image_meta_box()
{
    add_meta_box(
        'custom_image_meta_box',
        'Seleziona le immagini per il carosello',
        'render_custom_image_meta_box',
        'page', // Cambia 'page' con il tipo di post dove desideri che compaia la meta box
        'normal',
        'default'
    );
}

// Renderizza il contenuto della meta box
function render_custom_image_meta_box($post)
{
    // Recupera gli ID delle immagini salvati come metadati del post
    $image1_id = get_post_meta($post->ID, 'image1_id', true);
    $image2_id = get_post_meta($post->ID, 'image2_id', true);
    $image3_id = get_post_meta($post->ID, 'image3_id', true);
?>
    <p>Seleziona le immagini per il carosello:</p>
    <input type="button" id="upload_image_button1" class="button" value="Carica/Seleziona Immagine 1">
    <input type="hidden" id="image1_id" name="image1_id" value="<?php echo esc_attr($image1_id); ?>">
    <div id="image1_preview"><?php echo wp_get_attachment_image($image1_id, 'thumbnail'); ?></div>
    <input type="button" id="upload_image_button2" class="button" value="Carica/Seleziona Immagine 2">
    <input type="hidden" id="image2_id" name="image2_id" value="<?php echo esc_attr($image2_id); ?>">
    <div id="image2_preview"><?php echo wp_get_attachment_image($image2_id, 'thumbnail'); ?></div>
    <input type="button" id="upload_image_button3" class="button" value="Carica/Seleziona Immagine 3">
    <input type="hidden" id="image3_id" name="image3_id" value="<?php echo esc_attr($image3_id); ?>">
    <div id="image3_preview"><?php echo wp_get_attachment_image($image3_id, 'thumbnail'); ?></div>

    <script>
        jQuery(document).ready(function($) {
            $('#upload_image_button1').click(function() {
                var send_attachment_bkp = wp.media.editor.send.attachment;
                wp.media.editor.send.attachment = function(props, attachment) {
                    $('#image1_id').val(attachment.id);
                    $('#image1_preview').html('<img src="' + attachment.url + '" />');
                    wp.media.editor.send.attachment = send_attachment_bkp;
                }
                wp.media.editor.open($(this));
                return false;
            });

            $('#upload_image_button2').click(function() {
                var send_attachment_bkp = wp.media.editor.send.attachment;
                wp.media.editor.send.attachment = function(props, attachment) {
                    $('#image2_id').val(attachment.id);
                    $('#image2_preview').html('<img src="' + attachment.url + '" />');
                    wp.media.editor.send.attachment = send_attachment_bkp;
                }
                wp.media.editor.open($(this));
                return false;
            });

            $('#upload_image_button3').click(function() {
                var send_attachment_bkp = wp.media.editor.send.attachment;
                wp.media.editor.send.attachment = function(props, attachment) {
                    $('#image3_id').val(attachment.id);
                    $('#image3_preview').html('<img src="' + attachment.url + '" />');
                    wp.media.editor.send.attachment = send_attachment_bkp;
                }
                wp.media.editor.open($(this));
                return false;
            });
        });
    </script>
<?php
}

// Salva gli ID delle immagini come metadati del post
add_action('save_post', 'save_custom_image_meta_data');
function save_custom_image_meta_data($post_id)
{
    if (isset($_POST['image1_id'])) {
        update_post_meta($post_id, 'image1_id', esc_attr($_POST['image1_id']));
    }
    if (isset($_POST['image2_id'])) {
        update_post_meta($post_id, 'image2_id', esc_attr($_POST['image2_id']));
    }
    if (isset($_POST['image3_id'])) {
        update_post_meta($post_id, 'image3_id', esc_attr($_POST['image3_id']));
    }
}

// end immagini per carosello


// MENU

function gruppo4_menus()
{
    $locations = array(
        'primary' => 'Primary Menu',
        'footer' => 'Footer Menu'
    );
    register_nav_menus($locations);
}
add_action('init', 'gruppo4_menus');



class Bootstrap_5_WP_Nav_Menu_Walker extends Walker_Nav_Menu
{
    function start_lvl(&$output, $depth = 0, $args = null)
    {
        if ($depth > 0) {
            return;
        }
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        if (strcasecmp($item->attr_title, 'divider') == 0 && $depth === 1) {
            $output .= '<li class="dropdown-divider">';
            return;
        } elseif (strcasecmp($item->title, 'divider') == 0 && $depth === 1) {
            $output .= '<li class="dropdown-divider">';
            return;
        }
        if (strcasecmp($item->attr_title, 'dropdown-header') == 0 && $depth === 1) {
            $output .= '<li class="dropdown-header">' . esc_attr($item->title);
            return;
        } elseif (strcasecmp($item->title, 'dropdown-header') == 0 && $depth === 1) {
            $output .= '<li class="dropdown-header">' . esc_attr($item->title);
            return;
        }

        // Aggiungi le classi nav-item e nav-link
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'nav-item';

        $output .= '<li class="' . esc_attr(implode(' ', $classes)) . '">';

        $atts = array();
        $atts['class'] = 'nav-link'; // Aggiungi la classe nav-link
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target)     ? $item->target     : '';
        $atts['rel']    = !empty($item->xfn)        ? $item->xfn        : '';
        $atts['href']   = !empty($item->url)        ? $item->url        : '';

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

// end menu

// ----------------------------------------------------------------------wp-10 ------------------------------------------------------
function customtheme_register_sidebar()
{
    register_sidebar(
        array(
            'name' => __('Right Sidebar', 'customtheme'),
            'id' => 'right-sidebar',
            'description' => __('Widgets in this area will be displayed on the right side of the page.', 'customtheme'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        )
    );
}
add_action('widgets_init', 'customtheme_register_sidebar');

// Modify content to add wrapper elements
function modify_content_animations($content)
{
    // Add wrapper elements
    $content = preg_replace('/(<img.*?>)/', '<div class="custom-image-wrapper">$1</div>', $content);
    $content = preg_replace('/(<ul>|<ol>.*?<\/ol>)/s', '<div class="custom-list-wrapper">$1</div>', $content);
    $content = preg_replace('/(<article>.*?<\/article>)/s', '<div class="custom-article-wrapper">$1</div>', $content);

    return $content;
}
add_filter('the_content', 'modify_content_animations');


// Modify content to convert gallery into carousel
function convert_gallery_to_carousel($content)
{
    // Find galleries in the content
    preg_match_all('/\[gallery.*ids=.(.*).\]/', $content, $matches);

    // Check if there are any galleries found
    if (!empty($matches[1])) {
        foreach ($matches[1] as $ids) {
            $ids_array = explode(',', $ids);
            $carousel_items = '';
            foreach ($ids_array as $id) {
                // Get image URL
                $image_url = wp_get_attachment_image_src($id, 'large')[0];
                // Generate carousel item HTML
                $carousel_items .= '<div class="carousel-item"><img src="' . esc_url($image_url) . '" class="d-block w-100" alt=""></div>';
            }
            // Replace gallery shortcode with carousel HTML
            $carousel_html = '<div id="gallery-carousel" class="carousel slide" data-ride="carousel"><div class="carousel-inner">' . $carousel_items .
                '</div><a class="carousel-control-prev" href="#gallery-carousel" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span></a><a class="carousel-control-next" href="#gallery-carousel" role="button" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span></a></div>';
            $content = str_replace('[gallery ids="' . $ids . '"]', $carousel_html, $content);
        }
    }

    return $content;
}
add_filter('the_content', 'convert_gallery_to_carousel');





//----------------------------------------------------------------end wp-10---------------------------------------------------------------



function custom_post_types()
{
    register_post_type('servizi', array(
        'labels' => array(
            'name' => 'Servizi',
            'singular_name' => 'Servizi',
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comment')
    ));
}

add_action('init', 'custom_post_types');

?>

<?php
function registra_metabox_servizi()
{
    add_meta_box(
        "servizi_metabox",
        "Modifica Servizi",
        "callback_riempi_servizi",
        "servizi",
        "normal",
        "high"
    );
}
add_action("add_meta_boxes_servizi", "registra_metabox_servizi");


function callback_riempi_servizi($post)
{
    wp_nonce_field(basename(__FILE__), 'servizi_nonce');
?>
    <div>
        <h4>Titolo</h4>
        <br>
        <?php $titolo = get_post_meta($post->ID, "service_title", true); ?>
        <input type="text" name="title" id="title" value="<?= $titolo ?>">
        <br>
        <br>

        <div class="cosa-vedere-container-box" style="border: 1px solid black;padding: 1rem;">
            <h4>Cosa vedere</h4>
            <div style="display: flex; flex-wrap: wrap;">
                <div class="cosa-vedere-box" style="border: 1px solid black;padding: 1rem;margin: 0.25rem">
                    <label for="cosa_vedere_titolo_1">Titolo 1</label>
                    <br>
                    <?php $cosaVedereTitolo1 = get_post_meta($post->ID, "cosa_vedere_titolo_1", true); ?>
                    <input type="text" name="cosa_vedere_titolo_1" id="cosa_vedere_titolo_1" value="<?= $cosaVedereTitolo1 ?>">
                    <br>
                    <label for="cosa_vedere_descrizione_1">Descrizione 1</label>
                    <br>
                    <?php $cosaVedereDescrizione1 = get_post_meta($post->ID, "cosa_vedere_descrizione_1", true); ?>
                    <input type="text" name="cosa_vedere_descrizione_1" id="cosa_vedere_descrizione_1" value="<?= $cosaVedereDescrizione1 ?>">
                    <br>
                    <br>

                    <?php
                    $cosa_vedere_image_1 = get_post_meta($post->ID, 'cosa_vedere_image_1', true);
                    $cosa_vedere_image_url_1 = wp_get_attachment_image_url($cosa_vedere_image_1, 'thumbnail');
                    ?>
                    <div class="custom-image-container">
                        <div class="image-preview-1">
                            <?php if ($cosa_vedere_image_url_1) : ?>
                                <img src="<?php echo esc_url($cosa_vedere_image_url_1); ?>" alt="Custom Image" style="max-width: 200px; max-height: 100px;">
                            <?php endif; ?>
                        </div>
                        <input type="hidden" name="cosa_vedere_image_1" id="cosa_vedere_image_1" value="<?php echo esc_attr($cosa_vedere_image_1); ?>">
                        <button type="button" class="button button-primary" id="cosa_fare_image_button_1">Carica Immagine</button>
                    </div>
                    <script>
                        jQuery(document).ready(function($) {
                            // Upload dell'immagine
                            $('#cosa_fare_image_button_1').click(function(e) {
                                e.preventDefault();
                                var custom_uploader = wp.media({
                                    title: 'Carica Immagine',
                                    button: {
                                        text: 'Seleziona Immagine'
                                    },
                                    multiple: false
                                });
                                custom_uploader.on('select', function() {
                                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                                    $('#cosa_vedere_image_1').val(attachment.id);
                                    $('.image-preview-1 img').attr('src', attachment.url);
                                });
                                custom_uploader.open();
                            });


                        });
                    </script>





                </div>
                <!--  -->
                <div class="cosa-vedere-box" style="border: 1px solid black;padding: 1rem;margin: 0.25rem">

                    <label for="cosa_vedere_titolo_2">Titolo 2</label>
                    <br>
                    <?php $cosaVedereTitolo2 = get_post_meta($post->ID, "cosa_vedere_titolo_2", true); ?>
                    <input type="text" name="cosa_vedere_titolo_2" id="cosa_vedere_titolo_2" value="<?= $cosaVedereTitolo2 ?>">
                    <br>
                    <label for="cosa_vedere_descrizione_2">Descrizione 2</label>
                    <br>
                    <?php $cosaVedereDescrizione2 = get_post_meta($post->ID, "cosa_vedere_descrizione_2", true); ?>
                    <input type="text" name="cosa_vedere_descrizione_2" id="cosa_vedere_descrizione_2" value="<?= $cosaVedereDescrizione2 ?>">
                    <br>
                    <br>
                    <?php
                    $cosa_vedere_image_2 = get_post_meta($post->ID, 'cosa_vedere_image_2', true);
                    $cosa_vedere_image_url_2 = wp_get_attachment_image_url($cosa_vedere_image_2, 'thumbnail');
                    ?>
                    <div class="custom-image-container">
                        <div class="image-preview-2">
                            <?php if ($cosa_vedere_image_url_2) : ?>
                                <img src="<?php echo esc_url($cosa_vedere_image_url_2); ?>" alt="Custom Image" style="max-width: 200px; max-height: 100px;">
                            <?php endif; ?>
                        </div>
                        <input type="hidden" name="cosa_vedere_image_2" id="cosa_vedere_image_2" value="<?php echo esc_attr($cosa_vedere_image_2); ?>">
                        <button type="button" class="button button-primary" id="cosa_fare_image_button_2">Carica Immagine</button>
                    </div>
                    <script>
                        jQuery(document).ready(function($) {
                            // Upload dell'immagine
                            $('#cosa_fare_image_button_2').click(function(e) {
                                e.preventDefault();
                                var custom_uploader = wp.media({
                                    title: 'Carica Immagine',
                                    button: {
                                        text: 'Seleziona Immagine'
                                    },
                                    multiple: false
                                });
                                custom_uploader.on('select', function() {
                                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                                    $('#cosa_vedere_image_2').val(attachment.id);
                                    $('.image-preview-2 img').attr('src', attachment.url);
                                });
                                custom_uploader.open();
                            });


                        });
                    </script>
                </div>
                <!--  -->
                <div class="cosa-vedere-box" style="border: 1px solid black;padding: 1rem;margin: 0.25rem">

                    <label for=" cosa_vedere_titolo_3">Titolo 3</label>
                    <br>
                    <?php $cosaVedereTitolo3 = get_post_meta($post->ID, "cosa_vedere_titolo_3", true); ?>
                    <input type="text" name="cosa_vedere_titolo_3" id="cosa_vedere_titolo_3" value="<?= $cosaVedereTitolo3 ?>">
                    <br>
                    <label for="cosa_vedere_descrizione_3">Descrizione 3</label>
                    <br>
                    <?php $cosaVedereDescrizione3 = get_post_meta($post->ID, "cosa_vedere_descrizione_3", true); ?>
                    <input type="text" name="cosa_vedere_descrizione_3" id="cosa_vedere_descrizione_3" value="<?= $cosaVedereDescrizione3 ?>">


                    <br>
                    <br>

                    <?php
                    $cosa_vedere_image_3 = get_post_meta($post->ID, 'cosa_vedere_image_3', true);
                    $cosa_vedere_image_url_3 = wp_get_attachment_image_url($cosa_vedere_image_3, 'thumbnail');
                    ?>
                    <div class="custom-image-container">
                        <div class="image-preview-3">
                            <?php if ($cosa_vedere_image_url_3) : ?>
                                <img src="<?php echo esc_url($cosa_vedere_image_url_3); ?>" alt="Custom Image" style="max-width: 200px; max-height: 100px;">
                            <?php endif; ?>
                        </div>
                        <input type="hidden" name="cosa_vedere_image_3" id="cosa_vedere_image_3" value="<?php echo esc_attr($cosa_vedere_image_3); ?>">
                        <button type="button" class="button button-primary" id="cosa_fare_image_button_3">Carica Immagine</button>
                    </div>
                    <script>
                        jQuery(document).ready(function($) {
                            // Upload dell'immagine
                            $('#cosa_fare_image_button_3').click(function(e) {
                                e.preventDefault();
                                var custom_uploader = wp.media({
                                    title: 'Carica Immagine',
                                    button: {
                                        text: 'Seleziona Immagine'
                                    },
                                    multiple: false
                                });
                                custom_uploader.on('select', function() {
                                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                                    $('#cosa_vedere_image_3').val(attachment.id);
                                    $('.image-preview-3 img').attr('src', attachment.url);
                                });
                                custom_uploader.open();
                            });


                        });
                    </script>






                </div>
                <!--  -->
                <div class="cosa-vedere-box" style="border: 1px solid black;padding: 1rem;margin: 0.25rem">

                    <label for=" cosa_vedere_titolo_4">Titolo 4</label>
                    <br>
                    <?php $cosaVedereTitolo4 = get_post_meta($post->ID, "cosa_vedere_titolo_4", true); ?>
                    <input type="text" name="cosa_vedere_titolo_4" id="cosa_vedere_titolo_4" value="<?= $cosaVedereTitolo4 ?>">
                    <br>
                    <label for="cosa_vedere_descrizione_4">Descrizione 4</label>
                    <br>
                    <?php $cosaVedereDescrizione4 = get_post_meta($post->ID, "cosa_vedere_descrizione_4", true); ?>
                    <input type="text" name="cosa_vedere_descrizione_4" id="cosa_vedere_descrizione_4" value="<?= $cosaVedereDescrizione4 ?>">
                    <br><br>

                    <?php
                    $cosa_vedere_image_4 = get_post_meta($post->ID, 'cosa_vedere_image_4', true);
                    $cosa_vedere_image_url_4 = wp_get_attachment_image_url($cosa_vedere_image_4, 'thumbnail');
                    ?>
                    <div class="custom-image-container">
                        <div class="image-preview-4">
                            <?php if ($cosa_vedere_image_url_4) : ?>
                                <img src="<?php echo esc_url($cosa_vedere_image_url_4); ?>" alt="Custom Image" style="max-width: 200px; max-height: 100px;">
                            <?php endif; ?>
                        </div>
                        <input type="hidden" name="cosa_vedere_image_4" id="cosa_vedere_image_4" value="<?php echo esc_attr($cosa_vedere_image_4); ?>">
                        <button type="button" class="button button-primary" id="cosa_fare_image_button_4">Carica Immagine</button>
                    </div>
                    <script>
                        jQuery(document).ready(function($) {
                            // Upload dell'immagine
                            $('#cosa_fare_image_button_4').click(function(e) {
                                e.preventDefault();
                                var custom_uploader = wp.media({
                                    title: 'Carica Immagine',
                                    button: {
                                        text: 'Seleziona Immagine'
                                    },
                                    multiple: false
                                });
                                custom_uploader.on('select', function() {
                                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                                    $('#cosa_vedere_image_4').val(attachment.id);
                                    $('.image-preview-4 img').attr('src', attachment.url);
                                });
                                custom_uploader.open();
                            });


                        });
                    </script>



                </div>
                <!--  -->
            </div>
        </div>





        <br><br><br><br>

        <div class="mangiare-container-box" style="border: 1px solid black;padding: 1rem;">
            <h4>Cibo</h4>
            <div style="display: flex; flex-wrap: wrap;">
                <div class="mangiare-box" style="border: 1px solid black;padding: 1rem;margin: 0.25rem">
                    <label for="mangiare_titolo_1">Titolo 1</label>
                    <br>
                    <?php $mangiareTitolo1 = get_post_meta($post->ID, "mangiare_titolo_1", true); ?>
                    <input type="text" name="mangiare_titolo_1" id="mangiare_titolo_1" value="<?= $mangiareTitolo1 ?>">
                    <br>
                    <label for="mangiare_descrizione_1">Descrizione 1</label>
                    <br>
                    <?php $mangiareDescrizione1 = get_post_meta($post->ID, "mangiare_descrizione_1", true); ?>
                    <input type="text" name="mangiare_descrizione_1" id="mangiare_descrizione_1" value="<?= $mangiareDescrizione1 ?>">
                    <br>
                    <br>

                    <?php
                    $mangiare_image_1 = get_post_meta($post->ID, 'mangiare_image_1', true);
                    $mangiare_image_url_1 = wp_get_attachment_image_url($mangiare_image_1, 'thumbnail');
                    ?>
                    <div class="custom-image-container">
                        <div class="mangiare-image-preview-1">
                            <?php if ($mangiare_image_url_1) : ?>
                                <img src="<?php echo esc_url($mangiare_image_url_1); ?>" alt="Custom Image" style="max-width: 200px; max-height: 100px;">
                            <?php endif; ?>
                        </div>
                        <input type="hidden" name="mangiare_image_1" id="mangiare_image_1" value="<?php echo esc_attr($mangiare_image_1); ?>">
                        <button type="button" class="button button-primary" id="mangiare_image_button_1">Carica Immagine</button>
                    </div>
                    <script>
                        jQuery(document).ready(function($) {
                            // Upload dell'immagine
                            $('#mangiare_image_button_1').click(function(e) {
                                e.preventDefault();
                                var custom_uploader = wp.media({
                                    title: 'Carica Immagine',
                                    button: {
                                        text: 'Seleziona Immagine'
                                    },
                                    multiple: false
                                });
                                custom_uploader.on('select', function() {
                                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                                    $('#mangiare_image_1').val(attachment.id);
                                    $('.mangiare-image-preview-1 img').attr('src', attachment.url);
                                });
                                custom_uploader.open();
                            });


                        });
                    </script>





                </div>
                <!--  -->
                <div class="mangiare-box" style="border: 1px solid black;padding: 1rem;margin: 0.25rem">

                    <label for="mangiare_titolo_2">Titolo 2</label>
                    <br>
                    <?php $mangiareTitolo2 = get_post_meta($post->ID, "mangiare_titolo_2", true); ?>
                    <input type="text" name="mangiare_titolo_2" id="mangiare_titolo_2" value="<?= $mangiareTitolo2 ?>">
                    <br>
                    <label for="mangiare_descrizione_2">Descrizione 2</label>
                    <br>
                    <?php $mangiareDescrizione2 = get_post_meta($post->ID, "mangiare_descrizione_2", true); ?>
                    <input type="text" name="mangiare_descrizione_2" id="mangiare_descrizione_2" value="<?= $mangiareDescrizione2 ?>">
                    <br>
                    <br>
                    <?php
                    $mangiare_image_2 = get_post_meta($post->ID, 'mangiare_image_2', true);
                    $mangiare_image_url_2 = wp_get_attachment_image_url($mangiare_image_2, 'thumbnail');
                    ?>
                    <div class="custom-image-container">
                        <div class="mangiare-image-preview-2">
                            <?php if ($mangiare_image_url_2) : ?>
                                <img src="<?php echo esc_url($mangiare_image_url_2); ?>" alt="Custom Image" style="max-width: 200px; max-height: 100px;">
                            <?php endif; ?>
                        </div>
                        <input type="hidden" name="mangiare_image_2" id="mangiare_image_2" value="<?php echo esc_attr($mangiare_image_2); ?>">
                        <button type="button" class="button button-primary" id="mangiare_image_button_2">Carica Immagine</button>
                    </div>
                    <script>
                        jQuery(document).ready(function($) {
                            // Upload dell'immagine
                            $('#mangiare_image_button_2').click(function(e) {
                                e.preventDefault();
                                var custom_uploader = wp.media({
                                    title: 'Carica Immagine',
                                    button: {
                                        text: 'Seleziona Immagine'
                                    },
                                    multiple: false
                                });
                                custom_uploader.on('select', function() {
                                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                                    $('#mangiare_image_2').val(attachment.id);
                                    $('.mangiare-image-preview-2 img').attr('src', attachment.url);
                                });
                                custom_uploader.open();
                            });


                        });
                    </script>
                </div>
                <!--  -->
                <div class="mangiare-box" style="border: 1px solid black;padding: 1rem;margin: 0.25rem">

                    <label for=" mangiare_titolo_3">Titolo 3</label>
                    <br>
                    <?php $mangiareTitolo3 = get_post_meta($post->ID, "mangiare_titolo_3", true); ?>
                    <input type="text" name="mangiare_titolo_3" id="mangiare_titolo_3" value="<?= $mangiareTitolo3 ?>">
                    <br>
                    <label for="mangiare_descrizione_3">Descrizione 3</label>
                    <br>
                    <?php $mangiareDescrizione3 = get_post_meta($post->ID, "mangiare_descrizione_3", true); ?>
                    <input type="text" name="mangiare_descrizione_3" id="mangiare_descrizione_3" value="<?= $mangiareDescrizione3 ?>">


                    <br>
                    <br>

                    <?php
                    $mangiare_image_3 = get_post_meta($post->ID, 'mangiare_image_3', true);
                    $mangiare_image_url_3 = wp_get_attachment_image_url($mangiare_image_3, 'thumbnail');
                    ?>
                    <div class="custom-image-container">
                        <div class="mangiare-image-preview-2">
                            <?php if ($mangiare_image_url_3) : ?>
                                <img src="<?php echo esc_url($mangiare_image_url_3); ?>" alt="Custom Image" style="max-width: 200px; max-height: 100px;">
                            <?php endif; ?>
                        </div>
                        <input type="hidden" name="mangiare_image_3" id="mangiare_image_3" value="<?php echo esc_attr($mangiare_image_3); ?>">
                        <button type="button" class="button button-primary" id="mangiare_image_button_3">Carica Immagine</button>
                    </div>
                    <script>
                        jQuery(document).ready(function($) {
                            // Upload dell'immagine
                            $('#mangiare_image_button_3').click(function(e) {
                                e.preventDefault();
                                var custom_uploader = wp.media({
                                    title: 'Carica Immagine',
                                    button: {
                                        text: 'Seleziona Immagine'
                                    },
                                    multiple: false
                                });
                                custom_uploader.on('select', function() {
                                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                                    $('#mangiare_image_3').val(attachment.id);
                                    $('.mangiare-image-preview-3 img').attr('src', attachment.url);
                                });
                                custom_uploader.open();
                            });


                        });
                    </script>






                </div>

            </div>



        </div>
        <br> <br><br><br>






        <div class="localita-container-box" style="border: 1px solid black;padding: 1rem;">
            <h4>Località</h4>
            <div style="display: flex; flex-wrap: wrap;">
                <div class="localita-box" style="border: 1px solid black;padding: 1rem;margin: 0.25rem">
                    <label for="localita_titolo_1">Titolo 1</label>
                    <br>
                    <?php $localitaTitolo1 = get_post_meta($post->ID, "localita_titolo_1", true); ?>
                    <input type="text" name="localita_titolo_1" id="localita_titolo_1" value="<?= $localitaTitolo1 ?>">
                    <br>
                    <label for="localita_descrizione_1">Descrizione 1</label>
                    <br>
                    <?php $localitaDescrizione1 = get_post_meta($post->ID, "localita_descrizione_1", true); ?>
                    <input type="text" name="localita_descrizione_1" id="localita_descrizione_1" value="<?= $localitaDescrizione1 ?>">
                    <br>
                    <br>

                    <?php
                    $localita_image_1 = get_post_meta($post->ID, 'localita_image_1', true);
                    $localita_image_url_1 = wp_get_attachment_image_url($localita_image_1, 'thumbnail');
                    ?>
                    <div class="custom-image-container">
                        <div class="localita-image-preview-1">
                            <?php if ($localita_image_url_1) : ?>
                                <img src="<?php echo esc_url($localita_image_url_1); ?>" alt="Custom Image" style="max-width: 200px; max-height: 100px;">
                            <?php endif; ?>
                        </div>
                        <input type="hidden" name="localita_image_1" id="localita_image_1" value="<?php echo esc_attr($localita_image_1); ?>">
                        <button type="button" class="button button-primary" id="localita_image_button_1">Carica Immagine</button>
                    </div>
                    <script>
                        jQuery(document).ready(function($) {
                            // Upload dell'immagine
                            $('#localita_image_button_1').click(function(e) {
                                e.preventDefault();
                                var custom_uploader = wp.media({
                                    title: 'Carica Immagine',
                                    button: {
                                        text: 'Seleziona Immagine'
                                    },
                                    multiple: false
                                });
                                custom_uploader.on('select', function() {
                                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                                    $('#localita_image_1').val(attachment.id);
                                    $('.localita-image-preview-1 img').attr('src', attachment.url);
                                });
                                custom_uploader.open();
                            });


                        });
                    </script>





                </div>
                <!--  -->
                <div class="localita-box" style="border: 1px solid black;padding: 1rem;margin: 0.25rem">

                    <label for="localita_titolo_2">Titolo 2</label>
                    <br>
                    <?php $localitaTitolo2 = get_post_meta($post->ID, "localita_titolo_2", true); ?>
                    <input type="text" name="localita_titolo_2" id="localita_titolo_2" value="<?= $localitaTitolo2 ?>">
                    <br>
                    <label for="localita_descrizione_2">Descrizione 2</label>
                    <br>
                    <?php $localitaDescrizione2 = get_post_meta($post->ID, "localita_descrizione_2", true); ?>
                    <input type="text" name="localita_descrizione_2" id="localita_descrizione_2" value="<?= $localitaDescrizione2 ?>">
                    <br>
                    <br>
                    <?php
                    $localita_image_2 = get_post_meta($post->ID, 'localita_image_2', true);
                    $localita_image_url_2 = wp_get_attachment_image_url($localita_image_2, 'thumbnail');
                    ?>
                    <div class="custom-image-container">
                        <div class="localita-image-preview-2">
                            <?php if ($localita_image_url_2) : ?>
                                <img src="<?php echo esc_url($localita_image_url_2); ?>" alt="Custom Image" style="max-width: 200px; max-height: 100px;">
                            <?php endif; ?>
                        </div>
                        <input type="hidden" name="localita_image_2" id="localita_image_2" value="<?php echo esc_attr($localita_image_2); ?>">
                        <button type="button" class="button button-primary" id="localita_image_button_2">Carica Immagine</button>
                    </div>
                    <script>
                        jQuery(document).ready(function($) {
                            // Upload dell'immagine
                            $('#localita_image_button_2').click(function(e) {
                                e.preventDefault();
                                var custom_uploader = wp.media({
                                    title: 'Carica Immagine',
                                    button: {
                                        text: 'Seleziona Immagine'
                                    },
                                    multiple: false
                                });
                                custom_uploader.on('select', function() {
                                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                                    $('#localita_image_2').val(attachment.id);
                                    $('.localita-image-preview-2 img').attr('src', attachment.url);
                                });
                                custom_uploader.open();
                            });


                        });
                    </script>
                </div>
                <!--  -->
                <div class="localita-box" style="border: 1px solid black;padding: 1rem;margin: 0.25rem">

                    <label for=" localita_titolo_3">Titolo 3</label>
                    <br>
                    <?php $localitaTitolo3 = get_post_meta($post->ID, "localita_titolo_3", true); ?>
                    <input type="text" name="localita_titolo_3" id="localita_titolo_3" value="<?= $localitaTitolo3 ?>">
                    <br>
                    <label for="localita_descrizione_3">Descrizione 3</label>
                    <br>
                    <?php $localitaDescrizione3 = get_post_meta($post->ID, "localita_descrizione_3", true); ?>
                    <input type="text" name="localita_descrizione_3" id="localita_descrizione_3" value="<?= $localitaDescrizione3 ?>">


                    <br>
                    <br>

                    <?php
                    $localita_image_3 = get_post_meta($post->ID, 'localita_image_3', true);
                    $localita_image_url_3 = wp_get_attachment_image_url($localita_image_3, 'thumbnail');
                    ?>
                    <div class="custom-image-container">
                        <div class="localita-image-preview-2">
                            <?php if ($localita_image_url_3) : ?>
                                <img src="<?php echo esc_url($localita_image_url_3); ?>" alt="Custom Image" style="max-width: 200px; max-height: 100px;">
                            <?php endif; ?>
                        </div>
                        <input type="hidden" name="localita_image_3" id="localita_image_3" value="<?php echo esc_attr($localita_image_3); ?>">
                        <button type="button" class="button button-primary" id="localita_image_button_3">Carica Immagine</button>
                    </div>
                    <script>
                        jQuery(document).ready(function($) {
                            // Upload dell'immagine
                            $('#localita_image_button_3').click(function(e) {
                                e.preventDefault();
                                var custom_uploader = wp.media({
                                    title: 'Carica Immagine',
                                    button: {
                                        text: 'Seleziona Immagine'
                                    },
                                    multiple: false
                                });
                                custom_uploader.on('select', function() {
                                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                                    $('#localita_image_3').val(attachment.id);
                                    $('.localita-image-preview-3 img').attr('src', attachment.url);
                                });
                                custom_uploader.open();
                            });


                        });
                    </script>






                </div>
                <!--  -->
                <div class="localita-box" style="border: 1px solid black;padding: 1rem;margin: 0.25rem">

                    <label for=" localita_titolo_4">Titolo 4</label>
                    <br>
                    <?php $localitaTitolo4 = get_post_meta($post->ID, "localita_titolo_4", true); ?>
                    <input type="text" name="localita_titolo_4" id="localita_titolo_4" value="<?= $localitaTitolo4 ?>">
                    <br>
                    <label for="localita_descrizione_4">Descrizione 4</label>
                    <br>
                    <?php $localitaDescrizione4 = get_post_meta($post->ID, "localita_descrizione_4", true); ?>
                    <input type="text" name="localita_descrizione_4" id="localita_descrizione_4" value="<?= $localitaDescrizione4 ?>">
                    <br><br>

                    <?php
                    $localita_image_4 = get_post_meta($post->ID, 'localita_image_4', true);
                    $localita_image_url_4 = wp_get_attachment_image_url($localita_image_4, 'thumbnail');
                    ?>
                    <div class="custom-image-container">
                        <div class="localita-image-preview-4">
                            <?php if ($localita_image_url_4) : ?>
                                <img src="<?php echo esc_url($localita_image_url_4); ?>" alt="Custom Image" style="max-width: 200px; max-height: 100px;">
                            <?php endif; ?>
                        </div>
                        <input type="hidden" name="localita_image_4" id="localita_image_4" value="<?php echo esc_attr($localita_image_4); ?>">
                        <button type="button" class="button button-primary" id="localita_image_button_4">Carica Immagine</button>
                    </div>
                    <script>
                        jQuery(document).ready(function($) {
                            // Upload dell'immagine
                            $('#localita_image_button_4').click(function(e) {
                                e.preventDefault();
                                var custom_uploader = wp.media({
                                    title: 'Carica Immagine',
                                    button: {
                                        text: 'Seleziona Immagine'
                                    },
                                    multiple: false
                                });
                                custom_uploader.on('select', function() {
                                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                                    $('#localita_image_4').val(attachment.id);
                                    $('.localita-image-preview-4 img').attr('src', attachment.url);
                                });
                                custom_uploader.open();
                            });


                        });
                    </script>



                </div>
                <!--  -->
            </div>
        </div>

























        <div class="info-utili-container-box" style="border: 1px solid black;padding: 1rem;">
            <h4>Info Utili</h4>
            <div style="display: flex; flex-wrap: wrap;">
                <div class="info-utili-box" style="border: 1px solid black;padding: 1rem;margin: 0.25rem">
                    <label for="documento">Documenti</label>
                    <br>
                    <?php $documento = get_post_meta($post->ID, "documento", true); ?>
                    <input type="text" name="documento" id="documento" value="<?= $documento ?>">
                    <br>

                </div>
                <div class="info-utili-box" style="border: 1px solid black;padding: 1rem;margin: 0.25rem">
                    <label for="orario">orario</label>
                    <br>
                    <?php $orario = get_post_meta($post->ID, "orario", true); ?>
                    <input type="text" name="orario" id="orario" value="<?= $orario ?>">
                    <br>
                </div>
                <div class="info-utili-box" style="border: 1px solid black;padding: 1rem;margin: 0.25rem">
                    <label for="lingua">Lingua</label>
                    <br>
                    <?php $lingua = get_post_meta($post->ID, "lingua", true); ?>
                    <input type="text" name="lingua" id="lingua" value="<?= $lingua ?>">
                    <br>
                </div>
                <div class="info-utili-box" style="border: 1px solid black;padding: 1rem;margin: 0.25rem">
                    <label for="valuta">Valuta</label>
                    <br>
                    <?php $valuta = get_post_meta($post->ID, "valuta", true); ?>
                    <input type="text" name="valuta" id="valuta" value="<?= $valuta ?>">
                    <br>
                </div>
            </div>
        </div>
    <?php  }


add_action("save_post", "save_service_metabox_data", 10, 2);

function save_service_metabox_data($post_id, $post)
{
    if (!isset($_POST['servizi_nonce']) || !wp_verify_nonce($_POST['servizi_nonce'], basename(__FILE__))) {
        return $post_id;
    }
    $post_slug = "servizi";

    if ($post_slug != $post->post_type) {
        return;
    }

    $titolo = '';
    if (isset($_POST['title'])) {
        $titolo = htmlspecialchars($_POST['title']);
    } else {
        $titolo = '';
    }

    $cosaVedereTitolo1 = '';
    if (isset($_POST['cosa_vedere_titolo_1'])) {
        $cosaVedereTitolo1 = htmlspecialchars($_POST['cosa_vedere_titolo_1']);
    } else {
        $cosaVedereTitolo1 = '';
    }


    $cosaVedereTitolo2 = '';
    if (isset($_POST['cosa_vedere_titolo_2'])) {
        $cosaVedereTitolo2 = htmlspecialchars($_POST['cosa_vedere_titolo_2']);
    } else {
        $cosaVedereTitolo2 = '';
    }

    $cosaVedereTitolo3 = '';
    if (isset($_POST['cosa_vedere_titolo_3'])) {
        $cosaVedereTitolo3 = htmlspecialchars($_POST['cosa_vedere_titolo_3']);
    } else {
        $cosaVedereTitolo3 = '';
    }

    $cosaVedereTitolo4 = '';
    if (isset($_POST['cosa_vedere_titolo_4'])) {
        $cosaVedereTitolo4 = htmlspecialchars($_POST['cosa_vedere_titolo_4']);
    } else {
        $cosaVedereTitolo4 = '';
    }

    $cosaVedereDescrizione1 = '';
    if (isset($_POST['cosa_vedere_descrizione_1'])) {
        $cosaVedereDescrizione1 = htmlspecialchars($_POST['cosa_vedere_descrizione_1']);
    } else {
        $cosaVedereDescrizione1 = '';
    }

    $cosaVedereDescrizione2 = '';
    if (isset($_POST['cosa_vedere_descrizione_2'])) {
        $cosaVedereDescrizione2 = htmlspecialchars($_POST['cosa_vedere_descrizione_2']);
    } else {
        $cosaVedereDescrizione2 = '';
    }

    $cosaVedereDescrizione3 = '';
    if (isset($_POST['cosa_vedere_descrizione_3'])) {
        $cosaVedereDescrizione3 = htmlspecialchars($_POST['cosa_vedere_descrizione_3']);
    } else {
        $cosaVedereDescrizione3 = '';
    }


    $cosaVedereDescrizione4 = '';
    if (isset($_POST['cosa_vedere_descrizione_4'])) {
        $cosaVedereDescrizione4 = htmlspecialchars($_POST['cosa_vedere_descrizione_4']);
    } else {
        $cosaVedereDescrizione4 = '';
    }



    $documento = '';
    if (isset($_POST['documento'])) {
        $documento = htmlspecialchars($_POST['documento']);
    } else {
        $documento = '';
    }

    $valuta = '';
    if (isset($_POST['valuta'])) {
        $valuta = htmlspecialchars($_POST['valuta']);
    } else {
        $valuta = '';
    }


    $orario = '';
    if (isset($_POST['orario'])) {
        $orario = htmlspecialchars($_POST['orario']);
    } else {
        $orario = '';
    }


    $lingua = '';
    if (isset($_POST['lingua'])) {
        $lingua = htmlspecialchars($_POST['lingua']);
    } else {
        $lingua = '';
    }


    $newValues = array(
        'service_title' => $titolo,
        'cosa_vedere_titolo_1' => $cosaVedereTitolo1,
        'cosa_vedere_titolo_2' => $cosaVedereTitolo2,
        'cosa_vedere_titolo_3' => $cosaVedereTitolo3,
        'cosa_vedere_titolo_4' => $cosaVedereTitolo4,
        'cosa_vedere_descrizione_1' => $cosaVedereDescrizione1,
        'cosa_vedere_descrizione_2' => $cosaVedereDescrizione2,
        'cosa_vedere_descrizione_3' => $cosaVedereDescrizione3,
        'cosa_vedere_descrizione_4' => $cosaVedereDescrizione4,
        'documento' => $documento,
        'valuta' => $valuta,
        'orario' => $orario,
        'lingua' => $lingua,






    );

    foreach ($newValues as $key => $value) {

        update_post_meta($post_id, $key, $value);
    }


    $cosa_vedere_image_1 = isset($_POST['cosa_vedere_image_1']) ? sanitize_text_field($_POST['cosa_vedere_image_1']) : '';
    update_post_meta($post_id, 'cosa_vedere_image_1', $cosa_vedere_image_1);

    $cosa_vedere_image_2 = isset($_POST['cosa_vedere_image_2']) ? sanitize_text_field($_POST['cosa_vedere_image_2']) : '';
    update_post_meta($post_id, 'cosa_vedere_image_2', $cosa_vedere_image_2);

    $cosa_vedere_image_3 = isset($_POST['cosa_vedere_image_3']) ? sanitize_text_field($_POST['cosa_vedere_image_3']) : '';
    update_post_meta($post_id, 'cosa_vedere_image_3', $cosa_vedere_image_3);

    $cosa_vedere_image_4 = isset($_POST['cosa_vedere_image_4']) ? sanitize_text_field($_POST['cosa_vedere_image_4']) : '';
    update_post_meta($post_id, 'cosa_vedere_image_4', $cosa_vedere_image_4);










    $localitaTitolo1 = '';
    if (isset($_POST['localita_titolo_1'])) {
        $localitaTitolo1 = htmlspecialchars($_POST['localita_titolo_1']);
    } else {
        $localitaTitolo1 = '';
    }


    $localitaTitolo2 = '';
    if (isset($_POST['localita_titolo_2'])) {
        $localitaTitolo2 = htmlspecialchars($_POST['localita_titolo_2']);
    } else {
        $localitaTitolo2 = '';
    }

    $localitaTitolo3 = '';
    if (isset($_POST['localita_titolo_3'])) {
        $localitaTitolo3 = htmlspecialchars($_POST['localita_titolo_3']);
    } else {
        $localitaTitolo3 = '';
    }

    $localitaTitolo4 = '';
    if (isset($_POST['localita_titolo_4'])) {
        $localitaTitolo4 = htmlspecialchars($_POST['localita_titolo_4']);
    } else {
        $localitaTitolo4 = '';
    }

    $localitaDescrizione1 = '';
    if (isset($_POST['localita_descrizione_1'])) {
        $localitaDescrizione1 = htmlspecialchars($_POST['localita_descrizione_1']);
    } else {
        $localitaDescrizione1 = '';
    }

    $localitaDescrizione2 = '';
    if (isset($_POST['localita_descrizione_2'])) {
        $localitaDescrizione2 = htmlspecialchars($_POST['localita_descrizione_2']);
    } else {
        $localitaDescrizione2 = '';
    }

    $localitaDescrizione3 = '';
    if (isset($_POST['localita_descrizione_3'])) {
        $localitaDescrizione3 = htmlspecialchars($_POST['localita_descrizione_3']);
    } else {
        $localitaDescrizione3 = '';
    }


    $localitaDescrizione4 = '';
    if (isset($_POST['localita_descrizione_4'])) {
        $localitaDescrizione4 = htmlspecialchars($_POST['localita_descrizione_4']);
    } else {
        $localitaDescrizione4 = '';
    }


    $newValues = array(
        'service_title' => $titolo,
        'localita_titolo_1' => $localitaTitolo1,
        'localita_titolo_2' => $localitaTitolo2,
        'localita_titolo_3' => $localitaTitolo3,
        'localita_titolo_4' => $localitaTitolo4,
        'localita_descrizione_1' => $localitaDescrizione1,
        'localita_descrizione_2' => $localitaDescrizione2,
        'localita_descrizione_3' => $localitaDescrizione3,
        'localita_descrizione_4' => $localitaDescrizione4,




    );

    foreach ($newValues as $key => $value) {

        update_post_meta($post_id, $key, $value);
    }


    $localita_image_1 = isset($_POST['localita_image_1']) ? sanitize_text_field($_POST['localita_image_1']) : '';
    update_post_meta($post_id, 'localita_image_1', $localita_image_1);

    $localita_image_2 = isset($_POST['localita_image_2']) ? sanitize_text_field($_POST['localita_image_2']) : '';
    update_post_meta($post_id, 'localita_image_2', $localita_image_2);

    $localita_image_3 = isset($_POST['localita_image_3']) ? sanitize_text_field($_POST['localita_image_3']) : '';
    update_post_meta($post_id, 'localita_image_3', $localita_image_3);

    $localita_image_4 = isset($_POST['localita_image_4']) ? sanitize_text_field($_POST['localita_image_4']) : '';
    update_post_meta($post_id, 'localita_image_4', $localita_image_4);



































    $mangiareTitolo1 = '';
    if (isset($_POST['mangiare_titolo_1'])) {
        $mangiareTitolo1 = htmlspecialchars($_POST['mangiare_titolo_1']);
    } else {
        $mangiareTitolo1 = '';
    }


    $mangiareTitolo2 = '';
    if (isset($_POST['mangiare_titolo_2'])) {
        $mangiareTitolo2 = htmlspecialchars($_POST['mangiare_titolo_2']);
    } else {
        $mangiareTitolo2 = '';
    }

    $mangiareTitolo3 = '';
    if (isset($_POST['mangiare_titolo_3'])) {
        $mangiareTitolo3 = htmlspecialchars($_POST['mangiare_titolo_3']);
    } else {
        $mangiareTitolo3 = '';
    }



    $mangiareDescrizione1 = '';
    if (isset($_POST['mangiare_descrizione_1'])) {
        $mangiareDescrizione1 = htmlspecialchars($_POST['mangiare_descrizione_1']);
    } else {
        $mangiareDescrizione1 = '';
    }

    $mangiareDescrizione2 = '';
    if (isset($_POST['mangiare_descrizione_2'])) {
        $mangiareDescrizione2 = htmlspecialchars($_POST['mangiare_descrizione_2']);
    } else {
        $mangiareDescrizione2 = '';
    }

    $mangiareDescrizione3 = '';
    if (isset($_POST['mangiare_descrizione_3'])) {
        $mangiareDescrizione3 = htmlspecialchars($_POST['mangiare_descrizione_3']);
    } else {
        $mangiareDescrizione3 = '';
    }




    $newValues = array(
        'service_title' => $titolo,
        'mangiare_titolo_1' => $mangiareTitolo1,
        'mangiare_titolo_2' => $mangiareTitolo2,
        'mangiare_titolo_3' => $mangiareTitolo3,

        'mangiare_descrizione_1' => $mangiareDescrizione1,
        'mangiare_descrizione_2' => $mangiareDescrizione2,
        'mangiare_descrizione_3' => $mangiareDescrizione3,





    );

    foreach ($newValues as $key => $value) {

        update_post_meta($post_id, $key, $value);
    }


    $mangiare_image_1 = isset($_POST['mangiare_image_1']) ? sanitize_text_field($_POST['mangiare_image_1']) : '';
    update_post_meta($post_id, 'mangiare_image_1', $mangiare_image_1);

    $mangiare_image_2 = isset($_POST['mangiare_image_2']) ? sanitize_text_field($_POST['mangiare_image_2']) : '';
    update_post_meta($post_id, 'mangiare_image_2', $mangiare_image_2);

    $mangiare_image_3 = isset($_POST['mangiare_image_3']) ? sanitize_text_field($_POST['mangiare_image_3']) : '';
    update_post_meta($post_id, 'mangiare_image_3', $mangiare_image_3);
}




    