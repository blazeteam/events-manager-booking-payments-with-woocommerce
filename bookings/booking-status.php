<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Set the booking status to Awaiting Online Payment when added.
 *
 * @param boolean $result
 * @param EM_Booking $EM_Booking
 * @return boolean $result
 */
function blz_eventwoo_booking_added_set_status( $result, $EM_Booking){
    // 0 = Pending
    // 1 = Approved
    // 2 = Rejected
    // 3 = Cancelled
    // 4 = Awaiting Online Payment
    // 5 = Awaiting Payment
    $EM_Booking->set_status( 4 );
    return $result;
}
add_action( 'em_bookings_add', 'blz_eventwoo_booking_added_set_status', 10, 2 );

/**
 * Update the booking statuses to approved.
 *
 * @param int $order_id
 * @return void
 */
function blz_eventwoo_order_paid_set_booking_status($order_id){
    blz_eventwoo_order_status_change_set_booking_status($order_id, 1);
}
add_action( 'woocommerce_order_status_completed', 'blz_eventwoo_order_paid_set_booking_status');
add_action( 'woocommerce_order_status_processing', 'blz_eventwoo_order_paid_set_booking_status');


/**
 * Change the booking statuses back to Awaiting Payment if the order is cancelled.
 * This is so that cancelled orders will cause the bookings to be put back into a new cart.
 *
 * @param int $order_id
 * @return void
 */
function blz_eventwoo_order_cancelled_set_booking_status($order_id){
    blz_eventwoo_order_status_change_set_booking_status($order_id, 5);
}
add_action( 'woocommerce_order_status_cancelled', 'blz_eventwoo_order_cancelled_set_booking_status');


/**
 * Update the booking statuses when the order status is changed
 *
 * @param int $order_id
 * @param int $status 0 = Pending, 1 = Approved, 2 = Rejected, 3 = Cancelled, 4 = Awaiting Online Payment, 5 = Awaiting Payment
 * @return void
 */
function blz_eventwoo_order_status_change_set_booking_status($order_id, $status){
    global $woocommerce;
    $order = wc_get_order( $order_id );
    // The loop to get the order items which are WC_Order_Item_Product objects since WC 3+
    foreach( $order->get_items() as $item_id => $item ){
        $product_id = $item->get_product_id();
        $product = $item->get_product();
        $sku = $product->get_sku();
        if ($sku == 'Event Booking') {
            $booking_ids = explode( ',', $item->get_meta( 'bookingIDs') );
            blz_eventwoo_set_bookings( $booking_ids, $status ); // Approved
        }
    }
}


/**
 * Set the status of bookings from the ID's, see above for statuses.
 *
 * @param array $booking_ids
 * @param int $status 0 = Pending, 1 = Approved, 2 = Rejected, 3 = Cancelled, 4 = Awaiting Online Payment, 5 = Awaiting Payment
 * @return boolean Was the change successful
 */
function blz_eventwoo_set_bookings( $booking_ids , $status ){
    foreach ($booking_ids as $booking_id) {
        $em_booking = em_get_booking($booking_id);
        $em_booking->set_status( $status, false );
    }
    return false;
}