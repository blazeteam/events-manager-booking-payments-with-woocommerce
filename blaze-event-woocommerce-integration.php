<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Plugin Name: Blaze Event - WooCommerce Integration
 * Version: 1.0
 * Plugin URI: https://www.blazeconcepts.co.uk
 * Description: Connect the Events Manager plugin to WooCommerce to add an Event Booking product to the checkout when an event is booked.
 * Author: Andrew Real - Blaze Concepts
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

include plugin_dir_path( __FILE__ ) . 'installation/add-product.php';
include plugin_dir_path( __FILE__ ) . 'installation/activation-check.php';

