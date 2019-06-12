<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


// Check WooCommerce and the Event Manager is installed as thats pretty important with this plugin
if (!class_exists('BLZ_EventWoo_Install_Check')) {
    class BLZ_EventWoo_Install_Check
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
            add_option('Activated_Blaze_EventWoo_Plugin', 'Blaze_Event_Woo');
        }
    }
}


// END Check WooCommerce is installed