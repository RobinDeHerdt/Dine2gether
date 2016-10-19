d2gApp.controller("bookingController", function (bookingService, $scope) {

	var vm = this;
	var bookingSvc = bookingService;

	vm.bookings = {};
	function loadBookings () {
		bookingSvc.getBookings()
			.success(function(data) {
				//console.log(data.bookings[0].dishes[0].dish_images[0]['image-url'])
				console.log(data);
				vm.bookings = data.bookings;
			});
	}

	vm.convertToDate = function (dateString) {
		var convertedString = new Date(dateString);
		return convertedString;
	}

	function _init () {
		loadBookings();
	}
	_init();


});