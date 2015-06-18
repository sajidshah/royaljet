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

		while ( have_posts() ) : the_post(); ?>
		
			<?php 
				if ( has_post_thumbnail() ) {
					the_post_thumbnail();
				}
			?> 

			<h2><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
			
			<?php 
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

		<strong>Date</strong>: <?php echo get_field( "available_date" ); ?><br>
		<strong>Departure</strong>: <?php echo get_field( "departure" ); ?><br>
		<strong>Destination</strong>: <?php echo get_field( "destination" ); ?><br>
		<strong>Max Pax</strong>: <?php echo get_field( "max_pax" ); ?><br>
		<strong>Per Booking</strong>: $<?php echo get_field( "fee_per_booking" ); ?>
		
		<?php $amount = get_field( "fee_per_booking" )*100;?>
		
		<?php echo do_shortcode('[stripe id="'.$post->ID.'" name="'.get_the_title().'" amount="'.$amount.'" prefill_email="true"][/stripe]'); ?>
		
		<?php 
		$images = get_field('aircraft_image');

		if( $images ): ?>
		    <div class="gallery">
		        <?php foreach( $images as $image ): ?>
		        	<dl class="gallery-item">
						<dt class="gallery-icon landscape">
							<a href="<?php echo $image['url']; ?>"><img width="150" height="150" src="<?php echo $image['sizes']['thumbnail']; ?>" class="attachment-thumbnail" alt="<?php echo $image['alt']; ?>"></a>
						</dt>
					</dl>
		        <?php endforeach; ?>
		    </div>
		<?php endif; ?>

		</div><!-- /.sidebar -->
	</div><!-- /.row -->

<?php get_footer(); ?>