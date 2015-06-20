<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package runway-bootstrap-starter
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> <?php if (function_exists( 'rf_html_cover_class' )) : rf_html_cover_class(); endif; ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php do_action( 'before' ); ?>

    <!-- Navigation Top
    ================================================== -->
	<div class="navbar-wrapper">
		<header class="navbar navbar-default" id="top" role="navigation">
          <div class="container-fluid">
            <div class="navbar-header">
				<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
					<span class="sr-only"><?php _e('Toggle navigation', 'framework' ); ?></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
            </div>
            <nav class="collapse navbar-collapse" id="navbar-main">
			<?php 
				if (class_exists('wp_bootstrap_navwalker')) {
					// Main navbar (left)
					wp_nav_menu( array(
						'menu'              => 'primary',
						'theme_location'    => 'primary',
						'container'         => false,
						'menu_class'        => 'nav navbar-nav',
						'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
						'walker'            => new wp_bootstrap_navwalker()
					));
				} else {
					echo 'Please make sure the Bootstrap Navigation extension is active. Go to "Runway > Extensions" to activate.';
				}
			?>
			
			<ul class="social-list">
				<li><a class="fa fa-google-plus" href="https://plus.google.com/108786843512487721458/videos?hl=en" target="_blank"></a></li>
				<li><a class="fa fa-twitter" href="https://twitter.com/royaljets" target="_blank"></a></li>
				<li><a class="fa fa-facebook" href="https://www.facebook.com/Royaljetsfans?fref=ts" target="_blank"></a></li>
				<li><a class="fa fa-pinterest" href="https://www.pinterest.com/royaljets/" target="_blank"></a></li>
				<li><a class="fa fa-linkedin" href="https://www.linkedin.com/company/royal-jets-inc-" target="_blank"></a></li>
				<li><a class="fa fa-instagram" href="https://instagram.com/royaljets/" target="_blank"></a></li>
			</ul>
			
			</nav>
          </div>
          
          <div class="header_logo">
	    	<div class="container">
		    	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="navbar-brand">
					<?php 
					$logo_image = get_options_data('options-page', 'logo', '');
					$has_logo = false;
					if (!empty($logo_image)) {
						echo '<img src="'.$logo_image.'" alt="'.esc_attr(get_bloginfo('name', 'display')).'">';
						$has_logo = true;
					}
					$brand_title = get_options_data('options-page', 'brand-title', '');
					if (!empty($brand_title)) {
						if ($has_logo) {
							echo ' &nbsp;';
						}
						echo $brand_title;
					}
					?>
				</a>
				
				<ul class="inline-list">
					<?php if ( !is_user_logged_in() ) : ?>
						<li>		
							<a href="<?php echo site_url('login-now'); ?>">login</a>		
						</li>
						<li>
							<a href="#">|</a>
						</li>
						<li>
							<a href="<?php echo site_url('signup-now'); ?>">Register an account</a>
						</li>
					<?php else: 
						
						$user = new WP_User( $user_ID );
						$initial = (in_array('member_zero', $user->roles)) ? true : false;
						$silver = (in_array('member_silver', $user->roles)) ? true : false;
						$gold = (in_array('member_gold', $user->roles)) ? true : false;
						$black = (in_array('member_black', $user->roles)) ? true : false;
						
						if($initial): ?>
							<li><a href="<?php echo site_url('membership'); ?>">Upgrade Membership</a></li>
						<?php endif; ?>
						<?php if($gold || $silver || $black): ?>
							<li><a href="<?php echo site_url('product'); ?>">Book Empty Legs</a></li>
						<?php endif; ?>
						
						<?php if($black): ?>
							<li><a href="<?php echo site_url('plan-trip');?>">Plan a trip</a></li>
						<?php endif; ?>	
						
						<li><a href="#">Logout</a></li>
					<?php endif; ?>
				</ul>
				
			</div>
	    </div>
          
        </header>
                
    </div>

		
	<!-- Header content
	================================================== -->
	<?php 

	if(is_front_page()) :
		if ( function_exists( 'easingslider' ) ) { easingslider( 44 ); } ?>
		
		<div class="wings">
			<img class="img-responsive" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/wings.png">
		</div>
		
	<?php endif ?>
	
	
	<!-- Main content
	================================================== -->
	<div id="middle" <?php if (!is_page_template('templates/page-full-width-flush.php')) : echo 'class="container-fluid"'; endif; ?>>

	<?php do_action('output_layout','start'); // Layout Manager - Start Layout ?>