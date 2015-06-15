<?php

/**
 * Show notice if SC Pro is not activated.
 *
 * @package    SC SUB
 * @subpackage Views
 * @author     Phil Derksen <pderksen@gmail.com>, Nick Young <mycorpweb@gmail.com>
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<style>
	#sc-sub-pro-deactivated-notice .button-primary,
	#sc-sub-pro-deactivated-notice .button-secondary {
		margin-left: 15px;
	}
</style>

<div id="sc-sub-pro-deactivated-notice" class="error">
	<p>
		<?php printf( __(  '%s requires Stripe Checkout Pro to run properly. ' .
				'Please install Stripe Checkout Pro to fully use this plugin.', 'sc_sub' ), Stripe_Subscriptions::get_instance()->get_plugin_title()); ?>
	</p>
</div>
