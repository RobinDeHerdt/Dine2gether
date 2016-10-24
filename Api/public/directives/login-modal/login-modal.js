d2gApp.directive("d2gLogin", function (loginService) {
	return {
		restrict: "E",
		templateUrl: "directives/login-modal/login-modal.html",
		replace: true,
		scope: {},
		bindToController: true,
		controllerAs: "login",
		controller: function ($auth) {
			
			var vm = this;

			vm.login = function () {
				var credentials = {
					email: vm.email,
					password: vm.password,
				}

				$auth.login(credentials).then(function (data) {
					console.log(data.data.token);
				});
			}
		}
	}
});