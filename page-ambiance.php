<?php
/**
 * Template Name: Ambiance
 */
?>
<?php get_header(); ?>

<main>

<?php 

$images = get_field('photos');

if( $images ): ?>

<div class="container">
    <div class="link-back-container">
        <a class="link-back" href="javascript:history.go(-1)">Terug naar home</a>
    </div><!-- /.back-link-container -->
    <div class="photo-grid">

        <?php foreach( $images as $image ): ?>
            <div class="single-photo">
                <img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>" />
            </div>
        <?php endforeach; ?>
        
    </div><!-- /.image-container -->
</div><!-- /.container -->

<?php endif; ?>

</main>

<?php get_footer(); ?>