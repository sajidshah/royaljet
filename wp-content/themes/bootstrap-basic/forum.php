<?php
/*
 * Template Name: Forum
 */
	get_header();
?>	
	<?php
		if(have_posts()):
			while(have_posts()) : the_post();?>
				
				<section id="content" class="content">
					<div class="container well center">
						<div class="row">
							<div class="grid_10 preffix_1">
								<h3 class="page-title">Forum</h3>
								<div class="avlblnc"></div>
							</div>
						</div>
					</div>
				</section>
				
			<?php endwhile;
		endif; ?>
	
	
	<?php
	get_footer();
?>