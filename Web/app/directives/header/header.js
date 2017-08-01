d2gApp.directive("d2gHeader", function () {
	return {
		restrict: "E",
		templateUrl: "app/directives/header/header.html",
		replace: true,
		scope: {},
		bindToController: true,
		controllerAs: "header",
		controller: function ($scope, authService, $auth, $cookies, $rootScope, $location) {
			var vm = this;
			var authSvc = authService;
			
			$scope.$watch(authSvc.getUser, function (user) {
				vm.user = user;
			});			
			$rootScope.$on("$stateChangeSuccess", function(event, toState, toParams, fromState, 
				fromParams) {
    				if(toState.url === "/home") {
    					vm.navtext = {"color": "#fff"};
    					vm.navstyle = {'background-color': "transparent"};
    				} else {
    					vm.navtext = {"color": "#000"};
    					vm.navstyle = {'background-color': "#F9F9F9"};
    				}
  			});

			vm.showLogin = function () {
                authSvc.showLoginModal();
			};

			vm.showRegister = function () {
                authSvc.showRegisterModal();
			};

			vm.logout = function () {
                authSvc.logout();
			};

			vm.register = function () {
                authSvc.register();
			};
		}
	}
});