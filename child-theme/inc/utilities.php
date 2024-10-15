<?php

// Allow execution of php with generate blocks
add_filter( 'generate_hooks_execute_php', '__return_true' );



/*
* Allow SVG uploads
*/
function enable_svg_upload( $mimes ) {
    // Allow SVG file upload
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'enable_svg_upload' );

// Sanitize SVG uploads to prevent security risks
function sanitize_svg( $file, $url ) {
    if ( strpos( $file['type'], 'svg' ) !== false ) {
        $file['type'] = 'image/svg+xml';
    }
    return $file;
}
add_filter( 'wp_check_filetype_and_ext', 'sanitize_svg', 10, 5 );


// Adjust ACF min wysiwyg field height
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

?>