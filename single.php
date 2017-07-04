<?php get_header(); ?>

	<div class="single-header" style="background-image: url(<?php the_post_thumbnail_url('large'); ?>)">
		<div class="overlay"></div><!-- /.overlay -->
		<div class="container">
			<div class="link-back-container">
		        <a class="link-back" href="javascript:history.go(-1)">Terug naar home</a>
		    </div><!-- /.back-link-container -->
		    <h1><?php the_title(); ?></h1>
		</div><!-- /.container -->
	</div>

	<div class="single-content">
		<div class="container">
			
			<?php the_field('content'); ?>

		</div><!-- /.container -->
	</div><!-- /.single-content -->

<?php get_footer(); ?>
