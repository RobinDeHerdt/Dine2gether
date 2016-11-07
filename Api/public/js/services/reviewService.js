d2gApp.service('reviewService', function ($http) {
	
	var svc = this;

	svc.addReview = function (data) {
		return $http.post('api/', data);
	}

	svc.getBookings = function (id) {
		return $http.get('api/getUserBookingsFromPast/' + id);
	}
});