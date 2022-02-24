(function( $ ) {
	'use strict';

	$(document).ready(function() {

		var now = new Date();
		var now_day = now.getDay();
		var now_hour = now.getHours();
		var now_minutes = now.getMinutes();
		var current_time = ("0" + now_hour).slice(-2) + ':' + ("0" + now_minutes).slice(-2) + ':00';

		// Store List
		var storeListItems = $('.dokan-store-opening-hours-current-open-container');
		if(storeListItems.length > 0) {

			$.each(storeListItems, function(i, index) {
				var store_opening_hours = $(this).data('opening-hours');

				if(store_opening_hours == "") {
					return;
				}

				var open_time = store_opening_hours[now_day][0] + ':00';
				var closed_time = store_opening_hours[now_day][1] + ':00';

				// Is Open
				if (current_time > open_time && current_time < closed_time) {
				    $(this).find('.dokan-store-opening-hours-current-open').show();
			    // Is Closed
				} else {
				    $(this).find('.dokan-store-opening-hours-current-closed').show();
				}
			});
		}

		// Single Store Page
		if(typeof store_opening_hours === 'undefined') {
			return;
		}

		if(store_opening_hours.hasOwnProperty(now_day)) {
			
			if(store_opening_hours[now_day][0] == "" || store_opening_hours[now_day][1] == "") {
				$('.dokan-store-widget-opening-hours-current-closed').show();
				return;
			}
			
			var open_time = store_opening_hours[now_day][0] + ':00';
			var closed_time = store_opening_hours[now_day][1] + ':00';

			// Is Open
			if (current_time > open_time && current_time < closed_time) {
				console.log('test1');
			    $('.dokan-store-widget-opening-hours-current-open').show();
		    // Is Closed
			} else {
				console.log('test2');
			    $('.dokan-store-widget-opening-hours-current-closed').show();
			}
		}



	} );

})( jQuery );