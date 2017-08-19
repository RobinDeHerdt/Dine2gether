d2gApp.service('requestService', function ($http) {

    var svc = this;

    svc.addRequest = function (data) {
        return $http.post(CONSTANTS.API_BASE_URL + '/request', data);
    };

    svc.handleRequest = function (bookingdate_id, data) {
        return $http.post(CONSTANTS.API_BASE_URL + '/bookingdate/' + bookingdate_id + '/request', data);
    };

    svc.cancelRequest = function (id) {
        return $http.post(CONSTANTS.API_BASE_URL + '/bookingdate/' + id + '/cancel');
    };

    svc.getRequest = function (data) {
        return $http.post(CONSTANTS.API_BASE_URL + '/request/get', data);
    }
});