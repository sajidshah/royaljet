<?php
/**
 * Stripe Checkout Pro - Subscriptions Add-on
 *
 * @package   SC_SUB
 * @author    Phil Derksen <pderksen@gmail.com>, Nick Young <mycorpweb@gmail.com>
 * @license   GPL-2.0+
 * @link      http://wpstripe.net
 * @copyright 2014-2015 Phil Derksen
 *
 * @wordpress-plugin
 * Plugin Name: Stripe Checkout Pro - Subscriptions Add-on
 * Plugin URI: http://wpstripe.net
 * Description: Subscriptions add-on for Stripe Checkout Pro.
 * Version: 1.1.7
 * Author: Phil Derksen
 * Author URI: http://philderksen.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * GitHub Plugin URI: https://github.com/pderksen/WP-Stripe-Checkout
 * Text Domain: sc_sub
 * Domain Path: /languages/
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'SC_SUB_MAIN_FILE' ) ) {
	define( 'SC_SUB_MAIN_FILE', __FILE__ );
}

if ( ! defined( 'SC_SUB_PATH' ) ) {
	define( 'SC_SUB_PATH', plugin_dir_path( __FILE__ ) );
}

require_once( plugin_dir_path( __FILE__ ) . 'class-stripe-subscriptions.php' );

Stripe_Subscriptions::get_instance();
