d2gApp.controller("requestBookingController", function (bookingService, requestService, $stateParams) {
	
	var vm = this;
	var bookingSvc = bookingService;
	var requestSvc = requestService;

	vm.booking = {};

	vm.sendRequest = function () {
		var datetime = "";

		if(vm.booking.date) {
			datetime = vm.booking.date;
		} else {
			var datetime = vm.requestdata.date + " " + vm.requestdata.time; + ":00";
		}

		var data = {
			datetime: datetime,
			number_of_guests: vm.requestdata.nr_of_guests,
			booking_id: vm.booking.id,
			user_id: vm.booking.user.id
		};

		console.log(data);

		requestSvc.addRequest(data);
	}

	function loadBookingById() {
		bookingSvc.getBookingById($stateParams.id).then(function (data) {
			console.log(data.data.booking);
			vm.booking = data.data.booking;
			if(vm.booking.date) {
				var datetime = splitDateTime(vm.booking.date);		
				vm.booking.onlydate = datetime[0];
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