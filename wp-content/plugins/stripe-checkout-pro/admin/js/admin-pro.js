/**
 * Stripe Checkout Admin JS
 *
 * @package SC Pro
 * @author  Phil Derksen <pderksen@gmail.com>, Nick Young <mycorpweb@gmail.com>
 */

/* global jQuery, sc_script */

(function($) {
	'use strict';

	// Set debug flag.
	var script_debug = ( (typeof sc_script != 'undefined') && sc_script.script_debug == true);

	$(function () {

		if (script_debug) {
			console.log('sc_script', sc_script);
		}

		var $body = $( 'body' );

		$body.find( '.sc-license-wrap button.sc-license-action' ).on( 'click.eddLicenseActivate', function( event ) {

			event.preventDefault();
			
			var button = $(this);
			var licenseWrap = button.closest( '.sc-license-wrap' );
			var licenseInput = licenseWrap.find( 'input.sc-license-input' );
			
			if ( licenseInput.val().length < 1 ) {

				button.html( sc_strings.activate );
				button.data( 'sc-action', 'activate_license' );
				licenseWrap.find( '.sc-license-message' ).html( sc_strings.inactive_msg ).removeClass( 'sc-valid sc-invalid' ).addClass( 'sc-inactive' );

			} else {

				// WP 4.2+ wants .is-active class added/removed for spinner.
				licenseWrap.find( '.spinner' ).addClass( 'is-active' );

				var data = {
					action: 'sc_activate_license',
					license: licenseInput.val(),
					item: button.data( 'sc-item'),
					sc_action: button.data( 'sc-action' ),
					id: licenseInput.attr( 'id' )
				};

				$.post( ajaxurl, data, function(response) {

					if (script_debug) {
						console.log('EDD license check response', response);
					}

					// WP 4.2+ wants .is-active class added/removed for spinner.
					licenseWrap.find( '.spinner' ).removeClass( 'is-active' );

					if ( response == 'valid' ) {

						button.html( sc_strings.deactivate );
						button.data( 'sc-action', 'deactivate_license' );
						licenseWrap.find( '.sc-license-message' ).html( sc_strings.valid_msg ).removeClass( 'sc-inactive sc-invalid' ).addClass( 'sc-valid' );

					} else if ( response == 'deactivated' ) {

						button.html( sc_strings.activate );
						button.data( 'sc-action', 'activate_license' );
						licenseWrap.find( '.sc-license-message' ).html( sc_strings.inactive_msg ).removeClass( 'sc-valid sc-invalid' ).addClass( 'sc-inactive' );

					} else if ( response == 'invalid' ) {

						licenseWrap.find( '.sc-license-message' ).html( sc_strings.invalid_msg ).removeClass( 'sc-inactive sc-valid' ).addClass( 'sc-invalid' );

					} else if ( response == 'notfound' ) {

						licenseWrap.find( '.sc-license-message' ).html( sc_strings.notfound_msg ).removeClass( 'sc-inactive sc-valid' ).addClass( 'sc-invalid' );

					} else if ( response == 'error' ) {

						licenseWrap.find( '.sc-license-message' ).html( sc_strings.error_msg ).removeClass( 'sc-inactive sc-valid' ).addClass( 'sc-invalid' );
					}
				});
			}
		});

		// Make enter keypress from input box fires off correct activate button in the case of more than one.
		$body.find( '.sc-license-wrap input.sc-license-input').keypress( function ( event ) {

			var licenseInput = $(this);

			if ( event.keyCode == 13 ) {
				event.preventDefault();

				licenseInput.siblings( 'button.sc-license-action:first' ).click();
			}
		});

	});
}(jQuery));
