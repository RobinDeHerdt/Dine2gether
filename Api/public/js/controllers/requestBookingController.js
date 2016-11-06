d2gApp.controller("requestBookingController", function (bookingService, $stateParams) {
	var vm = this;
	var bookingSvc = bookingService;

	vm.booking = {};
	function loadBookingById() {
		bookingSvc.getBookingById($stateParams.id).then(function (data) {
			console.log(data);
		}, function (error) {
			swal({
				title: "Oops",
				text: "We can't seem to find this booking. Are you sure it exists?",
				type: "error"
			})
		})
	}
	function _init();

	_init()
});