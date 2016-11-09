d2gApp.controller("requestBookingController", function (bookingService, requestService, loginService, $stateParams, $location, $filter, $timeout) {
	
	var vm = this;
	var bookingSvc = bookingService;
	var requestSvc = requestService;
	var loginSvc = loginService;

	vm.user = loginSvc.getUser();
	vm.booking = {};

	vm.sendRequest = function () {
		var datetime = "";

		if(vm.requestdata.selectedDate && !vm.daterequest) {
			console.log(vm.requestdata.selectedDate);
			datetime = vm.requestdata.selectedDate;
		} else {
			var today = new Date();
			if(vm.requestdata.newdate < today) {
				vm.showdate_error = true;
				return false;
			} else {
				datetime = $filter('date')(vm.requestdata.newdate, "yyyy-MM-dd") + " " + $filter('date')(vm.requestdata.newtime, "HH:mm:ss");
				vm.showdate_error = false;
			}
		}

		if(!vm.showdate_error) {
			var data = {
				datetime: datetime,
				booking_id: vm.booking.id,
				user_id: vm.user.id
			};

			console.log(data);

			requestSvc.addRequest(data).then(function (data) {
				swal({
					title: "Your request was sent",
					text: "Your request is on its way. You'll get a notification as soon as the host responds to your request",
					type: "success"
				}).then(function () {
					$location.path("/overview");
				}, function () {
					$location.path("/overview");
				});
			}, function (error) {
				swal({
					title: "Couldn't send request",
					text: "We're very sorry, but something went wrong. We couldn't send your request. You can try again later, or contact us if this problem keeps occuring",
					type: "error"
				})
			});
		}
	}

	vm.convertToDate = function (dateString) {
		var convertedString = new Date(dateString);
		return convertedString;
	}

	vm.resetSelect = function () {
		$timeout(function() {
			$('select:not([multiple])').material_select();
		}, 1)
		vm.daterequest = false;
	}

	function loadBookingById() {
		bookingSvc.getBookingById($stateParams.id).then(function (data) {
			console.log(data.data.booking);
			vm.booking = data.data.booking;
			$timeout(function() {
				$('select:not([multiple])').material_select();
			}, 1)
			
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
		if(vm.user) {
			loadBookingById();
		} else {
			swal({
				text: "You need to be logged in to request a meal",
				type: "error"
			}).then(function () {
				$location.path("/");
			}, function () {
				$location.path("/");
			});
		}
	}

	_init();
});