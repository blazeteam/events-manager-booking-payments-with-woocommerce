<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Add a login and registration form if user is not logged in.
 * Can't find any suitable hooks we can use in the Event Manager Booking Form so we have to 
 * modify the event string.
 *
 * @param string $event_string
 * @param EM_Event $em_event
 * @param string $format
 * @param string $target
 * @return string $event_string
 */
function blz_eventwoo_registration_form( $event_string, $em_event, $format, $target ){
    if( !is_user_logged_in() && $target == 'html' ){
        if ( strpos( $event_string, get_option( 'dbem_booking_feedback_log_in' ) ) ) {
            // Use the WooCommerce login form as it includes a registration form if the option is enabled.
            ob_start();
            if ( function_exists( 'wc_get_template' ) ){
                wc_get_template( 'myaccount/form-login.php' );
            } else {
                echo __( 'Cart not activated!', 'eventwoo' );
                error_log ( 'Warning - Could not display registration form as template not found, probably WooCommerce isn\'t activated.' );
            }
            $login_form = '<div class="eventwoo_woocommerce_login_form">' . ob_get_clean() . '</div>';
            // Have to regex as no suitable hook
            $re = '/<div.class="em-booking-login.*<\/div>/ms';
            $event_string = preg_replace( $re, $login_form, $event_string );
        }        
    }
    return $event_string;
}
add_filter( 'em_event_output', 'blz_eventwoo_registration_form', 10, 4 );