d2gApp.controller("profileController", function (loginService,bookingService, $location, $filter, Upload, requestService) {
	var vm = this;
	var loginSvc = loginService;
	var bookingSvc = bookingService;
	var requestSvc = requestService;

	var shouldHide = false;

	function loadUser () {
		if(loginSvc.getUser()) {
			vm.user = loginSvc.getUser();
			console.log(vm.user);
		}
	}
	
	function getUserBookings () {
		bookingSvc.getBookingsByUserId(vm.user.id).then(function (data) {
			vm.hostbookings = data.data.bookings;
			vm.hostrequests = data.data.requests;
			if(vm.hostrequests.date_time) {
				vm.hostrequests.date = $filter(date)(vm.hostrequests.date_time, "dd/MM/yyyy");
				vm.hostrequests.time = $filter(date)(vm.hostrequests.date_time, "HH:mm");
			}
			console.log(data.data);
		})
	}

	function getGuestBookings () {
		bookingSvc.getGuestBookingsById(vm.user.id).then(function (data) {
			console.log(data.data);
			vm.guestbookings = data.data.bookings;
			vm.guestrequests = data.data.requests;
		}) 
	}

	vm.acceptRequest = function (id) {
		requestSvc.acceptRequest(id).then(function () {
			swal({
				text: "Request was accepted. User is booked and will get a notification.",
				type: "success"
			})

			getGuestBookings();
		}, function () {
			swal({
				text: "We're so sorry, for some reasons we couldn't accept this request. Please try again or contact us if this problem keeps occuring.",
				type: "error"
			})
		})
	}

	vm.declineRequest = function (id) {
		requestSvc.declineRequest(id).then(function () {
			swal({
				text: "Request was declined. We'll notificate the user",
				type: "success"
			})
			getGuestBookings();
		}, function () {
			swal({
				text: "We're so sorry, for some reasons we couldn't decline this request. Please try again or contact us if this problem keeps occuring.",
				type: "error"
			})
		})
	}

	vm.deleteBooking = function (id) {
		bookingSvc.deleteBooking(id).then(function()
		{
			getUserBookings();
		});
	}

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
	}

	vm.detachFromBooking = function (id, userid) {
		var user = loginSvc.getUser();
		bookingSvc.detachBooking(id, user.id).then(function()
		{
			getGuestBookings();
		});
	}

	vm.saveProfile = function() {
		var data = {
			first_name: vm.user.first_name,
			last_name: vm.user.last_name,
			email: vm.user.email,
			street_number: vm.user.street_number,
			postalcode: vm.user.postalcode,
			city: vm.user.city,
		};
		loginSvc.updateProfile(vm.user.id,data).then(function(data) {
			if ( data.status == 200)
			{
				loginSvc.setUser();
			}
		}, function (error) {
			vm.showerrormessage = true;
		});
	}

	vm.uploadProfilePicture = function (file) {
		Upload.upload({
			url: '/api/profile/upload',
			data: 
			{
				file	: file,
				user_id	: vm.user.id
			}
			}).then(function (data) {
				loginSvc.setUser();
				vm.user.image = data.data.filename;
				vm.path = '';
			}); 
	}

	function _init() {
		if(!loginSvc.getUser()) {
			loginSvc.errorMessage = "You need to be logged in to see your profile";
			$location.path('/home');
		} else {
			loadUser();
			getUserBookings();
			getGuestBookings();
		}
	}
	_init();
});