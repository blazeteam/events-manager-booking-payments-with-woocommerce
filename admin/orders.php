<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Auto Complete all WooCommerce orders.
 */
add_action( 'woocommerce_thankyou', 'custom_woocommerce_auto_complete_order' );
function custom_woocommerce_auto_complete_order( $order_id ) { 
    if ( ! $order_id ) {
        return;
    }
    if ( get_option( 'blz_eventwoo_set_event_orders_completed' ) == 'yes' ){
        $order = wc_get_order( $order_id );
        $order->update_status( 'completed' );
    }
}