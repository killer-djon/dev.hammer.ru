jQuery(document).ready(function(){


    function get_cart_content()
    {
        jQuery.ajax({
            url: '/widget/cart/content',
            type: 'POST',
            dataType: 'json',
            success: function(response, success)
            {
                if( success )
                {
                    jQuery('#cart-total, #shopping-cart-total-icon, #shopping-cart-total').html(response.result);
                }
            }
        });
    }

    get_cart_content();
});