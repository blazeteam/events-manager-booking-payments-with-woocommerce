<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class blz_eventwoo_settings_tab {

    public static function init(){
        $plugin = PLUGIN;
        add_filter( "plugin_action_links_$plugin", __CLASS__ . '::settings_link' );
        add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
        add_action( 'woocommerce_settings_tabs_settings_tab_blz_eventwoo', __CLASS__ . '::settings_tab' );
        add_action( 'woocommerce_update_options_settings_tab_blz_eventwoo', __CLASS__ . '::update_settings' );
    }
    

    public static function settings_link( $links ) {
        $settings_link = '<a href="admin.php?page=wc-settings&tab=settings_tab_blz_eventwoo">' . __( 'Settings' ) . '</a>';
        array_push( $links, $settings_link );
        return $links;
    }


    public static function add_settings_tab( $settings_tabs ) {
        $settings_tabs['settings_tab_blz_eventwoo'] = __( 'Events', 'blz_eventwoo' );
        return $settings_tabs;
    }


    /**
    * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
    *
    * @uses woocommerce_admin_fields()
    * @uses self::get_settings()
    */
    public static function settings_tab() {
        woocommerce_admin_fields( self::get_settings() );
    }


    /**
    * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
    *
    * @uses woocommerce_update_options()
    * @uses self::get_settings()
    */
    public static function update_settings() {
        woocommerce_update_options( self::get_settings() );
    }


    /**
     * Get all the settings for this plugin to generate the Settings Page in WooCommerce.
     * @see woocommerce_admin_fields() function.
     * @return array Array of settings. 
     */
    public static function get_settings() {
        $settings = array(
            'section_title' => array(
                'name'     => __( 'Events Manager for WooCommerce Settings', 'blaze-event-woo' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'blz_eventwoo_title'
            ),
            'blz_eventwoo_product_added_message' => array(
                'name' => __( 'Product added message', 'blaze-event-woo' ),
                'type' => 'textarea',
                'desc' => __( 'The message displayed to the user when they make a booking on the event page', 'blaze-event-woo' ),
                'id'   => 'blz_eventwoo_product_added_message',
                'default' => 'You have a pending booking for this event, we have added an event booking item to your shopping basket',
            ),
            'blz_eventwoo_product_added_link_to_cart' => array(
                'name' => __( 'Link to cart message', 'blaze-event-woo' ),
                'type' => 'textarea',
                'desc' => __( 'The text displayed on the cart link when they make a booking on the event page', 'blaze-event-woo' ),
                'id'   => 'blz_eventwoo_product_added_link_to_cart',
                'default' => 'please proceed to the checkout when you are ready.',
            ),
            'blz_eventwoo_hide_product_name_in_cart' => array(
                'name' => __( 'Hide product name in cart', 'blaze-event-woo' ),
                'type' => 'checkbox',
                'desc' => __( 'This hides the product name in the cart page and mini cart.', 'blaze-event-woo' ),
                'id'   => 'blz_eventwoo_hide_product_name_in_cart'
            ),
            'section_end' => array(
                 'type' => 'sectionend',
                 'id' => 'wc_settings_tab_demo_section_end'
            )
        );
        return apply_filters( 'blz_eventwoo_settings_tab_settings', $settings );
    }


}

blz_eventwoo_settings_tab::init();