<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package runway-bootstrap-starter
 */
?>
	
	<div class="col-sm-3 leg_item">
		<?php 
			if ( has_post_thumbnail() ) {
				the_post_thumbnail();
			}
		?> 
		<h2><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
		<strong>Date</strong>: <?php echo get_field( "available_date" ); ?><br>
		<strong>Departure</strong>: <?php echo get_field( "departure" ); ?><br>
		<strong>Destination</strong>: <?php echo get_field( "destination" ); ?><br>
		<strong>Max Pax</strong>: <?php echo get_field( "max_pax" ); ?><br>
		<strong>Per Booking</strong>: $<?php echo get_field( "fee_per_booking" ); ?>
		
		<?php $amount = get_field( "fee_per_booking" )*100;?>
		
		<?php echo do_shortcode('[stripe id="'.$post->ID.'" name="'.get_the_title().'" amount="'.$amount.'" prefill_email="true"][/stripe]'); ?>
		
	</div><!-- .entry-content -->

