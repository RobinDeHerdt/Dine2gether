d2gApp.service('reviewService', function ($http) {
	
	var svc = this;

	svc.postReview = function (data) {
		return $http.post('api/createreview', data);
	}

	svc.getGuests = function (id) {
		return $http.get('api/review/guests/' + id);
	}

	svc.getHosts = function (id) {
		return $http.get('api/review/hosts/' + id);
	}

	svc.getReviewsByUser = function(id) {
		return $http.get('api/user/' + id + '/reviews');
	}
});