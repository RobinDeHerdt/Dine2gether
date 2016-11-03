d2gApp.service('bookingService', function($http) {

	var svc = this;

	svc.getBookings = function () {
		return $http.get('/api/bookings');
	}
    
    svc.getBookingById = function (id) {
        return $http.get('api/bookingdetails/' + id);
    }

    svc.createBooking = function (data) {
    	return $http.post('api/createbooking', data, {withCredentials: true, headers: {'Content-Type': undefined }, 
            transformRequest: angular.identity});
    }

});