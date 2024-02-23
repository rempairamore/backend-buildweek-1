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

// Salva gli ID delle immagini come metadati del post
add_action('save_post', 'save_custom_image_meta_data');
function save_custom_image_meta_data($post_id) {
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
function convert_gallery_to_carousel($content) {
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



// javascript code for animations
?>
<script>
    // Function to handle animations when elements enter the viewport
    function handleAnimations(entries, observer) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate'); // Add a CSS class to trigger the animation
                observer.unobserve(entry.target); // Stop observing once animated
            }
        });
    }

    // Create an Intersection Observer
    const observer = new IntersectionObserver(handleAnimations, {
        root: null,
        threshold: 0.2, // Adjust threshold as needed
    });

    // Observe elements with the specified class
    document.querySelectorAll('.custom-image-wrapper, .custom-list-wrapper, .custom-article-wrapper').forEach(element => {
        observer.observe(element);
    });

</script>


<?php
//----------------------------------------------------------------end wp-10---------------------------------------------------------------

