<?php
/**
 * Main Stripe Subscriptions class
 *
 * @package SC_SUB
 * @author  Phil Derksen <pderksen@gmail.com>, Nick Young <mycorpweb@gmail.com>
 */


class Stripe_Subscriptions {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */

	protected $version = '1.1.7';
	
	/**
	 * Required version of SC Pro
	 *
	 * @since   1.0.1
	 *
	 * @var     string
	 */
	protected $sc_required = '2.2.5';

	/**
	 * Unique identifier
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'stripe-subscriptions';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;
	
	/**
	 * Store URL for EDD SL Updater
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $sc_sub_edd_sl_store_url = 'http://wpstripe.net/';
	
	/**
	 * Product Name for EDD SL Updater
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $sc_sub_edd_sl_item_name = 'Stripe Subscriptions';
	
	/**
	 * Author Name for EDD SL Updater
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $sc_sub_edd_sl_author = 'Phil Derksen';

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {
		// Define plugin wide variables
		$this->setup_constants();
		
		// Check for base plugin
		add_action( 'admin_init', array( $this, 'base_inactive_notice' ) );
		
		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		
		// Include our needed files
		add_action( 'init', array( $this, 'includes' ), 0 );
		
		// Include public scripts
		add_action( 'init', array( $this, 'register_public_scripts' ) );
		
		// Run EDD software licensing plugin updater.
		add_action( 'init', array( $this, 'sc_sub_edd_sl_updater' ) );
		
		// Run check for SC Pro version
		add_action( 'admin_notices', array( $this, 'check_sc_pro_required' ) );
		
		add_action( 'the_posts', array( $this, 'load_scripts' ) );
	}
	
	
	function load_scripts( $posts ) {
		
		global $sc_options;
		
		if ( empty($posts) ) {
			return $posts;
		}

		foreach ( $posts as $post ){
			if ( strpos( $post->post_content, '[stripe_subscription' ) !== false || ( ! empty( $sc_options['always_enqueue'] ) ) ){
				// Load JS
				wp_enqueue_script( $this->plugin_slug . '-public' );

				break;
			}
		}

		return $posts;
	}
	
	function check_sc_pro_required() {
		if( class_exists( 'Stripe_Checkout_Pro' ) ) {
			$sc_version = get_option( 'sc_version' );
			
			if( version_compare( $sc_version, $this->sc_required, '<' ) ) {
				include_once( 'views/admin-sc-pro-notice.php' );
			}
		}
	}

	/**
	 * Check for existence for base plugin (SC Pro)
	 *
	 * @since     1.0.0
	 */
	public function base_inactive_notice() {
		
		if ( ! class_exists( 'Stripe_Checkout_Pro' ) ) {
			include_once( 'views/admin-sc-pro-deactivated-notice.php' );
		}
	}
	
	/**
	 * Easy Digital Download Plugin Updater Code.
	 *
	 * @since     1.0.0
	 */
	public function sc_sub_edd_sl_updater() {
		global $sc_options;
		
		if( ! class_exists( 'EDD_SL_Plugin_Updater' ) ) {
			// load our custom updater
			include_once( 'includes/EDD_SL_Plugin_Updater.php' );
		}
		
		if( ! empty( $sc_options['sc_sub_license_key'] ) ) {
			
			// Set the license key
			$license_key = $sc_options['sc_sub_license_key'];

			// setup the updater
			$edd_updater = new EDD_SL_Plugin_Updater( $this->sc_sub_edd_sl_store_url, SC_SUB_MAIN_FILE, array(
					'version'   => $this->version, // current plugin version number
					'license'   => $license_key, // license key (used get_option above to retrieve from DB)
					'item_name' => $this->sc_sub_edd_sl_item_name, // name of this plugin
					'author'    => $this->sc_sub_edd_sl_author // author of this plugin
				)
			);
		}
	}
	
	/**
	 * Define any plugin wide constants we need
	 * 
	 * @since 1.0.0
	 */
	function setup_constants() {
		if( ! defined( 'SC_SUB_PLUGIN_SLUG' ) ) {
			define( 'SC_SUB_PLUGIN_SLUG', $this->plugin_slug );
		}
	}
	
	/**
	 * Register public scripts to use later
	 *
	 * @since     1.0.0
	 */
	function register_public_scripts() {
		wp_register_script( $this->plugin_slug . '-public', plugins_url( 'js/public.js', __FILE__ ), array( 'jquery', 'stripe-checkout-pro-public' ), $this->version, true );
		wp_localize_script( $this->plugin_slug . '-public', 'sc_sub', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}
	
	/**
	 * Include necessary files
	 *
	 * @since     1.0.0
	 */
	function includes() {
		include_once( 'includes/misc-functions.php' );
		include_once( 'includes/shortcodes.php' );
		
		if( ! is_admin() ) {
			if( ! class_exists( 'Shortcode_Tracker' ) ) {
				include_once( 'includes/class-shortcode-tracker.php' );
			}
		}
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'sc_sub',
			false,
			dirname( plugin_basename( SC_SUB_MAIN_FILE ) ) . '/languages/'
		);
	}
	
	/**
	 * Return the title of the plugin
	 * 
	 * @since 1.0.0
	 */
	public static function get_plugin_title() {
		return _x( 'Stripe Subscriptions', 'Plugin Title', 'sc_sub' );
	}
}
