d2gApp.directive("d2gLogin", function (loginService) {
	return {
		restrict: "E",
		templateUrl: "directives/login-modal/login-modal.html",
		replace: true,
		scope: {},
		bindToController: true,
		controllerAs: "login",
		controller: function () {
			var vm = this;
			var loginSvc = loginService;
			
			vm.email = "";
			vm.password = "";

			vm.login = function () {
				c
			}
			console.log("login modal controller");
		}
	}
});