d2gApp.service('authService', function ($http, $auth, $cookies, $location) {
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
			//$cookies.putObject("token", data.data.token);
			svc.token = data.data.token;
			svc.setUser();
		}, function (error) {
			if(error.data.error = "invalid_credentials") {
				swal({
				  title: "Login Failed",
				  text: "You've entered the wrong emailaddress or password, please try again.",
				  type: "error",
				});
			} else {
				swal({
				  title: "Oops",
				  text: "Something went wrong. We couldn't get you logged in. Try again, or contact user if this problem keeps occuring",
				  type: "error",
				});
			}
		});
	};

    svc.logout = function () {
        $auth.logout()
            .then(function (data) {
                svc.user = null;
                $cookies.remove("user");
            }, function (error) {

                console.log(error);
            })
    };

	svc.setUser = function () {
		$http.get(CONSTANTS.API_BASE_URL + '/authenticate/user').then(function (user) {
			if(user.data.user.activated == 0) {
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
				    sendActivationMail(user.data.user);
				})
			} else {
				$cookies.putObject("user", user.data.user);
				svc.user = $cookies.getObject("user");
			}
		});
	};

	svc.getUser = function () {
		return svc.user;
	};

	svc.updateProfile = function (id, data) {
        console.log(data);
    	return $http.post(CONSTANTS.API_BASE_URL + '/updateprofile/' + id, data, {headers: {"Bearer" : svc.token}});
    };

	svc.register = function (o_newuser) {
		$http.post(CONSTANTS.API_BASE_URL + '/authenticate/register', o_newuser).success(function (data) {
			sendActivationMail(data)
			//svc.login({"email": o_newuser.email, "password": o_newuser.password});
		});
	};

	svc.activateUser = function (token) {
		$http.post(CONSTANTS.API_BASE_URL + '/user/activation', token).then(function (data) {
			if(data.data !== "") {
				console.log(data);
				$cookies.putObject("user", data.data);
				svc.user = $cookies.getObject("user");
				$location.path("home");
			} else {
				swal({
				  title: "Wrong activation link",
				  text: "Sorry, we couldn't find a user with this activation link",
				  type: "error",
				});
			}
		}, function (error) {
			console.log(data);
		})
	};

	function sendActivationMail (user) {
		$http.post(CONSTANTS.API_BASE_URL + '/sendactivationmail', user).then(function (data) {
			console.log(data);
			swal({
				  title: "Mail sent",
				  text: data.data.info,
				  type: "info",
				});
			console.log(data);
		}, function (error) {
			//alert met error
			console.log(error);
		});
	}
});