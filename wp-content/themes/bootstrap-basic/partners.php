<?php
/*
 * Template Name: Partners
 */
	get_header();
?>	
	<?php
		if(have_posts()):
			while(have_posts()) : the_post();?>
				
				<section>
					<div class="container">
						<div class="row">
							<div class="well no-background">
								<h4 class="page-title">CHARITIES</h4>
								<div class="inrcntnt">
									<p class="text1">
										Royal Jets cares and invests in the community and has partnered with charitable organizations including &#8211;<br />
										The Balcony New York, The Family Center, and Chris Smith Basketball Clinic.
									</p>
									<ul class="charit">
										<li>
											<img src="http://www.royaljets.com/template/wp-content/uploads/2015/06/balcony-300x56_2.png" alt="balcony" width="300" height="56" class="alignleft size-medium wp-image-296" />
											<div class="tagline">The Balcony New York</div>
										</li>
										<li>
											<img src="http://www.royaljets.com/template/wp-content/uploads/2015/06/famcenter-300x126.png" alt="famcenter" width="300" height="126" class="alignleft size-medium wp-image-295" />
											<div class="tagline"><a href="http://www.thefamilycenter.org/2014/10/30/tfc-turns20/">The Family Center </a></div>
										</li>
										<li>
											<img src="http://www.royaljets.com/template/wp-content/uploads/2015/06/knicks_2.png" alt="knicks" width="186" height="143" class="alignleft size-full wp-image-300" />
											<div class="tagline"><a href="http://grungygentleman.com/post/view/chris-smith-basketball-clinic.">Chris Smith Basket Ball Clinic</a></div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="wings bg5">
						<img src="https://www.royaljets.com/template/wp-content/themes/royaljets-new-theme/images/wings.png" />
					</div>
				</section>
				
			<?php endwhile;
		endif; ?>
	
	
	<?php
	get_footer();
?>