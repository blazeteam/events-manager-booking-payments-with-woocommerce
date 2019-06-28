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
     * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
     *
     * @return array Array of settings for @see woocommerce_admin_fields() function. 
     */
    public static function get_settings() {
        $settings = array(
            'section_title' => array(
                'name'     => __( 'Work in Progress - Please ignore this tab', 'blaze-event-woo' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'wc_settings_tab_demo_section_title'
            ),
            'blz_eventwoo_hide_product_name_in_cart' => array(
                'name' => __( 'Hide product name in Cart', 'blaze-event-woo' ),
                'type' => 'checkbox',
                'desc' => __( 'This hides the product name in the cart page and mini cart.', 'blaze-event-woo' ),
                'id'   => 'blz_eventwoo_hide_product_name_in_cart'
            ),
            'blz_eventwoo_hide_event_table_in_cart' => array(
                'name' => __( 'Hide event table in Cart', 'blaze-event-woo' ),
                'type' => 'checkbox',
                'desc' => __( 'This hides the event table in the cart and mini cart.', 'blaze-event-woo' ),
                'id'   => 'blz_eventwoo_hide_event_table_in_cart'
            ),
            'title' => array(
                'name' => __( 'Title', 'blaze-event-woo' ),
                'type' => 'text',
                'desc' => __( 'This is some helper text', 'blaze-event-woo' ),
                'id'   => 'wc_settings_tab_demo_title'
            ),
            'description' => array(
                'name' => __( 'Description', 'blaze-event-woo' ),
                'type' => 'textarea',
                'desc' => __( 'This is a paragraph describing the setting. Lorem ipsum yadda yadda yadda. Lorem ipsum yadda yadda yadda. Lorem ipsum yadda yadda yadda. Lorem ipsum yadda yadda yadda.', 'blaze-event-woo' ),
                'id'   => 'wc_settings_tab_demo_description'
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