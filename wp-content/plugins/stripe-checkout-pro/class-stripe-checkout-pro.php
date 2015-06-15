<?php

/**
 * Main Stripe Checkout Pro class
 *
 * @package SC Pro
 * @author  Phil Derksen <pderksen@gmail.com>, Nick Young <mycorpweb@gmail.com>
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Stripe_Checkout_Pro extends Stripe_Checkout {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   2.0.0
	 *
	 * @var     string
	 */
	protected $version = '2.2.5';

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    2.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'stripe-checkout-pro';

	/**
	 * Instance of this class.
	 *
	 * @since    2.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    2.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;
	
	/**
	 * Product Store URL
	 *
	 * @since    2.0.0
	 *
	 * @var      string
	 */
	protected $sc_edd_sl_store_url = 'http://wpstripe.net/';
	
	/**
	 * Product Name for EDD SL Updater
	 *
	 * @since    2.0.0
	 *
	 * @var      string
	 */
	protected $sc_edd_sl_item_name = 'Stripe Checkout Pro';
	
	/**
	 * Author Name for EDD SL Updater
	 *
	 * @since    2.0.0
	 *
	 * @var      string
	 */
	protected $sc_edd_sl_author = 'Phil Derksen';

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     2.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'plugins_loaded', array( $this, 'plugin_textdomain' ) );
		
		if( ! get_option( 'sc_upgrade_has_run' ) ) {
			add_action( 'init', array( $this, 'upgrade_plugin' ), 0 );
		}
		
		// Include required files.
		$this->update_plugin_version();
		$this->setup_constants();

		add_action( 'init', array( $this, 'includes' ), 1 );
		
		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ), 2 );

		// Enqueue admin styles.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		
		// Enqueue admin scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Add admin notice after plugin activation. Also check if should be hidden.
		add_action( 'admin_notices', array( $this, 'admin_install_notice' ) );

		// Add plugin listing "Settings" action link.
		add_filter( 'plugin_action_links_' . plugin_basename( SC_PATH . $this->plugin_slug . '.php' ), array( $this, 'settings_link' ) );
		
		// Set our plugin constants
		//add_action( 'init', array( $this, 'setup_constants' ) );
		
		// Check WP version
		add_action( 'admin_init', array( $this, 'check_wp_version' ) );
		
		// Add public JS
		add_action( 'init', array( $this, 'enqueue_public_scripts' ) );
		
		// Add public CSS
		add_action( 'init', array( $this, 'enqueue_public_styles' ) );
		
		// Filters to add the settings page titles
		add_filter( 'sc_settings_keys_title', array( $this, 'sc_settings_keys_title' ) );
		add_filter( 'sc_settings_default_title', array( $this, 'sc_settings_default_title' ) );
		add_filter( 'sc_settings_licenses_title', array( $this, 'sc_settings_licenses_title' ) );
		
		// Hook into wp_footer so we can localize our script AFTER all the shortcodes have been processed
		add_action( 'wp_footer', array( $this, 'localize_shortcode_script' ) );
		
		// Add admin notice for license keys
		add_action( 'admin_notices', array( $this, 'license_key_notice' ) );
		
		// Check for SC Lite and legacy plugins
		add_action( 'admin_notices', array( $this, 'lite_legacy_notice' ) );
		
		// Run EDD software licensing plugin updater.
		add_action( 'init', array( $this, 'sc_edd_sl_updater' ) );
		
		// Load scripts when posts load so we know if we need to include them or not
		add_filter( 'the_posts', array( $this, 'load_scripts' ) );
	}
	
	function lite_legacy_notice() {
		if( is_plugin_active( 'stripe/stripe-checkout.php' ) || is_plugin_active( 'stripe-coupons/stripe-coupons.php' )
			|| is_plugin_active( 'stripe-custom-fields/stripe-custom-fields.php' ) || is_plugin_active( 'stripe-user-entered-amount/stripe-user-entered-amount.php' ) ) {
				include_once( SC_PATH . 'admin/views/admin-lite-legacy-notice.php' );
		}
	}
	
	function load_scripts( $posts ){
		
		global $sc_options;
		
		if ( empty( $posts ) ) {
			return $posts;
		}

		foreach ( $posts as $post ) {
			if ( ( strpos( $post->post_content, '[stripe' ) !== false ) || ( ! empty( $sc_options['always_enqueue'] ) ) ) {
				// Load CSS
				wp_enqueue_style( $this->plugin_slug . '-public' );
				
				// Load JS
				wp_enqueue_script( $this->plugin_slug . '-public' );
				
				break;
			}
		}

		return $posts;
	}
	
	/**
	 * Update the database option if the version has changed
	 *
	 * @since     2.0.3
	 */
	function update_plugin_version() {
		$current = get_option( 'sc_version' );
		
		if( version_compare( $current, $this->version, '<' ) ) {
			update_option( 'sc_version', $this->version );
		}
	}
	
	/**
	 * Easy Digital Download Plugin Updater Code.
	 *
	 * @since     2.0.0
	 */
	public function sc_edd_sl_updater() {
		global $sc_options;
		
		if( ! class_exists( 'EDD_SL_Plugin_Updater' ) ) {
			// load our custom updater
			include_once( SC_PATH . 'admin/includes/EDD_SL_Plugin_Updater.php' );
		}
		
		if( ! empty( $sc_options['sc_license_key'] ) ) {
			
			// Set the license key
			$license_key = $sc_options['sc_license_key'];

			// setup the updater
			$edd_updater = new EDD_SL_Plugin_Updater( $this->sc_edd_sl_store_url, SC_MAIN_FILE, array(
					'version'   => $this->version, // current plugin version number
					'license'   => $license_key, // license key (used get_option above to retrieve from DB)
					'item_name' => $this->sc_edd_sl_item_name, // name of this plugin
					'author'    => $this->sc_edd_sl_author // author of this plugin
				)
			);
		}
	}

	/**
	 * Check and display notice to admin if any add-on license keys are missing or invalid.
	 *
	 * @since 2.0.0
	 */
	function license_key_notice() {
		global $sc_options;
		
		$inactive = false;
		
		$licenses = get_option( 'sc_licenses' );
		
		if( empty( $sc_options['sc_license_key'] ) || $licenses['Stripe Checkout Pro'] != 'valid' ) {
			$inactive = true;
		}
		
		$inactive = apply_filters( 'sc_inactive_license', $inactive );
		
		if( $this->viewing_this_plugin() && $inactive ) {
			include_once( SC_PATH . 'admin/views/admin-license-notice.php' );
		}
	}
	
	/**
	 * Function to smoothly upgrade from version 1.1.0 to 1.1.1 of the plugin
	 * 
	 * @since 2.0.0
	 */
	function upgrade_plugin() {

		$keys_options = get_option( 'sc_settings_general' );
	
		// Check if test mode was enabled
		if( isset( $keys_options['enable_test_key'] ) && $keys_options['enable_test_key'] == 1 ) {
			// if it was then we remove it because we are now checking if live is enabled, not test
			unset( $keys_options['enable_test_key'] );
		} else {

			// If was not in test mode then we need to set our new value to true
			$keys_options['enable_live_key'] = 1;
		}
		
		// Delete old option settings from old version of SC
		delete_option( 'sc_settings_general' );
		
		// Update our new settings options
		update_option( 'sc_settings_keys', $keys_options );
		
		// Update version number option for future upgrades
		update_option( 'sc_version', $this->version );
		
		// Let us know that we ran the upgrade
		add_option( 'sc_upgrade_has_run', 1 );
	}
	
	/**
	 * Set the title of the 'Licenses' tab
	 * 
	 * @since 2.0.0
	 */
	function sc_settings_licenses_title( $title ) {
		return __( 'Licenses', 'sc' );
	}
	
	/**
	 * Load public facing CSS
	 * 
	 * @since 2.0.0
	 */
	function enqueue_public_styles() {
		global $sc_options;
		
		wp_register_style( 'stripe-checkout-button', 'https://checkout.stripe.com/v3/checkout/button.css', array(), null );
		
		wp_register_style( 'pikaday', SC_URL . 'public/css/pikaday.css', array(), $this->version );
		
		if( empty( $sc_options['disable_css'] ) ) {
			wp_register_style( $this->plugin_slug . '-public', SC_URL . 'public/css/public-pro.css', array( 'stripe-checkout-button', 'pikaday' ), $this->version );
		}
	}
	
	/**
	 * Load public facing JS
	 * 
	 * @since 2.0.0
	 */
	function enqueue_public_scripts() {
		
		// Register Parsley JS validation library.
		wp_register_script( 'parsley', SC_URL . 'public/js/parsley.min.js', array( 'jquery' ), $this->version, true );
		
		wp_register_script( 'stripe-checkout', 'https://checkout.stripe.com/checkout.js', array(), null, true );

		wp_register_script( 'moment', SC_URL . 'public/js/moment.min.js', array(), $this->version, true );
		wp_register_script( 'pikaday', SC_URL . 'public/js/pikaday.js', array( 'moment' ), $this->version, true );
		wp_register_script( 'pikaday-jquery', SC_URL . 'public/js/pikaday.jquery.js', array( 'jquery', 'pikaday' ), $this->version, true );
		
		wp_register_script( $this->plugin_slug . '-public', SC_URL . 'public/js/public.js', array( 'jquery', 'stripe-checkout', 'parsley', 'moment', 'pikaday', 'pikaday-jquery' ), $this->version, true );
		
		wp_localize_script( $this->plugin_slug . '-public', 'sc_coup', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}
	
	/**
	 * Function to localize the script variables being sent from the shortcodes
	 * 
	 * @since 2.0.0
	 */
	function localize_shortcode_script() {
		global $script_vars;

		// Add script debug flag to JS.
		$script_vars['script_debug'] = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG );

		wp_localize_script( $this->plugin_slug . '-public', 'sc_script', $script_vars );

		// clear it out after we use it
		$script_vars = array();
	}
	
	
	/**
	 * Load admin scripts
	 * 
	 * @since 2.0.0
	 */
	public function enqueue_admin_scripts() {
		
		if( $this->viewing_this_plugin() ) {
			wp_enqueue_script( $this->plugin_slug . '-admin-pro', SC_URL . 'admin/js/admin-pro.js', array( 'jquery' ), $this->version, true );
			
			wp_localize_script( $this->plugin_slug . '-admin-pro', 'sc_strings', array(
					'activate'     => __( 'Activate', 'sc' ),
					'deactivate'   => __( 'Deactivate', 'sc' ),
					'valid_msg'    => __( 'License is valid and active.', 'sc' ),
					'inactive_msg' => __( 'License is inactive.', 'sc' ),
					'invalid_msg'  => __( 'Sorry, but this license key is invalid.', 'sc' ),
					'notfound_msg' => __( 'License service could not be found. Please contact support for assistance.', 'sc' ),
					'error_msg'    => __( 'An error has occurred, please try again.', 'sc' )
				)
			);
		}
	}

	/**
	 * Enqueue admin-specific style sheets for this plugin's admin pages only.
	 *
	 * @since     2.0.0
	 */
	public function enqueue_admin_styles() {
		if ( $this->viewing_this_plugin() ) {
			wp_enqueue_style( $this->plugin_slug .'-admin-styles', SC_URL . 'admin/css/admin.css', array(), $this->version );
			wp_enqueue_style( $this->plugin_slug .'-admin-styles-pro', SC_URL . 'admin/css/admin-pro.css', array(), $this->version );
			wp_enqueue_style( $this->plugin_slug .'-toggle-switch', SC_URL . 'admin/css/toggle-switch.css', array(), $this->version );
		}
	}
	
	/**
	 * Make sure user has the minimum required version of WordPress installed to use the plugin
	 * 
	 * @since 2.0.0
	 */
	public function check_wp_version() {
		parent::check_wp_version();
	}
	
	/**
	 * Setup any plugin constants we need 
	 *
	 * @since    2.0.0
	 */
	public function setup_constants() {
		parent::setup_constants();
		
		// EDD SL Updater
		if( ! defined( 'SC_EDD_SL_STORE_URL' ) ) {
			define( 'SC_EDD_SL_STORE_URL', $this->sc_edd_sl_store_url );
		}
	}
	
	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    2.0.0
	 */
	public function plugin_textdomain() {
		parent::plugin_textdomain();
	}
	
	/**
	 * Return an instance of this class.
	 *
	 * @since     2.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    2.0.0
	 */
	public static function activate() {
		// Add value to indicate that we should show admin install notice.
		update_option( 'sc_show_admin_install_notice', 1 );
		
		if( ! function_exists( 'curl_version' ) ) {
			wp_die( sprintf( __( 'You must have the cURL extension enabled in order to run %s. Please enable cURL and try again. <a href="%s">Return to Plugins</a>.', 'sc' ), 
					self::get_plugin_title(), get_admin_url( '', 'plugins.php' ) ) );
		}
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    2.0.0
	 */
	public function add_plugin_admin_menu() {
		parent::add_plugin_admin_menu();
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    2.0.0
	 */
	public function display_plugin_admin_page() {
		parent::display_plugin_admin_page();
	}
	
	/**
	 * Include required files (admin and frontend).
	 *
	 * @since     2.0.0
	 */
	public function includes() {
		parent::includes();
		
		include_once( SC_PATH . 'includes/register-settings-pro.php' );
		
		include_once( SC_PATH . 'includes/shortcodes-pro.php' );
		
	}

	/**
	 * Return localized base plugin title.
	 *
	 * @since     2.0.0
	 *
	 * @return    string
	 */
	public static function get_plugin_title() {
		return __( 'Stripe Checkout Pro', 'sc' );
	}


	/**
	 * Add Settings action link to left of existing action links on plugin listing page.
	 *
	 * @since   2.0.0
	 *
	 * @param   array  $links  Default plugin action links
	 * @return  array  $links  Amended plugin action links
	 */
	public function settings_link( $links ) {

		$setting_link = sprintf( '<a href="%s">%s</a>', esc_url( add_query_arg( 'page', $this->plugin_slug, admin_url( 'admin.php' ) ) ), __( 'Settings', 'sc' ) );
		array_unshift( $links, $setting_link );

		return $links;
	}

	/**
	 * Check if viewing this plugin's admin page.
	 *
	 * @since   2.0.0
	 *
	 * @return  bool
	 */
	private function viewing_this_plugin() {
		
		$screen = get_current_screen();
		
		if( ! empty( $this->plugin_screen_hook_suffix ) && in_array( $screen->id, $this->plugin_screen_hook_suffix ) ) {
			return true;
		}
		
		return false;
	}

	/**
	 * Show notice after plugin install/activate in admin dashboard.
	 * Hide after first viewing.
	 *
	 * @since   2.0.0
	 */
	public function admin_install_notice() {
		parent::admin_install_notice();
	}
}
