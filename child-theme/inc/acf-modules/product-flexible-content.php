<?php
/**
 * Include file for flexible content
 */

if( have_rows('flexible-name') ):

    while ( have_rows('flexible-name') ) : the_row();
        if( get_row_layout() == 'block_name' ):
            get_template_part('inc/acf/block-file-name');

        elseif( get_row_layout() == 'block_name' ):
            get_template_part('inc/acf/block-file-name');

        elseif( get_row_layout() == 'feature_blocks' ):
            get_template_part('inc/acf/block-file-name');

        endif;
    endwhile;

endif;
?>
