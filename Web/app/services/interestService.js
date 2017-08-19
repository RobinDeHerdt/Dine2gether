d2gApp.service('interestService', function ($http) {
    var svc = this;

    svc.getInterests = function () {
        return $http.get(CONSTANTS.API_BASE_URL + '/interests');
    };

    svc.getAuthUserInterests = function () {
        return $http.get(CONSTANTS.API_BASE_URL + '/user/interests');
    };
});