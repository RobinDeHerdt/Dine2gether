d2gApp.controller('activationController', function ($stateParams, $http, loginService) {
	var vm = this;
	var loginSvc = loginService;

	function _init () {
		var activationcode = {token: $stateParams.token};
		loginSvc.activateUser(activationcode);
	}

	_init();
})