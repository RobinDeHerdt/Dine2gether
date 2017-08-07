d2gApp.controller("profileController", function (authService, bookingService, interestService, requestService, $http, $location, $filter, Upload) {
	var vm = this;

	var authSvc = authService;
	var interestSvc = interestService;

    function _init() {
        if(!authSvc.getUser()) {
            authSvc.showLoginModal();
            $state.go('home');

            return;
        }

        vm.user = authSvc.getUser();

        interestSvc.getInterests().then(function(data) {
        	vm.interests = data.data.interests;

            interestSvc.getAuthUserInterests().then(function(data) {
                vm.userInterests = data.data.userinterests;

                vm.interests.forEach(function(interest){
                    vm.userInterests.forEach(function(userInterest){
                        if(userInterest.id === interest.id){
                            interest.selected = true;
                        }
                    });
                });
            });
		});
    }

	function getSelectedInterests () {
		var selected_interests = [];

		angular.forEach(vm.interests, function (interest) {
			if(interest.selected) {
				selected_interests.push(interest.id);
			}
		});

		console.log(selected_interests);

		return selected_interests;
	}

	vm.saveProfile = function() {
		var data = {
			first_name: vm.user.first_name,
			last_name: vm.user.last_name,
			email: vm.user.email,
			street_number: vm.user.street_number,
			postalcode: vm.user.postalcode,
			city: vm.user.city,
			interests: getSelectedInterests()
		};

        authSvc.updateProfile(data).then(function(data) {
			if ( data.status === 200) {
				vm.showsuccessmessage = true;
                authSvc.setUser(false);
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
            authSvc.setUser(false);
				vm.user.image = data.data.filename;
				vm.path = '';
			}); 
	};

    vm.userImage = function() {
        return CONSTANTS.PUBLIC_BASE_URL + "/" + vm.user.image;
    };

	_init();
});