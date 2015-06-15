<?php
/**
 * Plugin shortcode functions
 *
 * @package SC
 * @author  Phil Derksen <pderksen@gmail.com>, Nick Young <mycorpweb@gmail.com>
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Function to process the [stripe] shortcode
 * 
 * @since 2.0.0
 */
function sc_stripe_shortcode_pro( $attr, $content = null ) {
	
	global $sc_options, $sc_script_options, $script_vars;

	// Variable to hold each form's data-sc-id attribute.
	static $sc_id = 0;

	// Increment variable for each iteration.
	$sc_id++;

	extract( shortcode_atts( array(
					'name'                  => ( ! empty( $sc_options['name'] ) ? $sc_options['name'] : get_bloginfo( 'title' ) ),
					'description'           => '',
					'amount'                => '',
					'image_url'             => '',
					'currency'              => ( ! empty( $sc_options['currency'] ) ? $sc_options['currency'] : 'USD' ),
					'checkout_button_label' => '',
					'billing'               => '',    // true or false
					'shipping'              => '',    // true or false
					'payment_button_label'  => ( ! empty( $sc_options['payment_button_label'] ) ? $sc_options['payment_button_label'] : __( 'Pay with Card', 'sc' ) ),
					'enable_remember'       => ( ! empty( $sc_options['enable_remember'] ) ? 'true' : 'false' ),    // true or false
					'bitcoin'               => ( ! empty( $sc_options['use_bitcoin'] ) ? 'true' : 'false' ),    // true or false
					'success_redirect_url'  => ( ! empty( $sc_options['success_redirect_url'] ) ? $sc_options['success_redirect_url'] : get_permalink() ),
					'failure_redirect_url'  => ( ! empty( $sc_options['failure_redirect_url'] ) ? $sc_options['failure_redirect_url'] : get_permalink() ),
					'prefill_email'         => 'false',
					'verify_zip'            => ( ! empty( $sc_options['verify_zip'] ) ? 'true' : 'false' ),
					'payment_button_style'  => ( ! empty( $sc_options['payment_button_style'] ) && $sc_options['payment_button_style'] == 'none' ? 'none' : '' ),
					'test_mode'             => 'false',
					'id'                    => null,
					'alipay'                => ( ! empty( $sc_options['alipay'] ) ? $sc_options['alipay'] : 'false' ), // true, false or auto
					'alipay_reusable'       => ( ! empty( $sc_options['alipay_reusable'] ) ? 'true' : 'false' ), // true or false
					'locale'                => ( ! empty( $sc_options['locale'] ) ? 'auto' : '' ), // empty or auto
					'payment_details_placement' => 'above',
				), $attr, 'stripe' ) );
	
	
	// Generate custom form id attribute if one not specified.
	// Rename var for clarity.
	$form_id = $id;
	if ( $form_id === null || empty( $form_id ) ) {
		$form_id = 'sc_checkout_form_' . $sc_id;
	}
	
	Shortcode_Tracker::set_as_base( 'stripe', $attr );
	
	$test_mode = ( isset( $_GET['test_mode'] ) ? 'true' : $test_mode );
	
	
	// Check if in test mode or live mode
	if( ! empty( $sc_options['enable_live_key'] ) && $sc_options['enable_live_key'] == 1 && $test_mode != 'true' ) {
		$data_key = ( ! empty( $sc_options['live_publish_key'] ) ? $sc_options['live_publish_key'] : '' );
		
		if( empty( $sc_options['live_secret_key'] ) ) {
			$data_key = '';
		}
	} else {
		$data_key = ( ! empty( $sc_options['test_publish_key'] ) ? $sc_options['test_publish_key'] : '' );
		
		if( empty( $sc_options['test_secret_key'] ) ) {
			$data_key = '';
		}
	}
	
	if( empty( $data_key ) ) {
		
		if( current_user_can( 'manage_options' ) ) {
			return '<h6>' . __( 'You must enter your API keys before the Stripe button will show up here.', 'sc' ) . '</h6>';
		}
		
		return '';
	}
	
	if( ! empty( $prefill_email ) && $prefill_email !== 'false' ) {
		// Get current logged in user email
		if( is_user_logged_in() ) {
			$prefill_email = get_userdata( get_current_user_id() )->user_email;
		} else { 
			$prefill_email = 'false';
		}
	}

	// Populate <form> tag including "id" and data-sc-id attributes.
	// Add Parsley JS form validation attribute here.
	$html  =
		'<form method="POST" action="" class="sc-checkout-form" ' .
		'id="' . esc_attr( $form_id ) . '" ' .
		'data-sc-id="' . $sc_id . '" ' .
		'data-parsley-validate>';

	// Save all of our options to an array so others can run them through a filter if they need to
	$sc_script_options = array( 
		'script' => array(
			'key'                  => $data_key,
			'name'                 => html_entity_decode( $name ),
			'description'          => html_entity_decode( $description ),
			'amount'               => $amount,
			'image'                => $image_url,
			'currency'             => strtoupper( $currency ),
			'panel-label'          => html_entity_decode( $checkout_button_label ),
			'billing-address'      => $billing,
			'shipping-address'     => $shipping,
			'label'                => html_entity_decode( $payment_button_label ),
			'allow-remember-me'    => $enable_remember,
			'bitcoin'              => $bitcoin,
			'email'                => $prefill_email,
			'verify_zip'           => $verify_zip,
			'alipay'               => $alipay,
			'alipay_reusable'      => $alipay_reusable,
			'locale'               => $locale,
		),
		'other' => array(
			'success-redirect-url' => $success_redirect_url,
			'failure-redirect-url' => $failure_redirect_url,
			'payment_details_placement' => ( $payment_details_placement == 'below' ? 'below' : 'above' ),
		)
	);
	
	$html .= do_shortcode( $content );
	
	$sc_script_options = apply_filters( 'sc_modify_script_options', $sc_script_options );
	
	// Set our global array based on the uid so we can make sure each button/form is unique
	$script_vars[$sc_id] = array(
			'key'             => ( ! empty( $sc_script_options['script']['key'] ) ? $sc_script_options['script']['key'] : ( ! empty( $sc_options['key'] ) ? $sc_options['key'] : -1 ) ),
			'name'            => ( ! empty( $sc_script_options['script']['name'] ) ? $sc_script_options['script']['name'] : ( ! empty( $sc_options['name'] ) ? $sc_options['name'] : -1 ) ),
			'description'     => ( ! empty( $sc_script_options['script']['description'] ) ? $sc_script_options['script']['description'] : ( ! empty( $sc_options['description'] ) ? $sc_options['description'] : -1 ) ),
			'amount'          => ( ! empty( $sc_script_options['script']['amount'] ) ? $sc_script_options['script']['amount'] : ( ! empty( $sc_options['amount'] ) ? $sc_options['amount'] : -1 ) ),
			'image'           => ( ! empty( $sc_script_options['script']['image'] ) ? $sc_script_options['script']['image'] : ( ! empty( $sc_options['image_url'] ) ? $sc_options['image_url'] : -1 ) ),
			'currency'        => ( ! empty( $sc_script_options['script']['currency'] ) ? $sc_script_options['script']['currency'] : ( ! empty( $sc_options['currency'] ) ? $sc_options['currency'] : -1 ) ),
			'panelLabel'      => ( ! empty( $sc_script_options['script']['panel-label'] ) ? $sc_script_options['script']['panel-label'] : ( ! empty( $sc_options['checkout_button_label'] ) ? $sc_options['checkout_button_label'] : -1 ) ),
			'billingAddress'  => ( ! empty( $sc_script_options['script']['billing-address'] ) ? $sc_script_options['script']['billing-address'] : ( ! empty( $sc_options['billing'] ) ? $sc_options['billing'] : -1 ) ),
			'shippingAddress' => ( ! empty( $sc_script_options['script']['shipping-address'] ) ? $sc_script_options['script']['shipping-address'] : ( ! empty( $sc_options['shipping'] ) ? $sc_options['shipping'] : -1 ) ),
			'allowRememberMe' => ( ! empty( $sc_script_options['script']['allow-remember-me'] ) ? $sc_script_options['script']['allow-remember-me'] : ( ! empty( $sc_options['enable_remember'] ) ? $sc_options['enable_remember'] : -1 ) ),
			'bitcoin'         => ( ! empty( $sc_script_options['script']['bitcoin'] ) ? $sc_script_options['script']['bitcoin'] : ( ! empty( $sc_options['use_bitcoin'] ) ? $sc_options['use_bitcoin'] : -1 ) ),
			'email'           => ( ! empty( $sc_script_options['script']['email'] ) && ! ( $sc_script_options['script']['email'] === 'false' ) ? $sc_script_options['script']['email'] : -1 ),
			'zipCode'         => ( ! empty( $sc_script_options['script']['verify_zip'] ) && ! ( $sc_script_options['script']['verify_zip'] === 'false' ) ? $sc_script_options['script']['verify_zip'] : -1 ),
			'alipay'          => ( ! empty( $sc_script_options['script']['alipay'] ) && ! ( $sc_script_options['script']['alipay'] === 'false' ) ? $sc_script_options['script']['alipay'] : -1 ),
			'alipay_reusable' => ( ! empty( $sc_script_options['script']['alipay_reusable'] ) && ! ( $sc_script_options['script']['alipay_reusable'] === 'false' ) ? $sc_script_options['script']['alipay_reusable'] : -1 ),
			'locale'          => ( ! empty( $sc_script_options['script']['locale'] ) && ! ( $sc_script_options['script']['locale'] === 'false' ) ? 'auto' : -1 ),
	);

	// Reference for Stripe's zero-decimal currencies in JS.
	$script_vars['zero_decimal_currencies'] = sc_zero_decimal_currencies();
	
	$name                 = $sc_script_options['script']['name'];
	$description          = $sc_script_options['script']['description'];
	$amount               = $sc_script_options['script']['amount'];
	$success_redirect_url = $sc_script_options['other']['success-redirect-url'];
	$failure_redirect_url = $sc_script_options['other']['failure-redirect-url'];
	$currency             = $sc_script_options['script']['currency'];

	if( false !== Shortcode_Tracker::shortcode_exists_current( 'stripe_subscription' ) ) {
		if ( $bitcoin == 'true' ) {
			if ( current_user_can( 'manage_options' ) ) {
				return '<h6>' . __( 'Bitcoin cannot be used with Stripe subscriptions at this time.', 'sc' ) . '</h6>';
			}
			
			return '';
		}
		
		if ( $alipay == 'true' ) {
			if ( current_user_can( 'manage_options' ) ) {
				return '<h6>' . __( 'Alipay cannot be used with Stripe subscriptions at this time.', 'sc' ) . '</h6>';
			}
			
			return '';
		}
	}
	
	$html .= '<input type="hidden" name="sc-name" value="' . esc_attr( $name ) . '" />';
	$html .= '<input type="hidden" name="sc-description" value="' . esc_attr( $description ) . '" />';
	$html .= '<input type="hidden" name="sc-amount" class="sc_amount" value="" />';
	$html .= '<input type="hidden" name="sc-redirect" value="' . esc_attr( ( ! empty( $success_redirect_url ) ? $success_redirect_url : get_permalink() ) ) . '" />';
	$html .= '<input type="hidden" name="sc-redirect-fail" value="' . esc_attr( ( ! empty( $failure_redirect_url ) ? $failure_redirect_url : get_permalink() ) ) . '" />';
	$html .= '<input type="hidden" name="sc-currency" value="' . esc_attr( $currency ) . '" />';
	$html .= '<input type="hidden" name="stripeToken" value="" class="sc_stripeToken" />';
	$html .= '<input type="hidden" name="stripeEmail" value="" class="sc_stripeEmail" />';
	
	if( $test_mode == 'true' ) {
		$html .= '<input type="hidden" name="sc_test_mode" value="true" />'; 
	}
	
	// Add shipping information fields if it is enabled
	if( $shipping === 'true' ) {
		$html .= '<input type="hidden" name="sc-shipping-name" class="sc-shipping-name" value="" />';
		$html .= '<input type="hidden" name="sc-shipping-country" class="sc-shipping-country" value="" />';
		$html .= '<input type="hidden" name="sc-shipping-zip" class="sc-shipping-zip" value="" />';
		$html .= '<input type="hidden" name="sc-shipping-state" class="sc-shipping-state" value="" />';
		$html .= '<input type="hidden" name="sc-shipping-address" class="sc-shipping-address" value="" />';
		$html .= '<input type="hidden" name="sc-shipping-city" class="sc-shipping-city" value="" />';
	}

	// Add an action here to allow developers to hook into the form
	$filter_html = '';
	$html .= apply_filters( 'sc_before_payment_button', $filter_html );

	// Payment button defaults to built-in Stripe class "stripe-button-el" unless set to "none".
	$html .= '<button class="sc-payment-btn' . ( $payment_button_style == 'none' ? '' : ' stripe-button-el' ) . '"><span>' . $payment_button_label . '</span></button>';
	
	$html .= '</form>';

	//Stripe minimum amount allowed.
	$stripe_minimum_amount = 50;
	
	$error_count = Shortcode_Tracker::get_error_count();
	
	Shortcode_Tracker::reset_error_count();
	
	if( $error_count > 0 && ! isset( $_GET['charge'] ) ) {
		if( current_user_can( 'manage_options' ) ) {
			return Shortcode_Tracker::print_errors();
		}
		
		return '';
	} 
	
	if( ( empty( $amount ) || $amount < $stripe_minimum_amount ) || ! isset( $amount ) && ! isset( $_GET['charge'] ) ) {

		if( current_user_can( 'manage_options' ) ) {
			$html =  '<h6>';
			$html .= __( 'Stripe checkout requires an amount of ', 'sc' ) . $stripe_minimum_amount;
			$html .= ' (' . sc_stripe_to_formatted_amount( $stripe_minimum_amount, $currency ) . ' ' . $currency . ')';
			$html .= __( ' or larger.', 'sc' );
			$html .= '</h6>';

			return $html;
		}
		
		return '';
	} 
	
	// Reset the static counter now in case there are multiple forms on a page
	sc_total_fields( true );
	
	$referer = wp_get_referer();
	
	if( ( ! isset( $_GET['charge'] ) && ! isset( $_GET['error_code'] ) ) ||
			( ( ! empty( $sc_options['success_redirect_url'] ) || ! empty( $sc_options['failure_redirect_url'] ) ||  
			( $referer !== false && $success_redirect_url != $referer ) || ( $referer !== false && $failure_redirect_url != $referer ) ) && ! isset( $_GET['test_mode'] ) ) ) {
		return $html;
	}
	
	return '';
}
remove_shortcode( 'stripe' );
add_shortcode( 'stripe', 'sc_stripe_shortcode_pro' );


/**
 * Function to process [stripe_total] shortcode
 * 
 * 
 * @since 2.0.0
 */
function sc_stripe_total( $attr ) {
	
	global $sc_options, $sc_script_options;
	
	static $counter = 1;
	
	$attr = shortcode_atts( array(
					'label' => ( ! empty( $sc_options['stripe_total_label'] ) ? $sc_options['stripe_total_label'] : __( 'Total Amount:', 'sc' ) )
				), $attr, 'stripe_total' );
	
	extract( $attr );
	
	Shortcode_Tracker::add_new_shortcode( 'stripe_total_' . $counter, 'stripe_total', $attr, false );

	$currency = strtoupper( $sc_script_options['script']['currency'] );
	$stripe_amount = $sc_script_options['script']['amount'];
	
	$attr['currency'] = $currency;
	$attr['amount']   = $stripe_amount;

	$html = $label . ' ';
	$html .= '<span class="sc-total-amount">';

	// USD only: Show dollar sign on left of amount.
	if ( $currency === 'USD' ) {
		$html .= '$';
	}

	$html .= sc_stripe_to_formatted_amount( $stripe_amount, $currency );

	// Non-USD: Show currency on right of amount.
	if ( $currency !== 'USD' ) {
		$html .= ' ' . $currency;
	}

	$html .= '</span>'; //sc-total-amount
	
	$args = sc_get_args( '', $attr );
	$counter++;
	
	return '<div class="sc-form-group">' . apply_filters( 'sc_stripe_total', $html, $args ) . '</div>';
}
add_shortcode( 'stripe_total', 'sc_stripe_total' );

/**
 * Render code for [stripe_coupon]
 * 
 * @since 2.0.0
 */
function sc_coup_stripe_coupon( $attr ) {

	global $sc_options;
	
	static $counter = 1;
	
	if( Shortcode_Tracker::shortcode_exists_current( 'stripe_coupon' ) ) {
		Shortcode_Tracker::update_error_count();
		
		if( current_user_can( 'manage_options' ) ) {
			Shortcode_Tracker::add_error_message( __( 'Only one coupon code per form is allowed.', 'sc' ) );
		}
		
		return '';
	}
	
	$attr = shortcode_atts( array(
		'label'              => ( ! empty( $sc_options['sc_coup_label'] ) ? $sc_options['sc_coup_label'] : '' ),
		'placeholder'        => '',
		'apply_button_style' => ( ! empty( $sc_options['sc_coup_apply_button_style'] ) && $sc_options['sc_coup_apply_button_style'] == 'stripe' ? 'stripe' : '' )
	), $attr, 'stripe_coupon' );
	
	extract( $attr );
	
	Shortcode_Tracker::add_new_shortcode( 'stripe_coupon_' . $counter, 'stripe_coupon', $attr, false );

    $html = ( ! empty( $label ) ? '<label for="sc-coup-coupon-' . $counter . '">' . $label . '</label>' : '' );
	$html .= '<div class="sc-coup-coupon-container">';
    $html .= '<input type="text" class="sc-form-control sc-coup-coupon" id="sc-coup-coupon-' . $counter . '" name="sc_coup_coupon" placeholder="' . esc_attr( $placeholder ) . '" ';

	// Make Parsley JS validation ignore this field entirely.
	$html .= 'data-parsley-ui-enabled="false">';

	// Store valid coupon code in hidden field.
	$html .= '<input type="hidden" class="sc-coup-coupon-code" name="sc_coup_coupon_code" />';

	// Apply button (using "stripe" style if indicated).
	$html .= '<button class="sc-coup-apply-btn' . ( $apply_button_style == 'stripe' ? ' stripe-button-el' : '' ) . '"><span>' . __( 'Apply', 'sc' ) . '</span></button>';

	$html .= '</div>'; //sc-coup-coupon-container

	// Loading indicator and validation message.
	$html .= '<div class="sc-coup-loading"><img src="' . SC_URL . 'assets/loading.gif" /></div>';
	$html .= '<div class="sc-coup-validation-message"></div>';

	// Success message and removal link.
	$html .= '<div class="sc-coup-success-row">';
	$html .= '<span class="sc-coup-success-message"></span>';
	$html .= ' <span class="sc-coup-remove-coupon">(<a href="#">remove</a>)</span>';
	$html .= '</div>'; //sc-coup-success-row
	
	$args = sc_get_args( '', $attr, $counter );
	
	$counter++;
	sc_total_fields();
	
	return '<div class="sc-form-group">' . apply_filters( 'sc_stripe_coupon', $html, $args ) . '</div>';
}
add_shortcode( 'stripe_coupon', 'sc_coup_stripe_coupon' );

/**
 * Shortcode to output a custom text field [stripe_text]
 * 
 * @since 2.0.0
 */
function sc_cf_text( $attr ) {
	
	static $counter = 1;
		
	$attr = shortcode_atts( array(
					'id'          => '',
					'label'       => '',
					'placeholder' => '',
					'required'    => 'false',
					'default'     => '',
					'multiline'   => 'false',
					'rows'        => '5',
					'is_quantity' => 'false'
				), $attr, 'stripe_text' );
	
	extract( $attr );
	
	Shortcode_Tracker::add_new_shortcode( 'stripe_text_' . $counter, 'stripe_text', $attr, false );
	
	// Check for ID and if it doesn't exist then we will make our own
	if( $id == '' ) {
		$id = 'sc_cf_text_' . $counter;
	}
	
	$quantity_html  = ( ( 'true' == $is_quantity ) ? ' data-sc-quanitity="true" data-parsley-type="integer" data-parsley-min="1" ' : '' );
	$quantity_class = ( ( 'true' == $is_quantity ) ? ' sc-cf-quantity' : '' );

    $html = ( ! empty( $label ) ? '<label for="' . esc_attr( $id ) . '">' . $label . '</label>' : '' );
	
	if( $multiline === 'true' ) {
		$html .= '<textarea rows="' . esc_attr( $rows ) . '" class="sc-form-control sc-cf-textarea" id="' . esc_attr( $id ) . '" ' .
		         'name="sc_form_field[' . $id . ']" placeholder="' . esc_attr( $placeholder ) . '" ' . ( $required === 'true' ? 'required' : '' ) . '>' .
		         esc_textarea( $default ) . '</textarea>';
	} else {
		$html .= '<input type="text" value="' . esc_attr( $default ) . '" class="sc-form-control sc-cf-text' . $quantity_class . '" id="' . esc_attr( $id ) . '" ' .
		         'name="sc_form_field[' . $id . ']" placeholder="' . esc_attr( $placeholder ) . '" ' . ( $required === 'true' ? 'required' : '' ) . $quantity_html . '>';
	}
	
	$args = sc_get_args( $id, $attr, $counter );
	
	// Increment static counter
	$counter++;
	sc_total_fields();
	
	return '<div class="sc-form-group">' . apply_filters( 'sc_stripe_text', $html, $args ) . '</div>';
}
add_shortcode( 'stripe_text', 'sc_cf_text' );

/**
 * Shortcode to output a date field - [stripe_date]
 * 
 * @since 2.0.0
 */
function sc_cf_date( $attr ) {
	
	static $counter = 1;
	
	$attr = shortcode_atts( array(
					'id'          => '',
					'label'       => '',
					'placeholder' => '',
					'required'    => 'false',
					'default'     => ''
				), $attr, 'stripe_date' );
	
	extract( $attr );
	
	Shortcode_Tracker::add_new_shortcode( 'stripe_date_' . $counter, 'stripe_date', $attr, false );
	
	// Check for ID and if it doesn't exist then we will make our own
	if( $id == '' ) {
		$id = 'sc_cf_date_' . $counter;
	}

    $html = ( ! empty( $label ) ? '<label for="' . esc_attr( $id ) . '">' . $label . '</label>' : '' );

	// Include inline Parsley JS validation data attributes.
	// Parsley doesn't have date validation built-in, so add as custom validator using Moment JS.
	$html .= '<input type="text" value="' . esc_attr( $default ) . '" class="sc-form-control sc-cf-date" name="sc_form_field[' . $id . ']" ';
	$html .= 'id="' . esc_attr( $id ) . '" placeholder="' . esc_attr( $placeholder ) . '" ';
	$html .= ( ( $required === 'true') ? 'required' : '' ) . ' data-parsley-required-message="Please select a date.">';
	
	$args = sc_get_args( $id, $attr, $counter );

	// Increment static counter
	$counter++;
	sc_total_fields();
	
	return '<div class="sc-form-group">' . apply_filters( 'sc_stripe_date', $html, $args ) . '</div>';
}
add_shortcode( 'stripe_date', 'sc_cf_date' );


/**
 * Shortcode to output a checkbox - [stripe_checkbox]
 * 
 * @since 2.0.0
 */

function sc_cf_checkbox( $attr ) {
	
	static $counter = 1;
	
	$attr = shortcode_atts( array(
					'id'       => '',
					'label'    => '',
					'required' => 'false',
					'default'  => 'false'
				), $attr, 'stripe_date' );
	
	extract( $attr );
	
	Shortcode_Tracker::add_new_shortcode( 'stripe_checkbox_' . $counter, 'stripe_checkbox', $attr, false );
	
	// Check for ID and if it doesn't exist then we will make our own
	if( $id == '' ) {
		$id = 'sc_cf_checkbox_' . $counter;
	}
	
	$checked  = ( ( $default === 'true' || $default === 'checked' ) ? 'checked' : '' );

	// Put <input type="checkbox"> inside of <lable> like Bootstrap 3.
	$html = '<label>';

	$html .= '<input type="checkbox" id="' . esc_attr( $id ) . '" class="sc-cf-checkbox" name="sc_form_field[' . esc_attr( $id ) . ']" ';
	$html .= ( ( $required === 'true' ) ? 'required' : '' ) . ' ' . $checked . ' value="Yes" ';

	// Point to custom container for errors as checkbox fields aren't automatically placing it in the right place.
	$html .= 'data-parsley-errors-container="#sc_cf_checkbox_error_' . $counter . '">';

	// Actual label text.
	$html .= $label;

	$html .= '</label>';

	// Hidden field to hold a value to pass to Stripe payment record.
	$html .= '<input type="hidden" id="' . esc_attr( $id ) . '_hidden" class="sc-cf-checkbox-hidden" name="sc_form_field[' 
			. esc_attr( $id ) . ']" value="' . ( 'true' === $default || 'checked' === $default ? 'Yes' : 'No' ) . '">';

	// Custom validation errors container for checkbox fields.
	// Needs counter ID specificity to match input above.
	$html .= '<div id="sc_cf_checkbox_error_' . $counter . '"></div>';
	
	$args = sc_get_args( $id, $attr, $counter );

	// Incrememnt static counter
	$counter++;
	sc_total_fields();
	
	return '<div class="sc-form-group">' . apply_filters( 'sc_stripe_checkbox', $html, $args ) . '</div>';
}
add_shortcode( 'stripe_checkbox', 'sc_cf_checkbox' );


/**
 * Shortcode to output a number box - [stripe_number]
 * 
 * @since 2.0.0
 */
function sc_cf_number( $attr ) {
	
	static $counter = 1;
	
	$attr = shortcode_atts( array(
					'id'          => '',
					'label'       => '',
					'required'    => 'false',
					'placeholder' => '',
					'default'     => '',
					'min'         => '',
					'max'         => '',
					'step'        => '',
					'is_quantity' => 'false'
				), $attr, 'stripe_date' );
	
	extract( $attr );
	
	Shortcode_Tracker::add_new_shortcode( 'stripe_number_' . $counter, 'stripe_number', $attr, false );
	
	// Check for ID and if it doesn't exist then we will make our own
	if( $id == '' ) {
		$id = 'sc_cf_number_' . $counter;
	}
	
	$quantity_html  = ( ( 'true' == $is_quantity ) ? 'data-sc-quanitity="true" data-parsley-min="1" ' : '' );
	$quantity_class = ( ( 'true' == $is_quantity ) ? ' sc-cf-quantity' : '' );
	
	$min = ( ! empty( $min ) ? 'min="' . $min . '" ' : '' );
	$max = ( ! empty( $max ) ? 'max="' . $max . '" ' : '' );
	$step = ( ! empty( $step ) ? 'step="' . $step . '" ' : '' );

    $html = ( ! empty( $label ) ? '<label for="' . esc_attr( $id ) . '">' . $label . '</label>' : '' );

	// No Parsley JS number validation yet as HTML5 number type takes care of it.
    $html .= '<input type="number" data-parsley-type="number" class="sc-form-control sc-cf-number' . $quantity_class . '" id="' . esc_attr( $id ) . '" name="sc_form_field[' . $id . ']" ';
	$html .= 'placeholder="' . esc_attr( $placeholder ) . '" value="' . esc_attr( $default ) . '" ';
	$html .= $min . $max . $step . ( ( $required === 'true' ) ? 'required' : '' ) . $quantity_html . '>';
	
	$args = sc_get_args( $id, $attr, $counter );
	
	// Incrememnt static counter
	$counter++;
	sc_total_fields();
	
	return '<div class="sc-form-group">' . apply_filters( 'sc_stripe_number', $html, $args ) . '</div>';
}
add_shortcode( 'stripe_number', 'sc_cf_number' );

/**
 * Function to add the custom user amount textbox via shortcode - [stripe_amount]
 * 
 * @since 2.0.0
 */
function sc_uea_amount( $attr ) {

	global $sc_script_options, $sc_options;
	
	static $counter = 1;
	
	$attr = shortcode_atts( array(
					'label'       => ( ! empty( $sc_options['sc_uea_label'] ) ? $sc_options['sc_uea_label'] : '' ),
					'placeholder' => '',
					'default'     => ''
				), $attr, 'stripe_amount' );
	
	extract( $attr );
	
   Shortcode_Tracker::add_new_shortcode( 'stripe_amount_' . $counter, 'stripe_amount', $attr, false );

	$currency = strtoupper( $sc_script_options['script']['currency'] );
	
	$attr['currency'] = $currency;

	$html  = '';

	$html .= ( !empty( $label ) ? '<label for="sc_uea_custom_amount_' . $counter . '">' . $label . '</label>' : '' );
	$html .= '<div class="sc-uea-container">';
	
	$currency_args['before'] = ( $currency === 'USD' ? '$' : '' );
	$currency_args['after']  = ( $currency === 'USD' ? '' : $currency );
	$currency_args           = apply_filters( 'sc_uea_currency', $currency_args );
	
	$currency_before = $currency_args['before'];
	$currency_after  = $currency_args['after'];
	
	if ( ! empty( $currency_before ) ) {
		$html .= '<span class="sc-uea-currency sc-uea-currency-before">' . $currency_before . '</span> ';
	}
	
	//Stripe minimum amount allowed.
	$stripe_minimum_amount = 50;

	//Get amount to validate based on currency.
	$converted_minimum_amount = sc_stripe_to_decimal_amount( $stripe_minimum_amount, $currency );

	// USD only: Show "50 cents" instead of "50" + currency code.
	// Non-USD: Format and show currency code on right.
	if ( $currency === 'USD' ) {
		$minimum_amount_validation_msg = sprintf( __( 'Please enter an amount equal to or more than %s cents.', 'sc' ), $stripe_minimum_amount );
	} else {
		// Format number with decimals depending on zero-decimal status.
		$minimum_amount_validation_msg = sprintf( __( 'Please enter an amount equal to or more than %s %s.', 'sc' ), $converted_minimum_amount, $currency );
	}
	
	$minimum_amount_validation_msg = apply_filters( 'sc_stripe_amount_validation_msg', $minimum_amount_validation_msg, $stripe_minimum_amount, $currency );
	
	$attr['min_validation_msg'] = $minimum_amount_validation_msg;

	// Include inline Parsley JS validation data attributes.
	// http://parsleyjs.org/doc/index.html#psly-validators-list
    $html .= '<input type="text" class="sc-form-control sc-uea-custom-amount" name="sc_uea_custom_amount" ';
	$html .= 'id="sc_uea_custom_amount_' . $counter . '" value="' . esc_attr( $default ) . '" placeholder="' . esc_attr( $placeholder ) . '" ';
	$html .= 'required data-parsley-required-message="Please enter an amount." ';
	$html .= 'data-parsley-type="number" data-parsley-type-message="Please enter a valid amount. Do not include a currency symbol." ';
	$html .= 'data-parsley-min="' . $converted_minimum_amount . '" data-parsley-min-message="' . $minimum_amount_validation_msg . '" ';

	// Point to custom container for errors so we can place the non-USD currencies on the right of the input box.
	$html .= 'data-parsley-errors-container="#sc_uea_custom_amount_errors_' . $counter . '">';
	
	if ( ! empty( $currency_after ) ) {
		$html .= ' <span class="sc-uea-currency sc-uea-currency-after">' . $currency_after . '</span>';
	}

	// Custom validation errors container for UEA.
	// Needs counter ID specificity to match input above.
	$html .= '<div id="sc_uea_custom_amount_errors_' . $counter . '"></div>';

	$html .= '</div>'; //sc-uea-container
	
	$args = sc_get_args( '', $attr, $counter );
	
	$counter++;
	
	if( ! isset( $_GET['charge'] ) ) {
		return '<div class="sc-form-group">' . apply_filters( 'sc_stripe_amount', $html, $args ) . '</div>';
	}
	
	return '';
}
add_shortcode( 'stripe_amount', 'sc_uea_amount' );


/**
 * Shortcode to output a dropdown list - [stripe_dropdown]
 * 
 * @since 2.0.0
 */
function sc_cf_dropdown( $attr ) {

	static $counter = 1;
	
	global $sc_script_options;
	
	$attr = shortcode_atts( array(
					'id'          => '',
					'label'       => '',
					'default'     => '',
					'options'     => '',
					'is_quantity' => 'false',
					'amounts'     => '',
					'is_amount'   => 'false' // For backwards compatibility
				), $attr, 'stripe_dropdown' );
	
	extract( $attr );
	
	Shortcode_Tracker::add_new_shortcode( 'stripe_dropdown_' . $counter, 'stripe_dropdown', $attr, false );
	
	// Check for ID and if it doesn't exist then we will make our own
	if( $id == '' ) {
		$id = 'sc_cf_select_' . $counter;
	}
	
	$quantity_html  = ( ( 'true' == $is_quantity ) ? 'data-sc-quanitity="true" ' : '' );
	$quantity_class = ( ( 'true' == $is_quantity ) ? ' sc-cf-quantity' : '' );
	
	$amount_class = ( ! empty( $amounts ) || $is_amount == 'true' ? ' sc-cf-amount' : '' );
	
	$options = explode( ',', $options );
	
	if( ! empty( $amounts ) ) {
		$amounts = explode( ',', str_replace( ' ', '', $amounts ) );
			
		if( count( $options ) != count( $amounts ) ) {
			Shortcode_Tracker::update_error_count();
			
			if( current_user_can( 'manage_options' ) ) {
				Shortcode_Tracker::add_error_message( '<h6>' . __( 'Your number of options and amounts are not equal.', 'sc' ) . '</h6>' );
			}
			
			return'';
		}
	}
	
	if( $is_amount == 'true' ) {
		if( current_user_can( 'manage_options' ) ) {
			echo '<h6>' . sprintf( __( 'The "is_amount" attribute is deprecated and will be removed in an upcoming release. Please use the new "amounts" attribute instead. %s', 'sc' ), 
					'<a href="http://wpstripe.net/docs/shortcodes/stripe-custom-fields/" target="_blank">' . __( 'See Documentation', 'sc' ) . '</a>' ) . '</h6>';
		}
	}

    $html = ( ! empty( $label ) ? '<label for="' . esc_attr( $id ) . '">' . $label . '</label>' : '' );
	$html .= '<select class="sc-form-control sc-cf-dropdown' . $quantity_class . $amount_class . '" id="' . esc_attr( $id ) . '" name="sc_form_field[' . esc_attr( $id ) . ']" ' . $quantity_html . '>';
	
	$i = 1;
	foreach( $options as $option ) {
		
		$option = trim( $option );
		$value = $option;
		
		if( $is_amount == 'true' ) {
			
			$currency = strtoupper( $sc_script_options['script']['currency'] );
			$amount = sc_stripe_to_formatted_amount( $option, $currency );
			
			if( $currency == 'USD' ) {
				$option_name = '$' . $amount;
			} else {
				$option_name = $amount . ' ' . $currency;
			}
			
		} else if( ! empty( $amounts ) ) {
			$value = $amounts[$i - 1];
		}
		
		if( empty( $default ) ) {
			$default = $option;
		}
		
		if( $default == $option  && $is_quantity != 'true' && ! empty( $amounts ) ) {
			$sc_script_options['script']['amount'] = $value;
		}
		
		$html .= '<option value="' . ( isset( $option_name ) ? $option_name : $option ) . '" ' . ( $default == $option ? 'selected' : '' ) . ' data-sc-price="' . esc_attr( $value ) . '">' . ( isset( $option_name ) ? $option_name : $option ) . '</option>';
		$i++;
	}
	
	$html .= '</select>';
	
	$args = sc_get_args( $id, $attr, $counter );
	
	// Incrememnt static counter
	$counter++;
	sc_total_fields();
	
	return '<div class="sc-form-group">' . apply_filters( 'sc_stripe_dropdown', $html, $args ) . '</div>';
}
add_shortcode( 'stripe_dropdown', 'sc_cf_dropdown' );

/**
 * Shortcode to output a number box - [stripe_radio]
 * 
 * @since 2.0.0
 */
function sc_cf_radio( $attr ) {

	static $counter = 1;
	
	global $sc_script_options;
	
	$attr = shortcode_atts( array(
					'id'          => '',
					'label'       => '',
					'default'     => '',
					'options'     => '',
					'is_quantity' => 'false',
					'amounts'     => '',
					'is_amount'   => 'false'  // For backwards compatibility
				), $attr, 'stripe_radio' );
	
	extract( $attr );
	
	Shortcode_Tracker::add_new_shortcode( 'stripe_radio_' . $counter, 'stripe_radio', $attr, false );
	
	// Check for ID and if it doesn't exist then we will make our own
	if( $id == '' ) {
		$id = 'sc_cf_radio_' . $counter;
	}
	
	$options = explode( ',', $options );
	
	if( ! empty( $amounts ) ) {
		$amounts = explode( ',', str_replace( ' ', '', $amounts ) );
		
		if( count( $options ) != count( $amounts ) ) {
			Shortcode_Tracker::update_error_count();
			
			if( current_user_can( 'manage_options' ) ) {
				Shortcode_Tracker::add_error_message( '<h6>' . __( 'Your number of options and amounts are not equal.', 'sc' ) . '</h6>' );
			}
			
			return '';
		}
	}
	
	if( $is_amount == 'true' ) {
		if( current_user_can( 'manage_options' ) ) {
			echo '<h6>' . sprintf( __( 'The "is_amount" attribute is deprecated and will be removed in an upcoming release. Please use the new "amounts" attribute instead. %s', 'sc' ), 
					'<a href="http://wpstripe.net/docs/shortcodes/stripe-custom-fields/" target="_blank">' . __( 'See Documentation', 'sc' ) . '</a>' ) . '</h6>';
		}
	}
	
	$quantity_html  = ( ( 'true' == $is_quantity ) ? 'data-sc-quanitity="true" ' : '' );
	$quantity_class = ( ( 'true' == $is_quantity ) ? ' sc-cf-quantity' : '' );
	
	$amount_class = ( ! empty( $amounts ) || $is_amount == 'true' ? ' sc-cf-amount' : '' );

    $html = ( ! empty( $label ) ? '<label>' . $label . '</label>' : '' );

	$html .= '<div class="sc-radio-group">';
	
	$i = 1;
	foreach( $options as $option ) {
		
		$option = trim( $option );
		$value = $option;
		
		if( empty( $default ) ) {
			$default = $option;
		}
		
		if( $is_amount == 'true' ) {
			
			$currency = strtoupper( $sc_script_options['script']['currency'] );
			$amount = sc_stripe_to_formatted_amount( $option, $currency );
			
			if( $currency == 'USD' ) {
				$option_name = '$' . $amount;
			} else {
				$option_name = $amount . ' ' . $currency;
			}
		} else if( ! empty( $amounts ) ) {
			$value = $amounts[$i - 1];
		}
		
		if( $default == $option  && $is_quantity != 'true' && ! empty( $amounts ) ) {
			$sc_script_options['script']['amount'] = $value;
		}

		// Don't use built-in checked() function here for now since we need "checked" in double quotes.
		$html .= '<label title="' . esc_attr( $option ) . '">';
		$html .= '<input type="radio" name="sc_form_field[' . esc_attr( $id ) . ']" value="' . ( isset( $option_name ) ? $option_name : $option ) . '" ' .
				'data-sc-price="' . esc_attr( $value ) . '" ' . ( $default == $option ? 'checked="checked"' : '' ) . 
				' class="' . esc_attr( $id ) . '_' . $i . $quantity_class . $amount_class . '" data-parsley-errors-container=".sc-form-group" ' . $quantity_html . '>';
		$html .= '<span>' . ( isset( $option_name ) ? $option_name : $option ) . '</span>';
		$html .= '</label>';
		
		$i++;
	}
	
	$html .= '</div>'; //sc-radio-group
	
	$attr['currency'] = strtoupper( $sc_script_options['script']['currency'] );
	
	$args = sc_get_args( $id, $attr, $counter );
	
	// Incrememnt static counter
	$counter++;
	sc_total_fields();
	
	return '<div class="sc-form-group">' . apply_filters( 'sc_stripe_radio', $html, $args ) . '</div>';
}
add_shortcode( 'stripe_radio', 'sc_cf_radio' );

/*
 * Calculates number of total fields added and returns a message if it is greater than the limit
 * 
 * @since 2.0.8
 */
function sc_total_fields( $reset = false ) {

	static $counter = 0;
	
	if( $reset == true ) {
		$counter = 0;
		return;
	}
	
	$counter++;
	
	if( $counter > 20 ) {
		$counter = 0;
		
		Shortcode_Tracker::update_error_count();
		
		if( current_user_can( 'manage_options' ) ) {
			echo '<p>' . __( 'You have entered more fields than are currently allowed by Stripe. Please limit your fields to 20 or less.', 'sc' ) . '</p>';
		}
	}
}

/**
 * Function to set the id of the args array and return the modified array
 */
function sc_get_args( $id = '', $args = array(), $counter = '' ) {
	
	if( ! empty( $id ) ) {
		$args['id'] = $id;
	}
	
	if( ! empty( $counter ) ) {
		$args['unique_id'] = $counter;
	}
	
	return $args;
}
