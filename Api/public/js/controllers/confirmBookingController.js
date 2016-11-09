d2gApp.controller("ConfirmBookingController", function (loginService, bookingService, requestService, $stateParams) {

	var loginSvc = loginService;
	var bookingSvc = bookingService;
	var requestSvc = requestService;
	var vm = this;
	var booking_id = $stateParams.id;

	vm.user = loginSvc.getUser();
	vm.selected_guests = 1;
	vm.showguesterror = false;

	function getBookingById() {
		bookingSvc.getBookingById(booking_id).then(function (data) {
			console.log(data.data.booking);
			vm.booking = data.data.booking;

			if(vm.booking) {
				vm.booking.availableseats = vm.booking.max_guests - vm.booking.guests_booked;
				vm.booking.newprice = vm.booking.price;
				vm.booking.fee = 5;
				vm.booking.totalprice = vm.booking.price + vm.booking.fee;
			}
		},function () {
			swal({
				text: "We couldn't seem to find this booking...",
				type: "error"
			}).then(function () {
				window.location.href = "#/overview";
			}, function() {
				window.location.href = "#/overview";
			});
		})
	}

	function getRequestById() {
		var data = {
			user_id: vm.user.id,
			booking_id: booking_id
		}
		console.log(data);
		requestSvc.getRequestById(data).then(function (data) {
			console.log(data);
			vm.request = data.data.request;

			if(vm.request.date_time) {
				var filteredDate = splitDateTime(vm.request.date_time);
				vm.request.date = filteredDate[0];
				vm.request.time = filteredDate[1];
				}
		})
	}

	function splitDateTime(datetime) {
		var datetimesplit = datetime.split(" ");
		var date = datetimesplit[0];
		var datesplit = date.split("-");

		var newdate = datesplit[2] + "/" + datesplit[1] + "/" + datesplit[0];
		var time = datetimesplit[1].substring(0,5);

		return [newdate, time];
	}

	vm.calcPrice = function () {
		if(vm.selected_guests) {
			vm.showguesterror = false;
			vm.booking.newprice = vm.booking.price * vm.selected_guests;
			vm.booking.totalprice = vm.booking.newprice 
				+ vm.selected_guests * vm.booking.fee; 
		} else {
			vm.showguesterror = true;
		}
	}

	vm.confirmBooking = function () {

		if(vm.selected_guests == undefined ) {
			vm.showguesterror = true;
		} else {
			vm.showguesterror = false;
		}
	}

	function _init() {
		if(vm.user) {
			getBookingById();
			getRequestById();
		} else {
			swal({
				title: "Not logged in.",
				text: "You're not logged in, so we can't check if you can book this meal. Please login and check your dashboard.",
				type: "error"
			}).then(function () {
				window.location.href('/');
			}, function () {
				window.location.href('/');
			})
		}
	}

	_init();
});