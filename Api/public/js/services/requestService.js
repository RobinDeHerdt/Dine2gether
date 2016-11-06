d2gApp.service('requestService', function ($http) {
	
	var svc = this;

	svc.addRequest = function (data) {
		return $http.post('api/requestbooking', data);
	}

	svc.getRequests = function () {
		return $http.get('api/requestbooking');
	}
});