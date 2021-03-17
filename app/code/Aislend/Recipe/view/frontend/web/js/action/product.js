/*global define,alert*/
define(
    [
        'ko',
        'jquery',
        'mage/storage',
        'mage/translate',
    ],
    function (
        ko,
        $,
        storage,
        $t
    ) {
        'use strict';
        return function (getProductData, productid) {
            return storage.post(
                '/aislendRecipe/recipe/moreoption?product='+productid,
                '',
                false
            ).done(
                function (response) {
                    if (response) {
						var responseData =  $.parseJSON(response);						
                        getProductData = responseData;
                        /* $.each(responseData, function (i, v) {							
                            getProductData.push(v);
                        }); */
                    }
                }
            ).fail(
                function (response) {
                }
            );
        };
    }
);