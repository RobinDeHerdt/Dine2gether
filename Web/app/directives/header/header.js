d2gApp.directive("d2gHeader", function () {
	return {
		restrict: "E",
		templateUrl: "app/directives/header/header.html",
		replace: true,
		scope: {},
		bindToController: true,
		controllerAs: "header",
		controller: function ($scope, loginService, $auth, $cookies, $rootScope, $location) {
			var vm = this;
			var loginSvc = loginService;
			
			$scope.$watch(loginSvc.getUser, function (user) {
				vm.user = user;
			});			
			$rootScope.$on("$stateChangeSuccess", function(event, toState, toParams, fromState, 
				fromParams) {
    				if(toState.url == "/home") {
    					vm.navtext = {"color": "#fff"};
    					vm.navstyle = {'background-color': "transparent"};
    				} else {
    					vm.navtext = {"color": "#000"};
    					vm.navstyle = {'background-color': "#F9F9F9"};
    				}
  			});


			vm.showLogin = function () {
				  loginSvc.showLoginModal();
			}

			vm.showRegister = function () {
				loginSvc.showRegisterModal();
			}

			vm.logout = function () {
				$cookies.remove("user");
				loginSvc.user = null;
				$location.path("home");
			}

			vm.register = function () {
				loginSvc.register();
			}

			function _init() {
				
			}

			_init();

		}
	}
});