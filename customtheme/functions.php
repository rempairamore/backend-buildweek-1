<?php

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
            $carousel_html = '<div id="gallery-carousel" class="carousel slide" data-ride="carousel"><div class="carousel-inner">' . $carousel_items . '</div><a class="carousel-control-prev" href="#gallery-carousel" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span></a><a class="carousel-control-next" href="#gallery-carousel" role="button" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span></a></div>';
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