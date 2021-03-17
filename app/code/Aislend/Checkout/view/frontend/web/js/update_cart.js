require(["jquery", 'notifyJS', 'Magento_Customer/js/customer-data'], function($, notifyJS, customerData) {
	$(document).ready(function(){
		$('.cart.item .qty__plus').on('click', function() {			
			$(this).attr('disabled','disabled');			
			$(this).siblings('button.qty__substract').attr('disabled','disabled');
			var post_url = '/checkout/cart/updatePost/';
			var formkey = $('input[name="form_key"]').val();
			var qtyname = $(this).siblings('.cc__qty-input').attr('name');
			var qty = parseFloat($(this).siblings('.cc__qty-input').val());
			var itemType = $(this).siblings('.lbs_status').val();
			qty = (itemType == 1) ? qty + .25 : qty + 1;			
			var sendData = qtyname + '=' + qty + '&type=add&update_cart_action=update_qty&form_key=' + formkey;
			$.ajax({
				url: post_url,
				dataType: 'json',
				type: 'POST',
				data: sendData,
				complete: function(data) {
					var sections = ['cart'];
					customerData.invalidate(sections);
					customerData.reload(sections, true);
					$("#cart-totals").trigger('contentUpdated');
					$('body').trigger('processStop');
					if (data.msg) {
						notifyJS.showMessage(data.status, data.msg, data.status);
					}
					setTimeout(function(){ $('body').trigger('processStart'); window.location = ''; }, 3000);  
				}
			});
		});
		$('.cart.item .qty__minus').on('click', function() {
			$(this).attr('disabled','disabled');
			$(this).siblings('button.qty__add').attr('disabled','disabled');
			var post_url = '/checkout/cart/updatePost/';
			var formkey = $('input[name="form_key"]').val();
			var qtyname = $(this).siblings('.cc__qty-input').attr('name');
			var qty = $(this).siblings('.cc__qty-input').val();
			var itemType = $(this).siblings('.lbs_status').val();
			qty = (itemType == 1) ? qty - .25 : qty -1;			
			var sendData = qtyname + '=' + qty + '&type=deduct&update_cart_action=update_qty&form_key=' + formkey;
			$.ajax({
				url: post_url,
				dataType: 'json',
				type: 'POST',
				data: sendData,
				complete: function(data) {
					var sections = ['cart'];
					customerData.invalidate(sections);
					customerData.reload(sections, true);
					$('body').trigger('processStop');
					if (data.msg) {
						notifyJS.showMessage(data.status, data.msg, data.status);
					}
					setTimeout(function(){ $('body').trigger('processStart'); window.location = ''; }, 3000);
				}
			}); 
		});
	});
});