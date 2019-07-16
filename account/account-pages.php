<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Add My Bookings button to WooCommerce Dashboard nav menu
 *
 * @param array $items The existing menu items
 * @param array $endpoints
 * @return array $items + the added items
 */
function blz_eventwoo_my_account_page_bookings_button( $items, $endpoints ){
    $orders_pos = 2;
    $items_start = array_splice( $items, $orders_pos);
    $items['../events/my-bookings'] = __( 'My Bookings', 'eventwoo' );
    return $items + $items_start;
}
add_filter( 'woocommerce_account_menu_items', 'blz_eventwoo_my_account_page_bookings_button', 10, 2 );


/**
 * Add WooCommerce dashboard nav menu to Events My Bookings page
 *
 * @return void
 */
function blz_eventwoo_add_wc_my_account_menu(){
    $wc_my_account_nav = woocommerce_account_navigation();
    echo $wc_my_account_nav;
}
add_action( 'em_template_my_bookings_header', 'blz_eventwoo_add_wc_my_account_menu' );


/**
 * Make the My Bookings link active if on the My Bookings page
 *
 * @param array $classes Array of class strings
 * @param string $endpoint
 * @return array $classes
 */
function blz_eventwoo_bookings_button_active( $classes, $endpoint ){
    global $wp_query;
    if ( ( $endpoint == '../events/my-bookings' ) && ( $wp_query->queried_object->post_name == 'my-bookings' ) ) {
        array_push( $classes, 'is-active' );
    }
    return $classes;
}
add_filter( 'woocommerce_account_menu_item_classes', 'blz_eventwoo_bookings_button_active', 10, 2 );


/**
 * Remove booking ID's from displayed HTML - Particularly for the customer Order Details page. 
 * e.g. my-account/view-order/nnnn/
 *
 * @param string $html
 * @param WC_Order_Item $item
 * @param array $args
 * @return string
 */
function blz_eventwoo_hide_booking_ids( $html, $item, $args ){
    $re = '/<li>.*bookingIDs.*<\/li>/m';
    $html = preg_replace( $re, '', $html );
    return $html;
}
add_filter( 'woocommerce_display_item_meta', 'blz_eventwoo_hide_booking_ids', 10, 3 );