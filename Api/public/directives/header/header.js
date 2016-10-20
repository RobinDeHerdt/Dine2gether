d2gApp.directive("d2gHeader", function () {
	return {
		restrict: "E",
		templateUrl: "directives/header/header.html",
		replace: true,
		scope: {},
		bindToController: true,
		controllerAs: "header",
		controller: function ($rootScope, loginService) {
			var vm = this;
			var loginSvc = loginService;

			vm.showLogin = function () {
				  loginSvc.showLoginModal();
			}
		}
	}
});