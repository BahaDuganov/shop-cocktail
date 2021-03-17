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
 * @package     Mageplaza_AutoRelated
 * @copyright   Copyright (c) 2017 Mageplaza (https://www.mageplaza.com/)
 * @license     http://mageplaza.com/LICENSE.txt
 */

define([
    'jquery',
    'jquery/ui',
    'mageplaza/autorelated_slick'
], function ($) {
    'use strict';

    $.widget('mageplaza.autorelated_block', {
        options: {
            ajaxData: {},
            blockClass: '.mageplaza-autorelated-block'
        },
        _create: function () {
            if (this.element.length > 0) {
                this.click = false;
                this._loadAjax();
            }
        },

        _bind: function ($this) {
            var slidesToShow = 4,
                slidesToScroll = 3,
                arrows = true,
                responsive = [
                    {
                        breakpoint: 1024,
                        settings: {
                            arrows: arrows,
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 640,
                        settings: {
                            arrows: arrows,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    }
                ];
            if ($this.attr('id') === 'mageplaza-autorelated-block-before-sidebar' || $this.attr('id') === 'mageplaza-autorelated-block-after-sidebar') {
                arrows = false;
                slidesToShow = 1;
                slidesToScroll = 1;
                responsive = [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 640,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    }
                ];
            }
            if ($this.attr('id') === 'mageplaza-autorelated-block-before-cross' || $this.attr('id') === 'mageplaza-autorelated-block-after-cross') {
                slidesToShow = 4;
                slidesToScroll = 3;
            }
            $this.find('.mageplaza-autorelated-slider ol').slick({
                infinite: false,
                slidesToShow: slidesToShow,
                slidesToScroll: slidesToScroll,
                autoplay: false,
                arrows: arrows,
                autoplaySpeed: 2000,
                responsive: responsive
            });
        },

        _loadAjax: function () {
            var _this = this,
                ruleIds = '';
            if (this.options.ajaxData.originalRequest.cms) {
                $('.mageplaza-autorelated-block').each(function () {
                    var ruleId = parseInt($(this).attr('data-rule-id'));
                    ruleIds += ruleId + ',';
                });
                this.options.ajaxData.originalRequest.ruleIds = ruleIds;
            }
            $.ajax({
                url: this.options.ajaxData.url,
                data: this.options.ajaxData.originalRequest,
                dataType: 'json',
                cache: false,
                success: function (result) {
                    if (result.status) {
                        var obj = result.data;
                        for (var key in obj) {
                            if (obj.hasOwnProperty(key)) {
                                if (obj[key].id == 'replace-related') {
                                    $('#mageplaza-autorelated-block-after-related').prev().remove();
                                    obj[key].id = 'after-related';
                                } else if (obj[key].id == 'replace-upsell') {
                                    $('#mageplaza-autorelated-block-after-upsell').prev().remove();
                                    obj[key].id = 'after-upsell';
                                } else if (obj[key].id == 'replace-cross') {
                                    $('#mageplaza-autorelated-block-after-cross').prev().remove();
                                    obj[key].id = 'after-cross';
                                }
                                $('#mageplaza-autorelated-block-' + obj[key].id).empty().append(obj[key].content);
                                _this._bind($('#mageplaza-autorelated-block-' + obj[key].id));
                                $('#mageplaza-autorelated-block-' + obj[key].id).trigger('contentUpdated');
                            }
                        }
                        _this._EventListener();
                    } else {
                        $(_this.options.blockClass).empty();
                    }
                }
            });
        },

        _EventListener: function () {
            var _this = this;
            $('.products-mageplaza-autorelated ol a, .products-mageplaza-autorelated ol button.mageplaza-autorelated-button').click(function (event) {
                if (!_this.click) {
                    _this.click = true;
                    var ruleId = $(this).closest('ol.product-items').attr('data-rule-id');
                    $.ajax({
                        url: _this.options.ajaxData.urlClick,
                        data: {ruleId: ruleId}
                    });
                }
            });
        }
    });

    return $.mageplaza.autorelated_block;
});