d2gApp.service('authService', function ($http, $auth, $cookies, $state) {
    var svc = this;

    svc.user = $cookies.getObject("user");

    svc.showLoginModal = function () {
        $('#login-modal').modal();
        $("#login-modal").modal('open');
    };

    svc.closeLoginModal = function () {
        $('#login-modal').modal();
        $("#login-modal").modal('close');
    };

    svc.showRegisterModal = function () {
        $("#register-modal").modal();
        $("#register-modal").modal('open');

    };

    svc.closeRegisterModal = function () {
        $("#register-modal").modal();
        $("#register-modal").modal('close');
    };

    svc.login = function (credentials) {
        $auth.login(credentials).then(function (data) {
            svc.token = data.data.token;
            svc.setUser(true);
        }, function (error) {
            if (error.data.error = "invalid_credentials") {
                swal({
                    title: "Login Failed",
                    text: "You've entered the wrong emailaddress or password, please try again.",
                    type: "error"
                }).then(function () {
                    svc.showLoginModal();
                });

            } else {
                swal({
                    title: "Oops",
                    text: "Something went wrong. We couldn't get you logged in. Try again, or contact user if this problem keeps occuring",
                    type: "error"
                });
            }
        });
    };

    svc.logout = function () {
        $auth.logout()
            .then(function (data) {
                svc.user = null;
                $cookies.remove("user");
                $state.go('home');
            }, function (error) {
                console.log(error);
            });
    };

    svc.getUser = function () {
        return svc.user;
    };

    svc.setUser = function (checkIfActivated) {
        $http.get(CONSTANTS.API_BASE_URL + '/user').then(function (data) {
            if (checkIfActivated && data.data.user.activated === 0) {
                swal({
                    title: 'Activate your account',
                    text: "You haven't activated your account yet. Please check your mailbox.",
                    type: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#108610',
                    cancelButtonColor: '#9e9e9e',
                    confirmButtonText: 'Resend activation mail',
                    cancelButtonText: "Okay, I'll check"
                }).then(function () {
                    sendActivationMail();
                });
            }

            $cookies.putObject("user", data.data.user);
            svc.user = $cookies.getObject("user");

        });
    };

    svc.updateProfile = function (data) {
        return $http.post(CONSTANTS.API_BASE_URL + '/user/update', data);
    };

    svc.register = function (user) {
        $auth.signup(user).then(function (data) {
            $auth.setToken(data);

            swal({
                title: 'Welcome',
                text: "Welcome to the team! We've sent an activation mail to your mailbox.",
                type: 'success',
                confirmButtonColor: '#108610',
                confirmButtonText: 'Got it!'
            });

            svc.setUser(false);
        }).catch(function (data) {

            var html = "";

            for (var field in data.data) {
                html += "<ul>";

                for (var i = 0; i < data.data[field].length; i++) {
                    html += "<li>" + data.data[field][i] + "</li>"
                }

                html += "</ul>";
            }

            swal({
                title: "Please check the following errors:",
                html: html,
                type: "error"
            }).then(function () {
                svc.showRegisterModal();
            });
        });
    };

    function sendActivationMail() {
        $http.post(CONSTANTS.API_BASE_URL + '/user/activation/send').then(function (data) {
            swal({
                title: "Mail sent",
                text: "Click the activation link inside to activate your account",
                type: "info"
            });
        }, function (error) {
            console.log(error);
        });
    }
});