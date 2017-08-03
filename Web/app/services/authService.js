d2gApp.service('authService', function ($http, $auth, $cookies, $state) {
	var svc = this;

	svc.user = $cookies.getObject("user");

	svc.showLoginModal = function () {
		$("#modal1").openModal();
	};

	svc.closeLoginModal = function () {
		$("#modal1").closeModal();
	};

	svc.showRegisterModal = function () {
		$("#modal2").openModal();
	};

	svc.closeRegisterModal = function () {
		$("#modal2").closeModal();
	};

	svc.login = function (credentials) {
		$auth.login(credentials).then(function (data) {
			svc.token = data.data.token;
			svc.setUser();
		}, function (error) {
			if(error.data.error = "invalid_credentials") {
				swal({
				  title: "Login Failed",
				  text: "You've entered the wrong emailaddress or password, please try again.",
				  type: "error"
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

    svc.setUser = function(checkIfActivated) {
    	$http.get(CONSTANTS.API_BASE_URL + '/user').then(function (data) {
			if(checkIfActivated && data.data.user.activated === 0) {
				swal({
					title: 'Activate your account',
					text: "You haven't activated your account yet. Please check your mailbox.",
					type: 'error',
					showCancelButton: true,
					confirmButtonColor: '#108610',
					cancelButtonColor: '#9e9e9e',
					confirmButtonText: 'Resend activation mail',
					cancelButtonText: "Okay, I'll check"
				}).then(function() {
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
        $auth.signup(user).then(function(data) {
            $auth.setToken(data);

			swal({
				title: 'Welcome',
				text: "Welcome to the team! We've sent an activation mail to your mailbox.",
				type: 'success',
				confirmButtonColor: '#108610',
				confirmButtonText: 'Got it!'
			});

            svc.setUser(false);
		}).catch(function(data) {
			console.log(data);
		});
	};

    function sendActivationMail (user) {
        $http.post(CONSTANTS.API_BASE_URL + '/user/activation/send').then(function (data) {
            console.log(data);
            swal({
                title: "Mail sent",
                text: data.data.info,
                type: "info"
            });
        }, function (error) {
            console.log(error);
        });
    };
});