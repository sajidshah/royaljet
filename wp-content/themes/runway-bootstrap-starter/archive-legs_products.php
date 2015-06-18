<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package runway-bootstrap-starter
 */

get_header(); ?>
	<div class="row">
		<div id="content" class="col-sm-12 col-md-8">

			<?php // add the class "panel" below here to wrap the content-padder in Bootstrap style ;) ?>
			<div class="content-padder">

				<?php if ( have_posts() ) : ?>

					<?php if ( function_exists('rf_has_custom_header') && !rf_has_custom_header() ) : ?>

						<header class="page-header main-header">
							<h1 class="page-title">
								<?php
									if ( is_category() ) :
										single_cat_title();

									elseif ( is_tag() ) :
										single_tag_title();

									elseif ( is_author() ) :
										/* Queue the first post, that way we know
										 * what author we're dealing with (if that is the case).
										*/
										the_post();
										printf( __( 'Author: %s', 'framework' ), '<span class="vcard">' . get_the_author() . '</span>' );
										/* Since we called the_post() above, we need to
										 * rewind the loop back to the beginning that way
										 * we can run the loop properly, in full.
										 */
										rewind_posts();

									elseif ( is_day() ) :
										printf( __( 'Day: %s', 'framework' ), '<span>' . get_the_date() . '</span>' );

									elseif ( is_month() ) :
										printf( __( 'Month: %s', 'framework' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

									elseif ( is_year() ) :
										printf( __( 'Year: %s', 'framework' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

									elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
										_e( 'Asides', 'framework' );

									elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
										_e( 'Images', framework);

									elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
										_e( 'Videos', 'framework' );

									elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
										_e( 'Quotes', 'framework' );

									elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
										_e( 'Links', 'framework' );

									else :
										_e( 'Archives', 'framework' );

									endif;
								?>
							</h1>
							<?php
								// Show an optional term description.
								$term_description = term_description();
								if ( ! empty( $term_description ) ) :
									printf( '<div class="taxonomy-description">%s</div>', $term_description );
								endif;
							?>
						</header> <!-- .page-header -->

					<?php endif; ?>

					<?php 

					/* Start the Loop */
					while ( have_posts() ) : the_post();
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
					
					endwhile;

					// If we have a custom post nav function
					if (function_exists( 'rf_next_prev_post_nav' )) :

						rf_next_prev_post_nav( 'nav-below' );
					
					endif;

				else : 

					get_template_part( 'no-results', 'archive' ); 

				endif; // end of loop. ?>

			</div><!-- .content-padder -->

		</div><!-- / #content -->
		<div class="sidebar col-sm-12 col-md-4">

			<?php get_sidebar(); ?>

		</div><!-- /.sidebar -->
	</div><!-- /.row -->

<?php get_footer(); ?>
