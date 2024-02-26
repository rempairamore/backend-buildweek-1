<?php
// STYLE E SCRIPTS
function load_bootstrap()
{
    // carica lo stile css di bootstrap
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
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
        <label for="title">Titolo</label>
        <br>
        <?php $titolo = get_post_meta($post->ID, "service_title", true); ?>
        <input type="text" name="title" id="title" value="<?= $titolo ?>">
        <br>

        <div>
            <div class="cosa-vedere-container-box" style="border: 1px solid black;padding: 1rem;">
                <h5>Cosa vedere</h5>
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


                        <?php
                        $custom_image_id = get_post_meta($post->ID, 'custom_image_id', true);
                        $custom_image_url = wp_get_attachment_image_url($custom_image_id, 'thumbnail');
                        ?>
                        <div class="custom-image-container">
                            <div class="image-preview">
                                <?php if ($custom_image_url) : ?>
                                    <img src="<?php echo esc_url($custom_image_url); ?>" alt="Custom Image">
                                <?php endif; ?>
                            </div>
                            <input type="hidden" name="custom_image_id" id="custom_image_id" value="<?php echo esc_attr($custom_image_id); ?>">
                            <button type="button" class="button button-primary" id="upload_image_button">Carica Immagine</button>
                            <button type="button" class="button" id="remove_image_button">Rimuovi Immagine</button>
                        </div>
                        <script>
                            jQuery(document).ready(function($) {
                                // Upload dell'immagine
                                $('#upload_image_button').click(function(e) {
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
                                        $('#custom_image_id').val(attachment.id);
                                        $('.image-preview img').attr('src', attachment.url);
                                    });
                                    custom_uploader.open();
                                });

                                // Rimozione dell'immagine
                                $('#remove_image_button').click(function() {
                                    $('#custom_image_id').val('');
                                    $('.image-preview img').attr('src', '');
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
                    </div>
                    <!--  -->
                </div>
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




    );

    foreach ($newValues as $key => $value) {

        update_post_meta($post_id, $key, $value);
    }


    $custom_image_id = isset($_POST['custom_image_id']) ? sanitize_text_field($_POST['custom_image_id']) : '';
    update_post_meta($post_id, 'custom_image_id', $custom_image_id);
}



?>