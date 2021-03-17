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
define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Customer/js/customer-data',
    "jquery/ui"
], function ($, ko, Component, customerData) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Webkul_TimeSlotDelivery/view/admin-time-slots'
        },
        slotCount: ko.observable(0),
        slotEnabled: ko.observable(window.checkoutConfig.slotEnabled),
        selectedSlots: ko.observableArray([]),
        initialize: function () {
            this._super();
            var self = this;
            this.allowedDays = window.checkoutConfig.allowed_days;
            this.isEnabled = window.checkoutConfig.slotEnabled;
            this.slotData = window.checkoutConfig.slotData;
            this.startDate = window.checkoutConfig.start_date;
            this.slots = ko.observableArray([]);
            this.sortedSlots = ko.observableArray([]);
            this.isChecked = ko.observable(false);
            this.currentDate = this.startDate;
            this.maxDays = window.checkoutConfig.max_days;
            this.weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            self.slots.push(this.slotData);

        },
        getSlotData: function () {
            return this.slots;
        },
        getSlotStorage: function (data) {
            if ($.isEmptyObject(this.selectedSlots())) {
                var slots = customerData.get("selected-slots");
                if (!$.isEmptyObject(slots)) {
                    //this.slotCount(1);
                }
            }

        },
        getSortedSlots: function (data) {
            var ordered = {};
            Object.keys(data).sort().forEach(function (key) {
                ordered[key] = data[key];
            });
            return ordered;
        },
        getDate: function (cday) {
            var cDate = new Date(cday);
            var cDay = cDate.getDay();
            var returnDate;
            var check = 0;
            for (var i = 0; i <= this.maxDays; i++) {
                var nDate = new Date(this.currentDate);

                nDate.setDate(nDate.getDate() + check);
                var day = nDate.getDate();
                var month = nDate.getMonth() + 1;
                if (day < 10) {
                    day = "0" + day;
                }
                if (month < 10) {
                    month = "0" + month;
                }

                var d = new Date(nDate.getFullYear() + "-" + month + "-" + day);
                var n = d.getDay();
                if (n == cDay) {
                    returnDate = $.datepicker.formatDate('DD, d MM, yy', new Date(cday))
                    //returnDate = cday +'/'+this.weekdays[n];
                    break;
                }
                check++;
            }

            //this.currentDate = nDate.getFullYear() + "-" + month + "-" + day;
            return returnDate;
        },
        checkDay: function (day, sellerStart) {
            if (sellerStart) {
                var d = new Date(sellerStart);
            } else {
                var d = new Date(this.startDate);
            }
            var requestedDay = new Date(day);
            if (requestedDay >= d) {
                return true;
            }
            return false;
        },
        checkTime: function (time, date) {
            var result = time.split('-');
            var currentTime = new Date().getTime();
            var slotTime = new Date(this._convertDate(date + " " + result[1].replace(' ', ''))).getTime();

            if (currentTime <= slotTime) {
                return true;
            }
            return false;
        },
        _convertDate(date) {
            // # valid js Date and time object format (YYYY-MM-DDTHH:MM:SS)
            var dateTimeParts = date.split(' ');

            // # this assumes time format has NO SPACE between time and AM/PM marks.
            if (dateTimeParts[1].indexOf(' ') == -1 && dateTimeParts[2] === undefined) {
                var theTime = dateTimeParts[1];

                // # strip out all except numbers and colon
                var ampm = theTime.replace(/[0-9:]/g, '');

                // # strip out all except letters (for AM/PM)
                var time = theTime.replace(/[[^a-zA-Z]/g, '');

                if (ampm == 'PM') {
                    time = time.split(':');

                    if (time[0] == 12) {
                        time = parseInt(time[0]) + ':' + time[1] + ':00';
                    } else {
                        time = parseInt(time[0]) + 12 + ':' + time[1] + ':00';
                    }
                } else { // if AM

                    time = time.split(':');

                    if (time[0] < 10) {
                        time = time[0] + ':' + time[1] + ':00';
                    } else {
                        time = time[0] + ':' + time[1] + ':00';
                    }
                }
            }
            var date = new Date(dateTimeParts[0] + 'T' + time);

            return date;
        },
        checkIsSlotsAvailable: function () {

        },
        refreshVars: function () {
            this.currentDate = this.startDate;
        },
        generateClass: function (name) {
            return name.replace(/\s+/g, '-').toLowerCase();
        },
        generateId: function (date, id) {
            var data = this.getDate(date).replace(/\s+/g, '-');
            return data.replace(',', '_').toLowerCase() + '_' + id;
        },
        isSelected: function (model, seller, data, event) {
            if ($(event.currentTarget).hasClass('disabled') == false) {
                var elem = event.currentTarget;
                $('.slot').removeClass('selected');
                $(event.currentTarget).addClass('selected');
            }


        },
        selectTimeSlot: function (model, slot, data, event) {
            var oldslotGroup = 0;
            $(".selected-slots").remove();
            var elem = event.target || event.srcElement || event.currentTarget;
            if (typeof elem !== 'undefined') {
                $('#' + elem.id + '_time').val(elem.getAttribute('value'));
                $('#' + elem.id + '_date').val(elem.getAttribute('data-date'));
                var selected = {
                    'slot_time': elem.getAttribute('value'),
                    'date': elem.getAttribute('data-date'),
                    'slot_id': elem.id,
                    'slot_group': data.slot_group
                };
                model.selectedSlots(selected);
                model.slotCount(1);
            }

            customerData.set("selected-slots", model.selectedSlots());
            model.isChecked(true);
            $('#co-shipping-method-form').append("<input class='selected-slots' type='hidden' name='slot_data' value='" + JSON.stringify(model.selectedSlots()) + "'/>");
            return true;
        }
    })
});
