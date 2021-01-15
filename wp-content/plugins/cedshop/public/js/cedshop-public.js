(function( $ ) {
	'use strict';
	$(document).ready(function() {
		$('.success').show().fadeOut(5000);

		$("#checkout").click(function(event) {
			var boolVar = false;
			var name    = $('#name').val();
			if (name != "") {
				var nameRegex = /^([a-zA-Z]+\s?)*$/;
				if (!name.match(nameRegex)) {
					$('.nameErr').html("Only alphabetic Character and single space are allowed").css("color","red");
					$('html, body').animate({
						scrollTop: parseInt($("#name").offset().top)
					}, 2000);
					boolVar = true;
					return false;
				} else {
					$('.nameErr').html("");
				}
			}
			var email = $('#email').val();
			//alert(email);
			if (email != "") {
				var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
				if (!email.match(emailRegex)) {
					$('.emailErr').html("Please enter valid email").css("color","red");
					boolVar = true;
					$('html, body').animate({
						scrollTop: parseInt($("#email").offset().top)
					}, 2000);
					return false;
				} else {
					$('.emailErr').html("");
				}
			}

			var mobile = $('#mobile').val();
			if (mobile != "") {
				var mobileRegex =  /^[1-9]{1}[0-9]{9}$/;
				//var mobileVal = /^[0][1-9][0-9]{9}$/;
				if (!mobile.match(mobileRegex)) {
					$('.mobileErr').html("Please enter 10 digits only").css("color","red");
					boolVar = true;
					$('html, body').animate({
						scrollTop: parseInt($("#mobile").offset().top)
					}, 2000);
					return false;
				} else {
					$('.mobileErr').html("");
				}
			}

			var city = $('#city').val();
			if (city != "") {
				var cityRegex = /^([a-zA-Z]+\s?)*$/;
				if (!city.match(cityRegex)) {
					$('.cityErr').html("Only alphabetic Character and single space are allowed").css("color","red");
					boolVar = true;
					$('html, body').animate({
						scrollTop: parseInt($("#city").offset().top)
					}, 2000);
					return false;
				} else {
					$('.cityErr').html("");
				}
			}

			var billing_address = $('#billing_address').val();
			if (billing_address != "") {
				var addressRegex = /(^((?![0-9]+$)[a-zA-Z0-9]+\,?\s?)+$)/;
				if (!billing_address.match(addressRegex)) {
					$('.addressErr').html("Only alphabetic and only alphanumric character with single space and , are allowed").css("color","red");
					boolVar = true;
					$('html, body').animate({
						scrollTop: parseInt($("#billing_address").offset().top)
					}, 2000);
					return false;
				} else {
					$('.addressErr').html("");
				}
			}

			var pincode = $('#pincode').val();
			if (pincode != "") {
				var pincodeRegex = /^[1-9]{1}[0-9]{5}$/;
				if (!pincode.match(pincodeRegex)) {
					$('.pincodeErr').html("Please enter 6 digit only").css("color","red");
					boolVar = true;
					$('html, body').animate({
						scrollTop: parseInt($("#pincode").offset().top)
					}, 2000);
					return false;
				} else {
					$('.pincodeErr').html("");
				}
			}

			var shipping_city = $('#shipping_city').val();
			if (shipping_city != "") {
				var cityRegex = /^([a-zA-Z]+\s?)*$/;
				if (!shipping_city.match(cityRegex)) {
					$('.shipping_cityErr').html("Only alphabetic Character with single space are allowed").css("color","red");
					boolVar = true;
					$('html, body').animate({
						scrollTop: parseInt($("#shipping_city").offset().top)
					}, 2000);
					return false;
				} else {
					$('.shipping_cityErr').html("");
				}
			}

			var shipping_address = $('#shipping_address').val();
			if (shipping_address != "") {
				var addressRegex = /(^((?![0-9]+$)[a-zA-Z0-9]+\,?\s?)+$)/;
				if (!shipping_address.match(addressRegex)) {
					$('.shippingAddressErr').html("Only alphabetic and only alphanumric character with single space and , are allowed").css("color","red");
					boolVar = true;
					$('html, body').animate({
						scrollTop: parseInt($("#shipping_address").offset().top)
					}, 2000);
					return false;
				} else {
					$('.shippingAddressErr').html("");
				}
			}

			var shipping_pincode = $('#shipping_pincode').val();
			if (shipping_pincode != "") {
				var pincodeRegex = /^[1-9]{1}[0-9]{5}$/;
				if (!shipping_pincode.match(pincodeRegex)) {
					$('.shipping_pincodeErr').html("Please enter 6 digit only").css("color","red");
					boolVar = true;
					$('html, body').animate({
						scrollTop: parseInt($("#shipping_pincode").offset().top)
					}, 2000);
					return false;
				} else {
					$('.shipping_pincodeErr').html("");
				}
			}


			// if(boolVar == false) {
			// 	$('#checkoutForm').submit();
			// }
		});

		$("#check").click(function(e) {
			var billing_address = $('#billing_address').val();
			var city            = $('#city').val();
			var pincode         = $('#pincode').val();
			if ($(this).is(':checked') == true) {
				$("#check").attr("checked","checked");
				$('#shipping_address').val(billing_address);
				$('#shipping_city').val(city);
				$('#shipping_pincode').val(pincode);
			} else {
				$('#shipping_address').val("");
				$('#shipping_city').val("");
				$('#shipping_pincode').val("");
			}
		});
	});
	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );
