define(
    [
        'jquery',
        'underscore',
        'uiComponent',
        'Amasty_Checkout/js/view/utils',
        'Amasty_Checkout/js/action/update-delivery',
        'Amasty_Checkout/js/model/delivery',
        'Magento_Checkout/js/model/payment/additional-validators',
        'Amasty_Checkout/js/view/checkout/datepicker'
    ],
    function (
        $,
        _,
        Component,
        viewUtils,
        updateAction,
        deliveryService,
        paymentValidatorRegistry
    ) {
        'use strict';
        var dd = new Date();
        var today =  ('0' + (dd.getMonth()+1)).slice(-2) + '/' + ('0' + dd.getDate()).slice(-2) + '/' + dd.getFullYear() ; 
        
        function timeCheckOnLoad() {
            var interval = setInterval(()=>{
                if(($('select[name="time"]')) && ($('input[name="date"]').val())){
                    let ddn = new Date();
                   
                    let todayN =  ('0' + (ddn.getMonth()+1)).slice(-2) + '/' + ('0' + ddn.getDate()).slice(-2) + '/' + ddn.getFullYear() ;
                    let  sdateN = $('input[name="date"]').val();
                    
                    if(todayN === sdateN){
                        timeCheck();
                    }
                    clearInterval(interval);
                }
            }, 1000);
        }
    
        $(document).on('change',"[name='date']",function(){
            if(today === $(this).val()){
               timeCheck();
            } else {
                $('select[name="time"] > option').each(function() {
                    $(this).attr('disabled', false) ; 
                });
            }
        });
        function timeCheck() {
             let cd = new Date();
             var av=0 ;
                $('select[name="time"] > option').each(function() {
                    if(this.value != '-1'){
                        let time = (this.value).split('-');
                        if((cd.getHours() + 2) < (timeConversion($.trim(time[0])))){
                            $(this).attr('disabled', false) ; 
                            if((this.value) ===  ($('select[name="time"]').val())){ av++ ; }
                        } else {
                            $(this).attr('disabled', true) ; 
                        }
                    }
                });
                if(av === 0 ){
                    $('select[name="time"]').val('');        
                }
        } 
        function timeConversion(s) {
            let hour = parseInt(s.substring(0,2));
            hour = s.indexOf('AM') > - 1 && hour === 12 ? '00' : hour;
            hour = s.indexOf('PM') > - 1 && hour !== 12 ? hour + 12 : hour;
            return hour ;
        } 
       

        return Component.extend({
            defaults: {
                template: 'Amasty_Checkout/checkout/delivery_date',
                listens: {
                    'update': 'update'
                }
            },
            isLoading: deliveryService.isLoading,
            _requiredFieldSelector: '.amcheckout-delivery-date .field._required :input:not(:button)',

            /**
             * initialize
             */
            initialize: function () {
                this._super();
                var self = this,
                    validator = {
                        validate: self.validate.bind(self)
                    };
                paymentValidatorRegistry.registerValidator(validator);
                timeCheckOnLoad();
            },

            update: function () {
                if (this.validate()) {
                    var data = this.source.get('amcheckoutDelivery');
                    updateAction(data);
                }
            },

            validate: function () {
                this.source.set('params.invalid', false);
                this.source.trigger('amcheckoutDelivery.data.validate');
                if (this.source.get('params.invalid')) {
                    return false;
                }

                var validationResult = true;
                this.elems().forEach(function (item) {
                    if (item.validate().valid == false) {
                        validationResult = false;
                        return false;
                    }
                });
                return validationResult;
            },

            getDeliveryDateName: function () {
                return viewUtils.getBlockTitle('delivery');
            }

        });
    }
);