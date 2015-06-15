<?php
/*
 * Template Name: Home
 */
	get_header();
?>	
	<?php
		if(have_posts()):
			while(have_posts()) : the_post();?>
			
				<section>
					<div id="slider_container">
						<?php if ( function_exists( 'easingslider' ) ) { easingslider( 44 ); } ?>
					</div>
					<div class="wings bg5">
						<img src="https://www.royaljets.com/template/wp-content/themes/royaljets-new-theme/images/wings.png" />
					</div>
				</section>
				
				<section id="home" class="content">
					<!--<div class="bg2 bg-image1">-->
					<div class="container well center no-background">
						<div class="row wow fadeInUp" data-wow-delay="0.2s">
							<div class="grid_10 preffix_1">
								<h3 class="page-title">Our Mission</h3>
								<p class="text1">
									Royal Jets mission is to treat each client like royalty, providing 
									a royal experience that surpasses all others, while maintaining our dedication to reliability, 
									safety, and convenience.
								</p>
								<!-- <div></div>-->
							</div>
						</div>
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
				
				
				<section id="company" class="content">
					<div class="bg5"></div>
					<div class="bg5">
						<div class="container">
							<div class="row">
								<div class="grid_12">
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
						</div>
					</div>				
				</section>
				
	
	
				
				<section id="partners" class="content">
					<div class="bgwhite">
						<div class="container well">
							<div class="row">
								<div class="grid_10 preffix_1">
									<div class="center">
										<h4 class="part-title">Our Partners</h4>
									</div>
									<div class="well0">
								<?php 
									kw_sc_logo_carousel('default');
								?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
	
	
	
	
	
	
				<section id="news" class="content">
					<div class="bg5">
					<div class="container">
					<div class="row">
					<div class="grid_10 preffix_1">
					<div class="wellnopadd center">
						<h3>NEWS</h3>
						Royal Jets has been featured in a variety of news publications and 
						has garnered media coverage for the positive impact it has made in the community.
					</div>
					</div>
					</div>             
					</div>
					</div>
					<div class="bg5">
					<div class="container">
					<div class="row">
					<div class="grid_10 preffix_1">
					<div class="well">
					
					<div class="col-sm-6" style="margin-left:0;">
						<h4>PRESS RELEASE</h4>   
						<p class="pcontent"></p>
						<div class="image_float"> 
							<ul class="magazine-logos">
								<div class="image_float_inner"> 
									<li>
										<a href="http://okmagazine.com/uncategorized/party-like-a-mob-wife-inside-big-angsblow-out-birthday-bash/">
											<img src="http://www.royaljets.com/template/wp-content/uploads/2015/06/ok.png" alt="OK! Magazine">
										</a>
									</li>
								</div>
								<div class="image_float_inner">
									<li>
										<a href="http://www.charterbroker.aero/newsrelease.html?id=29121"><img src="http://www.royaljets.com/template/wp-content/uploads/2015/06/charter.png" alt="Charter Broker Magazine" width="190px" /></a>
									</li>
									<li>
									<a href="http://rainemagazine.com/volume-23-time-sensitive/-Examiner.com">
										<img src="http://www.royaljets.com/template/wp-content/uploads/2015/06/raine.png" width="190px" alt="Raine Magazine">
									</a>
									</li>
									<li>
										<a href="http://www.examiner.com/article/bigg-ang-celebrates-her- birthday-at-hermiami-club-miami-monkey/">
											<img src="http://www.royaljets.com/template/wp-content/uploads/2015/06/examiner.png" alt="Examiner Magazine">
										</a>
									</li>
								</div>
							</ul>
						</div>
					</div>
					
					<div class="col-sm-6">
						<div class="heading">Royal Blog</div>   
						<div class="royalthumb"><a href="http://www.royaljets.com/template/why-its-g%d0%be%d0%bed-t%d0%be-fly-private/"><img width="900" height="292" src="http://www.royaljets.com/template/wp-content/uploads/2015/06/Airplane-pic.jpg" class="aligncenter wp-post-image" alt="Airplane-pic" /></a></div>
						<p class="title"><a href="http://www.royaljets.com/template/why-its-g%d0%be%d0%bed-t%d0%be-fly-private/" title="Why it’s gооd tо fly private?" class="post-title"><h4>Why it’s gооd tо fly private?</h4></a></p>
						<p class="pcontent">Travеling arоund thе wоrld оn a privatе ...<a href="http://www.royaljets.com/template/why-its-g%d0%be%d0%bed-t%d0%be-fly-private/">Read More</a></p>
					</div>
					
					<div style="clear:both;"></div>
					</div>
					</div>
					</div>
					</div>
					</div>
					 
				</section>
	
	<!--  Management Team Section start -->
    <div id="contacts" class="bg3">

            <div class="container well8 center">
		<h4>LEADERSHIP</h4>
                <div class="row">

		
                    <div class="col-sm-4 wow fadeIn" data-wow-delay="0.2s">

                        <blockquote class="quote">

                            <div class="quote_cnt" style="min-height:250px;">

                                <p>“With over 20 years of experience, John Dutton is a high-level executive who knows how to strategically grow businesses and create profitable companies.  As a leading Wall Street Analyst he pioneered research that launched publicly traded hospital chains as well as has extensive experience in raising capital.  Mr. Dutton is a NASDAQ Committee Member and is a key component to the culture at Royal Jets.”</p>

                                <h6 class="quote_author"> John Dutton</h6>

				 					
				
                                <p class="quote_credits">CFO</p>

                            </div>

                            <div class="quote_photo"><img width="100" height="100" src="http://www.royaljets.com/template/wp-content/uploads/2015/06/John-M-Dutton.jpg" class="attachment-post-thumbnail wp-post-image" alt="John M Dutton" /></div>

                        </blockquote>

                    </div>
	
                    <div class="col-sm-4 wow fadeIn" data-wow-delay="0.2s">

                        <blockquote class="quote">

                            <div class="quote_cnt" style="min-height:250px;">

                                <p>“James Hoxsie is an accomplished and highly regarded program manager with over 30 years in the Defense, Aerospace and Information Technology Industries. Mr Hoxsie has managed a variety of programs, his specialties of which include project planning, risk management, business capture, continuous improvement plans, and earned value management.”</p>

                                <h6 class="quote_author"> James Hoxsie</h6>

				 					
				
                                <p class="quote_credits">Program Director</p>

                            </div>

                            <div class="quote_photo"><img width="100" height="100" src="http://www.royaljets.com/template/wp-content/uploads/2015/06/Program-Manager.jpg" class="attachment-post-thumbnail wp-post-image" alt="Program Manager" /></div>

                        </blockquote>

                    </div>
	
                    <div class="col-sm-4 wow fadeIn" data-wow-delay="0.2s">

                        <blockquote class="quote">

                            <div class="quote_cnt" style="min-height:250px;">

                                <p>“Arun Prakash Maruthavanan , CMOconsulted a number of emerging companies in the areas of Branding, Strategic Positioning, Marketing Strategies, New Business Development and Social Media Strategies.”</p>

                                <h6 class="quote_author"> Arun Prakash Maruthavanan</h6>

				 					
				
                                <p class="quote_credits">CMO</p>

                            </div>

                            <div class="quote_photo"><img width="116" height="116" src="http://www.royaljets.com/template/wp-content/uploads/2015/06/iconimage.png" class="attachment-post-thumbnail wp-post-image" alt="iconimage" /></div>

                        </blockquote>

                    </div>
		
                  </div>

            </div>

        </div>			
				
		
		
		<!--  Testinomial Section start -->
    <div id="contacts" class="bg3_new">

            <div class="container well8 center">
		<h4>TESTIMONIALS</h4>

                <div class="row">


		
                    <div class="col-sm-4 wow fadeIn" data-wow-delay="0.2s">

                        <blockquote class="quote" >

                            <div class="quote_cnt" style="min-height:150px;">

                                <p>“Royal Jets has been absolutely amazing. The crew and staff are amazing.”</p>

                                 <h6 class="quote_author"> Kimberly &#8220;Lil Kim&#8221; Jones</h6>

 										
				
                                <p class="quote_credits">Music Mogul</p>


                            </div>
				

                            <div class="quote_photo"><img width="100" height="100" src="http://www.royaljets.com/template/wp-content/uploads/2015/06/img_31.jpg" class="attachment-post-thumbnail wp-post-image" alt="img_3" /></div>

                        </blockquote>

                    </div>

		
                    <div class="col-sm-4 wow fadeIn" data-wow-delay="0.2s">

                        <blockquote class="quote" >

                            <div class="quote_cnt" style="min-height:150px;">

                                <p>“Thank you for the travels provided by Royal Jets.Everyone please check them out.”</p>

                                 <h6 class="quote_author"> Music Man TY</h6>

 										
				
                                <p class="quote_credits">Music Producer</p>


                            </div>
				

                            <div class="quote_photo"><img width="100" height="100" src="http://www.royaljets.com/template/wp-content/uploads/2015/06/img_1.jpg" class="attachment-post-thumbnail wp-post-image" alt="img_1" /></div>

                        </blockquote>

                    </div>

		
                    <div class="col-sm-4 wow fadeIn" data-wow-delay="0.2s">

                        <blockquote class="quote" >

                            <div class="quote_cnt" style="min-height:150px;">

                                <p>“I enjoyed flying with Royal Jets.The pilots and staff were extremely professional and we had one of the smoothest flights ever.”</p>

                                 <h6 class="quote_author"> Alex Andrusjevich</h6>

 										
				
                                <p class="quote_credits">Investment Banker</p>


                            </div>
				

                            <div class="quote_photo"><img width="100" height="100" src="http://www.royaljets.com/template/wp-content/uploads/2015/06/img_2.jpg" class="attachment-post-thumbnail wp-post-image" alt="img_2" /></div>

                        </blockquote>
                    </div>

                </div>

            </div>

        </div>
<!--  Testinomial Section Ends -->
		
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
			<?php endwhile;
		endif; ?>
	
	
	<?php
	get_footer();
?>