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
                // Using the child as selector to avoid problems with the mini-cart class changing for some themes.
                var miniCartChildSelector = '.woocommerce-mini-cart';
                if ( jQuery('.woocommerce-mini-cart__empty-message').length > 0 ){
                    miniCartChildSelector = '.woocommerce-mini-cart__empty-message';
                }
                jQuery(miniCartChildSelector).parent().html(response);
                setTimeout(function(){
                    // Update the price next to the basket button but we need to check if the mini cart class has changed again
                    var miniCartChildSelector = '.woocommerce-mini-cart';
                    if ( jQuery('.woocommerce-mini-cart__empty-message').length > 0 ){
                        miniCartChildSelector = '.woocommerce-mini-cart__empty-message';
                    }
                    const priceHTML = jQuery(miniCartChildSelector).find('.woocommerce-Price-amount').html();
                    jQuery('.woocommerce-Price-amount').html(priceHTML);
                    // jQuery('.woocommerce-Price-amount').html(priceHTML);
                }, 100);
            }
        );
    });
}

