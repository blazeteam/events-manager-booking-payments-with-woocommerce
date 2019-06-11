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


// Check WooCommerce and the Event Manager is installed as thats pretty important with this plugin :)
if (!class_exists('BLZ_EventWoo_InstallCheck')) {
    class BLZ_BCL_InstallCheck
    {
        static function install()
        {
            if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                deactivate_plugins(__FILE__);
                $error_message = __('This plugin requires <a href="http://wordpress.org/extend/plugins/woocommerce/">WooCommerce</a> plugin to be active!', 'woocommerce');
                die($error_message);
            }
            if (!in_array('events-manager/events-manager.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                deactivate_plugins(__FILE__);
                $error_message = __('This plugin requires <a href="https://wordpress.org/plugins/events-manager/">Events Manager</a> plugin to be active!', 'woocommerce');
                die($error_message);
            }
        }
    }
}

register_activation_hook( __FILE__, array('BLZ_EventWoo_InstallCheck', 'install') );
// END Check WooCommerce is installed