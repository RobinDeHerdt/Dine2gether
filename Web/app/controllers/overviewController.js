d2gApp.controller("overviewController", function (bookingService, interestService, kitchenstyleService, $scope, $stateParams) {

	var vm = this;
	var bookingSvc = bookingService;
	var interestSvc = interestService;
	var kitchenstyleSvc = kitchenstyleService;

	vm.bookings = {};

	vm.bookingImage = function(booking) {
		return CONSTANTS.PUBLIC_BASE_URL  + "/" + booking.dishes[0].dish_images[0].image_url;
	}

	vm.showFilteredInterests = function () {
		var interestsarray = getInterestsFilter();
		return function (booking) {
			if(booking.interests.length == 0 && interestsarray.length == 0) {
				return true;
			} else {
				for(var i in booking.interests) {
					if(interestsarray.length != 0) {
						for(var x=0; x<interestsarray.length; x++) {
							if(booking.interests[i].interest == interestsarray[x]) {
								return booking.interests[i].interest == interestsarray[x];
							}
						}
					} else { return true; }
				} 
			}
		}
	}

	vm.showFilteredKitchenStyles = function () {
		var kitchenstylessarray = getKitchenStylesFilter();
		var arr_x = []
		return function (booking) {
			if(booking.kitchenstyles.length == 0 && kitchenstylessarray.length == 0) {
				return true;
			} else {
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
	}

	function loadBookings () {
		if($stateParams.search) {
			bookingSvc.getBookingsByLocation($stateParams.search)
				.then(function (data) {
					vm.bookings = data.data.bookings;
				}, function(error) {
					console.log(error);
				});
		} else {
			bookingSvc.getBookings()
				.success(function (data) {
					vm.bookings = data.bookings;
					console.log(data);
				});
		}
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