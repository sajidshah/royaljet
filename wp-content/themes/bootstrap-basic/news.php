<?php
/*
 * Template Name: News
 */
	get_header();
?>	
	<?php
		if(have_posts()):
			while(have_posts()) : the_post();?>
				
				<section class="content">
					<div class="bg5">
						<div class="container">
							<div class="row">
								<div class="grid_10 preffix_1">
									<div class="wellnopadd center">
										<h3>NEWS</h3>
										<p>
											Royal Jets has been featured in a variety of news 
											publications and has garnered media coverage for the positive 
											impact it has made in the community.
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
				
				<section>
					<div class="wings bg5">
						<img src="https://www.royaljets.com/template/wp-content/themes/royaljets-new-theme/images/wings.png" />
					</div>
				</section>
				
			<?php endwhile;
		endif; ?>
	
	
	<?php
	get_footer();
?>