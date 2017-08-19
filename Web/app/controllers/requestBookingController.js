d2gApp.controller("requestBookingController", function (bookingService, requestService, authService, $stateParams, $location, $state, $filter, $timeout) {
	
	var vm = this;

	var bookingSvc = bookingService;
	var requestSvc = requestService;
	var authSvc = authService;

	vm.user = authSvc.getUser();
	vm.booking = [];
	vm.requestdata = [];
	vm.propose_date = false;

    function _init() {
        loadBooking(function() {
        	// @todo Figure out why this is necessary.
            $timeout(function(){
                if (param = $location.search().date) {
                    $('#dateselect').val(param);
                    vm.requestdata.selectedDate = param;
                }
                $('#dateselect').material_select();
            }, 1);
		});
    }

	vm.sendRequest = function () {
        vm.buttonDisabled = true;

		if(!vm.propose_date) {
            $('select').material_select();

            var data = {
                bookingdate_id: vm.requestdata.selectedDate,
				booking_id: $stateParams.id,
				message: vm.requestdata.message
            };
		} else {
			var proposed_date = new Date(vm.requestdata.proposed_date);

			if(proposed_date > new Date()) {
                var datetime = $filter('date')(vm.requestdata.proposed_date, "yyyy-MM-dd") + " " + $filter('date')(vm.requestdata.proposed_time, "HH:mm:ss");

                var data = {
                    bookingdate: datetime,
                    booking_id: $stateParams.id,
                    message: vm.requestdata.message
                };
			} else {
                swal({
                    title: "Invalid date",
                    text: "The requested date lies in the past.",
                    type: "error"
                });

                vm.buttonDisabled = false;

                return;
			}
		}

        requestSvc.addRequest(data).then(function (data) {
            vm.buttonDisabled = false;

        	switch(data.data.status) {
				case "success":
                    swal({
                        title: "Your request was sent",
                        text: "Your request is on its way. You'll get a notification as soon as the host responds to your request",
                        type: "success"
                    }).then(function () {
                        $state.go('dashboard');
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

            vm.buttonDisabled = false;
        });
	};

	vm.convertToDate = function (dateString) {
		return new Date(dateString);
	};

    vm.initDatePickers = function() {
        $('.datepicker').pickadate({
            selectMonths: true,
            today: 'Today',
            clear: 'Clear',
            close: 'Ok',
            closeOnSelect: true,
            format: 'yyyy-mm-dd'
        });

        $('.timepicker').pickatime({
            default: 'now',
            fromnow: 0,
            twelvehour: false,
            donetext: 'OK',
            cleartext: 'Clear',
            canceltext: 'Cancel',
            autoclose: false,
            ampmclickable: true
        });
    };

	function loadBooking(callback) {
		bookingSvc.getBookingById($stateParams.id).then(function (data) {
			vm.booking = data.data.booking[0];

			if(vm.user.id === vm.booking.host.id) {
				swal({
					text: "Why would you want to request your own booking? That's weird...",
					type: "error"
				}).then(function () {
					window.history.back();
				});
			}

            callback();
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

	_init();
});