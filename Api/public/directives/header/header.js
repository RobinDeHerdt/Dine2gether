d2gApp.directive("d2gHeader", function () {
	return {
		restrict: "E",
		templateUrl: "directives/header/header.html",
		replace: true,
		scope: {},
		bindToController: true,
		controllerAs: "header",
		controller: function ($scope, loginService) {
			var vm = this;
			var loginSvc = loginService;

			$scope.$watch(loginSvc.getUser, function (user) {
				vm.user = user;
			})			

			vm.showLogin = function () {
				  loginSvc.showLoginModal();
			}
		}
	}
});