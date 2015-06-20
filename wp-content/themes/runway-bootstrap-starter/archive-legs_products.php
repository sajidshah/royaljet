<?php
/**
 * Template Name: Empty Legs
 * 
 * The template for displaying full background cover pages.
 *
 * @package runway-bootstrap-starter
 */


get_header(); ?>
<div class="nav navbar-default menu-legs">
	<div class="container-fluid">
		<div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	    </div>
	    
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	    	<ul class="nav navbar-nav">
				<li><a href="">Show All</a></li>
				<li><a href="">Empty Legs</a></li>
				<li><a href="">Recent First</a></li>
				<li><a href="">Owners Top Picks</a></li>
			</ul>
	      
	    </div>
	</div>
</div>
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
