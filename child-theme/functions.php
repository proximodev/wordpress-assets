<?php
/**
* Chld
*/

// Child theme
$ver = wp_get_theme()->get('Version');
define( 'CHILD_THEME_VERSION', $ver);

// Frontent CSS and JS
add_action( 'wp_enqueue_scripts', 'theme_styles' );
function theme_styles() {

$verRnd = rand();

wp_dequeue_style( 'generate-child-css' );
wp_deregister_style( 'generate-child-css' );
wp_enqueue_style( 'generate-child', get_stylesheet_directory_uri() . '/style.css', array() , $verRnd, false );
wp_enqueue_style( 'custom', get_stylesheet_directory_uri() . '/assets/css/common.css', array() , $verRnd, false);

wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() . '/assets/js/custom.js', array(), 1.04, true );
wp_enqueue_script( 'app-js', get_stylesheet_directory_uri() . '/assets/js/app.js', array(), 1.01, true );
wp_enqueue_script( 'slick-js', get_stylesheet_directory_uri() . '/assets/js/slick.min.js', array(), '1.01', true );
wp_enqueue_script( 'jquery-js', get_stylesheet_directory_uri() . '/assets/js/jquery.min.js', array(), CHILD_THEME_VERSION, false );

}

//Disable emojis
add_action( 'init', 'disable_emojis' );
function disable_emojis() {
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}

function disable_emojis_tinymce( $plugins ) {
if ( is_array( $plugins ) ) {
return array_diff( $plugins, array( 'wpemoji' ) );
} else {
return array();
}
}

// Remove dashicons in frontend for unauthenticated users
add_action( 'wp_enqueue_scripts', 'dequeue_dashicons' );
function dequeue_dashicons() {
if ( ! is_user_logged_in() ) {
wp_deregister_style( 'dashicons' );
}
}

// Allow execution of php with generate blocks
add_filter( 'generate_hooks_execute_php', '__return_true' );

/*
* Images
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
'tiles' => __( 'Tiles' ),
'full-width' => __( 'Full Width' ),
'fifty-fifty' => __( '50/50 Image' ),
) );
}


/*
* Update cover with mobile image
*/

// Update the cover block to support second mobile image with picture tag
add_filter('render_block_core/cover', 'my_responsive_cover_render', 1, 2);
function my_responsive_cover_render($content, $block) {
// If has mobile image
if (isset($block['attrs']['mobileImageURL'])) {
$image = $block['attrs']['mobileImageURL'];
$content = preg_replace(
'<img class="wp-block-cover__image.+\/>/Ui',
              "<picture><source srcset='{$image}' media='(max-width:800px)'>$0</picture>",
$content
);
}
return $content;
}

/*
* Custom block styles
*/

function register_button_block_styles() {

register_block_style(
'core/heading',
array(
'name'  => 'orange-underline',
'label' => __( ' Underline', 'orange-underline' ),
)
);

register_block_style(
'core/cover',
array(
'name'  => 'full-width',
'label' => __( ' Full Width', 'style-5' ),
)
);

register_block_style(
'core/group',
array(
'name'  => 'full-width',
'label' => __( ' Full Width', 'full-width' ),
)
);

register_block_style(
'core/button',
array(
'name'  => 'outline',
'label' => __( ' Outline', 'outline' ),
)
);


}
add_action( 'init', 'register_button_block_styles' );


/*
* Custom Blocks
*/

add_action('acf/init', 'my_acf_init');
function my_acf_init() {

if( function_exists('acf_register_block') ) {

acf_register_block(array(
'name'              => 'app-slider',
'title'             => __('Application Slider'),
'description'       => __('Slider for the application page'),
'render_callback'   => 'my_acf_block_render_callback',
'category'          => 'custom-super-empower',
'icon'              => 'format-image',
'keywords'          => array( 'media', 'slider', 'application' ),
));

acf_register_block(array(
'name'              => 'app-slider-large',
'title'             => __('Application Slider (Large)'),
'description'       => __('Slider for the application page'),
'render_callback'   => 'my_acf_block_render_callback',
'category'          => 'custom-super-empower',
'icon'              => 'format-image',
'keywords'          => array( 'media', 'slider', 'application', 'large' ),
));

acf_register_block(array(
'name'              => 'logo-slider',
'title'             => __('Logo Slider'),
'description'       => __('Slider for logos'),
'render_callback'   => 'my_acf_block_render_callback',
'category'          => 'custom-super-empower',
'icon'              => 'format-image',
'keywords'          => array( 'media', 'slider', 'logo' ),
));

acf_register_block(array(
'name'              => 'gallery',
'title'             => __('Gallery'),
'description'       => __('Product gallery'),
'render_callback'   => 'my_acf_block_render_callback',
'category'          => 'custom-super-empower',
'icon'              => 'format-image',
'keywords'          => array( 'gallery', 'images', 'product' ),
));

}

}

function my_acf_block_render_callback( $block ) {
$slug = str_replace('acf/', '', $block['name']);
if( file_exists( get_theme_file_path("/blocks/block-{$slug}.php") ) ) {
include( get_theme_file_path("/blocks/block-{$slug}.php") );
}
}

/*
* Allow SVG uploads
*/

add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {

global $wp_version;
if ( $wp_version !== '4.7.1' ) {
return $data;
}

$filetype = wp_check_filetype( $filename, $mimes );

return [
'ext'             => $filetype['ext'],
'type'            => $filetype['type'],
'proper_filename' => $data['proper_filename']
];

}, 10, 4 );

function cc_mime_types( $mimes ){
$mimes['svg'] = 'image/svg+xml';
return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

function fix_svg() {
echo '<style type="text/css">
    .attachment-266x266, .thumbnail img {
        width: 100% !important;
        height: auto !important;
    }
</style>';
}
add_action( 'admin_head', 'fix_svg' );

/*
* Custom Shortcodes
*/
include( get_theme_file_path("/inc/shortcodes.php") );

/*
* WooCommerce
*/
include( get_theme_file_path("/inc/woocommerce.php") );


// ACF
add_action('admin_head', 'admin_styles');
function admin_styles() {
?>
<style>
    .acf-field.acf-field-wysiwyg,
    .acf-field.acf-field-image {
        min-height: 150px !important;
        height: auto !important;
    }
    .acf-editor-wrap iframe {
        min-height: 0px !important;
        height: auto !important;
    }
</style>
<?php

}
?>