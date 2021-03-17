define([
    'jquery'
], function ($) {
    'use strict';

    return function (widget) {

        $.widget('mage.SwatchRenderer', widget, {
            _init: function () {
                this._super();
                return this._defaultSelect();
            },

            _defaultSelect: function () {
                var productId = this.options.jsonConfig.productId.trim();
                if($('.product').find('div').hasClass('swatch-opt-'+productId) || $('.product-options-wrapper').find('div').hasClass('swatch-opt'))
                {
                    var objectLength = Object.keys(this.options.jsonConfig.attributes).length;
                    $.each(this.options.jsonConfig.attributes, function (i, elem) {
                        $.each(elem, function (key, val) {
                            if(key == 'code')
                            {
                                $('.product-item .swatch-opt-'+productId+' .'+ val +' .swatch-attribute-options div.swatch-option').first().click();
                                $('.product-options-wrapper .swatch-opt .'+ val +' .swatch-attribute-options div.swatch-option').first().click();
                            }
                        });
                    });
                }
                this._getPriceUpdate(productId);
                return this.options.jsonConfig.attributes;
            },

            _getPriceUpdate: function (param)
            {
                if($('.product').find('div').hasClass('swatch-opt-'+param))
                {
                    var priceBoxes = $('[data-product-id=' + param + ']');
                    var dataPriceBoxSelector = '[data-role=priceBox]',
                        dataProductIdSelector = '[data-product-id=' + param + ']',
                        priceBoxes = $(dataPriceBoxSelector + dataProductIdSelector);

                    priceBoxes = priceBoxes.filter(function (index, elem) {
                        return !$(elem).find('.price-from').length;
                    });
                    var priceBox = priceBoxes.priceBox({'priceConfig': this.options.jsonConfig});
                    this._UpdatePrice();
                    return ;
                }
                else
                {
                    return;
                }
            }

        });

        return $.mage.SwatchRenderer;
    }
});