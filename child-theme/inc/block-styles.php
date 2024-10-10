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
?>