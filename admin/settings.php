<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class blz_eventwoo_settings_tab {

    public static function init(){
        $plugin = BLZ_EVENTWOO_PLUGIN;
        add_filter( "plugin_action_links_$plugin", __CLASS__ . '::settings_link' );
        add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
        add_action( 'woocommerce_settings_tabs_settings_tab_blz_eventwoo', __CLASS__ . '::settings_tab' );
        add_action( 'woocommerce_update_options_settings_tab_blz_eventwoo', __CLASS__ . '::update_settings' );
    }
    
    /**
     * Add the link to the settings page on the Plugins screen
     *
     * @param array $links
     * @return array
     */
    public static function settings_link( $links ) {
        $settings_link = '<a href="admin.php?page=wc-settings&tab=settings_tab_blz_eventwoo">' . __( 'Settings', 'eventwoo' ) . '</a>';
        array_push( $links, $settings_link );
        return $links;
    }

    /**
     * Add the Events settings tab to the WooCommerce Settings screen
     *
     * @param array $settings_tabs
     * @return array
     */
    public static function add_settings_tab( $settings_tabs ) {
        $settings_tabs['settings_tab_blz_eventwoo'] = __( 'Events', 'eventwoo' );
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
            'blz_eventwoo_booking_recommendation' => array(
                'name' => __( 'Recommendations', 'eventwoo' ),
                'type' => 'title',
                'desc' => __( 'Events payments currently requires that users are logged in so we recommend setting the Allow Guest Bookings (in Events -> Settings -> Bookings -> General Options) to No. <br/>We also recommend that you allow users to register (in Settings -> General -> Membership).', 'eventwoo' ),
                'id'   => 'blz_eventwoo_booking_recommendation',
            ),
            'section_title_events_page' => array(
                'name'     => __( 'Events Page Settings', 'eventwoo' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'blz_eventwoo_title'
            ),
            'blz_eventwoo_product_added_message' => array(
                'name' => __( 'Product added message', 'eventwoo' ),
                'type' => 'textarea',
                'desc' => __( 'The message displayed to the user when they make a booking on the event page', 'eventwoo' ),
                'id'   => 'blz_eventwoo_product_added_message',
                'default' => 'You have a pending booking for this event, we have added an event booking item to your shopping basket',
            ),
            'blz_eventwoo_product_added_link_to_cart' => array(
                'name' => __( 'Link to cart message', 'eventwoo' ),
                'type' => 'textarea',
                'desc' => __( 'The text displayed on the cart link when they make a booking on the event page', 'eventwoo' ),
                'id'   => 'blz_eventwoo_product_added_link_to_cart',
                'default' => 'please proceed to the checkout when you are ready.',
            ),
            'section_end_events_page' => array(
                'type' => 'sectionend',
                'id' => 'blz_eventwoo_section_end_events_page'
            ),

            'section_title_events_cart' => array(
                'name'     => __( 'Cart Settings', 'eventwoo' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'blz_eventwoo_events_cart_title'
            ),
            'blz_eventwoo_hide_product_name_in_cart' => array(
                'name' => __( 'Hide product name in cart', 'eventwoo' ),
                'type' => 'checkbox',
                'desc' => __( 'This hides the product name in the cart page and mini cart.', 'eventwoo' ),
                'id'   => 'blz_eventwoo_hide_product_name_in_cart'
            ),
            'blz_eventwoo_disable_spaces_if_logged_out' => array(
                'name' => __( 'Disable the Spaces dropdowns if logged out', 'eventwoo' ),
                'type' => 'checkbox',
                'desc' => __( 'This disables the Spaces dropdown selectors if the vsitior is not logged in.', 'eventwoo' ),
                'id'   => 'blz_eventwoo_disable_spaces_if_logged_out'
            ),
            'section_end_events_cart' => array(
                'type' => 'sectionend',
                'id' => 'blz_eventwoo_section_end_events_cart'
            ),

            'section_title_events_order' => array(
                'name'     => __( 'Order Settings', 'eventwoo' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'blz_eventwoo_order_title'
            ),
            'blz_eventwoo_set_event_orders_completed' => array(
                'name' => __( 'Set orders to completed when paid', 'eventwoo' ),
                'type' => 'checkbox',
                'desc' => __( 'This bypasses the Processing order status. Not recommended if you are also selling physical products.', 'eventwoo' ),
                'id'   => 'blz_eventwoo_set_event_orders_completed'
            ),
            'section_title_end_events_order' => array(
                'type' => 'sectionend',
                'id' => 'blz_eventwoo_section_title_events_cart'
            ),

            'blz_eventwoo_registration_section' => array(
                'name'     => __( 'Registration Message', 'eventwoo' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'blz_eventwoo_registration_section'
            ),
            'blz_eventwoo_display_registered_message_on_event_page' => array(
                'name' => __( 'Display registration message', 'eventwoo' ),
                'type' => 'checkbox',
                'desc' => __( 'Display the Account Created message on the Event page when just registered.', 'eventwoo' ),
                'id'   => 'blz_eventwoo_display_registered_message_on_event_page'
            ),
            'blz_eventwoo_registered_message' => array(
                'name' => __( 'Registered message', 'eventwoo' ),
                'type' => 'textarea',
                'desc' => __( 'The message displayed to when the user on the Event page has just registered.', 'eventwoo' ),
                'id'   => 'blz_eventwoo_registered_message',
                'default' => 'Your account has been created and we\'ve logged you in. We\'ve sent you an email with your username and password.',
            ),

            'section_end_registration' => array(
                 'type' => 'sectionend',
                 'id' => 'blz_eventwoo_section_end_registration'
            )
        );
        return apply_filters( 'blz_eventwoo_settings_tab_settings', $settings );
    }


}

blz_eventwoo_settings_tab::init();