app.directive("testDirective", function() {
	return {
		restrict: "E",
		templateUrl: "app/directives/testDirective/testDirective.html",
		replace: true,
		scope: {},
		controllerAs: "dir",
		controller: function() {
			var vm = this;

			function _init() {

				vm.value = "This is a directive test value!";
			}

			_init();
		}
	}
})