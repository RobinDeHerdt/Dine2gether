d2gApp.directive("d2gHeader", function () {
	return {
		restrict: "E",
		templateUrl: "directives/header/header.html",
		replace: true,
		scope: {},
		bindToController: true,
		controllerAs: "header",
		controller: function ($rootScope) {
			var vm = this;

			vm.Login = function () {
				$rootScope.showLogin = true;
			}
		}
	}
});