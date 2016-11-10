d2gApp.controller("bookingDetailsController", function ($stateParams, $location, bookingService, requestService, loginService) {
	var vm = this;
	var bookingSvc = bookingService;
	var requestSvc = requestService;
	var loginSvc = loginService;

	vm.user = loginSvc.getUser();
	vm.currentBookingId = $stateParams.id;
	vm.request = "";

	vm.imageUrlBase = "img/";

	vm.convertToDate = function (dateString) {
		var convertedString = new Date(dateString);
		return convertedString;
	}

	vm.redirect = function () {
		if(vm.request != "own_booking" && vm.request != "pending") {
			$location.path("requestbooking/"+ vm.currentBookingId);
		}
	}

	function getCurrentBooking () {
		bookingSvc.getBookingById(vm.currentBookingId).then(function (data) {
			vm.currentBooking = data.data.booking;
			console.log(data.data.booking);
			if(vm.user) {
				if(vm.user.id == vm.currentBooking.user.id) {
					vm.request = "own_booking";
					console.log(vm.request);
				} else {
					checkIfUserHasRequest();
				}
			}
		})
	}

	function checkIfUserHasRequest() {
		var data = {
			user_id: vm.user.id,
			booking_id: vm.currentBooking.id
		}
		requestSvc.checkIfHasRequest(data).then(function (data) {
				if (data.data.request == "none") {
					vm.request == "none";
				} else if(data.data.request.accepted === 1) {
					vm.request = "accepted";
				} else if (data.data.request.declined === 1) {
					vm.request = "declined";
				} else {
					vm.request = "pending";
				}
		});
	}

	function _init() {
		getCurrentBooking();
	}
	_init();
});