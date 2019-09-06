=== Events Manager Booking Payments with WooCommerce ===
Contributors: blazeconcepts
Donate link: https://www.paypal.me/blazeconcepts
Tags: woocommerce, events, manager, payment, bookings, payment gateway
Requires at least: 4.7
Tested up to: 5.2
Stable tag: 1.1.0
WC requires at least: 3.5
WC tested up to: 3.7
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Integrated with Events Manager and WooCommerce, this plugin gives customers a full range of payment gateway options to book and pay for events.

== Description ==

This plugin integrates with the [Events Manager](https://en-gb.wordpress.org/plugins/events-manager/) plugin by Marcus Sykes, providing the full range of payment gateways available in [WooCommerce](https://en-gb.wordpress.org/plugins/woocommerce/).

The plugin works by linking your events to a WooCommerce Product. After the customer selects the quantity they wish the book, it adds the booking to the cart as a product, where the customer can then proceed to the checkout and pay using any of the payment gateways provided by WooCommerce.

You do not need to create a Product for each of your events. The plugin creates just one called 'Event Booking' and this is used dynamically for all your events in order for the WooCommerce integration to work. It is important you do not delete this product otherwise the plugin will stop working! 

It is worth noting that the Events Manager plugin does offer a Pro version with payment intergration however this is limited to just PayPal, Authorize.net and Offline Payments. Our plugin, with WooCommerce offers many more payment gateways including, but not limited to:
* PayPal
* SagePay
* WorldPay
* Stripe
* BACS
* [and more...](https://woocommerce.com/product-category/woocommerce-extensions/payment-gateways/)

## Requirements
For this plugin to work, you need the [Events Manager](https://en-gb.wordpress.org/plugins/events-manager/) and [WooCommerce 3.5+](https://en-gb.wordpress.org/plugins/woocommerce/).

This plugin does not provide events management on it’s own. The Events Manager plugin is required for this functionality.


## Development
This plugin is developed and maintained by [Blaze Concepts](https://www.blazeconcepts.co.uk/) in the UK and we are very greatful to [Marcus Sykes](http://wp-events-plugin.com/) and the [WooCommerce team](https://woocommerce.com) for their respective efforts on Events Manager and WooCommerce.

The development repo is at [Github](https://github.com/blazeteam/events-manager-booking-payments-with-woocommerce), where you're welcome to raise issues, submit documentation and pull requests.

== Installation ==

**Events Manager Booking Payments with WooCommerce** requires the [WooCommerce](https://wordpress.org/plugins/woocommerce/ "WooCommerce") plugin (at least version 3.5) to be installed.

= Via WordPress =
1. From the WordPress Dashboard, go to Plugins > Add New
2. Search for 'Events Manager Booking Payments with WooCommerce' and click Install. Then click Activate.
3. Click the Settings link to set up any options.

= Manual =
1. Upload the folder /events-manager-booking-payments-with-woocommerce/ to the /wp-content/plugins/ directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Click the Settings link to set up any options, or go to WooCommerce -> Settings -> Events (tab).

== FAQ ==

= How do I change the message that says the product has been added when the booking form is submitted? =

Go to WooCommerce -> Settings -> Events (tab) and update the settings there.

= How do I hide the product name "Event Booking" from the cart pages? =

Go to WooCommerce -> Settings -> Events (tab) and set the option for "Hide product name in cart".

== Screenshots ==

1. WooCommerce Basket with Event Details
2. Plugin settings in WooCommerce


== Changelog ==

= 1.0.0 =
* Initial release

= 1.0.1 =
5th July 2019
* Change main plugin filename

= 1.1.0 =
11th July 2019
* Enhancement: Option to disable booking spaces drop down selectors if logged out.
* Enhancement: Option to display Account Created message on event page when just logged in.
* Enhancement: Improve orgnisation of settings page.