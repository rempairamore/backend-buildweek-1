
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

// Aggiungi campi personalizzati nel pannello amministratore per caricare le immagini
add_action('add_meta_boxes', 'custom_image_meta_box');
function custom_image_meta_box() {
    add_meta_box(
        'custom_image_meta_box',
        'Carica le immagini per il carosello',
        'render_custom_image_meta_box',
        'page', // Cambia 'page' con il tipo di post dove desideri che compaia la meta box
        'normal',
        'default'
    );
}

// Renderizza il contenuto della meta box
function render_custom_image_meta_box($post) {
    // Recupera le URL delle immagini salvate come metadati del post
    $image1_url = get_post_meta($post->ID, 'image1_url', true);
    $image2_url = get_post_meta($post->ID, 'image2_url', true);
    $image3_url = get_post_meta($post->ID, 'image3_url', true);
    ?>
    <p>Carica le immagini per il carosello:</p>
    <input type="text" name="image1_url" value="<?php echo esc_attr($image1_url); ?>" placeholder="URL immagine 1"><br>
    <input type="text" name="image2_url" value="<?php echo esc_attr($image2_url); ?>" placeholder="URL immagine 2"><br>
    <input type="text" name="image3_url" value="<?php echo esc_attr($image3_url); ?>" placeholder="URL immagine 3">
    <?php
}

// Salva le URL delle immagini come metadati del post
add_action('save_post', 'save_custom_image_meta_data');
function save_custom_image_meta_data($post_id) {
    if (isset($_POST['image1_url'])) {
        update_post_meta($post_id, 'image1_url', esc_url($_POST['image1_url']));
    }
    if (isset($_POST['image2_url'])) {
        update_post_meta($post_id, 'image2_url', esc_url($_POST['image2_url']));
    }
    if (isset($_POST['image3_url'])) {
        update_post_meta($post_id, 'image3_url', esc_url($_POST['image3_url']));
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