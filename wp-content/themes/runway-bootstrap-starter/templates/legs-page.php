<?php
/**
 * Template Name: Empty Legs
 * 
 * The template for displaying full background cover pages.
 *
 * @package runway-bootstrap-starter
 */


get_header(); ?>
<div class="row emtpy_legs">
	<?php 			
		$args = array( 'post_type' => 'legs_products', 'posts_per_page' => 10 );
		$loop = new WP_Query( $args );
		while ( $loop->have_posts() ) : $loop->the_post();
		  
		  get_template_part( 'content', 'jetlist' );
		
		endwhile;
	?>

	<?php while ( have_posts() ) : the_post(); ?>

		

	<?php endwhile; // end of the loop. ?>
</div>




<?php get_footer(); ?>
