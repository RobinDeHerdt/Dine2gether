d2gApp.service('requestService', function ($http) {
	
	var svc = this;

	svc.addRequest = function (data) {
		$http.post('api/requestbooking', data);
	}

	svc.getRequests = function () {
		$http.get('api/requestbooking');
	}
});