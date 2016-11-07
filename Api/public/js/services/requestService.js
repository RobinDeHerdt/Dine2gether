d2gApp.service('requestService', function ($http) {
	
	var svc = this;

	svc.addRequest = function (data) {
		return $http.post('api/requestbooking', data);
	}

});