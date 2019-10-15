<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Display custom cart item meta data (in cart and checkout)
 *
 * @param array $item_data
 * @param array $cart_item
 * @return array $item_data
 */
function blz_eventwoo_display_cart_item_custom_meta_data( $item_data, $cart_item ) {
    if ( isset( $cart_item['events'] ) ) {
        $item_data[] = array(
            'key'       => 'Events',
            'value'     => $cart_item['events'],
        );
    }
    if ( isset( $cart_item['Manage Bookings'] ) ) {
        $manage_bookings_page = get_post( $cart_item['Manage Bookings'] );
        $url = get_permalink( $manage_bookings_page );
        $item_data[] = array(
            'key'       => "manage-booking-button",
            'value'     => "<a  class='button button-secondary' href='$url'>" . __('Manage My Bookings', 'eventwoo') . "</a>",
        );
    }
    return $item_data;
}
add_filter( 'woocommerce_get_item_data', 'blz_eventwoo_display_cart_item_custom_meta_data', 99, 2 );


/**
 * Calculate the line price from the event costs.
 *
 * @param WC_Cart $cart_object
 * @return void
 */
function blz_eventwoo_price_to_cart_item( $cart_object ) {  
    if( !WC()->session->__isset( "reload_checkout" )) {
        foreach ( $cart_object->cart_contents as $key => $value ) {
            if( isset( $value["event_places_cost"] ) ) {
                // for woocommerce version lower than 3
                //$value['data']->price = $value["custom_price"];
                // for woocommerce version +3
                $value['data']->set_price($value["event_places_cost"]);
            }
        }  
    }  
}
add_action( 'woocommerce_before_calculate_totals', 'blz_eventwoo_price_to_cart_item', 99 );

/**
 * Remove the event booking product from cart and add back in again.
 * This is done on each page load to ensure the cart is recalculated,
 * e.g. if a booking is removed by the user.
 *
 * @return void
 */
function blz_eventwoo_update_cart_with_event_bookings(){
    blz_eventwoo_remove_event_product_from_cart();
    blz_eventwoo_add_event_product();
}
add_action( 'template_redirect', 'blz_eventwoo_update_cart_with_event_bookings', 90 );
add_filter( 'wp_ajax_eventwoo_update_mini_cart', 'blz_eventwoo_update_cart_with_event_bookings' );


/**
 * Remove any occurance of the Event Booking product before we recalculate and add a new one.
 *
 * @return void
 */
function blz_eventwoo_remove_event_product_from_cart(){
    global $woocommerce;
    foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item) {
        $wc_event_product = blz_eventwoo_get_product_by_sku( 'Event Booking' );
        $event_product_id = $wc_event_product->get_id();
        if ($cart_item['product_id'] == $event_product_id) {
            $woocommerce->cart->remove_cart_item($cart_item_key);
        }
    }
}


/**
 * Add our Event Product to the cart with the meta info and price.
 *
 * @return void
 */
function blz_eventwoo_add_event_product() {
    global $woocommerce;
    $user = _wp_get_current_user();
    $em_user = new EM_Person( $user->ID );
    $bookings = $em_user->get_bookings();
    $cart_item_data = array(
        'event_places_cost' => 0,
        'events' => '',
    );
    $booking_ids = array();
    $booking_count = 0;
    $event_table = "<table class='cart-event-table'>";
    $heading_event_name = __('Event Name', 'eventwoo');
    $heading_places = __('Places', 'eventwoo');
    $event_table .= "<tr><th>$heading_event_name</th><th>$heading_places</th></tr>";        
    foreach($bookings as $booking){
        if ($booking->booking_status == 0 || $booking->booking_status == 4 || $booking->booking_status == 5 ){
            // Event Manager Booking Status ID's - 0 = Pending, 1 = Approved, 2 = Rejected, 3 = Cancelled, 4 = Awaiting Online Payment, 5 = Awaiting Payment
            $booking_count++;
            $em_event = $booking->get_event();
            $booking_id = $booking->booking_id;
            $event_table .= "<tr data-eventID='{$em_event->event_id}' data-bookingID='{$booking_id}'>";
            $event_table .= "   <td class='name'><a href='{$em_event->get_permalink()}'>{$em_event->event_name}</a></td>";
            $event_table .= "   <td class='spaces' data-spaces='{$booking->get_spaces()}'>{$booking->get_spaces()}</td>";
            $event_table .= "</tr>";
            $cart_item_data['event_places_cost'] = $cart_item_data['event_places_cost'] + $booking->get_price_pre_taxes();
            array_push($booking_ids, $booking_id);
        }
    }
    $event_table .= "</table>";
    $cart_item_data['events'] = $event_table;
    $cart_item_data['bookingIDs'] = implode(',', $booking_ids);
    $cart_item_data['Manage Bookings'] = get_option( 'dbem_my_bookings_page' );
    $wc_product = blz_eventwoo_get_product_by_sku( 'Event Booking' );
    $product_id = $wc_product->get_id();
    if ($booking_count > 0){
        $result = $woocommerce->cart->add_to_cart($product_id, 1, 0, array(), $cart_item_data);
        if ( ( $result == null ) || ( $result == false ) ){
            wc_add_notice( __('Could not add event booking to cart.', 'eventwoo'), 'error');
            error_log ( __( 'Could not add event booking to cart, there is a good change that this is due to the Event Booking product missing.', 'eventwoo' ) );
        }
    }
}

/**
 * Save / Display custom field value as custom order item meta data when creating the order from the cart
 *
 * @param WC_Order_Item $item
 * @param string $cart_item_key
 * @param array $values
 * @param WC_Order $order
 * @return void
 */
function blz_eventwoo_field_update_order_item_meta( $item, $cart_item_key, $values, $order ) {
    if( isset($values['bookingIDs']) ){
        $item->update_meta_data( __('bookingIDs'), $values['bookingIDs'] );
    }
    if( isset($values['events']) ){
        $item->update_meta_data( __('events'), $values['events'] );
    }
}
add_action( 'woocommerce_checkout_create_order_line_item', 'blz_eventwoo_field_update_order_item_meta', 20, 4 );


/**
 * If we want the Event Booking product name hidden in the mini cart add a 'hidden' class.
 *
 * @param array $cart_item
 * @param string $cart_item_key
 * @return array $cart_item
 */
function blz_eventwoo_hide_product_name($product_name){
    $re = '/<a.*Event Booking<\/a>/m';
    if ( ( $product_name == 'Event Booking' ) || ( preg_match_all($re, $product_name) ) ) {
        if ( get_option( 'blz_eventwoo_hide_product_name_in_cart' ) == 'yes' ){
            $product_name = '';
        }
    }
    return $product_name;
}
add_filter( 'woocommerce_cart_item_name', 'blz_eventwoo_hide_product_name', 10, 1 );

/**
 * Modify (currently remove) the default remote cart item button on the Event Booking line as the 
 * cart is automatically re-generated
 *
 * @param string $link html for the remove button
 * @param string|int $cart_item_key
 * @return string $link
 */
function blz_eventwoo_cart_item_remove_to_bookings( $link, $cart_item_key ){
    $cart_item = WC()->cart->get_cart_item( $cart_item_key );
    $product_id = $cart_item['product_id'];
    $product = wc_get_product( $product_id );
    $product_slug = $product->get_slug();
    if ( $product_slug == 'event-booking' ) {
        // TODO - Would be better to redirect the remove item button to the Manage My Bookings page 
        // but WooCommerce intercepts the button and causes an Ajax reload which stops any redirect
        // working.
        $message = __( 'To remove this line, remove your unpaid bookings using the Manage My Bookings page.', 'eventwoo' );
        $link = "<span class='remove disabled' title='$message'>&times;</span>";
    }
    return $link;
}
add_filter( 'woocommerce_cart_item_remove_link', 'blz_eventwoo_cart_item_remove_to_bookings', 10, 2 );



function blz_eventwoo_update_mini_cart() {
    echo wc_get_template( 'cart/mini-cart.php' );
    die();
}
add_filter( 'wp_ajax_nopriv_eventwoo_update_mini_cart', 'blz_eventwoo_update_mini_cart' );
add_filter( 'wp_ajax_eventwoo_update_mini_cart', 'blz_eventwoo_update_mini_cart' );