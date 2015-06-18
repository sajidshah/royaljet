<?php
/**
 * The theme footer
 * 
 * @package bootstrap-basic
 */
?>

			<footer id="footer" class="footer">
				<div class="container">
					<div class="row">
						<div class="col-sm-4 wow fadeInLeft" data-wow-delay="0.2s">
							<aside id="nav_menu-2" class="widget widget_nav_menu">
								<h1 class="widget-title">Footer Menu</h1>
								<!--<div class="menu-footer-menu-container">
									<ul id="menu-footer-menu" class="menu">
										<li id="menu-item-51" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-51"><a href="https://www.royaljets.com/template/services/">Service</a></li>
										<li id="menu-item-50" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-50"><a href="https://www.royaljets.com/template/members/">Members</a></li>
										<li id="menu-item-49" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-49"><a href="https://www.royaljets.com/template/partners/">Partners</a></li>
										<li id="menu-item-48" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-48"><a href="https://www.royaljets.com/template/news/">News</a></li>
										<li id="menu-item-47" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-12 current_page_item menu-item-47"><a href="https://www.royaljets.com/template/company/">Company</a></li>
										<li id="menu-item-128" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-128"><a href="http://royaljets.com/template/forums">Forum</a></li>
									</ul>
								</div>-->
								
								<?php
								$args = array(
										'theme_location' =>'footer',
										'container_class' => 'menu-footer-menu-container',
										'items_wrap'      => '<ul id="menu-footer-menu" class="menu">%3$s</ul>'
										);
								?>
								
								<?php wp_nav_menu($args); ?>
								
							</aside>
                		</div>
                		
						<div class="col-sm-4 wow fadeInLeft" data-wow-delay="0.4s">
							<aside id="text-2" class="widget widget_text">
								<h1 class="widget-title">Disclaimer</h1>
								<div class="textwidget">
									Royal Jets do not own or operate any aircraft. Royal Jets acts as agent for the Royalty Members
								</div>
							</aside>
                		</div>
                		
                		<div class="col-sm-4 wow fadeInLeft" data-wow-delay="0.6s">
							<aside id="text-3" class="widget widget_text">
								<h1 class="widget-title">Get In Touch</h1>
								<div class="textwidget">
									<address class="addr">
										<p>1100 New Hwy<br/>Farmingdale, New York 11735.</p>
										<dl><dt>Freephone:</dt><dd>+1 877 626 6952</dd></dl>
										<dl><dt>FAX:</dt><dd>+ +1 877 626 6952</dd></dl>
										<p>E-mail: <a href="#">Info@royaljets.com</a></p>
									</address>
								</div>
							</aside>
						</div>
					</div>
					
					<div class="copyright">
						RoyalJets
						© <span id="copyright-year"></span>
                		<a href="index-1.html">Privacy policy</a>
                		<!-- {%FOOTER_LINK} -->
                	</div>
				</div>
				<!--<div id="google-map" class="map"></div>-->
			</footer>
			
		</div><!-- .page -->



<script>
	jQuery(document).ready(function()
	{
		jQuery(".kiwi-logo-carousel-default").bxSlider(
		{
			mode:"horizontal",speed:500,slideMargin:0,infiniteLoop:true,hideControlOnEnd:false,captions:false,ticker:false,tickerHover:false,adaptiveHeight:false,responsive:true,pager:false,controls:false,autoControls:false,minSlides:1,maxSlides:4,moveSlides:1,slideWidth:200,auto:true,pause:4000,useCSS:false
		});
		jQuery(".kiwi-logo-carousel-partners").bxSlider(
		{
			mode:"horizontal",speed:500,slideMargin:0,infiniteLoop:true,hideControlOnEnd:false,captions:false,ticker:false,tickerHover:false,adaptiveHeight:false,responsive:true,pager:false,controls:false,autoControls:false,minSlides:1,maxSlides:5,moveSlides:1,slideWidth:200,auto:true,pause:4000,useCSS:false
		});
		jQuery(".kiwi-logo-carousel-partners-list").bxSlider(
		{
			mode:"horizontal",speed:500,slideMargin:0,infiniteLoop:true,hideControlOnEnd:false,captions:false,ticker:false,tickerHover:false,adaptiveHeight:false,responsive:true,pager:false,controls:false,autoControls:false,minSlides:1,maxSlides:5,moveSlides:1,slideWidth:200,auto:true,pause:4000,useCSS:false
		});
	});
</script>
<div class="scroll-back-to-top-wrapper">
	<span class="scroll-back-to-top-inner">
					<i class="fa fa-2x fa-arrow-circle-up"></i>
			</span>
<script type='text/javascript'>
/* <![CDATA[ */
	var scrollBackToTop = {"scrollDuration":"500","fadeDuration":"0.5"};
/* ]]> */
</script>
<script type='text/javascript' src='https://www.royaljets.com/template/wp-content/plugins/scroll-back-to-top/assets/js/scroll-back-to-top.js'></script>
<script type='text/javascript' src='https://www.royaljets.com/template/wp-includes/js/comment-reply.min.js?ver=4.2.2'></script>
<script type='text/javascript' src='https://www.royaljets.com/template/wp-includes/js/masonry.min.js?ver=3.1.2'></script>
<script type='text/javascript' src='https://www.royaljets.com/template/wp-includes/js/jquery/jquery.masonry.min.js?ver=3.1.2'></script>
<script type='text/javascript' src='https://www.royaljets.com/template/wp-content/themes/royaljets-new-theme/js/functions.js?ver=20140616'></script>

<script src="https://www.royaljets.com/template/wp-content/themes/royaljets-new-theme/js/script.js"></script>

<script type="text/javascript">

 var _gaq = _gaq || [];

  _gaq.push(['_setAccount', 'UA-7078796-5']);

  _gaq.push(['_trackPageview']);

  (function() {

    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;

    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';

    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);

  })();
</script>

</body>

</html>



<!--========================================================

                              FOOTER

    =========================================================-->

    