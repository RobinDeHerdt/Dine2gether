d2gApp.service('reviewService', function ($http) {
	
	var svc = this;

	svc.postReview = function (data) {
		return $http.post('api/createreview', data);
	}

	svc.getBookings = function (id) {
		return $http.get('api/getUserBookingsFromPast/' + id);
	}
});