d2gApp.service('loginService', function($http) {
	var svc = this;

	svc.showLoginModal = function () {
		$("#modal1").openModal();
	}

	svc.closeLoginModal = function () {
		$("#modal1").closeModal();
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

	

});