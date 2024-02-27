
<?php get_header() ;
$post_type = get_post_type();
?>

<?php if($post_type == "servizi") {
     the_title() 
}
     ?>


<?php get_footer() ?>