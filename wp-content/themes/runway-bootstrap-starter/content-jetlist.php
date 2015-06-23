<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package runway-bootstrap-starter
 */
?>
	
	<div class="col-sm-4 leg_item">
		<div class="leg_item_body">
			<?php 
				if ( has_post_thumbnail() ) {
					the_post_thumbnail();
				}
			?> 
			<h2><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
			<strong>Date</strong>: 
				<?php $date = get_field( "available_date" );
				
				if($date && $date!="") echo $show_date = DateTime::createFromFormat('d/m/Y', $date)->format('m/d/Y');
				?>
			<br>
			<strong>Departure</strong>: <?php echo get_field( "departure" ); ?><br>
			<strong>Destination</strong>: <?php echo get_field( "destination" ); ?><br>
			<strong>Max Pax</strong>: <?php echo get_field( "max_pax" ); ?><br>
			<strong>Per Booking</strong>: $<?php echo get_field( "fee_per_booking" ); ?>
			
			<?php $amount = get_field( "fee_per_booking" )*100;?>
		</div>
		<a href="<?php echo get_permalink(); ?>" class="btn btn-success center-block">Details</a>
		
	</div><!-- .entry-content -->

