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
        return function (getMoreList, ingredietnsId) {
            return storage.post(
                '/aislendRecipe/recipe/moreoption?ingredients='+ingredietnsId,
                '',
                false
            ).done(
                function (response) {
                    if (response) {
						var responseData =  $.parseJSON(response);
                        getMoreList([]);
                        $.each(responseData, function (i, v) {							
                            getMoreList.push(v);
                        });
                    }
                }
            ).fail(
                function (response) {
                }
            );
        };
    }
);