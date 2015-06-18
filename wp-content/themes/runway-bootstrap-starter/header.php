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
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php do_action( 'before' ); ?>

    <!-- Navigation Top
    ================================================== -->
	<div class="navbar-wrapper">
		<header class="navbar navbar-default navbar-fixed-top" id="top" role="navigation">
          <div class="container-fluid">
            <div class="navbar-header">
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
					// Main navbar (right)
					wp_nav_menu( array(
						'menu'              => 'primary-right',
						'theme_location'    => 'primary-right',
						'container'         => false,
						'menu_class'        => 'nav navbar-nav navbar-right',
						'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
						'walker'            => new wp_bootstrap_navwalker()
					));
				} else {
					echo 'Please make sure the Bootstrap Navigation extension is active. Go to "Runway > Extensions" to activate.';
				}
			?>
			</nav>
          </div>
        </header>        
    </div>

		
	<!-- Header content
	================================================== -->
	<?php 

	// Get the custom header content
	if ( function_exists( 'rf_bootstrap_header' ) ) {
		rf_bootstrap_header();
	} else { ?>
		<section id="header"></section>
	<?php } ?>

	<!-- Main content
	================================================== -->
	<div id="middle" <?php if (!is_page_template('templates/page-full-width-flush.php')) : echo 'class="container-fluid"'; endif; ?>>

	<?php do_action('output_layout','start'); // Layout Manager - Start Layout ?>