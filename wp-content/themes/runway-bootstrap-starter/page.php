<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package runway-bootstrap-starter
 */

	get_header(); ?>

	<div class="row">

		<div class="col-sm-10">

			<?php while ( have_posts() ) : the_post(); ?>
				
				
				<?php
					if (has_post_thumbnail() ) 
					{ // check if the post has a Post Thumbnail assigned to it.
						the_post_thumbnail();
					} 
				?>

				<?php the_content(); ?>

			<?php endwhile; // end of the loop. ?>

		</div>

	</div><!-- /.row -->
	
	

	<?php get_footer(); ?>
