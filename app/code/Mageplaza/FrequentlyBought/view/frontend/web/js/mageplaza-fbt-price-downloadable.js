/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_FrequentlyBought
 * @copyright   Copyright (c) 2017 Mageplaza (https://www.mageplaza.com/)
 * @license     http://mageplaza.com/LICENSE.txt
 */

define([
    "jquery",
    "jquery/ui",
    "downloadable"
], function($){
    "use strict";

    $.widget('mageplaza.frequently_bought_downloadable', $.mage.downloadable, {
        /**
         * Reload product price with selected link price included
         * @private
         */
        _reloadPrice: function() {
            var finalPrice = 0;
            var basePrice = 0,
                productPrice = 0,
                parentElement = this.element.closest('li');
            this.element.find(this.options.linkElement + ':checked').each($.proxy(function(index, element) {
                finalPrice += this.options.config.links[$(element).val()].finalPrice;
                basePrice += this.options.config.links[$(element).val()].basePrice;
            }, this));

            productPrice = parseFloat(parentElement.find('.related-checkbox').attr('data-price-amount'));
            parentElement.find('.item-price').attr('data-price-amount', productPrice + finalPrice);
            parentElement.find('.related-checkbox').change();
        }
    });

    return $.mageplaza.frequently_bought_downloadable;
});
