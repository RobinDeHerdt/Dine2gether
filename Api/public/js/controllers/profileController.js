d2gApp.controller("profileController", function (loginService, $location) {
	var vm = this;
	var loginSvc = loginService;

	function loadUser () {
		if(loginSvc.getUser()) {
			vm.user = loginSvc.getUser();
			console.log(vm.user);
		}
	}

	function _init() {
		if(!loginSvc.getUser()) {
			loginSvc.errorMessage = "You need to be logged in to see your profile";
			$location.path('/home');
		} else {
			loadUser();
		}
	}
	_init();
});