<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


function blz_eventwoo_booking_add( $save_result, $EM_Booking){
    if ( $save_result ) {
        $wc_product = blz_eventwoo_get_product_by_sku( 'Event Booking' );
        $product_id = $wc_product->get_id();
        $variation = array();
        $em_event = $EM_Booking->get_event();
        $cart_item_data = array(
            'event_places_cost' => $EM_Booking->get_price_pre_taxes(),
            'event_name' => $em_event->event_name,
            'event_slug' => $em_event->event_slug,
            'event_id' => $em_event->event_id,
            'booking_places' => $EM_Booking->get_spaces(),
        );
        WC()->cart->add_to_cart( $product_id, 1, 0, $variation, $cart_item_data );
        // TODO - check if $result is false
    }
    return $save_result;
}
add_filter( 'em_booking_add', 'blz_eventwoo_booking_add', 20, 2 );


function blz_eventwoo_price_to_cart_item( $cart_object ) {  
    if( !WC()->session->__isset( "reload_checkout" )) {
        foreach ( $cart_object->cart_contents as $key => $value ) {
            if( isset( $value["event_places_cost"] ) ) {
                //for woocommerce version lower than 3
                //$value['data']->price = $value["custom_price"];
                //for woocommerce version +3
                $value['data']->set_price($value["event_places_cost"]);
            }
        }  
    }  
}
add_action( 'woocommerce_before_calculate_totals', 'blz_eventwoo_price_to_cart_item', 99 );


// Display custom cart item meta data (in cart and checkout)
function blz_eventwoo_display_cart_item_custom_meta_data( $item_data, $cart_item ) {
    $em_event = em_get_event( $cart_item['event_id'], 'event_id' );
    $permalink = $em_event->get_permalink();
    if ( isset( $cart_item['event_name'] ) ) {
        $item_data[] = array(
            'key'       => 'Event Name',
            'value'     => "<a href='$permalink'>{$cart_item['event_name']}</a>",
        );
    }
    if ( isset( $cart_item['event_id'] ) ) {
        $item_data[] = array(
            'key'       => 'Event ID',
            'value'     => $cart_item['event_id'],
        );
    }
    if ( isset( $cart_item['booking_places'] ) ) {
        $item_data[] = array(
            'key'       => 'Booked Places',
            'value'     => $cart_item['booking_places'],
        );
    }
    return $item_data;
}
add_filter( 'woocommerce_get_item_data', 'blz_eventwoo_display_cart_item_custom_meta_data', 10, 2 );

// Save cart item custom meta as order item meta data and display it everywhere on orders and email notifications.
function blz_eventwoo_save_cart_item_meta_as_order_item_meta( $item, $cart_item_key, $values, $order ) {
    $meta_key = 'PR CODE';
    if ( isset($values['add_size']) && isset($values['add_size'][$meta_key]) ) {
        $item->update_meta_data( $meta_key, $values['add_size'][$meta_key] );
    }
}
add_action( 'woocommerce_checkout_create_order_line_item', 'blz_eventwoo_save_cart_item_meta_as_order_item_meta', 10, 4 );