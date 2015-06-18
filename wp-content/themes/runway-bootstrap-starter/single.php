<?php
/**
 * The Template for displaying all single posts.
 *
 * @package runway-bootstrap-starter
 */

get_header(); ?>
	<div class="row">
		<div id="content" class="col-sm-12 col-md-8">

		<?php 

		while ( have_posts() ) : the_post(); 

			get_template_part( 'content', 'single' );

			// If we have a custom post nav function
			if (function_exists( 'rf_next_prev_post_nav' )) {
				rf_next_prev_post_nav( 'nav-below' ); 
			}

			// If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || '0' != get_comments_number() ) {
				comments_template();
			}
			
		endwhile; // end of the loop. ?>

		</div><!-- / #content -->
		<div class="sidebar col-sm-12 col-md-4">

			<?php get_sidebar(); ?>

		</div><!-- /.sidebar -->
	</div><!-- /.row -->

<?php get_footer(); ?>