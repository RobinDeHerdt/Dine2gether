d2gApp.service('loginService', function ($http, $auth) {
	var svc = this;

	svc.showLoginModal = function () {
		$("#modal1").openModal();
	}
	svc.closeLoginModal = function () {
		$("#modal1").closeModal();
	}

	svc.showRegisterModal = function () {
		$("#modal2").openModal();
	}
	svc.closeRegisterModal = function () {
		$("#modal2").closeModal();
	}

	svc.login = function (credentials) {
		$auth.login(credentials).then(function (data) {
			svc.setUser();
		}, function (error) {
			if(error.data.error = "invalid_credentials") {
				alert("You've entered the wrong email or password. Please Try again.");
			} else {
				alert("Oops, something went wrong. We couldn't get you logged in");
			}
		});
	}

	svc.setUser = function () {
		$http.get('api/authenticate/user').then(function (user) {
			svc.user = user.data.user;
			console.log(svc.user);
		});
	}

	svc.getUser = function () {
		return svc.user;
	}

	svc.register = function (o_newuser) {
		$http.post('api/authenticate/register', o_newuser).success(function (data) {
			sendActivationMail(data)
			//svc.login({"email": o_newuser.email, "password": o_newuser.password});
		});
	}

	function sendActivationMail (user) {
		$http.post('sendactivationmail', user).then(function (data) {
			console.log(data);
		}, function (error) {
			console.log(error);
		});
	}



	

});