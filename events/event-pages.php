<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Disable the spaces drop downs on the Event page is the option is selected and the user is not logged in.
 *
 * @param string $select_html
 * @param bool $zero_value
 * @param int $default_value
 * @param EM_Ticket $em_ticket
 * @return void
 */
function blz_eventwoo_disable_spaces( $select_html, $zero_value, $default_value, $em_ticket ){
    if ( get_option( 'blz_eventwoo_disable_spaces_if_logged_out' ) == 'yes' ) {
        if ( ! is_user_logged_in() ) {
            $re = '/class="em-ticket-select"/m';
            $select_html = preg_replace( $re, ' class="em-ticket-select" disabled ', $select_html );
        }
    }
    return $select_html;
}
add_filter( 'em_ticket_get_spaces_options', 'blz_eventwoo_disable_spaces', 10, 4 );