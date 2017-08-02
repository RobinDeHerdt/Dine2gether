d2gApp.controller("bookingDetailsController", function ($stateParams, $cookies, $location, bookingService, requestService, authService) {
	var vm = this;

	var bookingSvc = bookingService;
	var requestSvc = requestService;
	var authSvc = authService;

    vm.user = $cookies.getObject("user");
	vm.currentBookingId = $stateParams.id;
	vm.request = "";

    vm.redirect = function () {
    	if($cookies.getObject("user")) {
            $location.path("requestbooking/"+ vm.currentBookingId);
		} else {
            authSvc.showLoginModal();
		}
    };

	vm.convertToDate = function (dateString) {
		return new Date(dateString);
	};

    vm.userImage = function() {
    	console.log(vm.currentBooking);
        return CONSTANTS.PUBLIC_BASE_URL + "/" + vm.currentBooking.host.image;
    };

    vm.dishImage = function(dish) {
        return CONSTANTS.PUBLIC_BASE_URL + "/" + dish.dishimages[0].image_uri;
	};

	function getCurrentBooking () {
		bookingSvc.getBookingById(vm.currentBookingId).then(function (data) {
			console.log(data.data);
			vm.currentBooking = data.data.booking[0];
			vm.currentBooking.host.image = CONSTANTS.PUBLIC_BASE_URL + "/" + vm.currentBooking.host.image;
		});
	}

	function _init() {
		getCurrentBooking();
	}
	_init();
});