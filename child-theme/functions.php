<?php
/**
* Child Theme Functions
*/

// Child Theme Version
$ver = wp_get_theme()->get('Version');
define( 'CHILD_THEME_VERSION', $ver);

// Enqueue
function theme_styles() {

    //$verRnd = rand();
    wp_dequeue_style( 'generate-child-css' );
    wp_deregister_style( 'generate-child-css' );
    wp_enqueue_style( 'generate-child', get_stylesheet_directory_uri() . '/style.css', array() , CHILD_THEME_VERSION, false );
    wp_enqueue_style( 'common', get_stylesheet_directory_uri() . '/assets/css/common.css', array() , CHILD_THEME_VERSION, false);

    //wp_enqueue_script( 'jquery', get_stylesheet_directory_uri() . '/assets/js/vendor/jquery.min.js', array(), CHILD_THEME_VERSION, false );
    //wp_enqueue_script( 'slick', get_stylesheet_directory_uri() . '/assets/js/vendor/slick.min.js', array(), CHILD_THEME_VERSION, false );
    wp_enqueue_script( 'app', get_stylesheet_directory_uri() . '/assets/js/app.js', array(), CHILD_THEME_VERSION, true );

}
add_action( 'wp_enqueue_scripts', 'theme_styles' );

/*
* Remove WordPress bloat
*/

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

/*
* Custom Content Types
*/
include( get_theme_file_path("/inc/content-types.php") );

/*
* Taxonomies
*/
include( get_theme_file_path("/inc/taxomonies.php") );

/*
* ACF Fields
*/
include( get_theme_file_path("/inc/acf-fields.php") );

/*
* ACF Blocks
*/
include( get_theme_file_path("/inc/acf-blocks.php") );

/*
* Customized Blocks and Styles
*/
include( get_theme_file_path("/inc/block-styles.php") );

/*
* Utilities
*/
include( get_theme_file_path("/inc/media.php") );

/*
* Utilities
*/
include( get_theme_file_path("/inc/utilities.php") );
