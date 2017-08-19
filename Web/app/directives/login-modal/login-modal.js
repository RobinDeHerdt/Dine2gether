d2gApp.directive("d2gLogin", function (authService) {
	return {
		restrict: "E",
		templateUrl: "app/directives/login-modal/login-modal.html",
		replace: true,
		scope: {},
		bindToController: true,
		controllerAs: "login",
		controller: function (authService) {
			
			var vm = this;
			var authSvc = authService;

			vm.login = function () {
				$('#login-modal').modal('close');
				var credentials = {
					email: vm.email,
					password: vm.password
				};

                authSvc.login(credentials);
			}
		}
	}
});