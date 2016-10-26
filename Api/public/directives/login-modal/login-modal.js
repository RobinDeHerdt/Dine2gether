d2gApp.directive("d2gLogin", function (loginService) {
	return {
		restrict: "E",
		templateUrl: "directives/login-modal/login-modal.html",
		replace: true,
		scope: {},
		bindToController: true,
		controllerAs: "login",
		controller: function ($auth, $http, loginService) {
			
			var vm = this;
			var loginSvc = loginService;

			vm.login = function () {
				var credentials = {
					email: vm.email,
					password: vm.password,
				}

				$auth.login(credentials).then(function (data) {
					loginSvc.setUser();
				}, function (error) {
					if(error.data.error = "invalid_credentials") {
						alert("You've entered the wrong email or password. Please Try again.");
					} else {
						alert("Oops, something went wrong. We couldn't get you logged in");
					}
				});
			}
		}
	}
});