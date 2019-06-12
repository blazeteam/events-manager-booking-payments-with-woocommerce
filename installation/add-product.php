<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( !class_exists( 'BLZ_EventWoo_Init_Product' ) ){
    class BLZ_EventWoo_Init_Product
    {
        static function init_product()
        {
            // TODO - Check if product is already installed.
            $objProduct = new WC_Product();

            $objProduct->set_name("Product Title");
            $objProduct->set_status("publish");  // can be publish,draft or any wordpress post status
            $objProduct->set_catalog_visibility('visible'); // add the product visibility status
            $objProduct->set_description("Event Booking");
            $objProduct->set_sku("Event Booking"); //can be blank in case you don't have sku, but You can't add duplicate sku's
            $objProduct->set_price(0.00); // set product price
            $objProduct->set_regular_price(0.00); // set product regular price
            $objProduct->set_manage_stock(false); // true or false
            $objProduct->set_stock_quantity();
            $objProduct->set_stock_status('instock'); // in stock or out of stock value
            $objProduct->set_backorders('no');
            $objProduct->set_reviews_allowed(false);
            $objProduct->set_sold_individually(false);
            $objProduct->set_category_ids(array(1,2,3)); // array of category ids, You can get category id from WooCommerce Product Category Section of Wordpress Admin

            $product_id = $objProduct->save(); // it will save the product and return the generated product id
            ?>
            <div class="notice notice-success is-dismissible">
                <p>
                    <?php _e( 'WooCommerce Product for Event Bookings has been created with product ID ' . $product_id . '.', 'blaze-event-woo' ); ?>
                </p>
            </div>
            <?php            
        }
    }
}

register_activation_hook( __FILE__, array('BLZ_EventWoo_Init_Product', 'init_product') );



