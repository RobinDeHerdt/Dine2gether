d2gApp.controller("bookingDetailsController", function ($stateParams, $location, bookingService, requestService, authService) {
	var vm = this;
	var bookingSvc = bookingService;
	var requestSvc = requestService;
	var authSvc = authService;

	vm.user = authSvc.getUser();
	vm.currentBookingId = $stateParams.id;
	vm.request = "";

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
			vm.currentBooking = data.data.booking[0];
			vm.currentBooking.host.image = CONSTANTS.PUBLIC_BASE_URL + "/" + vm.currentBooking.host.image;
		});
	}

	function _init() {
		getCurrentBooking();
	}
	_init();
});