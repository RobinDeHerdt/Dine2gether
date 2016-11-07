d2gApp.controller("reviewController", function (reviewService, loginService) {
	vm = this;
	var reviewSvc = reviewService;
	var loginSvc  = loginService;

	function getPastBookings() {
		var user = loginSvc.getUser();
		reviewSvc.getBookings(user.id).then(function(data)
		{
			vm.bookings = data.data.bookings;
			console.log(data);
		});
	}

	vm.getSelectedGuest = function(id)
	{
		vm.selectedGuest = id;
	}

	function _init() {
		getPastBookings();
	}

	_init();
});