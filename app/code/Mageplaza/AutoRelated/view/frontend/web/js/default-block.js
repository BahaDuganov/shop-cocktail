/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_AutoRelated
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

define([
    'jquery',
    'mage/storage',
    'Mageplaza_AutoRelated/js/model/impression',
    'jquery/ui',
    'mageplaza/autorelated_slick'
], function ($, storage, impressionModel) {
    'use strict';

    $.widget('mageplaza.arp_default_block', {
        options: {
            type: '',
            rule_id: '',
            location: '',
            mode: ''
        },
        /**
         * @private
         */
        _create: function () {
            this.initSlider();
            this.initObserver();

            if (this.options.mode == 1) {
                impressionModel.registerRuleImpression(this.options.rule_id);
            }
        },

        /**
         * @return {mageplaza.arp_default_block}
         */
        initSlider: function () {
            if (!this.isSlider()) {
                return this;
            }

            var slidesToShow = 5,
                slidesToScroll = 4,
                arrows = true,
                responsive = [
                    {
                        breakpoint: 1024,
                        settings: {
                            arrows: false,
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 640,
                        settings: {
                            arrows: false,
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    }
                ];
            if (this.options.location.indexOf('sidebar') !== -1) {
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
            } else if (this.options.location.indexOf('cross') !== -1) {
                slidesToShow = 4;
                slidesToScroll = 3;
            }

            this.element.find('ol').slick({
                infinite: true,
                slidesToShow: slidesToShow,
                slidesToScroll: slidesToScroll,
                autoplay: true,
                arrows: arrows,
                autoplaySpeed: 2000,
                responsive: responsive
            });
        },

        /**
         * init click observer
         */
        initObserver: function () {
            var clickEl = this.element.find('a, button'),
                isClick = false;

            if (this.isSlider()) {
                clickEl.draggable({
                    start: function (event, ui) {
                        $(this).addClass('noclick');
                    }
                });
            }

            clickEl.click(function (event) {
                if (isClick) {
                    return;
                }

                if ($(this).hasClass('noclick')) {
                    $(this).removeClass('noclick');
                } else {
                    var id = $(this).parents('.mageplaza-autorelated-block').attr('rule-id');
                    isClick = true;
                    storage.post('autorelated/ajax/click', JSON.stringify({ruleId: id}), false);
                }
            });
        },

        isSlider: function () {
            return this.options.type === 'slider';
        }
    });

    return $.mageplaza.arp_default_block;
});