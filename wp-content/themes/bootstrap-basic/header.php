<?php
/**
 * The theme header
 * 
 * @package bootstrap-basic
 */
?>
<!DOCTYPE html>
<!--[if lt IE 7]>  <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>     <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>     <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri().'/css/grid.css'?>">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri().'/css/jquery.fancybox.css'?>">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri().'/css/camera.css'?>">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri().'/css/contact-form.css'?>">
<meta charset="<?php bloginfo('charset'); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title><?php wp_title('|', true, 'right'); ?></title>
<meta name="viewport" content="width=device-width">

<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

<!--wordpress head-->
<?php wp_head(); ?>
</head>



<script type="text/javascript">

$(document).ready(function(){
	
$('.btn-apply').children('a').attr('href','http://www.royaljets.com/template/register');

$('.gform_title').css('display','none');

$('.gform_description').css('display','none');

  // $('.menu-main-menu-container').children('ul#menu-main-menu').eq(0).addClass('sf-menu');

});
$(function() {
	var availableTags = [
		"ActionScript",
"AppleScript",
"Asp",
"BASIC",
"C",
"C++",
"Clojure",
"COBOL",
"ColdFusion",
"Erlang",
"Fortran",
"Groovy",
"Haskell",
"Java",
"JavaScript",
"Lisp",
"Perl",
"PHP",
"Python",
"Ruby",
"Scala",
"Scheme"
];
$( "#deparfrom" ).autocomplete({
		source: availableTags
	});
});

</script>



<link rel="alternate" type="application/rss+xml" title="royaljets &raquo; Feed" href="https://www.royaljets.com/template/feed/" />
<link rel="alternate" type="application/rss+xml" title="royaljets &raquo; Comments Feed" href="https://www.royaljets.com/template/comments/feed/" />
<link rel="alternate" type="application/rss+xml" title="royaljets &raquo; Company Comments Feed" href="https://www.royaljets.com/template/company/feed/" />
<script type="text/javascript">
window._wpemojiSettings = {"baseUrl":"https:\/\/s.w.org\/images\/core\/emoji\/72x72\/","ext":".png","source":{"concatemoji":"https:\/\/www.royaljets.com\/template\/wp-includes\/js\/wp-emoji-release.min.js?ver=4.2.2"}};
!function(a,b,c){function d(a){var c=b.createElement("canvas"),d=c.getContext&&c.getContext("2d");return d&&d.fillText?(d.textBaseline="top",d.font="600 32px Arial","flag"===a?(d.fillText(String.fromCharCode(55356,56812,55356,56807),0,0),c.toDataURL().length>3e3):(d.fillText(String.fromCharCode(55357,56835),0,0),0!==d.getImageData(16,16,1,1).data[0])):!1}function e(a){var c=b.createElement("script");c.src=a,c.type="text/javascript",b.getElementsByTagName("head")[0].appendChild(c)}var f,g;c.supports={simple:d("simple"),flag:d("flag")},c.DOMReady=!1,c.readyCallback=function(){c.DOMReady=!0},c.supports.simple&&c.supports.flag||(g=function(){c.readyCallback()},b.addEventListener?(b.addEventListener("DOMContentLoaded",g,!1),a.addEventListener("load",g,!1)):(a.attachEvent("onload",g),b.attachEvent("onreadystatechange",function(){"complete"===b.readyState&&c.readyCallback()})),f=c.source||{},f.concatemoji?e(f.concatemoji):f.wpemoji&&f.twemoji&&(e(f.twemoji),e(f.wpemoji)))}(window,document,window._wpemojiSettings);
</script>
<style type="text/css">
img.wp-smiley,
img.emoji {
	display: inline !important;
	border: none !important;
	box-shadow: none !important;
	height: 1em !important;
	width: 1em !important;
	margin: 0 .07em !important;
	vertical-align: -0.1em !important;
	background: none !important;
	padding: 0 !important;
}
</style>
<link rel='stylesheet' id='bxslider-css-css'  href='https://www.royaljets.com/template/wp-content/plugins/kiwi-logo-carousel/third-party/jquery.bxslider/jquery.bxslider.css?ver=4.2.2' type='text/css' media='' />
<link rel='stylesheet' id='kiwi-logo-carousel-styles-css'  href='https://www.royaljets.com/template/wp-content/plugins/kiwi-logo-carousel/custom-styles.css?ver=4.2.2' type='text/css' media='' />
<link rel='stylesheet' id='stripe-checkout-button-css'  href='https://checkout.stripe.com/v3/checkout/button.css' type='text/css' media='all' />
<link rel='stylesheet' id='pikaday-css'  href='https://www.royaljets.com/template/wp-content/plugins/stripe-checkout-pro/public/css/pikaday.css?ver=2.2.5' type='text/css' media='all' />
<link rel='stylesheet' id='stripe-checkout-pro-public-css'  href='https://www.royaljets.com/template/wp-content/plugins/stripe-checkout-pro/public/css/public-pro.css?ver=2.2.5' type='text/css' media='all' />
<link rel='stylesheet' id='bbp-default-css'  href='https://www.royaljets.com/template/wp-content/plugins/bbpress/templates/default/css/bbpress.css?ver=2.5.7-5693' type='text/css' media='screen' />
<link rel='stylesheet' id='easingslider-css'  href='https://www.royaljets.com/template/wp-content/plugins/easing-slider/css/easingslider.min.css?ver=2.2.1.1' type='text/css' media='all' />
<link rel='stylesheet' id='font-awesome-css'  href='//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css' type='text/css' media='screen' />
<link rel='stylesheet' id='wpuf-css'  href='https://www.royaljets.com/template/wp-content/plugins/wp-user-frontend/css/wpuf.css?ver=4.2.2' type='text/css' media='all' />
<link rel='stylesheet' id='twentyfourteen-lato-css'  href='//fonts.googleapis.com/css?family=Lato%3A300%2C400%2C700%2C900%2C300italic%2C400italic%2C700italic' type='text/css' media='all' />
<link rel='stylesheet' id='genericons-css'  href='https://www.royaljets.com/template/wp-content/themes/royaljets-new-theme/genericons/genericons.css?ver=3.0.3' type='text/css' media='all' />
<link rel='stylesheet' id='twentyfourteen-style-css'  href='https://www.royaljets.com/template/wp-content/themes/royaljets-new-theme/style.css?ver=4.2.2' type='text/css' media='all' />
<!--[if lt IE 9]>
<link rel='stylesheet' id='twentyfourteen-ie-css'  href='https://www.royaljets.com/template/wp-content/themes/royaljets-new-theme/css/ie.css?ver=20131205' type='text/css' media='all' />
<![endif]-->
<link rel='stylesheet' id='mycred-widget-css'  href='https://www.royaljets.com/template/wp-content/plugins/mycred/assets/css/widget.css?ver=1.6.3.1' type='text/css' media='all' />
<link rel='stylesheet' id='wp-members-css'  href='https://www.royaljets.com/template/wp-content/plugins/wp-members/css/generic-no-float.css?ver=2.9.9.1' type='text/css' media='all' />
<script type='text/javascript' src='https://www.royaljets.com/template/wp-includes/js/jquery/jquery.js?ver=1.11.2'></script>
<script type='text/javascript' src='https://www.royaljets.com/template/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>
<script type='text/javascript' src='https://www.royaljets.com/template/wp-content/plugins/easing-slider/js/jquery.easingslider.min.js?ver=2.2.1.1'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var wpuf = {"ajaxurl":"https:\/\/www.royaljets.com\/template\/wp-admin\/admin-ajax.php","postingMsg":"","confirmMsg":"Are you sure?","nonce":"d1e0f2f1f6","featEnabled":"","plupload":{"runtimes":"html5,silverlight,flash,html4","browse_button":"wpuf-ft-upload-pickfiles","container":"wpuf-ft-upload-container","file_data_name":"wpuf_featured_img","max_file_size":"33554432b","url":"https:\/\/www.royaljets.com\/template\/wp-admin\/admin-ajax.php?action=wpuf_featured_img&nonce=e7fc785ccc","flash_swf_url":"https:\/\/www.royaljets.com\/template\/wp-includes\/js\/plupload\/plupload.flash.swf","silverlight_xap_url":"https:\/\/www.royaljets.com\/template\/wp-includes\/js\/plupload\/plupload.silverlight.xap","filters":[{"title":"Allowed Files","extensions":"*"}],"multipart":true,"urlstream_upload":true}};
/* ]]> */
</script>
<script type='text/javascript' src='https://www.royaljets.com/template/wp-content/plugins/wp-user-frontend/js/wpuf.js?ver=4.2.2'></script>
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="https://www.royaljets.com/template/xmlrpc.php?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="https://www.royaljets.com/template/wp-includes/wlwmanifest.xml" /> 
<meta name="generator" content="WordPress 4.2.2" />
<link rel='canonical' href='https://www.royaljets.com/template/company/' />
<link rel='shortlink' href='https://www.royaljets.com/template/?p=12' />

<style>
.scroll-back-to-top-wrapper {
    position: fixed;
	opacity: 0;
	visibility: hidden;
	overflow: hidden;
	text-align: center;
	z-index: 99999999;
    background-color: #777777;
	color: #eeeeee;
	width: 50px;
	height: 48px;
	line-height: 48px;
	right: 30px;
	bottom: 30px;
	padding-top: 2px;
	border-top-left-radius: 10px;
	border-top-right-radius: 10px;
	border-bottom-right-radius: 10px;
	border-bottom-left-radius: 10px;
	-webkit-transition: all 0.5s ease-in-out;
	-moz-transition: all 0.5s ease-in-out;
	-ms-transition: all 0.5s ease-in-out;
	-o-transition: all 0.5s ease-in-out;
	transition: all 0.5s ease-in-out;
}
.scroll-back-to-top-wrapper:hover {
	background-color: #888888;
  color: #eeeeee;
}
.scroll-back-to-top-wrapper.show {
    visibility:visible;
    cursor:pointer;
	opacity: 1.0;
}
.scroll-back-to-top-wrapper i.fa {
	line-height: inherit;
}
.scroll-back-to-top-wrapper .fa-lg {
	vertical-align: 0;
}
</style><link rel='stylesheet' id='wop-css'  href='http://www.royaljets.com/template/wp-content/plugins/widgets-on-pages/wop.css' type='text/css' media='all' />    <style type="text/css">
ul.wpuf-attachments{ list-style: none; overflow: hidden;}
ul.wpuf-attachments li {float: left; margin: 0 10px 10px 0;}
    </style>
<!-- WP-Members version 2.9.9.1, available at http://rocketgeek.com/wp-members -->

<!--[if lt IE 9]>

<html class="lt-ie9">

<div style=' clear: both; text-align:center; position: relative;'>

    <a href="http://windows.microsoft.com/en-US/internet-explorer/..">

        <img src="images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820"

             alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."/>

    </a>

</div>

<script src="js/html5shiv.js"></script>

<![endif]-->



<script src='https://www.royaljets.com/template/wp-content/themes/royaljets-new-theme/js/device.min.js'></script>


<script type="text/javascript">

var $ = jQuery.noConflict();

$(document).ready(function(){

	  $('a[href*=#]:not([href=#])').click(function() {

if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {

  var target = $(this.hash);

  target = target.length ? target : $('[name=' + this.hash.slice(1) +']');

  if (target.length) {

	$('html,body').animate({

			  scrollTop: target.offset().top

			}, 5000);

			return false;

		  }

		}

	  });

  });


</script>

</head>

	<body>
		<div class="page">
		<!--========================================================
		
		                          HEADER
		
		=========================================================-->
		
		<header id="header" class="header">
			<div class="social_header">
				<div class="container">
					<ul class="social-list">
						<li>
							<a class="fa fa-google-plus" href="#"></a>
						</li>
						<li>
							<a class="fa fa-twitter" href="#"></a>
						</li>
						<li>
							<a class="fa fa-facebook" href="#"></a>
						</li>
						<li>
							<a class="fa fa-pinterest" href="#"></a>
						</li>
						<li>
							<a class="fa fa-linkedin" href="#"></a>
						</li>
					</ul>
				</div>  
			</div>
			<div id="stuck_container" class="stuck_container">
				<div class="container">
					<!--<ul id="menu-main-menu-2" class="nav sf-menu">
						<li id="menu-item-305" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-305"><a href="https://www.royaljets.com/template/">Home</a></li>
						<li id="menu-item-310" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-310"><a href="https://www.royaljets.com/template/services/">Service</a></li>
						<li id="menu-item-320" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-12 current_page_item menu-item-320"><a href="https://www.royaljets.com/template/company/">Company</a></li>
						<li id="menu-item-309" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-309"><a href="https://www.royaljets.com/template/partners/">Partners</a></li>
						<li id="menu-item-308" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-308"><a href="https://www.royaljets.com/template/news/">News</a></li>
					</ul>-->
					
					<?php
					$args = array(
							'theme_location' =>'header',
							'container_class' => 'menu-main-menu-2',
							'items_wrap'      => '<ul id="menu-main-menu-2" class="nav sf-menu">%3$s</ul>'
							);
					?>
					
					<?php wp_nav_menu($args); ?>
					<!-- </nav> -->
					<a class="search-form-toggle" href="#"></a>
				</div>
				<div class="search-form">
					<div class="container">
						<form id="search" action="search.php" method="GET" accept-charset="utf-8">
							<label class="input" for="in">
								<input id="in" type="text" name="s" placeholder="Type your search term here..."/>
							</label>
							<button type="submit" class="fa fa-search"></button>
						</form>
					</div>	
				</div>
			</div>
			<div class="header_panel">
				<div class="container">
					<div class="logo">
						<a href="https://www.royaljets.com/template">
							<img src="https://www.royaljets.com/template/wp-content/themes/royaljets-new-theme/images/logo.png" alt="royaljets" />
						</a>
					</div>
					<ul class="inline-list">		
						<li>		
							<a href="https://www.royaljets.com/template/login/">login</a>		
						</li>
						<li>
							<a href="#">|</a>
						</li>
						<li>
							<a href="https://www.royaljets.com/template/register/">Register an account</a>
						</li>		
					</ul>
				</div>		
			</div>
		</header>
	<!--========================================================
	
	                          CONTENT
	
	=========================================================-->
	<style>
	.bg3_new {
	  background: none repeat scroll 0 0 #e1eade;
	}
	</style>
	  
	<script type="text/javascript">
	
	$(document).ready(function(){
	/*$(function(){
	   var link = document.getElementsByClassName('.btn-apply').children('.btn3');
	
	    window.open(
	      link.href,
	      '_blank'
	    );
	
	    link.innerHTML = "facebook";,
	    link.setAttribute('href', "https://www.royaljets.com/template/register");
	*/
	/*	
	$('.btn-apply').children('.btn3').click(function() {
	    window.location= "/register";
	}*/
	
	 //var package = localStorage.getItem('packageval');
	 var usern = localStorage.getItem('u_name');
	 var emailid = localStorage.getItem('u_eid');
	
	 $('#input_1_5_3').val(usern);
	 $('#input_1_4').val(emailid);
	
	 $('#input_3_1_3').val(usern);
	 $('#input_3_2').val(emailid);
	
	 $('#input_4_1_3').val(usern);
	 $('#input_4_2').val(emailid);
	
	});
	</script>
	<script type="text/javascript">
	   document.getElementByClass("btn3").onclick = function() {
	   var linkv = document.getElementByClass("btn3");
	   linkv.setAttribute("href", "https://www.royaljets.com/template/register");
	   return false;
	   }
	</script>
	
	
	
