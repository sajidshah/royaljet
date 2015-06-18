<?php
/**
 * Bootstrap Basic theme
 * 
 * @package bootstrap-basic
 */


/**
 * Required WordPress variable.
 */
if (!isset($content_width)) {
	$content_width = 1170;
}


if (!function_exists('bootstrapBasicSetup')) {
	/**
	 * Setup theme and register support wp features.
	 */
	function bootstrapBasicSetup() 
	{
		/**
		 * Make theme available for translation
		 * Translations can be filed in the /languages/ directory
		 * 
		 * copy from underscores theme
		 */
		load_theme_textdomain('bootstrap-basic', get_template_directory() . '/languages');

		// add theme support post and comment automatic feed links
		add_theme_support('automatic-feed-links');

		// enable support for post thumbnail or feature image on posts and pages
		add_theme_support('post-thumbnails');

		// add support menu
		register_nav_menus(array(
			'primary' => __('Primary Menu', 'bootstrap-basic'),
		));

		// add post formats support
		add_theme_support('post-formats', array('aside', 'image', 'video', 'quote', 'link'));

		// add support custom background
		add_theme_support(
			'custom-background', 
			apply_filters(
				'bootstrap_basic_custom_background_args', 
				array(
					'default-color' => 'ffffff', 
					'default-image' => ''
				)
			)
		);
	}// bootstrapBasicSetup
}
add_action('after_setup_theme', 'bootstrapBasicSetup');


if (!function_exists('bootstrapBasicWidgetsInit')) {
	/**
	 * Register widget areas
	 */
	function bootstrapBasicWidgetsInit() 
	{
		register_sidebar(array(
			'name'          => __('Header right', 'bootstrap-basic'),
			'id'            => 'header-right',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		));

		register_sidebar(array(
			'name'          => __('Navigation bar right', 'bootstrap-basic'),
			'id'            => 'navbar-right',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
		));

		register_sidebar(array(
			'name'          => __('Sidebar left', 'bootstrap-basic'),
			'id'            => 'sidebar-left',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		));

		register_sidebar(array(
			'name'          => __('Sidebar right', 'bootstrap-basic'),
			'id'            => 'sidebar-right',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		));

		register_sidebar(array(
			'name'          => __('Footer left', 'bootstrap-basic'),
			'id'            => 'footer-left',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		));

		register_sidebar(array(
			'name'          => __('Footer right', 'bootstrap-basic'),
			'id'            => 'footer-right',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		));
	}// bootstrapBasicWidgetsInit
}
add_action('widgets_init', 'bootstrapBasicWidgetsInit');


if (!function_exists('bootstrapBasicEnqueueScripts')) {
	/**
	 * Enqueue scripts & styles
	 */
	function bootstrapBasicEnqueueScripts() 
	{
		wp_enqueue_style('bootstrap-style', get_template_directory_uri() . '/css/bootstrap.min.css');
		wp_enqueue_style('bootstrap-theme-style', get_template_directory_uri() . '/css/bootstrap-theme.min.css');
		wp_enqueue_style('fontawesome-style', get_template_directory_uri() . '/css/font-awesome.min.css');
		wp_enqueue_style('main-style', get_template_directory_uri() . '/css/main.css');

		wp_enqueue_script('modernizr-script', get_template_directory_uri() . '/js/vendor/modernizr.min.js');
		wp_enqueue_script('respond-script', get_template_directory_uri() . '/js/vendor/respond.min.js');
		wp_enqueue_script('html5-shiv-script', get_template_directory_uri() . '/js/vendor/html5shiv.js');
		wp_enqueue_script('jquery');
		wp_enqueue_script('bootstrap-script', get_template_directory_uri() . '/js/vendor/bootstrap.min.js');
		wp_enqueue_script('main-script', get_template_directory_uri() . '/js/main.js');
		wp_enqueue_style('bootstrap-basic-style', get_stylesheet_uri());
	}// bootstrapBasicEnqueueScripts
}
add_action('wp_enqueue_scripts', 'bootstrapBasicEnqueueScripts');


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';


/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';


/**
 * Custom dropdown menu and navbar in walker class
 */
require get_template_directory() . '/inc/BootstrapBasicMyWalkerNavMenu.php';


/**
 * Template functions
 */
require get_template_directory() . '/inc/template-functions.php';


/**
 * --------------------------------------------------------------
 * Theme widget & widget hooks
 * --------------------------------------------------------------
 */
require get_template_directory() . '/inc/widgets/BootstrapBasicSearchWidget.php';
require get_template_directory() . '/inc/template-widgets-hook.php';

	//Navigatin Menus
	register_nav_menus(array('header' => __('Header Menu'),'footer' => __('Footer Menu')));

	
/* custom code _ ###################
 * #################################
 * */
$cap = array(
        'read'         => true,  // true allows this capability
        'edit_posts'   => false,
        'delete_posts' => false, // Use false to explicitly deny
    ); 
	

$result = add_role('member_zero', __( 'Membership Initial' ), $cap);
$result = add_role('member_silver', __( 'Membership Silver' ), $cap);
$result = add_role('member_gold', __( 'Membership Gold' ), $cap);
$result = add_role('member_black', __( 'Membership  Black' ), $cap);



function sc_change_details( $html, $charge_response ) {
 
 
 	if($charge_response->receipt_email){
 		
		//$email = $charge_response->receipt_email;
		
		$product = esc_html( $_GET['store_name'] ) ;
		$email = $charge_response->receipt_email;
		$amount = $charge_response->amount;
		
		$user = get_user_by( 'email', $email );
		
		//echo $amount; die;
		
		if($amount == 999) $role="member_silver";
		if($amount == 1000000) $role="member_gold";
		if($amount == 2050000) $role="member_black";
		
		$arg = array( 'ID' => $user->ID, 'role' => $role );
		
		$update = wp_update_user( $arg );
		
		if($update) echo "";
		else {
			echo "Something went wrong please contact us";
		}

		
		
		/*echo "<pre>";
		print_r($charge_response);
		echo "</pre>";*/
		
		
 	}
 
    // This is copied from the original output so that we can just add in our own details
        
    $html = '<div class="sc-payment-details-wrap">';
          
    $html .= '<p>' . __( 'Congratulations. Your payment went through!', 'sc' ) . '</p>' . "\n";
          
    if( ! empty( $charge_response->description ) ) {
        $html .= '<p>' . __( "Here's what you bought:", 'sc' ) . '</p>';
        $html .= $charge_response->description . '<br>' . "\n";
    }
          
    if ( isset( $_GET['store_name'] ) && ! empty( $_GET['store_name'] ) ) {
        $html .= 'From: ' . esc_html( $_GET['store_name'] ) . '<br/>' . "\n";
    }
      
    $html .= '<br><strong>' . __( 'Total Paid: ', 'sc' ) . sc_stripe_to_formatted_amount( $charge_response->amount, $charge_response->currency ) . ' ' . 
            strtoupper( $charge_response->currency ) . '</strong>' . "\n";
      
    $html .= '<p>Your transaction ID is: ' . $charge_response->id . '</p>';
   
    //Our own new details
    // Let's add the last four of the card they used and the expiration date
    $html .= '<p>Card: ****-****-****-' . $charge_response->source->last4 . '<br>';
    $html .= 'Expiration: ' . $charge_response->source->exp_month . '/' . $charge_response->source->exp_year . '</p>';
      
    // We can show the Address provided - this requires shipping="true" in our shortcode
    if( ! empty( $charge_response->source->address_line1 ) ) {
        $html .= '<p>Address Line 1: ' . $charge_response->source->address_line1 . '</p>';
    }
      
    if( ! empty( $charge_response->source->address_line2 ) ) {
        $html .= '<p>Address Line 2: ' . $charge_response->source->address_line2 . '</p>';
    }
      
    if( ! empty( $charge_response->source->address_city ) ) {
        $html .= '<p>Address City: ' . $charge_response->source->address_city . '</p>';
    }
      
    if( ! empty( $charge_response->source->address_state ) ) {
        $html .= '<p>Address State: ' . $charge_response->source->address_state . '</p>';
    }
      
    if( ! empty( $charge_response->source->address_zip ) ) {
        $html .= '<p>Address Zip: ' . $charge_response->source->address_zip . '</p>';
    }
      
    // Finally we can add the output of a custom field
    // For our example shortcode: <div class="sc-form-group"><label for=""phone_number"">"Phone</label><input type="text" value="" class="sc-form-control sc-cf-text" id=""phone_number"" name="sc_form_field["phone_number"]" placeholder=""></div>
    if( ! empty( $charge_response->metadata->phone_number ) ) {
        $html .= '<p>Phone Number: ' . $charge_response->metadata->phone_number . '</p>';
    }
      
    $html .= '</div>';
      
    return $html;
      
}
add_filter( 'sc_payment_details', 'sc_change_details', 20, 2 );
	