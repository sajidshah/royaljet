=== Stripe Checkout Pro: Subscriptions Add-On ===
Contributors: pderksen, nickyoung87
Requires at least: 3.9
Tested up to: 4.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Subscriptions Add-On for Stripe Checkout Pro.

== Changelog ==

= 1.1.7 - May 20, 2015 =

* Added check for existence of extra fields before saving to meta data.

= 1.1.6 - April 22, 2015 =

* Updated calls to add_query_arg to prevent any possible XSS attacks.

= 1.1.5 - April 6, 2015 =

* Remove WPUpdatePHP class and usage since Stripe Checkout Pro (base) plugin already makes this check.
* Renamed use of key statement_description to statement_descriptor (Stripe API change).
* Fixed bug with statement_descriptor length.
* Payment success output now properly encodes slashes for store name and description.
* Updated shortcode tracker class.
* Tested up to WordPress 4.2.

= 1.1.4.1 - March 24, 2015 =

* Add extra check for WPUpdatePHP class existence. Fixes redeclare error in some cases.

= 1.1.4 - March 21, 2015 =

* Fixed a bug occurring with multiple plans in some cases.
* Now checks that host is running PHP 5.3.3 or higher using the WPupdatePHP library.

= 1.1.3 - March 18, 2015 =

* Fixed bug when using subscriptions with user-entered amount.
* Now warning, not deactivating this plugin, when the base Stripe Checkout Pro plugin is inactive or missing.
* Fixed bug where test_mode attribute wasn't setting test mode properly.

= 1.1.2 - March 12, 2015 =

* Updated to work with the most recent Stripe PHP library (v2.1.1).

= 1.1.1 =

* Check setting in Stripe Checkout Pro to always show scripts.

= 1.1.0.1 =

* Fixed bug where fatal errors may occur when an old version of Stripe Checkout Pro is still active.

= 1.1.0 =

* Tested up to WordPress 4.1.
* Plugin updater performance improvements.
* Updated to use new Stripe Checkout Pro filters to keep better separation between add-on and base plugin code.
* Fixed bug with use of do_shortcode() with subscription shortcodes in theme template files.
* Updated to utilize current Stripe API updates.
* Display clearer admin warning when shortcode syntax is invalid.
* Plugin script now only enqueued on posts and pages where required.

= 1.0.9 =

* Subscription plans created by user-entered amounts now have clearer plan names, which show up on email receipts and other places.
* Plugin updater performance improvements.

= 1.0.8 =

* Added support and messaging for trial subscription signups.
* Fixed bug with subscription plans and user-entered amounts in different forms on the same page.
* Error handling improvements.
* Simplified text domain function.

= 1.0.7 = 

* Added use_amount shortcode attribute to support new user-entered radio button or drop-down amount fields.

= 1.0.6 =

* Adjustment for charge details change in Stripe Checkout Pro 2.0.7.

= 1.0.5 =

* Fixed plan labels and payment success message to show custom interval counts (i.e. "$50.00 every 3 months").

= 1.0.4 =

* Adjustment for payment button class change in Stripe Checkout Pro 2.0.5.

= 1.0.3 =

* Enabled subscription integration with user entered amounts.
* Enabled subscription integration with custom fields.
* Enabled subscription integration with Stripe coupons.
* Improved invalid Stripe API key handling.
* Better admin-only notices for invalid shortcode combinations.
* Now allows plans of different currencies.

= 1.0.2 =

* Fixed a bug where live keys were throwing errors.

= 1.0.1 =

* Fixed bug with amounts when multiple Stripe checkout forms exist on a single page.

= 1.0.0 =

* Initial add-on release.
