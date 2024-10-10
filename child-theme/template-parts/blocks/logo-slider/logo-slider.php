<?php
/**
 * Block Name: Logo Slider
 */
?>

<?php if( have_rows('logos') ): ?>

<section class="sl-logos">
    <div class="sl-logos__list">

    <?php while( have_rows('logos') ): the_row();
        $logoImage = get_sub_field('logo_image');
        ?>
        <div class="sl-logos__item">
            <div class="sl-logos__inner"><img class="sl-logos__img" src="<?= $logoImage['sizes']['one-quarter']; ?>" alt="<?= $logoImage['alt']; ?>"/>
            </div>
        </div>
    <?php endwhile; ?>

    </div>
</section>

<?php endif; ?>