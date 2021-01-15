(function( $ ) {
	'use strict';
	
	$(document).ready(function(){
		$("#publish").click(function(e){
			e.preventDefault();
			var discountedPrice = $('#discountedPrice').val();
			var regularPrice    = $("#regularPrice").val();
			var inventory       = $('#inventory').val();
			//inventory = parseInt(inventory);
			//alert(inventory);
			var bool = false;
			
			if (inventory < 0 || inventory == "" ) {
				bool = true;
				$('.inventoryErr').html("All field are required and Inventory cannot be negative");
				$('html, body').animate({
					scrollTop: parseInt($("#inventory").offset().top)
				}, 2000);
				//return false;
			}
			if (discountedPrice < 0 || regularPrice < 0 || regularPrice == "" ) {
				bool = true;
				$('.disErr').html("All field are required and discount price and regular price can not be negative");
				$('html, body').animate({
					scrollTop: parseInt($("#discountedPrice").offset().top)
				}, 2000);
				//return false;
			} else {
				discountedPrice = parseInt(discountedPrice);
				regularPrice    = parseInt(regularPrice);
				if (discountedPrice > regularPrice) {
					$('.disErr').html("discount price must be less than regular price");
					bool = true;
					$('html, body').animate({
						scrollTop: parseInt($("#discountedPrice").offset().top)
					}, 2000);
					//return false;
				}
			}
			if (bool == false) {
				$("#post").submit();
			}
		});
	});

	/**
	 * All of the code for your admin-facing JavaScript source
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
