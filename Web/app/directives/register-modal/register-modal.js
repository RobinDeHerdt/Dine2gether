d2gApp.directive("d2gRegister", function (authService) {
    return {
        restrict: "E",
        templateUrl: "app/directives/register-modal/register-modal.html",
        replace: true,
        scope: {},
        bindToController: true,
        controllerAs: "register",
        controller: function (authService) {

            var vm = this;
            var authSvc = authService;

            vm.register = function () {
                var credentials = {
                    first_name: vm.first_name,
                    last_name: vm.last_name,
                    email: vm.email,
                    password: vm.password,
                    city: vm.city
                };

                authSvc.register(credentials);
            }
        }
    }
});