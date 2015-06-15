<?php

/**
 * Sidebar portion of the administration dashboard view.
 *
 * @package    SC Pro
 * @subpackage views
 * @author     Phil Derksen <pderksen@gmail.com>, Nick Young <mycorpweb@gmail.com>
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<!-- Use some built-in WP admin theme styles. -->

<div class="sidebar-container metabox-holder">
	<div class="postbox">
		<h3 class="wp-ui-primary"><span><?php _e( 'Resources', 'sc' ); ?></span></h3>
		<div class="inside">
			<ul>
				<li>
					<div class="dashicons dashicons-arrow-right-alt2"></div>
					<a href="<?php echo sc_ga_campaign_url( SC_WEBSITE_BASE_URL . 'docs/', 'stripe_checkout_pro', 'sidebar_link', 'docs' ); ?>" target="_blank">
						<?php _e( 'Support & Documentation', 'sc' ); ?></a>
				</li>

				<li>
					<div class="dashicons dashicons-arrow-right-alt2"></div>
					<a href="https://dashboard.stripe.com/" target="_blank">
						<?php _e( 'Stripe Dashboard', 'sc' ); ?></a>
				</li>
			</ul>
		</div>
	</div>
</div>

<div class="sidebar-container metabox-holder">
	<div class="postbox-nobg">
		<div class="inside centered">
			<a href="https://stripe.com/" target="_blank">
				<img src="<?php echo SC_PLUGIN_URL; ?>assets/powered-by-stripe.png" />
			</a>
		</div>
	</div>
</div>
