<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Plugin Name: Events Manager Booking Payments with WooCommerce
 * Version: 1.0.0
 * Description: Connect the Events Manager plugin to WooCommerce to add an Event Booking product to the checkout when an event is booked.
 * Author: Blaze Concepts
 * Author URI: https://www.blazeconcepts.co.uk
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 * Text Domain: blaze-event-woo
 * Domain Path: /lang/
 *
 * @package Blaze Event Woo
 * @author Blaze Concepts Ltd
 * @since 1.0.0
**/

define ( 'PLUGIN', plugin_basename( __FILE__ ) );

include_once dirname( __FILE__ ) . '/installation/add-product.php';
include_once dirname( __FILE__ ) . '/installation/activation-check.php';
include_once dirname( __FILE__ ) . '/cart/cart-link.php';
include_once dirname( __FILE__ ) . '/cart/cart.php';
include_once dirname( __FILE__ ) . '/bookings/booking-status.php';
include_once dirname( __FILE__ ) . '/account/account-pages.php';
include_once dirname( __FILE__ ) . '/admin/settings.php';


register_activation_hook( __FILE__, array('BLZ_EventWoo_Install_Check', 'install') );


/* Enqueue scripts and styles.*/
function blz_eventwoo_enqueue() {
    wp_enqueue_style( 'blz_eventwoo_layout', plugin_dir_url( __FILE__ )  . '/css/blz_eventwoo_layout.css');
}
add_action( 'wp_enqueue_scripts', 'blz_eventwoo_enqueue' );