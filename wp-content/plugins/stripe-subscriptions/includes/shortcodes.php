<?php

/*
 * [stripe_subscription] shortcode
 * 
 * @since 1.0.0
 */
function sc_sub_main_shortcode( $attr, $content = null ) {
	
	// Our unique identifier in case multiple forms exist
	STATIC $uid = 1;
	
	extract( shortcode_atts( array(
					'label'                 => '',
					'type'                  => 'radio',
					'default'               => '',
					'show_details'          => 'true',
					'id'                    => '',
					'interval'              => 'month',
					'interval_count'        => 1,
					'statement_description' => '',
					'use_amount'            => 'false'
				), $attr, 'stripe_subscription' ) );
	
	// Limit to 22
	if( ! empty( $statement_description ) ) {
		$attr['statement_description'] = substr( $attr['statement_description'], 0, 22 );
	}
	
	Shortcode_Tracker::add_new_shortcode( 'stripe_subscription_' . $uid, 'stripe_subscription', $attr, false );

	// Output public JS file whether there's an error or not.
	//wp_enqueue_script( SC_SUB_PLUGIN_SLUG . '-public' );

	$sub_amount = 0;
	$sub_interval = 0;
	$sub_interval_count = 0;

	$error_count = 0;
	$error_html  = '';
	$html        = ( ! empty( $label ) ? '<p class="sc-radio-group-label">' . $label . '</p>' : '' );
	
	
	// If the type is set to single then we just want to make sure the button points to the right plan
	// and that the button will be assigned the correct price for the subscripti
	// We use sanitize_text_field here to account for empty values that may exist
	$content_check = sanitize_text_field( $content );
		
	if( $type != 'radio' ) {
		Shortcode_Tracker::update_error_count();
		
		if( current_user_can( 'manage_options' ) ) {
			Shortcode_Tracker::add_error_message( '<h6>' . __( 'You have entered an invalid type.', 'sc_sub' ) . '</h6>' );
		}
		return;
	}
	
	if( empty( $content_check ) ) {
		
		if( empty( $id ) ) {
			return;
		}
		
		$base_attr = Shortcode_Tracker::get_base_attributes();
		
		if ( isset( $base_attr['test_mode'] ) && $base_attr['test_mode'] == 'true' ) {
			$test_mode = 'true';
		} else { 
			$test_mode = 'false';
		}
		
		$sub = sc_sub_get_subscription_by_id( $id, $test_mode );
		
		if( ! is_object( $sub ) ) {
			
			if( current_user_can( 'manage_options' ) ) {
				//$error_html .= _x( 'Invalid subscription ID entered - ', 'Shown when the admin has entered an invalid subscription ID', 'sc_sub' ) . $id . '<br>';
				$error_html .= $sub;
				$error_count++;
			}
		} else {
			$default    = $sub->id;
			$sub_amount = $sub->amount;
			$sub_interval = $sub->interval;
			$sub_interval_count = $sub->interval_count;
			$sub_currency = $sub->currency;
		}
		
		$uid++;
	} else {
		
		$content = trim( do_shortcode( $content ) );
		$content = substr( $content, 0, -1 );
		
		$ids = explode( ';', $content );
		
		STATIC $id_num = 1;
			
		$html .= '<div class="sc-radio-group">';
		foreach( $ids as $id ) {
			$data = explode( '|', $id );
					
			$data[0] = trim( $data[0] );
			
			// Get the Subscription
			if( empty( $data[0] ) ) {
				Shortcode_Tracker::update_error_count();
				
				if( current_user_can( 'manage_options' ) ) {
					$error_html .= _x( 'You have not entered any subscription plan IDs', 'Shown when the admin has not entered any subscription IDs', 'sc_sub' ) . $data[0] . '<br>';	
				}

				$error_count++;
				continue;
			}
			
			$sub = sc_sub_get_subscription_by_id( $data[0] );
			
			if( ! is_object( $sub ) ) {
				if( current_user_can( 'manage_options' ) ) {
					$error_html .= _x( 'An invalid shortcode or plan ID has been found. Please make sure you have the correct plan ID and there are not extra shortcodes.', 'Shown when the admin has entered an invalid subscription ID', 'sc_sub' ) . '<br>';
				}
				
				$error_count++;
				continue;
			}

			if( empty( $default ) ) {
				$default = $sub->id;
				$sub_interval = $sub->interval;
				$sub_interval_count = $sub->interval_count;
			}

			if( $default == $sub->id ) {
				$sub_amount = $sub->amount;
			}
			
			$currency = $sub->currency;

			$formatted_amount = sc_stripe_to_formatted_amount( $sub->amount, $sub->currency );
			
			$details_html = ' - ';
			$details_html .= ( $currency == 'usd' ? '$' : '' ) . $formatted_amount . ( $currency == 'usd' ? '' : ' ' . strtoupper( $currency ) );

			// For interval count of 1, use $1.00/month format.
			// For a count > 1, use $1.00 every 3 months format.
			if ($sub->interval_count == 1) {
				$details_html .= '/' . $sub->interval;
			} else {
				$details_html .= ' ' . __( 'every', 'sc_sub' ) . ' ' . $sub->interval_count . ' ' . $sub->interval . 's';
			}
						
			$details_html = ( ( ! empty( $data[1] ) ) ? $data[1] : $sub->name )  . ( $show_details == 'true' ? ' ' . $details_html : '' );

			$details_html = apply_filters( 'sc_subscription_details', $details_html, $sub );

			if( $type == 'radio' ) {
				$html .= '<label title="' . esc_attr( $sub->name ) . '">';
				$html .= '<input type="radio" value="' . esc_attr( $sub->name ) . '" name="sc_radio_' . $uid . '" id="sc_radio_' . $id_num . '" data-sub-amount="' . $sub->amount . '" ' .
				         'data-sub-id="' . $sub->id . '" ' . ( ! empty( $default ) && $sub->id == $default ? 'checked' : '' ) . ' data-parsley-errors-container=".sc-radio-group" ' . 
						 ' data-sub-interval="' . $sub->interval . '" data-sub-interval-count="' . $sub->interval_count . '" data-sub-currency="' . $currency . '">';
				$html .= '<span>' . $details_html . '</span>';
				$html .= '</label>';
			}
			
			if( ! empty( $default ) && $sub->id == $default ) {
				$sub_interval = $sub->interval;
			}

			$id_num++;
		}
		$html .= '</div>';
	}
	
	if( $error_count < 1 ) {
		$html .= '<input type="hidden" name="sc_sub_id" class="sc_sub_id" value="' . $default . '" />';
		$html .= '<input type="hidden" name="sc_sub_amount" class="sc_sub_amount" value="' . $sub_amount . '" />';
		$html .= '<input type="hidden" name="sc_sub_interval" class="sc_sub_interval" value="' . $sub_interval . '" />';
		$html .= '<input type="hidden" name="sc_sub_interval_count" class="sc_sub_interval_count" value="' . $sub_interval_count . '" />';
		
		if( isset( $sub_currency ) ) {
			$html .= '<input type="hidden" name="sc_sub_currency" class="sc_sub_currency" value="' . $sub_currency . '" />';
		}
		
		return '<div class="sc_sub_wrapper sc-form-group" id="sc_sub_wrapper_' . $uid . '">' . $html . '</div>';
	} else {
		Shortcode_Tracker::update_error_count();
		
		if( current_user_can( 'manage_options' ) ) {
			Shortcode_Tracker::add_error_message( '<h6>' . $error_html . '</h6>' );
		}
		
		return '<h6>' . __( 'An error has occurred. If the problem persists, please contact the site administrator.', 'sc_sub' ) . '</h6>';
	}
}
add_shortcode( 'stripe_subscription', 'sc_sub_main_shortcode' );

/**
 * [stripe_plan] shortcode
 * 
 * This doesn't actually output anything to the screen so it should not be used by itself.
 * It takes the data and transforms it to be used with the main shortcode.
 * 
 * @since 1.0.0
 */
function sc_sub_plan_items( $attr ) {
	
	STATIC $uid = 1;
	
	//echo '<pre>' . print_r( $attr ) . '</pre>';
	
	extract( shortcode_atts( array(
					'id'    => null,
					'label' => ( ! isset( $attr['label'] ) ? '' : $attr['label'] )
				), $attr, 'stripe_subscriptions' ) );
	
	Shortcode_Tracker::add_new_shortcode( 'stripe_plan_' . $uid, 'stripe_plan', $attr, true );
	
	//echo 'LABEL: ' . $label . '<br>';
	
	$uid++;
	
	return $id . '|' . $label . ';';
}
add_shortcode( 'stripe_plan', 'sc_sub_plan_items' );
