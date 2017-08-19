d2gApp.service('kitchenstyleService', function ($http) {
    var svc = this;

    svc.getKitchenStyles = function () {
        return $http.get(CONSTANTS.API_BASE_URL + '/kitchenstyles');
    }
});