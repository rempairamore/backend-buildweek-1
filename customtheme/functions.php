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
        ));
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



// javascript code for animations
?>
<script>
    // Function to check if an element is in the viewport
    function isElementInViewport(el) {
        var rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    // Function to handle scroll animations
    function handleScrollAnimations() {
        document.querySelectorAll('.custom-image-wrapper, .custom-list-wrapper, .custom-article-wrapper').forEach(element => {
            if (isElementInViewport(element)) {
                element.classList.add('animate');
            }
        });
    }

    // Attach scroll event listener to trigger animations
    window.addEventListener('scroll', handleScrollAnimations);

</script>


<?php
//----------------------------------------------------------------end wp-10---------------------------------------------------------------