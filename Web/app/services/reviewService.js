d2gApp.service('reviewService', function ($http) {
	
	var svc = this;

	svc.postReview = function (data) {
		return $http.post(CONSTANTS.API_BASE_URL + '/review/store', data);
	};

	svc.getGuests = function () {
		return $http.get(CONSTANTS.API_BASE_URL + '/review/guests/' + id);
	};

	svc.getHosts = function () {
		return $http.get(CONSTANTS.API_BASE_URL + '/review/hosts/' + id);
	};

	svc.getReviewsByUser = function(id) {
		return $http.get(CONSTANTS.API_BASE_URL + '/user/' + id + '/reviews');
	};

	svc.deleteReviews = function(id) {
		return $http.delete(CONSTANTS.API_BASE_URL + '/review/' + id);
	}
});