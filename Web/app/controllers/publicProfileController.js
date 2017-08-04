d2gApp.controller("publicProfileController", function (bookingService, $stateParams, $filter) { 

	var vm = this;
	var bookingSvc = bookingService;
	vm.user = vm.bookings = vm.reviews = {};

	vm.user = bookingService.getUserBookingsAndReviews($stateParams.id).then(function (data) {
		console.log(data);
		vm.user = data.data.user;
		vm.bookings = data.data.bookings;
		vm.reviews = data.data.latest_reviews;
	}, function (error) {	
		console.log("Error occured")
	});

	vm.toDate = function (datestring) {
		var date = $filter('date')(new Date(datestring), 'MMM d yyyy');
		console.log(date);	
		return date;
	}




});