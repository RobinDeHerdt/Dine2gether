d2gApp.controller("profileController", function (authService, bookingService, requestService, $http, $location, $filter, Upload) {
	var vm = this;

	var authSvc = authService;

    function _init() {
        if(!authSvc.getUser()) {
            authSvc.showLoginModal();
            $location.path('/home');

            return;
        }

        loadUser();
    }

    function loadUser () {
		if(authSvc.getUser()) {
			vm.user = authSvc.getUser();
		}
	}

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
			if ( data.status === 200) {
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

	_init();
});