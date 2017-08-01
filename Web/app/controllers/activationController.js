d2gApp.controller('activationController', function ($stateParams, $http, authService) {
	var vm = this;
	var authSvc = authService;

	function _init () {
		var activationcode = {token: $stateParams.token};
        authSvc.activateUser(activationcode);
	}

	_init();
})