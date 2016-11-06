d2gApp.controller("profileController", function (loginService,bookingService, $location, Upload) {
	var vm = this;
	var loginSvc = loginService;
	var bookingSvc = bookingService;

	function loadUser () {
		if(loginSvc.getUser()) {
			vm.user = loginSvc.getUser();
			console.log(vm.user);
		}
	}
	
	function getUserBookings () {
		bookingSvc.getBookingsByUserId(vm.user.id).then(function (data) {
			vm.bookings = data.data.bookings;
			console.log(data.data.bookings);
		})
	}

	vm.deleteBooking = function (id) {
		bookingSvc.deleteBooking(id);
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
			loginSvc.setUser();
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
			}); 
	}

	function _init() {
		if(!loginSvc.getUser()) {
			loginSvc.errorMessage = "You need to be logged in to see your profile";
			$location.path('/home');
		} else {
			loadUser();
			getUserBookings();
		}
	}
	_init();
});