d2gApp.controller("requestBookingController", function (bookingService, requestService, authService, $stateParams, $location, $filter, $timeout) {
	
	var vm = this;

	var bookingSvc = bookingService;
	var requestSvc = requestService;
	var authSvc = authService;

	vm.user = authSvc.getUser();
	vm.booking = [];
    vm.currentBookingId = $stateParams.id;

	vm.sendRequest = function () {
		if(!vm.propose_date) {
            $('select').material_select();

            var data = {
                bookingdate_id: vm.requestdata.selectedDate,
				booking_id: vm.currentBookingId,
				message: vm.requestdata.message
            };
		} else {
			if(vm.requestdata.proposed_date > new Date()) {
                var datetime = $filter('date')(vm.requestdata.proposed_date, "yyyy-MM-dd") + " " + $filter('date')(vm.requestdata.proposed_time, "HH:mm:ss");

                var data = {
                    bookingdate: datetime,
                    booking_id: vm.currentBookingId,
                    message: vm.requestdata.message
                };
			} else {
                swal({
                    title: "Invalid date",
                    text: "The requested date lies in the past.",
                    type: "error"
                });

                return;
			}
		}

        requestSvc.addRequest(data).then(function (data) {
        	switch(data.data.status) {
				case "success":
                    swal({
                        title: "Your request was sent",
                        text: "Your request is on its way. You'll get a notification as soon as the host responds to your request",
                        type: "success"
                    }).then(function () {
                        window.location.href = "#/dashboard";
                    });

                    break;

				case "exists":
                    swal({
						text: "You've already sent a request. Please wait for the host to respond.",
						type: "error"
                    });

					break;

				default:
                    swal({
                        title: "Couldn't send request",
                        text: "We're very sorry, but something went wrong. We couldn't send your request. You can try again later, or contact us if this problem keeps occuring",
                        type: "error"
                    });

                    break;
			}
        }, function (error) {
            swal({
                title: "Couldn't send request",
                text: "We're very sorry, but something went wrong. We couldn't send your request. You can try again later, or contact us if this problem keeps occuring",
                type: "error"
            });
        });
	};

	vm.convertToDate = function (dateString) {
		return new Date(dateString);
	};

	function loadBookingById() {
		bookingSvc.getBookingById($stateParams.id).then(function (data) {
			vm.booking = data.data.booking[0];

			$timeout(function() {
				$('select:not([multiple])').material_select();

				if(vm.user.id === vm.booking.host.id) {
					swal({ text: "Why would you want to request your own booking? That's weird...", type: "error"}).then(function () {
                        window.history.back();
					});
				}
			}, 50)
			
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

		var newdate = datesplit[2] + "/" + datesplit[1] + "/" + datesplit[0];
		var time = datetimesplit[1].substring(0,5);

		return [newdate, time];
	}

	function _init() {
		loadBookingById();
	}

	_init();
});