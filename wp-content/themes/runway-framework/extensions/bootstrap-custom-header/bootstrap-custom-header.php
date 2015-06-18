<?php
/*
    Extension Name: Bootstrap Custom Header
    Version: 1.0
    Description: Custom header content for the Bootstrap Starter theme.
*/


#-----------------------------------------------------------------
# Headers
#-----------------------------------------------------------------

/**
 * Header for "Cover" templates
 */
if ( ! function_exists( 'rf_cover_bootstrap_header' ) ) :
function rf_cover_bootstrap_header() {

	?>

		<!-- Cover element
		================================================== -->
		<section id="header" <?php if (is_page_template( 'templates/cover-with-page.php' )) { echo 'class="cover-with-page"'; } ?>>
			<?php
			if ( has_post_thumbnail() ) {
				$bg_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
			} ?>

			<div class="cover-wrapper" style="background-image: url(<?php echo $bg_image ?>)">
				<div class="cover-container overlay">
					<div class="cover-inner">
						<div class="container">
							<h1 class="page-title"><?php echo apply_filters('theme_header_title', get_the_title()); ?></h1>
							<?php while ( have_posts() ) : the_post(); ?>

								<?php if (has_excerpt()) : ?>
									<div class="lead"><?php echo get_the_excerpt(); ?></div>
								<?php else : ?>
									<div class="lead"><?php the_content(); ?></div>
								<?php endif; ?>

							<?php endwhile; // end of the loop. ?>
						</div><!-- /.container -->
					</div><!-- /.cover-inner -->
				</div><!-- /.cover-container -->
			</div><!-- /.cover-wrapper -->
		
		</section><!-- /#header -->

  	<?php
}
endif;



/**
 * Header for default title and home page
 */
if ( ! function_exists( 'rf_default_bootstrap_header' ) ) :
function rf_default_bootstrap_header() {

	$masthead_class = '';
	
	// Use Page Headers
	$show_the_header = rf_has_custom_header();

	// Home Page Background
	$home_background = get_options_data('home-page-header', 'home-header-background', 'solid');
	switch ($home_background) {
		case 'primary-bg':
			$home_bg_class = 'masthead-primary-bg';
			break;
		case 'primary-gradient':
			$home_bg_class = 'masthead-primary-bg masthead-gradient';
			break;
		default:
			$home_bg_class = 'masthead-'.$home_background;
			break;
	}

	// Background class
	if (is_front_page()) {
		$bg_class = $home_bg_class;
	} else {
		$bg_class = 'masthead-primary-bg';
	}

	// Size class
	$home_size = get_options_data('home-page-header', 'home-header-size', 'large');
	$size_class = 'masthead-'.$home_size;

	// Custom class
	$custom_class = get_options_data('home-page-header', 'home-header-class', '');

	if ($show_the_header) {
		// Masthead class
		$masthead_class = (is_front_page()) ? 'masthead '.$bg_class.' '.$size_class.' '.$custom_class : 'masthead masthead-primary-bg';
		$masthead_class = apply_filters('bootstrap_masthead_class', $masthead_class );
	}

	?>

	<!-- Header content
	================================================== -->

	<section id="header" class="<?php echo $masthead_class; ?>">
	<?php if ($show_the_header) : ?>

		<div class="container-fluid">
		<?php 
		if (is_front_page()) {
			$home_content = get_options_data('home-page-header', 'home-header-content');
			$home_autop = get_options_data('home-page-header', 'home-header-autop'); 
			if (isset($home_content)) {
				$home_content = stripslashes($home_content);
				echo $home_content;
			}
		} else {
			?>
			<h1 class="page-title"><?php echo apply_filters('theme_header_title', get_the_title()); ?></h1>
			<p class="lead"><?php echo apply_filters('theme_header_subtitle', ''); ?></p>
			<?php
		} ?>
		</div><!-- /.container-fluid -->

	<?php endif; ?>
	</section><!-- /.masthead -->

	<?php 
}
endif;



#-----------------------------------------------------------------
# Title Functions
#-----------------------------------------------------------------

/**
 * Page Title in Header. Similar to titles generaged by wp_title() 
 * for use in headers and other areas outside the loop.
 */
if ( ! function_exists( 'rf_generate_the_title' ) ) :
function rf_generate_the_title( $title = '' ) {
	global $wpdb, $wp_locale;

	$m        = get_query_var('m');
	$year     = get_query_var('year');
	$monthnum = get_query_var('monthnum');
	$day      = get_query_var('day');
	$search   = get_search_query();
	$t_sep    = ' ';

	// If there is a post
	if ( is_single() || ( is_home() && !is_front_page() ) || ( is_page() && !is_front_page() ) ) {
		$title = single_post_title( '', false );
	}
	// If there's a category or tag
	if ( is_category() || is_tag() ) {
		$title = single_term_title( '', false );
	}
	// If there's a taxonomy
	if ( is_tax() ) {
		$term = get_queried_object();
		$tax = get_taxonomy( $term->taxonomy );
		$title = single_term_title( $tax->labels->name . $t_sep, false );
	}
	// If there's an author
	if ( is_author() ) {
		$author = get_queried_object();
		$title = $author->display_name;
	}
	// If there's a post type archive
	if ( is_post_type_archive() )
		$title = post_type_archive_title( '', false );
	// If there's a month
	if ( is_archive() && !empty($m) ) {
		$my_year = substr($m, 0, 4);
		$my_month = $wp_locale->get_month(substr($m, 4, 2));
		$my_day = intval(substr($m, 6, 2));
		$title = ( $my_month ? $my_month .  $t_sep : '' ) . ( $my_day ? $my_day . $t_sep : '' ) . $my_year;
	}
	// If there's a year
	if ( is_archive() && !empty($year) ) {
		$title = '';
		if ( !empty($monthnum) )
			$title .= $wp_locale->get_month($monthnum) . $t_sep;
		if ( !empty($day) )
			$title .= zeroise($day, 2) . $t_sep;
		$title .= $year;
	}
	// If it's a search
	if ( is_search() ) {
		/* translators: 1: separator, 2: search phrase */
		$title = sprintf(__('Search Results for %1$s', 'framework'), '<em>'.strip_tags($search).'</em>');
	}
	// If it's a 404 page
	if ( is_404() ) {
		$title = __('Page not found', 'framework');
	}

	return $title;

}
endif; 

add_filter( 'theme_header_title', 'rf_generate_the_title' );



/**
 * Page Sub-Title in Header
 */
if ( ! function_exists( 'rf_generate_the_subtitle' ) ) :
function rf_generate_the_subtitle( $subtitle = '' ) {
	global $wpdb, $wp_locale;

	$t_sep    = ' ';

	// If there is a post
	if (is_page() && has_excerpt()) {
		$subtitle = get_the_excerpt();
	} elseif ( is_single() || ( is_home() && !is_front_page() ) ) {
		$subtitle = ( !function_exists( 'rf_posted_on' ) ) ? '' : rf_posted_on( false ); // use false to return, not echo
	}

	return $subtitle;

}
endif;

add_filter( 'theme_header_subtitle', 'rf_generate_the_subtitle' );



#-----------------------------------------------------------------
# Header Helpers
#-----------------------------------------------------------------

/**
 * Custom class on HTML element for "Cover" templates
 */
if ( ! function_exists( 'rf_html_cover_class' ) ) :
function rf_html_cover_class() {

	if (is_page_template( 'templates/cover.php' ) || is_page_template( 'templates/cover-with-page.php' )) { 

		echo 'class="cover"'; 

	}

}
endif;



/**
 * Show the Bootstrap header for the specific area.
 */
if ( ! function_exists( 'rf_bootstrap_header' ) ) :
function rf_bootstrap_header() {

	if (is_page_template( 'templates/cover.php' ) || is_page_template( 'templates/cover-with-page.php' )) {

		rf_cover_bootstrap_header();

	} else {

		rf_default_bootstrap_header();

	}

}
endif;



/**
 * Checks if custom headers are enabled for current page from theme options
 * 
 * @return bool Returns true if custom headers are enabled.
 */
if ( ! function_exists( 'rf_has_custom_header' ) ) :
function rf_has_custom_header() {
	
	// Use Page Headers
	$show_the_header = false;
	$show_headers = get_options_data('options-page', 'use-page-headers');
	if (isset($show_headers) && is_array($show_headers)) {

		foreach ($show_headers as $section) {
			if ( function_exists('is_'.$section) ) {
				if ( call_user_func('is_'.$section) )
					$show_the_header = true;

				continue;
			}
		}
	}

	return $show_the_header;
}
endif;



#-----------------------------------------------------------------
# Filters and Actions
#-----------------------------------------------------------------

// Filter Home Header for Auto Paragraphs
if ( ! function_exists( 'wpautop_home_header' ) ) :
function wpautop_home_header( $content ) {
	
	$home_autop = get_options_data('home-page-header', 'home-header-autop');
	if ( !is_front_page() || $home_autop == 'true') {
		$content = wpautop($content);
	}
	return $content;
}
endif;
remove_filter( 'get_options_data_type_text-editor', 'wpautop', 10 ); // remove for all Runway text editors
add_filter( 'get_options_data_type_text-editor', 'wpautop_home_header', 10 ); // add custom version


// Add custom CSS from header options.
function home_header_custom_styles() {
	$custom_css = get_options_data('home-page-header', 'home-header-custom-css', '');
	if (!empty($custom_css) && is_front_page()) {
		wp_add_inline_style( 'theme-style', $custom_css ); // $handle must match existing CSS file. 
	}
}
add_action( 'wp_enqueue_scripts', 'home_header_custom_styles' );


// Add support for excerpts in pages.
function rf_add_page_excerpts() {
	add_post_type_support( 'page', 'excerpt' );
}
add_action('init', 'rf_add_page_excerpts');
