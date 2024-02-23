
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

add_image_size( 'custom-size-thumbnail', 280, 180);

//end add features



// Immagini per carosello

// Aggiungi campi personalizzati nel pannello amministratore per selezionare le immagini dalla libreria multimediale
add_action('add_meta_boxes', 'custom_image_meta_box');
function custom_image_meta_box() {
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
function render_custom_image_meta_box($post) {
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
    jQuery(document).ready(function($){
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

// Salva gli ID delle immagini come opzioni del tema
add_action('save_post', 'save_custom_image_options');
function save_custom_image_options($post_id) {
    if (isset($_POST['image1_id'])) {
        update_option('image1_id', esc_attr($_POST['image1_id']));
    }
    if (isset($_POST['image2_id'])) {
        update_option('image2_id', esc_attr($_POST['image2_id']));
    }
    if (isset($_POST['image3_id'])) {
        update_option('image3_id', esc_attr($_POST['image3_id']));
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