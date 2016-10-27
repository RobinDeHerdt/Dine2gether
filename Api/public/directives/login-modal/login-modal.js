d2gApp.directive("d2gLogin", function (loginService) {
	return {
		restrict: "E",
		templateUrl: "directives/login-modal/login-modal.html",
		replace: true,
		scope: {},
		bindToController: true,
		controllerAs: "login",
		controller: function (loginService) {
			
			var vm = this;
			var loginSvc = loginService;

			vm.login = function () {
				var credentials = {
					email: vm.email,
					password: vm.password,
				}

			loginSvc.login(credentials);
			}
		}
	}
});