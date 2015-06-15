<?php

/**
 * Misc plugin functions
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Check for and include Stripe PHP (v2.0.0 +) library here until we refactor.
// Note plugins using Stripe PHP v1.18.0 or before can run alongside this plugin since the class namespace was updated.
// Was 'Stripe', now 'Stripe\Stripe'.

if ( ! class_exists( 'Stripe\Stripe' ) ) {
	require_once( SC_PATH . 'libraries/stripe-php/init.php' );
}

/**
 * Common method to set Stripe API key from options.
 *
 * @since 2.0.7
 */
function sc_set_stripe_key( $test_mode = 'false' ) {
	global $sc_options;
	$key = '';
	
	// Check first if in live or test mode.
	if( ! empty( $sc_options['enable_live_key'] ) && $sc_options['enable_live_key'] == 1 && $test_mode != 'true' ) {
		$key = ( ! empty( $sc_options['live_secret_key'] ) ? $sc_options['live_secret_key'] : '' );
	} else {
		$key = ( ! empty( $sc_options['test_secret_key'] ) ? $sc_options['test_secret_key'] : '' );
	}

	\Stripe\Stripe::setApiKey( $key );
}

/**
 * Function that will actually charge the customers credit card
 * 
 * @since 2.0.0
 */
function sc_charge_card() {

	global $sc_options;

	// Set redirect
	$redirect      = $_POST['sc-redirect'];
	$fail_redirect = $_POST['sc-redirect-fail'];
	$failed = null;

	$message = '';

	// Get the credit card details submitted by the form
	$token                 = $_POST['stripeToken'];
	$amount                = $_POST['sc-amount'];
	$description           = $_POST['sc-description'];
	$store_name            = $_POST['sc-name'];
	$currency              = $_POST['sc-currency'];
	$test_mode             = ( isset( $_POST['sc_test_mode'] ) ? $_POST['sc_test_mode'] : 'false' );

	sc_set_stripe_key( $test_mode );

	$meta = array();

	$meta = apply_filters( 'sc_meta_values', $meta );

	// We allow a spot to hook in, but the hook in is responsible for all of the code.
	// If the action is non-existant, then we run a default for the button.
	if( has_action( 'sc_do_charge' ) ) {
		do_action( 'sc_do_charge' );
	} else {
		try {
			// Create new customer 
			$new_customer = \Stripe\Customer::create( array(
					'email' => $_POST['stripeEmail'],
					'card'  => $token
				));

			$charge_args = array(
					'amount'      => $amount, // amount in cents, again
					'currency'    => $currency,
					'customer'    => $new_customer['id'],
					'metadata'    => $meta
				);

			if( ! empty( $description ) ) {
				$charge_args['description'] = $description;
			}

			$charge = \Stripe\Charge::create( $charge_args );

			$query_args = array( 'charge' => $charge->id, 'store_name' => urlencode( $store_name ) );

			$failed = false;

		} catch ( \Stripe\Error\Card $e ) {
			// Something else happened, completely unrelated to Stripe

			$redirect = $fail_redirect;

			$failed = true;

			$e = $e->getJsonBody();

			$query_args = array( 'charge' => $e['error']['charge'], 'error_code' => $e['error']['type'], 'charge_failed' => true );
		}

		unset( $_POST['stripeToken'] );

		do_action( 'sc_redirect_before', $failed );

		if( $test_mode == 'true' ) {
			$query_args['test_mode'] = 'true';
		}

		wp_redirect( esc_url_raw( add_query_arg( $query_args, apply_filters( 'sc_redirect', $redirect, $failed ) ) ) );

		exit;
	}

	return;
}

// We only want to run the charge if the Token is set
if( isset( $_POST['stripeToken'] ) ) {
	add_action( 'init', 'sc_charge_card' );
}

/*
 * Function to show the payment details after the purchase
 * 
 * @since 2.0.0
 */
function sc_show_payment_details( $content ) {
	
	global $sc_script_options;
	
	
	$place_above = ( $sc_script_options['other']['payment_details_placement'] == 'above' ? true : false );
	
	/*if ( isset( $sc_options['payment_details_placement'] ) ) {
		echo 'Payment Details: ' . $sc_options['payment_details_placement'] . '<Br>';
	} else {
		echo 'No HIT<br>';
	}*/
	
	if( in_the_loop() && is_main_query() ) {
		global $sc_options;

		$html = '';

		$test_mode = ( isset( $_GET['test_mode'] ) ? 'true' : 'false' );

		sc_set_stripe_key( $test_mode );

		// PRO ONLY: Check for error code.
		if ( isset( $_GET['error_code'] ) ) {
			
			$charge = esc_html( $_GET['charge'] );
			
			if ( $place_above ) {
				return apply_filters( 'sc_payment_details_error', $html, $charge ) . $content;
			} else {
				return $content . apply_filters( 'sc_payment_details_error', $html, $charge );
			}
		}

		// Successful charge output.
		if ( isset( $_GET['charge'] ) && !isset( $_GET['charge_failed'] ) ) {

			if ( empty( $sc_options['disable_success_message'] ) ) {

				$charge_id = esc_html( $_GET['charge'] );

				// https://stripe.com/docs/api/php#charges
				$charge_response = \Stripe\Charge::retrieve( $charge_id );

				$html = '<div class="sc-payment-details-wrap">' . "\n";

				$html .= '<p>' . __( 'Congratulations. Your payment went through!', 'sc' ) . '</p>' . "\n";
				$html .= '<p>' . "\n";

				if ( ! empty( $charge_response->description ) ) {
					$html .= __( "Here's what you purchased:", 'sc' ) . '<br/>' . "\n";
					$html .= stripslashes( $charge_response->description ) . '<br/>' . "\n";
				}

				if ( isset( $_GET['store_name'] ) && ! empty( $_GET['store_name'] ) ) {
					$html .= __( 'From: ', 'sc' ) . stripslashes( stripslashes( urldecode( $_GET['store_name'] ) ) ) . '<br/>' . "\n";
				}

				$html .= '<br/>' . "\n";
				$html .= '<strong>' . __( 'Total Paid: ', 'sc' ) . sc_stripe_to_formatted_amount( $charge_response->amount, $charge_response->currency ) . ' ' .
						 strtoupper( $charge_response->currency ) . '</strong>' . "\n";

				$html .= '</p>' . "\n";

				$html .= '<p>' . sprintf( __( 'Your transaction ID is: %s', 'sc' ), $charge_id ) . '</p>' . "\n";

				$html .= '</div>' . "\n";
				
				if ( $place_above ) {
					return apply_filters( 'sc_payment_details', $html, $charge_response ) . $content;
				} else {
					return $content . apply_filters( 'sc_payment_details', $html, $charge_response );
				}

			} else {

				return $content;
			}
		}
	}

	return $content;
}
add_filter( 'the_content', 'sc_show_payment_details', 11 );

// PRO ONLY: Payment details error in separate function.
// Since we don't have an error code the messaging is different between Lite & Pro.

function sc_default_error_html( $html, $charge ) {

	$charge = \Stripe\Charge::retrieve( $charge );

	$html  = '<div class="sc-payment-details-wrap sc-payment-details-error">' . "\n";
	$html .= '<p>' . __( 'Sorry, but there has been an error processing your payment.', 'sc' ) . '</p>' . "\n";
	$html .= '<p>' . $charge->failure_message . '</p>';
	$html .= '</div>' . "\n";

	return $html;
}
add_filter( 'sc_payment_details_error', 'sc_default_error_html', 10, 2 );

/**
 * Convert amount opposite of sc_decimal_to_stripe_amount().
 * Needed for Stripe's calculated amount. Don't convert if using zero-decimal currency.
 *
 * @since 2.0.0
 */
function sc_stripe_to_decimal_amount( $amount, $currency ) {

	if ( !sc_is_zero_decimal_currency( $currency) ) {
		// Always round to 2 decimals.
		$amount = round( $amount / 100, 2 );
	}

	return $amount;
}

/**
 * Format Stripe (non-decimal) amount for screen.
 *
 * @since 2.0.0
 */
function sc_stripe_to_formatted_amount( $amount, $currency ) {

	// First convert to decimal if needed.
	$amount = sc_stripe_to_decimal_amount( $amount, $currency );

	// Use 2 decimals unless zero-decimal currency.
	$formatted_amount = number_format_i18n( $amount, ( sc_is_zero_decimal_currency( $currency ) ? 0 : 2 ) );

	return $formatted_amount;
}

/**
 * List of zero-decimal currencies according to Stripe.
 * Needed for PHP and JS.
 * See: https://support.stripe.com/questions/which-zero-decimal-currencies-does-stripe-support
 *
 * @since 2.0.0
 */
function sc_zero_decimal_currencies() {
	return array( 'BIF', 'CLP', 'DJF', 'GNF', 'JPY', 'KMF', 'KRW', 'MGA', 'PYG', 'RWF', 'VUV', 'XAF', 'XOF', 'XPF' );
}

/**
 * Check if currency is zero-decimal.
 *
 * @since 2.0.0
 */
function sc_is_zero_decimal_currency( $currency ) {
	return in_array( strtoupper( $currency ), sc_zero_decimal_currencies() );
}

/**
 * Since Stripe does not deal with Shipping information we will add it as meta to pass to the Dashboard
 * 
 * @since 2.0.0
 */
function sc_add_shipping_meta( $meta ) {
	if( isset( $_POST['sc-shipping-name'] ) ) {
		
		// Add Shipping Name as an item
		$meta['Shipping Name']    = $_POST['sc-shipping-name'];
		
		// Show address on two lines: Address 1 and Address 2 in Stripe dashboard -> payments 
		$meta['Shipping Address 1'] = $_POST['sc-shipping-address'];
		$meta['Shipping Address 2'] = $_POST['sc-shipping-zip'] . ', ' . $_POST['sc-shipping-city'] . ', ' . $_POST['sc-shipping-state'] . ', ' . $_POST['sc-shipping-country'];
	}
	
	return $meta;
}
add_filter( 'sc_meta_values', 'sc_add_shipping_meta' );

/**
 * Google Analytics campaign URL.
 *
 * @since   2.0.0
 *
 * @param   string  $base_url Plain URL to navigate to
 * @param   string  $source   GA "source" tracking value
 * @param   string  $medium   GA "medium" tracking value
 * @param   string  $campaign GA "campaign" tracking value
 * @return  string  $url      Full Google Analytics campaign URL
 */
function sc_ga_campaign_url( $base_url, $source, $medium, $campaign ) {
	// $medium examples: 'sidebar_link', 'banner_image'

	$url = esc_url( add_query_arg( array(
		'utm_source'   => $source,
		'utm_medium'   => $medium,
		'utm_campaign' => $campaign
	), $base_url ) );

	return $url;
}

function sc_license_settings( $settings ) {
	
	$settings['licenses']['note'] = array(
			'id'   => 'note',
			'name' => '',
			'desc' => '<p class="description">' . __( 'These license keys are used for access to automatic upgrades and support.', 'sc' ) . '</p>',
			'type' => 'section'
	);

	$settings['licenses']['sc_license_key'] = array(
			'id'   => 'sc_license_key',
			'name' => __( 'Stripe Checkout Pro License Key', 'sc' ),
			'desc' => '',
			'type' => 'license',
			'size' => 'regular-text',
			'product' => 'Stripe Checkout Pro'
	);

	return $settings;
}
add_filter( 'sc_settings', 'sc_license_settings' );

function sc_check_license( $license, $item ) {
	
	$check_params = array(
		'edd_action' => 'check_license',
		'license'    => $license,
		'item_name'  => urlencode( $item ),
		'url'        => home_url()
	);

	// Move to wp_remote_post with 'body' array var set like EDD SL plugin updater v1.6 (4/27/2015).
	$response = wp_remote_post( SC_EDD_SL_STORE_URL, array( 'timeout' => 15, 'body' => $check_params, 'sslverify' => false ) );
	// OLD: $response = wp_remote_get( esc_url_raw( add_query_arg( $check_params, SC_EDD_SL_STORE_URL ) ), array( 'timeout' => 15, 'sslverify' => false ) );

	if( is_wp_error( $response ) )
	{
		return 'error';
	}
	
	$is_valid = json_decode( wp_remote_retrieve_body( $response ) );
	
	if( ! empty( $is_valid ) ) {
		return json_decode( wp_remote_retrieve_body( $response ) )->license;
	} else {
		return 'notfound';
	}
}

function sc_activate_license() {
	$sc_licenses = get_option( 'sc_licenses' );
	
	$current_license = $_POST['license'];
	$item            = $_POST['item'];
	$action          = $_POST['sc_action'];
	$id              = $_POST['id'];
	
	// Need to trim the id of the excess stuff so we can update our option later
	$length = strpos( $id, ']' ) - strpos( $id, '[' );
	$id     = substr( $id, strpos( $id, '[' ) + 1, $length - 1 );
	
	// Do activation
	$activate_params = array(
		'edd_action' => $action,
		'license'    => $current_license,
		'item_name'  => urlencode( $item ),
		'url'        => home_url()
	);

	// Move to wp_remote_post with 'body' array var set like EDD SL plugin updater v1.6 (4/27/2015).
	$response = wp_remote_post( SC_EDD_SL_STORE_URL, array( 'timeout' => 15, 'body' => $activate_params, 'sslverify' => false ) );
	// OLD: $response = wp_remote_get(  esc_url_raw( add_query_arg( $activate_params, SC_EDD_SL_STORE_URL ) ), array( 'timeout' => 15, 'sslverify' => false ) );

	if( is_wp_error( $response ) )
	{
		echo 'ERROR';
		
		die();
	}
	
	$activate_data = json_decode( wp_remote_retrieve_body( $response ) );
	
	if( $activate_data->license == 'valid' ) {
		$sc_licenses[$item] = 'valid';
		
		$sc_settings_licenses = get_option( 'sc_settings_licenses' );
		
		$sc_settings_licenses[$id] = $current_license;
		
		update_option( 'sc_settings_licenses', $sc_settings_licenses );
		
		
	} else if( $activate_data->license == 'deactivated' ) {
		$sc_licenses[$item] = 'deactivated';
	} else {
		$sc_licenses[$item] = 'invalid';
	}
	
	update_option( 'sc_licenses', $sc_licenses );
	
	echo $activate_data->license;
	
	die();
}
add_action( 'wp_ajax_sc_activate_license', 'sc_activate_license' );

/**
 * Function to handle AJAX request for coupon check
 * 
 * @since 2.0.0
 */
function sc_coup_ajax_check() {

	global $sc_options;

	$json = '';
	$code = $_POST['coupon'];
	$amount = $_POST['amount'];

	$json['coupon']['code'] = $code;
	
	$test_mode = $_POST['test_mode'];
	
	sc_set_stripe_key( $test_mode );

	try {
		$coupon = \Stripe\Coupon::retrieve( trim( $code ) );

		if( ! empty( $coupon->percent_off ) ) {
			$json['coupon']['amountOff'] = $coupon->percent_off;
			$json['coupon']['type'] = 'percent';

			if( $coupon->percent_off == 100 ) {
				$amount = 0;
			} else {
				$amount = round( ( $amount * ( ( 100 - $coupon->percent_off ) / 100 ) ) );
			}
		} else if( ! empty( $coupon->amount_off ) ) {
			$json['coupon']['amountOff'] = $coupon->amount_off;
			$json['coupon']['type'] = 'amount';

			$amount = $amount - $coupon->amount_off;

			if( $amount < 0 ) {
				$amount = 0;
			}
		}

		// Set message to amount now before checking for errors
		$json['success'] = true;
		$json['message'] = $amount;

		if( $amount < 50 ) {
			$json['success'] = false;
			$json['message'] = __( 'Coupon entered puts the total below the required minimum amount.', 'sc' );
		}

	} catch (Exception $e) {
		// an exception was caught, so the code is invalid
		$json['success'] = false;
		$json['message'] = __( 'Invalid coupon code.', 'sc' );
	}
		
	// Return as JSON
	echo json_encode( $json );
	
	die();
}
add_action( 'wp_ajax_sc_coup_get_coupon', 'sc_coup_ajax_check' );
add_action( 'wp_ajax_nopriv_sc_coup_get_coupon', 'sc_coup_ajax_check' );

/**
 * Function to handle adding the coupon as meta data in Stripe Dashboard
 * 
 * @since 2.0.0
 */
function sc_coup_add_coupon_meta( $meta ) {
	if( isset( $_POST['sc_coup_coupon_code'] ) && ! empty( $_POST['sc_coup_coupon_code'] ) ) {
		$meta['Coupon Code'] = $_POST['sc_coup_coupon_code'];
	}
	
	return $meta;
}
add_filter( 'sc_meta_values', 'sc_coup_add_coupon_meta' );

/*
 * Send post meta
 * 
 * @since 2.0.0
 */
function sc_cf_checkout_meta( $meta ) {
	if( isset( $_POST['sc_form_field'] ) ) {
		foreach( $_POST['sc_form_field'] as $k => $v ) {
			if( ! empty( $v ) ) {
				$meta[$k] = $v;
			}
		}
	}
	
	return $meta;
}
add_filter( 'sc_meta_values', 'sc_cf_checkout_meta' );

/**
 * This function hooks into the Stipe Checkout attributes and checks to see if an amount attribute is added
 * If an amount attribute is not added then we set it to 50 (the lowest possible) so that it will still show the button
 * and our UEA plugin will be able to run.
 * 
 * @since 2.0.0
 */
function sc_uea_set_minimum( $out, $pairs, $atts ) {
	
	if( empty( $out['amount'] ) ) {
		$out['amount'] = 50;
	}
	
   return $out;
}
add_filter( 'shortcode_atts_stripe', 'sc_uea_set_minimum', 10, 3 );


/**
 * Filters the content to remove any extra paragraph or break tags
 * caused by shortcodes.
 *
 * @since 1.0.0
 *
 * @param string $content  String of HTML content.
 * @return string $content Amended string of HTML content.
 * 
 * REF: https://thomasgriffin.io/remove-empty-paragraph-tags-shortcodes-wordpress/
 */
function sc_shortcode_fix( $content ) {

    $array = array(
        '<p>['    => '[',
        ']</p>'   => ']',
        ']<br />' => ']'
    );
	
    return strtr( $content, $array );
}
add_filter( 'the_content', 'sc_shortcode_fix' );
