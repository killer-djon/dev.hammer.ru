jQuery(document).ready(function(){
	
	jQuery('.add_to_cart').click(function(){
	    var formData = jQuery(this).closest('form');
	    var _self = jQuery(this);
	    console.log(formData)
	    jQuery.ajax({
		    url: '/widget/cart/add',
		    type: 'POST',
		    dataType: 'json',
		    data: {
			    id: formData.find('[name=id]').val(),
			    qty: formData.find('[name=qty]').val(),
			    article: formData.find('[name=article]').val(),
			    name: formData.find('[name=name]').val(),
			    price: formData.find('[name=price]').val(),
		    },
		    success: function(response, success)
		    {
			 	if( success )   
			 	{
				 	//jQuery('#cart-total').html(response.result);
				 	get_cart_content();
				 	jQuery.notify({
					 	message: 'Деталь успешно добавлена в корзину',
				 	}, {
					 	placement: {
						 	from: 'bottom',
						 	align: 'left'
					 	},
					 	animate: {
							enter: 'animated fadeInUp',
							exit: 'animated fadeOutDown'
						},
					 	z_index: 1001,
					 	delay: 1000
				 	});
				 	_self.closest('.dropdown').removeClass('open');
			 	}
		    }
	    });
	    
	    return false;
    });
    
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
    
    function removeProductItem(id)
    {
	    jQuery.ajax({
		    url: '/widget/cart/delete',
		    type: 'POST',
		    dataType: 'json',
		    data: {
			    id: id
		    },
		    success: function(response, success)
		    {
			    if( success )
			    {
				    var total = response.cart_data.total;
				    jQuery("#cart-items table").find('tr[data-row="'+id+'"]').remove();
				    //jQuery('#cart-total, #shopping-cart-total-icon, #shopping-cart-total').html(response.result);
				    get_cart_content();
				    
				    jQuery.notify({
					 	message: 'Деталь успешно удалена из корзины',
				 	}, {
					 	placement: {
						 	from: 'top',
						 	align: 'center'
					 	},
					 	animate: {
							enter: 'animated fadeInDown',
							exit: 'animated fadeOutUp'
						},
					 	z_index: 1001,
					 	delay: 1000
				 	});
				 	
				 	jQuery('#removeProduct').modal('hide');
				 	if( total.count == 0 )
				 	{
					 	jQuery('#clear-cart').trigger('click');
				 	}
			    }
		    }
	    });
	    
	    
    }
    
    jQuery('.remove-item').click(function(){
	    var detailData = jQuery(this).closest('tr.row-item-detail');
	    var price = detailData.find('[name=price]').val();
	    
	    jQuery('#removeProduct').find('table span.name').text( detailData.find('[name=name]').val() );
	    jQuery('#removeProduct').find('[name=id]').val( detailData.find('[name=id]').val() );
	    jQuery('#removeProduct').find('table span.article').text( detailData.find('[name=article]').val() );
	    jQuery('#removeProduct').find('table span.price').text( 
			( price == '0,00' ? 'Под заказ' : price+' руб.' )    
	    );
	    
    });
    
    jQuery("#shopping-cart-page").on('click', '.cart-qty', function(){
	    var countVal = jQuery(this).closest('.count-detail').find('[name=qty]');
	    var detailData = jQuery(this).closest('.form-group');
	    var value = (countVal.val()).replace(/([^\d+])/ig, '');
	    
	    
	    if( jQuery(this).hasClass('cart-refresh') )
	    {
		    countVal.val( jQuery(this).closest('.count-detail').prevAll('[name=data-qty]').val() );
	    }
	    
	    refreshRows(detailData.closest('tbody'));
    });
    
    
    
    function refreshRows(tbody)
    {
	    $.each(tbody.find('tr.row-item-detail'), function(key, itemRow){
		    jQuery(itemRow).find('td:first').text( (key+1) );
		    var inputQty = jQuery(itemRow).find('[name=qty]').val();
		    var defaultQty = jQuery(itemRow).find('[name=data-qty]').val();
		    
		    if( inputQty != defaultQty )
		    {
			    jQuery(itemRow).find('td.count-item').addClass('bg-danger');
		    }else
		    {
			    jQuery(itemRow).find('td.count-item').removeClass('bg-danger');
		    }
	    });
    }
    
    jQuery('#clear-cart').click(function(){
	    jQuery.ajax({
		    url: '/widget/cart/clear',
		    type: 'POST',
		    dataType: 'json',
		    success: function(response, success)
		    {
			    if( success )
			    {
				    //jQuery('#cart-total, #shopping-cart-total-icon, #shopping-cart-total').html(response.result);
				    get_cart_content();
			    }
			    
			    location.reload();
		    }
	    });
    });
    
    jQuery('#refresh-cart').click(function(){
	    
	    var formData = jQuery('.cart_content_form');
	    var data = {};
	    
	    formData.find('tr.row-item-detail').each(function(key, itemRow){
		    
		    data[key] = {
			    id: jQuery(itemRow).attr('data-row'),
			    qty: jQuery(itemRow).find('[name=qty]').val(),
		    };
	    });
	    
	    jQuery.ajax({
		    url: '/widget/cart/update',
		    type: 'POST',
		    dataType: 'json',
		    data: data,
		    success: function(response, success)
		    {
			    if( success )
			    {
				    //jQuery('#cart-total, #shopping-cart-total-icon, #shopping-cart-total').html(response.result);
				    get_cart_content();
				    var data = response.cart_data;
				    if( data && data.products )
				    {
					    $.each(data.products, function(key, item){
						    var itemTr = formData.find('tr[data-row="'+key+'"]');
						    var count = parseInt(item.qty);
						    var price = parseFloat(item.price);
						    jQuery(itemTr).find('[name=data-qty]').val(item.qty);
						    jQuery(itemTr).find('.subtotal-item').text( (count*price).toFixed(2).replace(/\./g,',') + ' руб.' );
						    
						    jQuery(itemTr).find('.cart-refresh').trigger('click')
					    });
					    
					    formData.find('.total-count > strong').text(data.total.count);
					    formData.find('.total-cost > strong').text( (data.total.price).toFixed(2).replace(/\./g,',') );
				    }
			    }
		    }
	    });
    });
    
    jQuery('#removeProduct').on('click', '#remove-product', function(){
	    removeProductItem( jQuery('#removeProduct').find('[name="id"]').val() );
	    return false;
    });
    
    refreshRows(jQuery('#cart-items').find('table tbody'));
    
    var shippingMethod = jQuery('select[name="shipping-method"]').val();
    
    activeShippingMethodBlock(shippingMethod);
    
    function activeShippingMethodBlock(shippingMethod)
    {
	    var activeOption = jQuery('select[name="shipping-method"] option[value="'+shippingMethod+'"]');
	    var optionId = activeOption.attr('data-target').substr(1);
	    jQuery('select[name="shipping-method"]').closest('#accordion-shipping').find('.panel-collapse').removeClass('in');
	    jQuery("#"+optionId).addClass('in');
    }
    
    jQuery("#auth-form, #personal-data").submit(function(){
		/*
	    var formData = jQuery("#shipping-method-form").serializeArray();
	    var authFormBlock = jQuery(this);
	    
	    jQuery(this).find('input.shipping').remove();
	    jQuery(formData).each(function(key, item){
		    jQuery(authFormBlock).prepend('<input type="hidden" name="'+item.name+'" value="'+item.value+'">');
	    });
	    */
		var authFormBlock = jQuery(this);
		var selectorShipping = jQuery('[name="shipping-method"]');

		jQuery(this).find('input.shipping').remove();
		jQuery(authFormBlock).prepend('<input type="hidden" name="shipping_method" value="'+ selectorShipping.find('option[value="'+selectorShipping.val()+'"]').text() +'">');

		if( selectorShipping.val() == '2' )
		{
			var formData = jQuery("#shipping-method-form").serializeArray();
			jQuery(formData).each(function(key, item){
				jQuery(authFormBlock).prepend('<input type="hidden" name="'+item.name+'" value="'+item.value+'">');
			});
		}

    });
});