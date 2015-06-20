<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package runway-bootstrap-starter
 */

get_header(); ?>
	
	<section id="mission">
		<div class="row pad">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="aligncenter">
					<h3>Our Mission</h3>
					<p>
						Royal Jets mission is to treat each client like royalty, providing 
						a royal experience that surpasses all others, while maintaining our dedication to reliability, 
						safety, and convenience.
					</p>
				</div>
			</div>
		</div><!-- /.row -->
	</section>
	
	<section id="service">
		<div class="row pad">
			<div class="col-sm-10 col-sm-offset-1">
				<!--<h3 class="page-title"></h3>-->
				<div class="row">
					<div class="col-sm-6">
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
					</div>
					<div class="col-sm-6">
						<img src="http://www.royaljets.com/template/wp-content/uploads/2015/04/img1.png" alt="img1" width="658" height="331" />
					</div>
				</div>
				<div class="row">	
					<div class="col-sm-6">
						<h4>Aircraft</h4>
						<p>
							Royal Jets has an extensive network of carefully selected 
							all of our operators are FAA certified and follow all the federal 
							regulation guidelines. Our customer have the luxury to choose from 
							any aircraft of any size.
						</p>
					</div>
					<div class="col-sm-6">
						<img src="http://www.royaljets.com/template/wp-content/uploads/2015/04/img2.jpg" alt="img2" width="658" height="332" />
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section id="charities">
		<div class="row pad">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="aligncenter">
					<h4>CHARITIES</h4>
					<p>
						Royal Jets cares and invests in the community and has partnered with charitable organizations including &#8211;<br />
						The Balcony New York, The Family Center, and Chris Smith Basketball Clinic.
					</p>
					<div class="col-sm-4">
						<img src="http://www.royaljets.com/template/wp-content/uploads/2015/06/balcony-300x56_2.png" alt="balcony"/>
						<p>The Balcony New York</p>
					</div>
					<div class="col-sm-4">
						<img src="http://www.royaljets.com/template/wp-content/uploads/2015/06/famcenter-300x126.png" alt="famcenter" />
						<a href="http://www.thefamilycenter.org/2014/10/30/tfc-turns20/">The Family Center </a>
					</div>
					<div class="col-sm-4">
						<img src="http://www.royaljets.com/template/wp-content/uploads/2015/06/knicks_2.png" alt="knicks"/> <br />
						<a href="http://grungygentleman.com/post/view/chris-smith-basketball-clinic.">Chris Smith Basket Ball Clinic </a>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section id="partners">
		<div class="row pad">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="aligncenter">
					<h4>Our Partners</h4>
					<?php 
						kw_sc_logo_carousel('default');
					?>
				</div>
			</div>
		</div>
	</section>
	
	<section id="news">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="aligncenter">
					<h3>NEWS</h3>
					<p>
						Royal Jets has been featured in a variety of news publications and 
						has garnered media coverage for the positive impact it has made in the community.
					</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="row">
					<div class="col-sm-4">
						<h4>PRESS RELEASE</h4>   
						<a href="http://okmagazine.com/uncategorized/party-like-a-mob-wife-inside-big-angsblow-out-birthday-bash/">
							<img src="http://www.royaljets.com/template/wp-content/uploads/2015/06/ok.png" alt="OK! Magazine">
						</a>
					</div>
					
					<div class="col-sm-4 news-col2">
						<a href="http://www.charterbroker.aero/newsrelease.html?id=29121">
							<img src="http://www.royaljets.com/template/wp-content/uploads/2015/06/charter.png" alt="Charter Broker Magazine" width="190px" />
						</a>
						
						<a href="http://rainemagazine.com/volume-23-time-sensitive/-Examiner.com">
							<img src="http://www.royaljets.com/template/wp-content/uploads/2015/06/raine.png" width="190px" alt="Raine Magazine">
						</a>
						
						<a href="http://www.examiner.com/article/bigg-ang-celebrates-her- birthday-at-hermiami-club-miami-monkey/">
							<img src="http://www.royaljets.com/template/wp-content/uploads/2015/06/examiner.png" alt="Examiner Magazine">
						</a>
					</div>
					
					<div class="col-sm-4">
						<h4 class="news-col3-head">Royal Blog</h4>
						<a href="http://www.royaljets.com/template/why-its-g%d0%be%d0%bed-t%d0%be-fly-private/">
							<img width="900" height="292" src="http://www.royaljets.com/template/wp-content/uploads/2015/06/Airplane-pic.jpg" class="aligncenter wp-post-image" alt="Airplane-pic" />
						</a>
						<a href="http://www.royaljets.com/template/why-its-g%d0%be%d0%bed-t%d0%be-fly-private/" title="Why it’s gооd tо fly private?" class="post-title">
							<h4>Why it’s gооd tо fly private?</h4>
						</a>
						<p>Travеling arоund thе wоrld оn a privatе ...
							<a href="http://www.royaljets.com/template/why-its-g%d0%be%d0%bed-t%d0%be-fly-private/">Read More</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section id="leader" class="pad">
		<h4 class="aligncenter">LEADERSHIP</h4>
		<div class="row leader-row">
			<div class="col-sm-4">
				<blockquote class="quote">
					<div class="quote-back">
						<p>
							“With over 20 years of experience, John Dutton is a high-level executive who knows how to strategically grow 
							businesses and create profitable companies.  As a leading Wall Street Analyst he pioneered research that launched publicly 
							traded hospital chains as well as has extensive experience in raising capital.  Mr. Dutton is a NASDAQ Committee Member 
							and is a key component to the culture at Royal Jets.”
						</p>
						<h6> John Dutton</h6>
						<p>CFO</p>
					</div>
					<div class="quote_photo">
						<img width="100" height="100" src="http://www.royaljets.com/template/wp-content/uploads/2015/06/John-M-Dutton.jpg" class="attachment-post-thumbnail wp-post-image" alt="John M Dutton" />
					</div>
				</blockquote>
			</div>
			<div class="col-sm-4">
				<blockquote class="quote">
					<div class="quote-back">
						<p>
							“James Hoxsie is an accomplished and highly regarded program manager with over 30 years in the Defense, Aerospace and Information 
							Technology Industries. Mr Hoxsie has managed a variety of programs, his specialties of which include project planning, 
							risk management, business capture, continuous improvement plans, and earned value management.”
						</p>
						<h6>James Hoxsie</h6>
						<p>Program Director</p>
					</div>
					<div class="quote_photo">
						<img width="100" height="100" src="http://www.royaljets.com/template/wp-content/uploads/2015/06/Program-Manager.jpg" class="attachment-post-thumbnail wp-post-image" alt="Program Manager" />
					</div>
				</blockquote>
			</div>
			<div class="col-sm-4">
				<blockquote class="quote">
					<div class="quote-back">
						<p>
							“Arun Prakash Maruthavanan , CMOconsulted a number of emerging companies in the areas of Branding, Strategic Positioning, Marketing 
							Strategies, New Business Development and Social Media Strategies.”
						</p>
						<h6 class="quote_author"> Arun Prakash Maruthavanan</h6>
						<p class="quote_credits">CMO</p>
					</div>
					<div class="quote_photo">
						<img width="116" height="116" src="http://www.royaljets.com/template/wp-content/uploads/2015/06/iconimage.png" class="attachment-post-thumbnail wp-post-image" alt="iconimage" />
					</div>
				</blockquote>
			</div>
		</div>
	</section>
	
	<section id="testimonial">
		<div class="row pad">
			<h4 class="aligncenter">TESTIMONIALS</h4>
		
			<div class="col-sm-4">
				<blockquote class="quote" >
					<div class="quote-back">
						<p>“Royal Jets has been absolutely amazing. The crew and staff are amazing.”</p>
						<h6>Kimberly &#8220;Lil Kim&#8221; Jones</h6>
						<p>Music Mogul</p>
					</div>
					<div class="quote_photo">
						<img width="100" height="100" src="http://www.royaljets.com/template/wp-content/uploads/2015/06/img_31.jpg" class="attachment-post-thumbnail wp-post-image" alt="img_3" />
					</div>
				</blockquote>
			</div>
			<div class="col-sm-4">
				<blockquote class="quote" >
					<div class="quote-back">
						<p>“Thank you for the travels provided by Royal Jets.Everyone please check them out.”</p>
						<h6>Music Man TY</h6>
						<p>Music Producer</p>
					</div>
					<div class="quote_photo">
						<img width="100" height="100" src="http://www.royaljets.com/template/wp-content/uploads/2015/06/img_1.jpg" class="attachment-post-thumbnail wp-post-image" alt="img_1" />
					</div>
				</blockquote>
			</div>
			<div class="col-sm-4">
				<blockquote class="quote" >
					<div class="quote-back">
						<p>“I enjoyed flying with Royal Jets.The pilots and staff were extremely professional and we had one of the smoothest flights ever.”</p>
						<h6>Alex Andrusjevich</h6>
						<p>Investment Banker</p>
					</div>
					<div class="quote_photo">
						<img width="100" height="100" src="http://www.royaljets.com/template/wp-content/uploads/2015/06/img_2.jpg" class="attachment-post-thumbnail wp-post-image" alt="img_2" />
					</div>
				</blockquote>
			</div>
		
		</div>
	</section>
	
	
	


<?php get_footer(); ?>

