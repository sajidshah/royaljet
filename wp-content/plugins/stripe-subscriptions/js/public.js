/**
 * Stripe Subscriptions public facing JavaScript
 *
 * @package SC_SUB
 * @author  Phil Derksen <pderksen@gmail.com>, Nick Young <mycorpweb@gmail.com>
 */

/* global jQuery, sc_script */

(function($) {
    'use strict';

    $(function() {

	    var $body = $( 'body' );
	
		$body.find( '.sc-checkout-form' ).each( function() {
		
            var scForm = $(this);
			
            // Get the "sc-id" ID of the current form as there may be multiple forms on the page.
            var formId = scForm.data('sc-id') || '';
			
			// Set the initial price based on the default subscription set
			if( scForm.has( '.sc_sub_amount' ).length > 0 ) {
				sc_script[formId].amount = scForm.find('.sc_sub_amount').val();
				sc_script[formId].originalAmount = scForm.find('.sc_sub_amount').val();
				
				if( scForm.has( '.sc_sub_currency').length > 0 ) {
					// single plan
					sc_script[formId].currency = scForm.find( '.sc_sub_currency').val();
				} else {
					sc_script[formId].currency = scForm.find('.sc_sub_wrapper .sc-radio-group input[type="radio"]:checked').data('sub-currency');
				}
				
			}
			
			// Update price and ID anytime a radio button changes
			scForm.find('.sc_sub_wrapper input[type="radio"]').on( 'change', function() {
				// We will update the hidden fields in case we need them somewhere else
				scForm.find('.sc_sub_id').val($(this).data('sub-id'));
				scForm.find('.sc_sub_amount').val($(this).data('sub-amount'));
				scForm.find('.sc_sub_interval').val($(this).data('sub-interval'));
				scForm.find('.sc_sub_interval_count').val($(this).data('sub-interval-count'));
				
				// Update the amount
				sc_script[formId].amount = scForm.find('.sc_sub_amount').val();
				sc_script[formId].originalAmount = scForm.find('.sc_sub_amount').val();
				
				// Update the currency
				sc_script[formId].currency = $(this).data('sub-currency');
				
				// Check for non-blank coupon code value.
		        var scCouponCode = scForm.find('.sc-coup-coupon-code').val();
				
				// If a coupon value exists then we need to update the price by calling the ajax function
		        if (scCouponCode) {
					// disable the buy button until the ajax completes
					scForm.find('.sc-payment-btn').prop('disabled',true);
					
					var oldMessage = scForm.find( '.sc-coup-success-message').html();
					
					// Change coupon message while calculating new price
					scForm.find('.sc-coup-success-message').html( 'Calculating...');
					scForm.find('.sc-coup-remove-coupon').hide();
					// Show loading indicator while checking code validity.
			        //scForm.find('.sc-coup-loading').show();
					// AJAX POST params
			        var params = {
				        action: 'sc_coup_get_coupon',
				        coupon: scCouponCode,
				        // Amount already preset in basic [stripe] shortcode (or default of 50).
				        amount: sc_script[formId].amount
			        };
					
					// Send AJAX POST -- sc_sub.ajaxurl from localized JS.
					$.post(sc_sub.ajaxurl, params, function (response) { 
						
						if(response.success) {
							// Update the amount
							sc_script[formId].amount = response.message;
							scForm.find('.sc-total-amount').html(currencyFormattedAmount(sc_script[formId].amount, sc_script[formId].currency));
						}
						
						// Re-enable the buy button
						scForm.find('.sc-payment-btn').prop('disabled',false);
						
						// Put original coupon message back
						scForm.find('.sc-coup-success-message').html(oldMessage);
						scForm.find('.sc-coup-remove-coupon').show();
					}, 'json' );
				}
				
				scForm.find('.sc-total-amount').html(currencyFormattedAmount(sc_script[formId].amount, sc_script[formId].currency));
			});
			
			
			scForm.find('.sc-total-amount').html(currencyFormattedAmount(sc_script[formId].amount, sc_script[formId].currency));
			
		});
		
		// Zero-decimal currency check.
        // Just like sc_is_zero_decimal_currency() in PHP.
        // References sc_script['zero_decimal_currencies'] localized JS value.
        function isZeroDecimalCurrency(currency) {
            return ( $.inArray(currency.toUpperCase(), sc_script['zero_decimal_currencies']) > 1 );
        }

        // Use with coupon "amount" type and total amount.
        function currencyFormattedAmount(amount, currency) {
            // Just in case.
            currency = currency.toUpperCase();

            // Don't use decimals if zero-based currency.
            // Uses JS function in base plugin.
            if ( isZeroDecimalCurrency(currency) ) {
                amount = Math.round(amount);
            } else {
                amount = (amount / 100).toFixed(2);
            }

            var formattedAmount = '';

            // USD only: Show dollar sign on left of amount.
            if (currency === 'USD') {
                formattedAmount = '$' + amount;
            }
            else {
                // Non-USD: Show currency on right of amount.
                formattedAmount = amount + ' ' + currency;
            }

            return formattedAmount;
        }
    });

}(jQuery));
