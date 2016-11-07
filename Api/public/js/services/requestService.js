d2gApp.service('requestService', function ($http) {
	
	var svc = this;

	svc.addRequest = function (data) {
		return $http.post('api/requestbooking', data);
	}

	svc.acceptRequest = function (id) {
		return $http.get('api/acceptrequest/'+ id );
	}

	svc.declineRequest = function (id) {
		return $http.get('api/declinerequest/' + id);
	}

});