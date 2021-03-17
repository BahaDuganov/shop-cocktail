define([
    'jquery',
    'ko',
    'uiComponent',
    'mage/url',
    'mage/storage',
    'Aislend_Recipe/js/action/save-customer',
    'Aislend_Recipe/js/action/product',
], function ($, ko, Component, urlBuilder, storage, saveAction, productAction) {
    'use strict';

    var getMoreList = ko.observableArray([]);
    var getProductData = ko.observableArray([]);

    return Component.extend({

        defaults: {
            template: 'Aislend_Recipe/recipe-alternate',
        },

        initialize: function () {
            this._super();

            this.getTotalProduct();
            this.productList = ko.observableArray([]);
        },

        getIngredientsIds: function () {
            return this.ingredientsIds;
        },

        getProduct: function () {
            $('body').trigger('processStart');

            var self = this;
            var serviceUrl = urlBuilder.build('/aislendRecipe/recipe/product?ingredients=' + ingredients);

            return storage.post(serviceUrl, '')
                .done(
                    function (response) {
                        var data = JSON.parse(response);

                        for(var i = 0; i < data.length; i++) {
							if(!data[i].selectedProduct.status){
								$('#ajax-info-action').removeClass('hidden');
								$('#ajax-info-action').attr('disabled','disabled');
								$('.ingredient-add').removeClass('hidden');
							}
                            $('body').trigger('processStop');
                            self.productList.push(data[i]);                           
                        }                        
                    }
                ).fail(
                    function (response) {
                        $('body').trigger('processStop');
                    }
                );
        },

        getTotalProduct: function () {
            return this.getProduct();
        },


        getText: function () {
            var ingredietnsId = this.ingredientsID;
            saveAction(getMoreList, ingredietnsId).always(function () {
            });
        },

        getMoreListData: function () {
            return getMoreList;
        },

        changeProductRequest: function () {
            var self = this;            
			var rowId = this.selectedProduct.ingredients;
			rowId = rowId.toLowerCase().replace(/\s/g, '-');
			$('.recipe-content #custom-component ul.ingredient__body li#'+rowId).find('.ingredient__product-name').html(this.selectedProduct.name);
			$('.recipe-content #custom-component ul.ingredient__body li#'+rowId).find('.ingredient__price').html(this.selectedProduct.price);
			$('.recipe-content #custom-component ul.ingredient__body li#'+rowId).find('.checkbox').val(this.selectedProduct.productId);
			$('.recipe-content #custom-component ul.ingredient__body li#'+rowId).find('.ingredient__product-content a').attr('href',this.selectedProduct.productUrl);
			$('.recipe-content #custom-component ul.ingredient__body li#'+rowId).find('.ingredient__product-image img').attr('src',this.selectedProduct.src);			
			$('.recipe-content #custom-component ul.ingredient__body li#'+rowId).find('.ingredient__body-quantity input[type=number]').attr('name','qty_'+this.selectedProduct.productId);			
			$('.recipe-content #custom-component ul.ingredient__body li#'+rowId).find('input#'+this.selectedProduct.checkboxId).attr('price',this.selectedProduct.price_check);	
			var price = 0;
			$('input[type="checkbox"]').each(function(){
                if ($(this).is(':checked')) {
					var getPrice = $(this).attr('price');					
                    price = price + parseFloat(getPrice);
                }				
			});
			if(price > 0)
			{				
				$('.ingredents-add-button').html('+ Add Selected Ingredients to Cart USD'+price.toFixed(2));
			}
        }
    });
});