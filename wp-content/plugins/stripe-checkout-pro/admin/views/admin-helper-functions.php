<?php

/**
 * Admin helper functions to get the base plugin tab and help tab set
 * 
 * @since 2.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* 
 * Get Admin Tabs and label
 * 
 * @since 2.0.0
 * 
 * array( $key => $value )
 * $key is the value that is used when making the setting option
 * $value is the display title of the tab
 * 
 * @return array
 */
function sc_get_admin_tabs() {
	
	$tabs = array();
	
	$tabs = array( 
		'keys'    => __( 'Stripe Keys' , 'sc' ),
		'default' => __( 'Default Settings', 'sc' )
	);
	
	return apply_filters( 'sc_admin_tabs', $tabs );
	
}

/**
 * Add Licenses admin tab
 * 
 * @since 2.0.0
 */
function sc_license_tab( $tabs ) {
	$tabs['licenses'] = __( 'Licenses', 'sc' );

	return $tabs;
}
add_filter( 'sc_admin_tabs', 'sc_license_tab' );
