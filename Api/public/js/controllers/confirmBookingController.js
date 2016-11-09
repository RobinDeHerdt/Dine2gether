d2gApp.controller("ConfirmBookingController", function (loginService, bookingService, requestService, $stateParams, $location, $filter) {

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
				if(vm.booking.host_id == vm.user.id) {
					swal({
						title: "You can't book your own meal...",
						type: "error"
					}).then(function () {
						window.location.href = "#/dashboard";
					}, function () {
						window.location.href = "#/dashboard";
					})
				}
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

				vm.datetime = $filter('date')(vm.request.date_time, "yyyy-MM-dd");
				console.log(vm.datetime);
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

	function checkForErrors () {
		var cardnumber = vm.card.toString();
		var cvv = vm.cvv.toString();
		var today = new Date();

		if(cardnumber.length !== 16 || vm.card == undefined) {
			vm.showcarderror = true;
			console.log("showcarderror");
		} else {
			vm.showcarderror = false;
		}
		if(vm.expirationdate < today) {
			vm.showexpirationerror = true;
		} else {
			vm.expirationerror = false;
		}
		if(cvv.length < 3 || cvv.length > 4 || vm.cvv == undefined ) {
			vm.showcvverror = true;
			console.log("showcvverror");
		} else {
			vm.showcvverror = false;
		}
		if(vm.selected_guests == undefined ) {
			vm.showguesterror = true;
		} else {
			vm.showguesterror = false;
		}

		if(vm.selected_guests && cardnumber.length == 16 && cvv.length >= 3 && cvv.length <= 4 && vm.expirationdate > today ) {
			console.log("no errors");
			return false;
		}

		return true;
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
		
		var hasErrors = checkForErrors();
		if(!hasErrors) {
			var data = {
				user_id: vm.user.id,
				booking_id: booking_id,
				nr_guests: vm.selected_guests,
				booking_date: vm.datetime
			}
			bookingSvc.createUserBooking(data).then(function (data) {
				swal({
					title: "Awesome!",
					text: "You booked this meal. We hope you'll enjoy it!",
					type: "success"
				}).then(function () {
					window.location.href("#/dashboard");
				}, function () {
					window.location.href("#/dashboard");
				})
			});
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