<?php

/**
 * Show notice if SC Pro is not the latest version.
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
	#sc-sub-pro-upgrade-notice .button-primary,
	#sc-sub-pro-upgrade-notice .button-secondary {
		margin-left: 15px;
	}
</style>

<div id="sc-sub-pro-upgrade-notice" class="error">
	<p>
		<?php _e( 'Your version of Stripe Checkout Pro is out of date. Please update it to avoid any incompatibilities with the Subscriptions add-on.', 'sc_sub' ); ?>
	</p>
</div>
