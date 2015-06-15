<?php

/**
 * Register all settings needed for the Settings API.
 *
 * @package    SC
 * @subpackage Includes
 * @author     Phil Derksen <pderksen@gmail.com>, Nick Young <mycorpweb@gmail.com>
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Add our add-on settings to the 'Default Settings' tab
 * 
 * @since 2.0.0
 */
function sc_pro_add_settings( $settings ) {
	
	$settings['default']['shipping'] = array(
		'id'   => 'shipping',
		'name' => __( 'Enable Shipping Address', 'sc' ),
		'desc' => __( 'Require the user to enter their shipping address during checkout.', 'sc' ) . '<br/>' .
		          '<p class="description">' . __( 'When a shipping address is required, the customer is also required to enter a billing address.', 'sc' ) . '</p>',
		'type' => 'checkbox'
	);

	$settings['default']['payment_button_style'] = array(
		'id'      => 'payment_button_style',
		'name'    => __( 'Payment Button Style', 'sc' ),
		'desc'    => __( 'Enable Stripe styles for the main payment button. Base button CSS class: <code>sc-payment-btn</code>.', 'sc' ),
		'type'    => 'radio',
		'std'     => 'stripe',
		'options' => array(
			'none'   => __( 'None', 'sc' ),
			'stripe' => __( 'Stripe', 'sc' )
		)
	);

	$settings['default']['sc_coup_label'] = array(
			'id'   => 'sc_coup_label',
			'name' => __( 'Coupon Input Label', 'sc' ),
			'desc' => __( 'Label to show before the coupon code input.', 'sc' ),
			'type' => 'text',
			'size' => 'regular-text'
		);
	
	$settings['default']['sc_coup_apply_button_style'] = array(
			'id'      => 'sc_coup_apply_button_style',
			'name'    => __( 'Apply Button Style', 'sc' ),
			'desc'    => __( 'Optionally enable Stripe styles for the coupon "Apply" button. Base button CSS class: <code>sc-coup-apply-btn</code>.', 'sc' ),
			'type'    => 'radio',
			'std'     => 'none',
			'options' => array(
				'none'   => __( 'None', 'sc' ),
				'stripe' => __( 'Stripe', 'sc' )
			)
		);
	
	$settings['default']['stripe_total_label'] = array(
			'id'   => 'stripe_total_label',
			'name' => __( 'Stripe Total Label', 'sc' ),
			'desc' => __( 'The default label for the stripe_total shortcode.' , 'sc' ),
			'type' => 'text',
			'size' => 'regular-text'
		);
	
	$settings['default']['sc_uea_label'] = array(
				'id'   => 'sc_uea_label',
				'name' => __( 'Amount Input Label', 'sc' ),
				'desc' => __( 'Label to show before the amount input.', 'sc' ),
				'type' => 'text',
				'size' => 'regular-text'
	);

	return $settings;
}
add_filter( 'sc_settings', 'sc_pro_add_settings' );

/*
 * License Keys callback function
 *
 * @since 2.?
 */
function sc_license_callback( $args ) {
	global $sc_options;

	if ( isset( $sc_options[ $args['id'] ] ) ) {
		$value = $sc_options[ $args['id'] ];
	} else {
		$value = isset( $args['std'] ) ? $args['std'] : '';
	}

	$item = '';

	$html  = '<div class="sc-license-wrap">' . "\n";

	$size  = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular-text';
	$html .= '<input type="text" class="sc-license-input ' . $size . '" id="sc_settings_' . $args['section'] . '[' . $args['id'] . ']" ' .
	         'name="sc_settings_' . $args['section'] . '[' . $args['id'] . ']" value="' . trim( esc_attr( $value ) ) . '"/>' . "\n";

	$licenses = get_option( 'sc_licenses' );

	$license_action = '';
	$button_text = '';

	// Add button on side of input
	if ( ! empty( $licenses[ $args['product'] ] ) && $licenses[ $args['product'] ] == 'valid' && ! empty( $value ) ) {
		$license_action = 'deactivate_license';
		$button_text = __( 'Deactivate', 'sc' );
	} else {
		$license_action = 'activate_license';
		$button_text = __( 'Activate', 'sc' );
	}

	$html .= '<button class="sc-license-action button" data-sc-action="' . $license_action . '" ' .
	         'data-sc-item="' . ( ! empty( $args['product'] ) ? $args['product'] : 'none' ) . '">' . $button_text . '</button>';

	$valid = sc_check_license( $value, $args['product'] );

	$license_class = '';
	$valid_message = '';

	if ( $valid == 'valid' ) {
		$license_class = 'sc-valid';
		$valid_message = __( 'License is valid and active.', 'sc' );
	} else if( $valid == 'notfound' ) {
		$license_class = 'sc-invalid';
		$valid_message = __( 'License service could not be found. Please contact support for additional help.', 'sc' );
	} else {
		$license_class = 'sc-inactive';
		$valid_message = __( 'License is inactive.', 'sc' );
	}

	$html .= '<span class="sc-spinner spinner"></span>';
	$html .= '<span class="sc-license-message ' . $license_class . '">' . $valid_message . '</span>';

	// Render and style description text underneath if it exists.
	if ( ! empty( $args['desc'] ) ) {
		$html .= '<p class="description">' . $args['desc'] . '</p>' . "\n";
	}

	$html .= '</div>';

	echo $html;
}
