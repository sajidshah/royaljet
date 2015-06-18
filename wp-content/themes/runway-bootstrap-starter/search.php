<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package runway-bootstrap-starter
 */

get_header(); ?>
	<div class="row">
		<div id="content" class="col-sm-12">

		<?php 

		if ( have_posts() ) : ?>

			<?php if ( function_exists('rf_has_custom_header') && !rf_has_custom_header() ) : ?>
				<header class="page-header main-header">
					<h2 class="page-title"><?php printf( __( 'Search Results for: %s', 'framework' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
				</header> <!-- .page-header -->
			<?php endif; ?>

			<?php 

			// start the loop. 
			while ( have_posts() ) : the_post(); 

				get_template_part( 'content', 'search' ); 

			endwhile; 

			// If we have a custom post nav function
			if (function_exists( 'rf_next_prev_post_nav' )) :

				rf_next_prev_post_nav( 'nav-below' ); 
			
			endif;
		
		else : 

			get_template_part( 'no-results', 'search' ); 

		endif; // end of loop. ?>

		</div><!-- / #content -->
	</div><!-- /.row -->

<?php get_footer(); ?>