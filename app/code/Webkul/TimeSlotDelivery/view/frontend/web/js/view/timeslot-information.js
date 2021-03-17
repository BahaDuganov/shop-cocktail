/**
 * Webkul Software
 *
 * @category Webkul
 * @package Webkul_MpTimeDelivery
 * @author Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license https://store.webkul.com/license.html
 */
/*jshint browser:true jquery:true*/
/*global alert*/
define(
    [
        'jquery',
        'uiComponent',
        'Magento_Checkout/js/model/quote',
        'Webkul_TimeSlotDelivery/js/view/admin-time-slots',
        'Magento_Customer/js/customer-data'
    ],
    function ($, Component, quote, adminTimeSlots, customerData) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Webkul_TimeSlotDelivery/timeslot-information'
            },
            initialize: function () {
                this._super();
                this.slotEnabled = window.checkoutConfig.slotEnabled;
            },
            getSlotInfo: function () {
                if ($.isEmptyObject(adminTimeSlots().selectedSlots())) {
                    var slots = customerData.get("selected-slots");
                    return slots();
                }
                return adminTimeSlots().selectedSlots();
            },
            isVisible: function () {
                return !$.isEmptyObject(this.getSlotInfo()) && this.slotEnabled;
            },

        });
    }
);
