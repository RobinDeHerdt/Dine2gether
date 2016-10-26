d2gApp.service('interestService', function ($http) {
	var svc = this;

	svc.getInterests = function () {
		return $http.get('/api/interests');
	}
});