d2gApp.controller("profileController", function (authService, bookingService, requestService, $http, $location, $filter, Upload) {
	var vm = this;
	var authSvc = authService;
	var bookingSvc = bookingService;
	var requestSvc = requestService;

    if(!authSvc.getUser()) {
        authSvc.showLoginModal();
        $location.path('/home');

        return;
    }

    function loadUser () {
		if(authSvc.getUser()) {
			vm.user = authSvc.getUser();
		}
	}
	
	function getHostBookings () {
		bookingSvc.getHostBookings().then(function (data) {
			vm.hostbookings = data.data.bookings;
			vm.hostrequests = data.data.requests;
		});
	}

	function getGuestBookings () {
		bookingSvc.getGuestBookings().then(function (data) {
			console.log(data.data);
			vm.guestbookingdates = data.data.bookingdates;
			vm.guestrequests = data.data.requests;
		});
	}

	vm.convertToDate = function (dateString) {
  		return new Date(dateString);
	};

	vm.acceptRequest = function (requestid, userid, bookingid) {
		requestSvc.acceptRequest(requestid).then(function () {
			var data = {
				user_id: userid,
				host_id: vm.user.id,
				booking_id: bookingid
			};

			$http.post(CONSTANTS.API_BASE_URL + "/sendconfirmationrequestmail", data).then( function () {
				swal({
					text: "Request was accepted. User is booked and will get a notification.",
					type: "success"
				});

				getHostBookings();
			});

		}, function () {
			swal({
				text: "We're so sorry, for some reasons we couldn't accept this request. Please try again or contact us if this problem keeps occuring.",
				type: "error"
			})
		})
	};

	vm.declineRequest = function (id) {
		requestSvc.declineRequest(id).then(function () {
			swal({
				text: "Request was declined. We'll notificate the user",
				type: "success"
			});
            getHostBookings();
		}, function () {
			swal({
				text: "We're so sorry, for some reasons we couldn't decline this request. Please try again or contact us if this problem keeps occuring.",
				type: "error"
			})
		})
	};

	vm.deleteBooking = function (id) {
		bookingSvc.deleteBooking(id).then(function()
		{
            getHostBookings();
		});
	};

	vm.deleteUserRequest = function (id) {
		requestSvc.deleteRequest(id).then(function () {
			swal({
				title: "Request deleted",
				type: "success"
			});
			getGuestBookings();
		}, function () {
			swal({
				title: "Couldn't delete request",
				text: "We couldn't delete your request. Try again later or contact us if this problem keeps occuring",
				type: "error"
			})
		});
	};

	vm.detachFromBooking = function (id, userid) {
		var user = authSvc.getUser();
		bookingSvc.detachBooking(id, user.id).then(function()
		{
			getGuestBookings();
		});
	};

	vm.saveProfile = function() {
		var data = {
			first_name: vm.user.first_name,
			last_name: vm.user.last_name,
			email: vm.user.email,
			street_number: vm.user.street_number,
			postalcode: vm.user.postalcode,
			city: vm.user.city
		};

        authSvc.updateProfile(data).then(function(data) {
			if ( data.status === 200)
			{
				vm.showsuccessmessage = true;
                authSvc.setUser();
			}
		}, function (error) {
			vm.showerrormessage = true;
		});
	};

	vm.uploadProfilePicture = function (file) {
		Upload.upload({
			url: CONSTANTS.API_BASE_URL + '/user/upload',
			data: {
				file : file,
				user_id	: vm.user.id
			}
			}).then(function (data) {
            authSvc.setUser();
				vm.user.image = data.data.filename;
				vm.path = '';
			}); 
	};

    vm.userImage = function() {
        return CONSTANTS.PUBLIC_BASE_URL + "/" + vm.user.image;
    };

	function _init() {
		loadUser();
		getHostBookings();
		getGuestBookings();
	}

	_init();
});