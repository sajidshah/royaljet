<?php
/**
 * Bootstrap Starter for Runway
 *
 * @package runway-bootstrap-starter
 */

/**
 * Toggle template directory and URI for Runway child/standalone themes
 *
 * These functions can be used to replace the defaults in WordPress so the correct path is
 * generated for both child themes and standalone. It will ensure the paths being referenced 
 * to your themes folder are always correct. 
 */
if (!function_exists('rf_get_template_directory_uri')) :
	function rf_get_template_directory_uri() {
		return (IS_CHILD) ? get_stylesheet_directory_uri() : get_template_directory_uri();
	}
endif;
if (!function_exists('rf_get_template_directory')) :
	function rf_get_template_directory() {
		return (IS_CHILD) ? get_stylesheet_directory() : get_template_directory();
	}
endif;

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 1170; /* pixels */

if ( ! function_exists( 'rf_theme_setup' ) ) :
/**
 * Set up theme defaults and register support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function rf_theme_setup() {
	global $cap, $content_width;

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	if ( function_exists( 'add_theme_support' ) ) {

		/**
		 * Add default posts and comments RSS feed links to head
		*/
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Enable support for Post Thumbnails on posts and pages
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		*/
		add_theme_support( 'post-thumbnails' );

		/**
		 * Enable support for Post Formats
		*/
		add_theme_support( 'post-formats', array( 'image', 'video', 'quote', 'link' ) );

	}

	/**
	 * Make theme available for translation
	 * Translations can be added to the /languages/ directory
	 * If you're building a theme based on Runway, you should keep the text domain
	 * set to 'framework' to maintain consistency with the core files and strings.
	*/
	load_theme_textdomain( 'framework', rf_get_template_directory() . '/languages' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	*/
	register_nav_menus( array(
		'primary'  => __( 'Main Menu - Left', 'framework' ),
		'footer-menu'  => __( 'Footer Menu', 'framework' ),
	) );

}
endif; // rf_theme_setup
add_action( 'after_setup_theme', 'rf_theme_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function rf_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'framework' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'rf_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function rf_enqueue_scripts() {
	global $wp_scripts;

	// Load Bootstrap CSS
	wp_enqueue_style( 'theme-bootstrap', rf_get_template_directory_uri() . '/assets/css/bootstrap.min.css' );

	// Load theme CSS
	wp_enqueue_style( 'theme-style', get_stylesheet_uri() );

	// Load theme CSS
	wp_enqueue_script( 'theme-js', rf_get_template_directory_uri().'/assets/js/theme-scripts.js', array('jquery'), false, true );

	// Load Bootstrap JS files
	wp_enqueue_script( 'theme-bootstrapjs', rf_get_template_directory_uri().'/assets/js/bootstrap.min.js', array('jquery'), false, true );
	wp_enqueue_script( 'theme-bootstrapwp', rf_get_template_directory_uri() . '/assets/js/bootstrap-wp.js', array('jquery'), false, true );

	// IE only JS
	wp_enqueue_script( 'theme-html5shiv', rf_get_template_directory_uri().'/assets/js/html5shiv.js', '3.7.0' );
	$wp_scripts->add_data( 'theme-html5shiv', 'conditional', 'lt IE 9' );
	wp_enqueue_script( 'theme-respondjs', rf_get_template_directory_uri().'/assets/js/respond.min.js', '1.4.2' );
	$wp_scripts->add_data( 'theme-respondjs', 'conditional', 'lt IE 9' );
    
    // IE10 viewport hack for Surface/desktop Windows 8 bug -->
	wp_enqueue_script( 'theme-ie10-viewport-bug', rf_get_template_directory_uri().'/assets/js/ie10-viewport-bug-workaround.js', '1.0.0' );

	// Load comment reply ajax
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Load keyboard navigation for image template
	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'theme-keyboard-image-nav', rf_get_template_directory_uri() . '/assets/js/keyboard-image-nav.js', array( 'jquery' ), '1.0.0' );
	}

}
add_action( 'wp_enqueue_scripts', 'rf_enqueue_scripts' );
