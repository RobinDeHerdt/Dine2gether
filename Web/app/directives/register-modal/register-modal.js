d2gApp.directive("d2gRegister", function (loginService) {
	return {
		restrict: "E",
		templateUrl: "app/directives/register-modal/register-modal.html",
		replace: true,
		scope: {},
		bindToController: true,
		controllerAs: "register",
		controller: function (loginService) {
			
			var vm = this;
			var loginSvc = loginService;

			vm.register = function () {
				var credentials = {
					first_name: vm.first_name,
					last_name: vm.last_name,
					email: vm.email,
					password: vm.password,
					city: vm.city
				}

			loginSvc.register(credentials);
			}
		}
	}
});