d2gApp.controller("bookingDetailsController", function ($stateParams, $cookies, $location, bookingService, authService) {
	var vm = this;

	var bookingSvc = bookingService;
	var authSvc = authService;

    vm.user = authSvc.getUser();

    vm.redirect = function ($querystring) {
    	if(authSvc.getUser()) {
    		if($querystring) {
                $location.path("booking/" + $stateParams.id + "/request").search({date: $querystring});
			} else {
                $location.path("booking/" + $stateParams.id + "/request");
			}
		} else {
            authSvc.showLoginModal();
		}
    };

	vm.convertToDate = function (dateString) {
		return new Date(dateString);
	};

    vm.userImage = function() {
        return CONSTANTS.PUBLIC_BASE_URL + "/" + vm.currentBooking.host.image;
    };

    vm.dishImage = function(dish) {
        return CONSTANTS.PUBLIC_BASE_URL + "/" + dish.dishimages[0].image_uri;
	};

    vm.guestsForThisDate = function(date) {
        var guests = [];

        angular.forEach(date.guests, function (guest) {
            guests.push(guest.id);
        });

        return guests;
    };

	function getCurrentBooking () {
		bookingSvc.getBookingById($stateParams.id).then(function (data) {
			vm.currentBooking = data.data.booking[0];
			vm.currentBooking.host.image = CONSTANTS.PUBLIC_BASE_URL + "/" + vm.currentBooking.host.image;
		});
	}

	function _init() {
		getCurrentBooking();
	}
	_init();
});