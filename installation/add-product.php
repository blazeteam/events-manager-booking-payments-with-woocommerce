<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Create the WooCommerce product that we'll be using for the cart items.
 *
 * @return void
 */
function blz_eventwoo_init_product(){
    $activate_plugin = get_option( 'Activated_Blaze_EventWoo_Plugin' );
    if ( is_admin() && get_option( 'Activated_Blaze_EventWoo_Plugin' ) == 'Blaze_Event_Woo' ) {
        // Check if product is already installed.
        if ( blz_eventwoo_get_product_by_sku( 'Event Booking' ) ) {
            $product_id = 'Event Booking';
            ?>
            <div class="notice notice-success is-dismissible">
                <p>
                    <?php _e( 'WooCommerce Product for Event Bookings has already been created with product SKU - <strong>' . $product_id . '</strong>.', 'blaze-event-woo' ); ?>
                </p>
            </div>
            <?php            
        } else {
            $objProduct = new WC_Product();
            $objProduct->set_name("Event Booking");
            $objProduct->set_status("publish");  // can be publish,draft or any wordpress post status
            $objProduct->set_catalog_visibility('hidden'); // add the product visibility status
            $objProduct->set_description("Event Booking");
            $objProduct->set_sku("Event Booking"); //Our key 
            $objProduct->set_price(0.00); // set product price
            $objProduct->set_regular_price(0.00); // set product regular price
            $objProduct->set_manage_stock(false); // true or false
            $objProduct->set_stock_status('instock'); // in stock or out of stock value
            $objProduct->set_backorders('no');
            $objProduct->set_reviews_allowed(false);
            $objProduct->set_sold_individually(false); // Remove the ability to change the quantity
            $objProduct->set_category_ids(array()); // array of category ids, You can get category id from WooCommerce Product Category Section of Wordpress Admin
            
            $product_id = $objProduct->save(); // it will save the product and return the generated product id
            ?>
            <div class="notice notice-success is-dismissible">
                <p>
                    <?php _e( 'WooCommerce Product for Event Bookings has been created with product ID - <strong>' . $product_id . '</strong>.', 'blaze-event-woo' ); ?>
                </p>
            </div>
            <?php            
        }
        delete_option('Activated_Blaze_EventWoo_Plugin');
    }
}
add_action( 'admin_init', 'blz_eventwoo_init_product' );

/**
 * Get the WooCommerce product from the Sku.
 *
 * @param string $sku The product sku
 * @return WC_Product|null A WooCommerce product object or null if not found
 */
function blz_eventwoo_get_product_by_sku( $sku ) {
    global $wpdb;
    $product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $sku ) );
    if ( $product_id ) return new WC_Product( $product_id );
    return null;
}
