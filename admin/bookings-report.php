<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Add custom columns to bookings table
 *
 * @param array $cols
 * @param EM_Bookings_table $EM_Bookings_table
 * @return array $cols
 */
function blz_eventwoo_bookings_table_cols( $cols, $EM_Bookings_table ) {
    $cols['coupons_used'] = __('Coupons Used', 'eventwoo');
    $cols['order_total'] = __('Order Total', 'eventwoo');
    return $cols;
}
add_filter( 'em_bookings_table_cols_template', 'blz_eventwoo_bookings_table_cols', 10, 2);


/**
 * Add WC Order and coupon information to the booking table
 *
 * @param string $val
 * @param string $col
 * @param EM_Booking $EM_Booking
 * @param EM_Bookings_table $EM_Bookings_table
 * @param string $format
 * @param object $object
 * @return string
 */
function blz_eventwoo_bookings_report_columns($val, $col, $EM_Booking, $EM_Bookings_table, $format, $object){
    if ( $col == 'coupons_used'){
        $coupons_used = '';
        $order_ids = blz_eventwoo_get_wc_order_ids( $EM_Booking->id );
        foreach ($order_ids as $order_id) {
            $order = new WC_Order( $order_id );
            if ( $order->get_used_coupons() ){
                $coupons_used .= '<ul class="coupons_used">';
                foreach ($order->get_used_coupons() as $coupon_code) {
                    $coupon_post_obj = get_page_by_title($coupon_code, OBJECT, 'shop_coupon');
                    $coupon_id       = $coupon_post_obj->ID;
                    $coupon = new WC_Coupon($coupon_id);
                    $coupon_type = $coupon->get_discount_type();
                    $coupon_amount = $coupon->get_amount();
                    $coupons_used .= "<li>$coupon_code - $coupon_amount $coupon_type</li>"; 
                }
                $coupons_used .= '</ul>';
                $coupons_used .= "Total Discount: " . $order->get_total_discount();
            }
        }
        if ( $format == 'html' ) {
            $val .= $coupons_used;
        }
        if ( $format == 'csv' ){
            $val .= wp_strip_all_tags($coupons_used);
        }
    }
    if ( $col == 'order_total' ){
        $order_total = '';
        $order_ids = blz_eventwoo_get_wc_order_ids( $EM_Booking->id );
        foreach ($order_ids as $order_id) {
            $order = new WC_Order( $order_id );
            $val .= $order->get_total();
        }
    }
    return $val;
}
add_filter( 'em_bookings_table_rows_col', 'blz_eventwoo_bookings_report_columns', 10, 6);



/**
 * Get the WooCommerce order ID from the Event Manager Booking ID
 *
 * @param string $booking_id
 * @return string
 */
function blz_eventwoo_get_wc_order_ids($booking_id){
    global $wpdb;
    $querystr = $wpdb->prepare("
    SELECT $wpdb->posts.ID 
    FROM $wpdb->posts
    INNER JOIN  ".$wpdb->prefix."woocommerce_order_items ON(
        $wpdb->posts.ID =  ".$wpdb->prefix."woocommerce_order_items.order_id
    )
    INNER JOIN  ".$wpdb->prefix."woocommerce_order_itemmeta ON(
        ".$wpdb->prefix."woocommerce_order_items.order_item_id =  ".$wpdb->prefix."woocommerce_order_itemmeta.order_item_id
    )
    WHERE
        1 = 1 AND(
            (
                ".$wpdb->prefix."woocommerce_order_itemmeta.meta_key = 'bookingIDs' AND  ".$wpdb->prefix."woocommerce_order_itemmeta.meta_value LIKE '%$booking_id%'
            )
        ) AND $wpdb->posts.post_type IN('shop_order', 'shop_order_refund') AND(
            (
                $wpdb->posts.post_status = 'wc-processing' OR $wpdb->posts.post_status = 'wc-completed' OR $wpdb->posts.post_status = 'wc-refunded'
            )
        )
        GROUP BY
        $wpdb->posts.ID
    ORDER BY
    $wpdb->posts.post_date
    DESC
    LIMIT 0, 10", []);
    $order_ids = $wpdb->get_results($querystr, OBJECT);
    return $order_ids;
}