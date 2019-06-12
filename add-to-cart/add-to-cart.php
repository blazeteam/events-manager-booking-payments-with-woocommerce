<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


function blz_eventwoo_booking_add( $save_result, $EM_Booking){
    if ( $save_result ) {
        $wc_product = blz_eventwoo_get_product_by_sku( 'Event Booking' );
        $product_id = $wc_product->get_id();
        $variation = array();
        $cart_item_data = array(
            'event_places_cost' => $EM_Booking->get_price_pre_taxes(),
        );
        $result = WC()->cart->add_to_cart( $product_id, 1, 0, $variation, $cart_item_data );
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