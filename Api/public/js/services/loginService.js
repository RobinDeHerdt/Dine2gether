d2gApp.service('loginService', function($http) {
	var svc = this;

	svc.showLoginModal = function () {
		$("#modal1").openModal();
	}

	svc.closeLoginModal = function () {
		$("#modal1").closeModal();
	}

	

});