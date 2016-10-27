d2gApp.controller("overviewController", function (bookingService, interestService, kitchenstyleService, $scope) {

	var vm = this;
	var bookingSvc = bookingService;
	var interestSvc = interestService;
	var kitchenstyleSvc = kitchenstyleService;

	vm.bookings = {};

	vm.convertToDate = function (dateString) {
		var convertedString = new Date(dateString);
		return convertedString;
	}

	vm.showFilteredInterests = function () {
		var interestsarray = getInterestsFilter();
		var arr_x = [];
			return function (booking) {
				for(var i in booking.user.interests) {
					if(interestsarray.length != 0) {
						for(var x=0; x<interestsarray.length; x++) {
							if(booking.user.interests[i].interest == interestsarray[x]) {
								return booking.user.interests[i].interest == interestsarray[x];
							}
						}
					} else { return true; }
				} 
			}
	}

	vm.showFilteredKitchenStyles = function () {
		var kitchenstylessarray = getKitchenStylesFilter();
		var arr_x = []
			return function (booking) {
				console.log(booking);
				for(var i in booking.kitchenstyles) {
					if(kitchenstylessarray.length != 0) {
						for(var x=0; x<kitchenstylessarray.length; x++) {
							if(booking.kitchenstyles[i].style == kitchenstylessarray[x]) {
								return booking.kitchenstyles[i].style == kitchenstylessarray[x]
							}
						}
					} else { return true; }
				} 
			}
	}
	function loadBookings () {
		bookingSvc.getBookings()
			.success(function(data) {
				//console.log(data.bookings[0].dishes[0].dish_images[0]['image-url'])
				console.log(data);
				vm.bookings = data.bookings;
			});
	}

	function loadInterests () {
		interestSvc.getInterests()
			.success(function (data) {
				vm.interests = data.interests;
			});
	}

	function loadKitchenStyles () {
		kitchenstyleSvc.getKitchenStyles()
			.success(function (data) {
				vm.kitchenstyles = data.kitchenstyles;
			});
	}

	function getInterestsFilter () {
		var arr_interests = [];
		angular.forEach(vm.interests, function (interest) {
			if(interest.selected) {
				arr_interests.push(interest.interest);
			}
		})
		return arr_interests;
	}

	function getKitchenStylesFilter () {
		var arr_kitchenstyles = [];
		angular.forEach(vm.kitchenstyles, function (kitchen) {
			if(kitchen.selected) {
				arr_kitchenstyles.push(kitchen.style);
			}
		})
		return arr_kitchenstyles;
	}

	function _init () {
		loadBookings();
		loadInterests();
		loadKitchenStyles();
	}
	_init();


});