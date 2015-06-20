<?php
/**
 * Template Name: Empty Legs
 * 
 * The template for displaying full background cover pages.
 *
 * @package runway-bootstrap-starter
 */

$user = new WP_User( $user_ID );
$silver = (in_array('member_silver', $user->roles)) ? true : false;
$gold = (in_array('member_gold', $user->roles)) ? true : false;
$admin = (in_array('administrator', $user->roles)) ? true : false;

if(!$black && !$silver && !$gold && !$admin) return_404();
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
				<li><a href="<?php echo site_url('product'); ?>">Recently Added</a></li>
				<li><a href="<?php echo site_url('product/?top=1'); ?>">Owners Top Picks</a></li>
			</ul>
	      
	    </div>
	</div>
</div>
<div class="row emtpy_legs">
	<?php
		
		$top = isset($_GET['top']) ? $_GET['top'] : false;
		
		if($top){
			$args = array( 'post_type' => 'legs_products', 
		
				'meta_query' => array(
			        array(
			            'key' => 'owners_top_pick', // name of custom field
			            'value' => '"Owner Top Choice"', // matches exaclty "red", not just red. This prevents a match for "acquired"
			            'compare' => 'LIKE'
			        )
			    )
				
			);
			query_posts( $args );
		
		}
		
		while ( have_posts() ) : the_post();
		  
		  get_template_part( 'content', 'jetlist' );
		
		endwhile;
	?>
	
</div>

<div class="pagination">
	<div class="nav-previous alignleft"><?php next_posts_link( 'Previous' ); ?></div>
	<div class="nav-next alignright"><?php previous_posts_link( 'Next' ); ?></div>
</div>
<?php get_footer(); ?>