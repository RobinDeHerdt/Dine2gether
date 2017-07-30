d2gApp.controller("overviewController", function (bookingService, interestService, kitchenstyleService, $scope, $stateParams) {

	var vm = this;
	var bookingSvc = bookingService;
	var interestSvc = interestService;
	var kitchenstyleSvc = kitchenstyleService;

	vm.bookings = [];

	vm.bookingImage = function(booking) {
		return CONSTANTS.PUBLIC_BASE_URL  + "/" + booking.dishes[0].dishimages[0].image_uri;
	};

	vm.showFilteredInterests = function () {
		var selected_interests = getSelectedInterests();

		return function (booking) {
			if(booking.host.interests.length > 0 && selected_interests.length > 0) {
                for(var i = 0; i < booking.interests.length; i++) {
                    for(var j = 0; j < selected_interests.length; j++) {
                        if(booking.interests[i].id === selected_interests[j]) {
                            return booking.interests[i].id === selected_interests[j];
                        }
                    }
                }
            } else {
				return true;
			}
		}
	};

	vm.showFilteredKitchenStyles = function () {
		var selected_kitchenstyles = getSelectedKitchenStyles();

		return function (booking) {
			if(booking.kitchenstyles.length > 0 && selected_kitchenstyles.length > 0) {
                for(var i = 0; i < booking.kitchenstyles.length; i++) {
					for(var j = 0; j < selected_kitchenstyles.length; j++) {
						if(booking.kitchenstyles[i].id === selected_kitchenstyles[j]) {
							return booking.kitchenstyles[i].id === selected_kitchenstyles[j];
						}
					}
                }
            } else {
				return true;
			}
		}
	};

	function loadBookings () {
		if($stateParams.search) {
			return bookingSvc.getBookingsByLocation($stateParams.search).then(function (data) {
				vm.bookings = data.data.bookings;
			});
		}

		return bookingSvc.getBookings().success(function (data) {
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

	function getSelectedInterests () {
		var selected_interests = [];

		angular.forEach(vm.interests, function (interest) {
			if(interest.selected) {
                selected_interests.push(interest.id);
			}
		});

		return selected_interests;
	}

	function getSelectedKitchenStyles () {
		var selected_kitchenstyles = [];

		angular.forEach(vm.kitchenstyles, function (kitchen) {
			if(kitchen.selected) {
                selected_kitchenstyles.push(kitchen.id);
			}
		});

		return selected_kitchenstyles;
	}

	function _init () {
		loadBookings();
		loadInterests();
		loadKitchenStyles();
	}

	_init();
});