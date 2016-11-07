d2gApp.controller("bookingDetailsController", function ($stateParams, bookingService) {
	var vm = this;
	var bookingSvc = bookingService;
	vm.currentBookingId = $stateParams.id;

	vm.imageUrlBase = "img/";

	function getCurrentBooking () {
		bookingSvc.getBookingById(vm.currentBookingId).then(function (data) {
			vm.currentBooking = data.data.booking;
			console.log(data.data.booking);
		})
	}
	function _init() {
		getCurrentBooking();
	}
	_init();
});