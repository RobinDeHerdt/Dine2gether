d2gApp.controller("profileController", function (loginService) {
	var vm = this;
	var loginSvc = loginService;

	function loadUser () {
		loginSvc.getUser().then(function (data) {
				console.log(data);
			});
	}

	function _init() {
		loadUser();
	}
	_init();
});