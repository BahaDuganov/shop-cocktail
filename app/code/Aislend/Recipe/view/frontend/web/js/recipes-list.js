define([
    "jquery"
], function($) {
    "use strict";
    $.widget('umesh.ajax', {
        options: {
            url: '/aislendRecipe/recipe/recipeIngredients',
            method: 'post',
            triggerEvent: 'click'
        },

        _create: function() {
            this._bind();
        },

        _bind: function() {
            var self = this;
            self.element.on(self.options.triggerEvent, function() {
                self._ajaxSubmit();
            });
        },

        _ajaxSubmit: function() {
            var productIds = [];
			var productQty = [];
            $('input[type="checkbox"]').each(function(){
                if ($(this).is(':checked')) {
                    var ids = $(this).val();
					var qty = $('input[name=qty_'+ids+']').val();					
                    productIds.push(ids);
                    productQty.push(qty);
                }
            });
            if(productIds.length == 0)
            {
                alert('Please select atleast one product');
                return false;
            }

            var self = this;
            $.ajax({
                url: self.options.url,
                type: self.options.method,
                dataType: 'json',
                data: {'product':productIds,'qty':productQty},
                beforeSend: function() {
                    $('body').trigger('processStart');
                },
                success: function(res) {
                    setTimeout(function() {
                        $('body').trigger('processStop');
                        location.reload();
                    }, 5000);

                }
            });
        },

    });

    return $.umesh.ajax;
});