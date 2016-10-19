d2gApp.controller("bookingController", function (bookingService, $scope) {

	var vm = this;
	var bookingSvc = bookingService;

	function loadBookings () {
		bookingSvc.getBookings()
			.success(function(data) {
				console.log(data);
			});
	}
	function _init () {
		loadBookings();
	}
	_init();


});