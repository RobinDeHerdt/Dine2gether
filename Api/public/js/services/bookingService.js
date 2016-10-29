d2gApp.service('bookingService', function($http) {

	var svc = this;

	svc.getBookings = function () {
		return $http.get('/api/bookings');
	}
    
    svc.getBookingById = function (id) {
        return $http.get('api/bookingdetails/' + id);
    }

});