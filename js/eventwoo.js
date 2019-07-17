jQuery(window).load(function(){
    triggerCartReload();
});


function triggerCartReload(){
    jQuery('#em-booking-submit').click(function(){
        // Update Mini Cart
        jQuery.post(
            woocommerce_params.ajax_url,
            {'action': 'eventwoo_update_mini_cart'},
            function(response) {
                // TODO : Need to find css classes that work across all themes - this works on Arts Taunton but not on StoreFront
                jQuery('.mini_cart').html(response);
                // jQuery('.woocommerce-mini-cart').html(response);
                setTimeout(function(){
                    // Update the price next to the basket button
                    const priceHTML = jQuery('.mini_cart .woocommerce-Price-amount').html();
                    jQuery('.cart-customlocation .woocommerce-Price-amount').html(priceHTML);
                    jQuery('.cart-contents .woocommerce-Price-amount').html(priceHTML);
                }, 100);
            }
        );
    });
}

