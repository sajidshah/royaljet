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
		$membership=false;
		if($amount == 999){
			$role="member_silver";
			$membership=true;
		} 
		if($amount == 1000000) {
			$role="member_gold";
			$membership=true;
		}
		if($amount == 2050000) {
			$role="member_black";
			$membership=true;
		}
		
		if($membership){
			
			$arg = array( 'ID' => $user->ID, 'role' => $role );
		
			$update = wp_update_user( $arg );
			
			if($update) echo "Transaction successful, you have unlocked your membership features";
			else {
				echo "Something went wrong please contact us";
			}
			
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
     
	if($charge_response->metadata->full_name && $charge_response->metadata->dateofbirth){
		$data['customer_email'] = $charge_response->receipt_email;
		$data['full_name'] = $charge_response->metadata->full_name;
		$data['dob'] = $charge_response->metadata->dateofbirth;
		$data['passport'] = $charge_response->metadata->weight;
		$data['passport'] = $charge_response->metadata->passport_no;
		$data['tran_id'] = $charge_response->id;
		$data['prod'] = esc_html( $_GET['store_name'] );
		$data['amount'] = $charge_response->amount;
		$data['paid'] = $charge_response->paid;
		$data['currency'] = $charge_response->currency;
		//pr($charge_response, true);
		sendProductMail($data);
	}
		
		
		
	echo $html;
      
}
add_filter( 'sc_payment_details', 'sc_change_details', 20, 2 );

function sendProductMail($data){
	
	
	$to = $data['customer_email'] .',reservations@royaljets.com, bookings@royaljets.com, dijast@gmail.com';
	$subject = 'Order - '.$data['prod'];
	
	$body = 'Dear '.$data['full_name'].',<br>';
	$body .= 'We have received your following booking <br>
	 
			  Plan: '.$data['prod'].'<br>
			  Weight: '.$data['weight'].'<br>
			  Amount: $'.($data['amount']/100).'<br>
			  
			  <br><br>
			  * By placing this order you agreed with our companies <a href="http://royaljets.com/royal-jets-empty-leg-terms-and-conditions/">Terms and Conditions</a>
			';
	
	echo $body; 
	
	$headers = array('Content-Type: text/html; charset=UTF-8');
	wp_mail( $to, $subject, $body, $headers );
}

add_action( 'init', 'create_post_type' );
function create_post_type() {
  register_post_type( 'legs_products',
    array(
      'labels' => array(
        'name' => __( 'Empty Legs' ),
        'singular_name' => __( 'Empty Leg' )
      ),
      'menu_position' => 4,
      'supports' => array('title','editor','revisions','page-attributes', 'thumbnail'),
      'public' => true,
      'hierarchical' => false,
      '_builtin' => false,
      'capability_type' => 'post',
      'rewrite' => array('slug' => 'product','with_front' => FALSE),
	   'has_archive' => true
    )
  );
}
function pr($data, $ret=false){
	echo "<pre>";
		print_r($data);
	echo "</pre>";
	
	if($ret) return true;
	else die;
}

//new post status
add_action('admin_footer-post.php', 'jc_append_post_status_list');
function jc_append_post_status_list(){
     global $post;
     $complete = '';
     $label = '';
     if($post->post_type == 'post'){
          if($post->post_status == 'archive'){
               $complete = ' selected="selected"';
               $label = '<span id="post-status-display"> Archived</span>';
          }
          echo '
          <script>
          jQuery(document).ready(function($){
               $("select#post_status").append("<option value="archive" '.$complete.'>Archive</option>");
               $(".misc-pub-section label").append("'.$label.'");
          });
          </script>
          ';
     }
}


function return_404() {
	status_header(404);
	nocache_headers();
	include( get_404_template() );
	exit;
}