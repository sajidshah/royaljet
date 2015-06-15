<?php
/*
 * Template Name: services
 */
	get_header();
?>	
	<?php
		if(have_posts()):
			while(have_posts()) : the_post();?>
				
				<section>
					<div class="container">
						<img src= "<?php echo get_template_directory_uri() . '/img/services.jpg' ?>" />
					</div>
					<div class="wings bg5">
						<img src="https://www.royaljets.com/template/wp-content/themes/royaljets-new-theme/images/wings.png" />
					</div>
				</section>
				
				<section id="service" class="content">
					<div class="container well no-background">
						<div class="row">
							<div class="grid_10 preffix_1">
								<!--<h3 class="page-title"></h3>-->
								<p class="text1">
									<div class="grid_5" style="margin-left:0;">
										<h4>Service</h4>
										<p>
											Royal Jets offers accessible luxury through a convenient and 
											flexible membership model that allows for freedom and an incomparable 
											experience. No longer is private jet travel a distant wish, but 
											with Royal Jets, it becomes a lovely reality.
										</p>
										<p>
											Royal Jet has a variety of choices for travel, 
											with a network of aircrafts to choose from when booking 
											travel plans, whether that be for business or pleasure.
										</p>
										<h4>Aircraft</h4>
										<p>
											Royal Jets has an extensive network of carefully selected 
											all of our operators are FAA certified and follow all the federal 
											regulation guidelines. Our customer have the luxury to choose from 
											any aircraft of any size.
										</p>
									</div>
									<div class="grid_5">
										<img class="alignright size-full wp-image-147" src="http://www.royaljets.com/template/wp-content/uploads/2015/04/img1.png" alt="img1" width="658" height="331" />
										<br />
										<img class="alignright size-full wp-image-148" src="http://www.royaljets.com/template/wp-content/uploads/2015/04/img2.jpg" alt="img2" width="658" height="332" />
									</div>
								</p>
							</div>
						</div>
					</div>
				</section>
				
			<?php endwhile;
		endif; ?>
	
	
	<?php
	get_footer();
?>