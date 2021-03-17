require(['jquery', 'Magento_Checkout/js/model/quote','Magento_Customer/js/model/customer'], function ($, quote, customer) {
    $(window).on('hashchange', function () {
        setPaymentActive();
    });

    $(document).ready(function () {  

		var d = new Date();
		var startTime = '06:00 AM';
		var endTime = '03:00 PM';
		var curr_time = getval();	
		
		if(customer.isLoggedIn())
		{
			if (get24Hr(curr_time) > get24Hr(startTime) && get24Hr(curr_time) < get24Hr(endTime)) {
			  //in between these two times
				//console.log("Yes")
			} else {
				if(d.getDay() == 4){
					dataLayer.push({'event': 'no_timeSlot'});
					//console.log("Yes");
					//console.log(dataLayer);
				}else {
					dataLayer.push({'event': 'no_timeSlot_today'});
				}
				/* if(d.getDay() == 5){
					//console.log('urvesh');
				} */
			}
		}
		
		function get24Hr(time){
		var hours = Number(time.match(/^(\d+)/)[1]);
		var AMPM = time.match(/\s(.*)$/)[1];
		if(AMPM == "PM" && hours<12) hours = hours+12;
		if(AMPM == "AM" && hours==12) hours = hours-12;

		var minutes = Number(time.match(/:(\d+)/)[1]);
		hours = hours*100+minutes;
		//console.log(time +" - "+hours);
		return hours;
		}

		function getval() {
		var currentTime = new Date()
		var hours = currentTime.getHours()
		var minutes = currentTime.getMinutes()

		if (minutes < 10) minutes = "0" + minutes;

		var suffix = "AM";
		if (hours >= 12) {
		suffix = "PM";
		hours = hours - 12;
		}
		if (hours == 0) {
		hours = 12;
		}
		var current_time = hours + ":" + minutes + " " + suffix;

		return current_time;

		}


	
        $(document).on("click", ".checkout__next-1", function () {
			
			if (get24Hr(curr_time) > get24Hr(startTime) && get24Hr(curr_time) < get24Hr(endTime)) {
			  //in between these two times
				//console.log("Yes")
			} else {
				if(d.getDay() == 4){
					dataLayer.push({'event': 'no_timeSlot'});
					//console.log("Yes");
					//console.log(dataLayer);
				} else {
					dataLayer.push({'event': 'no_timeSlot_today'});
				}
				/* if(d.getDay() == 5){
					//console.log('urvesh');
				} */
			}

            if (checkEmail() === false) {
                //alert('sd');
                var err = '<div for="customer-email" generated="true" class="mage-error" id="customer-email-error">Please enter a valid email address (Ex: johndoe@domain.com).</div>';
                $("#customer-email-error").remove();
                //$("#customer-email").next()
                $(err).insertAfter("#customer-email");
                return false;
            }

            if (window.location.hash === "#payment") {
                $(".checkout__progress-bar-item").addClass("_active");
            } else {
                $("#checkoutSteps > li").removeClass("hide");
                $("#checkoutSteps > li:first-child").addClass("hide");
                $(".checkout__progress-bar-item:nth-child(2)").addClass("_active");
            }

        });
		
		var existCondition = setInterval(function() {
		   if ($('.minicart-custom-message').length) {
				var subtotal = quote.totals().subtotal;
				var freeshiipingAmount = "50";
				var percentage = "70";
				var subTotalPercent = parseFloat(freeshiipingAmount)*parseFloat(percentage)/100;
				console.log(subTotalPercent);
				if(parseFloat(subtotal) < parseFloat(freeshiipingAmount) && parseFloat(subtotal) < subTotalPercent)
				{
					var message = "Enjoy free shipping on all orders above $50";
				}
				if(parseFloat(subtotal) < parseFloat(freeshiipingAmount) && parseFloat(subtotal) >= subTotalPercent)
				{
					var remainingAm = parseFloat(freeshiipingAmount) - parseFloat(subtotal);
					var message = "You are only $"+remainingAm.toFixed(2)+" away from free shipping. Keep shopping!";
				}
				if(parseFloat(subtotal) >= parseFloat(freeshiipingAmount))
				{
					var message = "Congratulations! You've earned free shipping";
				}
				clearInterval(existCondition);	
				$(".minicart-custom-message").html(message);
			}
		}, 100);

        $(document).on("click", "#checkout__backToFirstStep", function () {
            $("#checkoutSteps > li").addClass("hide");
            $("#checkoutSteps > li:first-child").removeClass("hide");
            $(".checkout__progress-bar-item").removeClass("_active");
            $(".checkout__progress-bar-item:nth-child(1)").addClass("_active");
        });
    });


    $(window).load(function () {
        setTimeout(function () {
            setPaymentActive();			
			$('#co-shipping-method-form tr:first').trigger('click');
        }, 7000);
    });

    function setPaymentActive() {
        if (window.location.hash == "#payment") {
            $(".checkout__progress-bar-item").addClass("_active");
			$('#cryozonic_stripe').trigger('click');
			if($('#billing-address-same-as-shipping-cryozonic_stripe').prop('checked') == false){
				$('#billing-address-same-as-shipping-cryozonic_stripe').trigger('click');
			}
        }
    }
});

function checkEmail() {

    var email = document.getElementById('customer-email');
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (!filter.test(email.value)) {
        //alert('Please provide a valid email address');
        email.focus;
        return false;
    }

}