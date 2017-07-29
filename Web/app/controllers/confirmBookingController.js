d2gApp.controller("ConfirmBookingController", function (loginService, bookingService, requestService, $stateParams, $location, $filter, $http) {

	var loginSvc = loginService;
	var bookingSvc = bookingService;
	var requestSvc = requestService;
	var vm = this;
	var booking_id = $stateParams.id;

	vm.user = loginSvc.getUser();
	vm.selected_guests = 1;
	vm.showguesterror = false;
	vm.bookingExists = false;

	function getBookingById() {
		bookingSvc.getBookingById(booking_id).then(function (data) {
			console.log(data.data.booking);
			vm.booking = data.data.booking;

			if(vm.booking) {
				if(vm.booking.host_id == vm.user.id) {
					swal({
						title: "You can't book your own meal...",
						type: "error",
					}).then(function () {
						window.location.href = "#/dashboard";
					}, function () {
						window.location.href = "#/dashboard";
					})
				}
				vm.booking.newprice = vm.booking.price;
				vm.booking.fee = 5;
				vm.booking.totalprice = vm.booking.price + vm.booking.fee;
				checkIfAcceptedRequest();
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

			var interval = setInterval(function () {
				if(vm.booking && vm.request) {
					clearInterval(interval);
					checkIfBookingDateExists();
					console.log(vm.bookingExists);
				}
			}, 50)
		});
	}

	function checkIfBookingDateExists() {
		for(var i=0; i<vm.booking.bookingdates.length; i++) {
			if(vm.request.date_time == vm.booking.bookingdates[i].booking_date) {
				vm.bookingExists = true;
				var data = {
					booking_id: vm.booking.id, 
					date_time: vm.booking.bookingdates[i].booking_date
				}
				bookingSvc.getBookingdateByDate(data).then(function (data) {
					vm.bookingdate = data.data.bookingdate;
					vm.booking.availableseats = vm.booking.max_guests - vm.bookingdate.guests_booked;
				});
			}
		} 
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

	function mealBooked() {
		swal({
			title: "Awesome!",
			text: "You booked this meal. We hope you'll enjoy it!",
			type: "success"
		}).then(function () {
			window.location.href = "#/dashboard";
		}, function () {
			window.location.href = "#/dashboard";
		});
	}

	function goToOverview () {
		window.location.href = "#/overview";
	}

	function checkIfAcceptedRequest () {
		var data = {
			user_id: vm.user.id,
			booking_id: vm.booking.id
		}
		requestSvc.checkIfHasRequest(data).then(function (data) {
				if (data.data.request == "none") {
					swal({text: "You have to make a request first!", type: "error"}).then(function () { goToOverview(); },function () { goToOverview(); })
				} else if(data.data.request.accepted === 1) {
					
				} else if (data.data.request.declined === 1) {
					swal({text: "Sorry! You're request has been declined. You can't book this meal", type: "error"}).then(function () { goToOverview(); },function () { goToOverview(); })
				} else {
					swal({text: "You're request is still pending. Please wait a bit longer", type: "error"}).then(function () { goToOverview(); },function () { goToOverview(); })
				}
		});
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
			if(vm.bookingdate) {
				var data = {
					user_id: vm.user.id,
					guests: vm.selected_guests,
					bookingdate_id: vm.bookingdate.id
				}

				bookingSvc.addUserToBookingdate(data).then(function (data) {
					requestSvc.deleteRequest(vm.request.id).then(function () {
						var maildata = {
							guest_id: vm.user.id,
							host_id: vm.booking.user.id,
							booking_id: vm.booking.id,
							date: vm.request.date,
							time: vm.request.time
						}
						console.log(maildata);
						$http.post(CONSTANTS.API_BASE_URL + "/sendbookingmails", maildata).then(function () {
							mealBooked();
						});
					});
				});

			} else {
				var data = {
					user_id: vm.user.id,
					booking_id: booking_id,
					guests: vm.selected_guests,
					booking_date: vm.datetime,
					host_id: vm.booking.user.id
				}

				bookingSvc.createNewBookingdate(data).then(function (data) {
					requestSvc.deleteRequest(vm.request.id).then(function () {
						mealBooked();
					});
				});
			}
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