<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Add cart link to bottom of event page if there is an unpaid booking.
 *
 * @param string $output the output specificied by $target
 * @param EM_Event $em_event
 * @param string $target
 * @return string $output
 */
function blz_eventwoo_cart_link( $output, $em_event, $target ){
    if ( $target == 'html' ){
        // Check if the user has a booking
        $EM_Booking = $em_event->get_bookings()->has_booking();
        $output .= blz_eventwoo_pending_booking_message( $EM_Booking );
    }
    return $output;
}
add_filter( 'em_event_output_single', 'blz_eventwoo_cart_link', 99, 3 );

/**
 * Add cart link to bottom of event page when a booking has just been added by 
 * hooking in to the get option call that fetches the message text.
 *
 * @param string $value - The existing booking message provided by Event Manager.
 * @param [type] $option
 * @return void
 */
function blz_eventwoo_cart_link_booking_added($value, $default){
    $value .= blz_eventwoo_pending_booking_message();
    return $value;
}
add_filter( 'option_dbem_booking_feedback_pending', 'blz_eventwoo_cart_link_booking_added', 99, 2 );
add_filter( 'option_dbem_booking_feedback', 'blz_eventwoo_cart_link_booking_added', 99, 2 );


/**
 * Check the booking status and paid status and generate the message.
 *
 * @param EM_Booking $EM_Booking
 * @return string
 */
function blz_eventwoo_pending_booking_message( $EM_Booking = null ){
    $output = '';
    if ( ! $EM_Booking ){
        global $EM_Booking;
    }
    if ( is_object( $EM_Booking ) ) {
        $unpaid_statuses = array(
            'Pending',
            'Awaiting Online Payment',
            'Awaiting Payment'
        );
        if ( in_array( $EM_Booking->get_status(), $unpaid_statuses ) ){
            $output .= '<p class="pending-booking">';
            $output .= __('You have a pending booking for this event, we have added an event booking item to your shopping basket,', 'blaze-event-woo');
            $cart_url = wc_get_cart_url();
            $output .= "<a href='$cart_url'>";
            $output .= __(' please proceed to the checkout when you are ready.', 'blaze-event-woo');
            $output .= '</a>';
            $output .= '</p>';
        }
    }
    return $output;
}