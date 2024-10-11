<?php
/**
* Adds style CSS in guttenberg
**/

function register_button_block_styles() {

    register_block_style(
        'core/paragraph',
            array(
            'name'  => 'paragraph-large',
            'label' => __( ' Large', 'p-large' ),
        )
    );

}

add_action( 'init', 'register_button_block_styles' );




/*
* Block: Update cover with mobile image
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

?>