d2gApp.directive("d2gLoginModal", function () {
	return {
		restrict: "E",
		templateUrl: "directives/header/login-modal.html",
		replace: true,
		scope: {},
		bindToController: true,
		controllerAs: "login",
		controller: function () {
			var vm = this;

			$rootScope.$watch(
			    function() { 
			        return $rootScope.showLogin; 
			    },
    			function(){
			        console.log($rootScope.showLogin);
			        console.log("changed");
    			},true);
		}
	}
});