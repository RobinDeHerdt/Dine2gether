d2gApp.service('requestService', function ($http) {
	
	var svc = this;

	svc.addRequest = function (data) {
		return $http.post('api/requestbooking', data);
	}

	svc.getUnacceptedRequests = function (id) {
		return $http.get('api/requestunacceptedbookings/'+ id);
	}
});