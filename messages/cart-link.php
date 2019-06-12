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
        // Check if the user has a pending, unpaid booking
        $EM_Booking = $em_event->get_bookings()->has_booking();
        // TODO - Add unpaid check
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
            $output .= '<pre>';
            $output .= $EM_Booking->get_status();
            $output .= '</pre>';
        }
    }
    // error_log ( print_r ( $em_event, true ) );
    // error_log ( print_r ( $target, true ) );
    return $output;
}
add_filter( 'em_event_output_single', 'blz_eventwoo_cart_link', 20, 3 );