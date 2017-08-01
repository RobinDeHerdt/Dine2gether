d2gApp.service('requestService', function ($http) {
	
	var svc = this;

	svc.addRequest = function (data) {
		return $http.post(CONSTANTS.API_BASE_URL + '/requestbooking', data);
	};

	svc.acceptRequest = function (id) {
		return $http.get(CONSTANTS.API_BASE_URL + '/acceptrequest/'+ id );
	};

	svc.declineRequest = function (id) {
		return $http.get(CONSTANTS.API_BASE_URL + '/declinerequest/' + id);
	};

	svc.deleteRequest = function(id) {
		return $http.post(CONSTANTS.API_BASE_URL + '/request/delete', data);
	};

	svc.getRequest = function (data) {
		return $http.post(CONSTANTS.API_BASE_URL + '/request/get', data);
	}
});