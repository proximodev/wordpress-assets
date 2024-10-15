<?php


/*
* Custom Image Sizes
*/

// Add custom media image sizes
add_theme_support( 'post-thumbnails' );
add_image_size( 'one-quarter', 500, 500, FALSE );
add_image_size( 'tiles', 800, 800, FALSE );
add_image_size( 'fifty-fifty', 1000, 1000, FALSE );
add_image_size( 'full-width', 2000, 2000, FALSE );

// Add images to Gutenberg block editor
add_filter( 'image_size_names_choose', 'custom_image_sizes' );
function custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
    'one-quarter' => __( 'One Quarter' ),
    'tiles' => __( 'Tiles' ),
    'full-width' => __( 'Full Width' ),
    'fifty-fifty' => __( '50/50 Image' ),
    ) );
}



?>