=== Events Manager Booking Payments with WooCommerce ===
Contributors: blazeconcepts
Donate link: https://www.paypal.me/blazeconcepts
Tags: woocommerce, events, manager, payment, bookings
Requires at least: 4.7
Tested up to: 5.2.2
Stable tag: 1.0.0
WC requires at least: 3.5
WC tested up to: 3.6.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Integrates the excellent WordPress Events Manager with WooCommerce so that users can use the full range of payment gateways that WooCommerce provide.

== Description ==

This plugin integrates the popular WordPress [Events Manager](https://en-gb.wordpress.org/plugins/events-manager/) by Marcus Sykes with [WooCommerce](https://en-gb.wordpress.org/plugins/woocommerce/) so that users can use the full range of payment gateways that WooCommerce provide.

The plugin works by adding an 'Event Booking' WooCommerce product. Each time the cart is displayed the plugin checks for Pending (or Awaiting Payment or Awaiting Online Payment) event bookings. If any Pending bookings exist the plugin adds the Event Booking product to the cart with the event booking details in the cart item meta information. The visitor can then go through the checkout process in WooCommerce and once complete, the status of the bookings is changed to Approved.

If the WooCommerce order is cancelled, the plugin sets the associated booking statuses back to Awaiting Payment.

The plugin doesn't make assumptions about design and tries to use as little CSS as possible so styling should inherit from your theme without too much trouble.

## Important Note
This plugin does not provide events management on it's own, it utilises the [Events Manager](https://en-gb.wordpress.org/plugins/events-manager/) to provide that functionality.

## Development
The development repo is at [Github](https://github.com/blazeteam/events-manager-booking-payments-with-woocommerce), where you're welcome to raise issues, submit documentation and pull requests.

This plugin is developed and maintained by [Blaze Concepts](https://www.blazeconcepts.co.uk/) in the UK and we are very greatful to [Marcus Sykes](http://wp-events-plugin.com/) and the [WooCommerce team](https://woocommerce.com) for their respective efforts on Events Manager and WooCommerce.


[http://wp-events-plugin.com](http://wp-events-plugin.com) provides a pro version of Events Manager that has it's own booking system as well as a number of other enhancements however this plugin fulfilled our requirement to use different payment gateways and help others to do the same.

== Installation ==

**Events Manager Booking Payments with WooCommerce** requires the [WooCommerce](https://wordpress.org/plugins/woocommerce/ "WooCommerce") plugin (at least version 3.5) to be installed.

= Via WordPress =
1. From the WordPress Dashboard, go to Plugins > Add New
2. Search for 'Events Manager Booking Payments with WooCommerce' and click Install. Then click Activate.
3. Click the Settings link to set up any options.

= Manual =
1. Upload the folder /blaze-event-woocommerce-integration/ to the /wp-content/plugins/ directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Click the Settings link to set up any options.

== FAQ ==

= How do I change the message that says the product has been added when the booking form is submitted? =

Go to WooCommerce -> Settings -> Events (tab) and update the settings there.

= How do I hide the product name "Event Booking" from the cart pages? =

Go to WooCommerce -> Settings -> Events (tab) and set the option for "Hide product name in cart".

== Screenshots ==

1. WooCommerce Basket with Event Details


== Changelog ==

= 1.0.0 =
* Initial release