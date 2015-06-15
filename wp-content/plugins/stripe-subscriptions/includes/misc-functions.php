<?php


/**
 * Check if the [stripe_subscription] shortcode exists on this page
 * 
 * @since 1.0.0
 */
function sc_sub_has_shortcode() {
	global $post;
	
	// Currently ( 5/8/2014 ) the has_shortcode() function will not find a 
	// nested shortcode. This seems to do the trick currently, will switch if 
	// has_shortcode() gets updated. -NY
	if ( strpos( $post->post_content, '[stripe_subscription' ) !== false ) {
		return true;
	}
	
	return false;
}

/**
 * Helper function to grab the subscription by ID and return the subscription object
 * 
 * @since 1.0.0
 */
function sc_sub_get_subscription_by_id( $id, $test_mode = 'false' ) {
	
	global $sc_options;
	
	$test_mode = ( isset( $_GET['test_mode'] ) ? 'true' : $test_mode );
	
	// Check if in test mode or live mode
	if( ! empty( $sc_options['enable_live_key'] ) && $sc_options['enable_live_key'] == 1 && $test_mode != 'true' ) {
		$data_key = ( ! empty( $sc_options['live_secret_key'] ) ? $sc_options['live_secret_key'] : '' );
	} else {
		$data_key = ( ! empty( $sc_options['test_secret_key'] ) ? $sc_options['test_secret_key'] : '' );
	}
	
	if( empty( $data_key ) ) {
		
		if( current_user_can( 'manage_options' ) ) {
			return '<h6>' . __( 'You must enter your API keys before the Stripe button will show up here.', 'sc_sub' ) . '</h6>';
		}
		
		return '';
	}
	
	\Stripe\Stripe::setApiKey( $data_key );

	// TODO Update with new Stripe PHP lib syntax.
	
	try {
		$return = \Stripe\Plan::retrieve( trim( $id ) );

	} catch( \Stripe\Error\Card $e ) {

		$body = $e->getJsonBody();

		$return = sc_print_errors( $body['error'] );

	} catch ( \Stripe\Error\Authentication $e ) {
		// Authentication with Stripe's API failed
		// (maybe you changed API keys recently)

		$body = $e->getJsonBody();

		$return = sc_print_errors( $body['error'] );

	} catch ( \Stripe\Error\ApiConnection $e ) {
		// Network communication with Stripe failed

		$body = $e->getJsonBody();

		$return = sc_print_errors( $body['error'] );

	} catch ( \Stripe\Error\Base $e ) {
		
		$body = $e->getJsonBody();

		$return = sc_print_errors( $body['error'] );

	} catch ( Exception $e ) {
		// Something else happened, completely unrelated to Stripe
		$body = $e->getJsonBody();

		$return = sc_print_errors( $body['error'] );
	}
	
	return $return;
}


/**
 * Add the license key settings 
 * 
 * @since 1.0.0
 */
function sc_sub_license_settings( $settings ) {
	
	$settings['licenses']['note'] = array(
			'id'   => 'note',
			'name' => '',
			'desc' => '<p class="description">' . __( 'These license keys are used for access to automatic upgrades and support.', 'sc_sub' ) . '</p>',
			'type' => 'section'
	);

	$settings['licenses']['sc_sub_license_key'] = array(
			'id'   => 'sc_sub_license_key',
			'name' => __( 'Subscriptions License Key', 'sc_sub' ),
			'desc' => '',
			'type' => 'license',
			'size' => 'regular-text',
			'product' => 'Stripe Subscriptions'
	);

	return $settings;
}
add_filter( 'sc_settings', 'sc_sub_license_settings', 20 );


function sc_sub_inactive_license_check( $inactive ) {
	global $sc_options;
	
	$licenses = get_option( 'sc_licenses' );


	if( empty( $sc_options['sc_sub_license_key'] ) || $licenses['Stripe Subscriptions'] != 'valid' ) {
		return true;
	}
	
	// Return the original if we are not returning true
	return $inactive;
	
}
add_filter( 'sc_inactive_license', 'sc_sub_inactive_license_check' );


function sc_sub_add_payment_details( $html, $details ) {
	
	if( ! isset( $details->invoice ) ) {
		return $html;
	}
	
	$invoice = \Stripe\Invoice::retrieve( $details->invoice );
	
	$interval = $invoice->lines->data[0]->plan->interval;
	$interval_count = $invoice->lines->data[0]->plan->interval_count;

	$html = '<div class="sc-payment-details-wrap">' . "\n";

	$html .= '<p>' . __( 'Congratulations. Your payment went through!', 'sc' ) . '</p>' . "\n";
	$html .= '<p>' . "\n";

	if ( ! empty( $details->description ) ) {
		$html .= __( "Here's what you purchased:", 'sc' ) . '<br/>' . "\n";
		$html .= stripslashes( $details->description ) . '<br/>' . "\n";
	}

	if ( isset( $_GET['store_name'] ) && ! empty( $_GET['store_name'] ) ) {
		$html .= __( 'From: ', 'sc' ) . stripslashes( stripslashes( urldecode( $_GET['store_name'] ) ) ) . '<br/>' . "\n";
	}

	$html .= '<br/>' . "\n";
	$html .= '<strong>' . __( 'Total Paid: ', 'sc' ) . sc_stripe_to_formatted_amount( $details->amount, $details->currency ) . ' ' .
	         strtoupper( $details->currency ) . '</strong>' . "\n";

	$html .= '</p>' . "\n";

	$html .= '<p>' . __( 'You will be charged ', 'sc_sub' );

	$html .= sc_stripe_to_formatted_amount( $details->amount, $details->currency ) . ' ' . strtoupper( $details->currency );

	// For interval count of 1, use $1.00/month format.
	// For a count > 1, use $1.00 every 3 months format.
	if ( $interval_count == 1 ) {
		$html .= '/' . $interval;
	} else {
		$html .= ' ' . __( 'every', 'sc_sub' ) . ' ' . $interval_count . ' ' . $interval . 's';
	}

	$html .= '</p>' . "\n";

	$html .= '<p>' . sprintf( __( 'Your transaction ID is: %s', 'sc' ), $details->id ) . '</p>';

	$html .= '</div>';
	
	return $html;
	
}
add_filter( 'sc_payment_details', 'sc_sub_add_payment_details', 10, 2 );


// Don't produce a fatal error when old version of SCP still active.

if ( ! function_exists( 'sc_print_errors' ) ) {

	function sc_print_errors( $err = array() ) {

		$message = '';

		if ( current_user_can( 'manage_options' ) ) {
			foreach ( $err as $k => $v ) {
				$message = '<h6>' . $k . ': ' . $v . '</h6>';
			}
		} else {
			$message = '<h6>' . __( 'An error has occurred. If the problem persists, please contact a site administrator.', 'sc' ) . '</h6>';
		}

		return apply_filters( 'sc_error_message', $message );
	}
}


function sc_sub_do_charge() {
	
	global $sc_options;
		
	$query_args = array();

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
	
	$sub                   = ( isset( $_POST['sc_sub_id'] ) ); 
	$interval              = ( isset( $_POST['sc_sub_interval'] ) ? $_POST['sc_sub_interval'] : 'month' );
	$interval_count        = ( isset( $_POST['sc_sub_interval_count'] ) ? $_POST['sc_sub_interval_count'] : 1 );
	$statement_description = ( isset( $_POST['sc_sub_statement_description'] ) ? $_POST['sc_sub_statement_description'] : '' );
	
	$coupon                = ( isset( $_POST['sc_coup_coupon_code'] ) ? $_POST['sc_coup_coupon_code'] : '' );
	
	$test_mode             = ( isset( $_POST['sc_test_mode'] ) ? $_POST['sc_test_mode'] : 'false' );
		
	if( $sub ) {
		$sub = ( ! empty( $_POST['sc_sub_id'] ) ? $_POST['sc_sub_id'] : 'custom' );
	}

	sc_set_stripe_key( $test_mode );

	$meta = array();

	$meta = apply_filters( 'sc_meta_values', $meta );
	
	try {
				
		if( $sub == 'custom' ) {

			$timestamp = time();

			$plan_id = $_POST['stripeEmail'] . '_' . $amount . '_' . $timestamp;

			$name = __( 'Subscription:', 'sc' ) . ' ' . sc_stripe_to_formatted_amount( $amount, $currency ) . ' ' . strtoupper( $currency ) . '/' . $interval;

			// Create a plan
			$plan_args = array( 
					'amount'                => $amount,
					'interval'              => $interval,
					'name'                  => $name,
					'currency'              => $currency,
					'id'                    => $plan_id,
					'interval_count'        => $interval_count
				);

			if( ! empty( $statement_description ) ) {
				$plan_args['statement_descriptor'] = $statement_description;
			}

			$new_plan = \Stripe\Plan::create( $plan_args );

			// Create a customer and charge
			$new_customer = \Stripe\Customer::create( array(
					'email'    => $_POST['stripeEmail'],
					'card'     => $token,
					'plan'     => $plan_id,
					'metadata' => $meta
				));

		} else {

			// Create new customer 
			$cust_args = array( 
					'email' => $_POST['stripeEmail'],
					'card'  => $token,
					'plan' => $sub,
					'metadata' => $meta
				);

			if( ! empty( $coupon ) ) {
				$cust_args['coupon'] = $coupon;
			}

			$new_customer = \Stripe\Customer::create( $cust_args );

			// Set currency based on sub
			$plan = \Stripe\Plan::retrieve( $sub );

			//echo $subscription . '<Br>';
			$currency = strtoupper( $plan->currency );

		}

		// We want to add the meta data and description to the actual charge so that users can still view the meta sent with a subscription + custom fields
		// the same way that they would normally view it without subscriptions installed.
		// We need the steps below to do this

		// First we get the latest invoice based on the customer ID
		$invoice = \Stripe\Invoice::all( array(
			'customer' => $new_customer->id,
			'limit' => 1 )
		 );

		// If this is a trial we need to skip this part since a charge is not made
		$trial = $invoice->data[0]->lines->data[0]->plan->trial_period_days;

		if( empty( $trial ) ) {
			// Now that we have the invoice object we can get the charge ID
			$inv_charge = $invoice->data[0]->charge;

			// Finally, with the charge ID we can update the specific charge and inject our meta data sent from Stripe Custom Fields
			$ch = \Stripe\Charge::retrieve( $inv_charge );
			
			if ( ! empty( $meta ) ) {
				$ch->metadata = $meta;
			}

			if( ! empty( $description ) ) {
				$ch->description = $description;
			}

			$ch->save();

			$query_args = array( 'charge' => $ch->id, 'store_name' => urlencode( $store_name ) );

			$failed = false;
		} else {

			$sub_id = $invoice->data[0]->subscription;

			$query_args = array( 'cust_id' => $new_customer->id, 'sub_id' => $sub_id, 'trial' => true, 'store_name' => urlencode( $store_name ) );

			$failed = false;
		}

	} catch (Exception $e) {
		// Something else happened, completely unrelated to Stripe

		$redirect = $fail_redirect;

		$failed = true;

		$e = $e->getJsonBody();
		
		$query_args = array( 'sub' => true, 'error_code' => $e['error']['type'], 'charge_failed' => true );
	}
	
	unset( $_POST['stripeToken'] );
		
	do_action( 'sc_redirect_before' );

	if( $test_mode == 'true' ) {
		$query_args['test_mode'] = 'true';
	}

	wp_redirect( esc_url_raw( add_query_arg( $query_args, apply_filters( 'sc_redirect', $redirect, $failed ) ) ) );

	exit;
}
if( isset( $_POST['sc_sub_id'] ) ) {
	add_action( 'sc_do_charge', 'sc_sub_do_charge' );
}

// Don't produce a fatal error when old version of SCP still active.

if ( ! function_exists( 'sc_validate_subscription' ) ) {

	function sc_validate_subscription( $html ) {

		$sub = Shortcode_Tracker::shortcode_exists_current( 'stripe_subscription' );
		$uea = Shortcode_Tracker::shortcode_exists_current( 'stripe_amount' );

		//$html = '';

		// Neither exist so we can just exit now
		if ( $sub === false && $uea === false ) {
			return $html;
		}

		$sub_id       = isset( $sub['attr']['id'] ) ? true : false;
		$sub_children = isset( $sub['children'] ) ? true : false;
		$use_amount   = ( isset( $sub['attr']['use_amount'] ) && $sub['attr']['use_amount'] == 'true' ) ? true : false;

		// Can't have both an ID and UEA
		if ( ( $sub_id || $sub_children ) && $uea ) {
			Shortcode_Tracker::update_error_count();

			if ( current_user_can( 'manage_options' ) ) {
				Shortcode_Tracker::add_error_message( '<h6>' . __( 'Subscriptions must specify a plan ID or include a user-entered amount field. You cannot include both or omit both.', 'sc' ) . '</h6>' );
			}
		}

		if ( empty( $sub_id ) && ( $uea || $use_amount ) && $sub != false ) {

			$interval              = ( isset( $sub['attr']['interval'] ) ? $sub['attr']['interval'] : 'month' );
			$interval_count        = ( isset( $sub['attr']['interval_count'] ) ? $sub['attr']['interval_count'] : 1 );
			$statement_description = ( isset( $sub['attr']['statement_description'] ) ? $sub['attr']['statement_description'] : '' );

			$html .= '<input type="hidden" name="sc_sub_id" class="sc_sub_id" value="" />';
			$html .= '<input type="hidden" name="sc_sub_interval" class="sc_sub_interval" value="' . $interval . '" />';
			$html .= '<input type="hidden" name="sc_sub_interval_count" class="sc_sub_interval_count" value="' . $interval_count . '" />';
			$html .= '<input type="hidden" name="sc_sub_statement_description" class="sc_sub_statement_description" value="' . $statement_description . '" />';
		}

		if ( empty( $sub_id ) && ! $uea && empty( $sub_children ) && $use_amount === false ) {
			Shortcode_Tracker::update_error_count();

			if ( current_user_can( 'manage_options' ) ) {
				Shortcode_Tracker::add_error_message( '<h6>' . __( 'Subscriptions must specify a plan ID or include a user-entered amount field. You cannot include both or omit both.', 'sc' ) . '</h6>' );
			}
		}

		return $html;
	}

	add_filter( 'sc_before_payment_button', 'sc_validate_subscription' );

}
