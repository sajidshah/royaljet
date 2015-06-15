<?php

/**
 * Show admin license key notice if Lite or the old legacy plugins are detected.
 *
 * @package    SC Pro
 * @subpackage Views
 * @author     Phil Derksen <pderksen@gmail.com>, Nick Young <mycorpweb@gmail.com>
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<style>
	#sc-lite-legacy-notice .button-primary,
	#sc-lite-legacy-notice .button-secondary {
		margin: 2px 0;
	}
</style>

<div id="sc-lite-legacy-notice" class="error">
	<p>
		<?php
			// Check for empty key first.
			echo '<strong>' . __( 'Notice: You have Stripe Checkout Lite and/or a legacy add-on installed. Please deactivate the plugin(s) to avoid conflicts with Stripe Checkout Pro.', 'sc' ) . '</strong>' . "\n";
		?>
	</p>
</div>
