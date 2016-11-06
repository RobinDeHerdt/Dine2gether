d2gApp.controller("requestBookingController", function (bookingService, $stateParams) {
	
	var vm = this;
	var bookingSvc = bookingService;

	vm.booking = {};

	function loadBookingById() {
		bookingSvc.getBookingById($stateParams.id).then(function (data) {
			console.log(data.data.booking);
			vm.booking = data.data.booking;
			if(vm.booking.date) {
				var datetime = splitDateTime(vm.booking.date);		
				vm.booking.date = datetime[0];
				vm.booking.hour = datetime[1];	
			}
		}, function (error) {
			swal({
				title: "Oops",
				text: "We can't seem to find this booking. Are you sure it exists?",
				type: "error"
			});
		});
	}

	function splitDateTime(datetime) {
		var datetimesplit = datetime.split(" ");
		var date = datetimesplit[0];
		var datesplit = date.split("-");

		console.log(datesplit);

		var newdate = datesplit[2] + "/" + datesplit[1] + "/" + datesplit[0];
		var time = datetimesplit[1].substring(0,5);

		return [newdate, time];
	}
	function _init() {
		loadBookingById();
	}

	_init();
});