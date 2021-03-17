define([
  'jquery',
  'Magento_Ui/js/modal/modal',
  'Magento_Ui/js/modal/alert',
  'Magento_Ui/js/lib/spinner',
  'jquery/ui',
  'mage/dropdown',
  "domReady!"
],
function($, modal, alert, loader) {

    var registry = {
        data: [],
        set: function (key, value) {
            this.data[key] = value;
        },
        get: function (key) {
            return this.data[key];
        }
    };

    function guestnotify(fmdata, drp)
    {
        var form = $(drp).find('form');
        if($(form).validation() && $(form).validation('isValid')){
            fmdata.data.email = $(form).find('input[type=email]').val();

            $.ajax({
                url: fmdata.action,
                dataType: 'json',
                method: 'POST',
                data: fmdata.data,
                showLoader: true
            }).done(function (data) {
                $(drp).dropdownDialog("close");

				alert({
                    title: data.status?'Success':'Error',
					modalClass: 'modal__small',
                    content: data.msg
                });

                $(form).find('input[type=email]').val('');
                loader.get(this.name).hide();
            }).fail(function (jqXHR, textStatus) {
                $(drp).dropdownDialog("close");
                if (window.console) {
                    console.log(textStatus);
                }
                $(form).find('input[type=email]').val('');
                alert({content: "Sorry there was an error processing. Please try later."});
                loader.get(this.name).hide();
            });
        }


    }

    function createDropDown(trg, formdata)
    {
        var trigger = $(trg);
        var pid = formdata.data.id;
        var dm = $('#aislend-alert-container').children().clone(false);

        $(dm).dropdownDialog({
            triggerTarget: $(trg),
            appendTo: $(trg).parent(),
            //timeout: "5000",
            closeOnMouseLeave: false,
            closeOnClickOutside: false,
            triggerClass:"active",
            parentClass:"active",
            buttons: [
                {
                    'class': "action primary out-notify btn-notify-me",
                    'text': $.mage.__("Notify Me"),
                    'click': function () {

                        // Check form validity
                        var form = $(dm).find('form');
                        if($(form).validation() && $(form).validation('isValid')) {
                            guestnotify(formdata, dm);

                        } else {

                            // Temporary solution: fake method to stop notify me box from closing
                            $(dm).dropdownDialog('show');
                        }
                    }
                }
            ]
        });

        // Fake click
        if(trigger.is("a")) {
            trigger.trigger("click");
        }
    }

    function notLoggedIn()
    {
        var self = this;

        if($(this).is("a")) {
            var data_string = $(self).attr('data-alert');

        } else {
            var data_string = $(self).parents(".aislend-notify").find("a").attr('data-alert');
        }

        if(data_string !== ''){
            var data_alert = JSON.parse(data_string);

            if(data_alert.action && data_alert.data && data_alert.data.id){
                createDropDown(self, data_alert);
            } else{
                alert({content: "Sorry this product is not on alert list"});
            }
        }

        /*
        $('body .out-notify').each(function(){
            var self = this;
            var data_string = $(self).attr('data-alert');
            if(data_string !== ''){
                var data_alert = JSON.parse(data_string);
                if(data_alert.action && data_alert.data && data_alert.data.id){
                    createDropDown(self, data_alert);
                } else{
                    alert({content: "Sorry this product is not on alert list"});
                }
            }
        });
        */
    }

    function loggedIn()
    {
        var data_string = $(this).attr('data-alert');
        if(data_string !== ''){
            var data_alert = JSON.parse(data_string);
            if(data_alert.action && data_alert.data){
                $.ajax({
                    url: data_alert.action,
                    dataType: 'json',
                    method: 'POST',
                    data: data_alert.data,
                    showLoader: true
                }).done(function (data) {

					alert({
						title: data.status?'Success':'Error',
						modalClass: 'modal__small',
						content: data.msg
                    });

                    //setTimeout(function(){ self.closeModal(); }, 10000);

                }).fail(function (jqXHR, textStatus) {
                    if (window.console) {
                        console.log(textStatus);
                        alert({content: "Sorry there was an error processing. Please try later."});
                    }
                    location.reload();
                });
            }
        }

        return false;
    }

    return function (config) {
        if($('body .out-notify').length){
            if(config.loggedIn){
                $('body').on('click','.out-notify', loggedIn);
            } else{
                $('body').on('click','.out-notify', notLoggedIn);
                // notLoggedIn();
            }
        }
    };
});