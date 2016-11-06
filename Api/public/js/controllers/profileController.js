d2gApp.controller("profileController", function (loginService,bookingService, $location) {
	var vm = this;
	var loginSvc = loginService;
	var bookingSvc = bookingService;

	function loadUser () {
		if(loginSvc.getUser()) {
			vm.user = loginSvc.getUser();
			console.log(vm.user);
		}
	}
	
	function getUserBookings () {
		bookingSvc.getBookingsByUserId(vm.user.id).then(function (data) {
			vm.bookings = data.data.bookings;
			console.log(data.data.bookings);
		})
	}

	function _init() {
		if(!loginSvc.getUser()) {
			loginSvc.errorMessage = "You need to be logged in to see your profile";
			$location.path('/home');
		} else {
			loadUser();
			getUserBookings();
		}
	}
	_init();
});