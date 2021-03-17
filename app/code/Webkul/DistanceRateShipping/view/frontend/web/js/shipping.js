
/**
 * Webkul Software
 *
 * @category    Webkul
 * @package     Webkul_DistanceRateShipping
 * @author      Webkul
 * @copyright   Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license     https://store.webkul.com/license.html
 */ 
/*jshint jquery:true*/
 define([
 "jquery",
 'mage/translate',
 'Magento_Ui/js/modal/alert',
 "jquery/ui",
 ], function ($, $t , alert) {
    'use strict';
    $.widget(
    'wkdrs.shipping',
    {
        _create: function () {
            var option = this.options;
            var place = '';
            if($('.product-info-main .product-add-form').length) {
                $('.product-info-main .product-add-form').after($('#wkdrs-estimate-container'))
            } else {
                $('.product-info-main').append($('#wkdrs-estimate-container'));
            }
            $('#wkdrs-estimate-container').show();
            var autocomplete = new google.maps.places.Autocomplete($("#wkdrs-address")[0], {});
            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                place = autocomplete.getPlace();
            });
            var storage = JSON.parse(localStorage.getItem("wkDistanceRateShip"));
            if(storage){
                var formatedAddress = storage[2];
                $("#wkdrs-address").val(formatedAddress);
            }
            $('#wkdrs-calculate').click(function (event) {
                var lat = '';
                var long = '';
                if((place != undefined) && (place != '')){
                    lat = place.geometry.location.lat().toFixed(5);
                    long = place.geometry.location.lng().toFixed(5);
                    var storageData = [lat,long,place.formatted_address];
                    localStorage.setItem("wkDistanceRateShip", JSON.stringify(storageData));
                
                }
                var storage = JSON.parse(localStorage.getItem("wkDistanceRateShip"));
                var productId = option.productid;
                var addressFormate = storage[2];
                lat = storage[0];
                long = storage[1];
                $.ajax({
                    url     :   option.estimateurl,
                    type    :   "POST",
                    data : {'lat':lat,'long':long,'productId':productId,'address':addressFormate},
                    async:true,
                    beforeSend: function() {
                        $('#wkdrs-calculate span').text($t('Calculating'));
                        $('#wkdrs-calculate').attr('disabled','disabled');
                    },
                    success :   function (result) {
                        var htmlData = '<div>'+result.showmsg+'</div>';
                        $('#wkdrs-shippingCost').html(htmlData);
                    },
                    complete: function() {
                        $('#wkdrs-calculate span').text($t('Calculate'));
                        $('#wkdrs-calculate').removeAttr('disabled');
                    }
                });
                
            });
        }
    });
    return $.wkdrs.shipping;
});
